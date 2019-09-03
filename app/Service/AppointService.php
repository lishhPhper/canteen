<?php
namespace App\Service;

use App\Models\AppointLog;
use App\Models\EatLog;
use App\Traits\Appoint;
use App\Traits\Setting;
use Illuminate\Support\Facades\DB;

class AppointService extends Service
{
    use Setting,Appoint;
    public function getReservationInfo()
    {
        $reservation_time = $this->getReservationTime();
        $lunch_num = $this->getReservationNum(1);
        $night_num = $this->getReservationNum(2);
        $max_num = Setting::getParam(['max_reservation_num']);
        $reservation_time['lunch_max_status'] = $max_num['max_reservation_num'] > $lunch_num ? 0 : 1;
        $reservation_time['night_max_status'] = $max_num['max_reservation_num'] > $night_num ? 0 : 1;
        return $reservation_time;
    }

    public function setAppiont($user_id, $type)
    {
        if(!in_array($type,[1,2])){
            return self::resultSet(0,'请选择预约类型');
        }
        // 违约查询
        $default_num = $this->getDefaultNum($user_id);
        if($default_num >= config('canteen.default_max_num')){
            return self::resultSet(0,"违约{$default_num}次,已无预约权限");
        }
        // 现在属于哪个预约类型
        $reservation_type = $this->getReservationType();
//        dd($reservation_type);
        if($reservation_type != $type){
            return self::resultSet(0,'不在预约时间范围内');
        }
        // 是否已预约（包括特殊预约）
        $nomal_reserved = $this->reserved($user_id, $reservation_type,1);
        if($nomal_reserved > 0){
            return self::resultSet(0,'您已预约');
        }
        $special_reserved = $this->reserved($user_id, $reservation_type,2);
        if($special_reserved > 0){
            return self::resultSet(0,'特殊预约审核中');
        }
        // 已预约人数查询
        $max_num = Setting::getParam(['max_reservation_num']);
        $reservation_num = $this->getReservationNum($reservation_type);
        if($reservation_num >= $max_num['max_reservation_num']){
            return self::resultSet(0,'预约人数已满');
        }

        $date = date('Y-m-d',strtotime("+1 day"));
        $normal_cancel = AppointLog::where('user_id',$user_id)
            ->where('appoint_date',$date)
            ->where('eat_type',$reservation_type)
            ->where('status',0)
            ->where('appoint_type',1)
            ->first();
        try{
            DB::beginTransaction();
            $AppointLog = new AppointLog();
            if(!$normal_cancel){
                // 保存预约记录
                $AppointLog->user_id = $user_id;
                $AppointLog->appoint_date = date('Y-m-d',strtotime("+1 day"));
                $AppointLog->eat_type = $reservation_type;
                $AppointLog->appoint_type = 1;
                $AppointLog->status = 1;
                $AppointLog->save();

                // 提前生成就餐记录
                $EatLog = new EatLog();
                $EatLog->user_id = $user_id;
                $EatLog->appoint_id = $AppointLog->id;
                $EatLog->appoint_date = date('Y-m-d',strtotime("+1 day"));
                $EatLog->eat_type = $reservation_type;
                $EatLog->appoint_type = 1;
                $EatLog->save();
                $appoint_id = $AppointLog->id;
            }else{
                $appoint_id = $normal_cancel->id;
                AppointLog::where('id',$appoint_id)
                    ->update(['status' => 1]);
                EatLog::where('appoint_id',$appoint_id)
                    ->update(['status' => 1]);
            }

            DB::commit();
            $data = $this->getReservationSuccess($reservation_type);
            $data['appoint_id'] = $appoint_id;
            // 返回就餐时间段、最晚取消预约时间
            return self::resultSet(1,'预约成功',$data);
        }catch (\Exception $e){
            DB::rollBack();
            return self::resultSet(0,'预约失败');
        }

    }

    public function timeTable()
    {
        $keys  = ['dining_lot','first_lunch_time','first_night_time','eat_interval'];
        $configs = Setting::getParam($keys);
        $lot = $configs['dining_lot'] * $configs['eat_interval'] * 60;
        $last_lunch_end_time = date("H:i:s",strtotime($configs['first_lunch_time']) + $lot);
        $last_night_end_time = date("H:i:s",strtotime($configs['first_night_time']) + $lot);
        $time_table = [];
        for ($i = $configs['first_lunch_time']; $i < $last_lunch_end_time; $i = date("H:i:s",strtotime($i) + $configs['eat_interval'] * 60)){
            $new_end_time = date("H:i",strtotime($i) + $configs['eat_interval'] * 60);
            $time_table[] = substr($i,0,5) . '-' . $new_end_time;
        }
        for ($i = $configs['first_night_time']; $i < $last_night_end_time; $i = date("H:i:s",strtotime($i) + $configs['eat_interval'] * 60)){
            $new_end_time = date("H:i",strtotime($i) + $configs['eat_interval'] * 60);
            $time_table[] = substr($i,0,5) . '-' . $new_end_time;
        }
        return $time_table;
    }

    public function arraignmentSpecial($user_id, $params)
    {
        if(!isset($params['day']) || !in_array($params['day'],[0,1,2])){
            return self::resultSet(0,'请选择日期');
        }
        $appoint_date = date('Y-m-d',strtotime("+{$params['day']} day"));
        if(empty($params['section'])){
            return self::resultSet(0,'请选择时间');
        }
        $section_time = explode('-',$params['section']);
        $start_time = $section_time[0];
        $end_time = $section_time[1];
        $time = date('H:i:s');
        if($params['day'] == 0 && $time >= $end_time){
            return self::resultSet(0,'请选择正确的就餐时间');
        }
        // 获取就餐类型
        $keys = ['first_lunch_time','first_night_time','eat_interval','dining_lot','special_eat'];
        $configs = Setting::getParam($keys);
        $lot = $configs['dining_lot'] * $configs['eat_interval'] * 60;
        $last_lunch_end_time = date("H:i:s",strtotime($configs['first_lunch_time']) + $lot);
        $eat_type = 2;
        if($end_time <= $last_lunch_end_time){
            $eat_type = 1;
        }
        if(empty($params['desc'])){
            return self::resultSet(0,'请填写备注');
        }
        // 已有这天这餐的特殊预约
        $special_count = AppointLog::where('user_id',$user_id)
            ->where('appoint_date',$appoint_date)
            ->where('eat_type',$eat_type)
            ->where('appoint_type',2)
            ->where('status',1)
            ->count();
        if($special_count > 0){
            return self::resultSet(0,'已提交过审核');
        }
        // 普通预约是否存在
        $normal_count = AppointLog::where('user_id',$user_id)
            ->where('appoint_date',$appoint_date)
            ->where('eat_type',$eat_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->count();
        try{
            DB::beginTransaction();
            // 保存特殊预约记录
            $AppointLog = new AppointLog();
            $AppointLog->user_id = $user_id;
            $AppointLog->appoint_date = $appoint_date;
            $AppointLog->eat_type = $eat_type;
            $AppointLog->start_time = $start_time;
            $AppointLog->end_time = $end_time;
            $AppointLog->appoint_type = 2;
            $AppointLog->desc = $params['desc'];
            $AppointLog->verify_status = $configs['special_eat'] ? 1 : 0;
            $AppointLog->save();

            // 如有普通预约则不作违约处理并取消
            if($normal_count > 0){
                AppointLog::where('user_id',$user_id)
                    ->where('appoint_date',$appoint_date)
                    ->where('eat_type',$eat_type)
                    ->where('appoint_type',1)
                    ->where('status',1)
                    ->update(['status' => 0]);

                EatLog::where('user_id',$user_id)
                    ->where('appoint_date',$appoint_date)
                    ->where('eat_type',$eat_type)
                    ->where('appoint_type',1)
                    ->update(['status' => 0]);
            }

            // 特殊审核自动审核
            if($configs['special_eat']){
                $EatLog = new EatLog();
                $EatLog->user_id = $user_id;
                $EatLog->appoint_id = $AppointLog->id;
                $EatLog->appoint_date = $appoint_date;
                $EatLog->eat_type = $eat_type;
                $EatLog->start_time = $start_time;
                $EatLog->end_time = $end_time;
                $EatLog->appoint_type = 2;
                $EatLog->save();

            }
            DB::commit();
            return self::resultSet(1,'成功提交预约，等待审核');
        }catch (\Exception $e){
            DB::rollBack();
            return self::resultSet(0,'提交审核失败');
        }
    }

    public function getMyReservation($user_id, $type)
    {
        $date = date('Y-m-d');
        $next_date = date('Y-m-d',strtotime("+2 day"));
        $list = AppointLog::where('user_id',$user_id)
            ->whereBetween('appoint_date', [$date, $next_date])
            ->where(function ($query) use ($type){
                if($type == 1){
                    $query->where('status',1)
                        ->where(function ($que){
                            $que->where('appoint_type',1)
                                ->orWhere(function ($q){
                                    $q->where('appoint_type',2)
                                        ->where('verify_status',1);
                                });
                        });
                }elseif ($type == 2){
                    $query->where('appoint_type',2)
                        ->where('verify_status',0);
                }else{
                    $query->where('status',0);
                }
            })
            ->orderBy('appoint_date','desc')
            ->get();
        $result = [];
        foreach ($list as $item) {
            if($type == 1){
                $status_text = '预约成功';
            }elseif ($type == 2){
                $status_text = '待审核';
            }else{
                $status_text = '已取消';
                if($item['verify_status'] == 2){
                    $status_text = '未通过';
                }
            }
            $result[] = [
                'id' => $item['id'],
                'canteen_name' => config('canteen.canteen_name'),
                'appoint_date' => $item['appoint_date'],
                'eat_type' => $item['eat_type'],
                'start_time' => $this->timeFormat($item['start_time']),
                'end_time' => $this->timeFormat($item['end_time']),
                'desc' => $item['desc'],
                'status_text' => $status_text,
                'appoint_type' => $item['appoint_type'],
            ];
        }
        return $result;
    }

    public function getReservationDetail($id, $type)
    {
        $detail = AppointLog::with('user')
        ->findOrFail($id);
        $result['id'] = $detail->id;
        $result['canteen_name'] = config('canteen.canteen_name');
        $result['appoint_date'] = $detail['appoint_date'];
        $result['eat_type'] = $detail['eat_type'];
        $result['appoint_type'] = $detail['appoint_type'];
        $result['start_time'] = $this->timeFormat($detail['start_time']);
        $result['end_time'] = $this->timeFormat($detail['end_time']);
        $result['name'] = $detail->user->name;
        $result['department'] = $detail->user->department;
        if($type == 1){
            $status_text = '预约成功';
        }elseif ($type == 2){
            $status_text = '审核中';
        }else{
            $status_text = '已取消';
            if($detail['verify_status'] == 2){
                $status_text = '未通过';
            }
        }
        $result['status_text'] = $status_text;
        return $result;
    }

    public function cancelReservation($id)
    {
        $detail = AppointLog::findOrFail($id);
        $next_date = date('Y-m-d',strtotime("+1 day"));
        if($detail->appoint_type == 2 || $detail->appoint_date != $next_date){
            return self::resultSet(0,'取消失败');
        }
        $keys = ['lunch_reservation_start_time','lunch_reservation_end_time','night_reservation_start_time','night_reservation_end_time'];
        $configs = Setting::getParam($keys);
        $time = date("H:i:s");
        if($detail->eat_type == 1){
            if($time < $configs['lunch_reservation_start_time'] || $time > $configs['lunch_reservation_end_time']){
                return self::resultSet(0,'取消失败,不在预约时间内');
            }
        }else{
            if($time < $configs['night_reservation_start_time'] || $time > $configs['night_reservation_end_time']){
                return self::resultSet(0,'取消失败,不在预约时间内');
            }
        }
        try{
            DB::beginTransaction();
            $detail->status = 0;
            $detail->save();

            // 移除违约
            EatLog::where('appoint_id',$id)
                ->update(['status' => 0]);

            DB::commit();
            return self::resultSet(1,'取消成功');
        }catch (\Exception $exception){
            DB::rollBack();
            return self::resultSet(0,'取消失败');
        }
    }

    public function refreshReservation($id)
    {
        $detail = AppointLog::findOrFail($id);
        $next_date = date('Y-m-d',strtotime("+1 day"));
        if($detail->appoint_type == 2 || $detail->appoint_date != $next_date){
            return self::resultSet(0,'重新预约失败');
        }
        $keys = ['lunch_reservation_start_time','lunch_reservation_end_time','night_reservation_start_time','night_reservation_end_time'];
        $configs = Setting::getParam($keys);
        $time = date("H:i:s");
        if($detail->eat_type == 1){
            if($time < $configs['lunch_reservation_start_time'] || $time > $configs['lunch_reservation_end_time']){
                return self::resultSet(0,'重新预约失败,不在预约时间内');
            }
        }else{
            if($time < $configs['night_reservation_start_time'] || $time > $configs['night_reservation_end_time']){
                return self::resultSet(0,'重新预约失败,不在预约时间内');
            }
        }
        try{
            DB::beginTransaction();
            $detail->status = 1;
            $detail->save();
            // 恢复违约判定
            EatLog::where('appoint_id',$id)
                ->update(['status' => 1]);
            DB::commit();
            return self::resultSet(1,'重新预约成功');
        }catch (\Exception $exception){
            DB::rollBack();
            return self::resultSet(0,'重新预约失败');
        }
    }

    public function getVerifyList($page = 1, $pagesize = 15)
    {
        $date = date('Y-m-d');
        $next_date = date('Y-m-d',strtotime("+2 day"));
        $offset = ($page - 1) * $pagesize;
        $total = AppointLog::where('appoint_type',2)
            ->whereBetween('appoint_date', [$date, $next_date])
            ->where('verify_status',0)
            ->where('status',1)
            ->count();
        $list = AppointLog::select('id','appoint_date','start_time','end_time','desc','user_id')
            ->with([
            'user' => function ($query){
                $query->select('id','name','phone');
            }])
            ->where('appoint_type',2)
            ->whereBetween('appoint_date', [$date, $next_date])
            ->where('verify_status',0)
            ->where('status',1)
            ->offset($offset)
            ->limit($pagesize)
            ->orderBy('appoint_date','asc')
            ->get()->toArray();
        $per_page = ceil($total / $pagesize);
        foreach($list as &$item){
            $item['start_time'] = $this->timeFormat($item['start_time']);
            $item['end_time'] = $this->timeFormat($item['end_time']);
        }
        return [
            'list' => $list,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'per_page' => $per_page
        ];
    }

    public function setVerifyStatus($params)
    {
        if (!isset($params['type']) || !in_array($params['type'],[1,2])) {
            return self::resultSet(0,'审核失败');
        }
        if (empty($params['appoint_ids'])) {
            return self::resultSet(0,'请选择审核的记录');
        }
        // 可通过或可拒绝的ID
        $appoint_ids = AppointLog::where('appoint_type',2)
            ->where('verify_status',0)
            ->whereIn('id',$params['appoint_ids'])
            ->pluck('id');
        if (empty($appoint_ids)) {
            return self::resultSet(0,'请选择审核的记录');
        }

        try{
            DB::beginTransaction();

            AppointLog::whereIn('id',$appoint_ids)
                ->update(['verify_status' => $params['type']]);
            // 通过则提前建立就餐记录
            if($params['type'] == 1){
                // 查预约记录信息
                $appoint_detail_list = AppointLog::whereIn('id',$appoint_ids)
                    ->get()->toArray();
                $datetime = date('Y-m-d H:i:s');
                $save_list = [];
                foreach ($appoint_detail_list as $item){
                    $save_list[] = [
                        'user_id' => $item['user_id'],
                        'appoint_id' => $item['id'],
                        'appoint_date' => $item['appoint_date'],
                        'eat_type' => $item['eat_type'],
                        'start_time' => $item['start_time'],
                        'end_time' => $item['end_time'],
                        'appoint_type' => 2,
                        'created_at' => $datetime,
                        'updated_at' => $datetime,
                    ];
                }
                DB::table('eat_logs')->insert($save_list);
            }

            DB::commit();
            return self::resultSet(1,'审核成功');
        }catch (\Exception $exception){
            DB::rollBack();
            return self::resultSet(0,'审核失败');
        }
    }

    public function getVerifyResult($page = 1, $pagesize = 15)
    {
        $date = date('Y-m-d');
        $next_date = date('Y-m-d',strtotime("+2 day"));
        $offset = ($page - 1) * $pagesize;
        $total = AppointLog::where('appoint_type',2)
            ->whereBetween('appoint_date', [$date, $next_date])
            ->where('verify_status','>',0)
            ->where('status',1)
            ->count();
        $list = AppointLog::select('id','appoint_date','start_time','end_time','desc','user_id','verify_status',DB::Raw("unix_timestamp(appoint_date) as appoint_time"))
            ->with([
                'user' => function ($query){
                    $query->select('id','name','phone');
                }])
            ->where('appoint_type',2)
            ->whereBetween('appoint_date', [$date, $next_date])
            ->where('verify_status','>',0)
            ->where('status',1)
            ->orderBy('updated_at','desc')
            ->offset($offset)
            ->limit($pagesize)
            ->get()->toArray();
        $per_page = ceil($total / $pagesize);
        foreach($list as &$item){
            $item['start_time'] = $this->timeFormat($item['start_time']);
            $item['end_time'] = $this->timeFormat($item['end_time']);
        }
        return [
            'list' => $list,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'per_page' => $per_page
        ];
    }

    public function getNormalTotal($eat_type, $page, $pagesize)
    {
        $date = date('Y-m-d',strtotime("+1 day"));
        $offset = ($page - 1) * $pagesize;
        $total = AppointLog::where('appoint_type',1)
            ->where('appoint_date', $date)
            ->where('eat_type', $eat_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->count();
        $list = AppointLog::select('id','appoint_date','user_id')
            ->with([
                'user' => function ($query){
                    $query->select('id','name','phone');
                }])
            ->where('appoint_date', $date)
            ->where('eat_type', $eat_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->orderBy('id','desc')
            ->offset($offset)
            ->limit($pagesize)
            ->get()->toArray();
        $per_page = ceil($total / $pagesize);
        foreach ($list as &$item){
            $item['desc'] = $eat_type == 1 ? '午餐' : '晚餐';
        }
        return [
            'list' => $list,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'per_page' => $per_page
        ];
    }
}

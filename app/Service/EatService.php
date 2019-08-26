<?php
namespace App\Service;

use App\Models\EatLog;
use App\Models\EvaluationLog;
use App\Traits\Setting;
use Illuminate\Support\Facades\DB;

class EatService extends Service
{
    use Setting;
    public function getDinnerLog($user_id, $page, $pagesize)
    {
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $offset = ($page - 1) * $pagesize;
        $today_list = [];
        if($page == 1){
            $today_list = EatLog::with('appoint')
                ->where('user_id',$user_id)
                ->where('appoint_date',$date)
                ->where('end_time','<',$time)
                ->where('default',1)
                ->where('status',1)
                ->get()->toArray();
        }
        $before_total = EatLog::where('user_id',$user_id)
            ->where('appoint_date','<',$date)
            ->where('status',1)
            ->count();
        $before_list = EatLog::with('appoint')
            ->where('user_id',$user_id)
            ->where('appoint_date','<',$date)
            ->where('status',1)
            ->offset($offset)
            ->limit($pagesize)
            ->get()->toArray();
        $per_page = ceil($before_total / $pagesize);
        $list = $page == 1 ? array_merge($today_list,$before_list) : $before_list;
        $result = [];
        foreach ($list as $item){
            // 不用看是否违约，违约是做限制
            // 普通预约
            if($item['appoint_type'] == 1){
                if(!$item['is_click']){
                    $status = 1;
                    $status_text = '未到食堂就餐';
                }elseif (!$item['is_face'] && $item['is_click'] == 1){
                    $status = 2;
                    $status_text = '未刷脸就餐';
                }else{
                    $status = 3;
                    $status_text = '已完成';
                }
            }
            // 特殊预约
            if($item['appoint_type'] == 2){
                if(!$item['is_face']){
                    $status = 2;
                    $status_text = '未刷脸就餐';
                }else{
                    $status = 3;
                    $status_text = '已完成';
                }
            }
            $result[] = [
                'id' => $item['id'],
                'eat_type' => $item['eat_type'],
                'appoint_type' => $item['appoint_type'],
                'appoint_date' => $item['appoint_date'],
                'start_time' => $this->timeFormat($item['start_time']),
                'end_time' => $this->timeFormat($item['end_time']),
                'status' => $status,
                'status_text' => $status_text,
                'desc' => $item['appoint']['desc'],
                'evaluation_id' => $item['evaluation_id'],
            ];
        }
        return [
            'list' => $result,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $page == 1 && $before_total == 0 ? count($today_list) : $before_total,
            'per_page' => $page == 1 && $before_total == 0 ? 1 : $per_page
        ];
    }

    public function setDinnerEvaluation($user_id, $params)
    {
        if(empty($params['id']) || $params['id'] < 1){
            return self::resultSet(0,'评价失败');
        }
        if(!isset($params['point']) || !is_numeric($params['point']) || $params['point'] < 1 || $params['point'] > 5){
            return self::resultSet(0,'请填写评分');
        }
        $evaluation = empty($params['evaluation']) ? '' : $params['evaluation'];
        $eat_detail = EatLog::findOrFail($params['id']);
        // 已评论
        if($eat_detail['evaluation_id'] > 0){
            return self::resultSet(1,'评论成功');
        }
        // 不能评论(违约)
        if($eat_detail['appoint_type'] == 1){
            if(!$eat_detail['is_click'] || !$eat_detail['is_face']){
                return self::resultSet(0,'不能发表评论');
            }
        }
        // 特殊预约
        if($eat_detail['appoint_type'] == 2){
            if(!$eat_detail['is_face']){
                return self::resultSet(0,'不能发表评论');
            }
        }
        try{
            DB::beginTransaction();
            $EvaluationLog = new EvaluationLog();
            $EvaluationLog->appoint_id = $eat_detail->appoint_id;
            $EvaluationLog->eat_id = $eat_detail->id;
            $EvaluationLog->user_id = $user_id;
            $EvaluationLog->point = $params['point'];
            $EvaluationLog->evaluation = $evaluation;
            $EvaluationLog->save();

            $eat_detail->evaluation_id = $EvaluationLog->id;
            $eat_detail->save();
            DB::commit();
            return self::resultSet(1,'评论成功');
        }catch (\Exception $exception){
            DB::rollBack();
            return self::resultSet(0,'评论失败');
        }
    }

    public function getEvaluationLog($user_id, $page = 1, $pagesize = 15)
    {
        $offset = ($page - 1) * $pagesize;
        $total = EvaluationLog::where('user_id',$user_id)
            ->count();
        $list = EvaluationLog::select('id','point','evaluation','created_at',DB::Raw("unix_timestamp(created_at) as create_time"))
            ->with(['eat' => function ($query){
                $query->select('id','appoint_date','eat_type','start_time','end_time','appoint_type','evaluation_id',DB::Raw("unix_timestamp(appoint_date) as appoint_time"));
            }])
            ->where('user_id',$user_id)
            ->offset($offset)
            ->limit($pagesize)
            ->orderBy('created_at','desc')
            ->get();
        foreach ($list as &$item){
            $item['eat']['start_time'] = $this->timeFormat($item['eat']['start_time']);
            $item['eat']['end_time'] = $this->timeFormat($item['eat']['end_time']);
        }
        $per_page = ceil($total / $pagesize);
        return [
            'list' => $list,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'per_page' => $per_page
        ];
    }

    public function getAdminEvaluationLog($page = 1, $pagesize = 15)
    {
        $offset = ($page - 1) * $pagesize;
        $total = EvaluationLog::count();
        $list = EvaluationLog::select('id','point','evaluation','created_at','user_id',DB::Raw("unix_timestamp(created_at) as create_time"))
            ->with([
                'eat' => function ($query){
                    $query->select('id','appoint_date','eat_type','start_time','end_time','appoint_type','evaluation_id',DB::Raw("unix_timestamp(appoint_date) as appoint_time"));
            },
                'user' => function ($query){
                    $query->select('id','name','avatar');
                }
                ])
            ->offset($offset)
            ->limit($pagesize)
            ->orderBy('created_at','desc')
            ->get();
        $per_page = ceil($total / $pagesize);
        return [
            'list' => $list,
            'curr_page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'per_page' => $per_page
        ];
    }
}

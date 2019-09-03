<?php

namespace App\Console;

use App\Models\EatLog;
use App\Traits\Setting;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $today_start = date('Y-m-d 00:00:00', time());
            $today_end = date('Y-m-d 23:59:59', time());
            // 找到现在处于哪餐范围
            $keys  =['first_lunch_time', 'first_night_time', 'eat_interval', 'dining_lot'];
            $congifs = Setting::getParam($keys);
            $lot = $congifs['dining_lot'] * $congifs['eat_interval'] * 60;
            $lunch_end_time = date("Y-m-d H:i:s",strtotime($congifs['first_lunch_time']) + $lot);
            $night_end_time = date("Y-m-d H:i:s",strtotime($congifs['first_night_time']) + $lot);
            $eat_type = 2;
            $between_time = [$lunch_end_time, $night_end_time];
            if($time < $lunch_end_time){
                $eat_type = 1;
                $between_time = [$today_start, $lunch_end_time];;
            }
            // 获取今天最新拉取记录
            $last_record_id = DB::table('face_update_log')->where('update_date',$date)->value('last_record_id');
            // 今天所有刷脸记录
            $face_data = DB::connection('faceDB')
                ->table('facerecord')
                ->where(function ($query) use ($last_record_id){
                    if(!empty($last_record_id)){
                        $query->where('id','>',$last_record_id);
                    }
                })
                ->where('EmployNO','>',0)
                ->whereBetween('DateTimeRecord',$between_time)
                ->where('InOrOut','进门')
                ->get();
            if(!empty($face_data)){
                $user_employ_ids = User::where('employ_id','>',0)
                    ->pluck('id','employ_id');
                // 整理数据(保留一份)
                $insert_data = [];
                // 用户的进闸时间
                $user_in_data = [];
                $datetime = date('Y-m-d H:i:s');
                $next_last_record_id = 0;
                foreach ($face_data as $item){
                    if($item['id'] > $next_last_record_id){
                        $next_last_record_id = $item['id'];
                    }
                    $record_id = $item->ID;
                    unset($item->ID);
                    $insert_tmp = $item;
                    $insert_tmp->record_id = $record_id;
                    $insert_tmp->created_at = $datetime;
                    $insert_tmp->updated_at = $datetime;
                    $insert_tmp = collect($insert_tmp)->toArray();
                    $insert_data[] = $insert_tmp;
                    if(isset($user_employ_ids[$item->EmployNO])){
                        $user_in_data[$user_employ_ids[$item->EmployNO]]['id'] = $user_employ_ids[$item->EmployNO];
                        $user_in_data[$user_employ_ids[$item->EmployNO]]['face_time'] = $item->DateTimeRecord;
                    }
                }
                DB::table('face_record')->insert($insert_data);
                // 保存最新拉取记录
                if(!empty($last_record_id)){
                    DB::table('face_update_log')->where('update_date',$date)->update([
                        'last_record_id' => $next_last_record_id,
                        'last_record_time' => $datetime
                    ]);
                }else{
                    DB::table('face_update_log')->where('update_date',$date)->update([
                        'last_record_id' => $next_last_record_id,
                        'last_record_time' => $datetime,
                        'update_date' => $date,
                        'created_at' => $datetime,
                        'updated_at' => $datetime,
                    ]);
                }
                // 已结束的就餐记录(没有点就餐全部做违约)
                $eat_logs = EatLog::where('appoint_date',$date)
                    ->where('eat_type',$eat_type)
                    ->where('end_time','<',$time)
                    ->where('default',1)
                    ->where('status',1)
                    ->where(function ($query){
                        $query->where('appoint_type',2)
                            ->orWhere(function ($query){
                                $query->where('appoint_type',1)
                                    ->where('is_click',1);
                            });
                    })
                    ->get()->toArray();
                $user_eat_logs = array_column($eat_logs,null,'user_id');
                $update_eat_ids = [];
                foreach ($user_eat_logs as $user_id => $item){
                    if(!empty($user_in_data[$user_id]['face_time'])){
                        $face_time = date('H:i:s',strtotime($user_in_data[$user_id]['face_time']));
                        if($face_time >= $item['start_time'] && $face_time <= $item['end_time']){
                            $update_eat_ids[] = $item['id'];
                        }
                    }
                }
                // 修改就餐记录刷脸记录
                EatLog::whereIn('id',$update_eat_ids)->update(['is_face' => 1]);
            }
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

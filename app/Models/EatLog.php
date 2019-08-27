<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EatLog extends Model
{
    use \App\Traits\Setting;
    public function appoint()
    {
        return $this->belongsTo(AppointLog::class,'appoint_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function paginate()
    {
        $perPage = Request::get('per_page', 10);

        $page = Request::get('page', 1);

        $start = ($page-1)*$perPage;
        $date = date('Y-m-d');
        $month_start = date("Y-m-01", time());
        $month_end =  date('Y-m-t', time());
        $result_before = DB::table('eat_logs')
            ->select('eat_logs.id','eat_logs.appoint_date','eat_logs.appoint_type','eat_logs.is_click','eat_logs.is_face','users.name','users.phone','users.department')
            ->join('users','eat_logs.user_id', '=', 'users.id')
            ->whereBetween('appoint_date', [$month_start, $month_end])
            ->where('appoint_date','<',$date)
            ->where('default',1)
            ->where('status',1)
            ->where(function ($query) {
                $query->where(function ($que){
                    $que->where('appoint_type', 1)
                        ->where(function ($q) {
                            $q->where('is_face', 0)
                                ->orWhere('is_click', 0);
                        });
                })
                    ->orWhere(function ($query){
                        $query->where('appoint_type',2)
                            ->where('is_face',0);
                    });
            })->get()->toArray();
        $now_data = DB::table('eat_logs')
            ->select('eat_logs.id','eat_logs.appoint_date','eat_logs.appoint_type','eat_logs.is_click','eat_logs.is_face','eat_logs.eat_type','users.name','users.phone','users.department')
            ->join('users','eat_logs.user_id', '=', 'users.id')
            ->where('appoint_date',$date)
            ->where('default',1)
            ->where('status',1)
            ->where(function ($query) {
                $query->where(function ($que){
                    $que->where('appoint_type', 1)
                        ->where(function ($q) {
                            $q->where('is_face', 0)
                                ->orWhere('is_click', 0);
                        });
                })
                    ->orWhere(function ($query){
                        $query->where('appoint_type',2)
                            ->where('is_face',0);
                    });
            })->get()->toArray();
        $now_num = 0;
        if(!empty($now_data)){
            // 最大预约人，批次
            $keys  = ['max_reservation_num','dining_lot','first_lunch_time','first_night_time','eat_interval'];
            $configs = \App\Traits\Setting::getParam($keys);
            $time = date('H:i:s');
            $lot = $configs['dining_lot'] * $configs['eat_interval'] * 60;
            $last_lunch_end_time = date("H:i:s",strtotime($configs['first_lunch_time']) + $lot);
            $last_night_end_time = date("H:i:s",strtotime($configs['first_night_time']) + $lot);
            foreach ($now_data as $key => $item){
                // 午餐
                if($item->eat_type == 1 && $time > $last_lunch_end_time){
                    $now_num += 1;
                }elseif($item->eat_type == 2 && $time > $last_night_end_time){
                    $now_num += 1;
                }else{
                    unset($now_data[$key]);
                }
            }
        }
        $total = count($result_before) + $now_num;
        $result = array_merge($now_data,$result_before);

        $movies = static::hydrate($result);

        $paginator = new LengthAwarePaginator($movies, $total, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }
}

<?php
namespace App\Service;

use App\Models\ServerFood;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ServerFoodService extends Service
{
    public static function saveServerFood($params)
    {
        $validate = Validator::make($params, ServerFood::storerule(), ServerFood::storeMsg());
        if ($validate->fails()) {
            throw new ServiceException($validate->errors()->first());
        }
        foreach ($params['food_id'] as $food_id){
            if(!empty($food_id)){
                $saveData[] = [
                    'server_time' => $params['server_time'],
                    'food_id' => $food_id,
                    'food_num' => $params['food_num'],
                    'server_type' => $params['server_type'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }
        try{
            ServerFood::insert($saveData);
            return self::MessageBagMsg(true,'操作成功');
        }catch (\Exception $e){
            return self::MessageBagMsg(false,'操作失败');
        }
    }

    public static function updateServerFood($params)
    {
        try{
            DB::beginTransaction();
            $ServerFoodModel = new ServerFood();
            $ServerFoodModel->whereIn('id',explode(',',$params['ids']))->delete();

            $params['food_id'] = $params['food_id_value'];

            $message =  self::saveServerFood($params);
            DB::commit();
            return $message;
        }catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return self::MessageBagMsg(false,'操作失败');
        }

    }
}

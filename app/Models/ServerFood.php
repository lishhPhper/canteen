<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerFood extends Model
{

    protected $appends = [
        'food_id_value',
        'ids'
    ];
    public static function storeRule()
    {
        return [
            'server_time' => 'required',
            'food_id' => 'required',
            'food_num' => 'required|integer',
            'server_type' => 'required|integer',
        ];
    }

    public static function storeMsg()
    {
        return [
            'server_time.required' => '请选择供餐日期',
            'food_id.required' => '请选择菜品',
            'food_num.required' => '请填写菜品数量',
            'food_num.integer' => '请填写菜品数量',
            'server_type.required' => '请选择供餐类型',
            'server_type.integer' => '请选择供餐类型',
        ];
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function getFoodIdValueAttribute()
    {
        return implode(',',$this
            ->where('server_time',$this->attributes['server_time'])
            ->where('server_type',$this->attributes['server_type'])
            ->pluck('food_id')->toArray());
    }

    public function getIdsAttribute()
    {
        return implode(',',$this
            ->where('server_time',$this->attributes['server_time'])
            ->where('server_type',$this->attributes['server_type'])
            ->pluck('id')->toArray());
    }
}

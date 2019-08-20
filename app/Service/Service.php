<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2019/2/16
 * Time: 15:10
 */

namespace App\Service;


class Service
{
    /**
     * 返回数组
     * @param bool $result
     * @param string $msg
     * @param mixed $data
     * @return array
     */
    public static function resultSet(bool $result, string $msg = '', $data = []): array
    {
        return [
            'result' => $result,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    /**
     * 返回MessageBag消息
     * @param bool $status
     * @param string $msg
     * @return array
     */
    public static function MessageBagMsg(bool $status, string $msg = ''): array
    {
        return [
            'status' => $status,
            'msg' => $msg
        ];
    }

    /**
     * 当前时间
     * @return Carbon
     */
    protected function now()
    {
        return Carbon::now();
    }
}

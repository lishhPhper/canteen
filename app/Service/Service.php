<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2019/2/16
 * Time: 15:10
 */

namespace App\Service;


use Illuminate\Support\MessageBag;

class Service
{
    private $code = [
        '1001' => '未登入或已失效',
        '1002' => '未获得权限',

        '2001' => '未查到预约记录',

        '5000' => '服务异常',
    ];
    /**
     * 返回数组
     * @param bool $result
     * @param string $msg
     * @param mixed $data
     * @return array
     */
    public static function resultSet($result, string $msg = '', $data = []): array
    {
        return [
            'result' => $result,
            'msg' => $msg,
            'data' => $data,
        ];
    }

    /**
     * 返回status消息
     * @param bool $status
     * @param string $msg
     * @return array
     */
    public static function statusSet(bool $status, string $msg = ''): array
    {
        return [
            'status' => $status,
            'msg' => $msg
        ];
    }

    public static function MessageBagReturn($message, $uri)
    {
        $title = !$message['status'] ? '失败' : '成功';
        $success = $error = new MessageBag([
            'title'   => $title,
            'message' => $message['msg'],
        ]);
        if(!$message['status']) return redirect($uri)->with(compact('error'));
        return redirect($uri)->with(compact('success'));
    }

    /**
     * 当前时间
     * @return Carbon
     */
    protected function now()
    {
        return Carbon::now();
    }

    public function timeFormat($time)
    {
        return date('H:i',strtotime($time));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $msg
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($msg = '', $data = [], $code =1)
    {
        $response = [
            'code' => $code,
            'msg'  => $msg ?: 'Successful',
            'data' => $data,
        ];

        return response()->json($response);
    }

    /**
     * @param string $msg
     * @param array $data
     * @param int $errcode
     * @return \Illuminate\Http\JsonResponse
     */
    public function failure($msg = '', $data = [], $errcode = 0)
    {
        $response = [
            'code' => $errcode,
            'msg'  => $msg ?: 'Failed',
            'data' => $data,
        ];

        return response()->json($response);
    }
}

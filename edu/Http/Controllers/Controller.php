<?php

namespace App\Http\Controllers;

use App\Support\ResponseSupport;
use App\Util\Traits\Validate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use  DispatchesJobs, Validate;



    /**
     * @param string $message
     * @param array $data
     * @param string $url
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message = '', $data = [],  $url='', $status = 400)
    {
        return ResponseSupport::jsonResponse([
            'code' => 0,
            'status' => $status,
            'msg' => $message,
            'data' => $data,
            'url' => $url,
        ], 200, array(), JSON_UNESCAPED_UNICODE);
    }


    /**
     * @param $message
     * @param $data
     * @param string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message, $data = [],  $url='')
    {
        return ResponseSupport::jsonResponse([
            'code' => 1,
            'status'=>200,
            'msg' => $message,
            'data' => $data,
            'url' => $url,
        ], 200, array(), JSON_UNESCAPED_UNICODE);
    }
}

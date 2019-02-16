<?php

namespace App\Util\Traits;

use App\Exceptions\ApiException;


/**
 * 控制器基类
 * Class Controller
 * @package JiaLeo\Core
 */
trait Controller
{
    use ResponseResult;


    /**
     * 应答数据api
     * @param array || Collection || Object $data
     * @param array $list
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data = array(), $list = array(), $code = '200')
    {
        $this->setResponseData($data);
        $this->setResponseList($list);
        $result = $this->getResponseResult();
        return response()->json($result, $code, array(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 应答列表数据api
     * @param array $list
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseList($list = array())
    {
        return $this->response(array(), $list);
    }

    /**
     * 应答错误api
     * @param $error_msg $string 错误信息
     * @param string $error_id 错误id
     * @param int $status_code http状态码
     * @throws ApiException
     */
    public function responseError($error_msg, $error_id = 'ERROR', $status_code = 400)
    {
        response_error($error_msg, $error_id, $status_code);
    }



}




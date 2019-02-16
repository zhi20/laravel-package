<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/8 10:13
 * ====================================
 * Project: SDJY
 * File: ApiException.php
 * ====================================
 */

namespace App\Exceptions;


use AppTILSUPPORT\LogSupport;

class ApiException extends  \Exception
{
    protected $data = [];

    protected $url = [];

    protected $status = 200;

    /**
     * ApiException constructor.
     * @param string $message 错误信息
     * @param int $status  业务状态码  Handler::$httpStatus
     * @param array $data
     * @param string $url
     */
    function __construct($message = '', $status = 400, $data = [], $url = '')
    {
        parent::__construct($message, 200);

        $this->data = $data;

        $this->status = $status;

        $this->url = $url;
    }

    /**
     * Report the exception.
     *
     * @param  \Illuminate\Http\Request
     */
    public function render($request)
    {
            //TODO。。。异常处理（API返回）
        if($this->status === 500){              //服務器異常
            LogSupport::errorLog($this->getMessage(),$this->status);
        }
        return $this->result($request);
    }

    /**
     * 返回结果
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function result($request)
    {
        $http_code = $this->getCode();
        $data = [
            'code' => 0,
            'status' => $this->status,
            'msg' => $this->getMessage(),
            'data' => $this->data,
            'url' => $this->url,
        ];
        return response()->json($data, $http_code, array(), JSON_UNESCAPED_UNICODE);
    }

}
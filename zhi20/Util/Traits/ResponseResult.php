<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2019/2/15 16:05
 * ====================================
 * Project: SDJY
 * File: ResponseData.php
 * ====================================
 */

namespace App\Util\Traits;


trait ResponseResult
{

    protected $response_data = [];
    protected $response_list = [];
    protected $error_code = '';
    protected $error_msg = 'ok';
    protected $response_status = true;

    /**
     * @param bool $status
     */
    public function setStatus($status)
    {
        $this->response_status = $status;
    }

    /**
     * @param string $status
     */
    public function setErrorMsg($msg)
    {
        $this->error_msg = $msg;
    }

    /**
     * @param mixed $status
     */
    public function setErrorCode($code)
    {
        $this->error_code = $code;
    }

    public function setResponseData($data)
    {
        $this->response_data = $data;
    }


    public function setResponseList($list)
    {
        $this->response_list = $list;
    }

    public function getResponseResult(...$args)
    {
        foreach ($args as $k => $v){
            if(isset($this->$k)){
                $this->$k = $v;
            }
        }
         return [
            'status' => $this->response_status,
            'error_msg' => $this->error_msg,
            'error_code' => $this->error_code,
            'data' => $this->response_data,
            'list' =>  $this->response_list,
        ];
    }
}
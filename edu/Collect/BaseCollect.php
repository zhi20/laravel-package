<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/18 18:06
 * ====================================
 * Project: SDJY
 * File: BaseCollect.php
 * ====================================
 */

namespace App\Collect;


abstract class BaseCollect
{

    protected $data;                                //参数

    protected $error = '';                               //错误信息

    protected $info = '';                                //返回信息

    public function __construct($params=[])
    {
       $this->data = $params;
    }
    /** 获取成功信息 */
    public function getInfo($default = '')
    {
        if(empty($this->info)){
            $this->info = $default;
        }
        return $this->info;
    }

    /** 获取错误 */
    public function getError($default = '')
    {
        if(empty($this->error)){
            $this->error = $default;
        }
        return $this->error;
    }

    /** 设置参数 */
    public function setData($key, $value='')
    {
        if(is_array($key)){
            $this->data = $key;
        }else{
            $this->data[$key] = $value;
        }
    }

    /**
     * 获取数据
     * @param string $name
     * @param null $default
     * @return array|mixed
     */
    public function getData($name = NULL, $default = null)
    {
        return is_null($name) ? $this->data : (isset($this->data[$name]) ? $this->data[$name] : $default);
    }

}
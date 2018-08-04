<?php

namespace Zhi20\Laravel\Wechat;


/**
 * 第三方平台类
 * Class Component
 * @package Zhi20\Laravel\Wechat
 */
class Component
{

    private $postxml;
    private $receive;

    public function __construct($options)
    {
        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->encodingAesKey = isset($options['encodingaeskey']) ? $options['encodingaeskey'] : '';
        $this->appid = isset($options['appid']) ? $options['appid'] : '';
        $this->appsecret = isset($options['appsecret']) ? $options['appsecret'] : '';
    }

    public function valid()
    {
        $data = file_get_contents('php://input');
        $array = (array)simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

        $encryptStr = $array['Encrypt'];
        $pc = new Prpcrypt($this->encodingAesKey);
        $array = $pc->decrypt($encryptStr, $this->appid);
        if (!isset($array[0]) || ($array[0] != 0)) {
            die('decrypt error!');
        }
        $this->postxml = $array[1];

        if (!$this->checkSignature($encryptStr)) {
            die('Signature error!');
        }
        return true;
    }

    /**
     * For weixin server validation
     */
    private function checkSignature($str = '')
    {
        $signature = isset($_GET["signature"]) ? $_GET["signature"] : '';
        $signature = isset($_GET["msg_signature"]) ? $_GET["msg_signature"] : $signature; //如果存在加密验证则用加密验证段
        $timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : '';
        $nonce = isset($_GET["nonce"]) ? $_GET["nonce"] : '';

        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce, $str);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取微信服务器发来的信息
     */
    public function getRevData()
    {
        if ($this->receive) return $this->receive;
        $postStr = !empty($this->postxml) ? $this->postxml : file_get_contents("php://input");
        //兼顾使用明文又不想调用valid()方法的情况
        if (!empty($postStr)) {
            $this->receive = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        return false;
    }


    public function getVerifyTicket()
    {

        $authname = 'wechat_access_token'.$appid;
        if ($rs = $this->getCache($authname))  {
            $this->access_token = $rs;
            return $rs;
        }

        $result = $this->http_get(self::API_URL_PREFIX.self::AUTH_URL.'appid='.$appid.'&secret='.$appsecret);
        if ($result)
        {
            $json = json_decode($result,true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in'])-100 : 3600;
            $this->setCache($authname,$this->access_token,$expire);
            return $this->access_token;
        }
    }


}
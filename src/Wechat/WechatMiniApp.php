<?php
namespace Zhi20\Laravel\Wechat;

/**
 * 小程序
 * Class WechatMiniApp
 * @package Zhi20\Laravel\Wechat
 */
class WechatMiniApp
{
    private $appid;
    private $appsecret;
    private $access_token;

    public $errCode = 0;
    public $errMsg = 'ok';

    const API_URL_PREFIX = 'https://api.weixin.qq.com/cgi-bin';
    const AUTH_URL = '/token?grant_type=client_credential&';
    const TEMPLATE_SEND_URL = '/message/wxopen/template/send?'; //小程序模板消息


    /**
     * 构造函数
     * @param $type string 用户在小程序登录后获取的会话密钥
     */
    public function __construct($type = 'miniapp')
    {
        $config = Config('wechat.' . $type);

        $this->appid = $config['appid'];
        $this->appsecret = $config['appsecret'];
    }

    /**
     * js code获取session
     * @param $code
     * @return bool|mixed
     */
    public function jscode2session($code)
    {
        load_helper('Network');

        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $this->appid . '&secret=' . $this->appsecret . '&js_code=' . $code . '&grant_type=authorization_code';
        $result = http_get($url);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptData($encryptedData, $iv, $sessionKey)
    {
        if (strlen($sessionKey) != 24) {
            $this->errCode = -41001;
            $this->errMsg = 'sessionKey错误';
            return false;
        }
        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            $this->errCode = -41002;
            $this->errMsg = 'iv参数错误';
            return false;
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            $this->errCode = -41003;
            $this->errMsg = '解密失败!';
            return false;
        }
        if ($dataObj->watermark->appid != $this->appid) {
            $this->errCode = -41004;
            $this->errMsg = '解密失败!';
            return false;
        }

        return $result;
    }

    /**
     * 验证权限
     * @param string $appid
     * @param string $appSecret
     * @param string $token
     * @return bool|mixed|string
     */
    public function checkAuth($appid = '', $appSecret = '', $token = '')
    {
        if (!$appid || !$appSecret) {
            $appid = $this->appid;
            $appSecret = $this->appsecret;
        }
        if ($token) { //手动指定token，优先使用
            $this->access_token = $token;
            return $this->access_token;
        }

        $authname = 'wechat_miniapp:access_token:' . $appid;
        if ($rs = $this->getCache($authname)) {
            $this->access_token = $rs;
            return $rs;
        }
        load_helper('Network');
        $result = $this->http_get(self::API_URL_PREFIX . self::AUTH_URL . 'appid=' . $appid . '&secret=' . $appSecret);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || isset($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            $this->access_token = $json['access_token'];
            $expire = $json['expires_in'] ? intval($json['expires_in']) - 100 : 3600;
            $this->setCache($authname, $this->access_token, $expire);
            return $this->access_token;
        }
        return false;
    }

    /**
     * 设置缓存，按需重载
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired)
    {
        \Cache::put($cachename, $value, $expired / 60);
        return true;
    }

    /**
     * 获取缓存，按需重载
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        return \Cache::get($cachename);
    }

    /**
     * GET 请求
     * @param string $url
     */
    public function http_get($url)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    public function http_post($url, $param, $post_file = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * 发送消息
     */
    public function sendTemplateMessage($data)
    {
        if (!$this->access_token && !$this->checkAuth()) return false;
        $result = $this->http_post(self::API_URL_PREFIX . self::TEMPLATE_SEND_URL . 'access_token=' . $this->access_token, self::json_encode($data));
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 清除access_token
     * @return string
     */
    public function clearAccessToken()
    {
        return $this->access_token = '';
    }

    /**
     * 微信api不支持中文转义的json结构
     * @param array $arr
     */
    static function json_encode($arr)
    {
        //php5.4 json_encode才支持第二个参数：JSON_UNESCAPED_UNICODE ,中文不会被默认转成unicode
        //官方已修复
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

}
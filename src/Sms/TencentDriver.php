<?php

namespace Zhi20\Laravel\Sms;

use App\Exceptions\ApiException;

class TencentDriver implements Contracts\Driver
{
    private $config;        //配置
    private $errorMsg;      //错误信息

    /**
     * TencentDriver constructor.
     * @param $config
     */
    public function __construct($config)
    {
        //读取配置
        $this->config = array(
            'appid' => $config['tencent']['app_key'],
            'appkey' => $config['tencent']['app_secret'],
            'sign_name_inland' => $config['tencent']['sign_name_inland'],
            'sign_name_overseas' => $config['tencent']['sign_name_overseas']
        );
    }


    /**
     * 发送操作
     * @param int $phone 手机号码
     * @param string $template_code 模板代码
     * @param array $param 模板参数
     * @param array $extra_data 额外字段
     * @return bool
     */
    public function send($phone, $template_code, $params = array(), $extra_data = array())
    {
        if (!isset($extra_data['nation_code'])) {
            throw new ApiException('发送参数nation_code不存在');
        }

        $config = $this->config;

        $random = rand(100000, 999999);
        $curTime = time();
        $wholeUrl = "https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid=" . $config['appid'] . "&random=" . $random; // 访问的url

        $tel = [];
        $data = [];
        $tel['nationcode'] = "" . $extra_data['nation_code']; // 国家号
        $tel['mobile'] = "" . $phone; // 手机号码

        $data['tel'] = $tel;
        $data['sig'] = hash("sha256", "appkey=" . $config['appkey'] . "&random=" . $random
            . "&time=" . $curTime . "&mobile=" . $phone); // App 凭证
        $data['tpl_id'] = $template_code; // 模板ID
        $data['params'] = $params; // 信息模板对应的参数
        $data['sign'] = $extra_data['nation_code'] == '86' ? $config['sign_name_inland'] : $config['sign_name_overseas']; // 短信签名，如果使用默认签名，该字段可缺省
        $data['time'] = $curTime; // 请求发起时间，unix 时间戳（单位：秒），如果和系统时间相差超过 10 分钟则会返回失败
        $data['extend'] = ""; // 短信码号扩展号，格式为纯数字串，其他格式无效。默认没有开通，开通请联系
        $data['ext'] = ""; // 用户的 session 内容，腾讯 server 回包中会原样返回，可选字段，不需要就填空

        load_helper('Network');
        $reponse = http_post($wholeUrl, json_encode($data));

        if ($reponse !== FALSE) {
            $res = json_decode($reponse, TRUE);

            if (isset($res['errmsg']) && $res['errmsg'] == 'OK') {
                return TRUE;
            }

            $this->errorMsg = $res;
        } else {
            $this->errorMsg = array('code' => 0, 'msg' => 'HTTP_RESPONSE_NOT_WELL_FORMED');
        }

        return false;
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

}
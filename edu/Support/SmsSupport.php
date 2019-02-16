<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/14 11:46
 * ====================================
 * Project: SDJY
 * File: SmsSupport.php
 * ====================================
 */

namespace App\Support;


use App\Exceptions\ApiException;
use extend\AliyunSms;

class SmsSupport
{
    const IP_KEY = 'sms:ip:lock:';
    protected static $ipLock;               //ip限制
    protected static $phoneLock;            //手机号限制
    /**
     * 发送短信
     * @param $phone
     * @param $code  //config sms.php
     * @param $data
     * @return bool|\stdClass
     */
    public static function sendSms($phone, $index, $data)
    {
//        ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
// error_reporting(E_ALL); // 显示所有错误提示，仅用于测试时排查问题
//        set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
        $params = array ();

        // *** 需用户填写部分 ***
        $aliyun = config('sms.aliyun');
        $template = config('sms.template');
        $template = $template[$index];
        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId =$aliyun['app_key'];
        $accessKeySecret = $aliyun['app_secret'];
        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $phone;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $aliyun['sign_name'];

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $template['template_code'];

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $data;

        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new AliyunSms();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );

        return $content;
    }

    /**
     * @param $key
     * @param $phone
     * @param $code
     * @return mixed
     * @throws ApiException
     */
    public static function checkCaptcha($key, $phone, $code)
    {
        $name = $key.'check:'.md5($phone);
        $value = \Cache::get($name);
        if(empty($value)){
            throw new ApiException('验证码已过期，请重新获取!');
        }elseif ($value != $code){
            throw new ApiException('验证码不正确!');
        }
        \Cache::forget($name);
        return true;
    }


    /**
     * 检查发送短信IP地址
     * @throws ApiException
     */
    public static function checkIp()
    {
        //相同IP手机号码1天最多提交30次；
        $ip = request()->ip();
        self::$ipLock = \Cache::get(self::IP_KEY.md5($ip));
        if( self::$ipLock){
            if( self::$ipLock['num'] > 30){
                throw new ApiException('今天获取次数过于频繁，请明天再试!');
            }
            self::$ipLock['num'] += 1;
        }else{
            self::$ipLock = [
                'num' =>1,
                'time' =>time()
            ];
        }
    }

    /**
     * @param $key  'login:sms:locked:'.md5($phone)
     * @throws ApiException
     */
    public static function checkTime($key, $phone)
    {
        //检查发送次数
        self::$phoneLock = \Cache::get($key.'lock:'.md5($phone));
        if(!self::$phoneLock){
            //发送验证码1分钟只能点击发送1次；
            if(time()<= (self::$phoneLock['time'] + 600)){
                throw new ApiException('请等待一分钟后获取!');
            }

            //验证码短信单个手机号码30分钟最多提交10次；
            if(time()<= (self::$phoneLock['time'] + 1800) && self::$phoneLock['num'] > 10){
                throw new ApiException('次数过于频繁，请稍后再获取!');
            }
            if(time() >= (self::$phoneLock['time'] + 1800)){        //每半个小时重置次数
                self::$phoneLock['time'] = time();
                self::$phoneLock['num'] = 1;
            }else{
                self::$phoneLock['num'] += 1 ;
            }
        }else{
            self::$phoneLock = [
                'time' => time(),
                'num'  => 1
            ];
        }
    }


    /**
     * 发送成功缓存结果
     * @param $key
     * @param $phone
     * @param $code
     */
    public static function cacheResult($key, $phone, $code)
    {
        if(self::$ipLock){
            $ip = request()->ip();
            \Cache::put(self::IP_KEY.md5($ip), self::$ipLock, 24 * 60);
        }
        if(self::$phoneLock){
            \Cache::put($key.'lock:'.md5($phone), self::$phoneLock, 60);
        }
        \Cache::put($key.'check:'.md5($phone), $code, 60);
    }
}
<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/14 11:45
 * ====================================
 * Project: SDJY
 * File: EmailSupport.php
 * ====================================
 */

namespace App\Support;


use App\Exceptions\ApiException;
use Mail;

class EmailSupport
{
    const IP_KEY = 'email:ip:lock:';
    protected static $ipLock;               //ip限制
    protected static $emailLock;            //邮箱限制

    /**
     * @param $email
     * @param $data
     * @return bool
     * @throws ApiException
     */
    public static function send($email, $data){
        try {
            Mail::to($email)->send(new \App\Http\Mail\Register($data));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return true;
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
     * @param $key  
     * @throws ApiException
     */
    public static function checkTime($key, $phone)
    {
        //检查发送次数
        self::$emailLock = \Cache::get($key.'lock:'.md5($phone));
        if(!self::$emailLock){
            //发送验证码1分钟只能点击发送1次；
            if(time()<= (self::$emailLock['time'] + 600)){
                throw new ApiException('请等待一分钟后获取!');
            }

            //验证码短信单个手机号码30分钟最多提交10次；
            if(time()<= (self::$emailLock['time'] + 1800) && self::$emailLock['num'] > 10){
                throw new ApiException('次数过于频繁，请稍后再获取!');
            }
            if(time() >= (self::$emailLock['time'] + 1800)){        //每半个小时重置次数
                self::$emailLock['time'] = time();
                self::$emailLock['num'] = 1;
            }else{
                self::$emailLock['num'] += 1 ;
            }
        }else{
            self::$emailLock = [
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
        if(self::$emailLock){
            \Cache::put($key.'lock:'.md5($phone), self::$emailLock, 60);
        }
        \Cache::put($key.'check:'.md5($phone), $code, 60);
    }
}
<?php

namespace App\Logic\Api;

use App\Exceptions\ApiException;
use App\Exceptions\Handler;
use App\Support\AuthSupport;
use App\Support\EmailSupport;
use App\Support\LoginSupport;
use App\Support\SmsSupport;
use App\Support\Zhi20Support;
use extend\Captcha;

class LoginLogic
{
    const SMS_KEY= 'sms:login:';            //短信验证码缓存前缀
    const PASSWORD_KEY= 'password:login:';            //密碼缓存前缀

    /**
     * 发送登录短信验证码
     * @param array $data 要发送验证码的数据
     * @return bool
     * @throws ApiException
     */
    public static function sendSms($data)
    {
        //判断电话号码
        $phone = $data['phone'];
        $key = static::SMS_KEY;
        SmsSupport::checkIp();                  //檢查ip
        SmsSupport::checkTime($key, $phone);    //檢查手機
        //发送短信
        $code = rand(1000, 9999);
        $data = [
            'code' => $code
        ];
//        ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
        try{
            $result = SmsSupport::sendSms($phone, 8, $data);
            if($result->Code == 'OK'){
                SmsSupport::cacheResult($key, $phone, $code);
                return true;
            }
            return false;
        }catch (\Exception $e){
            return false;
        }

    }

    /**
     * 发送登录邮箱验证码
     * @param array $data 要发送验证码的数据
     * @return bool
     * @throws ApiException
     */
    public static function sendEmail($data)
    {
        //判断邮箱

    }

    /**
     * 用户登录
     * @param $data
     * @return bool
     * @throws ApiException
     */
    public static function login($data)
    {
        //检查是手机还是邮箱登陆
        $user = \App\Model\UserModel::where('locked', '=', 0);
        // 判断登录方式
        if (isset($data['phone'])) { // 手机号码登录
            $login_method = 'phone';
            $account = $data['phone'];
            $user->where('phone', '=', $data['phone']);
        } else if (isset($data['email'])) { // 邮箱登录
            $login_method = 'email';
            $account = $data['email'];
            $user->where('email', '=', $data['email']);
        } else {
            throw new ApiException('请正确输入登录账号!');
        }
        //检查用户是否存在
        $user = $user->first(['id', 'headimg', 'username', 'headimg', 'status']);
        if(!$user && isset($data['verification_code'])){
            //如果用户不存在并且使用验证码登录 尝试从脂20获取用户
            $userInfo = Zhi20Support::getUserExist([$login_method=>$account]);
            if(!empty($userInfo)){
                unset($userInfo['id']);
                if("0000-00-00" ==$userInfo['birthday']){
                    $userInfo['birthday'] = date('Y-m-d',0 );
                }
                $user = new \App\Model\UserModel();
                $user->setValue($userInfo);
                if(!$user->save()){         //保存失败去掉用户信息
                    $user = null;
                }
            }
        }
        if (!$user) {
            throw new ApiException('密码错误或用户不存在!');
        }
        //判断参数是否正确
        //密码登录
        if (isset($data['password'])) {
            //判断是否需要验证码
            $error_num = 0;
            $lock_info = \Cache::get(static::PASSWORD_KEY.'lock:' . md5($account));
            if ($lock_info) {
                $error_num = $lock_info['error_num'];
                //判断是否够3次
                if ($error_num >= 3 && empty($data['locked_verification_code'])) {
                    throw new ApiException('多次输入密码错误,请填写图形验证码!', Handler::STATUS_NEED_CODE);
                } elseif ($error_num >= 3 && !empty($data['locked_verification_code'])) {
                    //验证密码图形验证码
                    $result = (new \extend\Captcha)->checkCodeInfo('account_check', $data['locked_verification_code']);
                    if (!$result) {
                        throw new ApiException('图形验证码错误!');
                    }
                }
            }

            //与密码比对
            $user_auth_pwd = \App\Model\UserAuthPasswordModel::where('user_id', '=', $user['id'])
                ->first(['id', 'password', 'salt']);
            if (!$user_auth_pwd) {
                \Cache::put(static::PASSWORD_KEY . 'lock:' . md5($account), ['error_num' => $error_num + 1], 60);
                throw new ApiException('密码错误或用户不存在!');
            }

            //密码加密
            load_helper('Password');
            $pwd = encrypt_password($data['password'], $user_auth_pwd['salt']);
            if ($user_auth_pwd['password'] != $pwd) {
                \Cache::put(static::PASSWORD_KEY . 'lock:' . md5($account), ['error_num' => $error_num + 1], 60);
                throw new ApiException('密码错误或用户不存在!');
            }

        } else if (isset($data['verification_code'])) {
            //验证码登录
            if ($login_method == 'phone') {
                SmsSupport::checkCaptcha(static::SMS_KEY, $data['phone'] , $data['verification_code']);
            } elseif ($login_method == 'email') {
                // TODO...
//                EmailSupport::checkCaptcha('login:email:check:'.md5($data['email']) , $data['verification_code']);
            } else {
                throw new ApiException('登录方式错误!');
            }
        } else {
            throw new ApiException('登录方式错误!');
        }
        //预定义修改字段
        $save_data = [
            'last_login_ip' => ip2long(request()->ip()),
            'last_login_time' => time(),

        ];
        \DB::beginTransaction();
        $res = \App\Model\UserModel::where('id', $user['id'])
            ->update($save_data);
        if (!$res) {
            \DB::rollBack();
            throw new ApiException('登录失败!', Handler::STATUS_SERVER_ERROR);
        }

        \DB::commit();
        \Cache::forget(static::PASSWORD_KEY.'lock:'  . md5($account));
        $tokens = AuthSupport::createToken([ 'user_id' => $user->id]);
        return $tokens;
    }

    /**
     * 判断是否已经登录并返回token
     *
     * @return array
     */
    public static function judgeLogin()
    {
        if(AuthSupport::check() &&  AuthSupport::get('user_id')){
            $data =  [
                'is_user' => 1
            ];
        }else{
            $data =  [
                'is_user' => 0
            ];
        }
        return $data;
    }
}
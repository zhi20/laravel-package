<?php
namespace App\Logic\Api;

use App\Exceptions\ApiException;
use App\Exceptions\Handler;
use App\Support\AuthSupport;
use App\Support\EmailSupport;
use App\Support\SmsSupport;

class RegisterLogic
{
    const SMS_KEY= 'sms:register:';            //短信验证码缓存前缀

    /**
     * 提交注册用户
     * @param array $data 要注册的用户数据
     * @return array
     * @throws ApiException
     */
    public static function addUser($data, $type = 'phone')
    {
        $phone = $data['phone'] ?? '';                    //手机号
        $email = $data['email'] ?? '';                    //手机号
        $code = $data['verification_code'];         //验证码
        $password = $data['password'];              //密码
        if(!empty($phone)){
            $type= 'phone';
        }elseif (!empty($email)){
            $type = 'email';
        }
        $saveData = array();
        //判断唯一电话号码或邮箱
        if ($type == 'phone') {
            //验证验证码
            if(!SmsSupport::checkCaptcha(static::SMS_KEY, $phone, $code)){
                throw new ApiException('验证码错误');
            }
            if (self::validPhone($phone)) {
                throw new ApiException( '当前账号已经被注册!');
            }
            $saveData['phone'] = $phone;
        } elseif ($type == 'email') {
            //验证验证码
//            if(!EmailSupport::checkCaptcha('register_code'.$email, $code)){
//                throw new ApiException('验证码错误');
//            }
            if (self::validEmail($email)) {
                throw new ApiException( '当前账号已经被注册!');
            }
            $saveData['email'] = $email;
        }
        \DB::beginTransaction();
        //用户表
        $user_model = new \App\Model\UserModel();
        $saveData['last_login_ip'] = ip2long(request()->ip());
        $saveData['last_login_time'] = time();
        $saveData['register_ip'] = ip2long(request()->ip());
        $user_model->setValue($saveData);
        $res = $user_model->save();
        if (!$res) {
            \DB::rollBack();
            throw new ApiException('数据库错误!');
        }
        $user_id = $user_model->id;
        //用户密码表
        $userAuthPasswordModel = new \App\Model\UserAuthPasswordModel();
        //密码加密
        load_helper('Password');
        $getPassword = create_password($password, $salt);
            $userAuthPasswordModel->setValue([
                'user_id' => $user_id,
                'password' => $getPassword,
                'salt' => $salt
            ]);
        $res = $userAuthPasswordModel->save();
        if (!$res) {
            \DB::rollBack();
            throw new ApiException('数据库错误!');
        }

        //用户资金表
        $userCapitalModel = new \App\Model\UserCapitalModel();
        $userCapitalModel->setValue([
            'user_id' => $user_id
        ]);
        $res = $userCapitalModel->save();
        if (empty($res)) {
            \DB::rollBack();
            throw new ApiException('数据库错误');
        }
        \DB::commit();
        //写入session
        $tokens = AuthSupport::createToken([ 'user_id' => $user_id]);
        return $tokens;
    }

    /**
     * 通过手机注册发送验证码
     * @param array $data 要发送验证码的数据
     * @return bool
     * @throws ApiException
     */
    public static function sendSms($data)
    {
        //判断电话号码
        $phone = $data['phone'];
        SmsSupport::checkIp();                  //檢查ip
        SmsSupport::checkTime(static::SMS_KEY, $phone);    //檢查手機
        //发送短信
        $code = rand(1000, 9999);
        $data = [
            'code' => $code
        ];
//        ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
        try{
            $result = SmsSupport::sendSms($phone, 8, $data);
            if($result->Code == 'OK'){
                SmsSupport::cacheResult(static::SMS_KEY, $phone, $code);
                return true;
            }
            return false;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * 通过邮箱注册发送验证码
     * @param array $data 要发送验证码的数据
     * @return bool
     * @throws ApiException
     */
    public static function sendEmail($data)
    {
        //图形验证码判断
        /*$result = \Captcha::checkCodeInfo('register_code', $data['captcha_code']);
        if (!$result) {
            throw new ApiException('验证码错误!');
        }*/

        return true;
    }

    /**
     * 判断手机号是否存在
     * @param string $phone 要验证的手机号
     * @return bool
     */
    public static function validPhone($phone)
    {
        //判断唯一电话号码
        $user = \App\Model\UserModel::where('phone', '=', $phone)
            ->first(['id']);
        if (empty($user)) {
           return false;
        }
        return true;
    }

    /**
     * 判断Email是否存在
     * @param string $email 要验证的邮箱
     * @return bool
     * @throws ApiException
     */
    public static function validEmail($email)
    {
        //判断唯一邮箱
        $user = \App\Model\UserModel::where('email', '=',$email)
            ->first(['id']);
        if (empty($user)) {
           return false;
        }
        return true;
    }

    /**
     * 忘记密码
     * @param $data
     * @return array
     * @throws ApiException
     */
    public static function forgetPassword($data){
        $phone = $data['phone'] ?? '';                    //手机号
        $email = $data['email'] ?? '';                    //手机号
        $code = $data['verification_code'];         //验证码
        $password = $data['password'];              //密码
        if(!empty($phone)){
            $type= 'phone';
        }elseif (!empty($email)){
            $type = 'email';
        }
        $saveData = array();
        //判断电话号码或邮箱
        if ($type == 'phone') {
            if(!SmsSupport::checkCaptcha(static::SMS_KEY, $phone, $code)){
                throw new ApiException('验证码错误');
            }
            if (!self::validPhone($phone)) {
                throw new ApiException( '该账户不存在!');
            }
            $user_model = \App\Model\UserModel::where('phone',$phone)->first();
        } elseif ($type == 'email') {
            //验证验证码
//            if(!EmailSupport::checkCaptcha('register_code'.$email, $code)){
//                throw new ApiException('验证码错误');
//            }
            if (!self::validEmail($email)) {
                throw new ApiException( '当前账号不存在!');
            }
            $user_model = \App\Model\UserModel::where('email',$email)->first();
        }
        \DB::beginTransaction();
        //用户表
        $saveData['last_login_ip'] = ip2long(request()->ip());
        $saveData['last_login_time'] = time();
        $user_model->setValue($saveData);
        $res = $user_model->save();
        if (!$res) {
            \DB::rollBack();
            throw new ApiException('数据库错误!', Handler::STATUS_SERVER_ERROR);
        }
        $user_id = $user_model->id;
        //用户密码表
        $userAuthPasswordModel =\App\Model\UserAuthPasswordModel::where('user_id', $user_id)->first();
        if(empty($userAuthPasswordModel)){
            $userAuthPasswordModel = new \App\Model\UserAuthPasswordModel();
        }
        //密码加密
        load_helper('Password');
        $getPassword = create_password($password, $salt);
        $userAuthPasswordModel->setValue([
            'user_id' => $user_id,
            'password' => $getPassword,
            'salt' => $salt
        ]);
        $res = $userAuthPasswordModel->save();
        if (!$res) {
            \DB::rollBack();
            throw new ApiException('数据库错误!', Handler::STATUS_SERVER_ERROR);
        }
        \DB::commit();
        //写入session
        $tokens = AuthSupport::createToken([ 'user_id' => $user_id]);
        return $tokens;
    }
}
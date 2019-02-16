<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{


    /**
     * 注册
     * 手机\邮箱注册
     *
     * @throws \App\Exceptions\ApiException
     */
    public function register(Request $request)
    {
        $data = $this->verify([
            'phone' => 'no_required|mobile',
            'email' => 'no_required|email',
            'verification_code' => '',
            'password' => ''
        ], 'POST');
        $token = \App\Logic\Api\RegisterLogic::addUser($data);
        return $this->success("OK",$token);
    }


    /**
     * 手机注册发送验证码
     *
     * @throws \App\Exceptions\ApiException
     */
    public function sendSms(Request $request)
    {
        $data = $this->verify([
            'phone' => 'mobile',
        ], 'POST');

        if(\App\Logic\Api\RegisterLogic::sendSms($data)){
            return $this->success("OK");
        }else{
            return $this->error("发送短信失败");
        }
    }


    /**
     * 邮箱注册发送验证码
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function sendEmail(Request $request)
    {
        $data = $this->verify([
            'email' => 'email',
        ], 'POST');

        if(\App\Logic\Api\RegisterLogic::sendEmail($data)){
            return $this->success("OK");
        }else{
            return $this->error("发送短信失败");
        }
    }

    /**
     * 注册图片验证码
     *
     * @return \Illuminate\Http\Response
     */
    public function captcha()
    {
        (new \extend\Captcha)->setLimit(4)->create('register_code', 5);
    }

    /**
     * 判断手机号是否存在
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function validPhone()
    {
        $data = $this->verify([
            'phone' => 'mobile'
        ], 'POST');
       if(\App\Logic\Api\RegisterLogic::validPhone($data['phone'])){
          $data = ['is_exist' => 1];
       }else{
           $data = ['is_exist' => 0];
       }
        return $this->success("OK", $data);
    }

    /**
     * 判断Email是否存在
     *
     *
     * @throws \App\Exceptions\ApiException
     */
    public function validEmail()
    {
        $data = $this->verify([
            'email' => 'email'
        ], 'POST');
        if(\App\Logic\Api\RegisterLogic::validEmail($data['email'])){
            $data = ['is_exist' => 1];
        }else{
            $data = ['is_exist' => 0];
        }
        return $this->success("OK", $data);
    }



    /**
     * 忘记密码
     * @throws \App\Exceptions\ApiException
     */
    public function forgetPassword(){
        $data = $this->verify([
            'phone' => 'no_required|mobile',
            'email' => 'no_required|email',
            'verification_code' => '',
            'password' => ''
        ], 'POST');
        $token = \App\Logic\Api\RegisterLogic::forgetPassword($data);
        return $this->success("OK",$token);
    }


}
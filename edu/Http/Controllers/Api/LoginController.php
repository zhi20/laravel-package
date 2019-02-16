<?php
namespace App\Http\Controllers\Api;

use App\Support\AuthSupport;
use App\Support\LogSupport;
use App\Support\Zhi20Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * 手机密码/验证码登录
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function login(Request $request)
    {
        $params = $this->verify([
            'phone' => 'no_required|mobile',
            'email' => 'no_required|email',
            'verification_code' => 'no_required',
            'password' => 'no_required',
            'locked_verification_code' => 'no_required'
        ], 'POST');

        $data = \App\Logic\Api\LoginLogic::login($params);

        return $this->success("OK", $data);
    }

    /**
     * 手机登录发送验证码
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function sendSms(Request $request)
    {
        $data = $this->verify([
            'phone' => 'mobile',
        ], 'POST');
        if(\App\Logic\Api\LoginLogic::sendSms($data)){
            return $this->success("OK");
        }else{
            return $this->error("发送短信失败");
        }
    }

    /**
     * 邮箱登录发送验证码
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

        $data = \App\Logic\Api\LoginLogic::sendEmail($data);

        return $this->success('OK',$data);
    }

    /**
     * 登录密码验证图片验证码
     */
    public function lockedCaptcha()
    {
        echo    $orderSn = 'exam'.date('YmdHis').str_pad(date("His")^856953,6,'0');
        exit;
        (new \extend\Captcha)->setLimit(4)->create('account_check', 5);
    }

    /**
     * 注销登录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        AuthSupport::destroy();
        return $this->success('OK');
    }

    /**
     * 判断是否已经登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function isLogin()
    {
        $data = \App\Logic\Api\LoginLogic::judgeLogin();
        return $this->success('OK', $data);


    }
}
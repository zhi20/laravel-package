<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/20 11:10
 * ====================================
 * Project: SDJY
 * File: LoginAuth.php
 * ====================================
 */

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\Handler;
use App\Logic\Api\WechatLogic;
use App\Support\AuthSupport;
use App\Support\LoginSupport;
use App\Support\ResponseSupport;
use Closure;


class LoginAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws ApiException
     */
    public function handle($request, Closure $next)
    {
        $result = $this->isLogin();
        if(!is_bool($result)){
            return $result;
        }
        //检查是否需要验证权限
        if($result){
            return $next($request);
        }
        throw  new ApiException('没有登录', Handler::STATUS_NO_LOGIN);
    }

    protected  function isLogin()
    {
        //TODO...登陆验证逻辑
        if(is_wechat()){
            //来源微信
            //1.检查是否已经登陆
            if(!AuthSupport::check() || !AuthSupport::get('openid')){
                $token = AuthSupport::createToken();            //生成token
                //2.未登陆自动登陆
                $result=WechatLogic::wechatLogin();
                if(!is_bool($result)){
                    return $result;
                }
                if(!$result){
                    return false;
                }
                ResponseSupport::setCookie(AuthSupport::COOKIE_NAME, $token['token']);  //写入cookie
            }
            //3.检查是否已绑定手机号 user_id
            if( !AuthSupport::get('user_id')){
                return ResponseSupport::jsonResponse([
                    'code' => 1,
                    'status'=>Handler::STATUS_NO_LOGIN,
                    'msg' => array_get( Handler::$httpStatus, Handler::STATUS_NO_LOGIN),
                    'data' => [],
                    'url' => '',
                ], 200, array(), JSON_UNESCAPED_UNICODE);
            }
        }else{
            //App
            //1. 检查是否已登陆  并自动登录
            if(!AuthSupport::check() || !AuthSupport::get('user_id')){
                //登陆失败提醒登陆
                return ResponseSupport::jsonResponse([
                    'code' => 1,
                    'status'=>Handler::STATUS_NO_LOGIN,
                    'msg' => array_get( Handler::$httpStatus, Handler::STATUS_NO_LOGIN),
                    'data' => [],
                    'url' => '',
                ], 200, array(), JSON_UNESCAPED_UNICODE);
            }
        }
        return true;
    }
}
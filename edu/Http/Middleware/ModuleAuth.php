<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/7 18:38
 * ====================================
 * Project: SDJY
 * File: ModuleAuth.php
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

class ModuleAuth
{
    protected $except = [
        //
    ];

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
        if(
            ( $this->isPermission() )||
            $this->inExceptArray($request)
        ){
            return $next($request);
        }
        throw  new ApiException('没有权限', Handler::STATUS_UNAUTHORIZED);
    }


    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }


    protected  function isPermission()
    {
        //TODO...权限验证逻辑
        $str = 'Module';
        if(defined(MODULE_NAME) && strncmp(MODULE_NAME, $str, strlen($str)) === 0){
            //1.检查模块所属分类并判断是否可用
            //2.检查模块是否需要验证
            //3.检查验证是否通过
            return true;
        }
        return true;
    }

}
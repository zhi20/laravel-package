<?php

namespace App\Http\Middleware;

use App\Exceptions\PowerException;
use App\Support\AuthSupport;
use App\Support\LoginSupport;
use Closure;

class Permission
{
    protected $except = [
        //
       '/m/admin/region/index'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检查是否需要验证权限
        if(
            ( $this->isLogin() && $this->isPermission() )||
            $this->inExceptArray($request)
        ){
            return $next($request);
        }
//        return redirect('/admin/login');
        throw  new PowerException('没有权限', [], '/admin/login');
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

    protected  function isLogin()
    {
        //检查是否登陆
        return AuthSupport::check();
    }

    protected  function isPermission()
    {
        //定义控制器模块

        return LoginSupport::checkPower();

    }
}

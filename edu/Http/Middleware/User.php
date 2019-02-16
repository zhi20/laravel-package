<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/14 11:59
 * ====================================
 * Project: SDJY
 * File: User.php
 * ====================================
 */

namespace App\Http\Middleware;

use App\Support\AuthSupport;
use Closure;

class User
{

    public function handle($request, Closure $next)
    {
        AuthSupport::$key = 'user';                 //设置认证 key 为用户
        return $next($request);

    }
}
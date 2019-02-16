<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/16 14:02
 * ====================================
 * Project: SDJY
 * File: Module.php
 * ====================================
 */

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;

class Module
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
        //定義控制器常量
        $route = request()->route()->action;
        if(isset($route['controller'])){
            $controller = str_replace($route['namespace'], "", $route['controller']);
            if(strpos($controller,'\\')===0){
                $controller = substr($controller,1);
            }
            $args = explode('@',$controller);
            $controller = str_replace("\\", '/',$args[0] );
            $controller = str_replace_last("Controller", '', $controller);
            $action  = $args[1];
            define('ACTION_NAME',$action);
            define('CONTROLLER_NAME',basename($controller));
            define('MODULE_NAME',dirname($controller));
            define("VIEW_NAME", MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME);
        }
        return $next($request);
    }
}
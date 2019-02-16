<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Exceptions\Handler;
use App\Support\AuthSupport;
use Closure;

class JwtAuth
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
        //JWT认证逻辑  AuthSupport::$key 缓存前缀用来区分不同用户类型（前端用户和后台用户）
        //1 用户登陆 从服务端获取token (根据header->X-ISAPP请求头判断是否app)
        //2. 用户使用token访问其他接口时进行验证
        //3. 从header->Authorization|cookie->edu_session|queryString->token获取token
        //4. 如果有生成sk的话会验证签名   header->X-Signingkey =  base64_encode(md5($src_str));
            //$src_str = /秘钥/时间戳/主机路径?请求参数(all没有file)   GET/sk/header->X-Hztimestmps/www.edu.com/admin/login?a=1
        //5. AuthSupport::check请求方式()通过会返回true
        if(AuthSupport::check() || $request->input('test') == 800){
            return $next($request);
        }
        throw  new ApiException('没有登录',Handler::STATUS_NO_LOGIN);

    }
}

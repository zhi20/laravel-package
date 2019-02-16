<?php
namespace App\Support;


use Firebase\JWT\JWT;
use Illuminate\Support\Arr;

class AuthSupport
{
    const COOKIE_NAME = 'auth_token';

    protected static $data;

    public static $key = 'auth';

    protected static $sessionKey;

    protected static $token;

    protected static $maxExpires = 60 * 24 * 30;        //分钟

    public static $expires = 120; //设置单次过期时间(分钟) ;





    /**
     * 验证jwt
     * @param string $token
     * @param object $request
     * @return bool
     */
    public static function check($token = '')
    {

        //尝试获取token
        if(empty($token)){
            $token = static::getToken();
        }
        if (!$token) {
            return false;
        }
        //解密token
        try {
            $encodeData = (array)JWT::decode($token, config('app.key'), ['HS256']);
        } catch (\Exception $e) {
            return false;
        }

        self::$sessionKey = $encodeData['session_key'];


        //通过sessionkey获取数据
        $data = \Cache::get(self::$key . ':' . self::$sessionKey);
        if (empty($data)) {
            return false;
        }

        //验证过期时间
        if ($data['expires_time'] < time()) {
            return false;
        }

        //过期时间
        $expires_time = $data['device'] == 'web' ? self::$expires : self::$maxExpires;

        $time = time();
        $data['expires_time'] = $time + $expires_time * 60;
        $data['refresh_time'] = $time;

        //拥有sk字段的,需验证签名
        if (!empty($data['sk'])) {
            if (!self :: checkSign($data['sk'])) {
                return false;
            }
        }
        \Cache::put(self::$key . ':' . self::$sessionKey, $data, $expires_time);
        self::$data = $data;

        return true;
    }

    /**
     * 获取token
     * @param $token
     * @return bool
     */
    public static function getToken()
    {

        if (empty(self::$token)) {
            //获取header内容
            self::$token = static::getTokenByHeader();
        }

        if (empty(self::$token)) {
            //获取url上token字段上的内容
            self::$token =  static::getTokenByUrl();
        }

        if (empty(self::$token)) {
            //获取cookie上的内容
            self::$token =  static::getTokenByCookie();
        }

        return self::$token;
    }

    /**
     * 通过Header获取token
     * @return array|string
     */
    public static function getTokenByHeader()
    {
        $token = request()->header('Authorization');
        if(strncmp('Bearer ', $token, 7) === 0){
            $token = substr($token,7);
        }
        return $token;
    }

    /**
     * 通过Url获取token
     * @return mixed
     */
    public static function getTokenByUrl()
    {

        return request()->query->get('token');
    }

    /**
     * 通过cookie获取token
     * @return mixed
     */
    public static function getTokenByCookie()
    {
        return request()->cookies->get(self::COOKIE_NAME);
    }

    /**
     * 生成token
     * @param array $session_data
     * @return array
     */
    public static function createToken(array $session_data = array(), $device = '')
    {
        load_helper('Password');
        $session_key = create_guid();
        $time = time();
        $expires_time = $time + (self::$expires * 60);
        $secret_key = '';
        $is_sign = false;

        if (empty($device)) {
            $device = 'web';

            //判断设备类型
            $is_app = boolval(request()->header('X-ISAPP'));
            if ($is_app) {
                $device = 'app';
            }

            $is_sign = config('app.is_web_sign', false);
        }
        if ($device == 'app' || $is_sign) {
            $expires_time = $time + (self::$maxExpires * 60);
            $secret_key = create_guid();
        }
        $session_data['device'] = $device;
        $session_data['create_at'] = $time;      //创建时间
        $session_data['expires_time'] = $expires_time;  //过期时间
        $session_data['sk'] = $secret_key;
        $data = array(
            'session_key' => $session_key
        );
        //过期时间
        $session_expires_time = $device == 'web' ? self::$expires : self::$maxExpires;
        \Cache::add(self::$key . ':' . $session_key, $session_data, $session_expires_time);
        $token = JWT::encode($data, config('app.key'),'HS256');
        self::$sessionKey = $session_key;
        return [
            'token' => $token,
            'sk' => $secret_key,
            'is_sign' => intval($is_sign)
        ];
    }

    /**
     * 设置数据
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value = '')
    {
        //获取最新数据
        $data = \Cache::get(self::$key . ':' . self::$sessionKey);
        if (empty($data)) {
            return false;
        }

        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($data, $key, $value);
        }

        //过期时间
        $expires_time = $data['device'] == 'web' ? self::$expires : self::$maxExpires;

        $time = time();
        $data['expires_time'] = $time + ($expires_time * 60);
        $data['refresh_time'] = $time;
        \Cache::put(self::$key . ':' . self::$sessionKey, $data, $expires_time);
        self::$data = $data;
        return true;
    }

    /**
     * 获取数据
     * @param $key
     * @return array | bool
     */
    public static function get($key = '', $default = '')
    {
        if(empty(self::$data)){
            self::$data = \Cache::get(self::$key . ':' . self::$sessionKey);
        }
        $data = self::$data;
        if (empty($data)) {
            return false;
        }

        if (empty($key)) {
            return $data;
        }

        return Arr::get($data, $key, $default);
    }

    /**
     * 删除数据
     * @param $key
     * @return array | bool
     */
    public static function delete($key)
    {
        //获取最新数据
        $data = \Cache::get(self::$key . ':' . self::$sessionKey);
        if (empty($data)) {
            return false;
        }

        if (!empty($key)) {
            Arr::forget($data, $key);

            //过期时间
            $expires_time = $data['device'] == 'web' ? self::$expires : self::$maxExpires;

            $time = time();
            $data['expires_time'] = $time + ($expires_time * 60);
            $data['refresh_time'] = $time;

            \Cache::put(self::$key . ':' . self::$sessionKey, $data, $expires_time);
            self::$data = $data;
        }

        return true;
    }

    /**
     *  销毁
     */
    public static function destroy()
    {
        \Cache::forget(self::$key . ':' . self::$sessionKey);
        self::$data = array();
    }

    /**
     * 验证签名
     * @param $secret_key
     * @return bool
     */
    public static function checkSign($secret_key)
    {
        //验证时间
        $timestmps = intval(request()->header('X-Hztimestmps'));
        $maxtime = (time() + 60 * 30) * 1000;
        $mintime = (time() - 60 * 30) * 1000;
        if ($timestmps > $maxtime || $timestmps < $mintime) {
           return false;
        }

        $method = strtoupper(request()->method());  //请求方式
        $host_and_path = request()->getHttpHost() . request()->getPathInfo();  //获取主机
        $params = request()->input();

        $params_str = self::toUrlParams($params);

        //拼接签名字符串(请求方式/秘钥/时间戳/主机路径?请求参数)
        $src_str = $method . '/' . $secret_key . '/' . $timestmps . '/' . $host_and_path . '?' . $params_str;
        $signStr = base64_encode(md5($src_str));

        //对比签名是否正确
        if ($signStr != request()->header('X-Signingkey')) {
           return false;
        }

        return true;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public static function toUrlParams($values)
    {
        $buff = "";
        ksort($values);
        foreach ($values as $k => $v) {
            if ($v == '' || is_array($v) || is_object($v)) {
                continue;
            }

            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}
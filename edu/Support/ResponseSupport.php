<?php
namespace App\Support;


class ResponseSupport
{
    /**
     * @var \Illuminate\Http\JsonResponse||\Illuminate\Http\Response
     */
    public static $response;

    public static $data = [];

    public static $cookie = [];


    /**
     * @param $type         //json|jsonp|view Response输出类型
     * @param array $args
     * @return \Illuminate\Http\JsonResponse||\Illuminate\Http\Response
     */
    public static function getResponse($type, ...$args)
    {
        if (empty(static::$response)){
//            response()->json($data = [], $status = 200, array $headers = [], $options = 0);
            static::$response = response()->$type( ...$args );
        }
        foreach (static::$cookie as $key => $value){
            static::$response->cookie(cookie($key, $value));
        }
        if(!empty(static::$data)){
            $data = array_merge(static::$response->getData(), static::$data);
            static::$response->setData($data);
        }
        return static::$response;
    }

    /**
     * 设置输出cookie
     * @param $name
     * @param $value
     */
    public static function setCookie($name, $value){
        static::$cookie[$name] = $value;
    }

    /**
     * json输出
     * @param mixed ...$args [$data = [], $status = 200, array $headers = [], $options = 0]
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonResponse(...$args)
    {
        return static::getResponse( 'json', ...$args);
    }
}
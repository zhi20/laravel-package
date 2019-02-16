<?php
/**
 * ====================================
 * 脂20 接口
 * ====================================
 * Author: ASUS
 * Date: 2018/8/15 9:44
 * ====================================
 * Project: SDJY
 * File: Zhi20Support.php
 * ====================================
 */

namespace App\Util\Support;


use App\Util\Extend\Curl;

class Zhi20Support
{
    /**
     * 脂20 根据手机号或邮箱获取用户号信息
     * @param $data
     * @return array
     */
    public static function getUserExist($data){
        //参数为手机号或者邮箱
        $qStr = self::sortQuery($data);
        $time = time();
        $sercet = '2a1b200fc1861620eaf661e893b5ab6f';
        $sign = md5($time . $sercet . $qStr);
        $header = [
            'X-ISAPI:' . '1',
            "timestamp:" . $time,
            "appid:" . 'e51f906cc3fc38687eb841e38cfeeb6c',
            "sign:" . $sign
        ];
        $url = 'http://api.zhi20.com/one/getUserExist?';
        $url .= http_build_query($data,'','&');
        $result = Curl::get($url, $header);
        $data = json_decode($result, true);
        //存在用户信息取得对应等级，不存在默认等级为0
        if (!$data || empty($data['data'])) {
            return [];
        } else {
          return  $data['data'][0];
        }
    }

    /**
     * 脂20签名参数格式
     * @param array $query
     * @return string
     */
    private static function sortQuery(array $query)
    {
        ksort($query);
        $str = '';
        foreach ($query as $key => $val) {

            if (is_array($val) || is_object($val)) {
                continue;
            }

            $str .= $key . $val;
        }
        return $str;
    }
}
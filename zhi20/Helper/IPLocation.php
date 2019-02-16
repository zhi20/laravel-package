<?php

if (!function_exists('pconlineQuery')) {
    function pconlineQuery($ip)
    {
        load_helper('Network');
        $res = http_get('http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=' . $ip);
        if (!$res) {
            return false;
        }
        preg_match('/\{(.+?)\}/',$res,$res);

        if(!isset($res[0])){
            return false;
        }

        $res = iconv('gbk', 'utf-8', $res[0]);
        $res = json_decode($res, true);
        if (!$res || !isset($res['err']) ) {
            return false;
        }

        if($res['err'] == 'noprovince'){
            return false;
        }

        return $res;
    }
}

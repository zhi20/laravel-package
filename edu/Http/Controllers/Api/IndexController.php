<?php
/**
 * ====================================
 * 首页接口
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 14:28
 * ====================================
 * Project: SDJY
 * File: IndexController.php
 * ====================================
 */

namespace App\Http\Controllers\Api;


use extend\Curl;

class IndexController
{
    public function test(){
        $translate_googleapis_url = 'https://translate.googleapis.com/translate_a/t';
        $tkk = $this->getTkk();

//        '?anno=3&client=te&format=html&v=1.0&key&logld=vTE_20181015_01&sl=zh-CN&tl=en&sp=nmt&tc=1&sr=1&tk=658140.821138&mode=1';
        Curl::post();

//        window.google.translate.TranslateService
//        function Ou
    }


    public function getTkk()
    {
        $timeout = 10 ;
        $url = "https://translate.google.cn" ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $conts = curl_exec($ch);
        curl_close($ch);
        if(preg_match("/tkk:'([^']*)'/", $conts, $arr)){
           return $arr[1];
            //var_dump($arr);
        }else{
            return false;
        }

    }


    public function getTk()
    {
        for (var e = TKK.split("."), h = Number(e[0]) || 0, g = [], d = 0, f = 0; f < a.length; f++) {
        var c = a.charCodeAt(f);
        128 > c ? g[d++] = c : (2048 > c ? g[d++] = c >> 6 | 192 : (55296 == (c & 64512) && f + 1 < a.length && 56320 == (a.charCodeAt(f + 1) & 64512) ? (c = 65536 + ((c & 1023) << 10) + (a.charCodeAt(++f) & 1023), g[d++] = c >> 18 | 240, g[d++] = c >> 12 & 63 | 128) : g[d++] = c >> 12 | 224, g[d++] = c >> 6 & 63 | 128), g[d++] = c & 63 | 128)
        }
        a = h;
        for (d = 0; d < g.length; d++) a += g[d], a = b(a, "+-a^+6");
        a = b(a, "+-3^+b+-f");
        a ^= Number(e[1]) || 0;
        0 > a && (a = (a & 2147483647) + 2147483648);
        a %= 1E6;
        return a.toString() + "." + (a ^ h)
    }


    public function b($a, $b) {
        for ($d = 0; $d < count($b) - 2; $d += 3){
            $c = $b[$d + 2];
                $c = "a" <= $c ? c.charCodeAt(0) - 87 : Number(c),
                c = "+" == b.charAt(d + 1) ? a >>> c : a << c;
            a = "+" == b.charAt(d) ? a + c & 4294967295 : a ^ c
        }
        return a
    }

}
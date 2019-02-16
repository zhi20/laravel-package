<?php
// 应用公共文件
if (!function_exists('logic')) {
    /**
     * 获取逻辑层类
     * @param $name
     * @param string $appendSuffix
     * @return \Illuminate\Foundation\Application|\App\Logic\BaseLogic
     */
    function logic($name, $appendSuffix = 'Logic'){
        $class = '\\App\\Logic\\'.studly_case($name).$appendSuffix;
        try{
            return app($name);
        }catch (ReflectionException $e){
            app()->singleton($name, function () use($class){
                return new $class();
            });
            return app($name);
        }
    }
}

if (!function_exists('model')) {
    /**
     * 获取Model层单例类
     * @param $name
     * @param string $appendSuffix
     * @return \App\Model\BaseModel
     */
    function model($name, $appendSuffix = 'Model'){
        $name = str_replace_last($appendSuffix, '', $name);
        $class = '\\App\\Model\\'.studly_case($name).$appendSuffix;
        try{
            return app($name);
        }catch (ReflectionException $e){
            app()->singleton($name, function () use($class){
                return new $class();
            });
            return app($name);
        }
    }
}


if (!function_exists('app_log')) {
    /**
     * 日志记录函数
     * @param $name
     * @param string $message
     * @return \App\Model\BaseModel
     */
    function app_log($name, $message){

    }
}

if (!function_exists('array_map_recursive')) {
    /**
     * @param $filter
     * @param $data
     * @return array
     */
    function array_map_recursive($filter, $data)
    {
        $result = [];
        foreach ($data as $key => $val) {
            $result[$key] = is_array($val) ? array_map_recursive($filter, $val) : call_user_func($filter, $val);
        }
        return $result;
    }
}


if (!function_exists('get_random')) {
    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @param int $mode 模式：0=字母+数字，1=数字，2=字母
     * @return string
     */
    function get_random($length = 32, $mode = 0)
    {
        $chars = array(
            'abcdefghijklmnopqrstuvwxyz0123456789',
            '0123456789',
            'abcdefghijklmnopqrstuvwxyz',
        );
        $data = isset($chars[$mode]) ? $chars[$mode] : $chars[0];
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($data, mt_rand(0, strlen($data) - 1), 1);
        }
        return $str;
    }
}

if (!function_exists('format_time')) {
    /**
     * 格式化时间
     * @param array $data 需要格式的数据
     * @param string $format 时间格式
     * @return array
     */
    function format_time(&$data, $format = 'Y-m-d H:i:s')
    {
        if (empty($data)) {
            return [];
        }
        $format = empty($format) ? config('data_format') : $format;
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                format_time($data[$key], $format);
            } else {
                if (strpos($key, 'time')) {
                    switch ($item) {
                        case 0:
                            $data[$key] = '';
                            break;
                        default:
                            $data[$key] = (is_integer($item) && $item > 0) ? date($format, $item) : $item;
                    }
                }
            }
        }
        return true;
    }
}
if (!function_exists('parse_config_attr')) {
    /**
     * 分析枚举类型配置值 格式 a:名称1,b:名称2
     * @param $string
     * @return array|false|string[]
     */
    function parse_config_attr($string)
    {
        $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
        if (strpos($string, ':')) {
            $value = array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k] = $v;
            }
        } else {
            $value = $array;
        }
        return $value;
    }
}

if (!function_exists('tree')) {
    /**
     * 树状图逻辑处理
     * @param array $data
     * @param string $selected
     * @param string $type
     * @return array
     */
    function tree(&$data, $selected = '', $type = '')
    {
        if (!empty($selected)) {
            $selected = strpos($selected, ',') ? explode(',', $selected) : [$selected];
            if (!empty($data) && is_array($data)) {
                foreach ($data as &$item) {
                    $item['tree_id'] = $item['id'];
                    if (in_array($item['id'], $selected)) {
                        $item['checked'] = true;
                    }
                }
            }
        }
        $data = \App\Util\Extend\Tree::treeArray($data);
        if (in_array($type, ['select', 'parent'])) {
            $data = [
                ['id' => 0, 'text' => "", 'pid' => 0, 'children' => $data]
            ];
        }
        return $data;
    }
}

if (!function_exists('base64_to_image')) {
    /**
     * base64保存图片
     * @param $base
     * @param string $path
     * @param string $saveName
     * @return mixed|string
     */
    function base64_to_image($base , $path='' , $saveName='')
    {
        $path or $path = public_path() . DIRECTORY_SEPARATOR . 'uploads';
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base, $result)) {
            if(empty($saveName)){
                $ext = empty($result[2]) ? 'jpg' : $result[2];
                $saveName =  date('Ymd') .DIRECTORY_SEPARATOR . md5(microtime(true)) . '.'. $ext;
            }
            $fileName= $path . DIRECTORY_SEPARATOR . ltrim($saveName,DIRECTORY_SEPARATOR);
            if (!make_dir(dirname($fileName))) {
                abort(500, '无法创建目录');
            }
            if(file_put_contents($fileName, base64_decode(str_replace($result[1], '', $base))) == false){
                abort(500, '无法创建文件');
            }
            return str_replace("\\",'/',str_replace( public_path(),'',$fileName));
        }else{
            return '';
        }

    }
}



if(!function_exists('make_dir')){
    /**
     * 递归生成目录
     * 如果使用/开头则认为是使用绝对路径
     * @param $filepath
     * @return bool
     */
    function make_dir($filepath){
//    /* 路径为空返回true */
        if(empty($filepath) && 0!==$filepath && "0"!==$filepath){   // 排除0
            return true;
        }

        $reval = false;
        //1. 检查目录是否存在
        if (!file_exists($filepath)) {
            /* 如果目录不存在则尝试创建该目录 */
            @umask(0);
            //2. 检查是否有父目录
            $parentpath =  substr($filepath,0,strrpos($filepath,DIRECTORY_SEPARATOR));
            //3. 调用本身检查父目录是否存在
            $res = make_dir($parentpath);
            //4. 父目录存在则生成目录
            if($res){
                if (@mkdir(rtrim($filepath, DIRECTORY_SEPARATOR), 0755)) {
                    @chmod($filepath, 0755);
                    $reval = true;
                }
            }
        } else {
            /* 路径已经存在。返回该路径是不是一个目录 */
            $reval =  is_dir($filepath);
        }
        clearstatcache();
        //5. 目录存在返回 true
        return $reval;
    }
}

if(!function_exists('write_file')) {
    /**
     * 保存文件到本地
     * @param string $filename "./uploads/qrcode/".filename.".png"
     * @param $content //二进制内容
     * @param bool|int $cover 文件存在是否覆盖并设置写入参数 FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX
     * @return bool|int
     */
    function write_file($filename, $content, $cover = true)
    {
        //1.获取图片内容
        if (empty($filename) || empty($content)) {
            return false;
        }
        //2.判断文件是否存在
        if ($cover || !is_file($filename)) {
            //判断路径是否存在并创建
            $filepath = substr($filename, 0, strrpos($filename, DIRECTORY_SEPARATOR));
            if (make_dir($filepath)) {
                //3. 写入文件
                return file_put_contents($filename, $content, $cover);
            };
        }
        //4.返回结果
        return false;
    }
}

if(!function_exists('str_to_array')) {
    /**
     *  将中文字符串转成数组
     * @param $str
     * @return array
     */
    function str_to_array($str){
        $length = mb_strlen($str, 'utf-8');
        $array = [];
        for ($i=0; $i<$length; $i++)
            $array[] = mb_substr($str, $i, 1, 'utf-8');
        return $array;
    }
}
if (!function_exists('key_index_array')) {
    /**
     * 用数组指定键值生成新的二维数组
     * @param array $arr    二维数组
     * @param array $index
     * @param string $glue
     * @return array
     */
    function key_index_array(Array $arr, Array $index, $glue="_")
    {
        $index = array_flip($index);
        $result = [];
        foreach ($arr as $v){
            $key = implode($glue,array_intersect_key($v,$index));
            $result[$key] = $v;
        }
        return $result;
    }
}




if(!function_exists('module_url')){
    /**
     * 创建模块化路由
     * @param $url               "Admin/index/index"
     * @param array $params     ['id'=>1]
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function module_url($url, $params = [])
    {
        if(empty($url)){
            return '';
        }
        $url = explode('/', $url);
        switch (count($url)){
            case 1:
                array_unshift($url,MODULE_NAME, str_replace_last("Controller",'',CONTROLLER_NAME));
                break;
            case 2:
                array_unshift($url,MODULE_NAME);
                break;
        }
        $url = implode("/",$url);
        $url = url($url);
        if(!empty($params)){
            array_walk($params, function (&$item, $key){
                $item = $key . '=' . $item;
            });
            $url .= "?".implode('&',$params);
        }
        return $url;
    }
}

/**
 * 加载辅助函数
 * @param string $class_name
 * @return object
 */
if (!function_exists('load_helper')) {
    function load_helper($helper_name)
    {
        //先加载系统的辅助函数
        if (file_exists(__DIR__ . '/' . $helper_name . '.php')) {
            require_once __DIR__ . '/' . $helper_name . '.php';

            //如果存在则返回
            return;
        }

        //再加载App目录下heler文件夹
        if (file_exists(app_path('Helper') . '/' . $helper_name . '.php')) {
            require_once app_path('Helper') . '/' . $helper_name . '.php';

            //如果存在则返回
            return;
        }
    }
}

if (!function_exists('is_wechat')) {
    /** 是否微信打开 */
    function is_wechat()
    {
        return is_device('weixin');
    }
}

if (!function_exists('is_device')) {
    /**
     * 通过userAgent判断设备来源
     * @param $type
     * @return bool|false|int
     */
    function is_device( $type )
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        switch ($type) {
            case 'trident':         //IE内核
                return strripos($userAgent, 'Trident') !== false;
                break;
            case 'presto':          //opera内核
                return strripos($userAgent, 'Presto') !== false;
                break;
            case 'webKit':          //苹果、谷歌内核
                return strripos($userAgent, 'AppleWebKit') !== false;
                break;
            case 'gecko':           //火狐内核
                return strripos($userAgent, 'Gecko') !== false && strripos($userAgent, 'KHTML') === false;
                break;
            case 'mobile':          //是否为移动终端
                return preg_match("/AppleWebKit.*Mobile.*/", $userAgent);
                break;
            case 'ios':             //ios终端
                return preg_match("/\(i[^;]+;( U;)? CPU.+Mac OS X/", $userAgent);
                break;
            case 'android':         //android终端
                return strripos($userAgent, 'android') !== false;
                break;
            case 'iPhone':          //是否为iPhone或者QQHD浏览器
                return strripos($userAgent, 'iPhone') !== false;
                break;
            case 'iPad':            //是否iPad
                return strripos($userAgent, 'iPad') !== false;
                break;
            case 'webApp':          //是否web应用程序，没有头部与底部
                return strpos($userAgent, 'Safari') !== false;
                break;
            case 'weixin':          //是否微信
                return strpos($userAgent, 'MicroMessenger') !== false;
                break;
            case 'qq':              //是否QQ
                return preg_match("/\sQQ/i", $userAgent);
                break;
        }
        return false;
    }
}
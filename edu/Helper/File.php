<?php


if (!function_exists('list_file')) {
    /**
     * 列出目录下所有文件为一个数组 (文件名做id,文件路径作为path)
     * @param $basePath
     * @param $rootPath         //网站根目录
     * @param bool $showAll 是否遍历所有层级
     * @return array
     */
    function list_file($basePath, $rootPath, $showAll = false)
    {
        if (is_dir($basePath)) {
            $filelist = glob($basePath . DIRECTORY_SEPARATOR . "*");
            $arr = [];
            foreach ($filelist as $file) {
                $result = [];
                $result['text'] = str_replace($basePath . DIRECTORY_SEPARATOR, "", $file);
                $result['path'] = $file;
                $result['home'] = str_replace("\\", '/', str_replace($rootPath, "", $file));
                $result['children'] = [];
                $result['id'] = str_replace('/', config('SPLIT_FILE'), $result['home']);
                if (is_dir($file)) {
                    $result['state'] = 'closed';
                    if ($showAll) {
                        $result['children'] = list_file($file, $rootPath, $showAll);
                    }
                }
                $arr[] = $result;
            }
            return $arr;
        } else {
            return [];
        }

    }
}
if (!function_exists('remove_file')) {
    /**
     * 删除文件
     * @param $basePath
     */
    function remove_file($basePath){
        if(is_file($basePath)){
            unlink($basePath);
        }else if(is_dir($basePath)){
            $filelist = glob($basePath.DIRECTORY_SEPARATOR."*");
            foreach($filelist as $file){
                remove_file($file);
            }
            rmdir($basePath);
        }
    }
}

if (!function_exists('calc')) {
    /**
     * 求一个数字的最大单位表示的尺寸
     */
    function calc($size, $digits = 2)
    {
        if (empty($size)) {
            return null;
        }
        $unit = array('', 'K', 'M', 'G', 'T', 'P');
        $base = 1024;
        $i = floor(log($size, $base));
        $n = count($unit);
        if ($i >= $n) {
            $i = $n - 1;
        }
        return round($size / pow($base, $i), $digits) . ' ' . $unit[$i] . 'B';
    }
}



if (!function_exists('dir_exists')) {
    /**
     * 判断目录是否存在
     * @param string $path 目录路径
     * @return bool
     */
    function dir_exists($path)
    {
        $f = true;
        if (file_exists($path) == false) {//创建目录
            if (mkdir($path, 0777, true) == false)
                $f = false;
            else if (chmod($path, 0777) == false)
                $f = false;
        }

        return $f;
    }
}

/**
 * 复制文件夹
 * @param string $src 源文件夹
 * @param string $dst 目标文件夹
 * @param bool $is_cover 是否覆盖
 */
if (!function_exists('copy_dir')) {
    function copy_dir($src, $dst, $is_cover = false)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    copy_dir($src . '/' . $file, $dst . '/' . $file);
                    continue;
                } else {
                    if (!$is_cover) {
                        if (file_exists($dst . '/' . $file)) {
                            return false;
                        }
                    }

                    $result = copy($src . '/' . $file, $dst . '/' . $file);
                    if (!$result) {
                        return false;
                    }
                }
            }
        }
        closedir($dir);
        return true;
    }
}

/**
 * 删除文件夹
 * @param string $dir 文件夹
 * @return bool
 */
if (!function_exists('del_dir')) {
    function del_dir($dir)
    {
        //先删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if (rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
}
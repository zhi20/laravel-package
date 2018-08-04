<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Zhi20\Laravel\Signature\CacheStorage;
use Zhi20\Laravel\Signature\Mysql;
use Zhi20\Laravel\Signature\MysqlStorage;
use Zhi20\Laravel\Signature\RedisStorage;

class TestController extends Controller
{

    public function test(){

        //检测签名是否正确
        \Signature::checkSign();
    }

}

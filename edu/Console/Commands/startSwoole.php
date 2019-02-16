<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/12/17 10:33
 * ====================================
 * Project: SDJY
 * File: startSwoole.php
 * ====================================
 */

namespace App\Console\Commands;

use App\Logic\Swoole\TcpLogic;
use Illuminate\Console\Command;



class startSwoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start {model?} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量生成文件';

    protected $filelist = [];

    protected $replace =[
        'name_space'  =>'{{name_space}}',
        'class_name'  =>'{{class_name}}',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('model');
        $type = empty($type) ? 'tcp' : $type;
        switch (strtolower($type)){
            case 'tcp':
                $this->tcp();
                break;
            case 'http':
                $this->http();
                break;
            case 'websocket':
                $this->websocket();
                break;
            case 'udp':
                $this->udp();
                break;
        }

    }


    public function tcp()
    {
        //创建Server对象，监听 127.0.0.1:9501端口
        $serv = new \swoole_server("127.0.0.1", 9501);
        try{
            //监听连接进入事件
            $serv->on('connect', function ($serv, $fd) {
                echo "Client: Connect.\n";
            });
            $tcpService = new TcpLogic($serv);
            $tcpService->regReceive();
            //监听连接关闭事件
            $serv->on('close', function ($serv, $fd) {
                echo "Client: Close.\n";
            });
            //启动服务器
        $serv->start();
        }catch (\Exception $e){

        }

    }

    public function udp()
    {
        //创建Server对象，监听 127.0.0.1:9502端口，类型为SWOOLE_SOCK_UDP
        $serv = new \swoole_server("127.0.0.1", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

        //监听数据接收事件
        $serv->on('Packet', function ($serv, $data, $clientInfo) {
            $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
            var_dump($clientInfo);
        });

        //启动服务器
        $serv->start();
    }

    public function websocket()
    {
        //创建websocket服务器对象，监听0.0.0.0:9502端口
        $ws = new \swoole_websocket_server("0.0.0.0", 9502);

        //监听WebSocket连接打开事件
        $ws->on('open', function ($ws, $request) {
            var_dump($request->fd, $request->get, $request->server);
            $ws->push($request->fd, "hello, welcome\n");
        });

        //监听WebSocket消息事件
        $ws->on('message', function ($ws, $frame) {
            echo "Message: {$frame->data}\n";
            $ws->push($frame->fd, "server: {$frame->data}");
        });

        //监听WebSocket连接关闭事件
        $ws->on('close', function ($ws, $fd) {
            echo "client-{$fd} is closed\n";
        });

        $ws->start();
    }

    public function http()
    {
        $http = new \swoole_http_server("0.0.0.0", 9501);
        $http->on('request', function ($request, $response) {
            var_dump($request->get, $request->post);
            $response->header("Content-Type", "text/html; charset=utf-8");
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });

        $http->start();
    }
}
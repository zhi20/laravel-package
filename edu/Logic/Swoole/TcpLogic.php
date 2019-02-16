<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/12/19 11:38
 * ====================================
 * Project: SDJY
 * File: TcpLogic.php
 * ====================================
 */

namespace App\Logic\Swoole;


use PHPUnit\Framework\Constraint\Callback;

class TcpLogic
{

    private $service;
    //
    public function __construct($serv)
    {
       $this->service = $serv;
    }


    public function regReceive()
    {
        $this->service->on('receive', function($serv, $fd, $from_id, $data) {
            //投递异步任务
            $task_id = $serv->task($data);
            echo "Dispath AsyncTask: id=$task_id\n";
        });
    }

    public function regTask()
    {
        //处理异步任务
        $this->service->on('task', function ($serv, $task_id, $from_id, $data) {
            echo "New AsyncTask[id=$task_id]".PHP_EOL;
            //返回任务执行的结果
            $serv->finish("$data -> OK");
        });

        //处理异步任务的结果
        $this->service->on('finish', function ($serv, $task_id, $data) {
            echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
        });
    }

    public function dd()
    {

    }


}
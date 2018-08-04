<?php

namespace Zhi20\Laravel\Swoole\Http\Controllers;

use Zhi20\Swoole\Lib\Context;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //\Session::put('aaa','1111');
        dump(session('aaa'));
        $data = array();

        $config_swoole = config('swoole.register_manager');
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        $client->connect($config_swoole['host'], $config_swoole['port']);
        $message = [
            'cmd' => 'summary',
        ];
        $msg = Context::encode($message);
        $is_send = $client->send($msg);
        if ($is_send) {
            $data = Context::decode($client->recv());
        }
        $client->close();

        dump($data);

        return view('Zhi20-swoole::dashboard', array('data' => $data));
    }
}

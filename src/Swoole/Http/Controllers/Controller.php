<?php

namespace JiaLeo\Laravel\Swoole\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {

    }

}

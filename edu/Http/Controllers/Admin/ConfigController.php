<?php
/**
 * ====================================
 * 配置管理
 * ====================================
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Support\ConfigSupport;
use Illuminate\Http\Request;
use View;

class ConfigController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        //校验权限
        View::share('groupList',ConfigSupport::getConfigGroup());
        View::share('typeList',ConfigSupport::getConfigType());


    }

    public function setting()
    {

        if (request()->ajax()) {
            $config = request()->post();
            $result = logic($this->logicName)->setting($config);
            if ($result) {
                return $this->success( logic($this->logicName)->getInfo());
            } else {
                return $this->error( logic($this->logicName)->getError());
            }
        } else {
            $list =  logic($this->logicName)->getList();
            return view(VIEW_NAME,['list'=>$list]);
        }
    }
}
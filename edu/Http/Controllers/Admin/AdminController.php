<?php
/**
 * ====================================
 * 管理员管理
 * ====================================
 * Author: 9004396
 * Date: 2017-11-22 18:32
 * ====================================
 * Project: ggzy
 * File: Admin.php
 * ====================================
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AdminController extends BaseController
{

    public function information(Request $request)
    {
        $logic = logic('Admin\Admin');
        if ($request->isMethod('post')) {
            $result = $logic->modifyPassword();
            if ($result) {
                return $this->success($logic->getInfo());
            } else {
                return $this->error($logic->getError());
            }
        } else {
            $info = $logic->getManageInfo();
            if(method_exists($info,'toArray')){
                $info = $info->toArray();
            }
            return view('Admin/Admin/information', $info);
        }
    }


    public function log()
    {
        $this->logicName = 'Admin\AdminLog';
//        $this->logic->setData(\request()->all());
        return $this->index();
    }




}
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    protected $isTree = true;

    public function power()
    {
        $request = \request();
        if ($request->ajax()) {
            $powerLogic =  logic('Admin\Power');
            $powerLogic->setData($request->all());
            $result = $powerLogic->setPower();
            if($result){
                return $this->success($powerLogic->getInfo());
            }else{
                return $this->error($powerLogic->getError());
            }
        }
//        $menuLogic = logic('Admin\Menu');
//        $menuLogic->setData($request->all());
//        $menuLogic->lists($this->isTree);
        return view(VIEW_NAME);
    }
}
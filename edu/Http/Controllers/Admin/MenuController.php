<?php
/**
 * ====================================
 * 菜单管理
 * ====================================
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    protected $isTree = true;


    public function getSearchData()
    {
        return logic($this->logicName)->getSearchData();
    }


    public function icon()
    {
       return view(VIEW_NAME);
    }
}
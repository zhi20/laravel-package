<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/23 16:30
 * ====================================
 * Project: SDJY
 * File: CategoryLogic.php
 * ====================================
 */

namespace App\Logic\Admin;


use App\Logic\BaseLogic;

class CategoryLogic extends BaseLogic
{

    public function _after_lists(){
        \extend\Tree:: $pid = 'parent_id' ;          // tree 根据parent_id分层
    }



    public function _after_select($data)
    {
        if(isset($this->data['isstree']) && !empty($this->data['isstree'])){
            \extend\Tree:: $pid = 'parent_id' ;          // tree 根据parent_id分层
            tree($data);
        }

        return $data;
    }
}
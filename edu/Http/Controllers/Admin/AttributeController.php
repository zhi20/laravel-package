<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/9/5 16:21
 * ====================================
 * Project: SDJY
 * File: AttributeController.php
 * ====================================
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;

class AttributeController extends BaseController
{

    public function setValue(){
        $id = request('id');
        $value = request('value');
        logic($this->logicName)->setData(['id'=>$id, 'value'=>$value]);
        $result = logic($this->logicName)->save();
        if ($result) {
            return $this->success(logic($this->logicName)->getInfo());
        } else {
            return $this->error(logic($this->logicName)->getError());
        }
    }
}
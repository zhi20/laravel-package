<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/16 11:36
 * ====================================
 * Project: SDJY
 * File: UserLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use App\Logic\BaseLogic;
use App\Support\LoginSupport;

class UserLogic extends BaseLogic
{

    public function _before_info()
    {
//        $this->data = $this->verify([
//
//        ],'GET');
        $this->data['id'] = LoginSupport::getUserId();
        $model = $this->getModel();
        $query = $model->getQueryModel();
        $query->addSelect(['id',"email","headimg","username","nickname","phone","birthday","sex","desc"]);
    }

    public function _after_info($data){
        //TODO.. 头像加域名
        if(isset($data['headimg'] ) && !empty($data['headimg'] )){
            $data['headimg'] = request()->getUriForPath($data['headimg']);
        }
        return $data;
    }

    public function _before_save(){
        $this->data['id'] = LoginSupport::getUserId();
    }
}
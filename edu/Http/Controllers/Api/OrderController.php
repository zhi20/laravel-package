<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/18 14:16
 * ====================================
 * Project: SDJY
 * File: OrderController.php
 * ====================================
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{

    /**
     * 准备购买 -- 购买流程第一步  -- 之后进入模块流程控制  --生成订单操作也是在相应分类模块中独立的。只有第一步是在这里开始的。
     */
    public function unifiedOrder(){
        $data = $this->verify([
            'category_id' => 'egnum',
            'goods_id' => 'egnum',
        ], 'POST');

        $result = [

        ];
        return $this->success('OK',$result);
    }


    public function test(){
       return logic('Api\Pay')->wechatPay();
    }

}
<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 11:22
 * ====================================
 * Project: SDJY
 * File: GoodsController.php
 * ====================================
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;

class GoodsController extends BaseController
{

    /** 获取商品分类列表
     *
     * @throws \App\Exceptions\ApiException
     */
    public function getGoodsTypeList(){
         $this->verify([
            'category_id' => 'egnum',
        ], 'POST');

        logic('Api\GoodsType')->setData('locked',0);
        logic('Api\GoodsType')->setData('field',[ "id","text","parent_id","category_id","level"]);
        $data = logic('Api\GoodsType')->select();
        return $this->success('OK', $data);
    }
}
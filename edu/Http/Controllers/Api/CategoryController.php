<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 14:29
 * ====================================
 * Project: SDJY
 * File: CategoryController.php
 * ====================================
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Logic\Api\CategoryLogic;

class CategoryController extends BaseController
{


    /** 获取分类推荐商品 */
    public function getRecommendGoods(){
//        $data = $this->verify([
//            'category_id' =>'',
//            'rows' =>'no_required',
//        ], 'POST');
        $data = ['category_id'=>1];
        $result = CategoryLogic::getRecommendGoods($data);
        return $this->success('OK',$result);
    }

    /**
     *  获取列表信息
     */
    public function lists(){
        $data =logic($this->logicName)->select();
        if(false === $data){
            $message = logic($this->logicName)->getError('Error');
            return $this->error($message);
        }else{
            $message = logic($this->logicName)->getInfo('OK');
            return $this->success($message,$data);
        }

    }
}
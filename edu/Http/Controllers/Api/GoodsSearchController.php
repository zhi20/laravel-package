<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 15:30
 * ====================================
 * Project: SDJY
 * File: GoodsSearchController.php
 * ====================================
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Logic\Api\GoodsSearchLogic;
use App\Model\GoodsSearchModel;
use App\Support\LoginSupport;

class GoodsSearchController extends BaseController
{

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function hotSearch(){
        $data  =  $this->verify([
            'category_id'=>'no_required',
            'rows'=>'no_required'
        ],'POST');
        $logic=logic($this->logicName);
        $logic->setData($data);
        $logic->setData('type', GoodsSearchModel::TYPE_HOT);
        $logic->setData('field', ['goods_name', 'goods_id','category_id']);
        $logic->setData('orderby', 'desc');
        $result = $logic->select();
        if(false === $result){
            return $this->error($logic->getError());
        }else{
            return $this->success($logic->getInfo(), $result);
        }
    }

    /**
     * @throws \App\Exceptions\ApiException
     */
    public function historySearch(){
        $data  =  $this->verify([
            'category_id'=>'no_required',
            'rows'=>'no_required'
        ],'POST');
        $data['user_id'] = LoginSupport::getUserId();
//        $data['rows'] = 10;
        $data['field'] = ['keyword','category_id'];
        $result = GoodsSearchLogic::getHistorySearch($data);
        return $this->success('OK',$result);
    }
}
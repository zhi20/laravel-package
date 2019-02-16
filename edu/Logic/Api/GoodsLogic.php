<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 11:22
 * ====================================
 * Project: SDJY
 * File: GoodsLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use App\Logic\BaseLogic;
use App\Model\UserSearchGoodsLinkedModel;
use App\Support\LoginSupport;

class GoodsLogic extends BaseLogic
{
    /**
     * $this->lists查询结果格式化处理
     * @param $data
     * @return array
     */
    public function format($data){

        return $data;
    }

    public function _after_lists($result){
        //用户搜索后记录搜索记录
        if( isset($this->data['keyword']) ){
            $model = new UserSearchGoodsLinkedModel();
            $data = [
                'user_id'=>LoginSupport::getUserId(),
                'keyword'=>$this->data['keyword'],
            ];
            if(isset($this->data['category_id'])){
                $data['category_id'] = $this->data['category_id'];
            }
            $model->filter($data);
            //有则更新
            if($id = $model->getQueryModel()->value('id')){
                $data['id'] = $id;
                $model->exists = true ;
            }
            $model->setValue($data);
            $model->save();
        }
    }
}
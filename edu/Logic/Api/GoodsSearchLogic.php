<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/17 15:37
 * ====================================
 * Project: SDJY
 * File: GoodsSearchLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use App\Logic\BaseLogic;
use App\Model\GoodsSearchModel;

class GoodsSearchLogic extends BaseLogic
{

    public static function getHistorySearch($data)
    {
        $model = model('UserSearchGoodsLinked');
        if (method_exists($model, 'filter')) {
            $model->filter($data);
        }
        $field = [];
        if(isset($data['field'])){
            $field =$data['field'];
        }
        $query = $model->getQueryModel();
        $query->orderBy('updated_at', 'desc');
        if(isset($data['rows'])){
            $query->limit($data['rows']);
        }
        $data = $model->getAll([],$field);
        return $data;

    }

    public function _before_select(){
        if( isset($this->data['rows'])){
            $model = $this->getModel();
            $query = $model->getQueryModel();
            $query->limit($this->data['rows']);
        }
    }
}
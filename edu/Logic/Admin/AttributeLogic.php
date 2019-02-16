<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/9/5 16:22
 * ====================================
 * Project: SDJY
 * File: AttributeLogic.php
 * ====================================
 */

namespace App\Logic\Admin;


use App\Logic\BaseLogic;
use App\Model\AttributeTypeModel;

class AttributeLogic extends BaseLogic
{
    /** 格式化_lists结果 */
    public function format($data)
    {
        if(isset($data['rows'])){
            $data['rows'] = $this->_format($data['rows']) ;
        }else{
            $data = $this->_format($data) ;
        }
        return $data;
    }

    /** 格式化数据 */
    private function _format($data)
    {
        if(empty($data)){ return []; }
        $type_id = array_column($data, 'type');
        $types = AttributeTypeModel::query()->whereIn('id',$type_id)->get(['id','text'])->pluck('text', 'id');
        foreach ($data as $key => $item){
            $data[$key]['type_text'] = $types[$item['type']] ?? '';
        }
        return $data;
    }
}
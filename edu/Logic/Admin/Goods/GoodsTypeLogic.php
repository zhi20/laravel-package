<?php
namespace App\Logic\Admin\Goods;

use App\Logic\BaseLogic;
use App\Model\CategoryModel;
use App\Model\GoodsTypeModel;

class GoodsTypeLogic extends BaseLogic
{
    //
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
        if(empty($data)){
            return [];
        }
        $category_id  = array_column($data, 'category_id');
        $categorys = CategoryModel::query()->whereIn('id', $category_id)->get(['id', 'text'])->pluck('text', 'id');
        foreach ($data as $key => $item){
            $data[$key]['category_text'] = $categorys[$item['category_id']];
        }
        return $data;
    }

    public function _before_save(){
        if($parent_id = $this->getData('parent_id')){
           $level =  GoodsTypeModel::query()->where('id', $parent_id)->value('level');
            $this->data['level'] = intval($level)+1;
        }
    }


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
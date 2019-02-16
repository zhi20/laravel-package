<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Model\CategoryModel;

class ModuleLogic extends BaseLogic
{
    //
    /** 格式化_lists结果 */
    public function format($data)
    {
        if(isset($data['rows'])){
            $data = $this->_format($data['rows']) ;
        }else{
            $data = $this->_format($data) ;
        }
        return $data;
    }

    /** 格式化数据 */
    private function _format($data)
    {
        $category = CategoryModel::get(['id','text'])->pluck('text','id');
        foreach ($data as $key =>$item){
            $data[$key]['category_name'] = $category[$item['category_id']];
        }
        return $data;
    }

    public function _before_save()
    {
        if(isset($this->data['category_id']) && !isset($this->data['category_code'])){
            $code = CategoryModel::query()->where('id', $this->data['category_id'])->value('code');
            $this->setData('category_code', $code);
        }
    }
}
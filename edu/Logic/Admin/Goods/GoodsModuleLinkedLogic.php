<?php
namespace App\Logic\Admin\Goods;

use App\Logic\BaseLogic;
use App\Model\ModuleModel;

class GoodsModuleLinkedLogic extends BaseLogic
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
        $category_id = $this->getData('category_id');
        $module = ModuleModel::query()->where('category_id', $category_id)->where('locked', 0)->get(
            ['id','text','category_id', 'category_code', 'class', 'action']
        )->toArray();
        $data = collect($data)->keyBy('module_id')->toArray();

        foreach ($module as $key => $item){
            if(isset($data[$item['id']])){
                $module[$key] = array_merge($item, $data[$item['id']]);
            }else{
                $module[$key]['module_id'] = $item['id'];
                unset($module[$key]['id']);
            }
        }
        return $module;
    }



}
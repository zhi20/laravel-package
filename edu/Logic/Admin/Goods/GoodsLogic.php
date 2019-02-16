<?php
namespace App\Logic\Admin\Goods;

use App\Logic\BaseLogic;
use App\Model\CategoryModel;
use App\Model\GoodsTypeModel;
use App\Model\RecommendModel;

class GoodsLogic extends BaseLogic
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
        //取分类名称
        $category_id  = array_column($data, 'category_id');
        $categorys = CategoryModel::query()->whereIn('id', $category_id)->get(['id', 'text'])->pluck('text', 'id');
        //取栏目名称
        $goods_type_id  = array_column($data, 'goods_type_id');
        $goods_types = GoodsTypeModel::query()->whereIn('id', $goods_type_id)->get(['id', 'text'])->pluck('text', 'id');
        //取推荐位名称
        $recommend_id  = array_column($data, 'recommend_id');
        $recommends = RecommendModel::query()->whereIn('id', $recommend_id)->get(['id', 'text'])->pluck('text', 'id');
        foreach ($data as $key => $item){
            $data[$key]['category_text'] = $categorys[$item['category_id']];
            $data[$key]['goods_type_text'] = $goods_types[$item['goods_type_id']];
            $data[$key]['recommend_text'] = $recommends[$item['recommend_id']];
        }
        return $data;
    }
}
<?php
namespace App\Logic\Api;


use App\Logic\BaseLogic;
use App\Model\GoodsModel;
use App\Model\RecommendModel;

class CategoryLogic extends BaseLogic
{

    /** 获取推荐商品
     * @param $data
     * @return array
     */
    public static function getRecommendGoods($data){
        $recommendId = RecommendModel::CATEGORY_RECOMMEND;      //分类推荐
        $limit = $data['rows'] ?? 5;
        $categoryId = $data['category_id'] ?? 5;
        $result = GoodsModel::where('recommend_id', $recommendId)
            ->where('locked',0)
            ->where('category_id',$categoryId)
            ->select(['*'])
            ->orderBy('orderby','desc')
            ->orderBy('id','desc')
            ->limit($limit)
            ->get();
        return $result->toArray();
    }


}
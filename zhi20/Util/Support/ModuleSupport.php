<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/18 15:57
 * ====================================
 * Project: SDJY
 * File: ModuleSupport.php
 * ====================================
 */

namespace App\Util\Support;


use App\Exceptions\ApiException;
use App\Model\CategoryModel;
use App\Model\GoodsModel;
use App\Model\GoodsTypeModel;

class ModuleSupport
{
    const MODULE_NAME = 'Module';

    //控制流程是否完成常量  completed
    const PROCESS_UNDONE = 0;               //未完成
    const PROCESS_COMPLETED = 1;            //已完成
    const PROCESS_NO = 2;                   //没有控制流程
    //控制流程用户参与常量   is_user
    const NEED_AUTO = 0;                    //自动判断是否需要用户参与
    const NEED_USER = 1;                    //需要用户参与
    const NEED_NO = 2;                      //无需用户参与


    public static function getParams($categoryCode, $module='',$params=[])
    {
        if(empty($module)){
            $module = ucfirst($categoryCode) .'\\'. CONTROLLER_NAME . '@' . ACTION_NAME;
        }
        $module = explode('@', $module);
        $class = $module[0];
        $action = $module[1];
        $class = module_collect($class);
        $class->setData($params);
        return $class->$action();
    }


    /**
     *  获取商品流程控制模块
     * @param $goodsId
     * @return mixed
     * @throws ApiException
     */
    public static function getProcess($goodsId){
        $goodsInfo =    GoodsModel::where('goods_id', $goodsId)->first(['goods_type_id','category_id','process_module'])->toArray();
        if(empty($goodsInfo)){
            throw new ApiException('商品不存在');
        }
        $processModule = json_decode($goodsInfo['process_module'],true);
        if(empty($processModule)){
            //商品没有取商品分类的
            $processModule =  GoodsTypeModel::where('id', $goodsInfo['goods_type_id'])->value('process_module');
            $processModule = json_decode($processModule, true);
        }
        if(empty($processModule)){
            //商品分类没有取分类的
            $processModule =  CategoryModel::where('id', $goodsInfo['category_id'])->value('process_module');
            $processModule = json_decode($processModule, true);
        }
        return $processModule;
    }
}
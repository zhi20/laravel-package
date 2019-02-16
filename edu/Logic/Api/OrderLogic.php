<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/18 14:36
 * ====================================
 * Project: SDJY
 * File: OrderLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use App\Logic\BaseLogic;
use App\Model\CategoryModel;
use App\Model\GoodsModel;
use App\Model\ModuleModel;
use App\Model\OrderGoodsModel;
use App\Model\OrderModel;
use App\Support\ModuleSupport;

class OrderLogic extends BaseLogic
{

    /**
     * @return array|bool
     * @throws \App\Exceptions\ApiException
     */
    public function unifiedOrder()
    {
        $categoryId = $this->getData('category_id');
        $goodsId = $this->getData('goods_id');
        if(empty($categoryId) || empty($goodsId)){
            return false;
        }
        $categoryCode = CategoryModel::where('id', $categoryId)->value('code');
        //返回结果
        $result = [
            'goods_id'=>$goodsId,                               //商品id
            'category_id'=>$categoryId,                         //分类
            'category_code'=>$categoryCode,                     //分类简码
            'module'=>'',                                       //下一步模块
            'completed'=>ModuleSupport::PROCESS_UNDONE          //是否已完成
        ];
        //1.先取商品的流程控制模块
        $processModule = ModuleSupport::getProcess($goodsId);
        //没控制流程直接返回完成
        if(empty($processModule)){
            $result['completed'] = ModuleSupport::PROCESS_NO;
            return $result;
        }
        //2.弹出第一个并判断是否已完成以及是否需要用户操作
        $module = array_shift($processModule);    //['is_user'=>1,'module'=>class@action,'key'=>1]
        if($module[ModuleModel::PROCESS_FIELD_IS_USER] == ModuleSupport::NEED_USER){
            //需要用户操作
            $result['module'] = $module[ModuleModel::PROCESS_FIELD_MODULE];
            return $result;
        }else{
            //2.1 自动判断参数是否完整.(在获取参数模块中先检查数据库是否有数据 没有数据才需要用户操作)
            $data =ModuleSupport::getParams($categoryCode, $module[ModuleModel::PROCESS_FIELD_MODULE],$this->data);
            if(false === $data && $module[ModuleModel::PROCESS_FIELD_IS_USER] == ModuleSupport::NEED_AUTO){
                //需要用户输入参数返回当前模块名称
                $result['module'] = $module[ModuleModel::PROCESS_FIELD_MODULE];
                return $result;
            }else{
                //TODO... 相关模块控制操作未完成中。。。
                // 自动执行调用模块执行操作
                $module = explode('@', $module);
                $class = ModuleSupport::MODULE_NAME .'\\'. $module[0];
                $action = $module[1];
                $class = logic($class);
                $class->setData($data);
                return $class->$action();           //返回模块执行结果
            }
        }
    }



    public function createOrder()
    {
        //订单验证
        //创建订单
//        $order = [
//            'order_sn'=> $orderSn ,
//            'user_id'=> $userId ,
//            'status'=> 0 ,
//            'category_id'=>$goodsDetails['type'] ,
//            'pay_code'=>'wechat_pay' ,
//            'pay_status'=>0 ,
//            'total_price'=>$goodsDetails['price'] ,
//            'actual_price'=>$actualPrice ,
//            'remark'=>json_encode($goodsDetails['desc']),
//            'attributes' => json_encode(['prepayId'=>$prepayId]),
//        ];
        \DB::beginTransaction();
        $orderInfo = model('order');
        $orderInfo->setValue($this->data);
        if(!$orderInfo->save()){
            \DB::rollBack();
            return false;
        }
        //添加商品
//        $data = [
////            'user_id'=> $userId,
////            'order_id'=> $orderInfo->id ,
////            'goods_id'=> $goodsDetails['id'],
////            'category_id'=> $goodsDetails['type'],
////            'goods_type_id'=>  $goodsDetails['subtype'],
////            'num'=> 1,
////            'goods_name'=>  $goodsDetails['name'],
////            'goods_sn'=> $goodsDetails['goods_sn'],
////            'price'=> $goodsDetails['price'] ,
////            'real_price'=> $actualPrice,
////            'remark'=>json_encode($goodsDetails['desc']),
////        ];
        $orderGoods =  model('OrderGoods');
        $orderGoods->setValue($this->data);
        if(!$orderGoods->save()){
            \DB::rollBack();
            return false;
        }
        \DB::commit();
        //添加
        return true;
    }

}
<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/21 15:41
 * ====================================
 * Project: SDJY
 * File: PayLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use aggregation\pay\WeChatJsApi;
use App\Logic\BaseLogic;
use App\Model\GoodsModel;
use App\Model\OrderModel;
use App\Model\PayModel;
use App\Model\PayOrderModel;
use App\Model\WechatAccountModel;
use App\Support\LoginSupport;
use App\Support\LogSupport;
use App\Support\WechatSupport;

class PayLogic extends BaseLogic
{
    protected $pay;         //支付对象

    /**
     * 微信支付预下单接口
     */
    public function wechatPay()
    {
        $openid = LoginSupport::getUserInfo('openid');
        $userId = LoginSupport::getUserInfo('user_id');
        $product_id = $this->getData('product_id',0);           //产品id goods_id
        $total_fee = $this->getData('total_fee',0);             //支付金额 分
        $body = $this->getData('body','');
        $orderSn = $this->getData('out_trade_no','');
        $attach = $this->getData('attach','');
        if(empty($userId) || empty($product_id) || empty($total_fee)){
            return false;
        }
//        $orderSn = 'exam'.date('YmdHis').str_pad(date("His")^$userId,6,'0',STR_PAD_LEFT);
        $this->pay = new WeChatJsApi();
        $config = WechatSupport::getConfig(WechatAccountModel::SDJY);
        $config = array_intersect_key($config,$this->pay->setup());
//        $config = [
//            "app_id"=>$config['app_id'],
//            "machine_id"=>$config['machine_id'],
//            "pay_key"=>$config['pay_key'],
//            "app_secret"=>$config['app_secret'],
//        ];
        $config['notify_url'] = url('pay/wechat/notify');
        $this->pay->init($config);
        $data = [
            'body'=>$body,
            'out_trade_no' =>   $orderSn,            //商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。详见商户订单号
            'total_fee' =>   $total_fee ,            //订单总金额，单位为分，详见支付金额
            'product_id' =>   $product_id,            //产品id
            'fee_type' =>   'CNY',
            'attach'    => '',
            'goods_tag'    => '',
        ];
        try{
            $order = $this->pay->pay($data,$openid);         // 统一下单
            if($order['return_code'] != 'SUCCESS' || $order['result_code'] != 'SUCCESS'){
                dd($order);
                LogSupport::payLog('微信下单失败', $order, 0);
                return false;
            }
        }catch (\aggregation\lib\wechat\WxPayException $e){
            LogSupport::payLog('微信下单失败', $data, 0);
            return false;
        }
//        //创建支付订单   -- 在调用这个接口后面执行
//        $pay = new PayOrderModel();
//        $data = [
//            'user_id' => $userId,
//            'pay_code' => PayModel::WECHATPAY,
//            'order_sn' => $orderSn,
//            'table'   =>  'order',
//            'table_id'=>  $orderId,
//            'amount'  =>  $actual_price,
//        ];
//        $pay->setValue($data);
//        if(!$pay->save()){
//            return false;
//        }
        $result = $this->pay->setSign('prepay_id='.$order['prepay_id'], $order['nonce_str']);
        return $result;
    }

    public function wechatNotify()
    {
        $orderSn = $this->getData('out_trade_no','');
        $attach = $this->getData('attach','');
        $totalFee = $this->getData('total_fee',0);             //支付金额 分
        $out_order_sn = $this->getData('transaction_id',0);             //支付金额 分
        \DB::beginTransaction();
        $orderInfo = OrderModel::query()->where('order_sn', $orderSn)->lockForUpdate()->first();
        if ($orderInfo->pay_status != 0 || $totalFee != ($orderInfo->actual_price)*100 ) {
            //订单不是待付款 或者金额不对直接结束//todo价格*100
            \DB::rollBack();
            return false;
        }
        // 成功后修改订单已支付
        data_set($orderInfo,'status',1);     //支付成功
        data_set($orderInfo,'out_order_sn',$out_order_sn);     //支付单号
        data_set($orderInfo,'pay_status',1);     //支付成功
        data_set($orderInfo,'pay_time',date("Y-m-d H:i:s"));     //支付时间
        data_set($orderInfo,'attributes',json_encode([]));//清空预支付订单id
        //完成支付订单
//        $pay = PayOrderModel::where('order_sn',$orderSn)->first();
        if($orderInfo->save()){
            \DB::commit();
        }else{
            //纪录日志。。
            $str = "===========START================\n";
            $str .= "开始时间：".date('Y-m-d H:i:s',time())."\n";
            $str .= "DATA：".var_export(request()->all(),true)."\n";
            $str .= "==========END===================\n\n";
            LogSupport::payLog($str, $orderInfo, 3, data_get($orderInfo,'user_id'));
            \DB::rollBack();
        }

        //根据分类处理支付完成后模块
        switch ($orderInfo->category_id){
            case 1:         //考试
                //TODO...

        }
        // 添加账单
//       event(new \App\Events\BillsExpensesEvent());
//       event(new \App\Events\BillsIncomeEvent());
        //微信和短信通知支付成功
//       event(new \App\Events\SmsNotifyEvent());
//       event(new \App\Events\WechatNotifyEvent());
    }
}
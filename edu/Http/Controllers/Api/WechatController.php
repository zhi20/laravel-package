<?php
namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Support\WechatSupport;

class WechatController extends Controller
{

    /* 接收微信推送过来的信息 */
    public function index()
    {
        $wechatAccount = request("accountid", 1);         //根据传入的wechat_account->id
        if(!empty($wechatAccount)){
            \extend\Wechat::init(WechatSupport::getConfig($wechatAccount));
        }
        $str = "===========START================\n";
        $str .= "开始时间：".date('Y-m-d H:i:s',time())."\n";
        $str .= "访问IP：".request()->ip()."\n";
        $str .= "账户类型：".$wechatAccount."\n";
        if(isset($GLOBALS['HTTP_RAW_POST_DATA'])){
            $str .= "GLOBALS方式：".$GLOBALS['HTTP_RAW_POST_DATA']."\n";
        }
        $str .= "INPUT方式：".file_get_contents("php://input")."\n";
        $str .= "DATA：".var_export(\extend\Wechat::getData(),true)."\n";
        /* ======验证微信公众号接入=====  */
        $result = WechatSupport::checkSignature();
        if(false !== $result){
            echo $result;             //直接输出
            exit;
        }
        try{
            /*==== 保存操作记录=====**/
//            register_shutdown_function();        //脚本结束后执行
        }catch (\Exception $e){

        }
        $MsgType = \extend\Wechat::getData("MsgType");
        switch($MsgType){
            /* =======接收事件推送 Event事件在wechatEvent中处理====== */
            case 'event':
                //TODO... 触发微信事件监听
//                event(new );
                break;
            default:
        }
        echo '';
        exit;  //回复文本给微信
    }

    //支付结果
    public function notify()
    {

    }

}

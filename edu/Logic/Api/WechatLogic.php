<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/8 15:13
 * ====================================
 * Project: SDJY
 * File: WechatLogic.php
 * ====================================
 */

namespace App\Logic\Api;


use App\Model\UserModel;
use App\Model\WechatAccountModel;
use App\Model\WechatUserModel;
use App\Support\AuthSupport;
use App\Support\WechatSupport;
use extend\Wechat;

class WechatLogic
{
    /**
     * 微信登录使用openid识别，只有绑定手机号后才会有user_id, 所以在中间件做登录验证时需要区分来源
     * @return bool|redirect
     */
    public static function wechatLogin()
    {
        //获取微信授权
        if(
            WechatSupport::getOauthUserInfo(WechatAccountModel::SDJY, $data = [])){
            if(isset($data['url'])){
                return redirect($data['url']);
            }
            //检查用户是否存在
            $wechatUser = WechatUserModel::where('openid'
                                      ,$data['openid'])
                ->where('wechat_account_id',WechatAccountModel::SDJY)->first(['id','user_id']);
            $wechatUserModel = new WechatUserModel();
            $wechatUserModel->setValue($data);
            if(empty($wechatUser)){
                //添加微信用户
                $wechatUserModel->setValue('wechat_account_id',WechatAccountModel::SDJY);
                $wechatUserModel->save();
            }else{
                //修改
                $wechatUserModel->setValue('id',$wechatUser->id);
                $wechatUserModel->exists = true;
                $wechatUserModel->save();
            }
            AuthSupport::set('openid',$data['openid']);
            AuthSupport::set('unionid',$data['unionid']);
            if(isset($wechatUser->user_id) && !empty($wechatUser->user_id)){
                //已有用户自动登录
                AuthSupport::set('user_id',$data['user_id']);
            }
        }
        return true;
    }
}
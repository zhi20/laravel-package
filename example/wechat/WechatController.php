<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;


class WechatController extends Controller
{

    public function index()
    {
        \Wechat::valid();

        $type = \Wechat::getRev()->getRevType(); // 获取数据类型
        $data = \Wechat::getRev()->getRevData(); // 获取微信服务器发来的信息

        switch ($type) {
            case app('wechat')::MSGTYPE_TEXT : // 文本类型
                // 记录文本消息到数据库

                //---特殊操作优先---

                // 关键字回复

                //自动回复
                \Wechat::text("hello")->reply();

                break;
            case app('wechat')::MSGTYPE_EVENT : // 事件类型
                if ($data ['Event'] == "subscribe") { // 关注事件
                    //记录关注事件

                    //添加粉丝操作

                    //扫码关注操作

                    //关注回复

                } elseif ($data ['Event'] == "unsubscribe") { // 取消关注事件
                    //记录取消关注事件

                    //粉丝操作

                } elseif ($data ['Event'] == "LOCATION") { // 获取上报的地理位置事件
                    //记录用户自动上传的地址位置

                } elseif ($data ['Event'] == "CLICK") { // 自定义菜单
                    // 记录自定义菜单消息

                    //菜单点击事件
                    $event_key = $data ["EventKey"];

                } elseif ($data ['Event'] == "VIEW") { // 点击菜单跳转链接时的事件推送
                    // 记录自定义菜单消息

                } elseif ($data['Event'] == "SCAN") {   //扫二维码进入公众号
                    // 记录自定义菜单消息

                } elseif (!empty($data['KfAccount'])) {  //客服时间

                }
                break;
            case app('wechat')::MSGTYPE_IMAGE : // 图片类型
                // 记录图片消息

                break;
            case app('wechat')::MSGTYPE_LOCATION : // 地理位置类型
                \Wechat::text("地理位置已接收")->reply();
                break;

            case app('wechat')::MSGTYPE_LINK : // 链接消息
                \Wechat::text("链接消息已接收")->reply();
                break;
            default :
                \Wechat::text("help info")->reply();
        }
    }

    /**
     * 微信授权
     * @return array|bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auth()
    {
        $this->verify([
            'token' => '',
            'callback' => '',
            'type' => 'in:mp:app:web|no_required'
        ], 'GET');

        $data = $this->verifyData;

        /**
         * callback_path : 回调地址的path,为contrller的路径
         * is_oauth_user_info : 是否通过授权获取用户信息
         * check_for : 通过openid或unionid
         * check_user_model : 检查用户是否存在的model类
         * check_user_function : 检查用户是否存在的model类里面的function,方法中,如果存在必须返回用户信息数组,且包含uid字段,不存在则返回false
         * oauth_get_user_silent_function : 授权获取到用户openid,且调用check_user_function后不返回false,则运行这个回调函数
         * oauth_get_user_info_function : 创建新用户回调函数
         * create_user_function : 授权成功后,创建seesion回调函数
         * type : 配置来源
         */
        $params = array(
            'token' => $data['token'],
            'callback_path' => 'v1_0/api/login/auth',       //回跳地址的path,为contrller的路径
            'is_oauth_user_info' => true,                       //是否通过授权获取用户信息
            'check_for' => 'openid',                            //通过openid或unionid
            'create_user_function' => array($this, 'create_user_function'),                 //创建新用户
            'oauth_get_user_silent_function' => array($this, 'oauth_get_user_silent_function'),        //静默授权获取到用户openid或unionid的回调函数
            'oauth_get_user_info_function' => array($this, 'oauth_get_user_info_function'),         //授权获取到用户信息的回调函数
        );

        //默认是公众号类型
        $params['type'] = empty($data['type']) ? 'mp' : $data['type'];

        $weObj = new \JiaLeo\Wechat\WechatOauth($params);
        return $weObj->run();
    }

    /**
     * 创建新用户
     * @param array $user_info 用户信息 示例如下:
     * {
     * "openid":" OPENID",
     * " nickname": NICKNAME,
     * "sex":"1",
     * "province":"PROVINCE"
     * "city":"CITY",
     * "country":"COUNTRY",
     * "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ
     * 4eMsv84eavHiaiceqxibJxCfHe/46",
     * "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
     * "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
     * }
     *
     * @return int $id 用户id
     */
    public function create_user_function($user_info)
    {
        load_helper('Network');

        \DB::beginTransaction();

        $user_model = new \App\Model\UserModel();
        set_save_data($user_model, [
            'username' => $user_info['nickname'],
            'last_login_ip' => get_client_ip(),
            'headimg' => $user_info['headimgurl'],
        ]);
        $result = $user_model->save();
        if (!$result) {
            \DB::rollBack();
            throw new ApiException('数据库错误!');
        }

        $user_id = $user_model->id;

        $user_auth_oauth = new \App\Model\UserAuthOauthModel();
        set_save_data($user_auth_oauth, [
            'user_id' => $user_id,
            'id1' => $user_info['openid'],
            'id2' => isset($user_info['unionid']) ? $user_info['unionid'] : ''
        ]);
        $result = $user_auth_oauth->save();
        if (!$result) {
            \DB::rollBack();
            throw new ApiException('数据库错误!');
        }

        \DB::commit();

        return $user_id;
    }

    /**
     * 显性授权后操作function
     * @param int $user_id 用户id
     * @param array $user_info 用户信息 示例如下
     * {
     * "openid":" OPENID",
     * " nickname": NICKNAME,
     * "sex":"1",
     * "province":"PROVINCE"
     * "city":"CITY",
     * "country":"COUNTRY",
     * "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ
     * 4eMsv84eavHiaiceqxibJxCfHe/46",
     * "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
     * "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
     * }
     * @return
     */
    public function oauth_get_user_info_function($user_id, $user_info)
    {
        \Jwt::set('user_info.user_id', $user_id);
        return true;
    }

    /**
     * 静默授权后操作function
     * @param array $user_info 用户信息 示例如下
     * $user_info = array(
     * 'openid' => '',
     * 'unionid' => '',
     * 'user_id' => ''
     * );
     * @param $user_info
     */
    public function oauth_get_user_silent_function($user_info)
    {
        \Jwt::set('user_info.user_id', $user_info['user_id']);
        return true;
    }

}

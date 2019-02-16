<?php
namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Exceptions\AdminException;
use App\Model\BaseAdminModel;
use App\Support\LoginSupport;
use App\Support\LogSupport;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LoginController extends BaseController
{
    public function username()
    {
        return 'login_name';
    }

    public function doLogin(Request $request){

        $username = $request->get('login_name');
        $password = $request->get('login_password');
        //檢查登陸次數
        $lock = \Cache::get('admin:login:locked:' . md5($username));
        $lock = $lock ? $lock : 0;
        if($lock >=6){
            throw  new AdminException('登录太频繁请休息半个小时!');
        }
        if(config('verify_close') === 1){
            $verifyCode = $request->get('verify_code');
            $result = (new \extend\Captcha)->checkCodeInfo(config('app.admin_captcha'), $verifyCode);
            if (!$result) {
                throw new AdminException('验证码错误!');
            }
        }
        $userInfo = BaseAdminModel::where('user_name',$username)
            ->select(['user_id','password','user_name','real_name','locked',
                'group_id','role_id','menu_id','is_open'])
            ->first();
        //管理不存在
        if (empty($userInfo)) {
            return $this->error(trans('base.ACCOUNT_NOT_EXISTS'));
        }
        $userInfo = $userInfo->toArray();
        //密码不正确
        load_helper('Password');
        if (! compare_password($userInfo['password'], $password)) {
            \Cache::put('admin:login:locked:' . md5($username),$lock+1, 30);
            $this->error(trans('base.confirm_password_error'));
        }
        unset($userInfo['password']);

        //已被锁定
        if ($userInfo['locked'] == 1) {
            return $this->error(trans('base.disable_login'));
        }

        //获取当前用户权限
        $menu = LoginSupport::getPower($userInfo);
        $userInfo['menu'] = $menu;
        $userInfo['login_time'] = time();
        LoginSupport::login($userInfo);             //保存登录信息
        \Cache::forget('admin:login:locked:' . md5($username));
        //登陆日志
       LogSupport::adminLog('登录成功');
       return $this->success(trans('base.allow_login'), [], module_url('Admin/Index/index'));
    }

}

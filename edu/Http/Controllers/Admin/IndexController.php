<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Support\LoginSupport;


class IndexController extends BaseController
{
    protected $allowAction = '*';

    public function index()
    {
        $version = \DB::select('select VERSION()');
        $info = array(
            'SERVER_SOFTWARE'=>PHP_OS.' '.$_SERVER["SERVER_SOFTWARE"],
            'mysql_get_server_info'=>php_sapi_name(),
            'MYSQL_VERSION' => !empty($version) ? collect($version[0])->get('VERSION()'):'',
            'upload_max_filesize'=> ini_get('upload_max_filesize'),
            'max_execution_time'=>ini_get('max_execution_time').'秒',
            'disk_free_space'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
        );
        return view('Admin.index.index',['server_info'=>$info]);
    }

    public function menu()
    {
        $menuLogic = logic('Admin\Menu')->getPanelMenu();
        return $menuLogic;
    }




    /**
     *  退出登录
     */
    public function logout()
    {
        LoginSupport::logout();
        return redirect(url('admin/login'));
    }

    public function login()
    {
        return view('Admin.Index.login',[]);
    }


    public function captcha()
    {
        (new \extend\Captcha)->setLimit(4)->create(config('app.admin_captcha'), 5);

    }
}

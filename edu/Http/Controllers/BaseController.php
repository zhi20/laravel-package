<?php
namespace App\Http\Controllers;

use App\Support\ConfigSupport;


class BaseController extends Controller
{
    protected $responseObj ;

    protected $isTree = false;

    protected $logicName = '';

    protected $isJson = false;

    //
    public function  __construct()
    {
        //修改默认语言
        \App::setLocale('zh-cn');
        //合并后台配置
        config( ConfigSupport::getConfig() );
        //
        if(empty($this->logicName)){
//            $class = str_replace("\\","/",get_class($this)) ;
            $class = str_replace("App\\Http\\Controllers\\", "", get_class($this) );

            $this->logicName = str_replace_last('Controller', '', $class);
        }
    }

    /**
     * 列表入口
     * @return mixed
     */
    public function index()
    {
        if (request()->ajax()) {
            $data =logic($this->logicName)->lists($this->isTree);
            return $data;
        }
        return view(VIEW_NAME);
    }


    /**
     * 表单入口
     */
    public function form()
    {
        if (request()->ajax()) {
            return $this->save();
        }
        return view(VIEW_NAME);
    }

    /**
     *  保存
     */
    public function save()
    {
        $result = logic($this->logicName)->save();
        if ($result) {
            return $this->success(logic($this->logicName)->getInfo());
        } else {
            return $this->error(logic($this->logicName)->getError());
        }
    }

    /**
     *  删除
     */
    public function delete()
    {
        $result = logic($this->logicName)->delete();
        if ($result) {
            return $this->success(logic($this->logicName)->getInfo());
        } else {
            return $this->error(logic($this->logicName)->getError());
        }
    }

    /**
     *  修改状态
     */
    public function lock()
    {
        $result = logic($this->logicName)->lock();
        if ($result) {
            return $this->success(logic($this->logicName)->getInfo());
        } else {
            return $this->error(logic($this->logicName)->getError());
        }
    }

    /**
     * 下拉列表
     * @return mixed
     */
    public function select()
    {
        $data = logic($this->logicName)->select();
        return $data;
    }

    /**
     *  获取列表信息
     */
    public function lists(){
        $data =logic($this->logicName)->lists($this->isTree);
        if(false === $data){
            $message = logic($this->logicName)->getError('Error');
            return $this->error($message);
        }else{
            $message = logic($this->logicName)->getInfo('OK');
            return $this->success($message,$data);
        }

    }


    /**
     *  获取详细信息
     */
    public function info(){
        $data =logic($this->logicName)->info($this->isTree);
        if(false === $data){
            $message = logic($this->logicName)->getError('Error');
            return $this->error($message);
        }else{
            $message = logic($this->logicName)->getInfo('OK');
            return $this->success($message,$data);
        }
    }
}
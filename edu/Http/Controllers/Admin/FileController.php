<?php
 /**
 * ====================================
 * thinkphp5
 * ====================================
 * Author: 1002571
 * Date: 2018/2/26 11:35
 * ====================================
 * File: File.php
 * ====================================
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Support\LoginSupport;
use App\Support\UploadSupport;
use Illuminate\Http\Request;

class FileController extends BaseController
{

    /**
     * 列表
     * @return array|mixed
     */
    public function index(){

        if (\request()->ajax()) {
            load_helper('File');
            $filepath = public_path('uploads');
            $id = \request('id',null);
           if(!empty($id)){
               $filepath = public_path().str_replace('_','/',$id);
           }
            $data =  list_file($filepath, public_path(), false);
            return $data;
        }
        return view(VIEW_NAME);
    }

    /**
     *  删除
     */
    public function delete()
    {
        $id =\request('id',null);
        if(empty($id)){
            $this->error('缺少参数');
        }
        load_helper('File');
        $files = explode('|',$id);
        foreach($files as $file){
            $file = public_path().str_replace(config('SPLIT_FILE'),DIRECTORY_SEPARATOR,$file);
            remove_file($file);
        }
        $this->success('删除成功');
    }

    /**
     * 上传文件 返回文件路径
     */
    public function upload(){
        LoginSupport::getUserId();  //检查用户是否登录
        $res = UploadSupport::upload();
        if(!$res){
            $this->error('上传失败');
        }else{
            $this->success('上传成功',$res);
        }
    }

}
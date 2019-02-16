<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class UploadController extends BaseController
{
    //

    public function index(){
        $CONFIG = config('ueditor');
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result =  $CONFIG;
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = logic($this->logicName)->upload();
                break;

            /* 列出图片 */
            case 'listimage':
                logic($this->logicName)->setData('filter','image');
                $result = logic($this->logicName)->lists();
                break;
            /* 列出文件 */
            case 'listfile':
                $result = logic($this->logicName)->lists();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = logic($this->logicName)->lists();
                break;

            default:
                $result =array(
                    'state'=> '请求地址出错'
                );
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                return htmlspecialchars($_GET["callback"]) . '(' . json_encode($result) . ')';
            } else {
                return array(
                    'state'=> 'callback参数不合法'
                );
            }
        } else {
            return $result;
        }
    }
}
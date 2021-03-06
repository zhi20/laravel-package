<?php
namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    /**
     * 第一步:获取上传id
     */
    public function getUploadID(Request $request)
    {
        $this->verify([
            'total_size' => 'egnum',
            'part_size' => 'egnum',
            'file_type' => '',
            'filename' => '',
            'upload_type' => 'in:banner:article:activity:headpic',
            'upload_setting' => 'in:cloud:local'
        ], 'POST');
        $data = $this->verifyData;

        //$part_size 必须大于102400
        $part_size = $data['part_size'];  //单位B

        //此处作权限控制
        switch ($data['upload_type']) {
            case 'banner' :
                $upload_setting = 'cloud';
                $dir = 'banner/';
                $is_multi = true;   //是否分块
                $part_size = 204800;  //单位B
                break;
            case 'article' :
                $upload_setting = 'cloud';
                $dir = 'article/';
                $is_multi = false;   //是否分块
                break;
            case 'activity' :
                $upload_setting = $data['upload_setting'];
                $dir = 'activity/';
                $is_multi = true;   //是否分块
                $part_size = 400000;   //单位B
                \Zhi20\Upload\ExtCheck::checkFileTypeOfGroup($data['file_type']);
                break;
            case 'headpic' :
                $upload_setting = 'cloud';
                $dir = 'headpic/';
                $is_multi = false;   //是否分块
                $part_size = 204800;   //单位B
                \Zhi20\Upload\ExtCheck::checkFileTypeOfGroup($data['file_type']);
                break;
            default :
                throw new ApiException('错误的上传类型!', 'UPLOAD_ERROR');
        }

        if ($upload_setting == 'cloud') {
            $aliyun_obj = new \Zhi20\Upload\AliyunOss();

            //配置云callback路径
            $callback = $request->getSchemeAndHttpHost() . '/api/admin/upload/callback';

            $aliyun_obj->getUploadId(\App\Model\UploadModel::class, $data['total_size'], $part_size, $data['file_type'], $dir, $data['filename'], $callback, $is_multi);
            $upload_sign = $aliyun_obj->uploadSign;
            $upload_id = $aliyun_obj->uploadId;
            $part_num = $aliyun_obj->partNum;

            //配置完成后调用的url
            $complete_url = '/api/admin/upload/cloudcomplete/';
        } else {
            //配置上传文件路径
            $upload_host = $request->getSchemeAndHttpHost() . '/api/admin/files';

            $local_obj = new \Zhi20\Upload\LocalOss();

            $local_obj->getUploadId(\App\Model\UploadModel::class, $data['total_size'], $part_size, $data['file_type'], $dir, $data['filename'], $upload_host, $is_multi);
            $upload_sign = $local_obj->uploadSign;
            $upload_id = $local_obj->uploadId;
            $part_num = $local_obj->partNum;

            //配置完成后调用的url
            $complete_url = '/api/admin/upload/localcomplete/';
        }

        return $this->response([
            'upload_id' => $upload_id,
            'part_num' => $part_num,
            'part_size' => $part_size,
            'upload_setting' => $upload_setting,
            'complete_url' => $complete_url
        ],
            $upload_sign);
    }

    /**
     *  完成(云上传)
     */
    public function putCloudUploadComplete($id)
    {
        $this->verifyId($id);

        $obj = new \Zhi20\Upload\AliyunOss();
        $data = $obj->multiUploadComplete(\App\Model\UploadModel::class, $id);

        return $this->response(['path' => $data['path'], 'url' => $data['url'], 'upload_id' => $id, 'origin_filename' => $data['origin_filename']]);
    }

    /**
     *  完成(本地上传)
     */
    public function putLocalUploadComplete($id)
    {
        $this->verifyId($id);

        $obj = new \Zhi20\Upload\LocalOss();
        $data = $obj->multiUploadComplete(\App\Model\UploadModel::class, $id);

        return $this->response(['path' => $data['path'], 'url' => $data['url'], 'upload_id' => $id, 'origin_filename' => $data['origin_filename']]);
    }

    /**
     *  上传回调(云上传)
     */
    public function uploadCallback()
    {
        $obj = new \Zhi20\Upload\AliyunOss();
        $sign = $obj->notify(\App\Model\UploadModel::class);
        return $sign;
    }


    /**
     * 本地上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function upload(Request $request)
    {
        $this->verify([
            'upload_id' => 'egnum',
            'part_now' => 'egnum'

        ], 'POST');
        $data = $this->verifyData;

        //完成后是否上传到阿里云
        $is_upload = false;

        $local_obj = new \Zhi20\Upload\LocalOss();
        $result = $local_obj->updatePart(\App\Model\UploadModel::class, $data['upload_id'], $data['part_now'], $is_upload);

        return $this->response($result);
    }


}

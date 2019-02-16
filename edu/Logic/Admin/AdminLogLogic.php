<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Support\LoginSupport;

class AdminLogLogic extends BaseLogic{

    protected  $modelName = 'BaseAdminLogModel';
    public function _initialize()
    {
    }


    public function format($data)
    {
        if (!empty($data['rows'])) {
            foreach ($data['rows'] as &$item) {
                $item['user_name'] = LoginSupport::getUserInfo('user_name');
                $item['real_name'] = LoginSupport::getUserInfo('real_name');
            }
        }
        return $data;
    }

}
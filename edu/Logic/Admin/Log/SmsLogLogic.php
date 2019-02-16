<?php
namespace App\Logic\Admin\Log;

use App\Logic\BaseLogic;

class SmsLogLogic extends BaseLogic
{
    //
    /** 格式化_lists结果 */
    public function format($data)
    {
        if(isset($data['rows'])){
            $data['rows'] = $this->_format($data['rows']) ;
        }else{
            $data = $this->_format($data) ;
        }
        return $data;
    }

    /** 格式化数据 */
    private function _format($data)
    {
        if(empty($data)){
            return [];
        }
        return $data;
    }
}
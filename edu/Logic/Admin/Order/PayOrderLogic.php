<?php
namespace App\Logic\Admin\Order;

use App\Logic\BaseLogic;

class PayOrderLogic extends BaseLogic
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

        return $data;
    }
}
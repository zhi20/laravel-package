<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;

class RecommendLogic extends BaseLogic
{
    //
    /** 格式化_lists结果 */
    public function format($data)
    {
        if(isset($data['rows'])){
            $data = $this->_format($data['rows']) ;
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

    public function _after_select($data){
        array_unshift($data ,['id'=>0,'text'=>'无']);
        return $data;
    }
}
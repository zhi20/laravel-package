<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/7 14:50
 * ====================================
 * Project: SDJY
 * File: RegionLogic.php
 * ====================================
 */

namespace App\Logic\Admin;


use App\Logic\BaseLogic;

class RegionLogic extends BaseLogic
{
    protected $modelName = 'AreaModel';

    public function format($data)
    {
        if (empty($this->data['type']) && !empty($data)) {
            foreach ($data as $key => &$row) {
                if ($row['have_children']) {
                    $row['state'] = 'closed';
                }
            }
        }
        return $data;
    }
}
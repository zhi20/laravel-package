<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/16 10:30
 * ====================================
 * Project: SDJY
 * File: Validate.php
 * ====================================
 */

namespace App\Util\Traits;


use App\Support\ValidateSupport;

trait Validate
{

    /**
     * 验证
     * @param array $rule
     * @param string $data
     * @return mixed
     * @throws \App\Exceptions\ApiException
     */
    public function verify(array $rule, $data = 'GET')
    {
        if(ValidateSupport::check($rule, $data)){
            return ValidateSupport::getData();
        }
        return false;
    }
}
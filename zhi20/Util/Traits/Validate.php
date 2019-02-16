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

use App\Exceptions\ApiException;
use App\Util\Support\ValidateSupport;

trait Validate
{

    /**
     * 验证Controller.php
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


    /**
     * 验证ID
     * @param mixed $id
     * @return bool
     * @throws ApiException
     */
    public function verifyId($id)
    {
        if (!ValidateSupport::egnum($id)) {
            throw new ApiException('id验证错误', 'id_ERROR', 422);
        }

        return true;
    }
}
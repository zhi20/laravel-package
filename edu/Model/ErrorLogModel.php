<?php
namespace App\Model;


use App\Model\Base\BaseModel;

class ErrorLogModel extends BaseModel
{
    protected $table = 'error_log';

    const UPDATED_AT = null;
}
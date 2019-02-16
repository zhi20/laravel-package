<?php
namespace App\Support;

use App\Events\AdminLogEvent;
use App\Events\ErrorLogEvent;
use App\Model\BaseAdminLogModel;

class LogSupport {

    /**
     * 后台操作日志
     * @param $message
     * @param int $user_id
     */
    public static function adminLog($message, $params = [], $user_id = 0){
        $user_id or $user_id = LoginSupport::getUserId();
        $data = array(
            'user_id' => $user_id,
            'module_name' => strtolower(MODULE_NAME),
            'controller_name' => strtolower(CONTROLLER_NAME),
            'action_name' => strtolower(ACTION_NAME),
            'note' => $message
        );
        $params['ip'] = request()->ip();
        if(!empty($params)){
            $data['params'] = json_encode($params);
        }
        return event(new AdminLogEvent($data));
    }

    /**
     * 錯誤日志記錄
     * @param $message
     * @param int $code         //错误状态码 和自定义业务错误码一致 Handler::$httpcode
     * @param int $user_id
     * @return array|null
     */
    public static function errorLog($message, $code = 0, $userId = 0){
        $userId or $userId = LoginSupport::getUserId();
        $data = array(
            'user_id' => intval($userId),
            'module_name' => strtolower(MODULE_NAME),
            'controller_name' => strtolower(CONTROLLER_NAME),
            'action_name' => strtolower(ACTION_NAME),
            'code' => $code,
            'note' => $message
        );
        $data['ip'] = ip2long(request()->ip());
        $data['params'] = json_encode(request()->all());
        return event(new ErrorLogEvent($data));
    }

    public static function payLog($message, $params, $code = 0, $userId = 0){
        $userId or $user_id = LoginSupport::getUserId();
        $data = array(
            'user_id' => intval($userId),
            'module_name' => strtolower(MODULE_NAME),
            'controller_name' => strtolower(CONTROLLER_NAME),
            'action_name' => strtolower(ACTION_NAME),
            'code' => $code,
            'note' => $message
        );
        $data['ip'] = ip2long(request()->ip());
        $data['params'] = json_encode($params);
        return event(new PayLogEvent($data));
    }
}
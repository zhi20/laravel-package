<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Model\BaseAdminModel;
use App\Model\BaseRoleModel;
use App\Support\LogSupport;


class PowerLogic extends BaseLogic{

    protected $modelName = false;


    public function setPower()
    {
        $this->error = '保存失败';
        $result = false;         //设置成功编辑
        $logMsg = trans('base.power_change');
        $name = $no = '';
        //设置角色权限
        if (isset($this->data['role_id'])) {
            $result = BaseRoleModel::where('id',$this->data['role_id'])->update(['menu_id' => $this->data['menu_list']]);
            $name = trans('role');
            $no = $this->data['role_id'];
        }

        //设置用户权限
        if (isset($this->data['user_id'])) {
            $result = BaseAdminModel::where('user_id',$this->data['user_id'])->update(['menu_id' => $this->data['menu_list']]);
            $name = trans('manage');
            $no = $this->data['user_id'];
        }

        if ($result !== false) {
            $this->info = trans('save') . trans('success');
            LogSupport::adminLog(sprintf($logMsg, $no, $name) . trans('base.success'));
            $result = true;
        } else {
            LogSupport::adminLog(sprintf($logMsg, $no, $name) . trans('base.error'));
        }
        return $result;
    }

}
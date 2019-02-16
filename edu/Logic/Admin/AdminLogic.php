<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Support\LoginSupport;

class AdminLogic extends BaseLogic
{
    protected $modelName = 'BaseAdminModel';

    public function _before_save()
    {
        if (isset($this->data['password']) && !empty($this->data['password']) && !empty($this->data['password_confirm'])) {
            if($this->data['password'] !== $this->data['password_confirm']){
                $this->error = '密码不一致';
                return false;
            }
            load_helper('Password');
            $this->data['password'] = encrypt_password($this->data['password']);
        } else {
            unset($this->data['password']);
        }
    }

    public function modifyPassword()
    {
        $user = LoginSupport::getUserInfo();
//        $this->data['user_name'] = $user['user_name'];
//        $this->data['real_name'] = $user['real_name'];
//        $this->data['group_id'] = $user['group_id'];
//        $this->data['role_id'] = $user['role_id'];
        $this->data['user_id'] = $user['user_id'];
        return $this->save();
    }

    /**
     * 获取当前管理员信息
     * @param array $field 获取字段
     * @param bool $isRole 是否关联角色表
     * @param bool $isGroup 是否关联组织架构表
     * @return mixed
     */
    public function getManageInfo($field = ['*'], $isRole = true, $isGroup = true)
    {
        $model = $this->getModel();
        $query = $model->query()->select($field);
        if ($isRole) {
//            $model->joinRole($query, [\DB::raw('text as role_name')]);
            $query->with(['role'=>function($build){
                $build->select(['id', \DB::raw('text as role_name')]);
                }]);
        }
        if ($isGroup) {
//            $model->joinGroup($query, [\DB::raw('text as group_name')]);
            $query->with(['group'=>function($build){
                $build->select(['id', \DB::raw('text as group_name')]);
            }]);
        }
        $result =$query->where('user_id', LoginSupport::getUserId())->first();
        return $result->toArray();
    }

}
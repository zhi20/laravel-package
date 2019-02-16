<?php
namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Model\Base\BaseModel;
use App\Model\BaseAdminModel;
use App\Model\BaseRoleModel;
use App\Support\LoginSupport;
use extend\Tree;

class MenuLogic extends BaseLogic
{
    protected $modelName = 'BaseMenuModel';
    /**
     * 获取后台菜单
     * @return array
     */
    public function getPanelMenu()
    {
        $where['display'] = 1;
        $user = LoginSupport::getUserInfo();
        if (!empty($user['is_open'])) {
            if (empty($user['menu'])) {
                return [];
            } else {
                $this->getModel()->whereIn('id', array_keys($user['menu']));
            }
        }

        $field = ['id', 'pid', 'text', 'module', 'controller', 'method', 'icon'];

        $menu = $this->getModel()->select($field)->where($where)->get()->toArray();
        $menu = json_decode(json_encode($menu), true);
        if (!empty($menu) && is_array($menu)) {
            foreach ($menu as $key => $item) {
                $action = (empty($item['method']) || $item['method'] == '*') ? config('app.default_action') : $item['method'];
                $href = [$item['controller'], $action];
                if (!empty($item['module'])) {
                    array_unshift($href, $item['module']);
                }
                $item['href'] = module_url(join('/', $href));
                $menu[$key] = $item;
            }
            $menu = Tree::treeArray($menu);
        }
        return $menu;
    }


    public function format($data = [])
    {
        if (empty($data) || !is_array($data)) {
            return $data;
        }

        $power = [];
        $disable = [];
        $rolePower = [];
        $checkRole = [];//存储当前勾选数据

        //会员权限处理
        if (!empty($this->data['userId'])) {
            $userInfo = BaseAdminModel::where(['user_id' => $this->data['userId']])
                ->select( ['role_id', 'menu_id'])->first();
            $userInfo = $userInfo->toArray();
            if (!empty($userInfo)) {
                $this->data['roleId'] = $userInfo['role_id'];
            }
            $power = array_merge($power, explode(',', $userInfo['menu_id']));
            $checkRole = $power;
        }

        //角色权限处理
        if (!empty($this->data['roleId'])) {
            $role = BaseRoleModel::get()->toArray(); //获取所有角色
            foreach ($role as $key => $item) {
                if ($item['id'] == $this->data['roleId']) {
                    $rolePower = explode(',', $item['menu_id']);
                    $power = array_merge($power, $rolePower);
                }
            }
            if (!empty($this->data['userId'])) {
                $disable = array_merge($disable, $rolePower);
            } else {
                $checkRole = $rolePower;
            }
            //获取所有子角色
            $child = Tree::findAllChild($role, $this->data['roleId']);
            if (!empty($child)) {
                foreach ($child as $item) {
                    $roleChildPower = explode(',', $item['menu_id']);
                    $power = array_merge($power, $roleChildPower);
                    $disable = array_merge($disable, $roleChildPower);
                }
            }
        }

        //过滤空值
        $power = array_filter($power);
        $disable = array_filter($disable);

        //过滤重复值
        $power = array_unique($power);
        $disable = array_unique($disable);

        foreach ($data as &$item) {
            $item['power'] = "power('{$item['module']}-{$item['controller']}-{$item['method']}')";
            if (!empty($disable)) {
                $item['disable'] = in_array($item['id'], $disable) ? true : false;
            }
            $item['unchecked'] = (in_array($item['id'], $checkRole)) ? false : true;
            $item['checked'] = in_array($item['id'], $power) ? true : false;
        }
        return $data;
    }


    public function getSearchData()
    {
        $result = [
            array('text' => trans('base.select_node'), 'selected' => true, 'value' => '')
        ];
        $where = [];
        $field = [];
        $query =  $this->getModel()->newQuery();
        if (!empty($this->data['module'])) {
            $where['module'] = $this->data['module'];
        }
        if (!empty($this->data['controller'])) {
            $where['controller'] = $this->data['controller'];
        }
        if (!empty($this->data['type'])) {
            $query->groupBy($this->data['type']);
        }
        if (empty($this->data['field'])) {
            $field = [$this->data['type'] . " as text"] ;
        }else{
            if(!is_array($this->data['field'])){
                $this->data['field'] = explode(',',$this->data['field']);
            }
            $field = $this->data['field'];
        }
//        $data = $query->where($where)->select($field)->get();
        $data = $query->where($where)->select($field)->get()->toArray();

        foreach ($data as &$item) {
            $item['value'] = $item['text'];
        }
        $result = array_merge($result, $data);
        return $result;
    }

    function _after_delete(){
        /*==== menu删除时删除子菜单 ====*/
        $pk = $this->getModel()->getKeyName();
        if (isset($this->data[$pk]) && !empty($this->data[$pk])) {
            if (strpos($this->data[$pk], ',') !== false) {
                $where['pid'] = ['IN', $this->data[$pk]];
            } else {
                $where['pid'] = $this->data[$pk];
            }
            $this->getModel()->newQuery()->where($where)->delete();
        }
    }
}
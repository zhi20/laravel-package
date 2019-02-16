<?php
namespace App\Support;

use Illuminate\Http\JsonResponse;

class LoginSupport {
    protected static $loginUser = null;

    protected static $menu = null;

    protected static $error = '';
    /**
     * 获取登录用户信息
     * @param string $field
     * @return null|string
     */
    public static function getUserInfo($field='')
    {
        if(empty(static::$loginUser)){
            static::$loginUser = AuthSupport::get();
        }
        if (empty($field)) {
            return  static::$loginUser;
        }
        return isset(static::$loginUser[$field]) ? static::$loginUser[$field] : null;
    }

    /**
     * 保存登录后的用户数据  LogSupport::adminLog(lang('LOGIN_SUCCESS'), $adminUserInfo['user_id']);
     * @param $userInfo
     * @return bool
     */
    public static function login($userInfo)
    {
        $token = AuthSupport::createToken($userInfo);
        ResponseSupport::setCookie(AuthSupport::COOKIE_NAME, $token['token']);
        return true;
    }

    /**
     *  退出登录销毁session喝用户数据
     */
    public static function logout()
    {
        AuthSupport::destroy();
        static::$loginUser = null;
    }

    /**
     * 获取登录用户user_id (默认主键)
     * @return null|string
     */
    public static function getUserId()
    {
        return static::getUserInfo('user_id');
    }


    /**
     * 验证逻辑权限   --- 当前power是否存在用户menu中
     * @param array $power 权限数据
     * @return bool
     */
    public static function power($power)
    {
        $menu  = static::getUserInfo('menu');
        $result = false;
        if (empty($menu)) {
            return $result;
        }
        if (empty(static::$menu)) {
            static::$menu = array_reduce($menu, 'array_merge', array());
        }
        if (is_array($power)) {
            foreach ($power as $key => $item) {
                if (in_array(strtolower($item), static::$menu)) {
                    $result = true;
                    break;
                }
            }
        } else {
            $result = in_array(strtolower($power), $menu);
        }

        return $result;
    }

    /**
     * 检查后台用户权限
     * @param array  $allowAction      //无需检查列表
     * @return bool
     */
    public static function checkPower($allowAction=[])
    {
        $user= static::getUserInfo();
        if (empty($user)) {
            static::$error = '用户信息获取失败';
            return false;
        }
        //不开权限则无需校验权限
        if (LoginSupport::getUserInfo('is_open') == 0) {
            return true;
        }
        $action = defined('ACTION_NAME') ? ACTION_NAME : '';
        $controller = defined('CONTROLLER_NAME') ? CONTROLLER_NAME : '';
        $module = defined('MODULE_NAME') ? MODULE_NAME : '';
        //是否无需检查的函数
        if (!empty($allowAction) && ($allowAction == '*' || in_array($action, array_map_recursive('strtolower', $allowAction)))) {
            return true;
        }
        $power = array(
            join('-', array($module, $controller, $action)),
            join('-', array($module, $controller, '*'))
        );

        //检查权限
       return LoginSupport::power($power);
    }




    /** 获取后台用户权限列表 [menu_id, role_id, user_id] */
    public static function getPower($user = [])
    {
        $power = [];
        if (empty($user)) {
            return $power;
        }
        //获取管理员权限
        if(!isset($user['menu_id'])){
            $user['menu_id'] = \App\Model\BaseAdminModel::where('user_id',$user['user_id'])
                ->value('menu_id');
        }
        if (!empty($user['menu_id'])) {
            $power = array_merge($power, explode(',', $user['menu_id']));
        }
        //获取角色权限
        $role = \App\Model\BaseRoleModel::select(['id','text','pid','remark','menu_id','locked'])->get()->toArray();  //获取所有角色
        $role = json_decode(json_encode($role),'true');
        if (!empty($role) && is_array($role)) {
            foreach ($role as $key => $item) {
                if ($item['id'] == $user['role_id']) {
                    $power = array_merge($power, explode(',', $item['menu_id']));
                }
            }

            $child = \extend\Tree::findAllChild($role, $user['role_id']); //获取所有子角色
            if (!empty($child)) {
                foreach ($child as $item) {
                    $power = array_merge($power, explode(',', $item['menu_id']));
                }
            }
        }
        $power = array_filter($power); //过滤空值
        $power = array_unique($power); //过滤重复的数据
        $data = \App\Model\BaseMenuModel::whereIn('id', $power)
            ->select(['id',
                \DB::raw('concat_ws("-", module, controller, method) as power'),
                'module', 'controller', 'other_method'])
            ->get();
        $data = json_decode(json_encode($data),'true');
        $menu = [];
        if (!empty($data) && is_array($data)) {
            foreach ($data as $row) {
                $menu[$row['id']][] = strtolower($row['power']);
                if (!empty($row['other_method'])) { //获取关联权限
                    $otherMethod = explode(',', $row['other_method']);
                    foreach ($otherMethod as $method) {
                        $menu[$row['id']][] = strtolower(join('-', array($row['module'], $row['controller'], $method)));
                    }
                }
            }
        }
        return $menu;
    }

}
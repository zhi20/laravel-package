<?php

namespace JiaLeo\Laravel\Core\Console;

use App\Exceptions\ApiException;
use Illuminate\Console\Command;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create permission data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $route = \Route::getRoutes()->get();
        $parents = []; // 用户保存已存在的父级权限

        $permission_list = \App\Model\AdminPermissionModel::where('is_on', 1)
            ->select(['code'])
            ->get();

        $permission_list = $permission_list->pluck('code')->toArray();

        $num = 0;
        foreach ($route as $value) {
            $action = $value->action;
            // 判断是否存在AdminAuth的中间件里，是才进入
            if (isset($action['middleware']) && is_array($action['middleware']) && in_array("AdminAuth", $action['middleware'])) {

                // 没有路由命名，直接跳过
                if (!isset($action['as'])) {   // as的格式 //name:权限组:权限|menu:菜单组:菜单|create:false|edit:false|index:true|store:true|show:true|update:true|destroy:true.资源路由命名(users).资源理由方法(index)
                    continue;
                }

                // 获取命名路由
                $as = $action['as'];
                if (empty($as)) {
                    throw new ApiException('权限格式错误：' . $action['as']);
                }
                $resource = explode('.', $as); // 用于判断是否为资源路由

                $as = $resource[0];
                if (empty($as)) {
                    throw new ApiException('权限格式错误：' . $action['as']);
                }

                // 获取权限信息和菜单信息
                $as_arr = explode('|', $as); // 权限名称-菜单需要的数据
                $permission = []; // 权限数据
                $menu = []; // 菜单数据
                $is_create = false; // 资源路由默认不创建create的权限
                $is_edit = false; // 资源路由默认不创建edit的权限
                $is_index = true; // 资源路由默认创建index的权限
                $is_store = true; // 资源路由默认创建store的权限
                $is_show = true; // 资源路由默认创建show的权限
                $is_update = true; // 资源路由默认创建update的权限
                $is_destroy = true; // 资源路由默认创建destroy的权限
                foreach ($as_arr as $item) {
                    $v = explode(':', $item);

                    if (!isset($v[1])) {
                        throw new ApiException('格式错误：' . $action['as']);
                    }

                    switch ($v[0]) {
                        case 'name':
                            if (!isset($v[1]) || !isset($v[2])) {
                                throw new ApiException('name格式错误：' . $action['as']);
                            }
                            $permission = [$v[1], $v[2]];
                            break;
                        case 'menu':
                            if (!isset($v[1]) || !isset($v[2])) {
                                throw new ApiException('menu格式错误：' . $action['as']);
                            }
                            $menu = [$v[1], $v[2]];
                            break;
                        case 'create':
                            $is_create = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'edit':
                            $is_edit = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'index':
                            $is_index = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'store':
                            $is_store = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'show':
                            $is_show = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'update':
                            $is_update = $this->verifyBool($action['as'], $v[1]);
                            break;
                        case 'destroy':
                            $is_destroy = $this->verifyBool($action['as'], $v[1]);
                            break;
                        default:
                            throw new ApiException('格式错误：' . $action['as']);
                            break;
                    }
                }

                // 没有权限直接报错
                if (empty($permission)) {
                    throw new ApiException('权限格式错误：' . $action['as']);
                }

                // 获取code
                $controller = str_replace($action['namespace'] . '\Admin\\', '', $action['controller']);
                $code = str_replace('Controller@', '@', $controller);
                // 判断权限是否已存在，存在则跳过
                if (in_array($code, $permission_list)) {
                    continue;
                }

                // 判断是否为资源路由，是的话拼接信息
                $parent_permission_name = $permission[0];
                if (isset($resource[1]) && isset($resource[2])) {
                    $continue = 0;
                    switch ($resource[2]) {
                        case 'index':
                            if ($is_index) {
                                $permission_name = $permission[1] . '列表';
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'store':
                            if ($is_store) {
                                $permission_name = '添加' . $permission[1];
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'show':
                            if ($is_show) {
                                $permission_name = $permission[1] . '详情';
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'update':
                            if ($is_update) {
                                $permission_name = '编辑' . $permission[1];
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'destroy':
                            if ($is_destroy) {
                                $permission_name = '删除' . $permission[1];
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'create':
                            if ($is_create) {
                                $permission_name = $permission[1] . '数据';
                            } else {
                                $continue = 1;
                            }
                            break;
                        case 'edit':
                            if ($is_edit) {
                                $permission_name = $permission[1] . '数据';
                            } else {
                                $continue = 1;
                            }
                            break;
                        default:
                            $continue = 1;
                            break;
                    }
                    if ($continue == 1) {
                        continue;
                    }
                } else {
                    $permission_name = $permission[1];
                }

                // 判断是否需要绑定目录
                $menu_id = 0;
                if (!empty($menu) && $value->methods[0] == 'GET' && (((isset($resource[1]) && isset($resource[2])) && $resource[2] == 'index') || !(isset($resource[1]) && isset($resource[2])))) {
                    $menu_data = \App\Model\AdminMenuModel::where('name', $menu[1])
                        ->where('is_on', 1)
                        ->where('level', 2)
                        ->first(['id']);

                    if ($menu_data) { // 存在菜单则绑定，不存在则忽略
                        $menu_id = $menu_data['id'];
                    }
                }

                // 判断权限组是否存在，不存在则创建
                \DB::beginTransaction();
                if (!isset($parents[$parent_permission_name])) {
                    $parent_permission = \App\Model\AdminPermissionModel::where('name', $parent_permission_name)
                        ->where('is_on', 1)
                        ->first(['id']);

                    if ($parent_permission) {
                        $parents[$parent_permission_name] = $parent_permission['id'];
                    } else {
                        $parent_permission_model = new \App\Model\AdminPermissionModel();
                        set_save_data($parent_permission_model, [
                            'name' => $parent_permission_name,
                            'description' => $parent_permission_name,
                            'level' => 1
                        ]);
                        $res = $parent_permission_model->save();

                        if (!$res) {
                            \DB::rollBack();
                            throw new ApiException('数据库错误');
                        }
                        $parents[$parent_permission_name] = $parent_permission_model->id;
                    }
                }

                $parent_id = $parents[$parent_permission_name];

                // 添加权限数据
                $permission_model = new \App\Model\AdminPermissionModel();
                set_save_data($permission_model, [
                    'name' => $permission_name,
                    'code' => $code,
                    'description' => $permission_name,
                    'parent_id' => $parent_id,
                    'level' => 2,
                ]);
                $res = $permission_model->save();
                if (!$res) {
                    \DB::rollBack();
                    throw new ApiException('数据库错误2');
                }
                $num++;
                // 判断是否需要绑定菜单
                if ($menu_id != 0) {
                    $permission_menu_model = new \App\Model\AdminPermissionMenuModel();
                    set_save_data($permission_menu_model, [
                        'admin_permission_id' => $permission_model->id,
                        'admin_menu_id' => $menu_id
                    ]);
                    $res = $permission_menu_model->save();
                    if (!$res) {
                        \DB::rollBack();
                        throw new ApiException('数据库错误3');
                    }
                }

                \DB::commit();
            }
        }

        $this->info('成功生成权限'.$num.'个');
    }

    /**
     * 验证bool类型参数
     * @param $as
     * @param string|bool $value 需要验证的值
     * @return bool
     * @throws ApiException
     */
    public function verifyBool($as, $value)
    {
        if (!is_bool($value) && $value != "false" && $value != "true") {
            throw new ApiException('create格式错误：' . $as);
        }

        if (is_bool($value)) {
            return $value;
        }

        if ($value == "false") {
            return false;
        }

        if ($value == "true") {
            return true;
        }
    }
}

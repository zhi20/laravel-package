<?php

namespace Zhi20\Laravel\Modules\Advertising;

use App\Exceptions\ApiException;
use Illuminate\Console\Command;

class AdvertisingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:advertising';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create advertising module';

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
        load_helper('File');

        //migrate
        $this->createMigrate();

        //model
        if ($this->createModel()) {
            $this->info('生成model成功!');
        }

        //controller
        if ($this->createController()) {
            $this->info('生成controller成功!');
        }

        //createLogic
        if ($this->createLogic()) {
            $this->info('生成logic成功!');
        }

        // insertData
        if ($this->insertData()) {
            $this->info('插入必需数据成功!');
        }

        //route
        $this->warn(str_repeat('*', 15));
        $this->warn("请手动将 Route::resource('advertisings', 'Admin\AdvertisingController'); //广告管理 添加到route/admin.php");
        $this->warn("请手动将 Route::get('advertisings','Api\AdvertisingController@index'); //广告列表 添加到route/api.php");
        $this->warn("请到 Admin/UplaodController 添加一个新的upload_type为advertising，确认upload配置无误后再开始使用');");

    }

    /**
     * 创建migrate
     */
    private function createMigrate()
    {
        //先存放到临时文件夹
        $dist = 'storage/migrations/' . date('YmdHis');
        $dist_path = base_path($dist);
        dir_exists($dist_path);
        $is_copy = copy_dir(__DIR__ . '/databases', $dist_path);

        if (!$is_copy) {
            $this->error('创建migrate--复制临时文件失败,请确保storage目录有权限!');
            return false;
        }

        $this->call('migrate', [
            '--path' => $dist
        ]);

        //删除文件夹
        $is_del = del_dir($dist_path);
        if (!$is_del) {
            $this->error('创建migrate--删除临时文件失败,请自行删除!' . $dist_path);
            return false;
        }

        return true;
    }

    /**
     * 生成model
     * @return bool
     */
    private function createModel()
    {
        $dist_path = app_path('Model');
        $is_copy = copy_stubs(__DIR__ . '/stubs/model', $dist_path, true);
        if (!$is_copy) {
            $this->error('创建model--复制文件失败,请确保' . dirname($dist_path) . '目录有权限!');
            return false;
        }

        return true;
    }

    /**
     * 生成controller
     * @return bool
     */
    private function createController()
    {
        $dist_path = app_path('Http/Controllers');
        $is_copy = copy_stubs(__DIR__ . '/stubs/controller', $dist_path, true);
        if (!$is_copy) {
            $this->error('创建controller--复制文件失败,请确保' . dirname($dist_path) . '目录有权限!');
            return false;
        }

        return true;
    }

    /**
     * 生成Logic
     * @return bool
     */
    private function createLogic()
    {
        $dist_path = app_path('Logic');
        $is_copy = copy_stubs(__DIR__ . '/stubs/logic', $dist_path, true);
        if (!$is_copy) {
            $this->error('创建logic--复制文件失败,请确保' . dirname($dist_path) . '目录有权限!');
            return false;
        }

        return true;
    }

    /**
     * 插入必需数据
     * @return bool
     */
    private function insertData()
    {
        try {
            \DB::beginTransaction();
            // 插入菜单数据
            $menu_parent = \App\Model\AdminMenuModel::where('name', '拓展管理')
                ->where('is_on', 1)
                ->where('parent_id', 0)
                ->where('level', 1)
                ->first(['id']);

            if (!$menu_parent) {
                $menu_parent = new \App\Model\AdminMenuModel();
                set_save_data($menu_parent, [
                    'name' => '拓展管理',
                    'level' => 1,
                    'parent_id' => 0,
                    'order' => 1,
                    'description' => '拓展管理',
                ]);
                $res = $res = $menu_parent->save();
                if (!$res) {
                    throw new ApiException('插入必要数据报错');
                }
            }

            $menu_parent_id = $menu_parent->id;

            $menu_model = new \App\Model\AdminMenuModel();
            set_save_data($menu_model, [
                'name' => '广告列表',
                'url' => '/expand/advertisement/lists',
                'level' => 2,
                'parent_id' => $menu_parent_id,
                'order' => 1,
                'description' => '广告列表',
            ]);

            $res = $menu_model->save();
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            // 插入权限数据
            $permission_parent = \App\Model\AdminPermissionModel::where('name', '拓展管理权限组')
                ->where('is_on', 1)
                ->where('parent_id', 0)
                ->where('level', 1)
                ->first(['id']);

            if (!$permission_parent) {

                $permission_parent = new \App\Model\AdminPermissionModel();
                set_save_data($permission_parent, [
                    'name' => '拓展管理权限组',
                    'level' => 1,
                    'parent_id' => 0,
                    'description' => '拓展管理权限组',
                ]);

                $res = $permission_parent->save();
                if (!$res) {
                    throw new ApiException('插入必要数据报错');
                }
            }

            $permission_parent_id = $permission_parent->id;

            $permission_model = new \App\Model\AdminPermissionModel();
            set_save_data($permission_model, [
                'name' => '广告列表',
                'description' => '广告列表',
                'code' => 'Advertising@index',
                'level' => 2,
                'parent_id' => $permission_parent_id
            ]);
            $res = $permission_model->save();
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            $res = \DB::table('admin_permission')->insert([
                'name' => '广告详情',
                'level' => 2,
                'parent_id' => $permission_parent_id,
                'description' => '广告详情',
                'code' => 'Advertising@show'
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            $res = \DB::table('admin_permission')->insert([
                'name' => '添加广告',
                'level' => 2,
                'parent_id' => $permission_parent_id,
                'description' => '添加广告',
                'code' => 'Advertising@store'
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            $res = \DB::table('admin_permission')->insert([
                'name' => '编辑广告',
                'level' => 2,
                'parent_id' => $permission_parent_id,
                'description' => '编辑广告',
                'code' => 'Advertising@update'
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            $res = \DB::table('admin_permission')->insert([
                'name' => '删除广告',
                'level' => 2,
                'parent_id' => $permission_parent_id,
                'description' => '删除广告',
                'code' => 'Advertising@destroy'
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            // 添加菜单权限关联
            $res = \DB::table('admin_permission_menu')->insert([
                'admin_permission_id' => $menu_model->id,
                'admin_menu_id' => $permission_model->id
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            // 增加配置表数据
            $res = \DB::table('config')->insert([
                'code' => 'advertising_position',
                'desc' => '广告位置',
                'value' => '{"app":[{"id":1,"name":"首页轮播图"},{"id":2,"name":"个人中心"}],"pc":[{"id":1,"name":"首页轮播图"},{"id":2,"name":"个人中心"}],"phone":[{"id":1,"name":"首页轮播图"},{"id":2,"name":"个人中心"}]}',
                'is_show' => '0',
                'created_at' => '0',
                'updated_at' => '1522207126',
                'is_on' => '1',
            ]);
            if (!$res) {
                throw new ApiException('插入必要数据报错');
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            $this->error($e);
            return false;
        }
    }
}

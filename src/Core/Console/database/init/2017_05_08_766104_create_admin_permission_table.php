<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('admin_permission', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 255)->comment("权限名称")->default("");
            $table->string('code', 255)->comment("规则代码")->default("");
            $table->string('description', 255)->comment("描述")->default("");
            $table->integer('parent_id')->length(11)->unsigned()->comment("父级id")->default("0");
            $table->tinyInteger('level')->length(1)->unsigned()->comment("层级，1级为组，2级为权限")->default("2");
            $table->integer('sort')->length(1)->unsigned()->comment("排序(从小到大)")->default("1");
            $table->integer('created_at')->length(11)->unsigned()->comment("创建时间")->default("0");
            $table->integer('updated_at')->length(11)->unsigned()->comment("更新时间")->default("0");
            $table->tinyInteger('is_on')->length(1)->unsigned()->comment("0为已删除，1为正常")->default("1");
            $table->comment = '后台管理权限表';
            $table->engine = 'InnoDB';
        });

        DB::table('admin_permission')->insert([
            'id' => '1',
            'name' => '管理员管理',
            'code' => '',
            'description' => '管理员管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117247',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '2',
            'name' => '角色管理',
            'code' => '',
            'description' => '角色管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117253',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '3',
            'name' => '权限管理',
            'code' => '',
            'description' => '权限管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117261',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '4',
            'name' => '菜单管理',
            'code' => '',
            'description' => '菜单管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117266',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '5',
            'name' => '文章管理',
            'code' => '',
            'description' => '文章管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117272',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '6',
            'name' => '文章分类',
            'code' => '',
            'description' => '文章分类权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117278',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '7',
            'name' => '文章标签管理',
            'code' => '',
            'description' => '文章标签管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1493117283',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '8',
            'name' => '管理员列表',
            'code' => 'AdminUser@index',
            'description' => '管理员列表',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '9',
            'name' => '添加管理员',
            'code' => 'AdminUser@store',
            'description' => '添加管理员',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '10',
            'name' => '编辑管理员',
            'code' => 'AdminUser@update',
            'description' => '编辑管理员',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '11',
            'name' => '删除管理员',
            'code' => 'AdminUser@destroy',
            'description' => '删除管理员',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '12',
            'name' => '角色列表',
            'code' => 'AdminRole@index',
            'description' => '角色列表',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '13',
            'name' => '添加角色',
            'code' => 'AdminRole@store',
            'description' => '添加角色',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '14',
            'name' => '编辑角色',
            'code' => 'AdminRole@update',
            'description' => '编辑角色',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '15',
            'name' => '删除角色',
            'code' => 'AdminRole@destroy',
            'description' => '删除角色',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '16',
            'name' => '修改角色权限',
            'code' => 'AdminRolePermission@update',
            'description' => '修改角色权限',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '6',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '17',
            'name' => '查看角色权限',
            'code' => 'AdminRolePermission@index',
            'description' => '查看角色权限',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '7',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '18',
            'name' => '权限列表',
            'code' => 'AdminPermission@index',
            'description' => '权限列表',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '19',
            'name' => '添加权限',
            'code' => 'AdminPermission@store',
            'description' => '添加权限',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '20',
            'name' => '编辑权限',
            'code' => 'AdminPermission@update',
            'description' => '编辑权限',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '21',
            'name' => '删除权限',
            'code' => 'AdminPermission@destroy',
            'description' => '删除权限',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '22',
            'name' => '查看权限菜单',
            'code' => 'AdminPermissionMenu@index',
            'description' => '查看权限菜单',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '6',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '23',
            'name' => '修改权限菜单',
            'code' => 'AdminPermissionMenu@update',
            'description' => '修改权限菜单',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '7',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '24',
            'name' => '菜单列表',
            'code' => 'AdminMenu@index',
            'description' => '菜单列表',
            'parent_id' => '4',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '25',
            'name' => '添加菜单',
            'code' => 'AdminMenu@store',
            'description' => '添加菜单',
            'parent_id' => '4',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '26',
            'name' => '编辑菜单',
            'code' => 'AdminMenu@update',
            'description' => '编辑菜单',
            'parent_id' => '4',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '27',
            'name' => '删除菜单',
            'code' => 'AdminMenu@destroy',
            'description' => '删除菜单',
            'parent_id' => '4',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '28',
            'name' => '文章列表',
            'code' => 'Article@index',
            'description' => '文章列表',
            'parent_id' => '5',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '29',
            'name' => '添加文章',
            'code' => 'Article@store',
            'description' => '添加文章',
            'parent_id' => '5',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '30',
            'name' => '编辑文章',
            'code' => 'Article@update',
            'description' => '编辑文章',
            'parent_id' => '5',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '31',
            'name' => '删除文章',
            'code' => 'Article@destroy',
            'description' => '删除文章',
            'parent_id' => '5',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '32',
            'name' => '文章分类列表',
            'code' => 'ArticleCategory@index',
            'description' => '文章分类列表',
            'parent_id' => '6',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '33',
            'name' => '添加文章分类',
            'code' => 'ArticleCategory@store',
            'description' => '添加文章分类',
            'parent_id' => '6',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '34',
            'name' => '编辑文章分类',
            'code' => 'ArticleCategory@update',
            'description' => '编辑文章分类',
            'parent_id' => '6',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '35',
            'name' => '删除文章分类',
            'code' => 'ArticleCategory@destroy',
            'description' => '删除文章分类',
            'parent_id' => '6',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '36',
            'name' => '文章标签列表',
            'code' => 'ArticleTag@index',
            'description' => '文章标签列表',
            'parent_id' => '7',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '37',
            'name' => '添加文章标签',
            'code' => 'ArticleTag@store',
            'description' => '添加文章标签',
            'parent_id' => '7',
            'level' => '2',
            'sort' => '3',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '38',
            'name' => '编辑文章标签',
            'code' => 'ArticleTag@update',
            'description' => '编辑文章标签',
            'parent_id' => '7',
            'level' => '2',
            'sort' => '4',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '39',
            'name' => '删除文章标签',
            'code' => 'ArticleTag@destroy',
            'description' => '删除文章标签',
            'parent_id' => '7',
            'level' => '2',
            'sort' => '5',
            'created_at' => '1492763092',
            'updated_at' => '1492763092',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '40',
            'name' => '会员管理',
            'code' => '',
            'description' => '会员管理权限组',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1493117215',
            'updated_at' => '1493117295',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '41',
            'name' => '会员列表',
            'code' => 'User@index',
            'description' => '会员列表',
            'parent_id' => '40',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1493117331',
            'updated_at' => '1493117351',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '48',
            'name' => '管理员操作日志',
            'code' => 'SystemLog@index',
            'description' => '管理员操作日志',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '6',
            'created_at' => '1493868394',
            'updated_at' => '1493881385',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '50',
            'name' => '权限详情',
            'code' => 'AdminPermission@show',
            'description' => '权限详情',
            'parent_id' => '3',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493879908',
            'updated_at' => '1493879908',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '51',
            'name' => '管理员详情',
            'code' => 'AdminUser@show',
            'description' => '管理员详情',
            'parent_id' => '1',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493880468',
            'updated_at' => '1493880468',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '52',
            'name' => '角色详情',
            'code' => 'AdminRole@show',
            'description' => '角色详情',
            'parent_id' => '2',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493880733',
            'updated_at' => '1493880733',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '54',
            'name' => '菜单详情',
            'code' => 'AdminMenu@show',
            'description' => '菜单详情',
            'parent_id' => '4',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493880923',
            'updated_at' => '1493880923',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '55',
            'name' => '文章详情',
            'code' => 'Article@show',
            'description' => '文章详情',
            'parent_id' => '5',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493880983',
            'updated_at' => '1493880983',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '56',
            'name' => '文章分类详情',
            'code' => 'ArticleCategory@show',
            'description' => '文章分类详情',
            'parent_id' => '6',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493881058',
            'updated_at' => '1493881058',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '57',
            'name' => '文章标签详情',
            'code' => 'ArticleTag@show',
            'description' => '文章标签详情',
            'parent_id' => '7',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493881259',
            'updated_at' => '1493881259',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '58',
            'name' => '会员详情',
            'code' => 'User@show',
            'description' => '会员详情',
            'parent_id' => '40',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1493881352',
            'updated_at' => '1493881352',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '59',
            'name' => '其它',
            'code' => '',
            'description' => '其它',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1493881868',
            'updated_at' => '1493881868',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '60',
            'name' => '系统设置',
            'code' => '',
            'description' => '系统设置',
            'parent_id' => '0',
            'level' => '1',
            'sort' => '1',
            'created_at' => '1493881868',
            'updated_at' => '1493881868',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '61',
            'name' => '基础设置列表',
            'code' => 'Config@index',
            'description' => '基础设置列表',
            'parent_id' => '60',
            'level' => '2',
            'sort' => '1',
            'created_at' => '1493881868',
            'updated_at' => '1493881868',
            'is_on' => '1',
        ]);

        DB::table('admin_permission')->insert([
            'id' => '62',
            'name' => '编辑基础设置',
            'code' => 'Config@update',
            'description' => '编辑基础设置',
            'parent_id' => '60',
            'level' => '2',
            'sort' => '2',
            'created_at' => '1493881868',
            'updated_at' => '1493881868',
            'is_on' => '1',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('admin_permission');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('admin_role_permission', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('admin_role_id')->length(11)->unsigned()->defalut("0");
            $table->integer('admin_permission_id')->length(11)->unsigned()->defalut("0");
            $table->comment = '后台管理员角色权限表';
            $table->engine = 'InnoDB';
        });

        DB::table('admin_role_permission')->insert([
            'id' => '215',
            'admin_role_id' => '4',
            'admin_permission_id' => '12',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '216',
            'admin_role_id' => '4',
            'admin_permission_id' => '13',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '217',
            'admin_role_id' => '4',
            'admin_permission_id' => '14',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '218',
            'admin_role_id' => '4',
            'admin_permission_id' => '15',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '219',
            'admin_role_id' => '4',
            'admin_permission_id' => '16',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '220',
            'admin_role_id' => '4',
            'admin_permission_id' => '17',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '221',
            'admin_role_id' => '4',
            'admin_permission_id' => '52',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '222',
            'admin_role_id' => '4',
            'admin_permission_id' => '8',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '223',
            'admin_role_id' => '4',
            'admin_permission_id' => '9',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '224',
            'admin_role_id' => '4',
            'admin_permission_id' => '10',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '225',
            'admin_role_id' => '4',
            'admin_permission_id' => '11',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '226',
            'admin_role_id' => '4',
            'admin_permission_id' => '48',
        ]);

        DB::table('admin_role_permission')->insert([
            'id' => '227',
            'admin_role_id' => '4',
            'admin_permission_id' => '51',
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('admin_role_permission');
    }
}

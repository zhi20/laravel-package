<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogAdminActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('log_admin_action', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('admin_id')->length(11)->unsigned()->default("0");
            $table->string('content', 5000)->comment("操作内容")->default("");
            $table->integer('ip')->length(11)->default("0");
            $table->text('data');
            $table->string('code', 255)->comment("操作控制器代码")->default("");
            $table->integer('created_at')->length(11)->unsigned()->comment("创建时间")->default("0");
            $table->integer('updated_at')->length(11)->unsigned()->comment("更新时间")->default("0");
            $table->comment = '管理员操作日志表';
            $table->engine = 'InnoDB';
        });

        DB::table('log_admin_action')->insert([
            'id' => '443',
            'admin_id' => '1',
            'content' => '登录到后台管理系统',
            'ip' => '168298521',
            'data' => '{"account":"admin","password":"4297f44b13955235245b2497399d7a93"}',
            'code' => 'LoginController@store',
            'created_at' => '1494224194',
            'updated_at' => '1494224194',
        ]);

        DB::table('log_admin_action')->insert([
            'id' => '444',
            'admin_id' => '1',
            'content' => '登录到后台管理系统',
            'ip' => '167837963',
            'data' => '{"account":"admin","password":"4297f44b13955235245b2497399d7a93"}',
            'code' => 'LoginController@store',
            'created_at' => '1494224242',
            'updated_at' => '1494224242',
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('log_admin_action');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:models {model?} {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all model files';

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
        $tables = $this->argument('model');
        if(empty($tables)){
            //获取当前所有表
            $tables = array_map('reset', \DB::select('SHOW TABLES'));
        }else{
            $tables = explode(',', $tables);
        }
        //获取模板文件
        $template = file_get_contents(app_path('Console/Stub').'/model.stub');
        $template_method = file_get_contents(app_path('Console/Stub').'/model_method.stub');

        //model文件目录
        $model_path = app_path() . '/Model';
        $path = $this->argument('path');
        $path =trim($path, '/');
        if(!empty($model_path)){
            $model_path = $model_path . '/'.$path;
        }
        //加载helper
        load_helper('File');

        foreach ($tables as $key => $v) {
            $class_name = studly_case($v) . 'Model';
            $file_name = $class_name . '.php';
            $file_path = $model_path . '/' . $file_name;

            //判断文件是否存在,存在则跳过
            if (file_exists($file_path)) {
                continue;
            }

            //查询所有字段
            $columns_ide = '';
            $columns = \DB::select('SHOW COLUMNS FROM `' . $v . '`');
            foreach ($columns as $vv) {

                if (strpos($vv->Type, "int") !== false)
                    $type = 'int';
                else if (strpos($vv->Type, "varchar") !== false || strpos($vv->Type, "char") !== false || strpos($vv->Type, 'blob') || strpos($vv->Type, "text") !== false) {
                    $type = "string";
                } else if (strpos($vv->Type, "decimal") !== false || strpos($vv->Type, "float") !== false || strpos($vv->Type, "double") !== false) {
                    $type = "float";
                }
                else{
                    $type = 'string';
                }

                $columns_ide .= ' * @property ' . $type . ' $' . $vv->Field.PHP_EOL;
            }

            $columns_ide.=' *';
            $template_temp = $template;
            if(!empty($path)){                              //判断是否有下级目录
                $template_temp = str_replace('{{path}}', '\\'.$path, $template_temp);
                $source_method=str_replace('{{class_name}}', '\App\Model\\'.$path.'\\'.$class_name, $template_method);
            }else{
                $template_temp = str_replace('{{path}}', '', $template_temp);
                $source_method=str_replace('{{class_name}}', '\App\Model\\'.$class_name, $template_method);
            }
            $source = str_replace('{{class_name}}', $class_name, $template_temp);
            $source = str_replace('{{table_name}}', $v, $source);
            $source = str_replace('{{ide_property}}', $columns_ide, $source);
            $source = str_replace('{{ide_method}}', $source_method, $source);

            //写入文件
            if (!dir_exists($model_path)) {
                $this->error('目录' . $model_path . ' 无法写入文件,创建' . $class_name . ' 失败');
                continue;
            }

            if (file_put_contents($file_path, $source)) {
                $this->info($class_name . '添加类成功');
            } else {
                $this->error($class_name . '类写入失败');
            }

        }

    }

}

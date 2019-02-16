<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class MakeInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makefile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量生成文件';

    protected $filelist = [];

    protected $replace =[
      'name_space'  =>'{{name_space}}',
      'class_name'  =>'{{class_name}}',
    ];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->filelist = [
            'Controller'=>[
                'Admin'=>[
                    'Goods'=>['Goods', 'Goods_module_linked', 'Goods_search', 'Goods_type','goods_module_process'],
                    "Order"=>['Order', 'OrderGoods', 'Goods_order_attribute', 'Pay_order', 'Spread_order', 'withdraw_order'],
                    'Module', 'pay', 'recommend', 'spread', 'upload', 'withdraw','attribute_type',
                    'User'=>['user', 'user_search_goods_linked', 'user_capital', 'user_bills_income', 'user_bills_expenses', 'user_bank_card', 'user_address'],
                    "Log"=>['Pay_log', 'Sms_log', 'ErrorLog', 'user_login_log'],
                    "Wechat"=>['wechat_user', 'wechat_menu', 'wechat_account']
                ]
            ],
            'Logic'=>[
                'Admin'=>[
                    'Goods'=>['Goods', 'Goods_module_linked', 'Goods_search', 'Goods_type','goods_module_process'],
                    "Order"=>['Order', 'OrderGoods', 'Goods_order_attribute', 'Pay_order', 'Spread_order', 'withdraw_order'],
                    'Module', 'pay', 'recommend', 'spread', 'upload', 'withdraw','attribute_type',
                    'User'=>['user', 'user_search_goods_linked', 'user_capital', 'user_bills_income', 'user_bills_expenses', 'user_bank_card', 'user_address'],
                    "Log"=>['Pay_log', 'Sms_log', 'ErrorLog', 'user_login_log'],
                    "Wechat"=>['wechat_user', 'wechat_menu', 'wechat_account']
                ]
            ],
            'View'=>[
                'Admin'=>[
                    'Goods'=>['Goods', 'Goods_module_linked', 'Goods_search', 'Goods_type','goods_module_process'],
                    "Order"=>['Order', 'OrderGoods', 'Goods_order_attribute', 'Pay_order', 'Spread_order', 'withdraw_order'],
                    'Module', 'pay', 'recommend', 'spread', 'upload', 'withdraw','attribute_type',
                    'User'=>['user', 'user_search_goods_linked', 'user_capital', 'user_bills_income', 'user_bills_expenses', 'user_bank_card', 'user_address'],
                    "Log"=>['Pay_log', 'Sms_log', 'ErrorLog', 'user_login_log'],
                    "Wechat"=>['wechat_user', 'wechat_menu', 'wechat_account']
                ]
            ],
            'Model'=>[

            ],
            'Event'=>[

            ],
            'Exception'=>[

            ],
            'Provider'=>[

            ],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $output = [];
        foreach ($this->filelist as $appendSuffix =>$list){
            switch ($appendSuffix){
                case 'Controller':
                    $this->createBase($appendSuffix,'Http'.DIRECTORY_SEPARATOR.'Controllers');
                    $this->createCommand($list, $appendSuffix, 'Http'.DIRECTORY_SEPARATOR.'Controllers');
                    break;
                case 'Logic':
                    $this->createBase($appendSuffix,'Logic');
                    $this->createCommand($list, $appendSuffix, 'Logic');
                    break;
                case "Model":
                    $this->createCommand($list, $appendSuffix, '');
                    break;
                case "View":
                    $this->createCommand($list,$appendSuffix, '');
                    break;
                default:
                    foreach ($list as $command){
                        $command = 'php artisan make:'.strtolower($appendSuffix). ' ' .$command;
                        $this->execSystem($command,$output);
                    }
                    foreach ($output as $string){
                        $this->info($string);
                    }
            }
        }
        //根据数据库生成model
//        $this->execSystem('php artisan create:models');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub( $name )
    {
       return  file_get_contents(dirname(dirname(__FILE__)) . '/Stub/'.strtolower($name).'.stub');
    }

    /** 模板生成 */
    protected function createStub($template, $replace, $path){
        //检查目录
        if(! file_exists($path)){
            @make_dir(dirname($path));
            //替换变量
            $source = str_replace(array_keys($replace), array_values($replace), $template);

            return file_put_contents($path,$source);
        }
        return null;
    }

    /** 创建Base 基类 */
    protected function createBase($appendSuffix, $path){

        $template = $this->getStub('base'.strtolower($appendSuffix));

        if($this->createStub($template, [],
            app_path($path) .DIRECTORY_SEPARATOR . 'Base' . $appendSuffix.'.php')){
            $this->info( 'Base' . $appendSuffix . '添加成功');
        } else {
            $this->error( 'Base' . $appendSuffix . '添加失败');
        }
    }

    
    
    /** 生成指令 */
    protected function createCommand($list, $appendSuffix, $path)
    {
        foreach($list as $key => $command){
            if(!is_numeric($key)){
                $dir =  $path . DIRECTORY_SEPARATOR . $key;
            }else{
                $dir = $path;
            }
            if(is_array($command)){
                $this->createCommand($command, $appendSuffix, $dir);
            }else{
                switch ($appendSuffix){
                    case "Controller":
                    case 'Logic':
                        $this->createFile(studly_case($command), $appendSuffix, $dir);
                        break;
                    case "View":
                        $this->createViewFile(studly_case($command),  $dir);
                        break;
                    case "Model":
                        $command = 'php artisan create:models '.$command . " " . $dir;
                        $this->execSystem($command,$output);
                        break;
                }
               
            }
        }
    }
    
    /** 创建文件 */
    protected function createFile($controller, $appendSuffix, $path)
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        //类名
        $className = class_basename($controller) . $appendSuffix;

        //文件路径
        $filePath = app_path($path) . DIRECTORY_SEPARATOR . $controller . $appendSuffix . '.php';

        //文件目录路径
        $dirPath = dirname($filePath);

        //命名空间
        $nameSpace = str_replace(DIRECTORY_SEPARATOR, '\\', str_replace(app_path(),'App', $dirPath));

        $template = $this->getStub(strtolower($appendSuffix));
        $result =  $this->createStub($template, [
            $this->replace['class_name']=>$className,
            $this->replace['name_space']=>$nameSpace
        ], $filePath);
        if($result){
            $this->info( $className. '添加成功');
        } else {
            $this->error( $className . '添加失败');
        }
    }



    /** 执行命令 */
    protected function execSystem($command, &$output = null)
    {
        if(system($command,$output)){
            $this->info($command . '添加成功');
        } else {
            $this->error($command . '添加失败');
        }
    }

    /** 创建视图模板 */
    protected function createViewFile($name,  $dir)
    {
        $path = 'views';
        if(!empty($dir)){
            $path .= DIRECTORY_SEPARATOR . trim($dir, DIRECTORY_SEPARATOR);
        }
        $path .=  DIRECTORY_SEPARATOR . trim($name, DIRECTORY_SEPARATOR) ;
        //文件路径
        $indexPath = resource_path($path) . DIRECTORY_SEPARATOR .'index.blade.php';
        $formPath = resource_path($path) . DIRECTORY_SEPARATOR .'form.blade.php';
        if(
            ! $this->createStub( $this->getStub('view_index'), [
        ], $indexPath)
        ){
            $this->error( $name . 'index添加失败');
        }
        if(
            ! $this->createStub( $this->getStub('view_form'), [
        ], $formPath)){
            $this->error( $name . 'form添加失败');
        }
            $this->info( $name. 'View添加完成');
    }
}
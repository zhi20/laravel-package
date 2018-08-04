<?php

namespace Zhi20\Laravel\Core;

use Illuminate\Support\ServiceProvider;

class CoreProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //是否有设置代理,有则获取设置为代理
        if (!empty(config('app.proxy_ips'))) {
            Request()->setTrustedProxies(config('app.proxy_ips'));
        }

        //注册资源
        $this->registerResources();
        //注册helper
        $this->registerHelpers();
        //注册调试模式
        $this->registerDebugMode();
        //注册路由
        $this->registerRoutes();
        //注册自动生成命令
        $this->registerConsoleCommand();

        require __DIR__ . '/../Opcache/routes/web.php';

        //horizon权限验证
        if (class_exists(\Laravel\Horizon\Horizon::class) && config('app.env') != 'local') {
            //权限
            \Horizon::auth(function ($request) {
                if (!$this->validateBasicHorizon(@$_SERVER['PHP_AUTH_USER'], @$_SERVER['PHP_AUTH_PW'])) {
                    http_response_code(401);
                    header('WWW-Authenticate:Basic realm="My Horizon"'); //对话框显示 http://127.0.0.3 请求用户名和密码。信息为：My website
                    exit;
                } else {
                    return true;
                }
            });
        }

        try {
            $this->slowRunning();
        } catch (\Exception $e) {
            //略过
        }

    }

    /**
     * @param $user
     * @param $pass
     * @return bool
     */
    protected function validateBasicHorizon($user, $pass)
    {
        if (empty(config('horizon.auth.username')) || empty(config('horizon.auth.password'))) {
            return false;
        }

        if (!($user == config('horizon.auth.username') && config('horizon.auth.password') == $pass)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Register the resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Zhi20-package');
    }

    /**
     * Register the Routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {

        if (!$this->app->routesAreCached()) {

            //用户模块
            if (file_exists(base_path('routes/user.php'))) {
                \Route::prefix('api')
                    ->middleware('api')
                    ->namespace('\App\Http\Controllers')
                    ->group(base_path('routes/user.php'));
            }

            //支付模块
            if (file_exists(base_path('routes/pay.php'))) {
                \Route::prefix('api')
                    ->middleware('api')
                    ->namespace('\App\Http\Controllers')
                    ->group(base_path('routes/pay.php'));
            }

            //商城模块
            if (file_exists(base_path('routes/shop.php'))) {
                \Route::prefix('api')
                    ->middleware('api')
                    ->namespace('\App\Http\Controllers')
                    ->group(base_path('routes/shop.php'));
            }

            //微信模块
            if (file_exists(base_path('routes/wechat.php'))) {
                \Route::prefix('api')
                    ->middleware('api')
                    ->namespace('\App\Http\Controllers')
                    ->group(base_path('routes/wechat.php'));
            }
        }
    }

    /**
     * Register the Console Command.
     *
     * @return void
     */
    protected function registerConsoleCommand()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([

                //Create
                \Zhi20\Laravel\Core\Console\CreateModel::class,
                \Zhi20\Laravel\Core\Console\CreateModelDoc::class,
                \Zhi20\Laravel\Core\Console\CreateController::class,
                \Zhi20\Laravel\Core\Console\CreateLogic::class,
                \Zhi20\Laravel\Core\Console\CreateTest::class,
                \Zhi20\Laravel\Core\Console\CreateSeeder::class,
                \Zhi20\Laravel\Core\Console\CreateMigration::class,
                \Zhi20\Laravel\Core\Console\CreatePermission::class,

                \Zhi20\Laravel\Core\Console\Config::class,
                \Zhi20\Laravel\Core\Console\Supervisor::class,
                \Zhi20\Laravel\Core\Console\Upload::class,

                //模块
                \Zhi20\Laravel\Modules\Version\VersionCommand::class,
                \Zhi20\Laravel\Modules\Advertising\AdvertisingCommand::class,
                \Zhi20\Laravel\Modules\Payment\PaymentCommand::class,
                \Zhi20\Laravel\Modules\Sms\SmsCommand::class,
                \Zhi20\Laravel\Sms\Console\SmsTableCommand::class,
                \Zhi20\Laravel\Sms\Console\SmsCommand::class,
                \Zhi20\Laravel\Sms\Console\SmsTemplateCommand::class,
                \Zhi20\Laravel\Wechat\Console\WechatCommand::class,
                \Zhi20\Laravel\Area\Console\AreaCommand::class,

                //Signature
                \Zhi20\Laravel\Signature\Console\SignatureTableCommand::class,
                \Zhi20\Laravel\Signature\Console\SignatureInitCommand::class,
                \Zhi20\Laravel\Signature\Console\SignatureAddCommand::class,
                \Zhi20\Laravel\Signature\Console\SignatureTableCommand::class,

                //Opcache
                \Zhi20\Laravel\Opcache\Console\Clear::class,
                \Zhi20\Laravel\Opcache\Console\Config::class,
                \Zhi20\Laravel\Opcache\Console\Optimize::class,
                \Zhi20\Laravel\Opcache\Console\Status::class,
            ]);
        }
    }

    /**
     * Register the Helpers.
     *
     * @return void
     */
    protected function registerHelpers()
    {
        $this->app->singleton('jiaoleo_helper', function () {
            return new \Zhi20\Laravel\Core\Helper\HelperInstance();
        });
        //实例化
        $this->app->make('jiaoleo_helper');
    }

    /**
     * Register the Debug Mode.
     *
     * @return void
     */
    protected function registerDebugMode()
    {
        //调试模式
        if (config('app.debug') === true) {
            //注册路由
            if (!$this->app->routesAreCached()) {
                require __DIR__ . '/routes/debug.php';
            }
            new \Zhi20\Laravel\Core\Debuger();
        }
    }

    /**
     * 执行慢的日志
     */
    protected function slowRunning()
    {
        if (config('app.env') != 'local') {
            app()->terminating(function () {
                if (app()->runningInConsole()) {
                    return true;
                }

                $run_time = get_run_time(0, microtime(true));

                //大于一秒
                if ($run_time > 1000) {
                    $route_info = \Route::getCurrentRoute();

                    $data = [
                        'request_uri' => request()->getRequestUri(),
                        'controller' => $route_info->action['controller'],
                        'post_data' => request()->method() == 'GET' ? [] : request()->request->all(),
                        'run_time' => $run_time
                    ];

                    //新建一个log实例
                    $logger = new \Monolog\Logger('Zhi20-slowRunning');
                    $file_name = 'slow-' . date('Y-m-d') . '.log';
                    $log_path = storage_path('slowRunning/' . $file_name);
                    $stream = new \Monolog\Handler\StreamHandler($log_path, \Monolog\Logger::DEBUG);
                    $dateFormat = "[Y-m-d H:i:s]";
                    $output = "%datetime% %message%" . PHP_EOL;
                    $formatter = new \Monolog\Formatter\LineFormatter($output, $dateFormat);
                    $stream->setFormatter($formatter);
                    $logger->pushHandler($stream);

                    $logger->debug('详细: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
                }
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

<?php
namespace JiaLeo\Laravel\Swoole;

use Illuminate\Support\ServiceProvider;

class SwooleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //注册自动生成命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                'JiaLeo\Laravel\Swoole\Console\CreateSwoole',
                'JiaLeo\Laravel\Swoole\Console\Register',
                'JiaLeo\Laravel\Swoole\Console\Gateway',
                'JiaLeo\Laravel\Swoole\Console\Worker',
                'JiaLeo\Laravel\Swoole\Console\Swoole',
            ]);
        }

        //报表功能后面再更新
        //$this->registerResources();
        //$this->registerRoutes();
    }

    /**
     * Register the Swoole resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'jialeo-swoole');
    }

    /**
     * Register the Swoole routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        \Route::group([
            'prefix' => config('swoole.laravel.uri', 'swoole'),
            'namespace' => 'JiaLeo\Laravel\Swoole\Http\Controllers',
            'middleware' => config('swoole.laravel.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
<?php
namespace Zhi20\Laravel\Swoole;

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
                'Zhi20\Laravel\Swoole\Console\CreateSwoole',
                'Zhi20\Laravel\Swoole\Console\Register',
                'Zhi20\Laravel\Swoole\Console\Gateway',
                'Zhi20\Laravel\Swoole\Console\Worker',
                'Zhi20\Laravel\Swoole\Console\Swoole',
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Zhi20-swoole');
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
            'namespace' => 'Zhi20\Laravel\Swoole\Http\Controllers',
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
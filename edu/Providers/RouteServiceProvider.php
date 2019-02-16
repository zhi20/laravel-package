<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //模块路由注册
//        $requestUri = $_SERVER['REQUEST_URI'];
        Route::namespace($this->namespace)->middleware('api')->group(function () {
            $request =  request();
            $requestUri = $request->server->get('REQUEST_URI');
            if(strpos($requestUri,'?')){
                $requestUri = strstr($requestUri,"?",true);
            }
            if(strpos($requestUri,'/')===0){
                $requestUri = substr($requestUri,1);
            }
            $args = explode('/', $requestUri);
            $args = array_map('studly_case',$args);             //下划线转大写
            //以M开头是模块化路由
            $start = array_shift($args);
            if('M' == $start)
            {
                $action = array_pop($args);
                $class = implode('\\',$args);
//            $action = basename($requestUri);
//            $class = str_replace('/','\\',dirname($requestUri));
                Route::any($requestUri,$class . 'Controller' .'@'.$action)->middleware(['Permission']);
            }
            elseif (\App\Support\ModuleSupport::MODULE_NAME == $start)
            {
                $action = array_pop($args);
                $class = implode('\\',$args);
                Route::any($requestUri, $start.'\\'.$class . 'Controller' .'@'.$action)->middleware(['user', 'login', 'moduleAuth']);
            }


        });
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }
}

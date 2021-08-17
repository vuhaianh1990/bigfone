<?php

namespace AV_Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use AV_Core\Http\Middleware\VerifyJWTToken;
use AV_Core\Http\Middleware\AclMiddleware;
use AV_Core\Http\Middleware\CheckSuperAdmin;
use Tymon\JWTAuth\Middleware\RefreshToken;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'AV_Core\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        // $router->pushMiddlewareToGroup('web', Locale::class);
        $router->aliasMiddleware('jwt.auth', VerifyJWTToken::class);
        $router->aliasMiddleware('jwt.refresh', RefreshToken::class);
        $router->aliasMiddleware('role', AclMiddleware::class);
        $router->aliasMiddleware('isAdmin', CheckSuperAdmin::class);
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
             ->group(base_path('core/routes/web.php'));
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
             ->group(base_path('core/routes/api.php'));
    }
}

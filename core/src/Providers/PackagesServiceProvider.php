<?php

namespace AV_Core\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Laravel\Socialite\SocialiteServiceProvider;
use Tymon\JWTAuth\Providers\JWTAuthServiceProvider;
use Yajra\DataTables\DataTablesServiceProvider;
use Weidner\Goutte\GoutteServiceProvider;
use Illuminate\Foundation\AliasLoader;

use Barryvdh\Debugbar\Facade;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Yajra\DataTables\Facades\DataTables;
use Weidner\Goutte\GoutteFacade;

class PackagesServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(DebugbarServiceProvider::class);
        $this->app->register(SocialiteServiceProvider::class);
        $this->app->register(JWTAuthServiceProvider::class);
        $this->app->register(DataTablesServiceProvider::class);
        $this->app->register(GoutteServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Debugbar', Facade::class);
        $loader->alias('Socialite', Socialite::class);
        $loader->alias('JWTAuth', JWTAuth::class);
        $loader->alias('JWTFactory', JWTFactory::class);
        $loader->alias('DataTables', DataTables::class);
        $loader->alias('Goutte', GoutteFacade::class);
    }
}

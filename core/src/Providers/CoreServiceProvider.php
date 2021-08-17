<?php

namespace AV_Core\Providers;

use Illuminate\Support\ServiceProvider;
use AV_Core\Providers\RouteServiceProvider;
use AV_Core\Providers\PackagesServiceProvider;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Set config facebook
        if (!config('services.facebook')) {
            $fb_config = [
                'client_id'     => env('FACEBOOK_APP_ID'),
                'client_secret' => env('FACEBOOK_APP_SECRET'),
                'redirect'      => env('FACEBOOK_APP_CALLBACK_URL'),
            ];
            \Config::set('services.facebook', $fb_config);
        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        // Load modules
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PackagesServiceProvider::class);

        $this->loadViewsFrom(base_path('core/resources/views'), 'av_core');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/wisdmlabs/todolist'),
        // ]);
    }
}

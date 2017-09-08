<?php

namespace Zein\Zacl;

use Illuminate\Support\ServiceProvider;

class ZaclServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->publishes([
            __DIR__.'/config/config.php' => app()->basePath() . '/config/zacl.php',
        ]);
        $this->publishes([
            __DIR__.'/migrations' => base_path('database/migrations'),
        ],'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Zein\Zacl\Controllers\PermissionsController');
        $this->app->make('Zein\Zacl\Controllers\PermissionsrolesController');
        $this->app->make('Zein\Zacl\Controllers\RolesController');
        $this->app->make('Zein\Zacl\Controllers\RolesusersController');
        
    }
    
}

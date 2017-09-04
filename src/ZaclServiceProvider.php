<?php

namespace Zein\Zacl;

use Illuminate\Support\ServiceProvider;
use Zizaco\Entrust\EntrustServiceProvider;

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
            __DIR__.'/config/config.php' => app()->basePath() . '/config/entrust.php',
        ]);
        
        $entrustSP = new EntrustServiceProvider;
        // Register commands
        $entrustSP->commands('command.entrust.migration');

        // Register blade directives
        $entrustSP->bladeDirectives();
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
        
        $entrustSP = new EntrustServiceProvider;
        $entrustSP->registerEntrust();

        $entrustSP->registerCommands();

        $entrustSP->mergeConfig();
        //
    }
    
}

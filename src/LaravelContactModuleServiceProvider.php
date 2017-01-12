<?php

namespace ErenMustafaOzdal\LaravelContactModule;

use Illuminate\Support\ServiceProvider;

class LaravelContactModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-contact-module.php' => config_path('laravel-contact-module.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('ErenMustafaOzdal\LaravelModulesBase\LaravelModulesBaseServiceProvider');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-contact-module.php', 'laravel-contact-module'
        );

        $router = $this->app['router'];
        // model binding
        $router->model(config('laravel-contact-module.url.contact'),  'App\Contact');
    }
}

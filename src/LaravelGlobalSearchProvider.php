<?php

namespace PhpJunior\LaravelGlobalSearch;

use Illuminate\Support\ServiceProvider;
use PhpJunior\LaravelGlobalSearch\Facades\LaravelGlobalSearch as LaravelGlobalSearchFacades;
use PhpJunior\LaravelGlobalSearch\Services\LaravelGlobalSearch;

class LaravelGlobalSearchProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path('laravel-global-search.php')
        ],'laravel-global-search-config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'laravel-global-search');

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('LaravelGlobalSearch', LaravelGlobalSearchFacades::class);
        });

        $this->app->bind('laravel-global-search', function ($app) {
            $config = $app['config'];
            $resources = collect($config->get('laravel-global-search.resources'));
            $search = new LaravelGlobalSearch($resources, $config);
            return $search;
        });
    }

    /**
     * @return string
     */
    protected function configPath()
    {
        return __DIR__.'/../config/laravel-global-search.php';
    }
}

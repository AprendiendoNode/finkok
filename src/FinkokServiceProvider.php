<?php

namespace Gmlo\Finkok;

use Illuminate\Support\ServiceProvider;

class FinkokServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfigFiles();

        /*$this->app->bind(
            'Laracasts\Flash\SessionStore',
            'Laracasts\Flash\LaravelSessionStore'
        );
    */

        $this->app->singleton('finkok', function () {
            return $this->app->make(Finkok::class);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadViewsFrom(__DIR__ . '/../../views', 'flash');
        /*
        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/flash')
        ]);*/
        //$this->loadTranslations();
    }

    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'CFDI');

        /*$this->publishes([
            __DIR__.'/translations' => resource_path('lang/vendor/courier'),
        ]);*/
    }

    /**
    * Load configuration files
    */
    protected function loadConfigFiles()
    {
        $configPath = __DIR__ . '/config/finkok.php';
        $this->mergeConfigFrom($configPath, 'finkok');
    }
}

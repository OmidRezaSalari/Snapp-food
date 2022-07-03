<?php

namespace DelayReport\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DelayReportServiceProvider extends ServiceProvider
{
    private $namespace = "DelayReport\\Controllers";

    public function register()
    {
    }

    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            $this->defineRoutes();
        }

        $this->loadings();
        $this->publish();
    }


    /**
     * Register service routes.
     *
     * @return void
     */
    private function defineRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . './../routes/routes.php');
    }

    /**
     * Publish service config files in that path.
     *
     * @return void
     */
    private function publish(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], "delay-service");
    }

    /**
     * Specify the path of the files to be read from that path.
     *
     * @return void
     */
    private function loadings(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'DelayReportService');

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }
}

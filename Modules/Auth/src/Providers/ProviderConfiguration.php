<?php

namespace Authenticate\Providers;

use Authenticate\Console\Commands\CreateParsPackUserCommand;
use Authenticate\Facades\ResponderFacade;
use Authenticate\Facades\AuthFacade;
use Authenticate\Facades\BaseAuth;
use Authenticate\Facades\VueResponder;
use Authenticate\Models\User;
use Authenticate\Repositories\User\EloquentUserRepositry;
use Authenticate\Repositories\User\UserProviderFacade;
use Illuminate\Support\Facades\Route;

trait ProviderConfiguration
{
    private $namespace = "Authenticate\\Controllers";

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

    private function bindings(): void
    {
        app()->register("Tymon\JWTAuth\Providers\LaravelServiceProvider");

        UserProviderFacade::shouldProxyTo(EloquentUserRepositry::class);
        ResponderFacade::shouldProxyTo(VueResponder::class);
        AuthFacade::shouldProxyTo(BaseAuth::class);
    }

    /**
     * Specify service config.
     *
     * @return void
     */
    private function config(): void
    {

        config()->set('auth.providers.users.model', User::class);
        config()->set('auth.guards.api.driver', "jwt");
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
        ], "auth-service");
    }

    /**
     * Specify the path of the files to be read from that path.
     *
     * @return void
     */
    private function loadings(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'authService');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateParsPackUserCommand::class,
            ]);
        }
    }
}

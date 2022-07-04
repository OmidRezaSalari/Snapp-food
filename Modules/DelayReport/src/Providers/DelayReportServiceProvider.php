<?php

namespace DelayReport\Providers;

use DelayReport\Facades\DelayReport\DelayReportProvider;
use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\DeliveryTime\DeliveryTimeProvider;
use DelayReport\Facades\DeliveryTime\DeliveryTimeProviderFacade;
use DelayReport\Facades\TripHandler\TripHandlerFacade;
use DelayReport\Facades\TripHandler\DeliverdTripHandler;
use DelayReport\Facades\TripHandler\InProcessTripHandler;
use DelayReport\Facades\Order\OrderProvider;
use DelayReport\Facades\Order\OrderProviderFacade;
use DelayReport\Facades\Response\VueResponder;
use DelayReport\Facades\Response\ResponderFacade;
use DelayReport\Facades\Trip\TripProvider;
use DelayReport\Facades\Trip\TripProviderFacade;
use DelayReport\Middleware\IsValidDeliveryTime;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DelayReportServiceProvider extends ServiceProvider
{
    private $namespace = "DelayReport\\Controllers";

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/delivery.php", "delivery");

        OrderProviderFacade::shouldProxyTo(OrderProvider::class);
        TripProviderFacade::shouldProxyTo(TripProvider::class);

        TripProviderFacade::postCall("isValidTrip", function ($methodName, $args, $result) {

            if ($result && $result["status"] !== "DELIVERED") {
                TripHandlerFacade::shouldProxyTo(InProcessTripHandler::class);
            } else {
                TripHandlerFacade::shouldProxyTo(DeliverdTripHandler::class);
            }
        });

        DeliveryTimeProviderFacade::shouldProxyTo(DeliveryTimeProvider::class);
        ResponderFacade::shouldProxyTo(VueResponder::class);
        DelayReportProviderFacade::shouldProxyTo(DelayReportProvider::class);
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

        $this->publishes([
            __DIR__ . '/../config/delivery.php' => config_path('delivery.php')
        ], 'delivery');
    }

    /**
     * Specify the path of the files to be read from that path.
     *
     * @return void
     */
    private function loadings(): void
    {
        app(Router::class)->aliasMiddleware('isValidDeliveryTime', IsValidDeliveryTime::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'DelayReportService');

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }
}

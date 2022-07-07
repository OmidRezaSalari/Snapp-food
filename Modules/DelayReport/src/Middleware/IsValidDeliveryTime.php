<?php

namespace DelayReport\Middleware;

use Closure;
use DelayReport\Facades\Order\OrderProviderFacade;
use DelayReport\Facades\Response\ResponderFacade;

class IsValidDeliveryTime
{
    public function handle($request, Closure $next)
    {
        if ($request['orderId'] && !OrderProviderFacade::isValidDeliveryTime($request['orderId'])) {

            return ResponderFacade::time_delivery_not_exceed();
        }

        return $next($request);
    }
}

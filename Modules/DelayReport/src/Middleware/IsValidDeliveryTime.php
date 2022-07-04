<?php

namespace DelayReport\Middleware;

use Closure;
use DelayReport\Facades\Order\OrderProviderFacade;

class IsValidDeliveryTime
{
    public function handle($request, Closure $next)
    {
        if (!OrderProviderFacade::isValidDeliveryTime($request['orderId'])) {

            return response()->json("not valid");
        }

        return $next($request);
    }
}

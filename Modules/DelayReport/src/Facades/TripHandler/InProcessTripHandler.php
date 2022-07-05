<?php

namespace DelayReport\Facades\TripHandler;

use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\DeliveryTime\DeliveryTimeProviderFacade;
use DelayReport\Facades\Order\OrderProviderFacade;

class InProcessTripHandler
{

    public function handle($orderId)
    {
        $PredictTime = DeliveryTimeProviderFacade::refresh();

        OrderProviderFacade::update(
            $orderId,
            ['time_delivery' => $PredictTime, 'created_at' => now()]
        );

        DelayReportProviderFacade::create(['order-id'=>$orderId,"status"=>"DELAY"]);

        return __("DelayReportService::message.predict-time-to-delivery", ['time' => $PredictTime]);
    }
}

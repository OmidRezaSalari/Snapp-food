<?php

namespace DelayReport\Facades\TripHandler;

use DelayReport\Facades\DelayReport\DelayReportProviderFacade;
use DelayReport\Facades\Message\MessageSenderFacade;

class DeliverdTripHandler
{

    public function handle($orderId)
    {
        
        MessageSenderFacade::send($orderId);

        DelayReportProviderFacade::create(['order-id'=>$orderId,"status"=>"DELAY"]);

        return __("DelayReportService::message.send-to-delay-queue");
    }
}

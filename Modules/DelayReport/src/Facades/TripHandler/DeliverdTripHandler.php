<?php

namespace DelayReport\Facades\TripHandler;

use DelayReport\Facades\Message\MessageSenderFacade;

class DeliverdTripHandler
{

    public function handle($orderId)
    {
        
        MessageSenderFacade::send($orderId);

        return __("DelayReportService::message.send-to-delay-queue");
    }
}

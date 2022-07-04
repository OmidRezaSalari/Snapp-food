<?php

namespace DelayReport\Facades\DeliveryTime;

use Illuminate\Support\Facades\Http;

class DeliveryTimeProvider
{

    /**
     * predict new delivery time
     *
     * @return integer
     */
    public function refresh()
    {
        $response = Http::get(config("delivery.refresh-time-url"));

        return $response->json("data.eta");
    }
}

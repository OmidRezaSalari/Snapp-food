<?php

namespace DelayReport\Facades\Trip;

use DelayReport\Models\Trip;

class TripProvider
{

    /**@var Trip */

    private $trip;

    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * Get deliverd order that exist in trips and with deliverd status.
     *
     * @param int $orderId
     * 
     * @return Trip|null
     */

    public function isValidTrip(int $orderId)
    {
        return  $this->inProcess($orderId) ?? $this->deliverd($orderId);
    }

    /**
     * Get inprocess order that exist in trips
     *
     * @param int $orderId
     * 
     * @return Trip|null
     */
    public function inProcess(int $orderId)
    {
        return $this->trip->where('order_id', $orderId)->inProcess()->first();
    }

    /**
     * Get deliverd order that exist in trips and with deliverd status.
     *
     * @param int $orderId
     * 
     * @return Trip|null
     */
    public function deliverd(int $orderId)
    {
        return $this->trip->where('order_id', $orderId)->deliverd()->first();
    }
}

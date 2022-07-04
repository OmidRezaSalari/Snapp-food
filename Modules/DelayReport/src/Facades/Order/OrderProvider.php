<?php

namespace DelayReport\Facades\Order;

use DelayReport\Models\Order;

class OrderProvider
{

    /** @var Order */

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * check this order has valid delivery time
     *
     * @param string $orderId order unqiue ID
     * 
     * @return boolean
     */
    public function isValidDeliveryTime(int $orderId)
    {

        $order = $this->order->where('id', $orderId)->first();

        return (bool)$order && (now() > $order->created_at->addMinutes($order->time_delivery));
    }

    /**
     * check this order has valid delivery time
     *
     * @param string $orderId order unqiue ID
     * @param array $data order update request fields.
     * 
     * @return boolean
     */
    public function update(int $orderId, array $data)
    {
        $this->order->where('id', $orderId)->update($data);

        return true;
    }
}

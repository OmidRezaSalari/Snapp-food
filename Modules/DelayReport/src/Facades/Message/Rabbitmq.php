<?php

namespace DelayReport\Facades\Message;

class Rabbitmq
{

    private $exchangeName, $exchangeType, $severity;

    public function __construct()
    {
        $this->exchangeName = config('delivery.exchange_name');
        $this->exchangeType = config('delivery.exchange_type');
        $this->severity = config('delivery.exchange_serverity');
        $this->queueName = config('delivery.rabbitmq_queue_name');
    }
    /**
     * send message to rabbitmq queue
     * 
     * @param string|array $message  the content should be send
     * 
     * @return bool
     */

    public function send($message)
    {
        $connection = resolve("AMQPStreamConnection");

        $channel = $connection->channel();

        $channel->exchange_declare($this->exchangeName, $this->exchangeType, false, false, false);

        $msg = resolve("AMQPMessage", [$message]);

        $channel->basic_publish($msg, $this->exchangeName, $this->severity);

        $channel->close();
        $connection->close();

        return true;
    }


    public function recieved()
    {

        $connection = app("AMQPStreamConnection");

        $channel = $connection->channel();

        $channel->exchange_declare($this->exchangeName, $this->exchangeType, false, false, false);

        $queue = $channel->queue_declare($this->queueName, false, true, false, false);


        $channel->queue_bind($queue[0], $this->exchangeName, $this->severity);

        $callback = function ($msg) {
            echo $msg->body . "\n";
            $msg->ack();
        };

        $channel->basic_qos(null, 1, null);


        $channel->basic_consume($queue[0], '', false, false, false, false, $callback);


        if ($channel->basic_get($queue[0])) {
            $channel->wait();
        } else {

            // send response;
            dd("rad shod");
        }



        $channel->close();
        $connection->close();

        return 1;
    }
}

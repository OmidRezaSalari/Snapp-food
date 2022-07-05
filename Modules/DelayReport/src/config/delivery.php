<?php

return [
    /*
    |--------------------------------------------------------------------------
    | RabbitMq config for connect to server
    |--------------------------------------------------------------------------
    */
    'rabbitmq_host' => "localhost",
    "rabbitmq_port" => 5672,
    "rabbitmq_username" => "guest",
    "rabbitmq_password" => "guest",
    "rabbitmq_queue_name" => "delay_queue",
    "rabbitmq_vhost" => "/",
    "exchange_name" => "snapp-food",
    "exchange_type" => "direct",
    "exchange_serverity" => "DELAY",
    "delivery_mode" => PhpAmqpLib\Message\AMQPMessage::DELIVERY_MODE_PERSISTENT,


    "refresh-time-url" => "https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7"



];

<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// function to send & receive message to/from RabbitMQ
function processCheckout($data){
    // declare connection & channel to RabbitMQ
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    // mutate data
    $data = json_decode($data, TRUE);
    $data = ['data_type' => 'processCheckout'];
    $data = json_encode($data);
    // data to be sent is ['order_id' => 1, 'product_id' => 1, 'quantity' => 10, 'data_type' => 'processCheckout']

    // additional info for message sending replying
    $corr_id = uniqid();
    $reply_queue = 'OrderQueue';
    $exchange_name = 'Exchange1';
    $request_processed = 0;

    // initialize variable for result saving
    $res = NULL;

    // create Exchange to send and Queue to receive
    $channel->exchange_declare($exchange_name, 'direct', false, false, false);
    $channel->queue_declare($reply_queue, false, false, false, false);

    // prepare message
    $msg = new AMQPMessage(
        (string) $data,
        [
            'correlation_id' => $corr_id,
            'reply_to' => $reply_queue
        ]
    );

    // send message to exchange
    $channel->basic_publish($msg, $exchange_name);

    // prepare a function for callback on receiveing message 
    $onMessage = function($rep) use (&$corr_id, &$res, &$request_processed){
        if ($rep->get('correlation_id') == $corr_id) {
            $res = $rep->body;

            $request_processed++;
        }
    };

    // receive message
    $channel->basic_consume($reply_queue, '', false, true, false, false, $onMessage);

    // wait for only 1 message with timeout of 30 seconds
    while($request_processed <= 0) {
        try{
            $channel->wait(NULL, FALSE, 30);
        }
        catch (Exception $e){
            return;
        }
    }

    // close connection and channel
    $channel->close();
    $connection->close();

    // return result
    return $res;
}
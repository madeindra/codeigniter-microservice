<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// function to send & receive message to/from RabbitMQ
function processCheckout($data){
    // declare connection & channel to RabbitMQ
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    // additional info for message sending replying
    $corr_id = uniqid();
    $reply_queue = 'OrderQueue';
    $exchange_name = 'Exchange1';

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
    $onMessage = function($rep) use (&$corr_id, &$res){
        if ($rep->get('correlation_id') == $corr_id) {
            $res = $rep->body;
        }
    };

    // receive message
    $channel->basic_consume($reply_queue, '', false, true, false, false, $onMessage);

    // wait for consume complete with timeout of 30 seconds
    while($channel->is_consuming()) {
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
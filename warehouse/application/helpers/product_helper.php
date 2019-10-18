<?php
// call autoload manually, because this script run on CLI
require_once  '/var/www/html/tdd-microservice/application/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// function to send & receive message to/from RabbitMQ
function processInvoice(){
    // declare connection & channel to RabbitMQ
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    // info for message sending replying
    $exchange_name = 'Exchange1';
    $queue_name = 'WarehouseQueue';

    // initialize variable for result saving
    $res = NULL;

    // create Exchange to send and Queue to receive then bind the Queue
    $channel->exchange_declare($exchange_name, 'direct', false, false, false);
    $channel->queue_declare($queue_name, false, false, false, false);
    $channel->queue_bind($queue_name, $exchange_name);

    // print wait message
    echo " [x] Awaiting message\n";

    // prepare a function for callback on receiveing message 
    $onMessage = function($rep) {
        $message_body = json_decode($rep->body, TRUE);
        if ($message_body['data_type'] === 'processCheckout'){
            echo " [.] Requesting checkout invoice \n";
            // TODO: Create this function
            if(checkProduct($message_body)){
                // TODO: Send inStock TRUE result to Financial Queue
                $message_body['in_stock'] = TRUE;
            }
            // TODO: Send inStock FALSE result to Financial Queue
            $message_body['in_stock'] = FALSE;
            $msg = $message_body;
        }
    };

    // receive message
    $channel->basic_consume($queue_name, '', false, true, false, false, $onMessage);

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

function checkProduct($data){
    $curl = new Curl\Curl();
    $curl->setHeader('Content-type', 'application/json');

    $id = $data['product_id'];
    try{
        $response = $curl->get('localhost/tdd-microservice/api/1.0.0/product/'.$id)->response;
        $response = json_decode($response, TRUE);
        
        if((int) $response['stock'] >= (int) $data['quantity']){
            return TRUE;
        }
        return FALSE;
    } catch (Exception $e){
         return;
    }
}

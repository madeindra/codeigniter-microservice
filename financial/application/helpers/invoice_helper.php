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
    $queue_name = 'FinancialQueue';
    $exchange_reply = 'Exchange2';

    // initialize variable for result saving
    $res = NULL;

    // create Exchange to send and Queue to receive then bind the Queue
    $channel->exchange_declare($exchange_name, 'direct', false, false, false);
    $channel->queue_declare($queue_name, false, false, false, false);
    $channel->queue_bind($queue_name, $exchange_name);
    $channel->exchange_declare($exchange_reply, 'direct', false, false, false);

    // print wait message
    echo " [x] Awaiting message\n";

    // prepare a function for callback on receiveing message 
    $onMessage = function($rep) use (&$channel){
        $message_body = json_decode($rep->body, TRUE);
        // data received is ['order_id' => 1, 'product_id' => 1, 'quantity' => 10, 'data_type' => 'processCheckout']
        if ($message_body['data_type'] === 'processCheckout'){
            echo " [.] Requesting checkout invoice \n";
            $invoice = createInvoice($message_body);
            if(empty($invoice)){
                return NULL;
            }
        }
        
        if ($message_body['data_type'] === 'confirmStock'){
            // TODO: Create this function
            $message_body['invoice'] = FALSE;
            $message_body['data_type'] = 'confirmInvoice';

            if ($message_body['inStock']){
                $data = [
                    'status' => 'waiting'
                ];

                if(updateInvoice($message_body['order_id'], $data)){
                    $message_body['invoice'] = TRUE;
                }
            } else {
                deleteInvoice($message_body['order_id']);
            }
            // TODO: Send message to exchange
            // prepare message
            $msg = new AMQPMessage(
                (string) json_encode($message_body)
            );

            // send message to exchange
            $channel->basic_publish($msg, $exchange_reply);
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

function createInvoice($data){
    $curl = new Curl\Curl();
    $curl->setHeader('Content-type', 'application/json');
    
    try{
        $response = $curl->post('localhost/tdd-microservice/api/1.0.0/invoice/', $data)->response;
        return json_decode($response, TRUE);
    } catch (Exception $e){
         return;
    }
}

function updateInvoice($id, $data){

}

function deleteInvoice($id){

}
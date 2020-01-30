<?php
// call autoload manually, because this script run on CLI
require_once  '/var/www/html/tdd-microservice-poc/application/vendor/autoload.php';

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
    $financial_queue = 'FinancialQueue';
    $exchange_reply = 'Exchange2';

    // initialize variable for result saving
    $res = NULL;

    // create Exchange to send and Queue to receive then bind the Queue
    $channel->exchange_declare($exchange_name, 'direct', false, false, false);
    $channel->queue_declare($queue_name, false, false, false, false);
    $channel->queue_bind($queue_name, $exchange_name);
    $channel->exchange_declare($exchange_reply, 'direct', false, false, false);
    $channel->queue_bind($queue_name, $exchange_reply);

    // print wait message
    echo " [x] Awaiting message\n";

    // prepare a function for callback on receiveing message 
    $onMessage = function($rep) use (&$channel, &$financial_queue) {
        $message_body = json_decode($rep->body, TRUE);
        if ($message_body['data_type'] === 'processCheckout'){
            echo " [.] Requesting product availability \n";
            
            // TODO: As default, send inStock FALSE result to Financial Queue
            $message_body['in_stock'] = FALSE;
            $message_body['data_type'] = 'confirmStock';
            $available = checkProduct($message_body);

            // TODO: Create this function
            if($available){
                echo " [.] Stock availabe \n";

                // TODO: Send inStock TRUE result to Financial Queue
                $message_body['in_stock'] = TRUE;
                $message_body['available_stock'] = $available;
            }
            
            $msg = new AMQPMessage(
                (string) json_encode($message_body)
            );

            // send message to exchange
            $channel->basic_publish($msg, '', $financial_queue);
            echo " [.] Message sent to $financial_queue \n";
        }

        if ($message_body['data_type'] === 'confirmInvoice'){
            echo " [.] Invoice updated \n";
            
            if($message_body['invoice']){
                echo " [.] Updating stock \n";

                $stock = updateStock($message_body['quantity'], $message_body['product_id']);

                if(empty($stock)){
                    return NULL;
                }
            }
            
        }
    };

    // receive message
    $channel->basic_consume($queue_name, '', false, true, false, false, $onMessage);

    // wait for consume complete with timeout of 30 seconds
    while($channel->is_consuming()) {
        try{
            $channel->wait();
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
    $client = new \GuzzleHttp\Client();
    $id = $data['product_id'];
    try{
        $response = $client->get('localhost/tdd-microservice-poc/index.php/api/v1/products/'.$id);
        $response = json_decode($response->getBody(),TRUE);
        $response = $response['data'];
        
        if((int) $response['stock'] >= (int) $data['quantity']){
            return $response['stock'];
        }
        return NULL;
    } catch (Exception $e){
         return;
    }
}

function updateStock($amount, $id){
    $client = new \GuzzleHttp\Client();
    $data = ['quantity' => '-'.$amount];

    try{
        $response = $client->put('localhost/tdd-microservice-poc/index.php/api/v1/products/stocks/'.$id, ['json' => $data]);
        return json_decode($response->getBody(), TRUE);
    } catch (Exception $e){
         return;
    }
}

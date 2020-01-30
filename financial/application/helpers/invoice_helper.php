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
    $onMessage = function($rep) use (&$exchange_reply, &$channel){
        $message_body = json_decode($rep->body, TRUE);
        // data received is ['order_id' => 1, 'product_id' => 1, 'quantity' => 10, 'data_type' => 'processCheckout']
        if ($message_body['data_type'] === 'processCheckout'){
            echo " [.] Requesting checkout invoice \n";

            $data = [
                'order_id' => $message_body['id'],
                'total' => $message_body['price']
            ];

            $invoice = createInvoice($data);

            if(empty($invoice)){
                return NULL;
            }
            echo " [.] Successfuly created invoice \n";
        }
        
        if ($message_body['data_type'] === 'confirmStock'){
            // TODO: Create this function
            $message_body['invoice'] = FALSE;
            $message_body['data_type'] = 'confirmInvoice';

            if ($message_body['in_stock']){
                echo " [.] Stock confirmed updating invoice \n";

                $data = [
                    'status' => 'waiting'
                ];
                
                if(updateInvoice($message_body['id'], $data)){
                    $message_body['invoice'] = TRUE;
                }
            } 
            
            if(!$message_body['invoice']){
                echo " [.] Stock nonexist deleting invoice \n";

                deleteInvoice($message_body['id']);
            }
            // TODO: Send message to exchange
            // prepare message
            $msg = new AMQPMessage(
                (string) json_encode($message_body)
            );

            // send message to exchange
            $channel->basic_publish($msg, $exchange_reply);
            echo " [.] Message sent to $exchange_reply \n";
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

function createInvoice($data){
    $client = new \GuzzleHttp\Client();
    try{
        $response = $client->post('localhost/tdd-microservice-poc/index.php/api/v1/invoices/', ['json' => $data]);
        return json_decode($response->getBody(), TRUE);
    } catch (Exception $e){
         return;
    }
}

function updateInvoice($id, $data){
    $client = new \GuzzleHttp\Client();
    try{
        $response = $client->put('localhost/tdd-microservice-poc/index.php/api/v1/invoices/orders/'.$id.'/', ['json' => $data]);
        return json_decode($response->getBody(), TRUE);
    } catch (Exception $e){
         return;
    }
}

function deleteInvoice($id){
    $client = new \GuzzleHttp\Client();
    try{
        $response =  $client->delete('localhost/tdd-microservice-poc/index.php/api/v1/invoices/orders/'.$id.'/');
        return json_decode($response->getBody(), TRUE);
    } catch (Exception $e){
         return;
    }
}
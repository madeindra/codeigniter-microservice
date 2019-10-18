<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends REST_Controller
{
    // constructor for the class
    public function __construct(){
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->library('Php_func');
    }

    // default GET method
    public function index_get(){
        $id = $this->uri->segment(4);

         if ($id !== NULL) {
            $order = $this->Order_model->getOrder($id);
        } else{
            $order = $this->Order_model->getOrder();
        }

        if ($order) {
            return $this->response(
                [
                    'success' => TRUE,
                    'data' => $order
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'order not found'
            ],
            REST_Controller::HTTP_NOT_FOUND,
            TRUE
        );
    }

    // default POST method
    public function index_post(){
        $product_id = $this->post('product_id') ?? NULL;
        $quantity = $this->post('quantity') ?? NULL;
        $price = $this->post('price') ?? NULL;

        $data = 
        [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price
        ];

        if ($this->Order_model->createOrder($data) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'new order has been placed',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to place order'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // default PUT method
    public function index_put(){
        $id = $this->uri->segment(4);

        if($id === NULL){
            return $this->response(
                [
                    'success' => FALSE,
                    'message' => 'provide an id'
                ],
                REST_Controller::HTTP_BAD_REQUEST,
                TRUE
            );
        }

        $product_id = $this->put('product_id') ?? NULL;
        $quantity = $this->put('quantity') ?? NULL;
        $price = $this->put('price') ?? NULL;
        
        $data = ['id' => $id ];

        if ($product_id !== NULL) {
            $data += ['product_id' => $product_id];
        
        }

        if ($quantity !== NULL) {
            $data += ['quantity' => $quantity];
        
        }

        if ($price !== NULL) {
            $data += ['price' => $price];
        
        }

        if ($this->Order_model->updateOrder($data, $id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'order has been updated',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to update order'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // default DELETE method
    public function index_delete(){
        $id = $this->uri->segment(4);

        if($id === NULL){
            return $this->response(
                [
                    'success' => FALSE,
                    'message' => 'provide an id'
                ],
                REST_Controller::HTTP_BAD_REQUEST,
                TRUE
            );
        }

        if ($this->Order_model->deleteOrder($id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'order has been deleted'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to delete order'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // Checkout POST method
    public function checkout_post(){
        $id = $this->uri->segment(5);

        if ($id === NULL) {
            return $this->response(
                [
                    'success' => FALSE,
                    'message' => 'provide an id'
                ],
                REST_Controller::HTTP_BAD_REQUEST,
                TRUE
            );
        }

        $data = $this->Order_model->getOrder($id);

        if (empty($data)){
            return $this->response(
                [
                    'success' => FALSE,
                    'message' => 'order not found'
                ],
                REST_Controller::HTTP_NOT_FOUND,
                TRUE
            );
        }

        $data = json_encode($data);
        $order = $this->php_func->processCheckout($data);
        if (!empty($order)){

            $result = json_decode($order, true);

            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'order has been checkout successfully',
                    'data' => $result
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'cannot process checkout'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends REST_Controller
{
    // constructor for the class
    public function __construct(){
        parent::__construct();
        $this->load->model('Product_model');
    }

    // default GET method
    public function index_get(){
        $id = $this->uri->segment(4);

         if ($id !== NULL) {
            $product = $this->Product_model->getProduct($id);
        } else{
            $product = $this->Product_model->getProduct();
        }

        if ($product) {
            return $this->response(
                [
                    'success' => TRUE,
                    'data' => $product
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'product not found'
            ],
            REST_Controller::HTTP_NOT_FOUND,
            TRUE
        );
    }

    // default POST method
    public function index_post(){
        $stock = $this->post('price') ?? NULL;
        $price = $this->post('price') ?? NULL;

        $data = 
        [
            'stock' => $stock,
            'price' => $price
        ];

        if ($this->Product_model->createProduct($data) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'new product has been placed',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to place product'
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

        $stock = $this->put('stock') ?? NULL;
        $price = $this->put('price') ?? NULL;
        
        $data = ['id' => $id ];

        if ($stock !== NULL) {
            $data += ['stock' => $stock];
        
        }

        if ($price !== NULL) {
            $data += ['price' => $price];
        
        }

        if ($this->Product_model->updateProduct($data, $id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'product has been updated',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to update product'
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

        if ($this->Product_model->deleteProduct($id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'product has been deleted'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to delete product'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // stock PUT method
    public function stock_put(){
        $id = $this->uri->segment(5);

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

        $quantity = $this->put('quantity') ?? NULL;

        if ($this->Product_model->updateProductStock($quantity, $id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'product stock has been updated'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to update product stock'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }
}
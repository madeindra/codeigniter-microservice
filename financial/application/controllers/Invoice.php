<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice extends REST_Controller
{
    // constructor for the class
    public function __construct(){
        parent::__construct();
        $this->load->model('Invoice_model');
    }

    // default GET method
    public function index_get(){
        $id = $this->uri->segment(4);

         if ($id !== NULL) {
            $invoice = $this->Invoice_model->getInvoice($id);
        } else{
            $invoice = $this->Invoice_model->getInvoice();
        }

        if ($invoice) {
            return $this->response(
                [
                    'success' => TRUE,
                    'data' => $invoice
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'invoice not found'
            ],
            REST_Controller::HTTP_NOT_FOUND,
            TRUE
        );
    }

    // default POST method
    public function index_post(){
        $order_id = $this->post('order_id') ?? NULL;
        $total = $this->post('total') ?? NULL;
        $status = 'incomplete';

        $data = 
        [
            'order_id' => $order_id,
            'total' => $total,
            'status' => $status
        ];

        if ($this->Invoice_model->createInvoice($data) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'new invoice has been placed',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to place invoice'
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

        $order_id = $this->put('order_id') ?? NULL;
        $total = $this->put('total') ?? NULL;
        $status = $this->put('status') ?? 'incomplete';
        
        $data =
        [
            'id' => $id,
            'status' => $status
        ];
        

        if ($order_id !== NULL) {
            $data += ['order_id' => $order_id];
        
        }

        if ($total !== NULL) {
            $data += ['total' => $total];
        
        }

        if ($this->Invoice_model->updateInvoice($data, $id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'invoice has been updated',
                    'data' => $data
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to update invoice'
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

        if ($this->Invoice_model->deleteInvoice($id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'invoice has been deleted'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to delete invoice'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // Order PUT method
    public function order_put(){
        $id = $this->uri->segment(5);

        if($id === NULL){
            return $this->response(
                [
                    'success' => FALSE,
                    'message' => 'provide an order id'
                ],
                REST_Controller::HTTP_BAD_REQUEST,
                TRUE
            );
        }

        $total = $this->put('total') ?? NULL;
        $status = $this->put('status') ?? 'incomplete';
        
        $data =
        [
            'status' => $status
        ];
    

        if ($total !== NULL) {
            $data += ['total' => $total];
        }

        if ($this->Invoice_model->updateInvoiceByOrderId($data, $id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'invoice has been updated'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to update invoice'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }

    // Order DELETE method
    public function order_delete(){
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

        if ($this->Invoice_model->deleteInvoiceByOrderId($id) > 0) {
            return $this->response(
                [
                    'success' => TRUE,
                    'message' => 'invoice has been deleted'
                ],
                REST_Controller::HTTP_OK,
                TRUE
            );
        }

        return $this->response(
            [
                'success' => FALSE,
                'message' => 'failed to delete invoice'
            ],
            REST_Controller::HTTP_BAD_REQUEST,
            TRUE
        );

    }
}
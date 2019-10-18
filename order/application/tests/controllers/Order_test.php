<?php
class Order_test extends TestCase
{
    // function to load on every test
    public function setUp(): void {

    }

    public function test_get_all(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => [
                            [
                            'id' => '1',
                            'product_id' => '1',
                            'quantity' => '5',
                            'price' => '5000'
                            ],
                            [
                            'id' => '2',
                            'product_id' => '2',
                            'quantity' => '5',
                            'price' => '2500'
                            ]
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/1.0.0/order/');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_get_one(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => [
                            'id' => '1',
                            'product_id' => '1',
                            'quantity' => '5',
                            'price' => '5000'
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/1.0.0/order/1');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_get_not_found(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => NULL
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/1.0.0/order/1');

        // assert response code and message
        $this->assertResponseCode(404);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_post_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'createOrder' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'id' => '1',
            'product_id' => '1',
            'quantity' => '5',
            'price' => '5000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/', $data);

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_post_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'createOrder' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'id' => '1',
            'product_id' => '1',
            'quantity' => '5',
            'price' => '5000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'updateOrder' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '3',
            'price' => '3000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/1.0.0/order/1', $data);

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_put_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'updateOrder' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '3',
            'price' => '3000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/1.0.0/order/1', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_null_id(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'updateOrder' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '3',
            'price' => '3000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/1.0.0/order/', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_delete_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'deleteOrder' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/1.0.0/order/1');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_delete_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'deleteOrder' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/1.0.0/order/1');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_delete_null_id(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'deleteOrder' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/1.0.0/order/');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_order_accepted(){
        // mock model and library on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => [
                            'id' => '1',
                            'product_id' => '1',
                            'quantity' => '5',
                            'price' => '5000'
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;

                $library = $this->getDouble(
                    'Php_func', [
                        'processCheckout' => json_encode([
                            'productId' => '1',
                            'quantity' => '10',
                            'inStock' => TRUE,
                            'invoiceId' => '1'
                        ])
                    ]
                );
                // use mocked library to be loaded
                $CI->php_func = $library;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/checkout/1');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_order_rejected(){
        // mock model and library on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => [
                            'id' => '1',
                            'product_id' => '1',
                            'quantity' => '5',
                            'price' => '5000'
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;

                $library = $this->getDouble(
                    'Php_func', [
                        'processCheckout' => NULL
                    ]
                );
                // use mocked library to be loaded
                $CI->php_func = $library;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/checkout/1');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_order_null_id(){
        // mock model and library on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => NULL
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;

                $library = $this->getDouble(
                    'Php_func', [
                        'processCheckout' => NULL
                    ]
                );
                // use mocked library to be loaded
                $CI->php_func = $library;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/checkout/');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_order_not_found(){
        // mock model and library on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Order_model', [
                        'getOrder' => NULL
                    ]
                );
                // use mocked model to be loaded
                $CI->Order_model = $model;

                $library = $this->getDouble(
                    'Php_func', [
                        'processCheckout' => NULL
                    ]
                );
                // use mocked library to be loaded
                $CI->php_func = $library;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/1.0.0/order/checkout/1');

        // assert response code and message
        $this->assertResponseCode(404);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

}
<?php
class Product_test extends TestCase
{
    // function to load on every test
    public function setUp(): void {

    }

    public function test_get_all(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'getProduct' => [
                            [
                                'id' => '1',
                                'stock' => '50',
                                'price' => '1000'
                            ],
                            [
                                'id' => '2',
                                'stock' => '100',
                                'price' => '500'
                            ]
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/v1/products/');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_get_one(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'getProduct' => [
                            'id' => '1',
                            'stock' => '50',
                            'price' => '1000'
                        ]
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/v1/products/1');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_get_not_found(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'getProduct' => NULL
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('GET', 'api/v1/products/1');

        // assert response code and message
        $this->assertResponseCode(404);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_post_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'createProduct' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'id' => '1',
            'stock' => '50',
            'price' => '1000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/v1/products/', $data);

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_post_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'createProduct' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'id' => '1',
            'stock' => '50',
            'price' => '1000'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('POST', 'api/v1/products/', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProduct' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'stock' => '10',
            'price' => '500'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/1', $data);

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_put_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProduct' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'stock' => '10',
            'price' => '500'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/1', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_null_id(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProduct' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'stock' => '10',
            'price' => '500'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_delete_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'deleteProduct' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/v1/products/1');

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_delete_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'deleteProduct' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/v1/products/1');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_delete_null_id(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'deleteProduct' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('DELETE', 'api/v1/products/');

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_stock_success(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProductStock' => 1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '-10'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/stocks/1', $data);

        // assert response code and message
        $this->assertResponseCode(200);
        $this->assertStringContainsStringIgnoringCase('TRUE', $output);

    }

    public function test_put_stock_failed(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProductStock' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '-10'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/stocks/1', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }

    public function test_put_stock_null_id(){
        // mock model on tested class' constructor and mock model's function
        $this->request->setCallable(
            function ($CI) {
                $model = $this->getDouble(
                    'Product_model', [
                        'updateProductStock' => -1
                    ]
                );
                // use mocked model to be loaded
                $CI->Product_model = $model;
            }
        );

        // set data to be sent
        $data = json_encode([
            'quantity' => '-10'
        ]);

        // set request as JSON
        $this->request->setHeader('Content-type', 'application/json');

        // send request
        $output = $this->request('PUT', 'api/v1/products/stocks/', $data);

        // assert response code and message
        $this->assertResponseCode(400);
        $this->assertStringContainsStringIgnoringCase('FALSE', $output);

    }
}
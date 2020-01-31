<?php
class Product_model_test extends TestCase
{
    // function to load on every test
    public function setUp(): void {
        $this->resetInstance();
        $this->CI->load->model('Product_model');
        $this->obj = $this->CI->Product_model;
    }

    public function test_get_all_product(){
        // mock result array
        $return = 
        [
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
        ];

        $db_result = $this->getMockBuilder('CI_DB_Result')
                          ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('result_array')->willReturn($return);

        // mock get query
        $db = $this->getMockBuilder('CI_DB_query_builder')
                   ->disableOriginalConstructor()
                   ->getMock();

        $db->method('get')->willReturn($db_result);

        // verify function called at least once
        $this->verifyInvokedOnce(
            $db_result,
            'result_array',
            []
        );

        $this->verifyInvokedOnce(
            $db,
            'get',
            ['product']
        );

        // set mocked db
        $this->obj->db = $db;

        // set expected result
        $expected = [
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
        ];

        // run function to be tested
        $output = $this->obj->getProduct();

        // assert if output matched expected
        $this->assertEquals($expected, $output);

    }

    public function test_get_one_product(){
         // mock result array
         $return = 
         [
            'id' => '1',
            'stock' => '50',
            'price' => '1000'
         ];
 
         $db_result = $this->getMockBuilder('CI_DB_Result')
                           ->disableOriginalConstructor()
                           ->getMock();
 
         $db_result->method('row_array')->willReturn($return);
 
         // mock get query
         $db = $this->getMockBuilder('CI_DB_query_builder')
                    ->disableOriginalConstructor()
                    ->getMock();
 
         $db->method('get_where')->willReturn($db_result);
 
         // verify function called at least once
         $this->verifyInvokedOnce(
             $db_result,
             'row_array',
             []
         );
 
         $this->verifyInvokedOnce(
             $db,
             'get_where',
             ['product', ['id' => '1']]
         );
 
         // set mocked db
         $this->obj->db = $db;
 
         // set expected result
         $expected =
             [
                'id' => '1',
                'stock' => '50',
                'price' => '1000'
             ];
 
         // run function to be tested
         $output = $this->obj->getProduct(1);
 
         // assert if output matched expected
         $this->assertEquals($expected, $output);
    }

    public function test_create_product_success(){
        // mock result
        $return = 1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // data to be sent
        $data =
            [
                'id' => '1',
                'stock' => '50',
                'price' => '1000'
            ];

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = 1;

        // run function to be tested
        $list = $this->obj->createProduct($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_create_product_failed(){
            // mock result
            $return = -1;

            // mock affected rows
            $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
                              ->disableOriginalConstructor()
                              ->getMock();
    
            $db_result->method('affected_rows')->willReturn($return);
    
            // data to be sent
            $data =
                [
                    'id' => '1',
                    'stock' => '50',
                    'price' => '1000'
                ];
    
           // verify function called at least once
            $this->verifyInvokedOnce(
                $db_result,
                'affected_rows',
                []
            );
    
            // set mocked db
            $this->obj->db = $db_result;
    
            // set expected result
            $expected = -1;
    
            // run function to be tested
            $list = $this->obj->createProduct($data);
            
            // assert if output matched expected
            $this->assertEquals($expected, $return);    
    }

    public function test_update_product_success(){
        // mock result
        $return = 1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // data to be sent
        $data =
            [
                'stock' => '10',
                'price' => '500'
            ];

        // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = 1;

        // run function to be tested
        $list = $this->obj->updateProduct($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_product_failed(){
        // mock result
        $return = -1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // data to be sent
        $data =
            [
                'stock' => '10',
                'price' => '500'
            ];
        
            // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = -1;

        // run function to be tested
        $list = $this->obj->updateProduct($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_product_success(){
        // mock result
        $return = 1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = 1;

        // run function to be tested
        $list = $this->obj->deleteProduct($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_product_failed(){
        // mock result
        $return = -1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = -1;

        // run function to be tested
        $list = $this->obj->deleteProduct($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_stock_success(){
        // mock result
        $return = 1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // amount to decrease
        $decrease = '-10';

        // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = 1;

        // run function to be tested
        $list = $this->obj->updateProductStock($decrease, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_stock_failed(){
        // mock result
        $return = -1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // amount to be decrease
        $decrease = '-10';
        
        // id to be sent
        $id = '1';

       // verify function called at least once
		$this->verifyInvokedOnce(
			$db_result,
			'affected_rows',
			[]
        );

        // set mocked db
        $this->obj->db = $db_result;

        // set expected result
        $expected = -1;

        // run function to be tested
        $list = $this->obj->updateProductStock($decrease, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }
}
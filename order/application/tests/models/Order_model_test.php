<?php
class Order_model_test extends TestCase
{
    // function to load on every test
    public function setUp(): void {
        $this->resetInstance();
        $this->CI->load->model('Order_model');
        $this->obj = $this->CI->Order_model;
    }

    public function test_get_all_order(){
        // mock result array
        $return = 
        [
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
            ['order']
        );

        // set mocked db
        $this->obj->db = $db;

        // set expected result
        $expected = [
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
        ];

        // run function to be tested
        $output = $this->obj->getOrder();

        // assert if output matched expected
        $this->assertEquals($expected, $output);

    }

    public function test_get_one_order(){
         // mock result array
         $return = 
         [
            'id' => '1',
            'product_id' => '1',
            'quantity' => '5',
            'price' => '5000'
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
             ['order', ['id' => '1']]
         );
 
         // set mocked db
         $this->obj->db = $db;
 
         // set expected result
         $expected =
             [
             'id' => '1',
             'product_id' => '1',
             'quantity' => '5',
             'price' => '5000'
             ];
 
         // run function to be tested
         $output = $this->obj->getOrder(1);
 
         // assert if output matched expected
         $this->assertEquals($expected, $output);
    }

    public function test_create_order_success(){
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
                'product_id' => '1',
                'quantity' => '5',
                'price' => '5000'
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
        $list = $this->obj->createOrder($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_create_order_failed(){
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
                    'product_id' => '1',
                    'quantity' => '5',
                    'price' => '5000'
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
            $list = $this->obj->createOrder($data);
            
            // assert if output matched expected
            $this->assertEquals($expected, $return);    
    }

    public function test_update_order_success(){
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
                'quantity' => '3',
                'price' => '3000'
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
        $list = $this->obj->updateOrder($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_order_failed(){
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
                'quantity' => '3',
                'price' => '3000'
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
        $list = $this->obj->updateOrder($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_order_success(){
        // mock result
        $return = 1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // data to be sent
        $data = '1';

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
        $list = $this->obj->deleteOrder($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_order_failed(){
        // mock result
        $return = -1;

        // mock affected rows
        $db_result = $this->getMockBuilder('CI_DB_sqlite3_driver')
			              ->disableOriginalConstructor()
                          ->getMock();

        $db_result->method('affected_rows')->willReturn($return);

        // data to be sent
        $data = '1';

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
        $list = $this->obj->deleteOrder($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

}
<?php
class Invoice_model_test extends TestCase
{
    // function to load on every test
    public function setUp(): void {
        $this->resetInstance();
        $this->CI->load->model('Invoice_model');
        $this->obj = $this->CI->Invoice_model;
    }

    public function test_get_all_invoice(){
        // mock result array
        $return = 
        [
            [
                'id' => '1',
                'order_id' => '1',
                'total' => '10000',
                'status' => 'incomplete'
            ],
            [
                'id' => '1',
                'order_id' => '2',
                'total' => '20000',
                'status' => 'waiting'
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
            ['invoice']
        );

        // set mocked db
        $this->obj->db = $db;

        // set expected result
        $expected = [
            [
                'id' => '1',
                'order_id' => '1',
                'total' => '10000',
                'status' => 'incomplete'
            ],
            [
                'id' => '1',
                'order_id' => '2',
                'total' => '20000',
                'status' => 'waiting'
            ]
        ];

        // run function to be tested
        $output = $this->obj->getInvoice();

        // assert if output matched expected
        $this->assertEquals($expected, $output);

    }

    public function test_get_one_invoice(){
         // mock result array
         $return = 
         [
            'id' => '1',
            'order_id' => '1',
            'total' => '10000',
            'status' => 'incomplete'
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
             ['invoice', ['id' => '1']]
         );
 
         // set mocked db
         $this->obj->db = $db;
 
         // set expected result
         $expected =
             [
                'id' => '1',
                'order_id' => '1',
                'total' => '10000',
                'status' => 'incomplete'
             ];
 
         // run function to be tested
         $output = $this->obj->getInvoice(1);
 
         // assert if output matched expected
         $this->assertEquals($expected, $output);
    }

    public function test_create_invoice_success(){
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
                'order_id' => '1',
                'total' => '10000',
                'status' => 'incomplete'
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
        $list = $this->obj->createInvoice($data);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_create_invoice_failed(){
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
                    'order_id' => '1',
                    'total' => '10000',
                    'status' => 'incomplete'
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
            $list = $this->obj->createInvoice($data);
            
            // assert if output matched expected
            $this->assertEquals($expected, $return);    
    }

    public function test_update_invoice_success(){
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
                'status' => 'waiting'
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
        $list = $this->obj->updateInvoice($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_invoice_failed(){
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
                'status' => 'waiting'
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
        $list = $this->obj->updateInvoice($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_invoice_success(){
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
        $list = $this->obj->deleteInvoice($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_invoice_failed(){
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
        $list = $this->obj->deleteInvoice($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_order_invoice_success(){
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
                'status' => 'waiting'
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
        $list = $this->obj->updateInvoiceByOrderId($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_update_order_invoice_failed(){
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
                'status' => 'waiting'
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
        $list = $this->obj->updateInvoiceByOrderId($data, $id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_order_invoice_success(){
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
        $list = $this->obj->deleteInvoiceByOrderId($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

    public function test_delete_order_invoice_failed(){
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
        $list = $this->obj->deleteInvoiceByOrderId($id);
        
        // assert if output matched expected
		$this->assertEquals($expected, $return);

    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_order extends CI_Migration {

    // Start Migration
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'product_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'quantity' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'price' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('order');

        $data = array(
            array(
                'id' => "1",
                'product_id' => "1",
                'quantity' => "1",
                'price' => "500"
            ),
            array(
                'id' => "2",
                'product_id' => "2",
                'quantity' => "2",
                'price' => "500"
            ),
            array(
                'id' => "3",
                'product_id' => "1",
                'quantity' => "3",
                'price' => "1500"
            )
         );
         
         $this->db->insert_batch('order', $data);
    }

    // Revert Migration
    public function down()
    {
        $this->dbforge->drop_table('order');
    }
}
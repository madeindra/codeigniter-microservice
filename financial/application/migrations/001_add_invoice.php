<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_invoice extends CI_Migration {

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
            'order_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'total' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'status' => array(
                'type' => 'varchar',
                'constraint' => 255,
            ),
        ));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('invoice');

        $data = array(
            array(
                'id' => "1",
                'order_id' => "1",
                'total' => "1000",
                'status' => "incomplete"
            ),
            array(
                'id' => "2",
                'order_id' => "2",
                'total' => "1500",
                'status' => "incomplete"
                )
         );
         
         $this->db->insert_batch('invoice', $data);
    }

    // Revert Migration
    public function down()
    {
        $this->dbforge->drop_table('invoice');
    }
}
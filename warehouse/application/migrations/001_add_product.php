<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_product extends CI_Migration {

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
            'stock' => array(
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
        $this->dbforge->create_table('product');

        $data = array(
            array(
                'id' => "1",
                'stock' => "5",
                'price' => "500"
            ),
            array(
                'id' => "2",
                'stock' => "5",
                'price' => "250"
            )
         );
         
         $this->db->insert_batch('product', $data);
    }

    // Revert Migration
    public function down()
    {
        $this->dbforge->drop_table('product');
    }
}
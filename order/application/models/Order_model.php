<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order_model extends CI_Model
{
    // get all orders or get one by id
    public function getOrder($id = NULL)
    {
        if ($id === NULL) {
            return $this->db->get('order')->result_array();
        }

        return $this->db->get_where('order', ['id' => $id])->row_array();
    }

    // create a new order
    public function createOrder($data)
    {
        $this->db->insert('order', $data);
        return $this->db->affected_rows();
    }

    // update an existing order
    public function updateOrder($data, $id)
    {
        $this->db->update('order', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    // delete an existing order
    public function deleteOrder($id)
    {
        $this->db->delete('order', $id);
        return $this->db->affected_rows();
    }

}
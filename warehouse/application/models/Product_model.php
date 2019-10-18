<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model
{
    // get all products or get one by id
    public function getProduct($id = NULL)
    {
        if ($id === NULL) {
            return $this->db->get('product')->result_array();
        }

        return $this->db->get_where('product', ['id' => $id])->row_array();
    }

    // create a new product
    public function createProduct($data)
    {
        $this->db->insert('product', $data);
        return $this->db->affected_rows();
    }

    // update an existing product
    public function updateProduct($data, $id)
    {
        $this->db->update('product', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    // delete an existing product
    public function deleteProduct($id)
    {
        $this->db->delete('product', $id);
        return $this->db->affected_rows();
    }

}
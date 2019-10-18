<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_model extends CI_Model
{
    // get all invoices or get one by id
    public function getInvoice($id = NULL)
    {
        if ($id === NULL) {
            return $this->db->get('invoice')->result_array();
        }

        return $this->db->get_where('invoice', ['id' => $id])->row_array();
    }

    // create a new invoice
    public function createInvoice($data)
    {
        $this->db->insert('invoice', $data);
        return $this->db->affected_rows();
    }

    // update an existing invoice
    public function updateInvoice($data, $id)
    {
        $this->db->update('invoice', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    // delete an existing invoice
    public function deleteInvoice($id)
    {
        $this->db->delete('invoice', $id);
        return $this->db->affected_rows();
    }

}
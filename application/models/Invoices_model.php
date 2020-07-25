<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_model extends CI_Model {

    public function get_all() {
        $this->db->select('*');
        $this->db->from('tb_factura');
        $query = $this->db->get();
        return $query->result();
    }

    public function add_invoice($data) {

        $this->db->insert('invoices', $data);
        $invoice_id = $this->db->insert_id();

        $invoice_number = "FAC-".str_pad( $invoice_id, '8', '0', STR_PAD_LEFT);
        $this->db->where('id', $invoice_id);
        return $this->db->update('invoices', array('invoice_number' => $invoice_number));
    }

}
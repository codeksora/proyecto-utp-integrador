<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_details_model extends CI_Model {
    public function get_order_details_by_order($order_id) {
        $this->db->select("
            *
        ");
        $this->db->from('order_details ordd');
        $this->db->join('products pro', 'pro.id = ordd.product_id');
        $this->db->where('ordd.order_id', $order_id);
        $query = $this->db->get();
        return $query->result();
    }

}
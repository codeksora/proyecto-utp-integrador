<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_price_types_model extends CI_Model {

    public function get_all() {
        $this->db->select('
            ppt.id, ppt.name
        ');
        $this->db->from('product_price_types ppt');
        $query = $this->db->get();
        return $query->result();
    }

}
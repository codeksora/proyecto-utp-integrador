<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_types_model extends CI_Model {

    public function get_all() {
        $this->db->select('id, name');
        $this->db->from('product_types');
        $this->db->order_by('name');
        $query = $this->db->get();

        $rows = $query->custom_result_object('Product_types_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
        }

        return $rows;
	}	
	
}
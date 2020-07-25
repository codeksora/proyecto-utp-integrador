<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_categories_model extends CI_Model {

    public function get_all() {
        $this->db->select('id, name, technical_specifications');
        $this->db->from('product_categories');
        $query = $this->db->get();

        $rows = $query->custom_result_object('Product_categories_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
        }

        return $rows;
    }	
    
    public function get_all_dt(
        $start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
            name, technical_specifications, id
        ');
        $this->db->from('product_categories');
        if($search_value != NULL) {
            $this->db->or_like('name', $search_value);
            $this->db->or_like('technical_specifications', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Product_categories_model');

        foreach($rows as $row) {
            // $row->id = intval($row->id);
            // $row->status_id = intval($row->status_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->order_total = floatval($row->order_total);
        }

        return $rows;
    }

    public function get_product_category($product_category_id) {
        $this->db->select('
        name, technical_specifications, id
        ');
        $this->db->from('product_categories');
        $this->db->where('id', $product_category_id);
        // $this->db->where('cont.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Product_categories_model');

            // $row->id = intval($row->id);
            // $row->phone_code_id = intval($row->phone_code_id);
            // $row->country_id = intval($row->country_id);
            // $row->contact_type_id = intval($row->contact_type_id);
            // $row->customer_id = intval($row->customer_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function add_product_category($product_category_data) {
        return $this->db->insert('product_categories', $product_category_data);
    }

    public function update_product_category($product_category_data, $product_category_id) {
        $this->db->where('id', $product_category_id);
        // $this->db->where('status_id !=', 3);
        return $this->db->update('product_categories', $product_category_data);
    }
	
}
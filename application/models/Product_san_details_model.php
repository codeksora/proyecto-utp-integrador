<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_san_details_model extends CI_Model {

	public function get_all_by_product($product_id) {
        $this->db->select('
            pp.id, pp.price, pp.product_id, pp.price_pen,
            qy.id as quantity_year_id, qy.name as quantity_year_name,
            qy.description as quantity_year_description
        ');
        $this->db->from('product_san_details pp');
        $this->db->join('products p', 'p.id = pp.product_id', 'left');
        $this->db->join('quantity_years qy', 'qy.id = pp.quantity_year_id', 'left');
        $this->db->where('pp.product_id', $product_id);
        $this->db->order_by('pp.quantity_year_id');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Product_san_details_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->currency_type_id = intval($row->currency_type_id);
            $row->quantity_year_id = intval($row->quantity_year_id);
            $row->price = floatval($row->price);
          $row->price_pen = floatval($row->price_pen);
            // $row->is_san = intval($row->is_san);
        }

        return $rows;
    }

	public function add_product_san_detail($product_san_detail_data) {
        return $this->db->insert('product_san_details', $product_san_detail_data);
    }

    public function update_product_san_detail($product_san_detail_data, $product_san_detail_id) {
        $this->db->where('id', $product_san_detail_id);
        return $this->db->update('product_san_details', $product_san_detail_data);
    }
}

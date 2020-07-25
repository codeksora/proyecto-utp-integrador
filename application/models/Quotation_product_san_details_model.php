<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_product_san_details_model extends CI_Model {

	public function add_quotation_product_san_detail($quotation_product_san_detail_data) {
        return $this->db->insert('quotation_product_san_details', $quotation_product_san_detail_data);
    }

}
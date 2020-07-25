<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_products_model extends CI_Model {

	public function get_all_by_quotation($quotation_id = NULL) {
		$this->db->select('
			op.amount, op.subtotal, pro.name as product_name, quy.name as quantity_year_name, prod.price as product_detail_price,
			opsd.price as product_san_detail_price, curty.symbol as currency_type_symbol, op.total, op.discount, ppt.name as product_type_name,
			opsd.quantity as qty_san, conc.name as concept_name, prod.quantity_year_id, op.mails as quotation_products_mails, op.domains as quotation_products_domains,
			pro.san_base, prodc.technical_specifications
		');
		$this->db->from('quotation_products op');
		$this->db->join('quotations ord', 'ord.id = op.quotation_id', 'right');
		$this->db->join('currency_types curty', 'curty.id = ord.currency_type_id');
		$this->db->join('product_details prod', 'prod.id = op.product_detail_id', 'left');
// 		$this->db->join('product_san_details psd', 'psd.product_id = prod.product_id AND psd.quantity_year_id = prod.quantity_year_id', 'left');
		$this->db->join('quotation_product_san_details opsd', 'opsd.quotation_product_id = op.id', 'left');
//     $this->db->join('product_san_details psd', 'psd.product_id = prod.product_id AND psd.quantity_year_id = prod.quantity_year_id', 'left');
		$this->db->join('products pro', 'pro.id = prod.product_id', 'inner');
		$this->db->join('product_categories prodc', 'prodc.id = pro.product_category_id', 'left');
		$this->db->join('product_types ppt', 'ppt.id = pro.product_type_id');
		$this->db->join('quantity_years quy', 'quy.id = prod.quantity_year_id');
		$this->db->join('concepts conc', 'conc.id = op.concept_id');
		$this->db->where('op.quotation_id', $quotation_id);
		$query = $this->db->get();
        $rows = $query->custom_result_object('Quotation_products_model');
        
        foreach ($rows as $row) {
            // $row->status_id = intval($row->status_id);
            $row->subtotal = floatval($row->subtotal);
            $row->product_detail_price = floatval($row->product_detail_price);
            $row->product_san_detail_price = floatval($row->product_san_detail_price);
            // $row->customer_id = intval($row->customer_id);
            $row->qty_san = intval($row->qty_san);
            // $row->quantity = intval($row->quantity);
        }

        return $rows;

	}

	public function add_quotation_product($quotation_product_data) {
        return $this->db->insert('quotation_products', $quotation_product_data);
    }
}
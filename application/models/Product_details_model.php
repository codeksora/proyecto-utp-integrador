<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_details_model extends CI_Model {

    public function get_all_by_currency_type() {
        $this->db->select('
            pp.id,
            CONCAT(provi.name, " - ", pro.name, " - ", qy.name) as product_name, 
            pp.price, pro.san_max, pp.price_pen, 
            pro.product_type_id, provi.name as provider_name, provi.id as provider_id
        ');
        $this->db->from('product_details pp');
        $this->db->join('products pro', 'pro.id = pp.product_id', 'left');
        $this->db->join('providers provi', 'provi.id = pro.provider_id');
        $this->db->join('quantity_years qy', 'qy.id = pp.quantity_year_id', 'left');
        // $this->db->where('pp.currency_type_id', $currency_type_id);
        $this->db->where('pro.status_id !=', 3);
        $this->db->order_by('product_name');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Product_details_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->product_type_id = intval($row->product_type_id);
          $row->provider_id = intval($row->provider_id);
            // $row->is_san = intval($row->is_san);
            $row->san_max = intval($row->san_max);
            // $row->price_san_pen = floatval($row->price_san_pen);
            // $row->price_san_usd = floatval($row->price_san_usd);
        }

        return $rows;

    }

    public function get_all_by_product($product_id) {
        $this->db->select('
            pp.id, pp.price, pp.product_id, pp.price_pen,
            qy.id as quantity_year_id, qy.name as quantity_year_name,
            qy.description as quantity_year_description, p.san_base, pcc.name as product_category_name,
            pcc.technical_specifications
        ');
        $this->db->from('product_details pp');
        $this->db->join('products p', 'p.id = pp.product_id', 'left');
        $this->db->join('product_categories pcc', 'pcc.id = p.product_category_id', 'left');
        $this->db->join('quantity_years qy', 'qy.id = pp.quantity_year_id', 'left');
        $this->db->where('pp.product_id', $product_id);
        $this->db->order_by('pp.quantity_year_id');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Product_details_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->quantity_year_id = intval($row->quantity_year_id);
            $row->price = floatval($row->price);
          $row->price_pen = floatval($row->price_pen);
        }

        return $rows;
    }

    public function get_qty_years_by_product($product_id) {
        $this->db->select('max(pp.quantity_year_id) as count');
        $this->db->from('product_details pp');
        $this->db->where('pp.product_id', $product_id);
        $this->db->where('pp.is_san', null);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Product_details_model');
            $row->count = intval($row->count);

            return $row->count;
        } else return FALSE;
    }

    public function get_product_detail($product_detail_id) {
        $this->db->select('
            pp.id as product_detail_id,
            pp.quantity_year_id,
            p.name,
            p.san_max,
            pp.price as product_price,
            pp.price_pen as product_price_pen,
            pt.name as product_type_name,
            qy.name as quantity_year_name,
            p.is_san,
            psd.price as product_san_price,
            psd.price_pen as product_san_price_pen,
            psd.id as product_san_detail_id,
            p.description as product_description,
            p.san_base, pct.name as product_category_name, pct.technical_specifications
        ');
        $this->db->from('product_details pp');
        $this->db->join('products p', 'p.id = pp.product_id', 'left');
        $this->db->join('product_categories pct', 'pct.id = p.product_category_id', 'left');
        $this->db->join('product_types pt', 'pt.id = p.product_type_id', 'left');
        $this->db->join('quantity_years qy', 'qy.id = pp.quantity_year_id', 'left');
        $this->db->join('product_san_details psd', 'psd.product_id = pp.product_id AND psd.quantity_year_id = pp.quantity_year_id', 'left');
        $this->db->where('pp.id', $product_detail_id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Product_details_model');
            $row->product_detail_id = intval($row->product_detail_id);
            $row->san_max = intval($row->san_max);
            $row->is_san = intval($row->is_san);
            $row->product_price = floatval($row->product_price);
          $row->product_price_pen = floatval($row->product_price_pen);
            $row->product_san_price = floatval($row->product_san_price);
          $row->product_san_price_pen = floatval($row->product_san_price_pen);
            $row->san_base = intval($row->san_base);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->price_san_pen = floatval($row->price_san_pen);
            // $row->price_san_usd = floatval($row->price_san_usd);

            return $row;
        } else return FALSE;
    }

    public function add_product_detail($product_detail_data) {
        return $this->db->insert('product_details', $product_detail_data);
    }

    public function update_product_detail($product_detail_data, $product_id) {
        $this->db->where('id', $product_id);
        return $this->db->update('product_details', $product_detail_data);
    }
}
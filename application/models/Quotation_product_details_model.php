<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_product_details_model extends CI_Model {
    public function get_product_details_by_quotation($quotation_id) {

        $this->db->select("
            ordp.id as order_product_detail_id, count(*) as quantity,
            pro.name as product_name, ordp.status_id, prot.name as product_type_name, prot.id as product_type_id,
            prod.product_id, ord.customer_id, prod.price, qqy.name as quantity_year_name,
        ");
        $this->db->from('(SELECT * FROM quotation_product_details WHERE status_id = 1) as ordp');
        $this->db->join('quotations ord', 'ord.id = ordp.quotation_id', 'left');
        $this->db->join('customers cus', 'cus.id = ord.customer_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id', 'left');
        $this->db->join('quantity_years qqy', 'qqy.id = prod.quantity_year_id');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->join('product_types prot', 'prot.id = pro.product_type_id', 'left');
        $this->db->where('ordp.quotation_id', $quotation_id);
        $this->db->group_by('pro.name');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quotation_product_details_model');
        
        foreach ($rows as $row) {
            $row->status_id = intval($row->status_id);
            $row->product_id = intval($row->product_id);
            $row->customer_id = intval($row->customer_id);
            $row->product_type_id = intval($row->product_type_id);
            $row->quantity = intval($row->quantity);
        }

        return $rows;
    }

    public function get_product_details_by_quotation_separate($quotation_id) {

        $this->db->select("
            ordp.id, ordp.quotation_id,
            ordp.id as quotation_product_detail_id,
            pro.name as product_name, ordp.status_id, prot.name as product_type_name, prot.id as product_type_id,
            prod.product_id, ord.customer_id, prod.price, qqy.name as quantity_year_name
        ");
        $this->db->from('(SELECT * FROM quotation_product_details WHERE status_id = 1 AND quotation_id = ' . $quotation_id . ') as ordp');
        $this->db->join('quotations ord', 'ord.id = ordp.quotation_id', 'left');
        $this->db->join('customers cus', 'cus.id = ord.customer_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id', 'left');
        // $this->db->join('currency_types currt', 'currt.id = prod.currency_type_id');
        $this->db->join('quantity_years qqy', 'qqy.id = prod.quantity_year_id', 'left');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->join('product_types prot', 'prot.id = pro.product_type_id', 'left');
        // $this->db->where('prot.id', 1);
        // $this->db->or_where('prot.id', 2);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quotation_product_details_model');
        
        foreach ($rows as $row) {
            $row->status_id = intval($row->status_id);
            $row->product_id = intval($row->product_id);
            $row->customer_id = intval($row->customer_id);
            $row->product_type_id = intval($row->product_type_id);
        }

        return $rows;
    }

    public function get_product_details_by_order_separate($order_id) {
        $this->db->select("
            qupd.id,
            qupd.quotation_id,
            qupd.id as quotation_product_detail_id,
            pro.name as product_name, 
            qupd.status_id, prot.name as product_type_name, 
            prot.id as product_type_id,
            prod.product_id, quo.customer_id, prod.price, qqy.name as quantity_year_name,
            qpsand.quantity as qty_san
        ");
        $this->db->from('quotation_product_details qupd');
        $this->db->join('quotations quo', 'quo.id = qupd.quotation_id', 'right');
        $this->db->join('orders ord', 'ord.quotation_id = quo.id');
        $this->db->join('product_details prod', 'prod.id = qupd.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->join('product_types prot', 'prot.id = pro.product_type_id', 'left');
        $this->db->join('customers cus', 'cus.id = quo.customer_id');
        $this->db->join('quantity_years qqy', 'qqy.id = prod.quantity_year_id', 'left');
        //$this->db->join('(SELECT )')
     // $this->db->join('quotation_products qqp', 'qqp.quotation_id = quo.id', 'left');
      $this->db->join('quotation_product_san_details qpsand', 'qpsand.quotation_product_id = qupd.quotation_product_id', 'left');
        $this->db->where('ord.id', $order_id);
        $this->db->where('qupd.status_id', 1);
      //$this->db->group_by('qupd.id');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quotation_product_details_model');
        
        foreach ($rows as $row) {
            $row->status_id = intval($row->status_id);
            $row->product_id = intval($row->product_id);
            $row->customer_id = intval($row->customer_id);
            $row->product_type_id = intval($row->product_type_id);
          $row->product_name = $row->product_name . ' por ' . $row->quantity_year_name . ($row->qty_san > 0 ? ' + ' . $row->qty_san . ' SAN' : '');
        }

        return $rows;
    }

    public function get_quotation_product_detail($quotation_product_detail_id) {
        $this->db->select("
            ordp.id,
            ordp.id as quotation_product_detail_id,
            pro.name as product_name, ordp.status_id, prot.name as product_type_name, prot.id as product_type_id,
            prod.product_id, ord.customer_id, prod.price, qqy.name as quantity_year_name
        ");
        $this->db->from("quotation_product_details ordp");
        $this->db->join('quotations ord', 'ord.id = ordp.quotation_id', 'left');
        $this->db->join('customers cus', 'cus.id = ord.customer_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id', 'left');
        $this->db->join('quantity_years qqy', 'qqy.id = prod.quantity_year_id');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->join('product_types prot', 'prot.id = pro.product_type_id', 'left');
        $this->db->where("ordp.id", $quotation_product_detail_id);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Quotation_product_details_model');

            $row->id = intval($row->id);
            $row->product_type_id = intval($row->product_type_id);
            // $row->country_id = intval($row->country_id);
            // $row->contact_type_id = intval($row->contact_type_id);
            // $row->customer_id = intval($row->customer_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function get_product_type_by_id($order_product_details_id) {
        /**
         * BASADOS EN LA BASE DE DATOS
         * CERTIFICADOS SSL: 1 - 9 - 12
         * CERTIFICADOS FIRMA: 2 - 3 - 5 - 6 - 7
         */
        $this->db->select('id_tipoProducto');
        $this->db->from('tb_detordprod tbd');
        $this->db->join('tb_producto tbp', 'tbd.idproducto = tbp.id_producto');
        $this->db->join('tb_tipoproducto tbt', 'tbt.id_tipoProducto = tbp.tipo');
        $this->db->where('tbd.id_detordprod', $order_products_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function add_quotation_product_detail($quotation_product_detail_data) {
        return $this->db->insert('quotation_product_details', $quotation_product_detail_data);
    }

    public function update_quotation_product_detail($quotation_product_detail_data, $quotation_product_detail_id) {
        $this->db->where('id', $quotation_product_detail_id);
        return $this->db->update('quotation_product_details', $quotation_product_detail_data);
    }

}
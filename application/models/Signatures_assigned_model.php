<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Signatures_assigned_model extends CI_Model {

    public function get_signatures_assigned_by_order($order_id, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
            pro.name as product_name,
            firmst.class as signature_assigned_status_class, firmst.name as signature_status_name, 
            sigfo.persnombreuser, sigfo.persmailuser,
            firmss.issue_date,
            firmss.installation_date,
            firmss.expiration_date
        ');
        $this->db->from('signatures_assigned firmss');
        $this->db->join('signature_forms sigfo', 'sigfo.idpersonal = firmss.signature_form_id');
        $this->db->join('signature_status firmst', 'firmst.id = firmss.signature_status_id', 'left');
        $this->db->join('quotation_product_details ordp', 'ordp.id = firmss.quotation_product_detail_id');
        $this->db->join('orders ord', 'ord.quotation_id = ordp.quotation_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id');
        $this->db->join('products pro', 'pro.id = prod.product_id');
        // if($search_value != NULL) {
        //     $this->db->or_like('DATE_FORMAT(firmss.created_at, "%d/%m/%Y")', $search_value);
        // }
        $this->db->where('ord.id', $order_id);
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Signatures_assigned_model');

        foreach($rows as $row) {
            // $row->id = intval($row->id);
            $row->issue_date = $row->issue_date ? strtotime($row->issue_date) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
        }

        return $rows;
    }

    public function get_all($signature_status_s = NULL, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
            cus.name as customer_name,
            pro.name as product_name,
            sigform.persnombreuser,
            sigform.persmailuser,
            signss.updated_at,
            usr.full_name as user_full_name,
            signst.name as signature_status_name, 
            signst.class as signature_status_class,
            signss.id
        ');
        $this->db->from('signatures_assigned signss');
        $this->db->join('signature_forms sigform', 'sigform.idpersonal = signss.signature_form_id', 'left');
        $this->db->join('signature_status signst', 'signst.id = signss.signature_status_id', 'left');
        $this->db->join('quotation_product_details ordp', 'ordp.id = signss.quotation_product_detail_id', 'left');
        $this->db->join('orders ord', 'ord.quotation_id = ordp.quotation_id', 'left');
        $this->db->join('quotations qot', 'qot.id = ord.quotation_id', 'left');
        $this->db->join('customers cus', 'cus.id = qot.customer_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->join('users usr', 'usr.id = signss.user_id');
        if($search_value != NULL) {
            $this->db->like('cus.name', $search_value);
            $this->db->or_like('pro.name', $search_value);
            $this->db->or_like('sigform.persnombreuser', $search_value);
            $this->db->or_like('sigform.persmailuser', $search_value);
            $this->db->or_like('DATE_FORMAT(signss.updated_at, "%d/%m/%Y")', $search_value);
            $this->db->or_like('usr.full_name', $search_value);
            $this->db->or_like('signst.name', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Signatures_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_signature_assigned($id) {
        $this->db->select('
            sigas.id,
            sigas.issue_date,
            sigas.installation_date,
            sigas.expiration_date,
            ord.order_number,
            ord.customer_order_number,
            qot.customer_id,
            ord.order_date,
            ord.expiration_date as order_expiration_date,
            sigfo.persnombreuser,
            sigfo.persmailuser,
            sigfo.perscargouser,
            pro.name as product_name,
            sigas.enroll_code,
            sigas.signature_status_id
        ');
        $this->db->from('signatures_assigned sigas');
        $this->db->join('signature_forms sigfo', 'sigfo.idpersonal = sigas.signature_form_id', 'left');
        $this->db->join('signature_status sigst', 'sigst.id = sigas.signature_status_id', 'left');
        $this->db->join('quotation_product_details odp', 'odp.id = sigas.quotation_product_detail_id');
        $this->db->join('product_details prd', 'prd.id = odp.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prd.product_id', 'left');
        $this->db->join('orders ord', 'ord.quotation_id = odp.quotation_id');
        $this->db->join('quotations qot', 'qot.id = ord.quotation_id');
        // $this->db->join('customers cus', 'cus.id = ord.customer_id');
        // $this->db->join('ssl_certificates sslcer', 'sslcer.id = sslas.ssl_certificate_id', 'left');
        // $this->db->join('domains dom', 'dom.id = sslcer.domain_id', 'left');
        // $this->db->join('server_types servt', 'servt.id = sslas.server_type_id', 'left');
        // $this->db->join('operating_system_types opsys', 'opsys.id = servt.operating_system_type_id', 'left');
        $this->db->where('sigas.id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Signatures_assigned_model');

            $row->id = intval($row->id);
            $row->customer_id = intval($row->customer_id);
            $row->order_date = $row->order_date ? strtotime($row->order_date) * 1000 : '';
            $row->order_expiration_date = $row->order_expiration_date ? strtotime($row->order_expiration_date) * 1000 : '';
            $row->issue_date = $row->issue_date ? strtotime($row->issue_date) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            $row->installation_date = $row->installation_date ? strtotime($row->installation_date) * 1000 : '';
            // $row->country_id = intval($row->country_id);
            // $row->sector_id = intval($row->sector_id);
            // $row->phone_code_id = intval($row->phone_code_id);

            return $row;
        } else return FALSE;
    }

    public function update_signature_assigned($data, $signature_assigned_id) {
        $this->db->where('id', $signature_assigned_id);
        return $this->db->update('signatures_assigned', $data);
    }

    public function add_signature_assigned($data) {
        return $this->db->insert('signatures_assigned', $data);
    }
}
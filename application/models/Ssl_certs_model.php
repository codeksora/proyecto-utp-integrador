<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ssl_certs_model extends CI_Model {

    public function get_all($start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
        cus.name as customer_name, 
        dom.common_name,
        ssl.created_at, ssl.updated_at,
        ssl.id, cus.id as customer_id
        ');
        $this->db->from('ssl_certificates ssl');
        $this->db->join('domains dom', 'dom.id = ssl.domain_id');
        $this->db->join('customers cus', 'cus.id = ssl.customer_id', 'left');
        if($search_value != NULL) {
            $this->db->or_like('cus.name', $search_value);
            $this->db->or_like('dom.common_name', $search_value);
            $this->db->or_like('ssl.created_at', $search_value);
            $this->db->or_like('ssl.updated_at', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_ssl_certs_by_order($order_id) {
        $this->db->select('
            ssl.id, dom.common_name
        ');
        $this->db->from('ssl_certificates ssl');
        $this->db->join('domains dom', 'dom.id = ssl.domain_id');
        // $this->db->join('tb_orden tbo', 'tbo.idcliente = tbs.idcliente', 'LEFT');
        $this->db->where('tbo.id_orden', $order_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->status_id = intval($row->status_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_ssl_certs_by_customer($customer_id) {
        $this->db->select('
            ssl.id, dom.common_name, cus.name as customer_name,
            ssl.created_at
        ');
        $this->db->from('ssl_certificates ssl');
        $this->db->join('domains dom', 'dom.id = ssl.domain_id');
        $this->db->join('customers cus', 'cus.id = ssl.customer_id', 'left');
        $this->db->where('ssl.customer_id', $customer_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->status_id = intval($row->status_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_ssl_cert($data) {
        return $this->db->insert('ssl_certificates', $data);
    }

}

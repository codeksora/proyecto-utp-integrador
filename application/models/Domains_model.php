<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Domains_model extends CI_Model {

    public function get_all($start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
        dom.id,
        dom.common_name,
        dom.status_id,
        dom.created_at,
        dom.updated_at,
        dom.user_id,
        usr.full_name
        ');
        $this->db->from('domains dom');
        $this->db->join('users usr', 'usr.id = dom.user_id');
        // if($search_value != NULL) {
        //     $this->db->or_like('cus.name', $search_value);
        //     $this->db->or_like('ssl.common_name', $search_value);
        // }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Domains_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_customers_by_domain($domain_id) {
        $this->db->select('*');
        $this->db->from('customers_domains cusdom');
        $this->db->join('customers cus', 'cusdom.customer_id = cus.id', 'left');
        $this->db->where('cusdom.domain_id', $domain_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Domains_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_domain($data) {
        return $this->db->insert('domains', $data);
    }


}

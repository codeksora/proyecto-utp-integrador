<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Módulo de proveedores
class Providers_model extends CI_Model {

    // Recibir todos los proveedores
    public function get_all() {
        $this->db->select('
            pro.id, 
            pro.name,
            ppt.product_type_id
        ');
        $this->db->from('providers pro');
      $this->db->join('providers_product_types ppt', 'ppt.provider_id = pro.id', 'right');
        $this->db->where('pro.status_id !=', 3);
        $this->db->order_by('name');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Providers_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
          $row->product_type_id = intval($row->product_type_id);
        }

        return $rows;
    }	

    public function get_all_dt($start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
            pro.name, pro.phone, pro.email, pro.website, pro.updated_at, pro.id, pro.created_at
        ');
        $this->db->from('(SELECT * FROM providers WHERE status_id != 3) as pro');
        if($search_value != NULL) {
            $this->db->like('pro.name', $search_value);
            $this->db->or_like('pro.phone', $search_value);
            $this->db->or_like('pro.email', $search_value);
            $this->db->or_like('pro.website', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Providers_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_provider($provider_id) {
        $this->db->select('
            prov.name, prov.phone, prov.email, prov.website, prov.id, prov.created_at, prov.updated_at,
            u.full_name as user_full_name
        ');
        $this->db->from('providers prov');
        $this->db->join('users u', 'u.id = prov.user_id', 'left');
        $this->db->where('prov.id', $provider_id);
        $this->db->where('prov.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Providers_model');

            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function search_provider($id) {
        $this->db->select('
            *
        ');
        $this->db->from('providers p');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    public function add_provider($provider_data) {
        return $this->db->insert('providers', $provider_data);
    }

    public function update_provider($data, $id) {
        $this->db->where('id', $id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('providers', $data);
    }

    public function delete_provider($provider_id) {
        $this->db->where('id', $provider_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('providers', array('status_id' => 3));

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }
	
}
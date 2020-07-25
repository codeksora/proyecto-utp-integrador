<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges_model extends CI_Model {

	public function get_all() {
        $this->db->join('menus m', 'm.id = p.menu_id');
        $this->db->join('roles r', 'r.id = p.role_id');
        $this->db->from('privileges p');
        $this->db->select('p.id as privilege_id, 
            m.id as menu_id, 
            r.id as role_id,
            m.name as menu_name, 
            r.name as role_name, 
            p.read, 
            p.insert, 
            p.update, 
            p.delete');
            $query = $this->db->get();
		return $query->result();
	}	

	public function count_all() {
        $this->db->from("privileges");
		return $this->db->count_all_results();
	}

    public function get_privilege($id) {
        $this->db->where('p.id', $id);
        $this->db->join('menus m', 'm.id = p.menu_id');
        $this->db->join('roles r', 'r.id = p.role_id');
        $this->db->from('privileges p');
        $this->db->select('p.id as privilege_id, 
            m.id as menu_id, 
            r.id as role_id,
            m.name as menu_name, 
            r.name as role_name, 
            p.read, 
            p.insert, 
            p.update, 
            p.delete');
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Privileges_model');
            $row->read = intval($row->read);
            $row->insert = intval($row->insert);
            $row->update = intval($row->update);
            $row->delete = intval($row->delete);

            return $row;
        } else return FALSE;
        
    }

    public function get_privileges_by_role($role_id) {
        $this->db->from('privileges p');
        $this->db->select('p.id as privilege_id, 
            m.id as menu_id, 
            r.id as role_id,
            m.name as menu_name, 
            r.name as role_name, 
            p.read, 
            p.insert, 
            p.update, 
            p.delete');
        $this->db->join('roles r', 'r.id = p.role_id');
        $this->db->join('menus m', 'm.id = p.menu_id AND p.role_id = ' . $role_id, 'right');
        // $this->db->where('p.role_id', $role_id);
        $query = $this->db->get();

        $rows = $query->custom_result_object('Privileges_model');

        foreach($rows as $row) {
            $row->menu_id = intval($row->menu_id);
            $row->read = ($row->read == 1) ? TRUE : FALSE;
            $row->insert = ($row->insert == 1) ? TRUE : FALSE;
            $row->update = ($row->update == 1) ? TRUE : FALSE;
            $row->delete = ($row->delete == 1) ? TRUE : FALSE;

        }

        return $rows;
        
    }

    public function add_privilege($data) {
        return $this->db->insert('privileges', $data);
    }

    public function update_privilege($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('privileges', $data);
    }

    public function delete_privilege($id) {
        $this->db->where('id', $id);
        return $this->db->delete('privileges');
    }

    public function delete_privilege_by_role($role_id) {
        $this->db->where('role_id', $role_id);
        return $this->db->delete('privileges');
    }
	
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_model extends CI_Model {
	public function get_id($url) {
		$this->db->like('url', $url);
		$query = $this->db->get('menus');
		return $query->row();
	}

	public function get_privileges($menu, $role) {
		$this->db->where('menu_id', $menu);
		$this->db->where('role_id', $role);
		$query = $this->db->get('privileges');

		if($query->num_rows() == 1) {
			$row = $query->custom_row_object(0, 'Backend_model');
			$row->menu_id = intval($row->menu_id);
			$row->role_id = intval($row->role_id);
            $row->read = intval($row->read);
            $row->insert = intval($row->insert);
            $row->update = intval($row->update);
            $row->delete = intval($row->delete);

            return $row;
        } else return FALSE;
	}

	public function get_all_privileges($role) {
		$this->db->where('role_id', $role);
		$query = $this->db->get('privileges');
		return $query->result();
	}
}
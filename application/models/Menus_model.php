<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_model extends CI_Model {

	public function get_all() {
		// $this->db->select('m.id, m.name, m.url, p.read, p.insert, p.update, p.delete');
		$this->db->select('m.id, m.name, m.url');
		$this->db->from('menus m');
		// $this->db->join('privileges p', 'm.id = p.menu_id');
        $query = $this->db->get();
		return $query->result();
	}	
	
}
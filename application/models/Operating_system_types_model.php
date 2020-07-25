<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Operating_system_types_model extends CI_Model {

	public function get_all() {
        $query = $this->db->get('operating_system_types');
		return $query->result();
	}
}

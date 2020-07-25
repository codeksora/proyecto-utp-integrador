<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_types_model extends CI_Model {

	public function get_all() {
    $query = $this->db->get('order_types');
		return $query->result();
	}
}

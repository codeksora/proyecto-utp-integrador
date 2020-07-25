<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_templates_model extends CI_Model {
    public function get_all() {
        $query = $this->db->get('quotation_templates');
        return $query->result();
    }
}
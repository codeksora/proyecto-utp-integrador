<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ssl_cert_forms_model extends CI_Model {

	public function get_ssl_cert_form($ssl_cert_form_id) {

	}

	public function add_form($data) {
        return $this->db->insert('ssl_certificate_forms', $data);
    }

}
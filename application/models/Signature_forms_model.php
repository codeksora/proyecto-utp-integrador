<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Signature_forms_model extends CI_Model {

	public function get_singature_forms() {
		$this->db->select('
			*
		');
		$this->db->from('signature_forms sigf');
		$this->db->where('sigf.persestadouser', 'Valido');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Signature_forms_model');

        foreach($rows as $row) {
            $row->idpersonal = intval($row->idpersonal);
            $row->persfechavalidacion = $row->persfechavalidacion ? strtotime($row->persfechavalidacion) * 1000 : '';
        }

        return $rows;
	}

	public function add_form($data) {
        return $this->db->insert('signature_forms', $data);
    }

    public function update_signature_form($data, $signature_form_id) {
        $this->db->where('idpersonal', $signature_form_id);
        return $this->db->update('signature_forms', $data);
    }

}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_types_model extends CI_Model {

	public function get_all() {
        $query = $this->db->get('currency_types');
		$rows = $query->custom_result_object('Currency_types_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
        }

        return $rows;
    }
    
    public function get_currency_type($currency_type_id) {
        $this->db->select('*');
        $this->db->from('currency_types');
        $this->db->where('id', $currency_type_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
          return $query->row();
        else
          return FALSE;
    }
}

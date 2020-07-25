<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Configurations_model extends CI_Model {

	public function get_all() {
        $this->db->select('
	        conf.option, conf.value
        ');
        $this->db->from('configurations conf');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Configurations_model');

        foreach($rows as $row) {
            // $row->option = $row->value;
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function update_config($data, $option) {
        $this->db->where('option', $option);
        // $this->db->where('status_id !=', 3);
        return $this->db->update('configurations', $data);
    }

    public function get_by_option($option) {
        $this->db->select('
            conf.value
        ');
        $this->db->from('configurations conf');
        $this->db->where('conf.option', $option);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Configurations_model');

            return $row;
        } else return FALSE;

    }

}
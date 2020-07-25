<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Document_types_model extends CI_Model {

    public function get_all() {
        $this->db->select('
            dtt.id, dtt.name
        ');
        $this->db->from('document_types dtt');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Document_types_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
        }

        return $rows;
    }

}
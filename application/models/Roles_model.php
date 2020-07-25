<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roles_model extends CI_Model {

	public function get_all() {
        $query = $this->db->get_where('roles', array('status_id' => 2));
		return $query->result();
	}	

	public function count_all() {
        $this->db->where('status_id !=', 1);
        $this->db->from("roles");
		return $this->db->count_all_results();
	}

    public function get_role($id) {
        $query = $this->db->get_where('roles', array('id' => $id), 1);
        if($query->num_rows() == 1)
          return $query->row();
        else
          return FALSE;
    }

    public function search_role($id) {
        $query = $this->db->get_where('roles', array('id' => $id));
        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    public function add_role($data) {
        return $this->db->insert('roles', $data);
    }

    public function update_role($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('roles', $data);
    }

    public function delete_role($id) {
        $data = array(
            'status_id' => 1
        );

        $this->db->where('id', $id);
        $this->db->update('roles', $data);

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }
	
}
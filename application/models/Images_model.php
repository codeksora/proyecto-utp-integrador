<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Images_model extends CI_Model {

	public function get_all() {
        $query = $this->db->get('images');
		return $query->result();
	}

	public function count_all() {
        $this->db->where('status_id !=', 1);
        $this->db->from("categories");
		return $this->db->count_all_results();
	}

	public function get_current_page_records($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->where('status_id !=', 1);
        $query = $this->db->get('categories');
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return array();
	}
	
	public function get_category($id) {
        $query = $this->db->get_where('categories', array('id' => $id), 1);
        return $query->row();
    }

	public function add_image($data) {
        return $this->db->insert('images', $data);
    }

    public function update_category($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($id) {
        $data = array(
            'status_id' => 1
        );

        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }
}
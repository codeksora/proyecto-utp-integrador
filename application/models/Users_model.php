<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

  /*
   * Login
   */
//  public function find_by_email($email) {
//      $this->db->select('*, u.id as user_id, i.name as image_name');
//      $this->db->from('users u');
//      $this->db->join('images i', 'i.id = u.image_id', 'left');
//      $this->db->where('u.email', $email);
//      $this->db->where('u.status_id', 2);
//      $this->db->or_where('u.status_id', 4);
//      $this->db->limit(1);
//      $query = $this->db->get();
//      return $query->row();
//  }

  public function loginUser($username, $password) {
      $this->db->where('u.username', $username);
      $this->db->where('u.status_id', 1);
      $query = $this->db->get('users u');
      $db_password = $query->num_rows() == 1 ? $query->row(10)->password : '';
      if(password_verify($password, $db_password)) return $query->row(0)->id;
      else return $query->row();
	}

    /*
     * Admin
     */
    public function get_all($start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
            TRIM(u.full_name) as full_name, 
            u.username, TRIM(u.email) as email, u.role_id, 
            r.name as role_name, u.id, u.status_id,
        ');
        $this->db->from('(SELECT * FROM users WHERE status_id != 3) as u');
        $this->db->join('roles r', 'r.id = u.role_id', 'left');
        if($search_value != NULL) {
            $this->db->like('u.full_name', $search_value);
            $this->db->or_like('u.username', $search_value);
            $this->db->or_like('u.email', $search_value);
            $this->db->or_like('r.name', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Users_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
  }

	public function count_all() {
        $this->db->where('status_id !=', 3);
        $this->db->from("tb_usuario");
		return $this->db->count_all_results();
	}

    public function get_user($id) {
        $this->db->select('
            u.id, u.full_name, 
            u.username, 
            u.status_id, 
            u.email, 
            u.role_id, 
            im.name as image_name,
            rl.name as role_name,
            u.job_title, u.extension
        ');
        $this->db->from('users u');
        $this->db->join('images im', 'im.id = u.image_id', 'left');
        $this->db->join('roles rl', 'rl.id = u.role_id');
        $this->db->where('u.id', $id);
        $this->db->where('u.status_id', 1);
        $query = $this->db->get();
        if($query->num_rows() == 1)
          return $query->row();
        else
          return FALSE;
    }

    public function search_user($id) {
        $this->db->select('
            *
        ');
        $this->db->from('users u');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
            return $query->row();
        else
            return FALSE;
    }

    public function add_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($data, $id) {
        $this->db->where('id', $id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        $this->db->where('status_id !=', 3);
        $this->db->update('users', array('status_id' => 3));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }

}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Phone_codes_model
 *
 * @package     Código de teléfono
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Notifications_model extends CI_Model {
    /**
     * Muestra todos los códigos de teléfono.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            not.id, not.description, not.color, not.icon, not.created_at, not.subject
        ');
        $this->db->from('notifications not');
        $this->db->join('users usr', 'usr.id = not.user_id');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Notifications_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
             $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_all_now() {
        $this->db->select('
            not.id, not.description, not.color, not.icon, not.created_at, not.subject
        ');
        $this->db->from('notifications not');
        $this->db->join('users usr', 'usr.id = not.user_id');
        $this->db->where('DATE_FORMAT(not.created_at, "%Y-%m-%d") =', date('Y-m-d'));
        $this->db->order_by('not.created_at', 'DESC');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Notifications_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_all_dt($start = NULL, $length = NULL, $order_column = '',
                               $order_dir = '', $search_value = NULL) {
        $this->db->select('
            not.id, not.description, not.color, not.icon, not.created_at, not.subject, usr.full_name as user_full_name
        ');
        $this->db->from('notifications not');
        $this->db->join('users usr', 'usr.id = not.user_id');
        if($search_value != NULL) {
//            $this->db->like('u.full_name', $search_value);
//            $this->db->or_like('u.username', $search_value);
//            $this->db->or_like('u.email', $search_value);
//            $this->db->or_like('r.name', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Notifications_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_notification($data) {
        return $this->db->insert('notifications', $data);
    }
}
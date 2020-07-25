<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_obs_model extends CI_Model {

    public function get_order_observations($order_id) {
        $this->db->select('
            obs.message, obs.user_id, obs.created_at,
            us.full_name
        ');
        $this->db->from('order_observations obs');
        $this->db->join('users us', 'us.id = obs.user_id', 'left');
        $this->db->where('obs.order_id', $order_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Order_obs_model');

        foreach($rows as $row) {
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_obs($data) {
      return $this->db->insert('order_observations', $data);
    }
}

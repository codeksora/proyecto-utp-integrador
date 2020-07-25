<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Phone_codes_model
 *
 * @package     Código de teléfono
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Credit_times_model extends CI_Model {
    /**
     * Muestra todos los códigos de teléfono.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            ct.id, ct.name
        ');
        $this->db->from('credit_times ct');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Credit_times_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_credit_time($credit_time_id) {
        $query = $this->db->get_where('credit_times', array('id' => $credit_time_id));

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Credit_times_model');
            $row->id = intval($row->id);

            return $row;
        } else return FALSE;
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Countries_model
 *
 * @package     Países
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Countries_model extends CI_Model {

    /**
     * Muestra todos los contactos con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            count.id, count.name
        ');
        $this->db->from('countries count');
        $this->db->order_by('count.name');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Countries_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
}
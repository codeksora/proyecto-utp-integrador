<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Phone_codes_model
 *
 * @package     Código de teléfono
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Concepts_model extends CI_Model {
    /**
     * Muestra todos los códigos de teléfono.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            con.id, con.name
        ');
        $this->db->from('concepts con');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Concepts_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
}
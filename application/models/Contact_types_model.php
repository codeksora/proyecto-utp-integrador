<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contact_types_model
 *
 * @package     Tipos de contacto
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Contact_types_model extends CI_Model {

    /**
     * Muestra todos los tipos de contacto con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            ct.id, ct.name
        ');
        $this->db->from('contact_types ct');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Contact_types_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
}
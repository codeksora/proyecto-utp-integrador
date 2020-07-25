<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contact_types_model
 *
 * @package     Tipos de contacto
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Additional_sans_model extends CI_Model {

    /**
     * Muestra todos los tipos de contacto con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_additional_sans_by_ssl_certificates_assigned($ssl_certificates_assigned_id) {
        $this->db->select('
            adds.id,
            adds.common_name
        ');
        $this->db->from('additional_sans adds');
        $this->db->where('adds.ssl_certificate_assigned_id', $ssl_certificates_assigned_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Additional_sans_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_addition_sans($additional_san_data) {
        return $this->db->insert('additional_sans', $additional_san_data);
    }
}
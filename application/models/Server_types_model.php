<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sectors_model
 *
 * @package     Sectores
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Server_types_model extends CI_Model {

    /**
     * Muestra todos los sectores.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            st.id, st.name, st.operating_system_type_id
        ');
        $this->db->from('server_types st');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Server_types_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->operating_system_type_id = intval($row->operating_system_type_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sectors_model
 *
 * @package     Sectores
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Sectors_model extends CI_Model {

    /**
     * Muestra todos los sectores.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            sec.id, sec.name
        ');
        $this->db->from('sectors sec');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Sectors_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
}
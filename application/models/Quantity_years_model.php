<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sectors_model
 *
 * @package     Sectores
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Quantity_years_model extends CI_Model {

    /**
     * Muestra todos los sectores.
     *
     * @return      array
     */
    public function get_all() {
        $this->db->select('
            quye.id, quye.name
        ');
        $this->db->from('quantity_years quye');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quantity_years_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
        }

        return $rows;
    }
}
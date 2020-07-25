<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contacts_model
 *
 * @package     Contactos
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Contacts_model extends CI_Model {

    /**
     * Muestra todos los contactos con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_all($start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
            cont.first_name, cont.last_name, cus.name as customer_name, cont.job_title, cont.email, cont.phone, cont.mobile_phone, cont.created_at,
            cus.document_number, cont.id, cont.status_id, cont.customer_id
        ');
        $this->db->from('(SELECT * FROM contacts WHERE status_id != 3) as cont');
        if($search_value != NULL) {
            $this->db->like('cont.first_name', $search_value);
            $this->db->or_like('cont.last_name', $search_value);
            $this->db->or_like('cus.name', $search_value);
            $this->db->or_like('cont.job_title', $search_value);
            $this->db->or_like('cont.email', $search_value);
            $this->db->or_like('cont.phone', $search_value);
            $this->db->or_like('cont.mobile_phone', $search_value);
            $this->db->or_like('DATE_FORMAT(cont.created_at, "%d/%m/%Y")', $search_value);
        }
        $this->db->join('customers cus', 'cus.id = cont.customer_id', 'left');
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Contacts_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    /**
     * Muestra los datos de un producto.
     *
     * @param       int     $contact_id
     * @return      array
     */
    public function get_contact($contact_id) {
        $this->db->select('
            cont.id, cont.first_name, cont.last_name, cont.job_title, cont.email, cont.phone, cont.mobile_phone, 
            cont.address_line_1, cont.address_line_2, cont.state, cont.city, cont.extension, cont.phone_code_id,
            cont.country_id, cont.customer_id, cont.contact_type_id,
            cus.document_number, cus.name as customer_name, cus.website,
            conty.name as contact_type_name,
            phc.code,
            ctry.name as country_name, 
        ');
        $this->db->from('contacts cont');
        $this->db->join('customers cus', 'cus.id = cont.customer_id', 'left');
        $this->db->join('phone_codes phc', 'phc.id = cont.phone_code_id', 'left');
        $this->db->join('contact_types conty', 'conty.id = cont.contact_type_id', 'left');
        $this->db->join('countries ctry', 'ctry.id = cont.country_id', 'left');
        $this->db->where('cont.id', $contact_id);
        $this->db->where('cont.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Contacts_model');

            $row->id = intval($row->id);
            $row->phone_code_id = intval($row->phone_code_id);
            $row->country_id = intval($row->country_id);
            $row->contact_type_id = intval($row->contact_type_id);
            $row->customer_id = intval($row->customer_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function get_contact_by_customer($customer_id) {
        $this->db->select('
            cont.id, cont.first_name, cont.last_name, cont.job_title, cont.email, cont.phone, cont.mobile_phone, 
            cont.address_line_1, cont.address_line_2, cont.state, cont.city, cont.extension, cont.phone_code_id,
            cont.country_id, cont.customer_id, cont.contact_type_id,
            cus.document_number, cus.name as customer_name, cus.website,
            conty.name as contact_type_name,
            phc.code,
            ctry.name as country_name
        ');
        $this->db->from('contacts cont');
        $this->db->join('customers cus', 'cus.id = cont.customer_id', 'left');
        $this->db->join('phone_codes phc', 'phc.id = cont.phone_code_id', 'left');
        $this->db->join('contact_types conty', 'conty.id = cont.contact_type_id', 'left');
        $this->db->join('countries ctry', 'ctry.id = cont.country_id', 'left');
        $this->db->where('cont.customer_id', $customer_id);
        $this->db->where('cont.status_id !=', 3);
        $query = $this->db->get();

        $rows = $query->custom_result_object('Contacts_model');

        foreach($rows as $row) {

            $row->id = intval($row->id);
            $row->phone_code_id = intval($row->phone_code_id);
            $row->country_id = intval($row->country_id);
            $row->contact_type_id = intval($row->contact_type_id);
            $row->customer_id = intval($row->customer_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        } 

        return $rows;
    }

    /**
     * Agrega un nuevo contacto.
     *
     * @param       array  $contact_data
     * @return      bool
     */
    public function add_contact($contact_data) {
        return $this->db->insert('contacts', $contact_data);
    }

    /**
     * Actualizar un contacto.
     *
     * @param       array   $contact_data
     * @param       int     $contact_id
     * @return      bool
     */
    public function update_contact($contact_data, $contact_id) {
        $this->db->where('id', $contact_id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('contacts', $contact_data);
    }

    /**
     * Elimina un contacto cambiando su estado a 3.
     *
     * @param       int     $contact_id
     * @return      bool
     */
    public function delete_contact($contact_id) {
        $this->db->where('id', $contact_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('contacts', array('status_id' => 3));

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }
}
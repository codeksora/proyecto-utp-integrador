<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_signatures_assigned_model extends CI_Model {

    public function get_contacts_by_signature_assigned($signature_assigned_id, $start = NULL, $length = NULL, $order_column = '', $order_dir = '', $search_value = NULL) {
        $this->db->select("
        cnsign.id,    
        con.first_name, con.last_name,
        con.email, con.phone, con.job_title, con.address_line_1, cont.name as contact_type_name,
        cnsign.contact_id
        ");
        $this->db->from('contacts_signatures_assigned cnsign');
        $this->db->join('contacts con', 'con.id = cnsign.contact_id', 'left');
        $this->db->join('contact_types cont', 'cont.id = cnsign.contact_type_id');
        $this->db->where('cnsign.signature_assigned_id', $signature_assigned_id);
        $this->db->where('cnsign.status_id !=', 3);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Contacts_signatures_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->contact_id = intval($row->contact_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_contact_signature_assigned($contact_data) {
        return $this->db->insert('contacts_signatures_assigned', $contact_data);
    }

    public function delete_contact($signature_assigned_id, $contact_id) {
        $this->db->where('id', $contact_id);
        $this->db->where('signature_assigned_id', $signature_assigned_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('contacts_signatures_assigned', array('status_id' => 3));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }
}
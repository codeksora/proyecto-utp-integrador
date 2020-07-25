<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts_ssl_certs_assigned_model extends CI_Model {

    public function get_contacts_by_ssl_cert_assigned($ssl_cert_assigned_id, $start = NULL, $length = NULL, $order_column = '', $order_dir = '', $search_value = NULL) {
        $this->db->select("
        cnssl.id,    
        con.first_name, con.last_name,
        con.email, con.phone, con.job_title, con.address_line_1, cont.name as contact_type_name,
        cnssl.contact_id
        ");
        $this->db->from('contacts_ssl_certificates_assigned cnssl');
        $this->db->join('contacts con', 'con.id = cnssl.contact_id', 'left');
        $this->db->join('contact_types cont', 'cont.id = cnssl.contact_type_id');
        $this->db->where('cnssl.ssl_certificate_assigned_id', $ssl_cert_assigned_id);
        $this->db->where('cnssl.status_id !=', 3);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Contacts_ssl_certs_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->contact_id = intval($row->contact_id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            // $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function add_contact_ssl_cert_assigned($contact_data) {
        return $this->db->insert('contacts_ssl_certificates_assigned', $contact_data);
    }

    public function delete_contact($ssl_cert_assigned_id, $contact_id) {
        $this->db->where('id', $contact_id);
        $this->db->where('ssl_certificate_assigned_id', $ssl_cert_assigned_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('contacts_ssl_certificates_assigned', array('status_id' => 3));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }
}
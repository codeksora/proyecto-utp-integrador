<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_contacts_model extends CI_Model {

    public function get_contacts_by_customer($customer_id, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
            cusco.id,
            cusco.contact_id,
            con.first_name as contact_first_name,
            con.last_name as contact_last_name,
            con.job_title as contact_job_title,
            con.email as contact_email,
            con.phone as contact_phone,
            con.extension as contact_extension,
            con.mobile_phone as contact_mobile_phone
        ');
        $this->db->from('customer_contacts cusco');
        $this->db->join('customers cus', 'cus.id = cusco.customer_id', 'left');
        $this->db->join('contacts con', 'con.id = cusco.contact_id', 'left');
        $this->db->where('cusco.customer_id', $customer_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Customer_contacts_model');

        foreach ($rows as $row) {
            $row->id = intval($row->id);
            // $row->customer_id = intval($row->customer_id);
            $row->contact_id = intval($row->contact_id);
            // $row->idcliente = intval($row->idcliente);
        }

        return $rows;
    }

}

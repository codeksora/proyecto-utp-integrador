<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model {

       /**
     * Muestra todos los contactos con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_all($start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
            cust.name, cust.document_number, cust.address_line_1, cust.address_line_2, cust.phone, cust.id
        ');
        $this->db->from('(SELECT * FROM customers WHERE status_id != 3) as cust');
        if($search_value != NULL) {
            $this->db->like('cust.name', $search_value);
            $this->db->or_like('cust.document_number', $search_value);
            $this->db->or_like('cust.address_line_1', $search_value);
            $this->db->or_like('cust.address_line_2', $search_value);
            $this->db->or_like('cust.phone', $search_value);
            // $this->db->join('customers cus', 'cus.id = cont.customer_id', 'left');
            // $this->db->where('cust.status_id !=', 3);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Customers_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            // $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

	public function count_all() {
        $this->db->from("customers c");
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('u.status_id !=', 3);
        return $this->db->count_all_results();
	}

    public function search_customer_by_ruc($ruc) {
        $this->db->select('*');
        $this->db->from('customers cus');
        $this->db->where('cus.document_number', $ruc);
        $this->db->where('cus.status_id', 1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Customers_model');

            return $row;
        } else return FALSE;
    }

    public function get_customer($id) {
        $this->db->select('
            cust.name, cust.document_number, cust.address_line_1, cust.address_line_2, cust.phone, cust.id,
            cust.shipping_address, cust.website, cust.state, cust.city, cust.document_type_id, cust.sector_id,
            cust.country_id, cust.phone_code_id, cust.mobile_phone, cust.extension,
            dt.name as document_type_name,
            count.name as country_name,
            sec.name as sector_name,
            phc.code
            ');
        $this->db->from('customers cust');
        $this->db->join('document_types dt', 'dt.id = cust.document_type_id', 'left');
        $this->db->join('countries count', 'count.id = cust.country_id', 'left');
        $this->db->join('sectors sec', 'sec.id = cust.sector_id', 'left');
        $this->db->join('phone_codes phc', 'phc.id = cust.phone_code_id', 'left');
        $this->db->where('cust.id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Customers_model');

            $row->id = intval($row->id);
            $row->document_type_id = intval($row->document_type_id);
            $row->country_id = intval($row->country_id);
            $row->sector_id = intval($row->sector_id);
            $row->phone_code_id = intval($row->phone_code_id);

            return $row;
        } else return FALSE;
    }

    // public function get_customer_by_email($email) {

    //     $this->db->select('u.id, u.first_name, u.last_name, u.email, c.id as customer_id, c.phone, c.country');
    //     $this->db->from('customers c');
    //     $this->db->join('users u', 'u.id = c.user_id', 'left');
    //     $this->db->where('u.email', $email);
    //     $this->db->limit(1);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

	// public function get_current_page_records($limit, $start) {
    //     $this->db->select('u.id, u.first_name, u.last_name, u.email, c.phone, c.country');
    //     $this->db->from('customers c');
    //     $this->db->join('users u', 'u.id = c.user_id', 'left');
    //     $this->db->where('u.status_id !=', 1);
    //     $this->db->where('u.role_id', 4);
    //     $this->db->limit($limit, $start);
    //     $query = $this->db->get();

    //     if ($query->num_rows() > 0)
    //     {
    //         foreach ($query->result() as $row)
    //         {
    //             $data[] = $row;
    //         }

    //         return $data;
    //     }

    //     return array();
    // }

    public function add_customer($data) {
        return $this->db->insert('customers', $data);
    }

    public function update_customer($data, $customer_id) {
        $this->db->where('id', $customer_id);
        return $this->db->update('customers', $data);
    }

    /**
     * Elimina un cliente cambiando su estado a 3.
     *
     * @param       int     $customer_id
     * @return      bool
     */
    public function delete_customer($customer_id) {
        $this->db->where('id', $customer_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('customers', array('status_id' => 3));

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }

}

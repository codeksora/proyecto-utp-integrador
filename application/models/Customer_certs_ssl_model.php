<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_certs_ssl_model extends CI_Model {

    public $id_certSSL;
    public $idcliente;
    public $commonName_certSSL;
    public $nombrecliente;
    public $tipo_certSSL;

    public function get_certs_ssl_by_customer($customer_id) {
        $this->db->where('idcliente', $customer_id);
        $this->db->from('tb_ssl');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Customer_certs_ssl_model');

        foreach ($rows as $row) {
            $row->id_certSSL = intval($row->id_certSSL);
            $row->idcliente = intval($row->idcliente);
        }

        return $rows;
    }

}

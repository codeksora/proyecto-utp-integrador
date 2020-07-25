<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ssl_certs_assigned_model extends CI_Model {

    public function get_all($ssl_certificate_status_s = NULL, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
        cus.name as customer_name,
        pro.name as product_name,
        dom.common_name,
        usr.full_name as user_full_name,
        sslas.updated_at,
        stsslce.id as ssl_certificate_status_id,
        stsslce.name as status_ssl_certificate_name,
        sslas.expiration_date, sslas.id, stsslce.id as status_ssl_certificate_id,
        stsslce.class
        ');
        $this->db->from('(SELECT * FROM ssl_certificates_assigned WHERE ssl_certificate_status_id != 8) as sslas');
        $this->db->join('ssl_certificate_status stsslce', 'stsslce.id = sslas.ssl_certificate_status_id');
        $this->db->join('ssl_certificates sslce', 'sslce.id = sslas.ssl_certificate_id');
        $this->db->join('domains dom', 'dom.id = sslce.domain_id');
        $this->db->join('quotation_product_details odp', 'odp.id = sslas.quotation_product_detail_id');
        $this->db->join('orders ord', 'ord.quotation_id = odp.quotation_id');
        $this->db->join('quotations qot', 'qot.id = ord.quotation_id');
        $this->db->join('customers cus', 'cus.id = qot.customer_id', 'left');
        $this->db->join('product_details prode', 'prode.id = odp.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prode.product_id', 'left');
        $this->db->join('users usr', 'usr.id = sslas.user_id');
        if($search_value != NULL) {
            $this->db->or_like('cus.name', $search_value);
            $this->db->or_like('pro.name', $search_value);
            $this->db->or_like('dom.common_name', $search_value);
            // $this->db->or_like('opst.name', $search_value);
            // $this->db->or_like('servt.name', $search_value);
            $this->db->or_like('DATE_FORMAT(sslas.updated_at, "%d/%m/%Y")', $search_value);
            $this->db->or_like('stsslce.name', $search_value);
        }
        if($ssl_certificate_status_s != NULL) $this->db->where('sslas.ssl_certificate_status_id', $ssl_certificate_status_s);
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->status_ssl_certificate_id = intval($row->status_ssl_certificate_id);
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_all_pending($ssl_certificate_status_s = NULL, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
        cus.name as customer_name,
        pro.name as product_name,
        dom.common_name,
        opst.name as operating_system_type_name, 
        servt.name as server_type_name, 
        sslas.updated_at,
        stsslce.id as ssl_certificate_status_id,
        stsslce.name as status_ssl_certificate_name,
        sslas.expiration_date, sslas.id, stsslce.id as status_ssl_certificate_id,
        stsslce.class,
        ord.order_number,
        sslas.id
        ');
        $this->db->from("(SELECT * FROM ssl_certificates_assigned WHERE ssl_certificate_status_id = 8) as sslas");
        $this->db->join('ssl_certificate_status stsslce', 'stsslce.id = sslas.ssl_certificate_status_id', 'left');
        $this->db->join('server_types servt', 'servt.id = sslas.server_type_id', 'left');
        $this->db->join('operating_system_types opst', 'opst.id = servt.operating_system_type_id', 'left');
        $this->db->join('ssl_certificates sslce', 'sslce.id = sslas.ssl_certificate_id', 'left');
        $this->db->join('domains dom', 'dom.id = sslce.domain_id', 'left');
        $this->db->join('quotation_product_details odp', 'odp.id = sslas.quotation_product_detail_id', 'left');
        $this->db->join('quotations qot', 'qot.id = odp.quotation_id');
        $this->db->join('orders ord', 'ord.quotation_id = qot.id');
        $this->db->join('customers cus', 'cus.id = qot.customer_id');
        $this->db->join('product_details prod', 'prod.id = odp.product_detail_id');
        $this->db->join('products pro', 'pro.id = prod.product_id');
        if($search_value != NULL) {
            $this->db->or_like('cus.name', $search_value);
            $this->db->or_like('pro.name', $search_value);
            $this->db->or_like('dom.common_name', $search_value);
            $this->db->or_like('opst.name', $search_value);
            $this->db->or_like('servt.name', $search_value);
            $this->db->or_like('DATE_FORMAT(sslas.updated_at, "%d/%m/%Y")', $search_value);
            $this->db->or_like('stsslce.name', $search_value);
        }
        if($ssl_certificate_status_s != NULL) $this->db->where('sslas.ssl_certificate_status_id', $ssl_certificate_status_s);
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->status_ssl_certificate_id = intval($row->status_ssl_certificate_id);
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    public function get_ssl_cert_assigned($id) {
        $this->db->select('
            sslas.id, sslas.ssl_certificate_status_id,
            qot.customer_id, cus.name as customer_name,
            ord.order_number, ord.customer_order_number, ord.order_date, ord.expiration_date as order_expiration_date,
            pro.name as product_name, pro.is_san,
            dom.common_name, servt.name as server_type_name, opsys.name as operating_system_types,
            odp.id as order_product_detail_id,
            sslas.enroll_code,
            sslas.expiration_date, sslas.issue_date, sslas.installation_date,
            sslst.class, sslfo.organizacion_cli, sslfo.ruc_cli, sslfo.direccion_cli, sslfo.telefono_cli,
            sslfo.periodo, sslfo.accion, sslfo.servidor, sslfo.cantservidor, sslfo.CommonName_CSR, sslfo.Organizacion_CSR,
            sslfo.UnidadOrganizacion_CSR, sslfo.Ciudad_CSR, sslfo.Estado_CSR, sslfo.Pais_CSR, sslfo.key_CSR, sslfo.Desc_csr,
            sslfo.nombreSSL_Adm, sslfo.apellidoSSL_Adm, sslfo.organizacionSSL_Adm, sslfo.mailSSL_Adm, sslfo.cargoSSL_Adm,
            sslfo.telOfSSL_Adm, sslfo.direccionSSL_Adm, sslfo.nombreSSL_Tec, sslfo.apellidoSSL_Tec, sslfo.organizacionSSL_Tec,
            sslfo.mailSSL_Tec, sslfo.cargoSSL_Tec, sslfo.telOfSSL_Tec, sslfo.direccionSSL_Tec,
            pro.san_base, opsd.quantity, (opsd.quantity + pro.san_base) as total_san,
            sslfo.codPostal_cli
            
        ');
        //conc.name as concept_name
        $this->db->from('ssl_certificates_assigned sslas');
        $this->db->join('ssl_certificate_forms sslfo', 'sslfo.id_formulario = sslas.ssl_certificate_form_id', 'left');
        $this->db->join('ssl_certificate_status sslst', 'sslst.id = sslas.ssl_certificate_status_id', 'left');
        $this->db->join('quotation_product_details odp', 'odp.id = sslas.quotation_product_detail_id', 'left');
        $this->db->join('product_details prd', 'prd.id = odp.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prd.product_id', 'left');
        $this->db->join('quotations qot', 'qot.id = odp.quotation_id');
        // $this->db->join('quotation_products qotp', 'qotp.quotation_id = qot.id');
        // $this->db->join('concepts conc', 'conc.id = qotp.concept_id');
        $this->db->join('orders ord', 'ord.quotation_id = qot.id');
        $this->db->join('customers cus', 'cus.id = qot.customer_id');
        $this->db->join('ssl_certificates sslcer', 'sslcer.id = sslas.ssl_certificate_id', 'left');
        $this->db->join('domains dom', 'dom.id = sslcer.domain_id', 'left');
        $this->db->join('server_types servt', 'servt.id = sslas.server_type_id', 'left');
        $this->db->join('operating_system_types opsys', 'opsys.id = servt.operating_system_type_id', 'left');
        $this->db->join('quotation_product_san_details opsd', 'opsd.quotation_product_id = odp.quotation_product_id', 'left');
        $this->db->join('product_san_details prosd', 'prosd.id = opsd.product_san_detail_id AND prosd.product_id = pro.id', 'left');
        $this->db->where('sslas.id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Ssl_certs_assigned_model');

            $row->total_san = intval($row->total_san);
            // $row->customer_id = intval($row->customer_id);
            // $row->order_date = $row->order_date ? strtotime($row->order_date) * 1000 : '';
            // $row->order_expiration_date = $row->order_expiration_date ? strtotime($row->order_expiration_date) * 1000 : '';
            // $row->issue_date = $row->issue_date ? strtotime($row->issue_date) * 1000 : '';
            // $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            // $row->installation_date = $row->installation_date ? strtotime($row->installation_date) * 1000 : '';
            // $row->san_base = intval($row->san_base);
            // $row->quantity = intval($row->quantity);
            // $row->phone_code_id = intval($row->phone_code_id);

            return $row;
        } else return FALSE;
    }

    public function get_ssl_certs_assigned_by_order($order_id, $start = NULL, $length = NULL, $order_column = '', 
    $order_dir = '', $search_value = NULL) {
        $this->db->select('
            pro.name as product_name, 
            dom.common_name, sslas.created_at, 
            sslst.name as ssl_certificate_status_name,
            sslas.ssl_certificate_status_id,
            sslst.class as ssl_certificate_status_class, sslas.renovated,
            sslas.expiration_date, sslas.issue_date
        ');
        $this->db->from('ssl_certificates_assigned sslas');
        $this->db->join('ssl_certificate_status sslst', 'sslst.id = sslas.ssl_certificate_status_id', 'left');
        $this->db->join('ssl_certificates sslce', 'sslce.id = sslas.ssl_certificate_id', 'left');
        $this->db->join('domains dom', 'dom.id = sslce.domain_id', 'left');
        $this->db->join('quotation_product_details ordp', 'ordp.id = sslas.quotation_product_detail_id', 'left');
        $this->db->join('orders ord', 'ord.quotation_id = ordp.quotation_id');
        $this->db->join('product_details prod', 'prod.id = ordp.product_detail_id', 'left');
        $this->db->join('products pro', 'pro.id = prod.product_id', 'left');
        $this->db->where('ord.id', $order_id);
        if($search_value != NULL) {
            $this->db->like('pro.name', $search_value);
            $this->db->or_like('dom.common_name', $search_value);
            $this->db->or_like('sslst.name', $search_value);
            $this->db->or_like('DATE_FORMAT(sslas.created_at, "%d/%m/%Y")', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Ssl_certs_assigned_model');

        foreach($rows as $row) {
            $row->ssl_certificate_status_id = intval($row->ssl_certificate_status_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            $row->issue_date = $row->issue_date ? strtotime($row->issue_date) * 1000 : '';
        }

        return $rows;
    }

    public function update_ssl_cert_assigned($data, $ssl_cert_assigned_id) {
        $this->db->where('id', $ssl_cert_assigned_id);
        return $this->db->update('ssl_certificates_assigned', $data);
    }

    public function add_ssl_cert_assigned($data) {
        return $this->db->insert('ssl_certificates_assigned', $data);
    }
}
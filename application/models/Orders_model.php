<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model {
    public function get_all(
        $start = NULL, $length = NULL, $order_column = '', 
        $order_dir = 'DESC', $search_value = NULL) {
        $this->db->select('
            ord.reception_date, ord.expiration_date, cstm.name as customer_name, 
            ord.customer_order_number, ord.invoice_number, us.full_name, ord.order_type_id, ord.id, 
            
        ');
        $this->db->from('(SELECT * FROM orders WHERE status_id = 1) ord');
        $this->db->join('quotations quo', 'quo.id = ord.quotation_id');
        $this->db->join('customers cstm', 'cstm.id = quo.customer_id');
        $this->db->join('users us', 'us.id = ord.user_id');
        if($search_value != NULL) {
            $this->db->like('cstm.name', $search_value);
            $this->db->or_like('ord.reception_date', $search_value);
            $this->db->or_like('ord.expiration_date', $search_value);
            $this->db->or_like('ord.order_number', $search_value);
            $this->db->or_like('ord.status_id', $search_value);
            $this->db->or_like('us.full_name', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Orders_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
        }

        return $rows;
    }

    // public function get_all_quotations(
    //     $start = NULL, $length = NULL, $order_column = '', 
    //     $order_dir = 'DESC', $search_value = NULL) {
    //     $this->db->select('
    //         ord.created_at,
    //         cstm.name as customer_name,
    //         ord.reception_date, ord.expiration_date,
    //         ord.total as order_total,
    //         ord.order_number, ord.customer_order_number, ord.order_type_id, ord.id, 
    //         cuty.symbol as currency_type_symbol, ord.quotation_document, us.full_name as user_full_name,
    //         st.class as status_class, st.name as status_name, st.id as status_id, st.description as status_description
    //     ');
    //     $this->db->from('orders as ord');
    //     $this->db->join('customers cstm', 'cstm.id = ord.customer_id');
    //     $this->db->join('currency_types cuty', 'cuty.id = ord.currency_type_id');
    //     $this->db->join('users us', 'us.id = ord.user_id');
    //     $this->db->join('status st', 'st.id = ord.status_id');
    //     if($search_value != NULL) {
    //         $this->db->like('cstm.name', $search_value);
    //         $this->db->or_like('DATE_FORMAT(ord.created_at, "%d/%m/%Y")', $search_value);
    //         $this->db->or_like('ord.total', $search_value);
    //         // $this->db->or_like('ord.expiration_date', $search_value);
    //         // $this->db->or_like('ord.order_number', $search_value);
    //         // $this->db->or_like('cuty.symbol', $search_value);
    //         // $this->db->or_like('ord.status_id', $search_value);
    //     }
    //     $this->db->limit($length, $start);
    //     $this->db->order_by($order_column, $order_dir);
    //     $query = $this->db->get();
    //     $rows = $query->custom_result_object('Orders_model');

    //     foreach($rows as $row) {
    //         $row->id = intval($row->id);
    //         $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
    //         $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
    //         $row->order_type_id = intval($row->order_type_id);
    //     }

    //     return $rows;
    // }

    // public function get_all_quotations_to_approve(
    //     $start = NULL, $length = NULL, $order_column = '', 
    //     $order_dir = 'DESC', $search_value = NULL) {
    //     $this->db->select('
    //         ord.created_at,
    //         cstm.name as customer_name,
    //         ord.reception_date, ord.expiration_date,
    //         ord.total as order_total,
    //         ord.order_number, ord.customer_order_number, ord.order_type_id, ord.id, 
    //         cuty.symbol as currency_type_symbol, ord.quotation_document, us.full_name as user_full_name,
    //         st.class as status_class, st.name as status_name, st.id as status_id, st.description as status_description
    //     ');
    //     $this->db->from('(SELECT * FROM orders WHERE status_id = 4) as ord');
    //     $this->db->join('customers cstm', 'cstm.id = ord.customer_id');
    //     $this->db->join('currency_types cuty', 'cuty.id = ord.currency_type_id');
    //     $this->db->join('users us', 'us.id = ord.user_id');
    //     $this->db->join('status st', 'st.id = ord.status_id');
    //     if($search_value != NULL) {
    //         $this->db->like('cstm.name', $search_value);
    //         $this->db->or_like('DATE_FORMAT(ord.created_at, "%d/%m/%Y")', $search_value);
    //         $this->db->or_like('ord.total', $search_value);
    //         // $this->db->or_like('ord.expiration_date', $search_value);
    //         // $this->db->or_like('ord.order_number', $search_value);
    //         // $this->db->or_like('cuty.symbol', $search_value);
    //         // $this->db->or_like('ord.status_id', $search_value);
    //     }
    //     $this->db->limit($length, $start);
    //     $this->db->order_by($order_column, $order_dir);
    //     $query = $this->db->get();
    //     $rows = $query->custom_result_object('Orders_model');

    //     foreach($rows as $row) {
    //         $row->id = intval($row->id);
    //         $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
    //         $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
    //         $row->order_type_id = intval($row->order_type_id);
    //     }

    //     return $rows;
    // }

    public function get_all_by_filter($customer, $fact, $startRec, $endRec) {
        $this->db->select('
            ord.id, ord.reception_date, ord.expiration_date, ord.order_number, ord.nro_cotizacionOrd, ord.customer_order_number, 
            ord.order_type_id, ord.factAsocOrd,
            cstm.name as customer_name,
        ');
        $this->db->join('customers cstm', 'cstm.id = ord.customer_id');
        if($fact != '') $this->db->or_like('ord.factAsocOrd', $fact);
        if($customer != '') $this->db->or_where('cstm.id', $customer);
        if($startRec != '' && $endRec != '') $this->db->or_where("(ord.reception_date >= '$startRec' AND ord.reception_date <= '$endRec')");
        $this->db->order_by('ord.reception_date', 'DESC');
        if($fact == '' && $customer == '' && $startRec == '' && $endRec == '') $this->db->limit(100);
        $this->db->where('ord.status_id !=', 3);
        $query = $this->db->get('orders ord');
        $rows = $query->custom_result_object('Orders_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
        }

        return $rows;
    }

    public function get_order_details($id) {
        $this->db->select('
            tbd.desc_detord,
            tbd.concepto2,
            tbd.tiempo2,
            tbd.cant_detord,
            tbd.preciounit_detord,
            tbd.subtotal_detord
        ');
        $this->db->from('orders ord');
        $this->db->join('tb_detordprod tbd', 'tbd.idorden = tbo.id_orden');
        $this->db->where('tbo.id_orden', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function search_quotation($id) {
        $this->db->select('
            *
        ');
        $this->db->from('orders ord');
        $this->db->where('ord.id', $id);
        $this->db->where('ord.status_id', 5);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Orders_model');
            return $row;
        } else return FALSE;
    }

    public function get_order($id) {
        $this->db->select('
            ord.id, ord.reception_date, ord.expiration_date, ord.order_date, ord.customer_order_number, ord.order_number, ord.status_id, 
            quo.currency_type_id, quo.subtotal, quo.tax, quo.total, ord.order_type_id, ordt.name as order_type_name,
            cus.name as customer_name,
            cut.name as currency_type_name, cut.symbol, quo.quotation_document,
            ord.quotation_id, cus.document_number as customer_document_number, cus.address_line_1 as customer_address_line_1,
            ord.invoice_number
        ');
        $this->db->from('orders ord');
        $this->db->join('quotations quo', 'quo.id = ord.quotation_id');
        $this->db->join('customers cus', 'cus.id = quo.customer_id', 'left');
        $this->db->join('currency_types cut', 'cut.id = quo.currency_type_id', 'left');
        $this->db->join('order_types ordt', 'ordt.id = ord.order_type_id', 'left');
        $this->db->where('ord.id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Orders_model');
            $row->id = intval($row->id);
            $row->quotation_id = intval($row->quotation_id);
            $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
            $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            $row->order_date = $row->order_date ? strtotime($row->order_date) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function get_order_certs_ssl($id) {
        $this->db->select('
        tbd.id_detordprdcertssl,
        tbs.commonName_certSSL,
        tbp.nombre,
        tbd.estado_certSSL,
        DATE_FORMAT(tbd.fchemision_certSSL, "%d/%m/%Y") as fchemision_certSSL,
        DATE_FORMAT(tbd.fchvencimiento_certSSL, "%d/%m/%Y") as fchvencimiento_certSSL
        ');
        $this->db->from('tb_orden tbo');
        $this->db->join('tb_detordprodcertssl tbd', 'tbd.idorden = tbo.id_orden');
        $this->db->join('tb_ssl tbs', 'tbd.idcertSSL = tbs.id_certSSL');
        $this->db->join('tb_producto tbp', 'tbd.idproducto = tbp.id_producto');
        $this->db->where('tbo.id_orden', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_order_firms($id) {
        $this->db->select('
        tbd.id_detordcertfirma,
        tbc.nom_certFirmper,
        tbc.correo_certFirmper,
        tbp.nombre,
        DATE_FORMAT(tbd.fchcreacion_certfirmPer, "%d/%m/%Y") as fchcreacion_certfirmPer,
        DATE_FORMAT(tbd.fchvencimiento_certfirmPer, "%d/%m/%Y") as fchvencimiento_certfirmPer,
        tbd.estado_certfirmPer
        ');
        $this->db->from('tb_orden tbo');
        $this->db->join('tb_detordprodcertfirma tbd', 'tbd.idorden = tbo.id_orden');
        $this->db->join('tb_certfirmapersonal tbc', 'tbd.idcertfirmPer = tbc.id_certFirmper');
        $this->db->join('tb_producto tbp', 'tbd.idproducto = tbp.id_producto');
        $this->db->where('tbo.id_orden', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function add_order($data) {
        return $this->db->insert('orders', $data);
    }

    public function update_order($data, $id) {
        $this->db->where('id', $id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('orders', $data);
    }

    public function delete_order($order_id) {
        $this->db->where('id', $order_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('orders', array('status_id' => 3));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }

    public function disable_quotation($order_id) {
        $this->db->where('id', $order_id);
        $this->db->where('status_id !=', 2);
        $this->db->update('orders', array('status_id' => 2));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }

    public function approve_quotation($order_id) {
        $this->db->where('id', $order_id);
        $this->db->where('status_id', 4);
        $this->db->update('orders', array('status_id' => 5));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }
    
    public function api_get_all() {
        $this->db->select('o.order_date, o.invoice_number, c.name as customer_name, c.document_number, u.full_name as user_name, q.quotation_number, p.name as product_name, ct.symbol as currency_type_symbol, pd.price');
        $this->db->from('product_details pd');
        $this->db->join('products p', 'p.id = pd.product_id');
        $this->db->join('quotation_products op', 'op.product_detail_id = pd.id');
        $this->db->join('quotations q', 'q.id = op.quotation_id');
        $this->db->join('orders o', 'o.quotation_id = q.id', 'right');
        $this->db->join('customers c', 'c.id = q.customer_id');
        $this->db->join('users u', 'u.id = o.user_id');
        $this->db->join('currency_types ct', 'ct.id = q.currency_type_id');
        $query = $this->db->get();
        $rows = $query->custom_result_object('Orders_model');

        foreach($rows as $row) {
            $row->currency_type_symbol = $row->currency_type_symbol == 1 ? 'PEN' : 'USD';
        }

        return $rows;
    }
}

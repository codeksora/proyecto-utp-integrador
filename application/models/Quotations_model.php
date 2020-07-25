<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quotations_model extends CI_Model {

	public function get_all_dt(
        $start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
			quot.created_at,
            cstm.name as customer_name,
            us.full_name as user_full_name,
            quot.quotation_number,
            quot.total as order_total,
            st.name as status_name,
            quot.id, 
            cuty.symbol as currency_type_symbol, quot.quotation_document,
            st.class as status_class, st.id as status_id, st.description as status_description,
            quot.quotation_template_id
        ');
        $this->db->from('(SELECT * FROM quotations WHERE status_id != 3) as quot');
        $this->db->join('customers cstm', 'cstm.id = quot.customer_id');
        $this->db->join('currency_types cuty', 'cuty.id = quot.currency_type_id');
        $this->db->join('users us', 'us.id = quot.user_id');
        $this->db->join('status st', 'st.id = quot.status_id');
        if($search_value != NULL) {
            $this->db->like('DATE_FORMAT(quot.created_at, "%d/%m/%Y")', $search_value);
            $this->db->or_like('cstm.name', $search_value);
            $this->db->or_like('us.full_name', $search_value);
            $this->db->or_like('quot.quotation_number', $search_value);
            $this->db->or_like('quot.total', $search_value);
            $this->db->or_like('st.name', $search_value);
            // $this->db->or_like('cuty.symbol', $search_value);
            // $this->db->or_like('ord.status_id', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quotations_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->status_id = intval($row->status_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->order_total = floatval($row->order_total);

        }

        return $rows;
    }

    public function get_all_to_approve_dt(
        $start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
			quot.created_at,
            cstm.name as customer_name,
            quot.total as order_total,
            quot.id, 
            cuty.symbol as currency_type_symbol, quot.quotation_document, us.full_name as user_full_name,
            st.class as status_class, st.name as status_name, st.id as status_id, st.description as status_description
        ');
        $this->db->from('(SELECT * FROM quotations WHERE status_id = 4) as quot');
        $this->db->join('customers cstm', 'cstm.id = quot.customer_id');
        $this->db->join('currency_types cuty', 'cuty.id = quot.currency_type_id');
        $this->db->join('users us', 'us.id = quot.user_id');
        $this->db->join('status st', 'st.id = quot.status_id');
        if($search_value != NULL) {
            // $this->db->like('cstm.name', $search_value);
            // $this->db->or_like('DATE_FORMAT(ord.created_at, "%d/%m/%Y")', $search_value);
            // $this->db->or_like('ord.total', $search_value);
            // $this->db->or_like('ord.expiration_date', $search_value);
            // $this->db->or_like('ord.order_number', $search_value);
            // $this->db->or_like('cuty.symbol', $search_value);
            // $this->db->or_like('ord.status_id', $search_value);
        }
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Quotations_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->status_id = intval($row->status_id);
            // $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->order_total = floatval($row->order_total);
        }

        return $rows;
    }



    public function search_quotation($id) {
        $this->db->select('
            *
        ');
        $this->db->from('quotations quot');
        $this->db->where('quot.id', $id);
        $this->db->where('quot.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Quotations_model');
            // $row->id = intval($row->id);
            // $row->reception_date = $row->reception_date ? strtotime($row->reception_date) * 1000 : '';
            // $row->expiration_date = $row->expiration_date ? strtotime($row->expiration_date) * 1000 : '';
            // $row->order_date = $row->order_date ? strtotime($row->order_date) * 1000 : '';

            return $row;
        } else return FALSE;
    }

    public function get_quotation($id) {
        $this->db->select('
            quot.id, quot.status_id, 
            quot.currency_type_id, quot.subtotal, quot.tax, quot.total,
            cus.name as customer_name, cus.document_number as customer_document_number,
            cut.name as currency_type_name, cut.symbol as currency_type_symbol, quot.quotation_document, quot.quotation_number,
            quot.observation, usr.full_name as user_full_name, usr.job_title as user_job_title, usr.extension as user_extension,
            cont.first_name as contact_first_name, cont.last_name as contact_last_name, quot.quotation_template_id, cont.email as contact_email,
            quot.created_at, cret.name as credit_time_name
        ');
        $this->db->from('quotations quot');
        $this->db->join('customers cus', 'cus.id = quot.customer_id', 'left');
        $this->db->join('contacts cont', 'cont.id = quot.contact_id', 'left');
      $this->db->join('credit_times cret', 'cret.id = quot.credit_time_id', 'left');
        $this->db->join('currency_types cut', 'cut.id = quot.currency_type_id', 'left');
        $this->db->join('users usr', 'usr.id = quot.user_id', 'left');
        // $this->d
        $this->db->where('quot.id', $id);
        $this->db->where('quot.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Quotations_model');
            $row->id = intval($row->id);

            return $row;
        } else return FALSE;
    }
    
    // Agregar cotización
    public function add_quotation($quotation_data, $products) {
      
      $this->db->trans_start(); // INICIO DE TRANSACCIÓN
      // AGREGAR COTIZACIÓN
        $this->db->insert('quotations', $quotation_data);
			$quotation_id = $this->db->insert_id();
			$quotation_number = "COT-".str_pad( $quotation_id, '8', '0', STR_PAD_LEFT);

			$data_quotation['quotation_document'] = "$quotation_number.pdf";
			$data_quotation['quotation_number'] = $quotation_number;
      
      $this->db->where('id', $quotation_id);
      $this->db->where('status_id !=', 3);
      $this->db->update('quotations', $data_quotation);

			foreach ($products as $product) {
				$product_amount = $product["amount"];
				$product_detail_id = $product['product_detail_id'];
				$product_subtotal = $product['subtotal'];
				$product_discount = floatval($product['discount']);
				$product_total = $product['total'];
				$concept_id = $product['concept_id'];
        
				if(isset($product['mails'])) {
					$mails = $product['mails'];
					$mails_array = array();
					foreach ($mails as $mail) {
						array_push($mails_array, $mail['text']);
					}
					$mails = implode(",", $mails_array);
					$quotation_product['mails'] = $mails;
				}
        
        if(isset($product['domains'])) {
					$domains = $product['domains'];
					$domains_array = array();
					foreach ($domains as $domain) {
						array_push($domains_array, $domain['text']);
					}
					$domains = implode(",", $domains_array);
					$quotation_product['domains'] = $domains;
				}

				$quotation_product['quotation_id'] = $quotation_id;
				$quotation_product['concept_id'] = $concept_id;
				$quotation_product['amount'] = $product_amount;
				$quotation_product['subtotal'] = $product_subtotal;
				$quotation_product['discount'] = $product_discount;
				$quotation_product['total'] = $product_total;
				$quotation_product['product_detail_id'] = $product_detail_id;
        
        $this->db->insert('quotation_products', $quotation_product);
        
        $quotation_product_id = $this->db->insert_id();
        
				for($i=1; $i <= $product_amount; $i++) {
					$quotation_product_detail['quotation_id'] = $quotation_id;
          $quotation_product_detail['quotation_product_id'] = $quotation_product_id;
					$quotation_product_detail['product_detail_id'] = $product['product_detail_id'];
					$quotation_product_detail['created_at'] = date("Y-m-d H:i:s");
					$quotation_product_detail['updated_at'] = date("Y-m-d H:i:s");
					$quotation_product_detail['user_id'] = $this->session->userdata('user_id');
					$quotation_product_detail['status_id'] = 1;
					$quotation_product_detail['price'] = $product['product_detail_price'];

					$this->db->insert('quotation_product_details', $quotation_product_detail);
				}
				if($product['is_san'] == 1) {
					$quotation_product_san_detail['product_san_detail_id'] = $product['product_san_detail_id'];
// 					$quotation_product_san_detail['quotation_id'] = $quotation_id;
					$quotation_product_san_detail['price'] = $product['product_san_detail_price'];
					$quotation_product_san_detail['quantity'] = $product['qty_san'];
          $quotation_product_san_detail['quotation_product_id'] = $quotation_product_id;

					$this->db->insert('quotation_product_san_details', $quotation_product_san_detail);
				}
			}

			$this->db->trans_complete(); // FIN DE TRANSACCIÓN
      
      return $this->db->trans_status();
    }

    public function disable_quotation($quotation_id) {
        $this->db->where('id', $quotation_id);
        $this->db->where('status_id !=', 2);
        $this->db->update('quotations', array('status_id' => 2));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }

    public function approve_quotation($quotation_id) {
        $this->db->where('id', $quotation_id);
        $this->db->where('status_id', 4);
        $this->db->update('quotations', array('status_id' => 5));

        if ($this->db->affected_rows() > 0)
          return TRUE;
        else
          return FALSE;
    }

    public function approve_all_quotation() {
        $this->db->where('status_id', 4);
        return $this->db->update('quotations', array('status_id' => 5));
    }

    public function update_quotation($data, $id) {
        $this->db->where('id', $id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('quotations', $data);
    }

}
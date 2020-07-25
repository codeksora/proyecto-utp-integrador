<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_orders_PMController extends REST_Controller {

    private $url;
	private $privileges;

	public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Orders_model');
		// $this->load->model('Order_products_model');
		// $this->load->model('Order_product_details_model');
		// $this->load->model('Order_product_san_details_model');
		$this->load->library('form_validation');
		date_default_timezone_set('America/Lima');
    }

  	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/orders/orders_view', $data);
		}
	}

  	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders/orders_add_view');
		}
	}

  	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders/orders_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders/orders_modal_view');
		}
	}

	public function modal_assign_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders/orders_modal_assign_view');
		}
	}

	public function modal_assign_product_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders/orders_modal_assign_product_view');
		}
	}

	public function assign_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/orders/orders_assign_view', $data);
		}
	}

    public function invoice_view_get() {
        if(!isset($this->privileges) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $this->load->view('admin/templates/orders/orders_invoice_view');
        }
    }

    public function bill_view_get() {
        if(!isset($this->privileges) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $this->load->view('admin/templates/orders/orders_bill_view');
        }
    }

	// public function quotations_get($id = NULL) {
 //        if($id != NULL):
 //            if($this->Orders_model->get_order($id)) {
 //                $this->response($this->Orders_model->get_order($id), REST_Controller::HTTP_OK);
 //            } else {
 //                $this->response(
 //                    array(
 //                        'err' => TRUE,
 //                        'status' => 'error',
 //                        'message' => 'Esta orden no existe'
 //                    ), REST_Controller::HTTP_OK);
 //            }
	// 	else:
	// 		$start = $this->get('start');
	// 		$length = $this->get('length');
	// 		$draw = $this->get('draw');
	// 		$order = $this->get('order');
	// 		$order_column = (int) $order[0]['column'] + 1;
	// 		$order_dir = $order[0]["dir"];
	// 		$search = $this->get("search");
	// 		$search_value = $search["value"];

	// 		$data = array(
	// 			'draw' => $draw,
	// 			'recordsTotal' => count($this->Orders_model->get_all_quotations($start, $length)),
	// 			'recordsFiltered' => count($this->Orders_model->get_all_quotations(NULL, NULL, $order_column, $order_dir, $search_value)),
	// 			'data' => $this->Orders_model->get_all_quotations($start, $length, $order_column, $order_dir, $search_value)
	// 		);
	// 		$this->response($data, REST_Controller::HTTP_OK);
 //        endif;
	// }

	public function quotations_approve_get($id = NULL) {
        if($id != NULL):
            if($this->Orders_model->get_order($id)) {
                $this->response($this->Orders_model->get_order($id), REST_Controller::HTTP_OK);
            } else {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Esta orden no existe'
                    ), REST_Controller::HTTP_OK);
            }
		else:
			$start = $this->get('start');
			$length = $this->get('length');
			$draw = $this->get('draw');
			$order = $this->get('order');
			$order_column = (int) $order[0]['column'] + 1;
			$order_dir = $order[0]["dir"];
			$search = $this->get("search");
			$search_value = $search["value"];

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Orders_model->get_all_quotations_to_approve($start, $length)),
				'recordsFiltered' => count($this->Orders_model->get_all_quotations_to_approve(NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Orders_model->get_all_quotations_to_approve($start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
        endif;
	}

//	public function quotations_approve_put($order_id = NULL) {
//		if($this->Orders_model->approve_quotation($order_id)) {
//			$this->response(
//				array(
//					'err' => FALSE,
//					'status' => 'success',
//					'message' => 'Aprobado correctamente'
//				), REST_Controller::HTTP_OK);
//		} else {
//			$this->response(
//				array(
//					'err' => TRUE,
//					'status' => 'error',
//					'message' => 'Error al aprobar la cotización'
//				), REST_Controller::HTTP_OK);
//		}
//	}

	public function orders_get($id = NULL) {
        if($id != NULL):
            if($this->Orders_model->get_order($id)) {
                $this->response($this->Orders_model->get_order($id), REST_Controller::HTTP_OK);
            } else {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Esta orden no existe'
                    ), REST_Controller::HTTP_OK);
            }
		else:
			$start = $this->get('start');
			$length = $this->get('length');
			$draw = $this->get('draw');
			$order = $this->get('order');
			$order_column = (int) $order[0]['column'] + 1;
			$order_dir = $order[0]["dir"];
			$search = $this->get("search");
			$search_value = $search["value"];

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Orders_model->get_all($start, $length)),
				'recordsFiltered' => count($this->Orders_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Orders_model->get_all($start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
        endif;

	}

    public function orders_filter_get() {
		$startRec = $this->get('startRec');
		$endRec = $this->get('endRec');
		$customer = $this->get('customer');
		$fact = $this->get('n_fact');

		$this->response(
			$this->Orders_model->get_all_by_filter($customer, $fact, $startRec, $endRec),
			REST_Controller::HTTP_OK);
	}
	// Agregar orden
	public function orders_post() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			$products = $this->post('data_products');
			$currency_type_id = $this->post('currency_type_id');
			$customer_id = $this->post('customer_id');
			$observation = $this->post('observation');
			$order_type_id = $this->post('order_type_id');
			$customer_order_number = $this->post('customer_order_number');
			$order_date = date("Y-m-d H:i:s", strtotime($this->post('order_date')));
			$reception_date = date("Y-m-d H:i:s", strtotime($this->post('reception_date')));
			$expiration_date = date("Y-m-d H:i:s", strtotime($this->post('expiration_date')));
			$subtotal = $this->post('subtotal');
			$tax = $this->post('tax');
			$total = $this->post('total');

			$data['customer_id'] = $customer_id;
			$data['status_id'] = 4;
			$data['currency_type_id'] = $currency_type_id;
			$data['subtotal'] = $subtotal; 
			$data['tax'] = $tax;
			$data['total'] = $total;
			$data['user_id'] = $this->session->userdata('user_id');
			$data['created_at'] = date("Y-m-d H:i:s");
			$data['updated_at'] = date("Y-m-d H:i:s");

			$config['upload_path'] = './quotation_docs/';
			$config['allowed_types'] = 'pdf';
			$config['encrypt_name'] = TRUE;

	        $this->load->library('upload', $config);

			if(isset($_FILES['quotation_document'])) {
				if ( ! $this->upload->do_upload('quotation_document')) {
	                $this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => $this->upload->display_errors()
						), REST_Controller::HTTP_OK);

	                return;
	            } else {
	                $data['quotation_document'] = $this->upload->data('file_name');
	            }
	        } 
			$this->db->trans_start(); // INICIO DE TRANSACCIÓN


			$this->Orders_model->add_order($data);
			$order_id = $this->db->insert_id();

			$order_number = "ORD-".str_pad( $order_id, '8', '0', STR_PAD_LEFT);
			$data['order_number'] = $order_number;

			$this->Orders_model->update_order($data, $order_id);

			foreach ($products as $product) {
				$amount = $product["amount"];
				$product_detail_id = $product['product_detail_id'];
				$subtotal = $product['subtotal'];
				$discount = $product['discount'];
				$total = $product['total'];
				$concept_id = $product['concept_id'];

				$order_product['order_id'] = $order_id;
				$order_product['concept_id'] = $concept_id;
				$order_product['amount'] = $amount;
				$order_product['subtotal'] = $subtotal;
				$order_product['discount'] = $discount;
				$order_product['total'] = $total;
				$order_product['product_detail_id'] = $product_detail_id;

				$this->Order_products_model->add_order_product($order_product);
				
				for($i=1; $i <= $amount; $i++) {
					$order_product_detail['order_id'] = $order_id;
					$order_product_detail['product_detail_id'] = $product['product_detail_id'];
					$order_product_detail['created_at'] = date("Y-m-d H:i:s");
					$order_product_detail['updated_at'] = date("Y-m-d H:i:s");
					$order_product_detail['user_id'] = $this->session->userdata('user_id');
					$order_product_detail['status_id'] = 1;
					$order_product_detail['price'] = $product['product_detail_price'];

					$this->Order_product_details_model->add_order_product_detail($order_product_detail);
				}	
				if($product['is_san'] == 1) {
					$order_product_san_detail['product_san_detail_id'] = $product['product_san_detail_id'];
					$order_product_san_detail['order_id'] = $order_id;
					$order_product_san_detail['price'] = $product['product_san_detail_price'];
					$order_product_san_detail['quantity'] = $product['qty_san'];

					$this->Order_product_san_details_model->add_order_product_san_detail($order_product_san_detail);
				}
			}

			$this->db->trans_complete(); // FIN DE TRANSACCIÓN

			if($this->db->trans_status() === FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Error al agregar la cotización'
					), REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => FALSE,
						'status' => 'success',
						'message' => 'Agregado correctamente'
					), REST_Controller::HTTP_OK);
			}
		endif;
	}

	public function orders_put($order_id = NULL) {
		
		$customer_order_number = $this->put('customer_order_number');
		$invoice_number = $this->put('invoice_number');

		$data['customer_order_number'] = $customer_order_number;
		$data['invoice_number'] = $invoice_number;
		$data['updated_at'] = date("Y-m-d H:i:s");

		if($this->Orders_model->update_order($data, $order_id)) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Actualizado correctamente'
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al actualizar'
				), REST_Controller::HTTP_OK);
		}
		
	}

	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_ssl_certs_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

         $infomenu = $this->Backend_model->get_id($this->url);
         $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Ssl_certs_model');
    }

    public function index_get() {
        if(!isset($this->privileges->read) || $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/ssl_certificates/ssl_certificates_view', $data);
        }
	}
	
	// public function add_view_get() {
	// 	if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$this->load->view('admin/templates/ssl_certificates/ssl_certificates_add_view');
	// 	}
	// }

	public function modal_add_view_get() {
		if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_add_view');
		}
	}

	public function modal_assign_domain_to_customer_view_get() {
		if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_assign_domain_to_customer_view');
		}
	}

    public function ssl_certs_get($order_id = NULL) {
		if($order_id != NULL):
			$ssl_certs = $this->Ssl_certs_model->get_ssl_certs_by_order($order_id);

			if($ssl_certs) {
				$this->response($ssl_certs, REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Producto no existe'
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
			// $provider_s = $this->get('provider_s');
			// $product_type_s = $this->get('product_type_s');
			// $startRec_s = $this->get('startRec_s');
			// $endRec = $this->get('endRec');

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Ssl_certs_model->get_all($start, $length)),
				'recordsFiltered' => count($this->Ssl_certs_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Ssl_certs_model->get_all($start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
		endif;
	}

	public function ssl_certs_by_customer_get($customer_id = NULL) {
		if($customer_id != NULL):
			$ssl_certs = $this->Ssl_certs_model->get_ssl_certs_by_customer($customer_id);

			if($ssl_certs) {
				$this->response($ssl_certs, REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Producto no existe'
					), REST_Controller::HTTP_OK);
			}
		else:
			echo "Error de solicitud";
		endif;
	}

    public function ssl_certs_put() {
		if(!isset($this->privileges->insert) OR $this->privileges->insert == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else:
			$ssl_cert = $this->put();

			if(count($ssl_cert) > 0):
				$this->form_validation->set_data($ssl_cert);
			
				$this->form_validation->set_rules('customer_id', '<strong>Cliente</strong>', 'required');
				$this->form_validation->set_rules('domain_id', '<strong>Dominio</strong>', 'required');

				if ($this->form_validation->run() == FALSE) {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => validation_errors()
						), REST_Controller::HTTP_OK);
				} else {
					$data['customer_id'] = $this->put('customer_id');
					$data['domain_id'] = $this->put('domain_id');
					$data['user_id'] = $this->session->userdata('user_id');
					$data['created_at'] = date("Y-m-d H:i:s");
					$data['updated_at'] = date("Y-m-d H:i:s");

					if($this->Ssl_certs_model->add_ssl_cert($data)) {
						$this->response(
							array(
								'err' => FALSE,
								'status' => 'success',
								'message' => 'Agregado correctamente'
							), REST_Controller::HTTP_OK);
					} else {
						$this->response(
							array(
								'err' => TRUE,
								'status' => 'error',
								'message' => 'Error al asignar el dominio al cliente'
							), REST_Controller::HTTP_OK);
					}
				}
			else:
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Todos los campos son requeridos',
					), REST_Controller::HTTP_OK);
			endif;
		endif;
	}
	
	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_customers_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->library('session');
		if($this->session->userdata('logged_in') == FALSE) redirect();

		$this->load->model('Backend_model');
		$this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

		$infomenu = $this->Backend_model->get_id($this->url);
		$this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Customers_model');
		$this->load->library('form_validation');
		date_default_timezone_set('America/Lima');
    }

	 public function index_get() {
         if(!isset($this->privileges) OR $this->privileges->read == 0) {
	 		$this->load->view('admin/templates/errors/not_privilege');
	 	} else {
             $this->load->view('admin/templates/customers/customers_view');
         }
     }

    public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/customers/customers_add_view');
		}
	}
	
	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/customers/customers_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/customers/customers_modal_view');
		}
	}

	public function customers_post() {

		$customer_data = $this->post();

		if(count($customer_data) > 0):
			$this->form_validation->set_data($customer_data);
			$this->form_validation->set_rules('document_type_id', '<strong>Tipo de documento</strong>', 'required|integer');
			$this->form_validation->set_rules('document_number', '<strong>Número de documento</strong>', 'required|is_unique[customers.document_number]', 
				array('is_unique' => 'Este cliente ya se encuentra registrado')
			);
			$this->form_validation->set_rules('name', '<strong>Nombre de la empresa</strong>', '');
			$this->form_validation->set_rules('website', '<strong>Sitio web</strong>', 'valid_url');
			$this->form_validation->set_rules('address_line_1', '<strong>Dirección 1</strong>', 'required');
			$this->form_validation->set_rules('address_line_2', '<strong>Dirección 2</strong>', '');
			$this->form_validation->set_rules('sector_id', '<strong>Sector</strong>', 'required|integer');
			$this->form_validation->set_rules('shipping_address', '<strong>Dirección de envío</strong>', '');
			$this->form_validation->set_rules('phone_code_id', '<strong>Código de país</strong>', 'required|integer');
			$this->form_validation->set_rules('phone', '<strong>Teléfono</strong>', 'numeric|max_length[7]');
			$this->form_validation->set_rules('mobile_phone', '<strong>Celular</strong>', 'numeric|max_length[9]');
			$this->form_validation->set_rules('extension', '<strong>Anexo</strong>', 'numeric|max_length[7]');
			$this->form_validation->set_rules('state', '<strong>Estado</strong>', 'required|alpha');
			$this->form_validation->set_rules('country_id', '<strong>País</strong>', 'required|integer');
			$this->form_validation->set_rules('city', '<strong>Ciudad</strong>', 'required|alpha');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				$data['document_type_id'] = $this->post('document_type_id');
				$data['document_number'] = $this->post('document_number');
				$data['name'] = $this->post('name');
				$data['website'] = prep_url($this->post('website'));
				$data['address_line_1'] = $this->post('address_line_1');
				$data['address_line_2'] = $this->post('address_line_2');
				$data['sector_id'] = $this->post('sector_id');
				$data['shipping_address'] = $this->post('shipping_address');
				$data['country_id'] = $this->post('country_id');
				$data['state'] = $this->post('state');
				$data['city'] = $this->post('city');
				$data['phone_code_id'] = $this->post('phone_code_id');
				$data['mobile_phone'] = $this->post('mobile_phone');
				$data['phone'] = $this->post('phone');
				$data['extension'] = $this->post('extension');
				$data['status_id'] = 1;
				$data['user_id'] = $this->session->userdata('user_id');
				$data['created_at'] = date("Y-m-d H:i:s");
				$data['updated_at'] = date("Y-m-d H:i:s");

				if($this->Customers_model->add_customer($data)) {
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
							'message' => 'Error al agregar el cliente'
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
	}

    /**
     * Con Id => Recibe un cliente en específico
	 * Sin Id => Recibe todos los clientes
     *
	 * @link		/admin/customers/:customer_id		GET
     * @param 	integer		$customer_id		Id del cliente (opcional)
     * @return 	array
     */
	public function customers_get($customer_id = NULL) {
		if(!isset($this->privileges) OR $this->privileges->read == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			if($customer_id != NULL) {
				$customer = $this->Customers_model->get_customer($customer_id);

				if($customer) {
					$this->response($customer, REST_Controller::HTTP_OK);
				} else {
					$this->response(array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Acceso no permitido'
						), REST_Controller::HTTP_UNAUTHORIZED);
				}
			} else {
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
					'recordsTotal' => count($this->Customers_model->get_all($start, $length)),
					'recordsFiltered' => count($this->Customers_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
					'data' => $this->Customers_model->get_all($start, $length, $order_column, $order_dir, $search_value)
				);
				$this->response($data, REST_Controller::HTTP_OK);
			}
		endif;	
	}
	
	// public function customer($id) {
	// 	echo json_encode($this->Customers_model->get_customer($id));
	// }

	public function customers_by_ruc_get($ruc = NULL) { 
		$ruc = $this->Customers_model->search_customer_by_ruc($ruc);

		if($ruc) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Esta empresa ya está registrada',
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Esta empresa no se encuentra registrada',
				), REST_Controller::HTTP_OK);
		}

	}

	public function customers_put($customer_id = NULL) {
		
		$customer_data = $this->put();

		if(count($customer_data) > 0):
			$this->form_validation->set_data($customer_data);
			// $this->form_validation->set_rules('document_type_id', '<strong>Tipo de documento</strong>', 'required|integer');
			// $this->form_validation->set_rules('document_number', '<strong>Número de documento</strong>', 'required');
			$this->form_validation->set_rules('name', '<strong>Nombre de la empresa</strong>', 'required');
			$this->form_validation->set_rules('website', '<strong>Sitio web</strong>', 'valid_url');
			$this->form_validation->set_rules('address_line_1', '<strong>Dirección 1</strong>', 'required');
			$this->form_validation->set_rules('address_line_2', '<strong>Dirección 2</strong>', '');
			$this->form_validation->set_rules('sector_id', '<strong>Sector</strong>', 'required|integer');
			$this->form_validation->set_rules('shipping_address', '<strong>Dirección de envío</strong>', '');
			$this->form_validation->set_rules('phone_code_id', '<strong>Código de país</strong>', 'required');
			$this->form_validation->set_rules('phone', '<strong>Teléfono</strong>', '');
			$this->form_validation->set_rules('mobile_phone', '<strong>Celular</strong>', '');
			$this->form_validation->set_rules('extension', '<strong>Anexo</strong>', '');
			$this->form_validation->set_rules('country_id', '<strong>País</strong>', 'required|integer');
			$this->form_validation->set_rules('state', '<strong>Estado</strong>', 'required');
			$this->form_validation->set_rules('city', '<strong>Ciudad</strong>', 'required');
		
			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				// $data['document_type_id'] = $this->put('document_type_id');
				// $data['document_number'] = $this->put('document_number');
				$data['name'] = $this->put('name');
				$data['website'] = prep_url($this->put('website'));
				$data['address_line_1'] = $this->put('address_line_1');
				$data['address_line_2'] = $this->put('address_line_2');
				$data['sector_id'] = $this->put('sector_id');
				$data['shipping_address'] = $this->put('shipping_address');
				$data['country_id'] = $this->put('country_id');
				$data['state'] = $this->put('state');
				$data['city'] = $this->put('city');
				$data['phone_code_id'] = $this->put('phone_code_id');
				$data['mobile_phone'] = $this->put('mobile_phone');
				$data['phone'] = $this->put('phone');
				$data['extension'] = $this->put('extension');
				$data['updated_at'] = date("Y-m-d H:i:s");

				if($this->Customers_model->update_customer($data, $customer_id)) {
					$this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Actualizado correctamente',
							'resp' => $data
						), REST_Controller::HTTP_OK);
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Error al actualizar',
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
	}

	// ELIMINAR CLIENTE
	public function customers_delete($customer_id = NULL) {
		if($this->Customers_model->delete_customer($customer_id)) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Eliminado correctamente'
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al eliminar el producto'
				), REST_Controller::HTTP_OK);
		}
	}

	public function quantity_customers_get() {
        $this->response($this->Customers_model->count_all(), REST_Controller::HTTP_OK);
    }

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

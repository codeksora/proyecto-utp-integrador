<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_products_PMController
 * 
 * Permite gestionar los contactos, agregar, editar o eliminar.
 *
 * @package     Contactos
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_contacts_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Contacts_model');
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));
		$this->load->library('form_validation');
		date_default_timezone_set('America/Lima');
	}

	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/contacts/contacts_view');
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/contacts/contacts_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/contacts/contacts_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/contacts/contacts_modal_view');
		}
	}

	/**
     * Con Id => Recibe un contacto en específico
	 * Sin Id => Recibe todos los contactos
     *
	 * @link		/admin/contacts/:contact_id		GET
     * @param 	integer		$contact_id		Id del contacto (opcional)
     * @return 	array
     */
	public function contacts_get($contact_id = NULL) {
		if(!isset($this->privileges) OR $this->privileges->read == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			if($contact_id != NULL) {
				$contact = $this->Contacts_model->get_contact($contact_id);

				if($contact) {
					$this->response($contact, REST_Controller::HTTP_OK);
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
				$order = (int) $this->get('order');
				$order_column = (int) $order[0]['column'] + 1;
				$order_dir = $order[0]["dir"];
				$search = $this->get("search");
				$search_value = $search["value"];
	
				$data = array(
					'draw' => $draw,
					'recordsTotal' => count($this->Contacts_model->get_all($start, $length)),
					'recordsFiltered' => count($this->Contacts_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
					'data' => $this->Contacts_model->get_all($start, $length, $order_column, $order_dir, $search_value)
				);
				$this->response($data, REST_Controller::HTTP_OK);
			}
		endif;	
	}

	public function customer_contacts_get($customer_id = NULL) {
		$this->response(
			$this->Contacts_model->get_contact_by_customer($customer_id), 
			REST_Controller::HTTP_OK);
	}

	/**
     * Agrega nuevo contacto
     *
     * @param array 	$contact	Datos del contacto en array
     * @return array
     */
	public function contacts_post() {
		$contact_data = $this->post();

		if(count($contact_data) > 0):
			$this->form_validation->set_data($contact_data);
			$this->form_validation->set_rules('first_name', 'Nombre', 'required');
			$this->form_validation->set_rules('last_name', 'Apellido', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('phone_code_id', 'Código de país', 'required|integer');
			$this->form_validation->set_rules('phone', 'Teléfono', 'numeric');
			$this->form_validation->set_rules('mobile_phone', 'Celular', 'numeric');
			$this->form_validation->set_rules('extension', 'Anexo', 'numeric');
			$this->form_validation->set_rules('country_id', 'País', 'required|integer');
			$this->form_validation->set_rules('state', 'Estado', 'required');
			$this->form_validation->set_rules('city', 'Ciudad', 'required');
			$this->form_validation->set_rules('address_line_1', 'Dirección 1', 'required');
			$this->form_validation->set_rules('address_line_2', 'Dirección 2', '');
			$this->form_validation->set_rules('customer_id', 'Empresa', 'required|integer');
			$this->form_validation->set_rules('job_title', 'Cargo', 'required');
			$this->form_validation->set_rules('contact_type_id', 'Tipo de contacto', 'required|integer');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				$data['first_name'] = $this->post('first_name');
				$data['last_name'] = $this->post('last_name');
				$data['email'] = $this->post('email');
				$data['phone_code_id'] = $this->post('phone_code_id');
				$data['phone'] = $this->post('phone');
				$data['mobile_phone'] = $this->post('mobile_phone');
				$data['extension'] = $this->post('extension');
				$data['country_id'] = $this->post('country_id');
				$data['state'] = $this->post('state');
				$data['city'] = $this->post('city');
				$data['address_line_1'] = $this->post('address_line_1');
				$data['address_line_2'] = $this->post('address_line_2');
				$data['customer_id'] = $this->post('customer_id');
				$data['job_title'] = $this->post('job_title');
				$data['contact_type_id'] = $this->post('contact_type_id');
				$data['status_id'] = 1;
                $data['user_id'] = $this->session->userdata('user_id');
				$data['created_at'] = date("Y-m-d H:i:s");
				$data['updated_at'] = date("Y-m-d H:i:s");

				if($this->Contacts_model->add_contact($data)) {
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
							'message' => 'Error al agregar el contacto'
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

	public function contacts_put($contact_id = NULL) {
		$contact_data = $this->put();

		if(count($contact_data) > 0):
			$this->form_validation->set_data($contact_data);
			$this->form_validation->set_rules('first_name', 'Nombre', 'required');
			$this->form_validation->set_rules('last_name', 'Apellido', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('phone_code_id', 'Código de país', 'required|integer');
			$this->form_validation->set_rules('phone', 'Teléfono', 'numeric');
			$this->form_validation->set_rules('mobile_phone', 'Celular', 'numeric');
			$this->form_validation->set_rules('extension', 'Anexo', 'numeric');
			$this->form_validation->set_rules('country_id', 'País', 'required|integer');
			$this->form_validation->set_rules('state', 'Estado', 'required');
			$this->form_validation->set_rules('city', 'Ciudad', 'required');
			$this->form_validation->set_rules('address_line_1', 'Dirección 1', 'required');
			$this->form_validation->set_rules('address_line_2', 'Dirección 2', '');
			$this->form_validation->set_rules('customer_id', 'Empresa', 'required|integer');
			$this->form_validation->set_rules('job_title', 'Cargo', 'required');
			$this->form_validation->set_rules('contact_type_id', 'Tipo de contacto', 'required|integer');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				$data['first_name'] = $this->put('first_name');
				$data['last_name'] = $this->put('last_name');
				$data['email'] = $this->put('email');
				$data['phone_code_id'] = $this->put('phone_code_id');
				$data['phone'] = $this->put('phone');
				$data['mobile_phone'] = $this->put('mobile_phone');
				$data['extension'] = $this->put('extension');
				$data['country_id'] = $this->put('country_id');
				$data['state'] = $this->put('state');
				$data['city'] = $this->put('city');
				$data['address_line_1'] = $this->put('address_line_1');
				$data['address_line_2'] = $this->put('address_line_2');
				$data['customer_id'] = $this->put('customer_id');
				$data['job_title'] = $this->put('job_title');
				$data['contact_type_id'] = $this->put('contact_type_id');
				$data['updated_at'] = date("Y-m-d H:i:s");

				if($this->Contacts_model->update_contact($data, $contact_id)) {
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
							'message' => 'Error al editar el contacto'
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

	// ELIMINAR CONTACTO
	public function contacts_delete($contact_id = NULL) {
		if($this->Contacts_model->delete_contact($contact_id)) {
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
					'message' => 'Error al eliminar el contacto'
				), REST_Controller::HTTP_OK);
		}
	}

	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

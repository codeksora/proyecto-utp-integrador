<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_privileges_PMController extends REST_Controller {

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

		$this->load->model('Privileges_model');
		$this->load->library('form_validation');
    }

	public function index_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/privileges/privileges_view', $data);
		}
		
	}

	public function add_view_get() {
		if(!isset($this->privileges) || $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/privileges/privileges_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) || $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/privileges/privileges_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/privileges/privileges_modal_view');
		}
	}

	public function role_privileges_get($order_id = NULL) {
		$this->response($this->Privileges_model->get_privileges_by_role($order_id), REST_Controller::HTTP_OK);
	}

	public function privileges_post() {
		$privilege_data = $this->post();

		if(count($privilege_data) > 0):
			$this->form_validation->set_data($privilege_data);
			$this->form_validation->set_rules('menu_id', 'Menu', 'required|callback_check_privilege');
			$this->form_validation->set_rules('role_id', 'Rol', 'required');
			$this->form_validation->set_rules('read', 'Leer', 'required');
			$this->form_validation->set_rules('insert', 'Insertar', 'required');
			$this->form_validation->set_rules('update', 'Actualizar', 'required');
			$this->form_validation->set_rules('delete', 'Eliminar', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				$data['menu_id'] = $this->post('menu_id');
				$data['role_id'] = $this->post('role_id');
				$data['read'] = $this->post('read');
				$data['insert'] = $this->post('insert');
				$data['update'] = $this->post('update');
				$data['delete'] = $this->post('delete');

				if($this->Privileges_model->add_privilege($data)) {
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
							'message' => 'Error al agregar los privilegios'
						), REST_Controller::HTTP_OK);
				}
			}
		else:
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Todos los campos son requeridos'
				), REST_Controller::HTTP_OK);
		endif;
	}


	public function privileges_put($id = NULL) {

		$privilege_data = $this->put();
		$this->form_validation->set_data($privilege_data);

		$this->form_validation->set_rules('read', 'Leer', 'required');
		$this->form_validation->set_rules('insert', 'Insertar', 'required');
		$this->form_validation->set_rules('update', 'Actualizar', 'required');
		$this->form_validation->set_rules('delete', 'Eliminar', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
			$data['menu_id'] = $this->put('menu_id');
			$data['role_id'] = $this->put('role_id');
			$data['read'] = $this->put('read');
			$data['insert'] = $this->put('insert');
			$data['update'] = $this->put('update');
			$data['delete'] = $this->put('delete');

			if($this->Privileges_model->update_privilege($data, $id)) {
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
						'message' => 'Error al actualizar',
						'asd' => $id
					), REST_Controller::HTTP_OK);
			}
		} 

	}

	public function privileges_delete($id = NULL) {

		if($this->Privileges_model->delete_privilege($id)) {
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
					'message' => 'Error al eliminar el privilegio'
				), REST_Controller::HTTP_OK);
		}

	}

	public function privileges_get($id = NULL) {	
		if($id != NULL):
			$privilege = $this->Privileges_model->get_privilege($id);

			if($privilege) {
				$this->response($privilege, REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Privilegio no existe'
					), REST_Controller::HTTP_OK);
			}
		else:
			$this->response($this->Privileges_model->get_all(), REST_Controller::HTTP_OK);
		endif;
	}

	//Helper
	public function check_privilege() {
		$role_id = $this->post('role_id');
		$menu_id = $this->post('menu_id');
		$this->db->select('id');
		$this->db->from('privileges');
		$this->db->where('role_id', $role_id);
		$this->db->where('menu_id', $menu_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('check_privilege', 'Ya existe el rol para ese menú');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

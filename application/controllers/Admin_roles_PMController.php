<?php

use Pusher\Pusher;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_roles_PMController extends REST_Controller {

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

		$this->load->model('Roles_model');
		$this->load->model('Privileges_model');
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
			$this->load->view('admin/templates/roles/roles_view', $data);
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/roles/roles_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/roles/roles_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/roles/roles_modal_view');
		}
	}

	public function roles_post() {
		$role_data = $this->post();

		if(count($role_data) > 0):
			$this->form_validation->set_data($role_data);
			$this->form_validation->set_rules('name', '<strong>Nombre</strong>', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
			    $name = $this->post('name');
				$data['name'] = $this->post('name');
				$data['status_id'] = 2;

				$menus = $this->post('menus');

				$this->db->trans_start();
					$this->Roles_model->add_role($data);
					$role_id = $this->db->insert_id();

					foreach ($menus as $menu) {
						$data_privilege['role_id'] = $role_id;
						$data_privilege['menu_id']  = $menu['id'];
						$data_privilege['read'] = $menu['read'];
						$data_privilege['insert'] = $menu['insert'];
						$data_privilege['update'] = $menu['update'];
						$data_privilege['delete'] = $menu['delete'];

						$this->Privileges_model->add_privilege($data_privilege);
					}
				$this->db->trans_complete();

				if($this->db->trans_status() === FALSE) {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Error al agregar el rol',
						), REST_Controller::HTTP_OK);
				} else {
                    $notif = array(
                        'created_at' => date("Y-m-d H:i:s"),
                        'user_id' => $this->session->userdata('user_id'),
                        'subject' => 'Un rol ha sido creado',
                        'description' => "El rol $name ha sido creado correctamente.",
                        'icon' => 'user-secret',
                        'color' => 'green'
                    );
                    $this->Notifications_model->add_notification($notif);

                    $options = array(
                        'cluster' => 'us2',
                        'useTLS' => true
                    );
                    $pusher = new Pusher(
                        '5e9b6b6e06917225ff96',
                        'd8cc1d7275c3f3b46981',
                        '825366',
                        $options
                    );

                    $data['message'] = 'Enviado';
                    $pusher->trigger('ch-notif', 'ev-notif', $data);

					$this->response(
						array(
							'err' => TRUE,
							'status' => 'success',
							'message' => 'Agregado correctamente'
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

	public function roles_put($role_id = NULL) {

		$role_data = $this->put();
		$this->form_validation->set_data($role_data);

		$this->form_validation->set_rules('name', 'Nombre de rol', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
		    $name = $this->put('name');
			$data['name'] = $this->put('name');

			$menus = $this->put('menus');

			$this->db->trans_start();
				$this->Roles_model->update_role($data, $role_id);

				$this->Privileges_model->delete_privilege_by_role($role_id);

				foreach ($menus as $menu) {
					$data_privilege['role_id'] = $role_id;
					$data_privilege['menu_id']  = $menu['menu_id'];
					$data_privilege['read'] = $menu['read'];
					$data_privilege['insert'] = $menu['insert'];
					$data_privilege['update'] = $menu['update'];
					$data_privilege['delete'] = $menu['delete'];

					$this->Privileges_model->add_privilege($data_privilege);
				}
			$this->db->trans_complete();

			// if($this->db->trans_status() === FALSE) {
			// 	$this->response(
			// 		array(
			// 			'err' => TRUE,
			// 			'status' => 'error',
			// 			'message' => 'Error al actualizar'
			// 		), REST_Controller::HTTP_OK);
			// } else {

            $notif = array(
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'subject' => 'Un rol ha sido editado',
                'description' => "El rol $name ha sido editado correctamente.",
                'icon' => 'user-secret',
                'color' => 'yellow'
            );
            $this->Notifications_model->add_notification($notif);

            $options = array(
                'cluster' => 'us2',
                'useTLS' => true
            );
            $pusher = new Pusher(
                '5e9b6b6e06917225ff96',
                'd8cc1d7275c3f3b46981',
                '825366',
                $options
            );

            $data['message'] = 'Enviado';
            $pusher->trigger('ch-notif', 'ev-notif', $data);

				$this->response(
					array(
						'err' => FALSE,
						'status' => 'success',
						'message' => 'Actualizado correctamente',
						'resp' => $role_data
					), REST_Controller::HTTP_OK);
			// }
		} 

	}

	public function roles_delete($id = NULL) {

		if($this->Roles_model->delete_role($id)) {
            $role = $this->Roles_model->search_role($id);

            $name = $role->name;

            $notif = array(
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'subject' => 'Un rol ha sido eliminado',
                'description' => "El rol $name ha sido eliminado correctamente.",
                'icon' => 'user-secret',
                'color' => 'red'
            );
            $this->Notifications_model->add_notification($notif);

            $options = array(
                'cluster' => 'us2',
                'useTLS' => true
            );
            $pusher = new Pusher(
                '5e9b6b6e06917225ff96',
                'd8cc1d7275c3f3b46981',
                '825366',
                $options
            );

            $data['message'] = 'Enviado';
            $pusher->trigger('ch-notif', 'ev-notif', $data);

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
					'message' => 'Error al eliminar el rol'
				), REST_Controller::HTTP_OK);
		}

	}

	public function roles_get($id = NULL) {
		if($id != NULL):
			$role = $this->Roles_model->get_role($id);

			if($role) {
				$this->response($role, REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Rol no existe'
					), REST_Controller::HTTP_OK);
			}
		else:
			$this->response($this->Roles_model->get_all(), REST_Controller::HTTP_OK);
		endif;
	}

	public function role($id) {
		echo json_encode($this->Roles_model->get_role($id));
	}

	// public function all_roles() {
	// 	echo json_encode($this->Roles_model->get_all());
	// }

}

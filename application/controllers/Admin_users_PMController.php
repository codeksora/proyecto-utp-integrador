<?php

use Pusher\Pusher;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_users_PMController extends REST_Controller {

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

		$this->load->model('Users_model');
        date_default_timezone_set('America/Lima');
  	}

	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/users/users_view', $data);
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/users/users_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/users/users_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/users/users_modal_view');
		}
	}

	public function users_post() {

		$user_data = $this->post();

		if(count($user_data) > 0):
			$this->form_validation->set_data($user_data);
			$this->form_validation->set_rules('full_name', '<strong>Nombre</strong>', 'required');
			$this->form_validation->set_rules('username', '<strong>Nombre de usuario</strong>', 'required|is_unique[users.username]',
				array('is_unique' => 'Este %s ya esta en uso')
			);
			$this->form_validation->set_rules('email', '<strong>Correo electrónico</strong>', 'required|valid_email');
			$this->form_validation->set_rules('role_id', '<strong>Rol</strong>', 'required');
			$this->form_validation->set_rules('extension', '<strong>Anexo</strong>', 'required');
			$this->form_validation->set_rules('job_title', '<strong>Cargo en la empresa</strong>', 'required');
			$this->form_validation->set_rules('password', '<strong>Contraseña</strong>', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
				$password = $this->post('password');
				$options = ['cost' => 12];
	  			$encripted_pass = password_hash($password, PASSWORD_BCRYPT, $options);

	  			$email = $this->post('email');
				$username = $this->post('username');
				$job_title = $this->post('job_title');
				$extension = $this->post('extension');

				$data['full_name'] = $this->post('full_name');
				$data['username'] = $username;
				$data['email'] = $email;
				$data['role_id'] = $this->post('role_id');
				$data['password'] = $encripted_pass;
				$data['status_id'] = 1;
				$data['job_title'] = $job_title;
				$data['extension'] = $extension;

				if($this->Users_model->add_user($data)) {
					$this->load->library('email');

					$subject = 'CUENTA NUEVA PERUSECURITY';
					$message = '<p>Buenos días<br><br>

					Se ha creado su cuenta en el sistema intranet de PERUSECURITY<br><br>
					
					La URL de ingreso es: <a href="https://sisps.perusecurity.pe">https://sisps.perusecurity.pe</a><br>
					Su usuario es: ' . $username . '<br>
					Su contraseña es: ' . $password . '
					<br><br>
					Si tiene alguna consulta, no dude en comunicarse con soporte2@perumedia.com.pe
					<br><br>
					Saludos</p>';	

					$to = $email;

					$result = $this->email
									->from('no-responder@perumedia.pe')
									->to($to)
									->subject($subject)
									->message($message)
									->send();

                    $notif = array(
                        'created_at' => date("Y-m-d H:i:s"),
                        'user_id' => $this->session->userdata('user_id'),
                        'subject' => 'Un usuario ha sido creado',
                        'description' => "El usuario $username ha sido creado correctamente.",
                        'icon' => 'users',
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
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Agregado correctamente'
						), REST_Controller::HTTP_OK);
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Error al agregar usuario'
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

	public function users_put($id = NULL) {
		
		$user_data = $this->put();
		$this->form_validation->set_data($user_data);
	
		$this->form_validation->set_rules('full_name', '<strong>Nombre</strong>', 'required');
		$this->form_validation->set_rules('username', '<strong>Nombre de usuario</strong>', 'required|edit_unique[users.username.'.$id.']',
			array('edit_unique' => 'Este %s ya esta en uso')
		);
		$this->form_validation->set_rules('email', '<strong>Correo electrónico</strong>', 'required|valid_email|edit_unique[users.email.'.$id.']',
			array('edit_unique' => 'Este %s ya esta en uso')
		);
		$this->form_validation->set_rules('extension', '<strong>Anexo</strong>', 'required');
		$this->form_validation->set_rules('job_title', '<strong>Cargo en la empresa</strong>', 'required');
		$this->form_validation->set_rules('role_id', '<strong>Rol</strong>', 'required');
	
		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
			$username = $this->put('username');
			$email = $this->put('email');
			$job_title = $this->put('job_title');
			$extension = $this->put('extension');

			if($this->put('password') != '') {
				$password = $this->put('password');

				$options = ['cost' => 12];
				$encripted_pass = password_hash($password, PASSWORD_BCRYPT, $options);

				$data['password'] = $encripted_pass;
				

				$this->load->library('email');

				$subject = 'CUENTA MODIFICADO PERUSECURITY';
				$message = '<p>Buenos días<br><br>

				Se ha modificado su cuenta en el sistema intranet de PERUSECURITY<br><br>
				
				La URL de ingreso es: <a href="https://sisps.perusecurity.pe">https://sisps.perusecurity.pe</a><br>
				Su usuario es: ' . $username . '<br>
				Su contraseña es: ' . $password . '
				<br><br>
				Si tiene alguna consulta, no dude en comunicarse con soporte2@perumedia.com.pe
				<br><br>
				Saludos</p>';	

				$to = $email;

				$result = $this->email
								->from('no-responder@perumedia.pe')
								->to($to)
								->subject($subject)
								->message($message)
								->send();
			}
			$data['full_name'] = $this->put('full_name');
			$data['username'] = $username;
			$data['email'] = $email;
			$data['role_id'] = $this->put('role_id');
			$data['job_title'] = $job_title;
			$data['extension'] = $extension;
			
			if($this->session->userdata('user_id') == $id) {
				$sess_user = array(
					'full_name' => $this->put('full_name'),
					'role' => $this->put('role_id'),
					'email' => $this->put('email')
				);
				$this->session->set_userdata($sess_user);
			}

			if($this->Users_model->update_user($data, $id)) {
                $notif = array(
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $this->session->userdata('user_id'),
                    'subject' => 'Un usuario ha sido editado',
                    'description' => "El usuario $username ha sido editado correctamente.",
                    'icon' => 'users',
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
	}

	public function users_delete($id = NULL) {
		if($this->Users_model->delete_user($id)) {

		    $user = $this->Users_model->search_user($id);

		    $username = $user->username;

            $notif = array(
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'subject' => 'Un usuario ha sido eliminado',
                'description' => "El usuario $username ha sido eliminado correctamente.",
                'icon' => 'users',
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
					'message' => 'Error al eliminar al usuario'
				), REST_Controller::HTTP_OK);
		}
	}

	public function users_get($user_id = NULL) {
		if(!isset($this->privileges) OR $this->privileges->read == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			if($user_id != NULL) {
				$user = $this->Users_model->get_user($user_id);
	
				if($user) {
					$this->response($user, REST_Controller::HTTP_OK);
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Acceso no permitido'
						), REST_Controller::HTTP_OK);
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
					'recordsTotal' => count($this->Users_model->get_all($start, $length)),
					'recordsFiltered' => count($this->Users_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
					'data' => $this->Users_model->get_all($start, $length, $order_column, $order_dir, $search_value)
				);
				$this->response($data, REST_Controller::HTTP_OK);
			}
		endif;
		
	}

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

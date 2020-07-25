<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_profile_PMController extends REST_Controller {
	
	private $url;
	private $privileges;

	public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect('pm-login');
		
        $this->load->model('Users_model');
        
    }
	
	public function index_get() {
		$data = array(
			'privileges' => $this->privileges
		);
		$this->load->view('admin/templates/profile/profile_view', $data);
	}

	public function user_get() {
		$id = $this->session->userdata('user_id');

		$this->response(
			$this->Users_model->get_user($id),
			REST_Controller::HTTP_OK);
	}

	public function user_put($id = NULL) {

		$user_data = $this->put();
		$this->form_validation->set_data($user_data);
		$this->form_validation->set_rules('full_name', '<strong>Nombre completo</strong>', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
			if($this->put('image')) {
				$image = $this->put('image');

				$data['image_id'] = $image['id'];
			}

			$id = $this->put('id');
			$full_name = $this->put('full_name');

			$data['full_name'] = $full_name;
	
			if($this->Users_model->update_user($data, $id)) {
				$id = $this->session->userdata('user_id');
				$user = $this->Users_model->get_user($id);

				$new_session = array(
					'full_name'  => $user->full_name,
					'image_profile' => $user->image_name
				);

				$this->session->set_userdata($new_session);

				$data_resp = array(
					'err' => false,
					'msg' => 'Guardado correctamente',
					'redirect_url' => site_url('admin/#!/profile')
				);
			} else {
				$data_resp = array(
					'err' => true,
					'msg' => 'Error al guardar los cambios'
				);
			}
    	}

		echo json_encode($data_resp);
	}

	public function update_pass() {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$request =  (array) $request;

		if($postdata) {
			$this->load->library('encryption');

			$id = $request["id"];
			$email = $request["email"];
			$user = $this->Users_model->find_by_email($email);
			
			$password = $this->encryption->decrypt($user->password);

			if(isset($request["old_password"]) && isset($request["new_password"]) && isset($request["new_password_2"])) {
				$old_password = $request["old_password"];
				$new_password = $request["new_password"];
				$new_password_2 = $request["new_password_2"];
				
				if($password == $old_password) {
					if($new_password == $new_password_2) {
						$data = array(
							'password' => $this->encryption->encrypt($new_password)
						);

						$this->Users_model->update_user($data, $id);

						$data_resp = array(
							'err' => false,
							'msg' => 'Su contraseña se ha cambiado correctamente',
							'redirect_url' => site_url('admin/#!/profile')
						);
					} else {
						$data_resp = array(
							'err' => true,
							'msg' => 'La contraseña nueva no es la misma que el campo "repetir nueva contraseña"',
						);
					}
				} else {
					$data_resp = array(
						'err' => true,
						'msg' => 'La contraseña ingresada no es la correcta',
					);
				}
			}

			
		} else {
			$data_resp = array(
				'err' => true,
				'msg' => 'Sin acceso'
			);
		}

		echo json_encode($data_resp);
	}

}

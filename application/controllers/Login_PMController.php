<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Login_PMController extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		
	}

	public function index_get() {
		if($this->session->userdata('logged_in') == TRUE) redirect('admin');
		$this->load->view('login/form_login_view');
	}

	public function remember_me_get() {
		$data = array(
			'username' => get_cookie('username'),
			'password' => get_cookie('password'),
			'remember_me' => (bool) get_cookie('remember_me')
		);
		$this->response(
			$data,
			REST_Controller::HTTP_OK);
	}

	public function auth_post() {
		if($this->session->userdata('logged_in') == TRUE) redirect('admin');
		$user_data = $this->post();
		$this->form_validation->set_data($user_data);

		$this->form_validation->set_rules('username', 'Nombre de usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
// 		$this->form_validation->set_rules('captcha', 'Captcha', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err'=>TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
			$this->load->model('Users_model');

			$username = $this->post('username');
			$password = $this->post('password');
// 			$recaptcha = $this->post('captcha');
			$remember_me = $this->post('remember_me');
			$expiration_time = time() + (10 * 365 * 24 * 60 * 60);
			
			set_cookie('username', '', $expiration_time);
			set_cookie('password', '', $expiration_time);
			set_cookie('remember_me', $remember_me, $expiration_time);


// 			$response = $this->recaptcha->verifyResponse($recaptcha);

// 			if(isset($response['success']) && $response['success'] === TRUE) {
				$user_id = $this->Users_model->loginUser($username, $password);
				
				if($user_id) {
					$user = $this->Users_model->get_user($user_id);

					$user_data = array(
						'user_id' => $user_id,
						'full_name' => $user->full_name,
						'email' => $user->email,
						'role_id' => $user->role_id,
						'image_profile' => $user->image_name ? $user->image_name : 'default.jpg',
						'role_name' => $user->role_name,
						'logged_in' => TRUE
					);

					$this->session->set_userdata($user_data);

					if($remember_me) { 
						set_cookie('username', $username, $expiration_time);
						set_cookie('password', $password, $expiration_time);
						set_cookie('remember_me', $remember_me, $expiration_time);
					}

					$this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Ingresando al administrador...'
						), REST_Controller::HTTP_OK);
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Usuario y/o contraseña incorrectos'
						), REST_Controller::HTTP_OK);
				}
// 			} else {
// 				$this->response(
// 					array(
// 						'err' => TRUE,
// 						'status' => 'error',
// 						'message' => 'Captcha inválido'
// 					), REST_Controller::HTTP_OK);
// 			}

			
    	}
	}

	public function logout_get() {
		if($this->session->userdata('logged_in') == TRUE) {
			$new_session = array(
		        'logged_in' => FALSE
			);

			$this->session->set_userdata($new_session);
		}

	}

	// public function forgot_password() {
	// 	$this->load->model('Users_model');
	// 	$this->load->helper('string');

	// 	$postdata = file_get_contents("php://input");
	// 	$request = json_decode($postdata);
	// 	$request =  (array) $request;

	// 	if($postdata) {

	// 		$email = $request['email'];

	// 		if($user = $this->Users_model->find_by_email($email)) {
	// 			$this->load->library('encryption');

	// 			$id = $user->user_id;

	// 			$random_pass = random_string('alnum', 16);

	// 			$data['status_password'] = 1;



	// 				$this->load->library("email");

	// 				$myemail   = "no-responder@perumedia.com.pe";
	// 				$url_token = $this->encryption->encrypt($email);
	// 				$content   = "Acceda a este link para cambiar su contraseña: " . anchor('pm-login/cambiar-contrasena/' . $url_token, 'Click aquí');

	// 				$this->email->from($myemail);
	// 				$this->email->to($email);

	// 				$this->email->subject('CWATCH.PERUSECURITY.PE');
	// 				$this->email->message($content);

	// 				/* Send the message using mail() function */
	// 				if($this->email->send()) {
	// 					$this->Users_model->update_user($data, $id);

	// 					$resp_data = array(
	// 						'err'     => true,
	// 						'code'	  => 200,
	// 						'message' => 'Su contraseña fue enviada a su correo. Revise por favor'
	// 					);

	// 				} else {
	// 					$resp_data = array(
	// 						'err'     => true,
	// 						'message' => 'Error al enviar el cambio de contraseña, o el correo es inválido'
	// 					);
	// 				}



	// 		} else {
	// 			$resp_data = array(
	// 				'err'     => true,
	// 				'message' => 'Este correo electrónico no existe'
	// 			);
	// 		}

	// 	} else {
	// 		$resp_data = array(
	// 			'err' => true,
	// 			'message' => 'Error al acceder'
	// 		);
	// 	}

	// 	echo json_encode($resp_data);
	// }

	// public function change_password($url_token) {
	// 	$this->load->model('Users_model');
	// 	$this->load->library('encryption');

	// 	$email = $this->encryption->decrypt($url_token);

	// 	if($user = $this->Users_model->find_by_email($email)) {
	// 		$status_password = $user->status_password;

	// 		if($status_password == 1) {
	// 			$data = array(
	// 				'url_token' => $url_token
	// 			);
	// 			$this->load->view('login/customer/change_password_view', $data);
	// 		} else {
	// 			show_404();
	// 		}
	// 	} else {
	// 		show_404();
	// 	}
	// }

	// public function save_new_pass() {

	// 	$this->load->model('Users_model');
	// 	$this->load->library('encryption');



	// 	$postdata = file_get_contents("php://input");
	// 	$request = json_decode($postdata);
	// 	$request =  (array) $request;

	// 	if($postdata) {
	// 		$url_token      = $request['url_token'];
	// 		$new_password   = $request['new_password'];
	// 		$new_password_2 = $request['new_password_2'];

	// 		if($new_password == $new_password_2) {
	// 			$email = $this->encryption->decrypt($url_token);

	// 			if($user = $this->Users_model->find_by_email($email)) {
	// 				$status_password = $user->status_password;

	// 				$id = $user->user_id;

	// 				$data = array(
	// 					'password' => $this->encryption->encrypt($new_password),
	// 					'status_password' => 0
	// 				);

	// 				if($status_password == 1) {
	// 					$this->Users_model->update_user($data, $id);

	// 					$resp_data = array(
	// 						'err' => false,
	// 						'code' => 200,
	// 						'message' => 'Su contraseña ha cambiado'
	// 					);
	// 				}
	// 			}
	// 		} else {
	// 			$resp_data = array(
	// 				'err' => true,
	// 				'code' => 300,
	// 				'message' => 'Las contraseñas no coinciden'
	// 			);
	// 		}


	// 	} else {
	// 		show_404();
	// 	}


	// 	echo json_encode($resp_data);
	// }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_ssl_cert_forms_PMController extends REST_Controller {

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

		$this->load->model('Ssl_cert_forms_model');

  	}

	public function ssl_cert_forms_get($ssl_cert_forms = NULL) {
		// if(!isset($this->privileges) OR $this->privileges->read == 0):
		// 	$this->response(array(
		// 			'err' => TRUE,
		// 			'status' => 'error',
		// 			'message' => 'Acceso no permitido'
		// 		), REST_Controller::HTTP_UNAUTHORIZED);
		// else:
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
					'recordsTotal' => count($this->Users_model->get_all($start, $length)),
					'recordsFiltered' => count($this->Users_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
					'data' => $this->Users_model->get_all($start, $length, $order_column, $order_dir, $search_value)
				);
				$this->response($data, REST_Controller::HTTP_OK);
			}
		// endif;
		
	}

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

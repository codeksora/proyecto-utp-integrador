<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_customer_certs_ssl_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Customer_certs_ssl_model');
    }

    public function customer_cert_ssl_get($customer_id) {
        $this->response(
            $this->Customer_certs_ssl_model->get_certs_ssl_by_customer($customer_id), 
            REST_Controller::HTTP_OK);
    }

	// public function index() {
  //       if($this->privileges->read == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$data = array(
	// 			'privileges' => $this->privileges
	// 		);
  //           $this->load->view('admin/templates/customers/customers_view', $data);
  //       }
  //   }
	//
  //   public function add_view() {
	// 	if($this->privileges->insert == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$this->load->view('admin/templates/customers/customers_add_view');
	// 	}
	// }
	//
	// public function edit_view() {
	// 	if($this->privileges->update == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$this->load->view('admin/templates/customers/customers_edit_view');
	// 	}
	// }

	public function add() {

		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);

		if($request) {
			$first_name = $request->first_name;
			$last_name  = $request->last_name;
			$country    = $request->country;
			$email      = $request->email;

			$createUser = $this->api_cwatch->createUser($email, $first_name, $last_name, $country);

			if($createUser) {
				$resp_data = array(
					'err' => false,
					'code' => $createUser->code,
					'msg' => "Agregado correctamente"
				);
			} else {
				$resp_data = array(
					'err' => true,
					'msg' => "Error al guardar datos " . $createUser->errorMsg
				);
			}

		} else {
			$resp_data = array(
				'err' => true,
				'msg' => "Error al acceder"
			);
		}

		echo json_encode($resp_data);
	}

	public function customers_get() {
		$this->response($this->Customers_model->get_all(), REST_Controller::HTTP_OK);
	}
	
	public function customer($id) {
		echo json_encode($this->Customers_model->get_customer($id));
	}

	public function customers_delete() {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$request =  (array) $request;

		if($postdata) {

			$id = $request["id"];

			$resp = $this->Users_model->delete_user($id);

			$data_resp = array(
				'err' => false,
				'msg' => 'Eliminado'
			);

			echo json_encode($data_resp);

		} else {
			show_404();
		}

	}

}

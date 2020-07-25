<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_PMController extends REST_Controller {

	public function __construct() {
		parent::__construct();

    $this->load->library('session');
		if($this->session->userdata('logged_in') == FALSE) redirect();

		$this->load->model('Backend_model');
		$this->all_privileges = $this->Backend_model->get_all_privileges($this->session->userdata('role_id'));

  }

  public function index_get() {
        $data = array(
			'privileges' => $this->all_privileges
		);

		$this->load->view('admin/main', $data);
	}

	public function configurations_get() {
		// $this->load->library('Api_sunat');

		// $tipo_cambio = $this->api_sunat->get_tipo_cambio();

		$data["application"] = "Sistema de Facturación";
		$data["year"] = "2019";
		$data["web"] = "https://perusecurity.pe";
		$data["company"] = "Perusecurity";
		$data["IGV"] = 0.18;
		$data['compra'] = 3.285;
		$data['venta'] = 3.290;

		$this->response($data);
	}

}

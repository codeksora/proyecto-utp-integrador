<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_configurations_PMController extends REST_Controller {

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

		$this->load->model('Configurations_model');

  	}

  	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/configurations/configurations_view', $data);
		}
	}

	public function configurations_get() {
		$this->load->library('Api_sunat');

		//$tipo_cambio = $this->api_sunat->get_tipo_cambio();
		// $tipo_cambio = $tipo_cambio->Cotizacion;
		$configurations = $this->Configurations_model->get_all();
		$data = array();
		foreach ($configurations as $config) {
			$data[$config->option] = $config->value;
			
			if($config->option == 'igv') $data['igv'] = (float) $config->value;
		//	if($config->option == 'buy') $data['buy'] = $tipo_cambio['compra'];
		//	if($config->option == 'sell') $data['sell'] = $tipo_cambio['venta'];
		}
		$this->response($data);
	}

	public function configurations_put() {

		$config_data = $this->put();

		foreach ($config_data as $key => $config) {
			$option = $key;
			$data['value'] = $config;
			$this->Configurations_model->update_config($data, $option);
		}

		$this->response(
			array(
				'err' => FALSE,
				'status' => 'success',
				'message' => 'Actualizado correctamente'
			), REST_Controller::HTTP_OK);
	}

}
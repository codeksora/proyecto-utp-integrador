<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_operating_system_types_PMController extends REST_Controller {

	private $url;
	private $privileges;

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Operating_system_types_model');
    }

    public function operating_system_types_get() {
        echo json_encode($this->Operating_system_types_model->get_all());
    }
}

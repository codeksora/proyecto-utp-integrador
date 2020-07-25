<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_order_types_PMController extends CI_Controller {

	private $url;
	private $privileges;

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect('pm-login');

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Order_types_model');
    }

    public function order_types() {
        echo json_encode($this->Order_types_model->get_all());
    }
}

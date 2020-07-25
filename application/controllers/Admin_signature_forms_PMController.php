<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_signature_forms_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

         $infomenu = $this->Backend_model->get_id($this->url);
         $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Signatures_assigned_model');
     	$this->load->model('Signature_forms_model');
        $this->load->library('api_forms_perusecurity');
        date_default_timezone_set('America/Lima');
    }

    public function signature_forms_get() {
        $signatures = $this->Signature_forms_model->get_singature_forms();

        $this->response(
            $signatures, 
            REST_Controller::HTTP_OK);
	}
	
	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

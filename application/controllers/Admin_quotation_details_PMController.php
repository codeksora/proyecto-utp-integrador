<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_quotation_details_PMController extends REST_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        //
        // $this->load->model('Backend_model');
        // $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);
        //
        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Order_details_model');
        $this->load->library('form_validation');
    }

    public function order_details_get($order_id) {
        $this->response(
            $this->Order_details_model->get_order_details_by_order($order_id),
            REST_Controller::HTTP_OK);
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_product_price_types_PMController extends REST_Controller {

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

        $this->load->model('Product_price_types_model');
    }

    public function product_price_types_get() {
        $this->response(
            $this->Product_price_types_model->get_all(),
            REST_Controller::HTTP_OK);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_quotation_product_details_PMController extends REST_Controller {
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

    $this->load->model('Quotation_product_details_model');
    $this->load->library('form_validation');
  }

  public function quotation_product_details_get($quotation_product_detail_id) {
        $this->response(
          $this->Quotation_product_details_model->get_quotation_product_detail($quotation_product_detail_id), 
          REST_Controller::HTTP_OK);
  }

  public function order_product_details_get($order_product_detail_id) {
        $this->response(
          $this->Quotation_product_details_model->get_order_product_detail($order_product_detail_id), 
          REST_Controller::HTTP_OK);
  }

  public function quotation_product_details_by_order_get($quotation_id) {
        $this->response(
          $this->Quotation_product_details_model->get_product_details_by_quotation($quotation_id), 
          REST_Controller::HTTP_OK);
  }

  public function quotation_product_details_separate_get($quotation_id) {
        $this->response(
          $this->Quotation_product_details_model->get_product_details_by_quotation_separate($quotation_id), 
          REST_Controller::HTTP_OK);
  }

  public function order_product_details_separate_get($order_id) {
        $this->response(
          $this->Quotation_product_details_model->get_product_details_by_order_separate($order_id), 
          REST_Controller::HTTP_OK);
  }
  
  public function order_product_type_get($order_product_details_id) {
    $this->response(
      $this->Order_product_details_model->get_product_type_by_id($order_product_details_id), 
      REST_Controller::HTTP_OK);
  }
}

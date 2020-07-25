<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_firms_assigned_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Firm_certs_model');
    }

    public function firms_assigned_get($firm_assigned_id = NULL) { 
        if(!isset($this->privileges->read) OR $this->privileges->read == 0):
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Acceso no permitido'
                ), REST_Controller::HTTP_UNAUTHORIZED);
        else: 
            if($firm_assigned_id != NULL) {
                $ssl_cert_assigned = $this->Ssl_certs_assigned_model->get_ssl_cert_assigned($firm_assigned_id);

                if($ssl_cert_assigned) {
                    $this->response($ssl_cert_assigned, REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
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

                $ssl_certificate_status_s = $this->get('ssl_certificate_status_s');
    
                $data = array(
                    'draw' => $draw,
                    'recordsTotal' => count($this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, $start, $length)),
                    'recordsFiltered' => count($this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, NULL, NULL, $order_column, $order_dir, $search_value)),
                    'data' => $this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, $start, $length, $order_column, $order_dir, $search_value)
                );
                $this->response($data, REST_Controller::HTTP_OK);
            }
        endif;
    }

}

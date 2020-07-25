<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_sunat_PMController
 *
 * @package     Sunat
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_sunat_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $this->load->model("Customers_model");
    }

    public function search_get($ruc = NULL) { 
        if($ruc != NULL):
            if($this->Customers_model->search_customer_by_ruc($ruc)) { // SI EXISTE EL CLIENTE
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Cliente ya existe'
                    ), REST_Controller::HTTP_OK);		
            } else {
                $company = new \Sunat\Sunat( true, true );
                
                // $dni = "44274795";

                $search = $company->search($ruc);
                // $search2 = $company->search( $dni );

                if($search->success == true) {
                    $data = array(
                        'err' => FALSE,
                        'status' => 'success',
                        'message' => 'RUC válido',
                        'name' => $search->result->razon_social,
                        'address' => $search->result->direccion
                    );
                    $this->response($data, self::HTTP_OK);
                } else {
                    $data = array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => $search->message
                    );
                }
            }
        else:
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Acceso no permitido'
                ), REST_Controller::HTTP_OK);
		endif;
	}

    public function search_edit_get($ruc = NULL) {
        if($ruc != NULL):
                $company = new \Sunat\Sunat( true, true );

                // $dni = "44274795";

                $search = $company->search($ruc);
                // $search2 = $company->search( $dni );

                if($search->success == true) {
                    $data = array(
                        'err' => FALSE,
                        'status' => 'success',
                        'message' => 'RUC válido',
                        'name' => $search->result->razon_social,
                        'address' => $search->result->direccion
                    );
                    $this->response($data, self::HTTP_OK);
                } else {
                    $data = array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => $search->message
                    );
                }
        else:
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Acceso no permitido'
                ), REST_Controller::HTTP_OK);
        endif;
    }

}
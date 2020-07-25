<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_products_PMController
 *
 * @package     Países
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_additional_sans_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Additional_sans_model');
    }

    public function additional_sans_get($ssl_certificate_assigned_id) {
        $this->response(
            $this->Additional_sans_model->get_additional_sans_by_ssl_certificates_assigned($ssl_certificate_assigned_id),
            REST_Controller::HTTP_OK);
    }

    // public function countries_get($id = NULL) {
    //     if($id != NULL):
	// 		$product = $this->Countries_model->get_all($id);

	// 		if($product) {
	// 			$this->response($product, REST_Controller::HTTP_OK);
	// 		} else {
	// 			$this->response(
	// 				array(
	// 					'err' => TRUE,
	// 					'status' => 'error',
	// 					'message' => 'Producto no existe'
	// 				), REST_Controller::HTTP_OK);
	// 		}
	// 	else:
	// 		$this->response($this->Countries_model->get_all(), REST_Controller::HTTP_OK);
	// 	endif;
	// }

}
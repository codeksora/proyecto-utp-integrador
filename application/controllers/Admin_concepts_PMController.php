<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_products_PMController
 *
 * @package     Código de teléfono
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_concepts_PMController extends REST_Controller {
	
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

		$this->load->model('Concepts_model');
		$this->load->library('form_validation');

        date_default_timezone_set('America/Lima');
        
    }

	public function concepts_get($id = NULL) {
		// if($id != NULL):
		// 	$product = $this->Products_model->get_product($id);

		// 	if($product) {
		// 		$this->response($product, REST_Controller::HTTP_OK);
		// 	} else {
		// 		$this->response(
		// 			array(
		// 				'err' => TRUE,
		// 				'status' => 'error',
		// 				'message' => 'Producto no existe'
		// 			), REST_Controller::HTTP_OK);
		// 	}
		// else:
			$this->response($this->Concepts_model->get_all(), REST_Controller::HTTP_OK);
		// endif;
	}


}

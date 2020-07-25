<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_products_PMController
 * 
 * Permite gestionar los contactos, agregar, editar o eliminar.
 *
 * @package     Contactos
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_order_products_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Contacts_model');
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->library('form_validation');
		$this->load->model('Order_products_model');
		date_default_timezone_set('America/Lima');
	}

	public function order_product_by_order_dt_get($order_id) {
		$this->Order_products_model->get_all_by_order_dt($order_id);
		$this->response(
			$this->Order_products_model->get_all_by_order_dt($order_id), 
			REST_Controller::HTTP_OK);
	}
}
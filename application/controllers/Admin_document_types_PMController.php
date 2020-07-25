<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_document_types_PMController
 *
 * @package     Tipos de documento
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_document_types_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Document_types_model');
    }

    public function document_types_get() {
        $this->response($this->Document_types_model->get_all(), REST_Controller::HTTP_OK);
	}

}
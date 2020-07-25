<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_quotations_PMController
 * 
 * Permite gestionar las cotizaciones, agregar, editar o eliminar.
 *
 * @package     Cotizaciones
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_quotations_approve_PMController extends REST_Controller {

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
		$this->load->model('Quotations_model');

		date_default_timezone_set('America/Lima');
	}

	public function index_get() {
		if(!isset($this->privileges) OR !isset($this->privileges->read) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations_approve/quotations_approve_view');
		}
	}

	public function quotations_approve_dt_get() {
  //       if($id != NULL):
  //           if($this->Orders_model->get_order($id)) {
  //               $this->response($this->Orders_model->get_order($id), REST_Controller::HTTP_OK);
  //           } else {
  //               $this->response(
  //                   array(
  //                       'err' => TRUE,
  //                       'status' => 'error',
  //                       'message' => 'Esta orden no existe'
  //                   ), REST_Controller::HTTP_OK);
  //           }
		// else:
			$start = $this->get('start');
			$length = $this->get('length');
			$draw = $this->get('draw');
			$order = $this->get('order');
			$order_column = (int) $order[0]['column'] + 1;
			$order_dir = $order[0]["dir"];
			$search = $this->get("search");
			$search_value = $search["value"];

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Quotations_model->get_all_to_approve_dt($start, $length)),
				'recordsFiltered' => count($this->Quotations_model->get_all_to_approve_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Quotations_model->get_all_to_approve_dt($start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
        // endif;
	}

	public function quotations_approve_put($quotation_id = NULL) {
		if($this->Quotations_model->approve_quotation($quotation_id)) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Aprobado correctamente'
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al aprobar la cotización'
				), REST_Controller::HTTP_OK);
		}
	}

	public function quotations_approve_all_put() {
		if($this->Quotations_model->approve_all_quotation()) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Aprobado correctamente'
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al aprobar las cotizaciones'
				), REST_Controller::HTTP_OK);
		}
	}

	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}
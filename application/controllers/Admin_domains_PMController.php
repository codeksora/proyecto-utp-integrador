<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_domains_PMController
 *
 * @package     Dominios
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_domains_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Domains_model');
        date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/domains/domains_view');
		}
    }

    public function modal_add_view_get() {
  //       if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
		// 	$this->load->view('admin/templates/errors/not_privilege');
		// } else {
			$this->load->view('admin/templates/domains/domains_modal_add_view');
		// }
    }

    public function modal_assign_customer_view_get() {
  //       if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
		// 	$this->load->view('admin/templates/errors/not_privilege');
		// } else {
			$this->load->view('admin/templates/domains/domains_modal_assign_customer_view');
		// }
    }

    public function domains_get() {
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
            'recordsTotal' => count($this->Domains_model->get_all($start, $length)),
            'recordsFiltered' => count($this->Domains_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
            'data' => $this->Domains_model->get_all($start, $length, $order_column, $order_dir, $search_value)
        );
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function domains_post() {
        if(!isset($this->privileges->insert) OR $this->privileges->insert == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else:
            $domain_data = $this->post();

            if(count($domain_data) > 0):
                $this->form_validation->set_data($domain_data);
                $this->form_validation->set_rules('common_name', '<strong>Common name</strong>', 'required|is_unique[domains.common_name]', 
                    array('is_unique' => 'Este <strong>common name</strong> ya existe')
                );

                if ($this->form_validation->run() == FALSE) {
                    $this->response(
                        array(
                            'err' => TRUE,
                            'status' => 'error',
                            'message' => validation_errors()
                        ), REST_Controller::HTTP_OK);
                } else {
                    $data['common_name'] = $this->post('common_name');
                    $data['status_id'] = 1;
                    $data['user_id'] = $this->session->userdata('user_id');
                    $data['created_at'] = date("Y-m-d H:i:s");
                    $data['updated_at'] = date("Y-m-d H:i:s");

                    if($this->Domains_model->add_domain($data)) {
                        $this->response(
                            array(
                                'err' => FALSE,
                                'status' => 'success',
                                'message' => 'Agregado correctamente'
                            ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(
                            array(
                                'err' => TRUE,
                                'status' => 'error',
                                'message' => 'Error al agregar usuario'
                            ), REST_Controller::HTTP_OK);
                    }
                }                
            else:
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Todos los campos son requeridos'
                    ), REST_Controller::HTTP_OK);
            endif;
        endif;
    }

    public function domains_customers_get($domain_id) {
        $this->response(
            $this->Domains_model->get_customers_by_domain($domain_id),
            REST_Controller::HTTP_OK
        );
    }

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}
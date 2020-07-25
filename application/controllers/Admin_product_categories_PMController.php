<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_product_categories_PMController extends REST_Controller {

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

        $this->load->model('Product_categories_model');
    }

    public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/product_categories/product_categories_view');
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/product_categories/product_categories_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/product_categories/product_categories_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/product_categories/product_categories_modal_view');
		}
	}

    public function product_categories_get($product_category_id = NULL) {
        if(!isset($this->privileges) OR $this->privileges->read == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			if($product_category_id != NULL) {
				$product_category = $this->Product_categories_model->get_product_category($product_category_id);

				if($product_category) {
					$this->response($product_category, REST_Controller::HTTP_OK);
				} else {
					$this->response(array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Acceso no permitido'
						), REST_Controller::HTTP_UNAUTHORIZED);
				}
			} else {
            $this->response(
                $this->Product_categories_model->get_all(), 
                REST_Controller::HTTP_OK);
            }
        endif;
        
    }

    public function product_categories_dt_get($id = NULL) {
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
			'recordsTotal' => count($this->Product_categories_model->get_all_dt($start, $length)),
			'recordsFiltered' => count($this->Product_categories_model->get_all_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
			'data' => $this->Product_categories_model->get_all_dt($start, $length, $order_column, $order_dir, $search_value)
		);
		$this->response($data, REST_Controller::HTTP_OK);
    }
    
    public function product_categories_post() {
        $product_category_data = $this->post();

		if(count($product_category_data) > 0):
			$this->form_validation->set_data($product_category_data);
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			$this->form_validation->set_rules('technical_specifications', 'Especificaciones técnicas', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
                $name = $this->post('name');
                $technical_specifications = $this->post('technical_specifications');
				$data['name'] = $name;
				$data['technical_specifications'] = $technical_specifications;
				// $data['status_id'] = 1;
                // $data['user_id'] = $this->session->userdata('user_id');
				// $data['created_at'] = date("Y-m-d H:i:s");
				// $data['updated_at'] = date("Y-m-d H:i:s");

				if($this->Product_categories_model->add_product_category($data)) {
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
							'message' => 'Error al agregar la categoría'
						), REST_Controller::HTTP_OK);
				}
			}
		else:
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Todos los campos son requeridos',
				), REST_Controller::HTTP_OK);
		endif;
    }

    public function product_categories_put($product_category_id = NULL) {
		$product_category_data = $this->put();

		if(count($product_category_data) > 0):
			$this->form_validation->set_data($product_category_data);
			$this->form_validation->set_rules('name', 'Nombre', 'required');
			$this->form_validation->set_rules('technical_specifications', 'Especificaciones técnicas', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
                $name = $this->put('name');
                $technical_specifications = $this->put('technical_specifications');
				$data['name'] = $name;
				$data['technical_specifications'] = $technical_specifications;

				if($this->Product_categories_model->update_product_category($data, $product_category_id)) {
					$this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Actualizado correctamente'
						), REST_Controller::HTTP_OK);
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => 'Error al editar la categoría'
						), REST_Controller::HTTP_OK);
				}
			}
		else:
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Todos los campos son requeridos',
				), REST_Controller::HTTP_OK);
		endif;
	}

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}
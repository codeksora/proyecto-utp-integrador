<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_order_obs_PMController extends REST_Controller {
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

		$this->load->model('Order_obs_model');
		$this->load->library('form_validation');
  }

  public function order_obs_get($order_id) {
      $this->response(
          $this->Order_obs_model->get_order_observations($order_id),
          REST_Controller::HTTP_OK);
  }

  public function order_obs_post() {
		$obs_data = $this->post();
		$comment_data = $this->post('user');

		if(count($comment_data) > 0):
			$this->form_validation->set_data($comment_data);
			$this->form_validation->set_rules('message', '<strong>Comentario</strong>', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors(),
					), REST_Controller::HTTP_OK);
			} else {
				date_default_timezone_set('America/Lima');
				$order = $this->post('order');
				$user = $this->post('user');

				$data['message'] = $user['message'];
				$data['cod_orden'] = $order['order']['id'];
				$data['user_id'] = $this->session->userdata('user_id');
				$data['created_at'] = date('Y-m-d H:i:s');

				if($this->Orders_obs_model->add_obs($data)) {
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
							'message' => 'Error al agregar el comentario'
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
	}
}

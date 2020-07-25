<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_comments_ssl_certs_assigned_PMController extends REST_Controller {

	private $url;
	private $privileges;

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

//         $this->load->model('Backend_model');
//         $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

//         $infomenu = $this->Backend_model->get_id($this->url);
//         $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Comments_ssl_certs_assigned_model');
		date_default_timezone_set('America/Lima');
    }
  
  public function comments_ssl_certs_assigned_get($ssl_cert_assigned_id) {
    
        $this->response(
          $this->Comments_ssl_certs_assigned_model->get_all_by_ssl_certificate_assigned_id($ssl_cert_assigned_id), 
                        REST_Controller::HTTP_OK);
  }
  
  public function comments_ssl_certs_assigned_post() {
        $data_comment = $this->post('comment');

        if(count($data_comment) > 0):
            $this->form_validation->set_data($data_comment);
            $this->form_validation->set_rules('message', '<strong>Mensaje</strong>', 'required');

            if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
          $ssl_cert_assigned_id = $this->post('ssl_cert_assigned_id');
              $comment_message = $data_comment['message'];
              
              $comment = array(
                'user_id' => $this->session->userdata('user_id'),
                'ssl_certificate_assigned_id' => $ssl_cert_assigned_id,
                'message' => $comment_message,
                'created_at' => date("Y-m-d H:i:s")
              ); 

                if($this->Comments_ssl_certs_assigned_model->add_comment_ssl_cert_assigned($comment)) {
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
                            'message' => 'Error al agregar el mensaje, intente de nuevo'
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
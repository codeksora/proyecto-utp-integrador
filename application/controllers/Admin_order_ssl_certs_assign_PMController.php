<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_order_ssl_certs_assign_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Order_ssl_certs_assign_model');
    }

    public function order_ssl_certs_get($order_id) {
        $this->response(
            $this->Order_ssl_certs_assign_model->get_ssl_certs_by_order($order_id),
            REST_Controller::HTTP_OK);
    }

    public function order_ssl_certs_post($order_id) {
        $cert_id = $this->post('cert_id');
        $product_id = $this->post('product_id');

	    $data['idorden'] = $order_id;
        $data['idcertSSL'] = $cert_id;
        $data['estado_certSSL'] = 'Pendiente';
        $data['idproducto'] = $product_id;
        $data['id_tecnico'] = $this->session->userdata('user_id');

        $this->Order_ssl_certs_assign_model->add_ssl_cert($data);

        $this->response(
            array(
                'err' => FALSE,
                'status' => 'success',
                'message' => 'Asignado correctamente'
            ), REST_Controller::HTTP_OK);
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_invoices_PMController extends REST_Controller {

    private $url;
    private $privileges;
    private $api_key;
    private $api_url;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->library('curl');
        $this->load->library('api_perusecurity');
        $this->load->model('Invoices_model');
        $this->load->helper('file');
    }

    public function index_get() {
        if(!isset($this->privileges) || $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );
            $this->load->view('admin/templates/invoices/invoices_view', $data);
        }
    }

    public function add_view_get() {
        if(!isset($this->privileges) OR $this->privileges->insert == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $this->load->view('admin/templates/invoices/invoices_add_view');
        }
    }

    public function modal_add_product_view_get() {
        if(!isset($this->privileges) OR $this->privileges->insert == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $this->load->view('admin/templates/invoices/invoices_modal_add_product_view');
        }
    }

    public function invoices_get() {
        $invoices = $this->api_perusecurity->get_invoices();

        $this->response(
            $invoices,
            REST_Controller::HTTP_OK);
    }

    //FUNCIÓN PARA AGREGAR FACTURA
    public function invoices_post() {
        // $data_resp = "Num doc: 1100111\n";
        // $data_resp .= "RUC: 56565656";
        // //CREACIÓN DE ARCHIVO TXT PARA "ACEPTA.COM"
        // // if ( ! write_file('./docs_invoice/FE-110011101.txt', $data_resp)) {
        // //         echo 'Unable to write the file';
        // // } else {
        // //         echo 'File written!';
        // // }

        // //LEER ARCHIVO 
        // // read_file('./docs_invoice/FE-110011101.txt');

        


        // $data = array(
        //     //'resp' => read_file('./docs_invoice/FE-110011101.txt'),
        //     'resp' => $this->post(),
        //     'status' => 'success',
        //     'message' => 'Factura emitida correctamente'
        // );

        // $this->response($data, self::HTTP_OK);
        $invoice_data = $this->post();

        if(count($invoice_data) > 0):
            $this->form_validation->set_data($invoice_data);
            $this->form_validation->set_rules('referral_guide', '<strong>Guía de remisión</strong>', 'required');
            $this->form_validation->set_rules('order_id', '<strong>Número de orden</strong>', 'required');
            $this->form_validation->set_rules('observation', '<strong>Observación</strong>', 'required');
            $this->form_validation->set_rules('external_invoice_number', '<strong>Nº de Factura</strong>', 'required');

            if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {

                $referral_guide  = $this->post('referral_guide');
                $order_id  = $this->post('order_id');
                $observation  = $this->post('observation');
                $created_at = date("Y-m-d H:i:s");
                $user_id = $this->session->userdata('user_id');
                $credit_time_id = $this->post('credit_time_id');
                $issue_date = date("Y-m-d H:i:s", strtotime($this->post('issue_date')));
                $external_invoice_number = $this->post('external_invoice_number');;
                // $invoice_number = '';
                
                $this->load->model('Credit_times_model');
                $credit_time = $this->Credit_times_model->get_credit_time($credit_time_id);
                $credit_time_quantity = $credit_time->quantity;

                $expiration_date = strtotime ("+$credit_time_quantity day", strtotime($this->post('issue_date')));
                $expiration_date = date ("Y-m-d H:i:s", $expiration_date );

                $data = array();
                $data['referral_guide'] = $referral_guide;
                $data['order_id'] = $order_id;
                $data['observation'] = $observation;
                $data['created_at'] = $created_at;
                $data['expiration_date'] = $expiration_date;
                $data['external_invoice_number'] = $external_invoice_number;
                $data['credit_time_id'] = $credit_time_id;
                $data['user_id'] = $user_id;
                $date['issue_date'] = $issue_date;
                
                if($this->Invoices_model->add_invoice($data)) {
                    $this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
                            'message' => 'Agregado correctamente',
                            're' => $expiration_date
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
    }

    public function info_sunat_post() {
        $company = new \Sunat\Sunat( true, true );

        $ruc = $this->post('document_number');
        $dni = "44274795";

        $search1 = $company->search( $ruc );
        $search2 = $company->search( $dni );

        if( $search1->success == true ) {
            $data = array(
                'name' => $search1->result->razon_social,
                'address' => $search1->result->direccion
            );
            $this->response($data, self::HTTP_OK);
        }

//        $document_number = $this->post('document_number');
//        echo "hola " . $document_number;

    }

}

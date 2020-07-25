<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_signatures_assigned_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Signatures_assigned_model');
        $this->load->model('Signature_forms_model');
        $this->load->model('Quotation_product_details_model');
    }

    public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/signatures_assigned/signatures_assigned_view', $data);
		}
    }

    public function modal_view_get() {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/signatures_assigned/signatures_assigned_modal_view', $data);
        }
    }

    public function modal_assign_contacts_view_get() {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/signatures_assigned/signatures_assigned_modal_assign_contacts_view', $data);
        }
    }
    
    public function signatures_assigned_get($signature_assigned_id = NULL) {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0):
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else: 
            if($signature_assigned_id != NULL) {
                $signature_assigned = $this->Signatures_assigned_model->get_signature_assigned($signature_assigned_id);

                if($signature_assigned) {
                    $this->response($signature_assigned, REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                            'err' => TRUE,
                            'status' => 'error',
                            'message' => 'Acceso no permitido'
                        ), REST_Controller::HTTP_UNAUTHORIZED);
                }
            } else {
                $start = $this->get('start');
                $length = $this->get('length');
                $draw = $this->get('draw');
                $order = $this->get('order');
                $order_column = (int) $order[0]['column'] + 1;
                $order_dir = $order[0]["dir"];
                $search = $this->get("search");
                $search_value = $search["value"];

                $signature_status_s = $this->get('signature_status_s');

                $data = array(
                    'draw' => $draw,
                    'recordsTotal' => count($this->Signatures_assigned_model->get_all($signature_status_s, $start, $length)),
                    'recordsFiltered' => count($this->Signatures_assigned_model->get_all($signature_status_s, NULL, NULL, $order_column, $order_dir, $search_value)),
                    'data' => $this->Signatures_assigned_model->get_all($signature_status_s, $start, $length, $order_column, $order_dir, $search_value)
                );
                $this->response($data, REST_Controller::HTTP_OK);
            }
        endif;
    }

    public function send_to_install_put($signature_assigned_id = NULL) {
        $expiration_date = date("Y-m-d H:i:s", strtotime($this->put('expiration_date')));
        $issue_date = date("Y-m-d H:i:s", strtotime($this->put('issue_date')));
        $installation_date = date("Y-m-d H:i:s", strtotime($this->put('installation_date')));
        $enroll_code = $this->put('enroll_code');
        
        $data['signature_status_id'] = 2;
        $data['issue_date'] = $issue_date;
        $data['expiration_date'] = $expiration_date;
        $data['installation_date'] = $installation_date;
        $data['enroll_code'] = $enroll_code;
        $data['enroll_date'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['user_id'] = $this->session->userdata('user_id');

        $upd_signature = $this->Signatures_assigned_model->update_signature_assigned($data, $signature_assigned_id);

        if($upd_signature) {
            $this->response(
                array(
                    'err' => FALSE,
                    'status' => 'success',
                    'message' => 'Instalado correctamente'
                ), REST_Controller::HTTP_OK); 
        } else {
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Error al guardar la información'
                ), REST_Controller::HTTP_OK); 
        }
        
    }

    public function order_signatures_assigned_get($order_id) {
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
            'recordsTotal' => count($this->Signatures_assigned_model->get_signatures_assigned_by_order($order_id, $start, $length)),
            'recordsFiltered' => count($this->Signatures_assigned_model->get_signatures_assigned_by_order($order_id, NULL, NULL, $order_column, $order_dir, $search_value)),
            'data' => $this->Signatures_assigned_model->get_signatures_assigned_by_order($order_id, $start, $length, $order_column, $order_dir, $search_value)
        );
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function signatures_assigned_post() {
        $signature_assigned_data = $this->post();

        if(count($signature_assigned_data) > 0):
            $this->form_validation->set_data($signature_assigned_data);
            $this->form_validation->set_rules('idpersonal', 'Firma', 'required', 
                array('required' => 'Debe seleccionar una cuenta')
            );
        //  $this->form_validation->set_rules('last_name', 'Apellido', 'required');
        //  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        //  $this->form_validation->set_rules('phone_code_id', 'Código de país', 'required|integer');
        //  $this->form_validation->set_rules('phone', 'Teléfono', 'required|numeric');
        //  $this->form_validation->set_rules('mobile_phone', 'Celular', 'required|numeric');
        //  $this->form_validation->set_rules('extension', 'Anexo', 'numeric');
        //  $this->form_validation->set_rules('country_id', 'País', 'required|integer');
        //  $this->form_validation->set_rules('state', 'Estado', 'required');
        //  $this->form_validation->set_rules('city', 'Ciudad', 'required');
        //  $this->form_validation->set_rules('address_line_1', 'Dirección 1', 'required');
        //  $this->form_validation->set_rules('address_line_2', 'Dirección 2', 'required');
        //  $this->form_validation->set_rules('customer_id', 'Empresa', 'required|integer');
        //  $this->form_validation->set_rules('job_title', 'Cargo', 'required');
        //  $this->form_validation->set_rules('contact_type_id', 'Tipo de contacto', 'required|integer');

            if ($this->form_validation->run() == FALSE) { // SI NO SE VALIDARON LOS VALORES ENVIADOS
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => validation_errors()
                    ), REST_Controller::HTTP_OK);
            } else { // SI SE APROBARON LOS VALORES ENVIADOS

                $idpersonal = $this->post('idpersonal'); // ID DEL FORMULARIO SELECCIONADO

                $quotation_product_detail_id = $this->post('quotation_product_detail_id'); // ID DEL PRODUCTO A SER ASIGNADO

                $data['quotation_product_detail_id'] = $quotation_product_detail_id;
                $data['signature_form_id'] = $idpersonal;
                $data['signature_status_id'] = 1;
                $data['user_id'] = $this->session->userdata('user_id');
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");

                if($this->Signatures_assigned_model->add_signature_assigned($data)) {
                    $data_signature_form['persestadouser'] = 'Asignado';

                    // ACTUALIZA EN LA TABLA DEL FORMULARIO CAMBIANDO SU VALOR A "ASIGNADO" DEL FORMULARIO
                    $this->Signature_forms_model->update_signature_form($data_signature_form, $idpersonal);

                    $quotation_product_detail['status_id'] = 2;
                    // ACTUALIZA SU VALOR DEL PRODUCTO, TOMANDOLO COMO ASIGNADO
                    $this->Quotation_product_details_model->update_quotation_product_detail($quotation_product_detail, $quotation_product_detail_id);

                    $this->response(
                        array(
                            'err' => FALSE,
                            'status' => 'success',
                            'message' => 'Asignado correctamente'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(
                        array(
                            'err' => TRUE,
                            'status' => 'error',
                            'message' => 'Error al asignar'
                        ), REST_Controller::HTTP_OK);
                }
            }
        else:
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Todos los campos son requeridos',
                    'resp' => $this->post()
                ), REST_Controller::HTTP_OK);
        endif;
    }

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

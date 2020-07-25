<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_ssl_certs_validate_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

         $infomenu = $this->Backend_model->get_id($this->url);
         $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Ssl_certs_assigned_model');
     	$this->load->model('Ssl_cert_forms_model');
        $this->load->library('api_forms_perusecurity');
        date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        if(!isset($this->privileges->read) || $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/ssl_certificates_validate/ssl_certificates_validate_view', $data);
        }
	}
	
	public function edit_view_get() {
		if(!isset($this->privileges->update) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/ssl_certificates_validate/ssl_certificates_validate_edit_view');
		}
	}

	// public function modal_add_view_get() {
	// 	if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_add_view');
	// 	}
	// }

	// public function modal_assign_domain_to_customer_view_get() {
	// 	if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
	// 		$this->load->view('admin/templates/errors/not_privilege');
	// 	} else {
	// 		$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_assign_domain_to_customer_view');
	// 	}
	// }

    public function ssl_certs_validate_get($ssl_certificate_id = NULL) {
        if($ssl_certificate_id != NULL):
            $ssl_cert = $this->api_forms_perusecurity->get_ssl_cert($ssl_certificate_id);
            
            $this->response(
                $ssl_cert, 
                REST_Controller::HTTP_OK);
        else:
            $data['start'] = $this->get('start');
            $data['length'] = $this->get('length');
            $data['draw'] = $this->get('draw');
            $data['order'] = $this->get('order');
            $data['search'] = $this->get("search");

            $ssl_certs = $this->api_forms_perusecurity->get_ssl_certs($data);

            $this->response(
                $ssl_certs, 
                REST_Controller::HTTP_OK);
        endif;

        

		// if($order_id != NULL):
		// 	$ssl_certs = $this->Ssl_certs_model->get_ssl_certs_by_order($order_id);

		// 	if($ssl_certs) {
		// 		$this->response($ssl_certs, REST_Controller::HTTP_OK);
		// 	} else {
		// 		$this->response(
		// 			array(
		// 				'err' => TRUE,
		// 				'status' => 'error',
		// 				'message' => 'Producto no existe'
		// 			), REST_Controller::HTTP_OK);
		// 	}
		// else:
		// 	$start = $this->get('start');
		// 	$length = $this->get('length');
		// 	$draw = $this->get('draw');
		// 	$order = $this->get('order');
		// 	$order_column = (int) $order[0]['column'] + 1;
		// 	$order_dir = $order[0]["dir"];
		// 	$search = $this->get("search");
		// 	$search_value = $search["value"];
		// 	// $provider_s = $this->get('provider_s');
		// 	// $product_type_s = $this->get('product_type_s');
		// 	// $startRec_s = $this->get('startRec_s');
		// 	// $endRec = $this->get('endRec');

		// 	$data = array(
		// 		'draw' => $draw,
		// 		'recordsTotal' => count($this->Ssl_certs_model->get_all($start, $length)),
		// 		'recordsFiltered' => count($this->Ssl_certs_model->get_all(NULL, NULL, $order_column, $order_dir, $search_value)),
		// 		'data' => $this->Ssl_certs_model->get_all($start, $length, $order_column, $order_dir, $search_value)
		// 	);
		// 	$this->response($data, REST_Controller::HTTP_OK);
		// endif;
	}

    public function ssl_certs_validate_put() {
		if(!isset($this->privileges->update) OR $this->privileges->update == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else:
			$ssl_cert = $this->put();

			if(count($ssl_cert) > 0):
				$this->form_validation->set_data($ssl_cert);
			
				$this->form_validation->set_rules('ssl_certificates_assigned_id', '', 'required', 
					array('required' => 'Debe asignarle algún producto registrado'));

				if ($this->form_validation->run() == FALSE) {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => validation_errors()
						), REST_Controller::HTTP_OK);
				} else {
					$data['producto'] = $this->put('producto');
					$data['accion'] = $this->put('accion');
					$data['periodo'] = $this->put('periodo');
					$data['cantservidor'] = $this->put('cantservidor');
					$data['Desc_csr'] = $this->put('Desc_csr');
					$data['San_CSR'] = $this->put('San_CSR');
					$data['CommonName_CSR'] = $this->put('CommonName_CSR');
					$data['UnidadOrganizacion_CSR'] = $this->put('UnidadOrganizacion_CSR');
					$data['Organizacion_CSR'] = $this->put('Organizacion_CSR');
					$data['Ciudad_CSR'] = $this->put('Ciudad_CSR');
					$data['Estado_CSR'] = $this->put('Estado_CSR');
					$data['Pais_CSR'] = $this->put('Pais_CSR');
					$data['Key_CSR'] = $this->put('Key_CSR');
					$data['organizacion_cli'] = $this->put('organizacion_cli');
					$data['ruc_cli'] = $this->put('ruc_cli');
					$data['direccion_cli'] = $this->put('direccion_cli');
					$data['ciudad_cli'] = $this->put('ciudad_cli');
					$data['direccion_cli'] = $this->put('direccion_cli');
					$data['provincia_cli'] = $this->put('provincia_cli');
					$data['pais_cli'] = $this->put('pais_cli');
					$data['codPostal_cli'] = $this->put('codPostal_cli');
					$data['telefono_cli'] = $this->put('telefono_cli');
					$data['nombreSSL_Adm'] = $this->put('nombreSSL_Adm');
					$data['apellidoSSL_Adm'] = $this->put('apellidoSSL_Adm');
					$data['organizacionSSL_Adm'] = $this->put('organizacionSSL_Adm');
					$data['cargoSSL_Adm'] = $this->put('cargoSSL_Adm');
					$data['direccionSSL_Adm'] = $this->put('direccionSSL_Adm');
					$data['ciudadSSL_Adm'] = $this->put('ciudadSSL_Adm');
					$data['provSSL_Adm'] = $this->put('provSSL_Adm');
					$data['paisSSL_Adm'] = $this->put('paisSSL_Adm');
					$data['codPostalSSL_Adm'] = $this->put('codPostalSSL_Adm');
					$data['telOfSSL_Adm'] = $this->put('telOfSSL_Adm');
					$data['anexoSSL_Adm'] = $this->put('anexoSSL_Adm');
					$data['mailSSL_Adm'] = $this->put('mailSSL_Adm');
					$data['nombreSSL_Tec'] = $this->put('nombreSSL_Tec');
					$data['apellidoSSL_Tec'] = $this->put('apellidoSSL_Tec');
					$data['organizacionSSL_Tec'] = $this->put('organizacionSSL_Tec');
					$data['cargoSSL_Tec'] = $this->put('cargoSSL_Tec');
					$data['direccionSSL_Tec'] = $this->put('direccionSSL_Tec');
					$data['ciudadSSL_Tec'] = $this->put('ciudadSSL_Tec');
					$data['provSSL_Tec'] = $this->put('provSSL_Tec');
					$data['paisSSL_Tec'] = $this->put('paisSSL_Tec');
					$data['codPostalSSL_Tec'] = $this->put('codPostalSSL_Tec');
					$data['telOfSSL_Tec'] = $this->put('telOfSSL_Tec');
					$data['anexoSSL_Tec'] = $this->put('anexoSSL_Tec');
					$data['mailSSL_Tec'] = $this->put('mailSSL_Tec');
					$data['estado'] = 'Asignado';
					$data['servidor'] = $this->put('servicioSSL');
					$data['fech_regform'] = date("Y-m-d H:i:s");

					$this->Ssl_cert_forms_model->add_form($data);
					$ssl_cert_form_id = $this->db->insert_id();

					$ssl_certificates_assigned_id = $this->put('ssl_certificates_assigned_id');

					$data_ssl_cert_assigned['ssl_certificate_status_id'] = 2;
					$data_ssl_cert_assigned['ssl_certificate_form_id'] = $ssl_cert_form_id;

					$api_form['status_id'] = 'Valido';
					$id_formulario = $this->put('id_formulario');

					// $resp = $this->api_forms_perusecurity->upd_ssl_cert($api_form, $id_formulario);

					// if($resp->err == FALSE) {
						if($this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data_ssl_cert_assigned, $ssl_certificates_assigned_id)) {
							$this->response(
								array(
									'err' => FALSE,
									'status' => 'success',
									'message' => 'Validado correctamente',
									'resp' => $resp
								), REST_Controller::HTTP_OK);
						} else {
							$this->response(
								array(
									'err' => TRUE,
									'status' => 'error',
									'message' => 'Error al validar'
								), REST_Controller::HTTP_OK);
						}
					// } else $this->response($resp, REST_Controller::HTTP_OK);
					
				}
			else:
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Todos los campos son requeridos',
					), REST_Controller::HTTP_OK);
			endif;
		endif;
	}
	
	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

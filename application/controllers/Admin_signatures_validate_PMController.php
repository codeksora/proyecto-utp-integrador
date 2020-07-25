<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_signatures_validate_PMController extends REST_Controller {

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
        $this->load->library('api_forms_perusecurity');
        date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/signatures_validate/signatures_validate_view', $data);
        }
	}
	
	public function edit_view_get() {
		if(!isset($this->privileges->update) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/signatures_validate/signatures_validate_edit_view');
		}
	}

	// // public function modal_add_view_get() {
	// // 	if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
	// // 		$this->load->view('admin/templates/errors/not_privilege');
	// // 	} else {
	// // 		$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_add_view');
	// // 	}
	// // }

	// // public function modal_assign_domain_to_customer_view_get() {
	// // 	if(!isset($this->privileges->insert) OR $this->privileges->insert == 0) {
	// // 		$this->load->view('admin/templates/errors/not_privilege');
	// // 	} else {
	// // 		$this->load->view('admin/templates/ssl_certificates/ssl_certificates_modal_assign_domain_to_customer_view');
	// // 	}
	// // }

    public function signatures_validate_get($signature_id = NULL) {
        if($signature_id != NULL):
            $signature = $this->api_forms_perusecurity->get_signature($signature_id);
            
            $this->response(
                $signature, 
                REST_Controller::HTTP_OK);
        else:
            $data['start'] = $this->get('start');
            $data['length'] = $this->get('length');
            $data['draw'] = $this->get('draw');
            $data['order'] = $this->get('order');
            $data['search'] = $this->get("search");

            $signatures = $this->api_forms_perusecurity->get_signatures($data);

            // $signatures = array(
            // 	'asd' => $signatures
            // );

            $this->response(
                $signatures, 
                REST_Controller::HTTP_OK);
        endif;
	}

    public function signatures_validate_put() {
		if(!isset($this->privileges->update) OR $this->privileges->update == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else:
			$signature = $this->put();

			if(count($signature) > 0):
				// $this->form_validation->set_data($signature);
			
	// 			$this->form_validation->set_rules('ssl_certificates_assigned_id', '', 'required', 
	// 				array('required' => 'Debe asignarle algún producto registrado'));

	// 			if ($this->form_validation->run() == FALSE) {
	// 				$this->response(
	// 					array(
	// 						'err' => TRUE,
	// 						'status' => 'error',
	// 						'message' => validation_errors()
	// 					), REST_Controller::HTTP_OK);
	// 			} else {
					$data['persnombreuser'] = $this->put('persnombreuser');
					$data['persmailuser'] = $this->put('persmailuser');
					$data['perscargouser'] = $this->put('perscargouser');
					$data['perstipodocuser'] = $this->put('perstipodocuser');
					$data['persnrodocuser'] = $this->put('persnrodocuser');
					$data['persareauser'] = $this->put('persareauser');
					$data['perstelefuser'] = $this->put('perstelefuser');
					$data['persanexouser'] = $this->put('persanexouser');
					$data['persmoviluser'] = $this->put('persmoviluser');
					$data['persrepresentante'] = $this->put('persrepresentante');
					$data['persempresauser'] = $this->put('persempresauser');
					$data['persrucuser'] = $this->put('persrucuser');
					$data['persdoc1user'] = $this->put('persdoc1user');
					$data['persdoc2user'] = $this->put('persdoc2user');
					$data['persempresafactura'] = $this->put('persempresafactura');
					$data['persempresaruc'] = $this->put('persempresaruc');
					$data['persnombrecontacto'] = $this->put('persnombrecontacto');
					$data['persmailcontacto'] = $this->put('persmailcontacto');
					$data['perscargocontacto'] = $this->put('perscargocontacto');
					$data['perstelefcontacto'] = $this->put('perstelefcontacto');
					$data['persanexocontacto'] = $this->put('persanexocontacto');
					$data['idproducto'] = $this->put('idproducto');
					$data['persdescproducto'] = $this->put('persdescproducto');
					$data['persaccionproducto'] = $this->put('persaccionproducto');
					$data['perstiempoproducto'] = $this->put('perstiempoproducto');
					$data['pagopersbanco'] = $this->put('pagopersbanco');
					$data['pagopersempresaord'] = $this->put('pagopersempresaord');
					$data['pagodatepicker1'] = $this->put('pagodatepicker1');
					$data['pagopersnrocuenta'] = $this->put('pagopersnrocuenta');
					$data['pagopersimporte'] = $this->put('pagopersimporte');
					$data['pagopersmoneda'] = $this->put('pagopersmoneda');
					$data['pagopersnrooperacion'] = $this->put('pagopersnrooperacion');
					$data['pagopersnropedido'] = $this->put('pagopersnropedido');
					$data['persestadouser'] = 'Valido';
					$data['persfecharegistro'] = $this->put('persfecharegistro');
					$data['persfechavalidacion'] = $this->put('persfechavalidacion');
					$data['persusuariovalidacion'] = $this->put('persusuariovalidacion');
					$data['idcertpersonal'] = $this->put('idcertpersonal');
					$data['perssolicitatoken'] = $this->put('perssolicitatoken');

					$data['persfechavalidacion'] = date("Y-m-d H:i:s");
					$data['persusuariovalidacion'] = $this->session->userdata('full_name');

					$this->Signature_forms_model->add_form($data);
					$signature_form_id = $this->db->insert_id();

					// $ssl_certificates_assigned_id = $this->put('ssl_certificates_assigned_id');

					$data_ssl_cert_assigned['ssl_certificate_status_id'] = 2;
					$data_ssl_cert_assigned['ssl_certificate_form_id'] = $signature_form_id;

					$api_form['status_id'] = 'Valido';
					$idpersonal = $this->put('idpersonal');

					$resp = $this->api_forms_perusecurity->upd_signature($api_form, $idpersonal);

					if($resp->err == FALSE) {
						$this->response(
							array(
								'err' => FALSE,
								'status' => 'success',
								'message' => 'Validado correctamente'
							), REST_Controller::HTTP_OK);
					} else $this->response($resp, REST_Controller::HTTP_OK);
					
	// 			}
			else:
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Todos los campos son requeridos',
						'resp' => $signature
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

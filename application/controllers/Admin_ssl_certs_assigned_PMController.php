<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_ssl_certs_assigned_PMController extends REST_Controller {

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

		$this->load->model('Ssl_certs_assigned_model');
		$this->load->model('Quotation_product_details_model');
		$this->load->model('Additional_sans_model');
		date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_view', $data);
        }
	}
	
	public function modal_view_get() {
		if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_modal_view', $data);
        }
	}

	public function modal_assign_contacts_view_get() {
		if(!isset($this->privileges->read) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );

            $this->load->view('admin/templates/ssl_certificates_assigned/ssl_certificates_assigned_modal_assign_contacts_view', $data);
        }
	}

	public function ssl_certs_assigned_pending_get() { 
        if(!isset($this->privileges->read) OR $this->privileges->read == 0):
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else: 
			$start = $this->get('start');
			$length = $this->get('length');
			$draw = $this->get('draw');
			$order = $this->get('order');
			$order_column = (int) $order[0]['column'] + 1;
			$order_dir = $order[0]["dir"];
			$search = $this->get("search");
			$search_value = $search["value"];

			$ssl_certificate_status_s = $this->get('ssl_certificate_status_s');

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Ssl_certs_assigned_model->get_all_pending($ssl_certificate_status_s, $start, $length)),
				'recordsFiltered' => count($this->Ssl_certs_assigned_model->get_all_pending($ssl_certificate_status_s, NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Ssl_certs_assigned_model->get_all_pending($ssl_certificate_status_s, $start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
        endif;
	
	}

    public function ssl_certs_assigned_get($ssl_cert_assigned_id = NULL) { 
        if(!isset($this->privileges->read) OR $this->privileges->read == 0):
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
        else: 
            if($ssl_cert_assigned_id != NULL) {
				$ssl_cert_assigned = $this->Ssl_certs_assigned_model->get_ssl_cert_assigned($ssl_cert_assigned_id);

				if($ssl_cert_assigned) {
					$this->response($ssl_cert_assigned, REST_Controller::HTTP_OK);
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

				$ssl_certificate_status_s = $search["ssl_certificate_status_id"];
	
				$data = array(
					'draw' => $draw,
					'recordsTotal' => count($this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, $start, $length)),
					'recordsFiltered' => count($this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, NULL, NULL, $order_column, $order_dir, $search_value)),
					'data' => $this->Ssl_certs_assigned_model->get_all($ssl_certificate_status_s, $start, $length, $order_column, $order_dir, $search_value)
				);
				$this->response($data, REST_Controller::HTTP_OK);
			}
        endif;
	}

	public function order_ssl_certs_assigned_get($order_id = NULL) {
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
			'recordsTotal' => count($this->Ssl_certs_assigned_model->get_ssl_certs_assigned_by_order($order_id, $start, $length)),
			'recordsFiltered' => count($this->Ssl_certs_assigned_model->get_ssl_certs_assigned_by_order($order_id, NULL, NULL, $order_column, $order_dir, $search_value)),
			'data' => $this->Ssl_certs_assigned_model->get_ssl_certs_assigned_by_order($order_id, $start, $length, $order_column, $order_dir, $search_value)
		);
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function send_to_form_put($ssl_cert_assigned_id = NULL) {
		$skip = $this->put('skip');
		
		if($skip == 1) {
			$contacts = $this->put('contacts');

			$this->load->library('email');

			$subject = 'FORMULARIO DE ENROLAMIENTO';
			$message = '<p>Buenos días<br><br>

			Para iniciar el proceso de adquisición y/o renovación de su(s) certificado(s) SSL es 
			necesario que ingrese al link de enrolamiento y complete los datos solicitados:<br><br>

			URL de enrolamiento:<br>
			<a href="https://formulario.perusecurity.pe">https://formulario.perusecurity.pe</a>
			<br><br>
			Si tiene alguna consulta, no dude en comunicarse con nosotros por este medio
			<br><br>
			Gracias por su atención
			<br><br>
			Saludos</p>';	

			$i = 0;

			$mails = array();

			foreach ($contacts as $contact) {
				if(isset($contact["isChecked"])) {
					if($contact["isChecked"] === true) { $i = 1;
						array_push($mails, $contact["email"]);
					}
				} 
			}
			if($i == 1) {
				$to = implode(",", $mails);

				$result = $this->email
					->from('no-responder@perumedia.pe')
					->to($to)
					->subject($subject)
					->message($message)
					->send();


				if($result) {
					$data['ssl_certificate_status_id'] = 8;
					$this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id);

					$this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Mensajes enviados correctamente'
						), REST_Controller::HTTP_OK); 
				} else {
					$this->response(
						array(
							'err' => TRUE,
							'status' => 'error',
							'message' => $this->email->print_debugger()
						), REST_Controller::HTTP_OK); 
				}
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Tiene que elegir al menos un contacto'
					), REST_Controller::HTTP_OK); 
			}
		} else {
			$data['ssl_certificate_status_id'] = 8;
			$this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id);

			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Se omitió el envío de correo electrónico correctamente'
				), REST_Controller::HTTP_OK); 
		}

		// En este proceso, los SSL pendientes pasan a formulario
		// luego de que los correos se hayan enviado correctamente a los
		// usuarios respectivos.
		
	}

	public function ssl_certs_assigned_post() {
		$ssl_cert_assigned_data = $this->post();

		if(count($ssl_cert_assigned_data) > 0):
			$this->form_validation->set_data($ssl_cert_assigned_data);
			$this->form_validation->set_rules('ssl_certificate_id', 'Dominio', 'required', 
				array('required' => 'Debe seleccionar un dominio')
			);
		// 	$this->form_validation->set_rules('last_name', 'Apellido', 'required');
		// 	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		// 	$this->form_validation->set_rules('phone_code_id', 'Código de país', 'required|integer');
		// 	$this->form_validation->set_rules('phone', 'Teléfono', 'required|numeric');
		// 	$this->form_validation->set_rules('mobile_phone', 'Celular', 'required|numeric');
		// 	$this->form_validation->set_rules('extension', 'Anexo', 'numeric');
		// 	$this->form_validation->set_rules('country_id', 'País', 'required|integer');
		// 	$this->form_validation->set_rules('state', 'Estado', 'required');
		// 	$this->form_validation->set_rules('city', 'Ciudad', 'required');
		// 	$this->form_validation->set_rules('address_line_1', 'Dirección 1', 'required');
		// 	$this->form_validation->set_rules('address_line_2', 'Dirección 2', 'required');
		// 	$this->form_validation->set_rules('customer_id', 'Empresa', 'required|integer');
		// 	$this->form_validation->set_rules('job_title', 'Cargo', 'required');
		// 	$this->form_validation->set_rules('contact_type_id', 'Tipo de contacto', 'required|integer');

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
                $quotation_product_detail_id = $this->post('quotation_product_detail_id');

				$data['quotation_product_detail_id'] = $quotation_product_detail_id;
				$data['ssl_certificate_id'] = $this->post('ssl_certificate_id');
				$data['server_type_id'] = $this->post('server_type_id');
				$data['ssl_certificate_status_id'] = 1;
                $data['user_id'] = $this->session->userdata('user_id');
				$data['created_at'] = date("Y-m-d H:i:s");
				$data['updated_at'] = date("Y-m-d H:i:s");

				$this->db->trans_start(); // INICIO DE QUERIES

				$this->Ssl_certs_assigned_model->add_ssl_cert_assigned($data);

				$quotation_product_detail['status_id'] = 2;
				$this->Quotation_product_details_model->update_quotation_product_detail($quotation_product_detail, $quotation_product_detail_id);

				$this->db->trans_complete(); // FIN DE QUERIES

				if($this->db->trans_status()) {
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

	public function send_to_validate_put($ssl_cert_assigned_id = NULL) {
		$enroll_code = $this->put('enroll_code');
		$additional_sans = $this->put('addtional_sans');

		$data['ssl_certificate_status_id'] = 3;
		$data['server_type_id'] = $this->put('server_type_id');
		$data['updated_at'] = date("Y-m-d H:i:s");

		foreach ($additional_sans as $additional_san) {
			$additional_san_data = array(
				'common_name' => $additional_san,
				'ssl_certificate_assigned_id' => $ssl_cert_assigned_id,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
				'status_id' => 1,
				'user_id' => $this->session->userdata('user_id')
			);
			$this->Additional_sans_model->add_addition_sans($additional_san_data);
		}

		$this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id);

		$this->response(
			array(
				'err' => FALSE,
				'status' => 'success',
				'message' => 'Cambios guardados correctamente, certificado validado',
			), REST_Controller::HTTP_OK); 
	}

	public function send_to_issue_put($ssl_cert_assigned_id = NULL) {
		$enroll_code = $this->put('enroll_code');

		$data['ssl_certificate_status_id'] = 4;
		$data['enroll_code'] = $enroll_code;
		$data['enroll_date'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");

		$this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id);

		$this->response(
			array(
				'err' => FALSE,
				'status' => 'success',
				'message' => 'Cambios guardados correctamente, listo para ser emitido'
			), REST_Controller::HTTP_OK); 
	}

	public function send_to_install_put($ssl_cert_assigned_id = NULL) {
		$ssl_cert_assigned_data = $this->put();
		$this->form_validation->set_data($ssl_cert_assigned_data);

		$this->form_validation->set_rules('expiration_date', '<strong>Fecha de Vencimiento</strong>', 'required|valid_date');
		$this->form_validation->set_rules('issue_date', '<strong>Fecha de Emisión</strong>', 'required|valid_date');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors(),
					'errors' => $this->form_validation->error_array()
				), REST_Controller::HTTP_OK);
    	} else {
			$expiration_date = date("Y-m-d H:i:s", strtotime($this->put('expiration_date')));
			$issue_date = date("Y-m-d H:i:s", strtotime($this->put('issue_date')));
			$updated_at = date("Y-m-d H:i:s");
			
			$data['ssl_certificate_status_id'] = 5;
			$data['issue_date'] = $issue_date;
			$data['expiration_date'] = $expiration_date;
			$data['updated_at'] = $updated_at;	

			if(date("Y", strtotime($this->put('expiration_date'))) == date("Y", strtotime($this->put('issue_date')))) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Las fechas de emisión y vencimiento <strong>NO</strong> pueden ser en el mismo año'
					), REST_Controller::HTTP_OK); 
			} else {
				if($this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id)) {
					$this->response(
						array(
							'err' => FALSE,
							'status' => 'success',
							'message' => 'Cambios guardados correctamente, listo para ser instalado'
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

	
		}

	}
	
	public function send_to_installed_put($ssl_cert_assigned_id = NULL) {
		$installation_date = date("Y-m-d H:i:s", strtotime($this->put('installation_date')));
		
		$data['ssl_certificate_status_id'] = 6;
		$data['installation_date'] = $installation_date;
		$data['updated_at'] = date("Y-m-d H:i:s");

		$this->Ssl_certs_assigned_model->update_ssl_cert_assigned($data, $ssl_cert_assigned_id);

		$this->response(
			array(
				'err' => FALSE,
				'status' => 'success',
				'message' => 'Cambios guardados correctamente, certificado instalado'
			), REST_Controller::HTTP_OK); 
	}

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}
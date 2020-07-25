<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_contact_types_PMController
 *
 * @package     Tipos de contacto
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_contacts_ssl_certs_assigned_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();
		
		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Contacts_ssl_certs_assigned_model');
    }

    public function contacts_ssl_certs_assigned_get($ssl_cert_assigned_id = NULL) {
        $start = $this->get('start');
        $length = $this->get('length');
        $draw = (int) $this->get('draw');
        $order = $this->get('order');
        $order_column = (int) $order[0]['column'] + 1;
        $order_dir = $order[0]["dir"];
        $search = $this->get("search");
        $search_value = $search["value"];

        $data = array(
            'draw' => (int) $draw,
            'recordsTotal' => count($this->Contacts_ssl_certs_assigned_model->get_contacts_by_ssl_cert_assigned($ssl_cert_assigned_id, $start, $length)),
            'recordsFiltered' => count($this->Contacts_ssl_certs_assigned_model->get_contacts_by_ssl_cert_assigned($ssl_cert_assigned_id, NULL, NULL, $order_column, $order_dir, $search_value)),
            'data' => $this->Contacts_ssl_certs_assigned_model->get_contacts_by_ssl_cert_assigned($ssl_cert_assigned_id, $start, $length, $order_column, $order_dir, $search_value)
        );
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function contacts_ssl_certs_assigned_post() {
        $assign_contact = $this->post();
        $contact_to_ssl = $assign_contact['contact_to_ssl'];

        if(count($assign_contact) > 0):
            $this->form_validation->set_data($contact_to_ssl);
            $this->form_validation->set_rules('contact_type_id', '<strong>Tipo de contacto</strong>', 'required');

            if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {

                
                $contact_type_id = $contact_to_ssl['contact_type_id'];

                $ssl_cert_assigned_id = $assign_contact['ssl_cert_assigned_id'];

                $contacts = $assign_contact['contacts'];

                $i = 0;

                foreach ($contacts as $contact) {
                    if(isset($contact["isChecked"])) {
                        if($contact["isChecked"] === true) { $i = 1;
                            $data['contact_id'] = $contact['id'];
                            $data['ssl_certificate_assigned_id'] = $ssl_cert_assigned_id;
                            $data['contact_type_id'] = $contact_type_id;
                            $data['status_id'] = 1;

                            $this->Contacts_ssl_certs_assigned_model->add_contact_ssl_cert_assigned($data);
                        }
                    } 
                }
                
                if($i == 0) {
                    $this->response(
                        array(
                            'err' => TRUE,
                            'status' => 'error',
                            'message' => 'Debe elegir al menos un contacto'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(
                        array(
                            'err' => FALSE,
                            'status' => 'success',
                            'message' => 'Contactos asignados correctamente al certificado SSL'
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
    
    public function contacts_ssl_certs_assigned_delete($ssl_cert_assigned_id, $contact_id) {
      if($this->Contacts_ssl_certs_assigned_model->delete_contact($ssl_cert_assigned_id, $contact_id)) {
            $this->response(
                array(
                    'err' => FALSE,
                    'status' => 'success',
                    'message' => 'Eliminado correctamente'
                ), REST_Controller::HTTP_OK);
        } else {
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => 'Error al eliminar el contacto'
                ), REST_Controller::HTTP_OK);
        }
    }

}
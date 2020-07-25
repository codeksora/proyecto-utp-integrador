<?php

use Pusher\Pusher;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_providers_PMController extends REST_Controller {

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

        $this->load->model('Providers_model');
        date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        if(!isset($this->privileges) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );
            $this->load->view('admin/templates/providers/providers_view', $data);
        }
    }

    public function add_view_get() {
        if(!isset($this->privileges) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );
            $this->load->view('admin/templates/providers/providers_add_view', $data);
        }
    }

    public function edit_view_get() {
        if(!isset($this->privileges) OR $this->privileges->update == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $this->load->view('admin/templates/providers/providers_edit_view');
        }
    }

    public function modal_view_get() {
        if(!isset($this->privileges) OR $this->privileges->read == 0) {
            $this->load->view('admin/templates/errors/not_privilege');
        } else {
            $data = array(
                'privileges' => $this->privileges
            );
            $this->load->view('admin/templates/providers/providers_modal_view', $data);
        }
    }

    public function providers_get($provider_id = NULL) {
        if($provider_id != NULL) {
            $provider = $this->Providers_model->get_provider($provider_id);

            if($provider) {
                $this->response($provider, REST_Controller::HTTP_OK);
            } else {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Acceso no permitido'
                    ), REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response(
                $this->Providers_model->get_all(),
                REST_Controller::HTTP_OK);
        }
    }

    // RECIBIR TODOS LOS PROVEEDORES - FORMATO PARA DATATABLE
    public function providers_dt_get() {
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
            'recordsTotal' => count($this->Providers_model->get_all_dt($start, $length)),
            'recordsFiltered' => count($this->Providers_model->get_all_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
            'data' => $this->Providers_model->get_all_dt($start, $length, $order_column, $order_dir, $search_value)
        );
        $this->response($data, REST_Controller::HTTP_OK);
    
    }

    // AGREGAR NUEVO PROVEEDOR
    public function providers_post() {
        $provider_data = $this->post();

        if(count($provider_data) > 0):
            $this->form_validation->set_data($provider_data);
            $this->form_validation->set_rules('name', 'Nombre', 'required');
            $this->form_validation->set_rules('phone', 'Teléfono', 'is_natural');
            $this->form_validation->set_rules('email', 'Correo electrónico', 'valid_email');
            $this->form_validation->set_rules('website', 'Sítio web', 'required|valid_url');

            if ($this->form_validation->run() == FALSE) {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => validation_errors()
                    ), REST_Controller::HTTP_OK);
            } else {
                $name = $this->post('name');

                $data['name'] = $name;
                $data['phone'] = $this->post('phone');
                $data['email'] = $this->post('email');
                $data['website'] = $this->post('website');
                $data['status_id'] = 1;
                $data['user_id'] = $this->session->userdata('user_id');
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['updated_at'] = date("Y-m-d H:i:s");

                if($this->Providers_model->add_provider($data)) {
                    $notif = array(
                        'created_at' => date("Y-m-d H:i:s"),
                        'user_id' => $this->session->userdata('user_id'),
                        'subject' => 'Un proveedor ha sido creado',
                        'description' => "El proveedor $name ha sido creado correctamente.",
                        'icon' => 'globe',
                        'color' => 'green'
                    );
                    $this->Notifications_model->add_notification($notif);

                    $options = array(
                        'cluster' => 'us2',
                        'useTLS' => true
                    );
                    $pusher = new Pusher(
                        '5e9b6b6e06917225ff96',
                        'd8cc1d7275c3f3b46981',
                        '825366',
                        $options
                    );

                    $data['message'] = 'Enviado';
                    $pusher->trigger('ch-notif', 'ev-notif', $data);

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
                            'message' => 'Error al agregar el proveedor',
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

    public function providers_put($id = NULL) {
        
        $provider_data = $this->put();

        $this->form_validation->set_data($provider_data);
        $this->form_validation->set_rules('name', 'Nombre', 'required');
        $this->form_validation->set_rules('phone', 'Teléfono', 'is_natural');
        $this->form_validation->set_rules('email', 'Correo electrónico', 'valid_email');
        $this->form_validation->set_rules('website', 'Sítio web', 'required|valid_url');
    
        if ($this->form_validation->run() == FALSE) {
            $this->response(
                array(
                    'err' => TRUE,
                    'status' => 'error',
                    'message' => validation_errors()
                ), REST_Controller::HTTP_OK);
        } else {
            $name = $this->put('name');

            $data['name'] = $name;
            $data['phone'] = $this->put('phone');
            $data['email'] = $this->put('email');
            $data['website'] = $this->put('website');
            $data['updated_at'] = date("Y-m-d H:i:s");

            if($this->Providers_model->update_provider($data, $id)) {
                $notif = array(
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $this->session->userdata('user_id'),
                    'subject' => 'Un proveedor ha sido editado',
                    'description' => "El proveedor $name ha sido editado correctamente.",
                    'icon' => 'globe',
                    'color' => 'yellow'
                );
                $this->Notifications_model->add_notification($notif);

                $options = array(
                    'cluster' => 'us2',
                    'useTLS' => true
                );
                $pusher = new Pusher(
                    '5e9b6b6e06917225ff96',
                    'd8cc1d7275c3f3b46981',
                    '825366',
                    $options
                );

                $data['message'] = 'Enviado';
                $pusher->trigger('ch-notif', 'ev-notif', $data);

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
                        'message' => 'Error al actualizar'
                    ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function providers_delete($id = NULL) {
        if($this->Providers_model->delete_provider($id)) {

            $provider = $this->Providers_model->search_provider($id);

            $name = $provider->name;

            $notif = array(
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'subject' => 'Un proveedor ha sido eliminado',
                'description' => "El proveedor $name ha sido eliminado correctamente.",
                'icon' => 'globe',
                'color' => 'red'
            );
            $this->Notifications_model->add_notification($notif);

            $options = array(
                'cluster' => 'us2',
                'useTLS' => true
            );
            $pusher = new Pusher(
                '5e9b6b6e06917225ff96',
                'd8cc1d7275c3f3b46981',
                '825366',
                $options
            );

            $data['message'] = 'Enviado';
            $pusher->trigger('ch-notif', 'ev-notif', $data);

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
                    'message' => 'Error al eliminar al proveedor'
                ), REST_Controller::HTTP_OK);
        }
    }

    public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}
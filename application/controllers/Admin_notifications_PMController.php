<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_domains_PMController
 *
 * @package     Dominios
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_notifications_PMController extends REST_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

//        $this->load->model('Backend_model');
//        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $this->load->model('Notifications_model');
        date_default_timezone_set('America/Lima');
    }

    public function index_get() {
        $this->load->view('admin/templates/notifications/notifications_view');
    }


    public function notifications_get() {
        $this->response(
            $this->Notifications_model->get_all(),
            REST_Controller::HTTP_OK
        );
    }

    public function notifications_now_get() {
        $this->response(
            $this->Notifications_model->get_all_now(),
            REST_Controller::HTTP_OK
        );
    }

    public function notifications_dt_get() {
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
            'recordsTotal' => count($this->Notifications_model->get_all_dt($start, $length)),
            'recordsFiltered' => count($this->Notifications_model->get_all_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
            'data' => $this->Notifications_model->get_all_dt($start, $length, $order_column, $order_dir, $search_value)
        );
        $this->response($data, REST_Controller::HTTP_OK);
    }

//    public function privileges_get() {
//        $this->response(
//            $this->privileges,
//            REST_Controller::HTTP_OK);
//    }

}
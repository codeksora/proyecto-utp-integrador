<?php
/**
 * Created by PhpStorm.
 * User: Desarrollo
 * Date: 14/03/2019
 * Time: 10:45
 */

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {
    public function index_get() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.intranet.pm/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: REhLeLq3bgmA6px554nawVc74UCgSUbC6DWL'
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        echo var_dump($data);
    }
    
    public function orders_get() {
        $this->load->model('Orders_model');
        
        $data = array(
            'status' => 'success',
            'err' => FALSE,
            'data' => $this->Orders_model->api_get_all()
        );
        
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
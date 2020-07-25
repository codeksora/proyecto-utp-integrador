<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_product_details_PMController extends REST_Controller {

    private $url;
    private $privileges;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        // $infomenu = $this->Backend_model->get_id($this->url);
        // $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

        $this->load->model('Product_details_model');
        $this->load->model('Configurations_model');
        $this->load->library('Api_sunat');
    }

    // Recibir precios del producto por ID
    public function product_details_get($product_price_id = NULL, $currency_type_id = NULL) {
        // $sell = $this->Configurations_model->get_by_option('sell'); //TIPO DE CAMBIO VENTA
        $sell = $this->api_sunat->get_tipo_cambio();
        // $cotizacion = $sell->Cotizacion;
        // $compra = $cotizacion[0]->Compra;
        $venta = $sell['venta'];

        $product_detail = $this->Product_details_model->get_product_detail($product_price_id);

        if($product_detail) {
            switch($currency_type_id) {
                case 1: // SOLES
                    $product_detail->product_detail_price = $product_detail->product_price_pen;
                    $product_detail->product_san_detail_price = $product_detail->product_san_price_pen;
                    break;
                default: // DÓLARES
                    $product_detail->product_detail_price = $product_detail->product_price;
                    $product_detail->product_san_detail_price = $product_detail->product_san_price;
                    break;
            }

           // $product_detail->product_detail_price = floatval(number_format($product_detail->product_detail_price, 2, '.', ''));
           // $product_detail->product_san_detail_price = floatval(number_format($product_detail->product_san_detail_price * $tipo_cambio, 2, '.', ''));
        }

        $this->response(
            $product_detail, 
            REST_Controller::HTTP_OK);
      
    }

    // Recibir precios del producto por TIPO DE MONEDA
    public function product_details_by_currency_type_get($currency_type_id = NULL) {
        // $sell = $this->Configurations_model->get_by_option('sell'); //TIPO DE CAMBIO VENTA
        $sell = $this->api_sunat->get_tipo_cambio();
        // $cotizacion = $sell->Cotizacion;
        // $compra = $cotizacion[0]->Compra;
        $venta = $sell['venta'];

        switch($currency_type_id) {
            case 1: // SOLES
                $tipo_cambio = (float) $venta;
                break;
            default: // DÓLARES
                $tipo_cambio = 1;
                break;
        }

        $product_details = $this->Product_details_model->get_all_by_currency_type();

        foreach ($product_details as $product_detail) {
            $product_detail->price = floatval(number_format($product_detail->price, 2, '.', ''));
        }

        $this->response(
            $product_details, 
            REST_Controller::HTTP_OK);
    }

    public function product_details_by_product_get($product_id = NULL) {
        $this->response(
            $this->Product_details_model->get_all_by_product($product_id), 
            REST_Controller::HTTP_OK);
    }

    public function product_details_put($product_id = NULL) {

//        $this->response($this->Product_details_model->update_product_details($product_id), REST_Controller::HTTP_OK);
    }
}
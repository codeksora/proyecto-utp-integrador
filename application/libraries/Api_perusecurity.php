<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_perusecurity {
    //Colocar la llave privada, que se registró en el sistema intranet
    private $api_key = 'REhLeLq3bgmA6px554nawVc74UCgSUbC6DWL';
    //URL del sistema intranet, el cuál se consumirá el API
    private $api_url = 'http://api.formularios.pm/';

    public function get_invoices() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "invoices");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-API-KEY: $this->api_key"
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $invoices = curl_exec($ch);
        curl_close($ch);

        return json_decode($invoices);
    }

    public function get_order($order_id = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "orders/$order_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-API-KEY: $this->api_key"
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $order = curl_exec($ch);
        curl_close($ch);
        return json_decode($order);
    }

    public function get_order_products($order_id = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "orders/$order_id/products");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "X-API-KEY: $this->api_key"
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $order_products = curl_exec($ch);
        curl_close($ch);
        return json_decode($order_products);
    }

    public function get_orders($data = array()) {
        // echo str_pad(7, 8, '0', STR_PAD_LEFT);
        // exit;
        //USANDO DATATABLE
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];
        $order_dir = $data['order_dir'];
        $order_column = $data['order_column'];
        $search_value = $data['search_value'];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "orders?start=$start&length=$length&draw=$draw&order_dir=$order_dir&order_column=$order_column&search_value=$search_value");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-API-KEY: $this->api_key"
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $orders = curl_exec($ch);
        curl_close($ch);

        return json_decode($orders);
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_forms_perusecurity {
    //Colocar la llave privada, que se registró en el sistema intranet
    private $api_key = 'REhLeLq3bgmA6px554nawVc74UCgSUbC6DWL';
    //URL del sistema intranet, el cuál se consumirá el API
    private $api_url = 'https://deposito2545.com/apiforms/';

    public function get_ssl_certs($data = array()) {
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];

        $order = $data['order'];
        $order_column = $order[0]["column"];
        $order_dir = $order[0]["dir"];

        $search = $data['search'];
        $search_value = $search["value"];

        $query = http_build_query([
            'start' => $start,
            'length' => $length,
            'draw' => $draw,
            'order_dir' => $order_dir,
            'order_column' => $order_column,
            'search_value' => $search_value
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "ssl-certificates?$query");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $ssl_certs = curl_exec($ch);
        curl_close($ch);

        return json_decode($ssl_certs);
    }

    public function get_ssl_cert($ssl_cert_id = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "ssl-certificates/$ssl_cert_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $ssl_cert = curl_exec($ch);
        curl_close($ch);
        return json_decode($ssl_cert);
    }

    public function upd_ssl_cert($ssl_cert_data, $ssl_cert_id = NULL) {
        $data = $ssl_cert_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "ssl-certificates/$ssl_cert_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp);
    }

    public function get_signatures($data = array()) {
        $start = $data['start'];
        $length = $data['length'];
        $draw = $data['draw'];

        $order = $data['order'];
        $order_column = $order[0]["column"];
        $order_dir = $order[0]["dir"];

        $search = $data['search'];
        $search_value = $search["value"];

        $query = http_build_query([
            'start' => $start,
            'length' => $length,
            'draw' => $draw,
            'order_dir' => $order_dir,
            'order_column' => $order_column,
            'search_value' => $search_value
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "signatures?$query");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $signatures = curl_exec($ch);
        curl_close($ch);

        return json_decode($signatures);
    }

    public function get_signature($signature_id = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "signatures/$signature_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $signature = curl_exec($ch);
        curl_close($ch);
        return json_decode($signature);
    }

    public function upd_signature($signature_data, $signature_id = NULL) {
        $data = $signature_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . "signatures/$signature_id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //         "X-API-KEY: $this->api_key"
        // ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp);
    }
}
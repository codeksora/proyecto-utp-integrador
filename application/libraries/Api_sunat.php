<?php defined('BASEPATH') OR exit('No direct script access allowed');

// API CREADO POR ZCRO
class Api_sunat {
    //Colocar la llave privada, que se registró en el sistema intranet
    private $api_key = 'REhLeLq3bgmA6px554nawVc74UCgSUbC6DWL';
    //URL del sistema intranet, el cuál se consumirá el API
    // private $api_url = 'http://api.formularios.pm/';
	//http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes=06&anho=2019
    public function get_tipo_cambio() {
    	$html = file_get_contents('http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias'); //Convierte la información de la URL en cadena
		preg_match_all("/<td width='8%' .*?>.*?<\/[\s]*td>/s", $html, $table_html);
		$table_html = $table_html[0];
		if($table_html) {
			$compra = $table_html ? (float)strip_tags(html_entity_decode($table_html[count($table_html)-2])) : '';
			$venta = $table_html ? (float)strip_tags(html_entity_decode($table_html[count($table_html)-1])) : '';
		} else {
			$month = date('m',strtotime("-1 month"));
			$year = date('Y',strtotime("-1 month"));
			$html = file_get_contents('http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias?mes='.$month.'&anho='.$year); //Convierte la información de la URL en cadena
			preg_match_all("/<td width='8%' .*?>.*?<\/[\s]*td>/s", $html, $table_html);
			$table_html = $table_html[0];
			$compra = $table_html ? (float)strip_tags(html_entity_decode($table_html[count($table_html)-2])) : '';
			$venta = $table_html ? (float)strip_tags(html_entity_decode($table_html[count($table_html)-1])) : '';
		}
		
		$data = array(
			'compra' => $compra,
			'venta' => $venta
		);

		return $data;
	}
	
	// public function get_tipo_cambio() {
	// 	$ch = curl_init();
 //        curl_setopt($ch, CURLOPT_URL, "https://www.deperu.com/api/rest/cotizaciondolar.json");
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 //        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
 //        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 //        //         "X-API-KEY: $this->api_key"
 //        // ));
 //        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 //        $tipo_cambio = curl_exec($ch);
 //        curl_close($ch);

 //        return json_decode($tipo_cambio);
	// }
}
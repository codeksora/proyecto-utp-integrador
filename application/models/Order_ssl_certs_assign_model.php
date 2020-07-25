<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_ssl_certs_assign_model extends CI_Model {
    
    public $id_detordprdcertssl;
    public $idorden;
    public $idproducto;
    public $idcertSSL;
    public $tipoServidor_SSL;
    public $estado_certSSL;
    public $idpedido_certSSL;
    public $cantservidores_certSSL;

    public function get_ssl_certs_by_order($order_id) {
        $this->db->select('
            tbpro.nombre as product_name, 
            tbssl.commonName_certSSL,
            tbdet.estado_certSSL
        ');
        $this->db->from('tb_detordprodcertssl tbdet');
        $this->db->join('orders tbord', 'tbord.id_orden = tbdet.idorden', 'left');
        $this->db->join('tb_producto tbpro', 'tbpro.id_producto = tbdet.idproducto', 'left');
        $this->db->join('tb_ssl tbssl', 'tbssl.id_certSSL = tbdet.idcertSSL', 'left');
        $this->db->where('tbdet.idorden', $order_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Order_ssl_certs_assign_model');
        
        foreach ($rows as $row) {
            $row->id_detordprdcertssl = intval($row->id_detordprdcertssl);
            $row->idorden = intval($row->idorden);
            $row->idproducto = intval($row->idproducto);
            $row->idcertSSL = intval($row->idcertSSL);
        }

        return $rows;
    }

    public function add_ssl_cert($data) {
        return $this->db->insert('tb_detordprodcertssl', $data);
    }
}
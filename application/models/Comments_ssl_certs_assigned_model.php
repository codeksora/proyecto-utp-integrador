<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments_ssl_certs_assigned_model
 *
 * @package     Comentarios de los certificados asignados
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Comments_ssl_certs_assigned_model extends CI_Model {
  
  public function get_all_by_ssl_certificate_assigned_id($ssl_cert_assigned_id) {
        $this->db->select('
            sslcom.id, sslcom.message, sslcom.created_at, us.full_name as user_full_name,
            im.name as image_name
        ');
        $this->db->from('comments_ssl_certificates_assigned sslcom');
    $this->db->join('users us', 'us.id = sslcom.user_id');
    $this->db->join('images im', 'im.id = us.image_id', 'left');
    $this->db->where('ssl_certificate_assigned_id', $ssl_cert_assigned_id);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Comments_ssl_certs_assigned_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }
  
  public function add_comment_ssl_cert_assigned($comment_data) {
        return $this->db->insert('comments_ssl_certificates_assigned', $comment_data);
    }
  
}
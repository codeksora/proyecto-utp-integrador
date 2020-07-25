<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Products_model
 *
 * @package     Productos
 * @author      Carlos Chirito
 * @link        https://intranet.perusecurity.pe
 */

class Products_model extends CI_Model {
    /**
     * Muestra todos los productos con estado diferente a 3 (3 => Eliminado).
     *
     * @return      array
     */
    public function get_all($provider_s = NULL, $product_type_s = NULL, $startRec_s = NULL, $endRec_s = NULL,
        $start = NULL, $length = NULL, $order_column = '', 
        $order_dir = '', $search_value = NULL) {
        $this->db->select('
            pro.name as provider_name, 
            p.name, 
            pts.name as product_type_name, 
            p.created_at, 
            u.full_name, 
            p.updated_at, 
            p.information_document,
            p.description, 
            p.id, p.status_id, p.product_type_id,
        ');
        $this->db->from('(SELECT * FROM products WHERE status_id != 3) as p');
        $this->db->join('providers pro', 'p.provider_id = pro.id', 'left');
        $this->db->join('product_types pts', 'p.product_type_id = pts.id', 'inner');
        $this->db->join('users u', 'u.id = p.user_id', 'left');
        if($search_value != NULL) {
            $this->db->or_like('pro.name', $search_value);
            $this->db->or_like('p.name', $search_value);
            $this->db->or_like('pts.name', $search_value);
            $this->db->or_like('DATE_FORMAT(p.created_at, "%d/%m/%Y")', $search_value);
            $this->db->or_like('u.full_name', $search_value);
        }
        if($provider_s != NULL) $this->db->like('pro.name', $provider_s);
        if($product_type_s != NULL) $this->db->like('pts.name', $product_type_s);
        if($startRec_s != NULL) $this->db->where('p.created_at >=', $startRec_s);
        if($endRec_s != NULL) $this->db->where('p.created_at <=', $endRec_s);
        $this->db->limit($length, $start);
        $this->db->order_by($order_column, $order_dir);
        $query = $this->db->get();
        $rows = $query->custom_result_object('Products_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->status_id = intval($row->status_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->updated_at = $row->updated_at ? strtotime($row->updated_at) * 1000 : '';
        }

        return $rows;
    }

    /**
     * Muestra los datos de un producto.
     *
     * @param       int     $product_id
     * @return      array
     */
    public function get_product($product_id) {
        $this->db->select('
            p.id, p.name, p.description, p.product_type_id, p.provider_id, p.status_id, p.created_at, 
            p.is_san, p.san_base, p.san_max,
            pro.name as provider_name, 
            pts.name as product_type_name, 
            st.name as status_name,
            us.full_name as user_full_name, 
            p.quantity_year_id,
            p.information_document, p.product_category_id
        ');
        $this->db->from('products p');
        $this->db->join('providers pro', 'p.provider_id = pro.id', 'left');
        $this->db->join('product_types pts', 'p.product_type_id = pts.id', 'left');
        $this->db->join('status st', 'p.status_id = st.id', 'left');
        $this->db->join('users us', 'p.user_id = us.id', 'left');
        $this->db->where('p.id', $product_id);
        $this->db->where('p.status_id !=', 3);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Products_model');
            $row->id = intval($row->id);
            $row->provider_id = intval($row->provider_id);
            $row->product_type_id = intval($row->product_type_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->san_base = intval($row->san_base);
            $row->san_max = intval($row->san_max);
            $row->quantity_year_id = intval($row->quantity_year_id);
            $row->product_category_id = intval($row->product_category_id);

            return $row;
        } else return FALSE;
    }

    public function search_product($product_id) {
        $this->db->select('
            p.id, p.name, p.description, p.product_type_id, p.provider_id, p.status_id, p.created_at, 
            p.is_san, p.san_base, p.san_max,
            pro.name as provider_name, 
            pts.name as product_type_name, 
            st.name as status_name,
            us.full_name as user_full_name, 
            p.quantity_year_id,
            p.information_document, p.product_category_id
        ');
        $this->db->from('products p');
        $this->db->join('providers pro', 'p.provider_id = pro.id', 'left');
        $this->db->join('product_types pts', 'p.product_type_id = pts.id', 'left');
        $this->db->join('status st', 'p.status_id = st.id', 'left');
        $this->db->join('users us', 'p.user_id = us.id', 'left');
        $this->db->where('p.id', $product_id);
        $query = $this->db->get();

        if($query->num_rows() == 1) {
            $row = $query->custom_row_object(0, 'Products_model');
            $row->id = intval($row->id);
            $row->provider_id = intval($row->provider_id);
            $row->product_type_id = intval($row->product_type_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
            $row->san_base = intval($row->san_base);
            $row->san_max = intval($row->san_max);
            $row->quantity_year_id = intval($row->quantity_year_id);

            return $row;
        } else return FALSE;
    }
    
    public function get_products_by_product_type($product_type_id) {
        $this->db->select('
            p.id, p.name, p.description, p.product_type_id, p.provider_id, p.status_id, p.created_at,
            pro.name as provider_name, 
            pts.name as product_type_name, 
            st.name as status_name,
            us.full_name as user_full_name
        ');
        $this->db->from('products p');
        $this->db->join('providers pro', 'p.provider_id = pro.id', 'left');
        $this->db->join('product_types pts', 'p.product_type_id = pts.id', 'left');
        $this->db->join('status st', 'p.status_id = st.id', 'left');
        $this->db->join('users us', 'p.user_id = us.id', 'left');
        $this->db->where('p.product_type_id', $product_type_id);
        $this->db->where('p.is_san !=', 1);
        $this->db->where('p.status_id !=', 3);
        $query = $this->db->get();

        $rows = $query->custom_result_object('Products_model');

        foreach($rows as $row) {
            $row->id = intval($row->id);
            $row->product_type_id = intval($row->product_type_id);
            $row->created_at = $row->created_at ? strtotime($row->created_at) * 1000 : '';
        }

        return $rows;
    }

    /**
     * Agrega un nuevo producto.
     *
     * @param       array  $product_data
     * @return      bool
     */
    public function add_product($product_data) {
        return $this->db->insert('products', $product_data);
    }

    /**
     * Actualizar un producto.
     *
     * @param       array   $product_data
     * @param       int     $product_id
     * @return      bool
     */
    public function update_product($product_data, $product_id) {
        $this->db->where('id', $product_id);
        $this->db->where('status_id !=', 3);
        return $this->db->update('products', $product_data);
    }

    /**
     * Elimina un producto cambiado su estado a 3.
     *
     * @param       int     $product_id
     * @return      bool
     */
    public function delete_product($product_id) {
        $this->db->where('id', $product_id);
        $this->db->where('status_id !=', 3);
        $this->db->update('products', array('status_id' => 3));

        if ($this->db->affected_rows() > 0) return TRUE;
        else return FALSE;
    }
}
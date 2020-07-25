<?php

use Pusher\Pusher;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_products_PMController
 *
 * @package     Productos
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_products_PMController extends REST_Controller {
	
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

		$this->load->model('Products_model');
		$this->load->model('Product_details_model');
		$this->load->model('Product_san_details_model');
		$this->load->library('form_validation');

        date_default_timezone_set('America/Lima');
        
    }

	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/products/products_view', $data);
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/products/products_add_view');
		}
	}

	public function edit_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/products/products_edit_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/products/products_modal_view');
		}
	}

	public function products_post() {

		$data_ajax = $this->post();

		if(count($data_ajax) > 0):
			$this->form_validation->set_data($data_ajax);
			$this->form_validation->set_rules('provider_id', 'Proveedor', 'required|integer');
			$this->form_validation->set_rules('name', 'Nombre de producto', 'required');
			$this->form_validation->set_rules('description', 'Descripción', 'required');
			$this->form_validation->set_rules('product_type_id', 'Tipo de producto', 'required|integer');
			$this->form_validation->set_rules('quantity_year_id', 'Contiene años', 'required|integer');
			$this->form_validation->set_rules('is_san', 'Contiene SAN', 'integer');
            if($this->post('quantity_year_id') == 1) {
                $this->form_validation->set_rules('price_1', 'Precio dólares', 'required|numeric');
              $this->form_validation->set_rules('price_pen_1', 'Precio soles', 'required|numeric');
			}
			if($this->post('quantity_year_id') == 2 OR $this->post('quantity_year_id') == 3 OR $this->post('quantity_year_id') == 4) {
                $this->form_validation->set_rules('price_1_year', 'Precio dólares (1 año)', 'required|numeric');
        $this->form_validation->set_rules('price_pen_1_year', 'Precio soles (1 año)', 'required|numeric');
			}
			if($this->post('quantity_year_id') == 3 OR $this->post('quantity_year_id') == 4) {
                $this->form_validation->set_rules('price_2_year', 'Precio dólares (2 años)', 'required|numeric');
        $this->form_validation->set_rules('price_pen_2_year', 'Precio soles (2 años)', 'required|numeric');
			}
			if($this->post('quantity_year_id') == 4) {
                $this->form_validation->set_rules('price_3_year', 'Precio dólares (3 años)', 'required|numeric');
        $this->form_validation->set_rules('price_pen_3_year', 'Precio soles (3 años)', 'required|numeric');
			}
			if($this->post('is_san') == 1) {
				$this->form_validation->set_rules('price_1_san', 'Precio dólares SAN (1 año)', 'required|numeric');
        $this->form_validation->set_rules('price_pen_1_san', 'Precio soles SAN (1 año)', 'required|numeric');

				if($this->post('quantity_year_id') == 3 OR $this->post('quantity_year_id') == 4) $this->form_validation->set_rules('price_2_san', 'Precio SAN (2 años)', 'required|numeric');
				$this->form_validation->set_rules('san_base', 'Cant. SAN base', 'required|integer');
                $this->form_validation->set_rules('san_max', 'Cant. SAN máx.', 'required|integer');
			}

			if ($this->form_validation->run() == FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => validation_errors()
					), REST_Controller::HTTP_OK);
			} else {
			    $product_name = $this->post('name');

				$product_data['provider_id']           = $this->post('provider_id');
				$product_data['product_category_id']   = $this->post('product_category_id');
                $product_data['name']                  = $this->post('name');
                $product_data['description']           = $this->post('description');
				$product_data['product_type_id']       = $this->post('product_type_id');
				$product_data['san_base']       = $this->post('san_base');
				$product_data['san_max']       = $this->post('san_max');
				$product_data['is_san']       = $this->post('is_san');
                $product_data['status_id']             = 1;
                $product_data['user_id']               = $this->session->userdata('user_id');
                $product_data['created_at']            = date("Y-m-d H:i:s");
                $product_data['updated_at']            = date("Y-m-d H:i:s");
                $product_data['quantity_year_id'] = $this->post('quantity_year_id');


				if(isset($_FILES['information'])) { // Si sube ficha técnica
          $config['upload_path'] = './product_docs/';
          $config['allowed_types'] = 'pdf';
          $config['encrypt_name'] = TRUE;

              $this->load->library('upload', $config);
          
					if ( ! $this->upload->do_upload('information')) {
		                $this->response(
							array(
								'err' => TRUE,
								'status' => 'error',
								'message' => $this->upload->display_errors()
							), REST_Controller::HTTP_OK);

		                return;
		            } else {
		                $product_data['information_document'] = $this->upload->data('file_name');
		            }
		        } // FIN Si sube ficha técnica
        
		        $this->db->trans_start();

                $this->Products_model->add_product($product_data);

				$product_id = $this->db->insert_id();

				$quantity_year_id = $this->post('quantity_year_id');
				$is_san = $this->post('is_san');
				$data_product_detail = array();
        
        //Si se agregarán SAN
				if($is_san == 1) { 
					if($quantity_year_id == 2 OR $quantity_year_id == 3 OR $quantity_year_id == 4) { // SI ES 1 AÑO
						$product_san_detail_data = array(
							'price' => $this->post('price_1_san'),
              'price_pen' => $this->post('price_pen_1_san'),
							'quantity_year_id' => 2,
							'product_id' => $product_id
						);
						$this->Product_san_details_model->add_product_san_detail($product_san_detail_data);
					}

					if($quantity_year_id == 3 OR $quantity_year_id == 4) { // SI ES 2 AÑOS
						$product_san_detail_data = array(
							'price' => $this->post('price_2_san'),
              'price_pen' => $this->post('price_pen_2_san'),
							'quantity_year_id' => 3,
							'product_id' => $product_id
						);
						$this->Product_san_details_model->add_product_san_detail($product_san_detail_data);
					}							
				} // Fin agregar SAN

        // Precio normal - sin años
				if($quantity_year_id == 1) {
					$data = array(
						'product_id' => $product_id,
						'price' => $this->post('price_1'),
            'price_pen' => $this->post('price_pen_1'),
						'quantity_year_id' => 1
					);
					$this->Product_details_model->add_product_detail($data);
				} 
        // Precio 1 año
				if($quantity_year_id == 2 OR $quantity_year_id == 3 OR $quantity_year_id == 4) {
					$data = array(
						'product_id' => $product_id,
						'price' => $this->post('price_1_year'),
            'price_pen' => $this->post('price_pen_1_year'),
						'quantity_year_id' => 2
					);
					$this->Product_details_model->add_product_detail($data);
				} 
        // Precio 2 años
				if($quantity_year_id == 3 OR $quantity_year_id == 4) {
					$data = array(
						'product_id' => $product_id,
						'price' => $this->post('price_2_year'),
            'price_pen' => $this->post('price_pen_2_year'),
						'quantity_year_id' => 3
					);
					$this->Product_details_model->add_product_detail($data);
				} 
        // Precio 3 años
				if($quantity_year_id == 4) {
					$data = array(
						'product_id' => $product_id,
						'price' => $this->post('price_3_year'),
            'price_pen' => $this->post('price_pen_3_year'),
						'quantity_year_id' => 4
					);
					$this->Product_details_model->add_product_detail($data);
				}

                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE) {
                    $this->response(
                        array(
                            'err' => TRUE,
                            'status' => 'error',
                            'message' => 'Ha ocurrido un error'
                        ), REST_Controller::HTTP_OK);
                } else {
                    $notif = array(
                        'created_at' => date("Y-m-d H:i:s"),
                        'user_id' => $this->session->userdata('user_id'),
                        'subject' => 'Un producto ha sido creado',
                        'description' => "El producto $product_name ha sido creado correctamente.",
                        'icon' => 'shopping-bag',
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
                  return;
                }

			}
		else:
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Todos los campos son requeridos'					
				), REST_Controller::HTTP_OK);
		endif;
	}

	public function products_put($id = NULL) {

		$product_data = $this->put();
        $product_details = $this->put('details');
        $product_san_details = $this->put('san_details');

		$this->form_validation->set_data($product_data);
		$this->form_validation->set_rules('provider_id', 'Proveedor', 'required|integer');
		$this->form_validation->set_rules('name', 'Nombre de producto', 'required');
		$this->form_validation->set_rules('description', 'Descripción', 'required');
		$this->form_validation->set_rules('product_type_id', 'Tipo de producto', 'required|integer');
		// $this->form_validation->set_rules('details[0][price]', 'Precio 1', 'required');
		// $this->form_validation->set_rules('details[1][price]', 'Precio 1', 'required');
		// $this->form_validation->set_rules('details[2][price]', 'Precio 1', 'required');
		// $this->form_validation->set_rules('details[3][price]', 'Precio 1', 'required');
		// $this->form_validation->set_rules('details[4][price]', 'Precio 1', 'required');
		// $this->form_validation->set_rules('details[5][price]', 'Precio 1', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => validation_errors()
				), REST_Controller::HTTP_OK);
    	} else {
            $product_name = $this->put('name');

			$data['provider_id']           = $this->put('provider_id');
			$data['product_category_id']   = $this->put('product_category_id');
            $data['name']                  = $this->put('name');
            $data['description']           = $this->put('description');
			$data['product_type_id']       = $this->put('product_type_id');
			$data['san_base']       = $this->put('san_base');
			$data['san_max']       = $this->put('san_max');
            $data['updated_at']            = date("Y-m-d H:i:s");

            $this->db->trans_start(); // INICIO DE TRANSACCIÓN

			$this->Products_model->update_product($data, $id);

            foreach($product_details as $product_detail) {
            	$product_detail_id = $product_detail['id'];
                $product_detail_data = array(
                    'price' => $product_detail['price'],
                  'price_pen' => $product_detail['price_pen']
                );
                $this->Product_details_model->update_product_detail($product_detail_data, $product_detail_id);
            }

            foreach($product_san_details as $product_san_detail) {
            	$product_san_detail_id = $product_san_detail['id'];
                $product_san_detail_data = array(
                    'price' => $product_san_detail['price'],
                  'price_pen' => $product_san_detail['price_pen']
                );
                $this->Product_san_details_model->update_product_san_detail($product_san_detail_data, $product_san_detail_id);
            }

            $this->db->trans_complete(); // FINAL DE TRANSACCIÓN

            if($this->db->trans_status() === FALSE ) {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Error al actualizar'
                    ), REST_Controller::HTTP_OK);
            } else {
                $notif = array(
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $this->session->userdata('user_id'),
                    'subject' => 'Un producto ha sido editado',
                    'description' => "El producto $product_name ha sido editado correctamente.",
                    'icon' => 'shopping-bag',
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
            }
		}
	}

	public function products_delete($product_id = NULL) {
		if($this->Products_model->delete_product($product_id)) {
            $product = $this->Products_model->search_product($product_id);

            $product_name = $product->name;

            $notif = array(
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'subject' => 'Un producto ha sido eliminado',
                'description' => "El producto $product_name ha sido eliminado correctamente.",
                'icon' => 'shopping-bag',
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
					'message' => 'Error al eliminar el producto'
				), REST_Controller::HTTP_OK);
		}
	}

	public function products_get($product_id = NULL) {
		if($product_id != NULL):
			$product = $this->Products_model->get_product($product_id);
			// $product->quantity_year_id = $this->Product_details_model->get_qty_years_by_product($product_id);

			// $product->price_1_pen = 123;
			// $product->price_1_usd = 124;
			// $product->price_1_year_pen = 125;
			// $product->price_1_year_usd = 126;
			// $product->price_2_year_pen = 127;
			// $product->price_2_year_usd = 128;
			// $product->price_3_year_pen = 129;
			// $product->price_3_year_usd = 1288;
			// $product->price_san_pen = 12888;
			// $product->price_san_usd = 1299;

			if($product) {

				$this->response($product, REST_Controller::HTTP_OK);
			} else {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Producto no existe'
					), REST_Controller::HTTP_OK);
			}
		else:
			$start = $this->get('start');
			$length = $this->get('length');
			$draw = $this->get('draw');
			$order = $this->get('order');
			$order_column = (int) $order[0]['column'] + 1;
			$order_dir = $order[0]["dir"];
			$search = $this->get("search");
			$search_value = $search["value"];
			$provider_s = $this->get('provider_s');
			$product_type_s = $this->get('product_type_s');
			$startRec_s = $this->get('startRec_s');
			$endRec = $this->get('endRec');

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Products_model->get_all($provider_s, $product_type_s, $startRec_s, $endRec, $start, $length)),
				'recordsFiltered' => count($this->Products_model->get_all($provider_s, $product_type_s, $startRec_s, $endRec, NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Products_model->get_all($provider_s, $product_type_s, $startRec_s, $endRec, $start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
		endif;
	}

	public function products_by_product_type_get($product_type_id = NULL) {
		// if($product_id != NULL):
			$this->response(
				$this->Products_model->get_products_by_product_type($product_type_id), 
				REST_Controller::HTTP_OK);
		// else:

		// endif;
    }

    public function information_document_post($product_id = NULL) {
    	$information = $this->post('information_document'); 

    	if($information != '') {
    		unlink('./product_docs/' . $information);
    	}

    	$config['upload_path'] = './product_docs/';
		$config['allowed_types'] = 'pdf';
		$config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

		if(isset($_FILES['new_information'])) {
			if ( ! $this->upload->do_upload('new_information')) {
                $this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => $this->upload->display_errors()
					), REST_Controller::HTTP_OK);

                return;
            } else {
                $product_data['information_document'] = $this->upload->data('file_name');
                $product_data['updated_at']            = date("Y-m-d H:i:s");

                $this->Products_model->update_product($product_data, $product_id);

                $this->response(
					array(
						'err' => FALSE,
						'status' => 'success',
						'message' => 'Subido correctamente'
					), REST_Controller::HTTP_OK);
            }
        } else {
        	$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al intentar acceder'
				), REST_Controller::HTTP_OK);
        }
    }

	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }

}

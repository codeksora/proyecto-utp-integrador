<?php 
use Dompdf\Dompdf;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/**
 * Admin_quotations_PMController
 * 
 * Permite gestionar las cotizaciones, agregar, editar o eliminar.
 *
 * @package     Cotizaciones
 * @author      Carlos Chirito
 * @link        https://sisps.perusecurity.pe
 */

class Admin_quotations_PMController extends REST_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();
        
        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));
		
		$this->load->library('form_validation');
		$this->load->model('Contacts_model');
		$this->load->model('Orders_model');
		$this->load->model('Quotations_model');
		$this->load->model('Quotation_products_model');
		$this->load->model('Quotation_product_details_model');
		$this->load->model('Quotation_product_san_details_model');
		$this->load->model('Products_model');
		$this->load->model('Customers_model');
		$this->load->model('Currency_types_model');
		$this->load->model('Users_model');

		date_default_timezone_set('America/Lima');
	}

	public function index_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations/quotations_view');
		}
	}

	public function add_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations/quotations_add_view');
		}
	}

	public function modal_view_get() {
		if(!isset($this->privileges) OR $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations/quotations_modal_view');
		}
	}

	public function validate_view_get() {
		if(!isset($this->privileges) OR $this->privileges->update == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations/quotations_validate_view');
		}
	}

	public function modal_add_product_view_get() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/quotations/quotations_modal_add_product_view');
		}
	}

	public function quotations_dt_get($id = NULL) {
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
			'recordsTotal' => count($this->Quotations_model->get_all_dt($start, $length)),
			'recordsFiltered' => count($this->Quotations_model->get_all_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
			'data' => $this->Quotations_model->get_all_dt($start, $length, $order_column, $order_dir, $search_value)
		);
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function quotations_get($id = NULL) {
		if($id != NULL):
            if($this->Quotations_model->search_quotation($id)) {
                $this->response(
                	$this->Quotations_model->get_quotation($id), 
                	REST_Controller::HTTP_OK);
            } else {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Esta orden no existe'
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

			$data = array(
				'draw' => $draw,
				'recordsTotal' => count($this->Quotations_model->get_all_dt($start, $length)),
				'recordsFiltered' => count($this->Quotations_model->get_all_dt(NULL, NULL, $order_column, $order_dir, $search_value)),
				'data' => $this->Quotations_model->get_all_dt($start, $length, $order_column, $order_dir, $search_value)
			);
			$this->response($data, REST_Controller::HTTP_OK);
        endif;
	}

	public function quotations_post() {
		if(!isset($this->privileges) OR $this->privileges->insert == 0):
			$this->response(array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Acceso no permitido'
				), REST_Controller::HTTP_UNAUTHORIZED);
		else:
			// $this->load->helper('fechaes_helper');
			
			$products = $this->post('data_products');
			$currency_type_id = $this->post('currency_type_id');
			$customer_id = $this->post('customer_id');
			$contact_id = $this->post('contact_id');
			$observation = $this->post('observation');
			$order_type_id = $this->post('order_type_id');
			$quotation_template_id = $this->post('quotation_template_id');
			$user_id = $this->session->userdata('user_id');
      $credit_time_id = $this->post('credit_time_id');
			$subtotal = $this->post('subtotal');
			$tax = $this->post('tax');
			$total = $this->post('total');


			// $customer = $this->Customers_model->get_customer($customer_id);
			// $currency_type = $this->Currency_types_model->get_currency_type($currency_type_id);
			// $user = $this->Users_model->get_user($user_id);
			// $contact = $this->Contacts_model->get_contact($contact_id);

			$quotation_data['customer_id'] = $customer_id;
			$quotation_data['contact_id'] = $contact_id;
			$quotation_data['currency_type_id'] = $currency_type_id;
			$quotation_data['observation'] = $observation;
			$quotation_data['subtotal'] = $subtotal; 
			$quotation_data['tax'] = $tax;
			$quotation_data['total'] = $total;
			$quotation_data['user_id'] = $user_id;
			$quotation_data['created_at'] = date("Y-m-d H:i:s");
			$quotation_data['updated_at'] = date("Y-m-d H:i:s");
			$quotation_data['quotation_template_id'] = $quotation_template_id;
      $quotation_data['credit_time_id'] = $credit_time_id;
			$quotation_data['status_id'] = 4;

			$i = 0;
     foreach ($products as $product) {
          $i += $product['discount'];
			}
			
    if($i == 0 ) $quotation_data['status_id'] = 5; 			

			if($this->Quotations_model->add_quotation($quotation_data, $products) === FALSE) {
				$this->response(
					array(
						'err' => TRUE,
						'status' => 'error',
						'message' => 'Error al agregar la cotización'
					), REST_Controller::HTTP_OK);
			} else {

				$this->response(
					array(
						'err' => FALSE,
						'status' => 'success',
						'message' => 'Agregado correctamente'
					), REST_Controller::HTTP_OK);
			}
		endif;
	}

	public function quotations_put($id = NULL) {
		if($id != NULL):
			if($this->Quotations_model->search_quotation($id)) {

				$order_type_id = $this->put('order_type_id');
				$customer_order_number = $this->put('customer_order_number');
				$order_date = date("Y-m-d H:i:s", strtotime($this->put('order_date')));
				$reception_date = date("Y-m-d H:i:s", strtotime($this->put('reception_date')));
				$expiration_date = date("Y-m-d H:i:s", strtotime($this->put('expiration_date')));
				$observation = $this->put('observation');
				$quotation_id = $this->put('id');

				$quotation_data['status_id'] = 1;
				$this->Quotations_model->update_quotation($quotation_data, $id);

				$order_data['order_type_id'] = $order_type_id;
				$order_data['customer_order_number'] = $customer_order_number;
				$order_data['status_id'] = 1;
				$order_data['reception_date'] = $reception_date;
				$order_data['order_date'] = $order_date;
				$order_data['expiration_date'] = $expiration_date;
				$order_data['observation'] = $observation;
				$order_data['created_at'] = date("Y-m-d H:i:s");
				$order_data['updated_at'] = date("Y-m-d H:i:s");
				$order_data['user_id'] = $this->session->userdata('user_id');
				$order_data['quotation_id'] = $quotation_id;

				$this->Orders_model->add_order($order_data);
				$order_id = $this->db->insert_id();

				$order_number = "ORD-".str_pad( $order_id, '8', '0', STR_PAD_LEFT);
				$data['order_number'] = $order_number;

				$this->Orders_model->update_order($data, $order_id);


                $this->response(
					array(
						'err' => FALSE,
						'status' => 'success',
						'message' => 'Validado correctamente, orden creada'
					), REST_Controller::HTTP_OK);
            } else {
                $this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Esta cotización no existe'
                    ), REST_Controller::HTTP_OK);
            }
		else:
			
			$this->response(
                    array(
                        'err' => TRUE,
                        'status' => 'error',
                        'message' => 'Acceso no permitido'
                    ), REST_Controller::HTTP_OK);
		endif;
	}

	public function quotations_delete($order_id = NULL) {
		if($this->Quotations_model->disable_quotation($order_id)) {
			$this->response(
				array(
					'err' => FALSE,
					'status' => 'success',
					'message' => 'Deshabilitado correctamente'
				), REST_Controller::HTTP_OK);
		} else {
			$this->response(
				array(
					'err' => TRUE,
					'status' => 'error',
					'message' => 'Error al deshabilitar la cotización'
				), REST_Controller::HTTP_OK);
		}
	}

	public function quotations_document_get($quotation_id = NULL) {
		// Helpers
		$this->load->helper('fechaes_helper');

		$quotation_id = intval($quotation_id);

		$quotation = $this->Quotations_model->get_quotation($quotation_id);
		$products = $this->Quotation_products_model->get_all_by_quotation($quotation_id);

		$quotation_number = $quotation->quotation_number;
		$quotation_template_id = $quotation->quotation_template_id;

		$data = array(
			'quotation' => $quotation,
			'products' => $products
		);

		switch($quotation_template_id) {
			case 1:
			case 2:
				ob_start();
				$this->load->view('admin/templates/quotation_templates/quotation_template_1_view', $data);
				$content = ob_get_clean();
				break;
			case 3:
			case 4:
				ob_start();
				$this->load->view('admin/templates/quotation_templates/quotation_template_2_view', $data);
				$content = ob_get_clean();
				break;
			case 5:
			case 6:
				ob_start();
				$this->load->view('admin/templates/quotation_templates/quotation_template_3_view', $data);
				$content = ob_get_clean();
				break;
			case 7:
			case 8:
				ob_start();
				$this->load->view('admin/templates/quotation_templates/quotation_template_4_view', $data);
				$content = ob_get_clean();
				break;
			default:
				$content = 'Error al generar PDF';
		}

		// Crear PDF
		$options = array(
			'enable_remote' => true // Activa URL's externas
		);
	
		$dompdf = new Dompdf($options);
	
		$dompdf->loadHtml($content);
	
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4');
		// echo $content;
		// Render the HTML as PDF
		$dompdf->render();
		// echo $content;
		// Output the generated PDF to Browser
		// $dompdf->stream();
		$dompdf->stream("$quotation_number.pdf", array("Attachment" => 0));
		// $pdf_gen = $dompdf->output();
		// $dompdf->output();
	}

	public function privileges_get() {
        $this->response(
            $this->privileges,
            REST_Controller::HTTP_OK);
    }
}
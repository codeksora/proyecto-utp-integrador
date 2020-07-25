<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_orders_intranet_PMController extends REST_Controller {

    private $url;
	private $privileges;
    private $api_key;
    private $api_url;

	public function __construct() {
        parent::__construct();

        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect();

        $this->load->model('Backend_model');
        $this->url =  $this->uri->segment(1) . '/' . $this->uri->segment(2);

        $infomenu = $this->Backend_model->get_id($this->url);
        $this->privileges = $this->Backend_model->get_privileges($infomenu->id, $this->session->userdata('role_id'));

		$this->load->model('Orders_model');
        $this->load->library('form_validation');
        $this->load->library('api_perusecurity');
    }

  	public function index_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$data = array(
				'privileges' => $this->privileges
			);
			$this->load->view('admin/templates/orders_intranet/orders_intranet_view', $data);
		}
	}

  	public function invoice_view_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders_intranet/orders_intranet_invoice_view');
		}
    }
    
    public function bill_view_get() {
		if(!isset($this->privileges) || $this->privileges->read == 0) {
			$this->load->view('admin/templates/errors/not_privilege');
		} else {
			$this->load->view('admin/templates/orders_intranet/orders_intranet_bill_view');
		}
	}

	public function orders_intranet_get($id = NULL) {
        if($id != NULL):
            $order = $this->api_perusecurity->get_order($id);
            
            $company = new \Sunat\Sunat( true, true );

            $ruc = $order->nro;

            $search = $company->search($ruc);

            $customer = '';
            $perusecurity = '';

            if( $search->success == true ) {
                $customer = $search->result;
                $customer->country = 'Perú';
            }
            //RUC PERUSECURITY
            $search2 = $company->search('20601709652');

            if( $search2->success == true ) {
                $perusecurity = $search2->result;
            }

            $resp_data = array(
                'customer' => $customer,
                'order' => $order,
                'perusecurity' => $perusecurity
            );
            
            $this->response(
                $resp_data,
                REST_Controller::HTTP_OK);
		else:
			$data['start'] = $this->get('start');
			$data['length'] = $this->get('length');
            $data['draw'] = $this->get('draw');
            
			$order = $this->get('order');
			$data['order_column'] = $order[0]["column"];
            $data['order_dir'] = $order[0]["dir"];
            
			$search = $this->get("search");
            $data['search_value'] = urlencode($search["value"]);

            $orders = $this->api_perusecurity->get_orders($data);

            $this->response(
                $orders,
                REST_Controller::HTTP_OK);
		endif;

    }
    
    public function order_products_intranet_get($id = NULL) {
        $order_products = $this->api_perusecurity->get_order_products($id);
        
        $this->response(
			$order_products,
			REST_Controller::HTTP_OK);
    }

    public function orders_filter_get() {
		$startRec = $this->get('startRec');
		$endRec = $this->get('endRec');
		$customer = $this->get('customer');
		$fact = $this->get('n_fact');

		$this->response(
			$this->Orders_model->get_all_by_filter($customer, $fact, $startRec, $endRec),
			REST_Controller::HTTP_OK);
	}
}


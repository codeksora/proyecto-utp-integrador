<?php
// use Spipu\Html2Pdf\Html2Pdf;
use Dompdf\Dompdf;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin_dashboard_PMController extends REST_Controller {

	public function __construct() {
		parent::__construct();

    $this->load->library('session');
		if($this->session->userdata('logged_in') == FALSE) redirect();

		$this->load->model('Backend_model');

		$this->all_privileges = $this->Backend_model->get_all_privileges($this->session->userdata('role_id'));
	}


	public function index_get() {
		$data = array(
			'privileges' => $this->all_privileges
		);

		$this->load->view('admin/templates/dashboard/dashboard_view', $data);
	}

	public function pdf_html_get() {
		$this->load->view('admin/templates/pdf/quotation_pdf_view');
	}

	public function pdf_get() {

	$options = array(
		'enable_remote' => true
	);

	$dompdf = new Dompdf($options);

	// switch($product_type_id) {
	// 	case 1:
	// 		break;
	// }

	ob_start();
	$this->load->view('admin/templates/pdf/quotation_pdf_view');
	$content = ob_get_clean();

	$dompdf->loadHtml($content);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4');
	// echo $content;
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	// VER
	// $dompdf->stream("mipdfss.pdf", array("Attachment" => 0));

	// DESCARGAR
	$dompdf->stream();
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_images_PMController extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged_in') == FALSE) redirect('pm-login');

        $this->load->model('Images_model');
    }

	public function index() {
		$this->load->view('admin/templates/images/images_view');
	}

	public function add_view() {
		$this->load->view('admin/templates/images/images_add_view');
	}

	public function edit_view() {
		$this->load->view('admin/templates/images/images_edit_view');
	}

	public function all_images() {
		echo json_encode($this->Images_model->get_all());
	}

	public function images($page_link) {
		
		$count = $this->Categories_model->count_all();

		$limit_per_page = 10;
		$total_records = $this->Categories_model->count_all();
		
		$page = ($page_link) ? ($page_link - 1) : 0;

		$arr = $this->Categories_model->get_current_page_records($limit_per_page, $page * $limit_per_page);

		$total_pages = ceil( $total_records / $limit_per_page );

		$arrPages = array();
		for ($i=0; $i < $total_pages; $i++) { 
			array_push($arrPages, $i + 1);
		}

		$data['err'] = false;
		$data['data_categories'] = $arr;
		$data['total_records'] = $total_records;
		$data['pag_actual'] = $page_link;
		$data['total_pages'] = $total_pages;
		$data['next_page'] = $page_link + 1;
		$data['prev_page'] = $page_link - 1;
		$data['pages'] = $arrPages;

		echo json_encode($data);
	}

	public function image($id) {
		echo json_encode($this->Images_model->get_category($id));
	}

	public function add() {
		if(isset($_FILES['data'])) { 
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['encrypt_name'] = TRUE;
			$config['max_size'] = 2000;
	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			$data_resp['err'] = true;

			if ( ! $this->upload->do_upload('data')) {
				$data_resp['msg'] = $this->upload->display_errors('','');
				
			} else {
				//unlink('./frontend/dist/img/imports/' . $this->input->post('img'));
				
				$image_up = $this->upload->data();
				if(isset($image_up[0]['file_name'])) {
					for ($i = 0; $i < count($image_up); $i++) {
						 $data['name'] = $image_up[$i]['file_name'];
						 
						 $this->Images_model->add_image($data);
					}
					
				} else {
					$data['name'] = $image_up['file_name'];
					
					$this->Images_model->add_image($data);
				}
				$data_resp['err'] = false;
			}

			echo json_encode($data_resp);
		} else {
			show_404();
		}
	}

	public function update() {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$request =  (array) $request;

		if($postdata) {
			$id = $request["id"];
	
			$data['name'] = $request["name"];
	
			$this->Categories_model->update_category($data, $id);
	
			$data_resp['err'] = false;
	
			echo json_encode($data_resp);

		} else {
			show_404();
		}

	}

	public function delete() {
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$request =  (array) $request;

		if($postdata) {
			$id = $request["id"];
	
			$this->Categories_model->delete_category($id);
	
			$data_resp['err'] = false;
	
			echo json_encode($data_resp);

		} else {
			show_404();
		}

	}

}

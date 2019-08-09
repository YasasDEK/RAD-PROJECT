<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp_regcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Emp_regmodel');
		$this->load->helper('form');
	}

	function index(){
		$data['error'] = '';
		$this->load->view('defaultAdminHeader');
		$this->load->view('Emp_regview',$data);
	}

	public function add(){
		$data['error'] = '';
		$this->load->view('defaultAdminHeader');
		$this->load->view('Emp_regview',$data);
	}

	public function submit(){
		

		$config = array(
			'upload_path' => "./assets/img/team/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => TRUE,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'max_height' => "768",
			'max_width' => "1024"
		);
		$this->load->library('upload', $config);

		if($this->upload->do_upload('empPhoto')){
			$data = array('upload_data' => $this->upload->data());
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			echo $this->upload->display_errors();
		}

		echo $_FILES['empPhoto']['name'];
		echo $_FILES['empPhoto']['type'];
		echo $_FILES['empPhoto']['size'];




		$field = array(
			'empNIC'=>$this->input->post('empNIC'),
			'emPassword'=>$this->input->post('emPassword'),
			'empPhoto'=>$_FILES['empPhoto']['name'],
		    'empName'=>$this->input->post('empName'),
			'empAddress'=>$this->input->post('empAddress'),
			'empTelephone'=>$this->input->post('empTelephone'),
			'empRights'=>1,
			'empStatus'=>1,
			
		);


			
		$result = $this->Emp_regmodel->submit($field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record added successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to add record');
		}
		$this->index();
	}

}

?>

	
	

	

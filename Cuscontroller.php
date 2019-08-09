<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuscontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Cusmodel');
	}

	function index(){
		$data['blogs'] = $this->Cusmodel->getBlog();
		$this->load->view('Customerheader');
		$this->load->view('Cusview', $data);
		$this->load->view('Customerfooter');
	}

	function homepagedriver(){
		$data['blogs'] = $this->Cusmodel->getBlog();
		$this->load->view('Defaultheader');
		$this->load->view('Cusview', $data);
		$this->load->view('Customerfooter');
	}

	public function submit(){
		$field = array(
			'drvFirstName'=>$this->input->post('drvFirstName'),
			'drvLasrName'=>$this->input->post('drvLastName'),
			'drvNIC'=>$this->input->post('drvNIC'),
			'drvEmail'=>$this->input->post('drvEmail'),
			'drvLicense'=>$this->input->post('drvLicense'),
			'drvDOB'=>$this->input->post('drvDOB'),
			'drvimg'=>$this->input->post('drvimg'),
			'drvMobile'=>$this->input->post('drvMobile'),
			'drvLAND'=>$this->input->post('drvLAND'),
			'empNIC'=>$this->input->post('empNIC')
			);

		$result = $this->Adminmodel->submit($field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record added successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to add record');
		}
		$this->index();
	}

	
	
}
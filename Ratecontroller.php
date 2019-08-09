<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ratecontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Ratemodel');
	}

	function index(){
		$data['blogs'] = $this->Ratemodel->getBlog();
		$this->load->view('Rateview', $data);
	}


	public function submit(){
		$field = array(
			'drvFirstName'=>$this->input->post('drvFirstName'),
			'drvLasrName'=>$this->input->post('drvLastName'),
			'drvNIC'=>$this->input->post('drvNIC'),
			'drvEmail'=>$this->input->post('drvEmail'),
			'drvLicense'=>$this->input->post('drvLicense'),
			'drvDOB'=>$this->input->post('drvDOB'),
			'drvLicensePhoto'=>$this->input->post('drvLicensePhoto'),
			'drvPhoto'=>$this->input->post('drvPhoto'),
			'drvMobile'=>$this->input->post('drvMobile'),
			'drvLAND'=>$this->input->post('drvLAND'),
			'empNIC'=>$this->input->post('empNIC')
			);
		$result = $this->Ratemodel->submit($drvNIC,$field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record added successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to add record');
		}
		$this->index();
	}

	
	public function edit($drvNIC){
		$data['blog'] = $this->Ratemodel->getBlogBydrvNIC($drvNIC);
		$this->load->view('Adminedit', $data);
	}

	public function update(){
		$drvNIC = $this->input->post('drvNIC');
		$field = array(
			'drvFirstName'=>$this->input->post('drvFirstName'),
			'drvLastName'=>$this->input->post('drvLastName'),
			'drvNIC'=>$this->input->post('drvNIC'),
			'drvEmail'=>$this->input->post('drvEmail'),
			'drvLicense'=>$this->input->post('drvLicense'),
			'drvDOB'=>$this->input->post('drvDOB'),
			'drvLicensePhoto'=>$this->input->post('drvLicensePhoto'),
			'drvPhoto'=>$this->input->post('drvPhoto'),
			'drvMobile'=>$this->input->post('drvMobile'),
			'drvLAND'=>$this->input->post('drvLAND'),
			'empNIC'=>$this->input->post('empNIC')
			);

		$result = $this->Adminmodel->update($drvNIC,$field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record updated successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to update record');
		}
		$this->index();
		
	}

	public function delete($drvNIC){
		$result = $this->Adminmodel->delete($drvNIC);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record deleted successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to delete record');
		}
		redirect('Admincontroller');
	}

}
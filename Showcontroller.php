<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  

class Showcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Showmodel');
		$this->load->helper('form');
	}

	public function index(){
		$this->load->view('driverHeader');
		$this->load->view('Showview');
	}

	public function edit($drvNIC){
		$data['blog'] = $this->Showmodel->getBlogBydrvNIC($drvNIC);
		$this->load->view('driverHeader');
		$this->load->view('Showedit', $data);
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
			'drvimg'=>$this->input->post('drvimg'),
			'drvMobile'=>$this->input->post('drvMobile'),
			'drvLAND'=>$this->input->post('drvLAND'),
			);

		$result = $this->Showmodel->update($drvNIC,$field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record updated successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to update record');
		}
		redirect('Logcontroller');
	} 
      
	public function trips($drvNIC){
		$data['blogs'] = $this->Showmodel->trips($drvNIC);
		$this->load->view('driverHeader');
		$this->load->view('Drvtrips', $data);
	}    

	public function statUpdate($resID,$drvNIC){
		$this->Showmodel->statUpdate($resID);
		$this->load->model('Logmodel');
		$data['blogs'] = $this->Logmodel->getBlog($drvNIC);
					$this->load->view("driverHeader");
					$this->load->view('Showview', $data);
		
	}
 }  
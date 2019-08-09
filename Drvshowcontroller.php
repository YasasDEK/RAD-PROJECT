<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  

class Drvshowcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Drvshowmodel');
		$this->load->helper('form');
	}

	public function index(){
		$this->load->view('Drvshowview');
	}

	public function edit($drvNIC){
		$data['blog'] = $this->Drvshowmodel->getBlogBydrvNIC($drvNIC);
		$this->load->view('Drvshowedit', $data);
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

		$result = $this->Drvshowmodel->update($drvNIC,$field);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record updated successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to update record');
		}
		redirect('Logcontroller');
	} 
      
    
 }  
<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  

class Emp_showcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Emp_showmodel');
		$this->load->helper('form');
	}

	public function index(){
		$this->load->view('defaultAdminHeader');
		$this->load->view('Emp_showview');
	} 
	public function edit($empNIC){
		$this->load->model('Emp_showmodel');
		$data['data']=$this->Emp_showmodel->getdbByNic($empNIC);
		//$this->load->view('layout/header');
		$this->load->view('defaultAdminHeader');
	    $this->load->view('Emp_editview',$data);
	    
	}
	

	public function update($id){
		$this->load->model('Emp_showmodel');
		$result['blog']=$this->Emp_showmodel->get_data($id);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record updated successfully');
		}
		else{
			$this->session->set_flashdata('error_msg', 'Faill to update record');
		}
		$this->load->view('defaultAdminHeader');
		$this->load->view('Emp_editview',$result);
		echo $id;
		//redirect(base_url('index.php/Crud/index'));
	}


	public function updateDB($id){
		echo "hi";
		$this->load->model('Emp_showmodel');

		$config = array(
			'upload_path' => "./assets/img/team/",
			'allowed_types' => "gif|jpg|png|jpeg|pdf",
			'overwrite' => TRUE
			//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			//'max_height' => "768",
			//'max_width' => "1024"
		);
		$this->load->library('upload', $config);

		if($this->upload->do_upload('empPhoto')){
			$data = array('upload_data' => $this->upload->data());
		}
		else{
			$error = array('error' => $this->upload->display_errors());
			echo $this->upload->display_errors();
		}
		
		echo $_POST['emPassword'];
		$field = array(
			'emPassword'=> $this->input->post('emPassword'),
			'empPhoto'=> $_FILES['empPhoto']['name'],
			'empName'=> $this->input->post('empName'),
			'empAddress'=> $this->input->post('empAddress'),
			'empTelephone'=> $this->input->post('empTelephone'),
			'empRights'=> $this->input->post('empRights'),
			'empStatus'=> $this->input->post('empStatus')
	   );
	   $this->Emp_showmodel->update($id,$field);
		$this->load->model('Emp_logmodel'); 
		$data['blogs'] = $this->Emp_logmodel->getBlog($id);
		$this->load->view('defaultAdminHeader');
		$this->load->view('Emp_showview', $data);
	}
	public function delete($empNIC){
		$this->load->model('Emp_showmodel');
		$result= $this->Emp_showmodel->delete($empNIC);
		if($result){
			$this->session->set_flashdata('success_msg', 'Record deleted successfully');
		}
		else{
			$this->session->set_flashdata('error_msg', 'Faill to delete record');
		}
		redirect(base_url('index.php/Emp_logcontroller'));
	}
      
    
 }  
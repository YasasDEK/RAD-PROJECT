<?php
Class TypeController extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
	}
	public function displayData(){
		$this->load->database();
		$this->load->model('TypeModel');
		$data['records']=$this->TypeModel->query();
		$this->load->view('defaultAdminHeader');
		$this->load->view('DisplayTypeView',$data);
	}
	public function customerDisplayData(){
		$this->load->database();
		$this->load->model('TypeModel');
		$data['records']=$this->TypeModel->query();
		$this->load->view('Defaultheader');
		$this->load->view('custTypeView',$data);
	}
	public function insert(){
		//$this->load->database();
		//$this->load->helper('url');
		$this->load->view('defaultAdminHeader');
		$this->load->view('InsertTypeView');
		
	}
	public function dataSend(){
		
			$img_path="";
			$config['upload_path']='./Uploads/';
			$config['allowed_types']='jpg|png|jpeg';
			$config['max_size']='4096000';
			$config['max_width']='4024';
			$config['max_height']='1068';
			$this->load->library('upload',$config);
			if(!$this->upload->do_upload('photo')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
			else{
				$file_name=$this->upload->data('file_name');
				$img_path='Uploads/'.$file_name;
			}
			$data = array(
				'tyName'=>$this->input->post('name'),
				'tyPassenger'=>$this->input->post('passenger'),
				'tyDRate'=>$this->input->post('dRate'),
				'tyWParcent'=>$this->input->post('mRate'),
				'tyMpercent'=>$this->input->post('wRate'),
				'tyDescription'=>$this->input->post('description'),
				'tyPhoto'=>$img_path
                
            );
			$this->load->model('TypeModel');
			if($this->TypeModel->existingType($data['tyName'])){
				$this->load->model('TypeModel');
				$this->TypeModel->TypeInsert($data);
				echo "<script type='text/javascript'>alert('Successfully Inserted');</script>";
			}
			else{
				echo "<script type='text/javascript'>alert('Type already exist');</script>";
			}
			
			$this->displayData();
		
	}
	public function deleteData(){		
		$this->load->model('TypeModel');
		$this->TypeModel->TypeDelete($this->input->post('id'));
		$this->displayData();
	}
	public function updateDataSelect(){
		$this->load->model('TypeModel');
		$data['records']=$this->TypeModel->TypeupdateSelect($this->input->post('id'));
		$this->load->view('defaultAdminHeader');
		$this->load->view('UpdateTypeView',$data);
	}
	public function updateData(){
		$this->load->model('TypeModel');
		if(!empty($this->input->post('name'))){
			$data=array(
			'tyName'=>$this->input->post('name')
		);
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('passenger'))){
			$data=array(
			'tyPassenger'=>$this->input->post('passenger')
		); 
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('dRate'))){
				$data=array(
			'tyDRate'=>$this->input->post('dRate')
		);
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('mRate'))){
				$data=array(
			'tyMPercent'=>$this->input->post('mRate')
		);
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('wRate'))){
				$data=array(
			'tyWParcent'=>$this->input->post('wRate')
		);
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('description'))){
				$data=array(
			'tyDescription'=>$this->input->post('description')
		); 
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		if(!empty($this->input->post('photo'))){
			$this->load->library('upload',$config);
			if(!$this->upload->do_upload('photo')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
			else{
				$file_name=$this->upload->data('file_name');
				$img_path='Uploads/'.$file_name;
			}
				$data=array(
			'tyPhoto'=>$img_path
		);
			$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
		}
		else{
			echo "<script type='text/javascript'>alert('Successfully Updated');</script>";
		}
			//$this->TypeModel->TypeUpdate($this->input->post('id'),$data);
			$this->displayData();
		}
	public function displayReport(){
		$this->load->view('defaultAdminHeader');
		$this->load->view('DisplayReport');
	}
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Regmodel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');	
	}

	function index(){
		$data['error'] = '';
		$this->load->view('defaultAdminHeader');
		$this->load->view('Regview',$data);
	}

	public function add(){
		$data['error'] = '';
		$this->load->view('defaultAdminHeader');
		$this->load->view('Regview',$data);
	}

	public function submit(){
		$image_path = '';

				$config['upload_path']          = './upload/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 4096000;
                $config['max_width']            = 1500;
                $config['max_height']           = 1000;

                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('drvimg'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
						$this->load->view('defaultAdminHeader');
                        $this->load->view('Regview', $error);
                }

                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        $file_name = $this->upload->data('file_name');
                        $image_path =base_url('upload/' . $file_name);
                        // $this->load->view('upload_success', $data);
                
                     $field = array(
					'drvNIC'=>$this->input->post('drvNIC'),
					'drvFirstName'=>$this->input->post('drvFirstName'),
					'drvLastName'=>$this->input->post('drvLastName'),
					'drvEmail'=>$this->input->post('drvEmail'),
					'drvLicense'=>$this->input->post('drvLicense'),
					'drvPassword'=>md5($this->input->post('drvPassword')),
					'drvDOB'=>$this->input->post('drvDOB'),
					'drvimg'=>$image_path,
					'drvAddress'=>$this->input->post('drvAddress'),
					'drvMobile'=>$this->input->post('drvMobile'),
					'drvLAND'=>$this->input->post('drvLAND'),
					'empNIC'=>$this->input->post('empNIC'),
					);

			$result = $this->Regmodel->submit($field);


                }		

	if($result){
			$this->session->set_flashdata('success_msg', 'Record added successfully');
		}else{
			$this->session->set_flashdata('error_msg', 'Faill to add record');
		}
		redirect('Logcontroller');
	}
}

?>

	
	

	

<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  

class Logcontroller extends CI_Controller{

	function __construct(){
		parent:: __construct();
		$this->load->model('Logmodel');
		$this->load->helper('form');
	}

	public function index(){
		$this->load->view("Defaultheader.php");
		$this->load->view('Logview');
	} 
      
    public function login(){  
	$this->load->view("Defaultheader.php");
        $this->load->view("Logview", $data);  
      }  

    public function login_validation(){$this->load->library('form_validation');
        $this->form_validation->set_rules('drvNIC', 'drvNIC', 'required');  
        $this->form_validation->set_rules('drvPassword', 'drvPassword', 'required');  
           
        if($this->form_validation->run()){  
                //true  
              	$drvNIC = $this->input->post('drvNIC');  
                $drvPassword = md5($this->input->post('drvPassword'));  
                //model function  
                $this->load->model('Logmodel');  
                
                if($this->Logmodel->can_login($drvNIC, $drvPassword)){  
                     $session_data = array(  
                          'drvNIC'     =>     $drvNIC  
                     );  

					$data['blogs'] = $this->Logmodel->getBlog($drvNIC);
					$this->load->view("driverHeader");
					$this->load->view('Showview', $data);
	
                	}

                else{  
                     $this->session->set_flashdata('error', 'Invalid drvNIC and drvPassword');  
					 $this->load->view("Defaultheader.php");
                     $this->load->view('Logview');  
                }  
           }  


           else  
           {  
                //false  
                $this->login();  
           }  
      }  

      function logout()  
      {  
           $this->session->unset_userdata('drvNIC'); 
$this->load->view("Defaultheader.php");		   
          $this->load->view('Logview');$this->load->view('Logview');$this->load->view('Logview');  
      }  



 }  
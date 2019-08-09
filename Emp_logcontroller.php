<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emp_logcontroller extends CI_Controller
{

     function __construct()
     {
          parent::__construct();
          $this->load->model('Emp_logmodel');
          $this->load->helper('form');
     }

     public function index()
     {
          $this->load->view("Defaultheader");
          $this->load->view('Emp_logview');
     }

     public function login()
     {
          $this->load->view("Defaultheader");
          $this->load->view("Emp_logview");
     }

     public function login_validation()
     {
          $this->load->library('form_validation');
          $this->form_validation->set_rules('empNIC', 'empNIC', 'required');
          $this->form_validation->set_rules('emPassword', 'emPassword', 'required');

          if ($this->form_validation->run()) {
               //true  
               $empNIC = $this->input->post('empNIC');
               $emPassword = $this->input->post('emPassword');
               //model function  
               $this->load->model('Emp_logmodel');

               if ($this->Emp_logmodel->can_login($empNIC, $emPassword)) {
                    $session_data = array(
                         'empNIC'     =>     $empNIC
                    );

                    $data['blogs'] = $this->Emp_logmodel->getBlog($empNIC);
                    $this->load->view("DefaultAdminHeader");
                    $this->load->view('Emp_showview', $data);
               } else {
                    $this->session->set_flashdata('error', 'Invalid empNIC and emPassword');
                    $this->load->view("DefaultAdminHeader");
                    $this->load->view('Emp_logview');
               }
          } else {
               //false  
               $this->login();
          }
     }



     function logout()
     {
          $this->session->unset_userdata('empNIC ');
          $this->load->view("DefaultAdminHeader");
          $this->load->view('Emp_logview');
          $this->load->view('Emp_logview');
          $this->load->view('Emp_logview');
     }
}

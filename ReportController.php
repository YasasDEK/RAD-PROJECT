<?php
Class ReportController extends CI_Controller{

    function __construct(){
      parent::__construct();
      //load chart_model from model
      $this->load->model('ReportModel');
    }
 
    function index(){
      $data = $this->ReportModel->get_data()->result();
      $x['data'] = json_encode($data);
	  $this->load->view('defaultAdminHeader');
      $this->load->view('ReservationReport',$x);
    }

}
?>
<?php

class Testcontroller extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
                $this->load->library('upload');	
        }

        public function index()
        {
                $this->load->view('Testview', array('error' => ' ' ));
        }

        public function do_upload()
        {
                $config['upload_path']          = './upload/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 4096000;
                $config['max_width']            = 1500;
                $config['max_height']           = 1000;

                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('Testview', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        // $this->load->view('upload_success', $data);
                }
        }
}
?>
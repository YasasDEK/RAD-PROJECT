<?php
class vehicleController extends CI_Controller
{
	function view()
	{
		$data['view'] = $this->vehicleModel->viewDB();
		$this->load->view('defaultAdminHeader');
		$this->load->view('vehicleView', $data);
	}

	function load()
	{
		$data['msg'] = "";
		$this->load->model('vehicleModel');
		$data['type'] = $this->vehicleModel->getType();
		$data['view'] = $this->vehicleModel->viewDB();
		$this->load->view('defaultAdminHeader');
		$this->load->view('vehicleAdd', $data);
	}

	public function insert()
	{
		$this->form_validation->set_rules('vNum', 'Registration Number', 'required');
		$this->form_validation->set_rules('vType', 'Vehicle Type', 'required|numeric');
		$this->form_validation->set_rules('vIns', 'Insurance Number', 'required');
		$this->form_validation->set_rules('vName', 'Name', 'required');
		$this->form_validation->set_rules('vColor', 'Colour', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['msg'] = "";
			$data['type'] = $this->vehicleModel->getType();
			$data['view'] = $this->vehicleModel->viewDB();
			$this->load->view('defaultAdminHeader');
			$this->load->view('vehicleAdd', $data);
		} else {

			$config['upload_path'] = './assets/img/car';
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			$this->upload->do_upload('vhPhoto');
			$upFileName = $this->upload->data();
			$dataFile = $upFileName['file_name'];
			$this->vehicleModel->insertDB($dataFile);

			$data['msg'] = $this->input->post('vNum') . " registration successful.";
			$data['type'] = $this->vehicleModel->getType();
			$data['view'] = $this->vehicleModel->viewDB();
			$this->load->view('defaultAdminHeader');
			$this->load->view('vehicleAdd', $data);
		}
	}

	public function viewIMG($src = FALSE)
	{
		if ($src != FALSE) {
			$data['src'] = $src;
			$this->load->view('viewIMG', $data);
		} else {
			$data['src'] = "No_Image";
			$this->load->view('viewIMG', $data);
		}
	}

	public function updateLoad($regNo)
	{
		$data['type'] = $this->vehicleModel->getType();
		$data['view'] = $this->vehicleModel->viewDB($regNo);
		$this->load->view('defaultAdminHeader');
		$this->load->view('vehicleEdit', $data);
	}

	public function update($regNo)
	{
		$config['upload_path'] = './assets/images/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		$this->upload->do_upload('vhPhoto');
		$upFileName = $this->upload->data();
		$dataFile = $upFileName['file_name'];
		$data['view'] = $this->vehicleModel->updateDB($regNo, $dataFile);

		$data['view'] = $this->vehicleModel->viewDB();
		$this->load->view('defaultAdminHeader');
		$this->load->view('vehicleView', $data);
	}

	public function delete($regNo)
	{
		$this->vehicleModel->delete($regNo);
		$data['view'] = $this->vehicleModel->viewDB();
		$this->load->view('defaultAdminHeader');
		$this->load->view('vehicleView', $data);
	}
}

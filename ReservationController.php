<?php
class ReservationController extends CI_Controller
{
	public function load()
	{
		$this->load->view('Customerheader');
		$this->load->view('ReservationDate');
		$this->load->view('Customerfooter');
	}

	public function getDate()
	{
		$this->form_validation->set_rules('pDate', 'Pickup Date', 'required');
		$this->form_validation->set_rules('dDate', 'Return Date', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('Customerheader');
			$this->load->view('ReservationDate');
			$this->load->view('Customerfooter');
		} else {
			$pTemp = $this->input->post('pDate');
			$newPDate = date("Y-m-d", strtotime($pTemp));
			$dTemp = $this->input->post('dDate');
			$newDDate = date("Y-m-d", strtotime($dTemp));

			$data['pDate'] = $newPDate;
			$data['dDate'] = $newDDate;
			$data['type'] = $this->ReservationModel->gettype($newPDate, $newDDate);
			$data['driver'] = $this->ReservationModel->getDriver($newPDate, $newDDate);

			$this->load->view('Customerheader');
			$this->load->view('Reservation', $data);
			$this->load->view('Customerfooter');
		}
	}
	public function insert($pDate, $dDate)
	{
		$this->form_validation->set_rules('resDrv', 'Driver', 'required');
		$this->form_validation->set_rules('resType', 'Vehicle Type', 'required');
		$custNIC = $_SESSION['custNIC'];
		if ($this->form_validation->run() == FALSE) {
			$data['pDate'] = $pDate;
			$data['dDate'] = $dDate;
			$data['type'] = $this->ReservationModel->gettype($pDate, $dDate);
			$data['driver'] = $this->ReservationModel->getDriver($pDate, $dDate);

			$this->load->view('Customerheader');
			$this->load->view('Reservation', $data);
			$this->load->view('Customerfooter');
		} else {
			$tyDetails = $this->ReservationModel->getTypeDet($this->input->post('resType'));
			$dateDiff = abs((strtotime($dDate) - strtotime($pDate)) / (60 * 60 * 24));

			if ($dateDiff < 7) {
				$estPrice = $dateDiff * $tyDetails['tyDRate'];
			} else if ($dateDiff < 30) {
				$estPrice = $dateDiff * $tyDetails['tyDRate'] * $tyDetails['tyWParcent'];
			} else {
				$estPrice = $dateDiff * $tyDetails['tyDRate'] * $tyDetails['tyMPercent'];
			}

			$this->ReservationModel->insert($pDate, $dDate, $custNIC, $estPrice);
			$this->load->view('Customerheader');
			$this->load->view('ReservationDone');
			$this->load->view('Customerfooter');
		}
	}

	public function view()
	{
		$custNIC = $_SESSION['custNIC'];
		$data['view'] = $this->ReservationModel->view($custNIC);
		$this->load->view('Customerheader');
		$this->load->view('ReservationView', $data);
		$this->load->view('Customerfooter');
	}

	public function delete($resID)
	{
		$custNIC = $_SESSION['custNIC'];
		$this->ReservationModel->delete($resID);

		$data['view'] = $this->ReservationModel->view($custNIC);
		$this->load->view('Customerheader');
		$this->load->view('ReservationView', $data);
		$this->load->view('Customerfooter');
	}
}

<?php
	Class CustomerMain extends CI_Controller{

		/*public function __construct(){


			parent :: __construct();

			$this->load->library('email');
			//sending an email to the customer
			$config = array(
				'protocol'=>'smtp',
				'smtp_host'=>'smtp.googlemail.com',
				//'smtp_host'=>'smtp.mailtrap.io',
				//'smtp_crypto'=>'ssl',
				'smtp_port'=>465,
				//'smtp_port'=>2525,
				//'smtp_user'=>'55b70c38361d29',
				'smtp_user'=>'sanjalisupunnadi@gmail.com',
				'smtp_pass'=>'Sanjali.1',
				'mailtype'=>'text',
				'smtp_timeout'=> 30,
				'charset'=>'iso-8859-1',
				'crlf' => "\r\n",
				'newline' => "\r\n",
				'wordwrap'=>TRUE
			);

			$this->email->initialize($config);
			
		}*/
		//load homepage
		public function index(){
			$this->load->view("Customerheader.php");
			$this->load->view("Home.php");
			$this->load->view("Customerfooter.php");
		}

		public function register(){
			$this->load->view("Defaultheader.php");
			$this->load->view("CustomerRegister.php");
			$this->load->view("Customerfooter.php");
			$this->session->unset_userdata('userError');
		}

		public function login(){
			$this->load->view("Defaultheader.php");
			$this->load->view("CustomerLogin.php");
			$this->load->view("Customerfooter.php");
			$this->session->unset_userdata('userError');
		}

		//when sign in or sign up load customer details (customer dashboard)
		public function loadcustomer(){
			$this->load->view("Customerheader.php");
			$this->load->view("CustomerPage.php");
			$this->load->view("Customerfooter.php");
			$this->session->unset_userdata('userError');
		}

		//when someone want to update their profile this will be load (in UpdateData.php text boxes are not readonly can be changed) 
		public function updateprofile(){
			$this->load->view("Customerheader.php");
			$this->load->view("CustomerUpdateData.php");
			$this->load->view("Customerfooter.php");
			$this->session->unset_userdata('userError');
		}

		//when someone want to update their password this will be load
		public function changePassword(){
			$this->load->view("Customerheader.php");
			$this->load->view("CustomerChangePassword.php");
			$this->load->view("Customerfooter.php");
			$this->session->unset_userdata('userError');
		}

		//view vehicle types for visitors
		public function customerDisplayData(){
			$this->load->database();
			$this->load->model('TypeModel');
			$data['records']=$this->TypeModel->query();
			$this->load->view('Defaultheader');
			$this->load->view('custTypeView',$data);
		}

		//view vehicle types for logged customer
		public function loggedcustomerDisplayData(){
			$this->load->database();
			$this->load->model('TypeModel');
			$data['records']=$this->TypeModel->query();
			$this->load->view('Customerheader');
			$this->load->view('custTypeView',$data);
		}

		//load about page
		public function about(){
			$this->load->view("Customerheader");
			$this->load->view("about");
			$this->load->view("Customerfooter");
		}

		public function registerValidation(){
			$this->form_validation->set_rules('fName','First Name','required');
			$this->form_validation->set_rules('lName','Last Name','required');
			$this->form_validation->set_rules('custDOB','Date Of Birth','required');
			$this->form_validation->set_rules('custTelephone','telephone','required');
			$this->form_validation->set_rules('custNIC','NIC','required');
			$this->form_validation->set_rules('no','No','required');
			$this->form_validation->set_rules('street','Street','required');
			$this->form_validation->set_rules('city','City','required');
			$this->form_validation->set_rules('pwd','Password','required');
			$this->form_validation->set_rules('custPassword','Confirm Password','required');

			if($this->form_validation->run()){

				$fName=$this->input->post('fName');
				$lName=$this->input->post('lName');
				$custDOB=$this->input->post('custDOB');

				$custName=$fName." ".$lName;

				$custTelephone=$this->input->post('custTelephone');
				$custNIC=$this->input->post('custNIC');
				$custLicence=$this->input->post('custLicence');

				$no=$this->input->post('no');
				$street=$this->input->post('street');
				$city=$this->input->post('city');
				$custAddress=$no." ".$street." ".$city;

				$custEmail=$this->input->post('custEmail');
				$custPassword=md5($this->input->post('custPassword'));

				$this->load->model('CustomerModel');

				//pass data to model to check with DB
				//if user does not exists on that NIC new user will be added
				if($this->CustomerModel->checkExistUser($custNIC)){
					$this->CustomerModel->insertData($custName,$custDOB,$custNIC,$custLicence,$custTelephone,$custAddress,$custEmail,$custPassword);
					$session_data=array(
						'custName'=>$custName,
						'custAddress'=>$custAddress,
						'custTelephone'=>$custTelephone,
						'custEmail'=>$custEmail,
						'custNIC'=>$custNIC,
						'custDOB'=>$custDOB,
						'custPhoto'=>''
					);


					/*$this->email->from('sanjalisupunnadi@gmail.com','Admin');
					$this->email->to($custEmail);
					//$this->email->cc('another@another-example.com');
					//$this->email->bcc('them@their-example.com');

					$this->email->subject('Welcome Message');
					$this->email->message('Hi there');
					if($this->email->send()){
						echo "sent !";
					}else{
						echo "not sent";
					}*/

					$this->session->set_userdata($session_data);
					$this->loadcustomer();
					
				//if an active user found on given NIC
				}else{
					$error="User already exists on given NIC";
					$session_data=array(
						'custName'=>'',
						'custAddress'=>'',
						'custTelephone'=>'',
						'custEmail'=>'',
						'custNIC'=>'',
						'custPhoto'=>'',
						'userError'=>$error
					);
					$this->session->set_userdata($session_data);
					echo "User Already exists on given NIC";
					$this->register();
				}

			}else{
				$error="Please fill the form correctly";
				$this->session->set_userdata('userError','Please fill the form correctly');
				echo 'error';
				$this->register();
			}
		}

		public function loginvalidate(){

			$this->form_validation->set_rules('custNIC','NIC','required');
			$this->form_validation->set_rules('custPassword','Password','required');

			if($this->form_validation->run()){

				$custNIC=$this->input->post('custNIC');
				$custPassword=md5($this->input->post('custPassword'));

				$this->load->model('CustomerModel');
				//if a user found on given password and NIC
				if($this->CustomerModel->checkData($custNIC,$custPassword)){
					//model passes results as an array (result_array())
					$result=$this->CustomerModel->retrieveData($custNIC,$custPassword);
					//get data from array
					foreach($result as $row){
						$data1=$row['custName'];
						$data2=$row['custAddress'];
						$data3=$row['custEmail'];
						$data4=$row['custTelephone'];
						$data5=$row['custDOB'];
						$data6=$row['custPhoto'];
					}
					//set session data
					$session_data=array(
						'custName'=>$data1,
						'custAddress'=>$data2,
						'custTelephone'=>$data4,
						'custEmail'=>$data3,
						'custDOB'=>$data5,
						'custPhoto'=>$data6,
						'custNIC'=>$custNIC
					);
					$this->session->set_userdata($session_data);
					$this->loadcustomer();

				}else{
					$this->session->set_userdata('userError', 'No active user for given NIC or Password');
					echo "No active user for given NIC or Password";
					$this->login();
				}
			}else{
				$this->session->set_userdata('userError', 'Error occured while doing !');
				echo 'error';
				$this->login();
			}
		}

		public function update(){
			$custNIC=$_SESSION['custNIC']; //take NIC from session
			$custName=$this->input->post('custName');
			$custTelephone=$this->input->post('custTelephone');
			$custAddress=$this->input->post('custAddress');
			$custEmail=$this->input->post('custEmail');
			$custDOB=$this->input->post('custDOB');	

			if($custDOB==''){
				$custDOB=$_SESSION['custDOB'];
			}

			$this->load->model('CustomerModel');

			if($custNIC==''){
				$this->session->set_userdata('userError', 'Log in first to change');
				echo 'Log in first to change';
				$this->login();
			}else{

				$config =[
				'upload_path'=>'./uploads',
				'allowed_types'=>'png|jpg|jpeg'
				];

				$this->load->library('upload',$config);
				$this->form_validation->set_error_delimiters();
				
				$image_path='';

				if($this->upload->do_upload()){
					$data=$this->input->post();
					$info=$this->upload->data();
					$image_path=base_url("uploads/".$info['raw_name'].$info['file_ext']);
					unset($data['submit']);
					$this->load->model('CustomerModel');
					$this->CustomerModel->insertImage($image_path,$custNIC);				
				}else{
					$image_path=$_SESSION['custPhoto'];
				}

				$this->CustomerModel->updateData($custNIC,$custName,$custTelephone,$custAddress,$custEmail,$custDOB);
				$session_data=array(
						'custName'=>$custName,
						'custAddress'=>$custAddress,
						'custTelephone'=>$custTelephone,
						'custEmail'=>$custEmail,
						'custNIC'=>$custNIC,
						'custDOB'=>$custDOB,
						'custPhoto'=>$image_path
					);
				$this->session->set_userdata($session_data);
				$this->loadcustomer();
			}
		}

		//update the password of customer
		public function updatepassword(){
			$custNIC=$_SESSION['custNIC'];
			$pwd=$this->input->post('custPassword');
			$custPassword=md5($pwd);

			$this->load->model('CustomerModel');
			if($custNIC==''){
				$this->session->set_userdata('userError', 'Log in first to change');
				echo 'Log in first to change';
				$this->login();
			}else{

				$this->CustomerModel->updatePassword($custNIC,$custPassword);
				$this->loadcustomer();
			}
		}

		//deativation on user
		public function deactivate(){
			$this->load->model('CustomerModel');
			$custNIC=$_SESSION['custNIC'];//take NIC from session since session has data about user
			$this->CustomerModel->deleteData($custNIC);
			$session_data=array(
						'custName'=>'',
						'custAddress'=>'',
						'custTelephone'=>'',
						'custEmail'=>'',
						'custNIC'=>'',
						'custDOB'=>'',
					);
				$this->session->set_userdata($session_data);
			redirect(base_url());
		}

		//rate the driver
		public function rateDriver(){
			$custNIC=$_SESSION['custNIC'];
			$this->load->model('CustomerModel');

			if($this->CustomerModel->checkReservation($custNIC)){
				$result=$this->CustomerModel->retrieveDataReservation($custNIC);
				foreach($result as $row){
					$resID=$row['resID'];
					$drvNIC=$row['drvNIC'];
				}

				$result=$this->CustomerModel->retrieveDataDriver($drvNIC);
				foreach($result as $row){
					$fname=$row['drvFirstName'];
					$lname=$row['drvLastName'];
				}
				$data= array(
					'firstname'=>$fname,
					'lastname'=>$lname,
					'reservationID'=>$resID
				);

				$this->load->view("Customerheader.php");
				$this->load->view("CustomerRateDriver.php",$data);
				$this->load->view("Customerfooter.php");
				$this->session->unset_userdata('userError');

			}else{
				echo '<script>alert("Currently you have not completed any trips with drivers or \n you have already rated the driver");</script>';
				$this->loadcustomer();;
			}
		}

		function addratingtodriver(){
			$rating =$this->input->post("star");
			$resID =$this->input->post("resID");
			$ratingValue=0;

			if($rating == "1"){
				$ratingValue=1;
			}else if($rating == "2"){
				$ratingValue=2;
			}else if($rating == "3"){
				$ratingValue=3;
			}else if($rating == "4"){
				$ratingValue=4;
			}else if($rating == "5"){
				$ratingValue=5;
			}

			//echo 'kkk'.$rating;
			//echo 'mmm'.$ratingValue;

			$this->load->model("CustomerModel");
			$this->CustomerModel->updateDriverRate($ratingValue,$resID);

			echo '<script>alert("Your rating has been recorded, Thank you");</script>';
			$this->loadcustomer();;

		}
	}
?>
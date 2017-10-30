<?php


class user_auth extends CI_Controller {

public function __construct() {
		
	parent::__construct();
	
	// Load form helper library
	$this->load->helper('form');
	
	//load url helper library
	$this->load->helper('url_helper');
	
	// Load form validation library
	$this->load->library('form_validation');
	
	// Load session library
	$this->load->library('session');
	
	// Load database
	$this->load->model('login_database');
	
	}
	
	public function index()
	{
		$data['heading']="ERROR 404";
		$data['message']="You are attempting to access an unknown page.";
		$this->load->view('errors/html/error_404',$data);
	}
	
	public function loginmodal(){
		$this->load->view('template/header.php');
		$this->load->view('template/breadcrumb.php');
		$this->load->view('template/modal.php');
		$this->load->view('template/footer.php');
	}
	
	// Check for user login process
	public function user_login_process() {
		$this->form_validation->set_rules('login_username', 'Username', 'trim|required');
		$this->form_validation->set_rules('login_password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['logged_in'])){
			//$this->load->view('pages/index5.php');
			echo "YES";
		}else{
			echo validation_errors();//."\nuser:".$this->input->post('login_username')."\npass:".$this->input->post('login_password');
		}
		} else {
			$data = array(
				'username' => $this->security->xss_clean($this->input->post('login_username')),
				//'password' => $this->hash_password($this->security->xss_clean($this->input->post('login_password')))
				'password' => $this->security->xss_clean($this->input->post('login_password'))
			);
			$result = $this->login_database->login($data);
			if ($result == TRUE ) {
				$username = $this->security->xss_clean($this->input->post('login_username'));
				$result = $this->login_database->read_user_information($username);
				if ($result != false) {
					$session_data = array(
					'username' => $result[0]->user_name,
					'email' => $result[0]->user_email,
					);
					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					//$this->load->view('admin_page');	
					echo "YES";
					//echo "<script type='text/javascript'>alert(".$session_data['username'].");</script>";
				}
				else 
					echo "NO";
			} else {
				$data = array(
				'error_message' => 'Invalid Username or Password'
				);
				echo "NO";
			}
		}
	}
	public function logout() {
	
	// Removing session data
	$sess_array = array(
	'username' => ''
	);
	$this->session->unset_userdata('logged_in', $sess_array);
	$data['message_display'] = 'Successfully Logout';
	sleep(3);
	redirect(base_url(""));
	}

	public function register_user()
	{
		$this->form_validation->set_rules('register_username', 'Username', 'trim|required');
		$this->form_validation->set_rules('register_password', 'Password', 'trim|required');
		$this->form_validation->set_rules('register_email', 'Email', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
		}
		else
		{
			$data = array(
					'user_name' => $this->security->xss_clean($this->input->post('register_username')),
					'user_email' => $this->input->post('register_email'),
					'user_password' => $this->hash_password($this->security->xss_clean($this->input->post('register_password'))),
					'email_verification_code' => md5(uniqid(rand(), true))
			);
			$result = $this->login_database->registration_insert($data);
			if($result == TRUE){
				$this->login_database->sendVerificatinEmail($this->security->xss_clean($data['user_email']), $data['email_verification_code']);
				echo "success";
			}
			else 
				echo "failure";
		}
	}
	
	public function verify($verificationText=NULL){
		$noRecords = $this->login_database->verifyEmailAddress($verificationText);
		if ($noRecords > 0){
			$error = "Email Verified Successfully!";
		}else{
			$error = "Sorry Unable to Verify Your Email!";
		}
		$data['errormsg'] = $error;
		$this->load->view('pages/verify.php', $data);
	}
	
	private function hash_password($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}
}

?>

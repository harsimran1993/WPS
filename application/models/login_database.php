

<?php

Class Login_Database extends CI_Model {
	
	public function __construct(){
			$this->load->database();

			//email
			$this->load->library('email');
	}

	// Insert registration data in database
	public function registration_insert($data) {
		
		// Query to check whether username already exist or not
		$condition = "user_name ="."'".$data['user_name']."' OR user_email='".$data['user_email']."'";
		$this->db->select('*');
		$this->db->from('user_login');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			// Query to insert data in database
			$this->db->insert('user_login', $data);
			
			if ($this->db->affected_rows() > 0) {
				return true;
			}
		}
		return false;
	}

	// Read data using username and password
	public function login($data) {
		//$condition = "user_name ="."'".$data['username']."' AND "."user_password ="."'".$data['password']."'";
		$this->db->select('*');
		$this->db->from('user_login');
		$this->db->where("user_name ="."'".$data['username']."'");
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query-> row_array();
			$verified = $result['active_status'];
			if($verified === "A"){
				if(password_verify($data['password'], $result['user_password']))
					return true;
				else
					return false;
			}
			else 
				return false;
		} else {
			return false;
			//echo  $this->db->error();
		}
	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {
	
		$condition = "`user_name` =" . "'" . $username . "'";
		$this->db->select('*');
		$this->db->from('user_login');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
			//echo  $this->db->error();
		}
	}

	function verifyEmailAddress($verificationcode){
		$sql = "update user_login set active_status='A' WHERE email_verification_code=?";
		$this->db->query($sql, array($verificationcode));
		return $this->db->affected_rows();
	}



	function sendVerificatinEmail($email,$verificationText){
		$this->email->from('harsim1994@gmail.com', 'Rangoli Fashion');
		$this->email->to($email);
			
		$this->email->subject("Rangoli Fashion:Email Verification");
		$this->email->message("Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n ".base_url()."user_auth/verify/".$verificationText."\n"."\n\nThanks\nRangoli Fashion");
		$this->email->send();
		$this->email->clear();
	}
}

?>


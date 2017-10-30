<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
	}
	
	public function index()
	{
		$data['heading']="ERROR 404";
		$data['message']="You are attempting to access an unknown page.";
		$this->load->view('errors/html/error_404',$data);
	}
}

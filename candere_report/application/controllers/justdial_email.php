<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Justdial_email extends CI_Controller  {
	
	public function __construct()
	{ 
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		   
		 $this->load->helper('url'); 
		 
		$message_arr['from_email']      = 'From Email';
		$message_arr['to_email']      	= 'To Email';
		$message_arr['message']      	= 'Message'; 
		$message_arr['subject']      	= 'Subject'; 
 
		$message_arr['scripts_to_load'] = array('jquery-1.7.2.min.js','jquery.form-validator.min.js');
		
		
		$this->load->view('templates/header'); 

		 
			$this->load->view("justdial/index",$message_arr);
		 
		
		$this->load->view('templates/footer');
	} 
	 
	public function sendemail()
	{ 
		$message_arr = array('');
		
		 redirect('justdial'); 
	}
	 
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();  
		$this->load->library('email'); 
		$this->load->helper('url');
		$this->load->library('form_validation');			
	}
	
	public function index()
	{
		$message_arr = array('');
		
		$this->db->cache_delete_all();  
		$this->load->view('newsletter/newsletter');
		 
		
	}

	public function email_send()
	{	
	
		$this->db->cache_delete_all();
		$this->form_validation->set_rules('sender_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('sender_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		
		
		if($this->form_validation->run() == FALSE){
			$message_arr[] = 'Please Enter all the required fields'; 
		}else{
			$sender_name 	= $this->input->post('sender_name');
			$sender_email 	= $this->input->post('sender_email');
			$email 			= $this->input->post('email');
			$message		= $this->input->post('message');
			$subject		= $this->input->post('subject');
			
			//$list = array('one@example.com', 'two@example.com', 'three@example.com');
			$email_list = explode(",",$email);
			
			 $config = array( 
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			$this->load->library('email', $config);
			
			$config = array(
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			foreach($email_list as $key => $emails)
			{
				$this->email->initialize($config);
				$this->email->from($sender_email, $sender_name);
				$this->email->to($emails);
				$this->email->subject($subject);
				$this->email->message($message);
				if($this->email->send())
				{   
					$message_arr[] = 'Email Sent to '.$emails; 
					$this->session->set_flashdata('message_arr', $message_arr);
				}
			   else
			   { 
					$message_arr[] = 'Unable to send email to '.$emails; 
					$this->session->set_flashdata('message_arr', $message_arr);
			   }
			}
		} 
		
		$this->session->set_flashdata('message_arr', $message_arr);
		redirect('/newsletter/index');
	}
} 
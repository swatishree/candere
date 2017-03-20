<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_design extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}

	public function index()
	{   
		if($_GET){
			$config['page_query_string'] = true; 
		}else{ 
			$config['page_query_string'] = false;
		}
		
		$todatepicker 		= ($this->input->get('todatepicker'));
		$fromdatepicker 	= ($this->input->get('fromdatepicker')); 
		$email 				= ($this->input->get('email'));
		$firstname 			= ($this->input->get('first_name'));
		$lastname 			= ($this->input->get('last_name'));
		$affiliate_source 	= ($this->input->get('affiliate_source'));
		$affiliate_medium 	= ($this->input->get('affiliate_medium'));
		
		$sql = " Select * from custom_design c order by id desc
	";
		
		
		 
		// $get_data = http_build_query($_GET);
		
		// $config['base_url'] 	= base_url()."index.php/customer_design/index/pageno?$get_data"; 
		// $config['total_rows'] 	= $this->db->query($sql)->num_rows();
		// $config['per_page'] 	= 50;
		// $config['uri_segment'] 	= 1;
		// $config['full_tag_open'] = "<div class=\"pagination\">\n<ul>\n";
		// $config['full_tag_close'] = "\n</ul>\n</div>";
		// $config['num_tag_open'] = '<li>';
		// $config['num_tag_close'] = '</li>';
		// $config['cur_tag_open'] = '<li><a><strong>';
		// $config['cur_tag_close'] = '</strong></a></li>';
		// $config['prev_tag_open'] = '<li>';
		// $config['prev_tag_close'] = '</li>';
		// $config['next_tag_open'] = '<li>';
		// $config['next_tag_close'] = '</li>';
		// $config['last_tag_open'] = '<li>';
		// $config['last_tag_close'] = '</li>';
		// $config['first_tag_open'] = '<li>';
		// $config['first_tag_close'] = '</li>';
		// $config['prev_link'] = 'Prev';
		// $config['next_link'] = 'Next';
		// $config['use_page_numbers'] = true; 
			
		
		$limit = $config['per_page'];
		
		$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;
		if($start != 0){ 
			$start = (($start - 1) * $limit); 
		}else{
			 $start = 0; 
		} 
		
		$data['total_count'] = $this->db->query($sql)->num_rows(); 
		
		
		
		 
		$results = $this->db->query($sql);  
		
		
		 
		if(count($results->result_array())>0){ 
			$data['data']= $results->result_array();
		}else{  
			$data['data']= array('noData'=>'emptydta');
		}	
		$this->pagination->initialize($config);
		
		$this->load->view('templates/header'); 
        $this->load->view("customer_design/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	 
	 
	 
}

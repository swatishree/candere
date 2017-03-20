<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Regionreports extends CI_Controller  {
	
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
		 
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount1 = $this->db->count_all('sales_flat_order_address');
				
		$config['base_url'] 	= base_url()."index.php/regionreports/index";
		$config['total_rows'] 	= $recordsCount1;
		$config['per_page'] 	= 50;
		$config['uri_segment'] 	= 3;
		$config['full_tag_open'] = "<div class=\"pagination\">\n<ul>\n";
		$config['full_tag_close'] = "\n</ul>\n</div>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['use_page_numbers'] = true;
		
		$limit = $config['per_page'];
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
		
		$data = array('');
		
		$sql = "select  SFO.increment_id,SFOA.region ,SFOA.city,SFOA.postcode from sales_flat_order_address SFOA
		left join sales_flat_order  SFO on (SFO.entity_id=SFOA.parent_id)
		where SFOA.address_type='billing' and SFO.state='complete' or 
		SFO.state='closed' order by SFO.increment_id desc limit $start, $limit";
		
		
		
		
		$count_sql_query = "select SFO.increment_id  from sales_flat_order_address SFOA
		left join sales_flat_order  SFO on (SFO.entity_id=SFOA.parent_id)
		 where SFOA.address_type='billing' and SFO.state='complete' or 
		 SFO.state='closed' order by SFO.increment_id desc";
		
		
		 
			$results = $this->db->query($sql);  
			$count_sql_query_result = $this->db->query($count_sql_query); 
		
			$recordsCount = $results->num_rows(); 
					
			if(count($results->result_array())>0){ 
				$data['search_data']= $results->result_array();
			}	
			
			
			$config['total_rows'] 	= $recordsCount;
			
			$this->pagination->initialize($config);
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['results_count'] = $recordsCount;
			$this->load->view('templates/header'); 
			$this->load->view("regionreports/index",$data);
			$this->load->view('templates/footer');
			
		} 
	
	
	//************************ Export Regions detial by Bharat @231215*********************
	
	public function export()
	{ 
		$message_arr = array('');
		$this->load->helper('csv');
		
		$sql = $this->getCsv();
		
		foreach($sql->result_object as $row) {
			
						
			$region		 			= $row->region; 
			$city 					= $row->city;
			$postcode 				= $row->postcode;
			
			
			$array[] = array(
				'Region'=>$region,
				'City'=>$city,
				'Postcode'=>$postcode, 
				); 
		}
		
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 array_to_csv($array,'exportdetails_'.date('d-M-y').'.csv'); 
		 
	} 
	  
	
	public function getCsv(){	
			
	   $sql = "select SFO.increment_id,SFOA.region ,SFOA.city,SFOA.postcode from sales_flat_order_address SFOA
		left join sales_flat_order  SFO on (SFO.entity_id=SFOA.parent_id)
		where SFOA.address_type='billing' and SFO.state='complete' or 
		SFO.state='closed' order by SFO.increment_id desc 
	    "; 
		$results = $this->db->query($sql); 			
		$result = $results->result();  

		
		rsort($results); 
		return $results ;
	}
	
	
	
	
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
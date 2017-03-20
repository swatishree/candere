<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Service_Enquiry extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
 
		$sql = "SELECT * from customer_queries order by id desc";
			
			
		$results 	= $this->db->query($sql);
		$result 	= $results->result();
		
		$data['RowsSelected']= $result;
						 
						 
		$this->load->view('templates/header'); 
        $this->load->view("service_enquiry/index", $data);
		$this->load->view('templates/footer');
	}
	
	public function export_report()
	{ 
		$this->db->cache_delete_all();
				
		$from 	= $this->input->post('from');
		$to 		= $this->input->post('to');
		$flag 		= $this->input->post('flag');
		
		
		$from = strtotime($from);
		$from = date('Y-m-d', $from);
		
		$to = strtotime($to);
		$to = date('Y-m-d', $to);
		$cond = '';
		if(isset($flag)){
			$cond .= " and flag = '$flag'";
		}
		
		if(isset($from)){
			$cond .= " and created_at between '$from' and '$to'";	
		}
		
		$this->load->helper('csv');
		$sql = "SELECT * from customer_queries where 1   $cond order by id desc ";
			 	
		$results 	= $this->db->query($sql);
		$result 	= $results->result();
		
		$data['RowsSelected']= $result;
						 
		//array_to_csv($result,'sales_order_report_'.date('d-M-y'));
		
		
		$this->load->view('templates/header'); 
        $this->load->view("service_enquiry/index", $data);
		$this->load->view('templates/footer');
	}
	
	public function report()
	{ 
		$this->db->cache_delete_all();
	 
		$this->load->view('templates/header'); 
        $this->load->view("service_enquiry/report");
		$this->load->view('templates/footer');
	}
	
}	

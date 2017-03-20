<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Affiliateorders extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$message_arr = array(''); 
	   
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function emi()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$message_arr = array(''); 
	   
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/emi",$message_arr);
		$this->load->view('templates/footer');
	}
	public function registeredCustomers() { 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$message_arr = array(''); 

		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/registeredCustomers",$message_arr);
		$this->load->view('templates/footer');
    }
	
	public function client_report() { 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		

		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/client_report");
		$this->load->view('templates/footer');
    }
	  
	  
	public function client_report_2() { 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/client_report_2");
		$this->load->view('templates/footer');
    } 
	
	public function client_report_3() {
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/client_report_3");
		$this->load->view('templates/footer');
    }
	
	public function order_product_report() { 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		

		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/order_product_report");
		$this->load->view('templates/footer');
    } 
	
	public function inventory_report() {
		$this->db->cache_delete_all();
		set_time_limit(0);	
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/inventory_report");
		$this->load->view('templates/footer');
    }
	
	public function magento_analytics() {
		$this->db->cache_delete_all();
		set_time_limit(0);	
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/magento_analytics");
		$this->load->view('templates/footer');
    }
	
	public function customer_enquiry() {
		$this->db->cache_delete_all();
		set_time_limit(0);	
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/customer_enquiry");
		$this->load->view('templates/footer');
    }
	
	
	public function buyers_n_subscribers()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$message_arr = array('');
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/buyers_n_subscribers",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function download()
	{
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		$user_type=$this->input->post('user_type') ;
		$date_from=$this->input->post('date_from') ;
		$date_to=$this->input->post('date_to') ;
		$mysql_date_from = $date_from.' 00:00:00'; 
	    $mysql_date_to = $date_to.' 23:59:59'; 
        $delimiter = ",";
        $newline = "\r\n";
		
		if($user_type=='Buyers') {
		
 		   $query  = "select Distinct b.email, b.firstname, b.lastname, b.region, b.postcode, a.state, a.base_grand_total, a.created_at ,a.customer_gender,a.customer_id,a.customer_dob,b.telephone, b.city, b.country_id from sales_flat_order a inner join sales_flat_order_address b on a.entity_id = b.parent_id where b.address_type = 'billing' and  a.created_at between '$mysql_date_from' AND '$mysql_date_to' group by b.email ";
		   $result = $this->db->query($query);
		   $resultarray 	= $result->result_array();
		  
			for($i=0;$i<count($resultarray);$i++) {
				$resultarray[$i]['country_id']= Mage::app()->getLocale()->getCountryTranslation($resultarray[$i]['country_id']);
				
				if($resultarray[$i]['customer_gender']=='1')
				{
					$resultarray[$i]['customer_gender'] = 'Male' ;
				}
				if($resultarray[$i]['customer_gender']=='2')
				{
				 $resultarray[$i]['customer_gender'] = 'Female' ;

				}
				
				 $date = date_create($resultarray[$i]['created_at']);
                 $resultarray[$i]['created_at'] = date_format($date, 'U');
			}
			
			$this->load->helper('csv'); 
			$this->load->dbutil(); 
			array_to_csv($resultarray,'buyers_'.date('d-M-Y').'.csv');
		}
		else {
		
			$query = "Select subscriber_id,subscriber_email,subscriber_status,gender,contact_no,affiliate_id,affiliate_term,affiliate_medium,affiliate_content,affiliate_source,subscription_date from newsletter_subscriber where subscriber_status=1 and subscription_date between '$mysql_date_from' AND '$mysql_date_to' " ;
			$result = $this->db->query($query);
			$resultarray 	= $result->result_array();
			for($i=0;$i<count($resultarray);$i++) {
				
				
				if($resultarray[$i]['gender']=='m')
				{
					$resultarray[$i]['gender'] = 'Male' ;
				}
				if($resultarray[$i]['gender']=='f')
				{
					$resultarray[$i]['gender'] = 'Female' ;
				}
				if($resultarray[$i]['gender']=='NULL')
				{
					$resultarray[$i]['gender'] = '' ;
				}
				
				
				$date = date_create($resultarray[$i]['subscription_date']);
                 $resultarray[$i]['subscription_date'] = date_format($date, 'U');
				
			}
			$this->load->helper('csv'); 
			$this->load->dbutil(); 
			array_to_csv($resultarray,'subscribers_'.date('d-M-Y').'.csv'); 		
		}
		
        
	}
	
	
	
		public function download1()
	{
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		$date_from=$this->input->post('date_from') ;
		$date_to=$this->input->post('date_to') ;
		$mysql_date_from = $date_from.' 00:00:00'; 
	    $mysql_date_to = $date_to.' 23:59:59'; 
        $delimiter = ",";
        $newline = "\r\n";
		
		
 		   $query  = "SELECT * from leadsquared where LastVisitDate between '$mysql_date_from' AND '$mysql_date_to'
				    
			ORDER BY id DESC";
		   $result = $this->db->query($query);
		   $resultarray 	= $result->result_array();
		  
		 
			
			$this->load->helper('csv'); 
			$this->load->dbutil(); 
			array_to_csv($resultarray,'leadactivity_'.date('d-M-Y').'.csv');

		
        
	}
	
	
	public function lead_squared_details()
	{
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/lead_squared_details");
		$this->load->view('templates/footer');
	
	}
	
	public function kwench_voucher_details() { 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		

		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/kwench_voucher_details");
		$this->load->view('templates/footer');
    }
	
		public function cancel_credit_memo() {
		$this->db->cache_delete_all();
		
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/cancel_credit_memo");
		$this->load->view('templates/footer');
    }
	public function change_payment_method() {
		$this->db->cache_delete_all();
		
		$this->load->view('templates/header'); 
		$this->load->view("affiliateorders/change_payment_method");
		$this->load->view('templates/footer');
    }
	
	public function leadactivity()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$message_arr = array(''); 
	   
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/leadactivity",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function order_status_history()
	{ 
		$this->db->cache_delete_all();
		 
		$this->load->view('templates/header'); 
        $this->load->view("affiliateorders/order_status_history");
		$this->load->view('templates/footer');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
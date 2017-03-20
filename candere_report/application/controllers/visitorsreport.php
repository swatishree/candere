<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Visitorsreport extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		
		$this->load->database();
	}

	public function index()
	{   
		$sql = "SELECT LV.visitor_id,LV.first_visit_at,LV.last_visit_at,LV.last_url_id,LU.visit_time,

		LUI.url,LUI.referer,LC.customer_id,LC.customer_id,LC.login_at,LC.logout_at,RVPI.product_id,RVPI.added_at,
		
		LVI.http_user_agent,SFQI.name,SFO.remote_ip
       
		FROM `log_visitor` as LV
        
		INNER JOIN log_url as LU ON LU.visitor_id=LV.visitor_id  
        
        INNER JOIN log_url_info as LUI ON LUI.url_id=LV.last_url_id 

		INNER JOIN log_customer as LC ON LC.visitor_id=LV.visitor_id

		INNER JOIN report_viewed_product_index as RVPI ON RVPI.visitor_id=LV.visitor_id
		
		INNER JOIN sales_flat_quote_item as SFQI ON SFQI.product_id=RVPI.product_id
		
		INNER JOIN log_visitor_info as LVI ON LVI.visitor_id=LV.visitor_id
       
		INNER JOIN sales_flat_order as SFO ON SFO.customer_id=LC.customer_id

        group by LV.visitor_id order by LV.visitor_id desc LIMIT 0,500
		
		";
			
		$results = $this->db->query($sql); 
		if(count($results->result_array())>0){ 
			
			$data['search_data']= $results->result_array();
		}	
		
		$this->load->view('templates/header'); 
        $this->load->view("visitorsreport/index",$data);
		$this->load->view('templates/footer');
		
	}
	 
	 
	 
	 
}

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cartabandoned extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database();
	}
	 
	public function index()
	{
		
		$first_day_current_mnth = date('Y-m-01').' 00:00:00';
		$current_date_time  = date('Y-m-d H:i:s',time()); 

		
		$date_from 		= strtotime($_POST['fromdatepicker']);
		$date_to 		= strtotime($_POST['todatepicker']);
	 
	 
		$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
		$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
		
		
		
		$data = array('');
		if($date_from!="" && $date_to!="" ){
			$term="AND sales_flat_quote.updated_at BETWEEN '$mysql_date_to' and '$mysql_date_from'";
		}else{
			$term="AND sales_flat_quote.updated_at BETWEEN '$first_day_current_mnth' and '$current_date_time'";
		}
		
	$sql = "SELECT sales_flat_quote.entity_id,
       sales_flat_quote.customer_email,
       sales_flat_quote.customer_firstname,
       sales_flat_quote.customer_lastname,
       sales_flat_quote.quote_currency_code,
       sales_flat_quote.updated_at,
       sales_flat_quote.affiliate_id,
       sales_flat_quote_item.product_id,
       sales_flat_quote_item.name as product_name
  FROM    sales_flat_quote_item sales_flat_quote_item
       INNER JOIN
          sales_flat_quote sales_flat_quote
       ON (sales_flat_quote_item.quote_id = sales_flat_quote.entity_id)
 WHERE      (    (    (    (    sales_flat_quote.customer_email IS NOT NULL
								$term
						   )
                      )
                 AND sales_flat_quote.is_active = 1)
            AND sales_flat_quote.items_count > 0)
GROUP BY sales_flat_quote.customer_email
ORDER BY sales_flat_quote.updated_at DESC";
		
		$results = $this->db->query($sql);  
		
		 
		 
		if(count($results->result_array())>0){ 
			$data['data']= $results->result_array();
		}
			$this->load->view('templates/header'); 
			$this->load->view("cartabandoned/index",$data);
			$this->load->view('templates/footer');
			
		} 
	}
	
	
	
	  


/* End of file main.php */
/* Location: ./application/controllers/main.php */
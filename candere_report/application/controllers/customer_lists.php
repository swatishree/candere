<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_lists extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}

	public function index()
	{   
		$this->db->cache_delete_all();
		if($_GET){
			$config['page_query_string'] = true; 
		}else{ 
			$config['page_query_string'] = false;
		}
		
		
		$todatepicker 		= ($this->input->get('todatepicker'));
		$fromdatepicker 	= ($this->input->get('fromdatepicker')); 
		$price 				= ($this->input->get('price'));
		$state	 			= ($this->input->get('order_status'));
		$from_flag = 0;
		$to_flag = 0;
		if(!empty($todatepicker)){
			$from_flag = 1;
			$from_date = $todatepicker;
		}
		
		if(!empty($fromdatepicker)){					
			$to_flag = 1;
			$to_date = $fromdatepicker; 							
		}
		
		
		if(!empty($country_id)){
			
			$countryList = Mage::getResourceModel('directory/country_collection')
							->loadData()
							->toOptionArray(false);
			$needle = $country_id;
			
			$country_name = '';
			
			//echo '<pre>'; print_r($countryList); echo '</pre>'; exit;
			
			foreach ($countryList as $key => $val) 
			{
			   if (strtolower($val['label']) === strtolower($needle)) {
				   $country_name = $val['value'];
				   break;
			   }
			}
			  
			$sql  		.= " AND SFOA.country_id like ('%$country_name%')"; 
		}

		
	 $sql = "SELECT DISTINCT sales_flat_order.state,
       sales_flat_order_item.name,
       sales_flat_order_item.sku,
       sales_flat_order.created_at,
       sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order_address.email,
       sales_flat_order_address.city,
       sales_flat_order_address.region,
       sales_flat_order_address.postcode,
       sales_flat_order_address.country_id,
       sales_flat_order_address.telephone,
       sales_flat_order_item.base_price AS product_price,
       sales_flat_order.base_grand_total
  FROM    (   sales_flat_order_item sales_flat_order_item
           INNER JOIN
              sales_flat_order sales_flat_order
           ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_order_address sales_flat_order_address
       ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
	   
	WHERE (    
			1
			
			)";
			
		if(!empty($to_date) || !empty($from_date)){
			
			$sql  		.= " AND sales_flat_order.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59'"; 
		} 
		
		if(!empty($_GET['order_status'])){
			
			
		
			$implode_state 	= implode("','",$_GET['order_status']); 
			
			$sql  		.= " AND sales_flat_order.state in ('$implode_state')";  
		}
		
					
		if(!empty($country_id)){
			
			$countryList = Mage::getResourceModel('directory/country_collection')
							->loadData()
							->toOptionArray(false);
			$needle = $country_id;
			
			$country_name = '';
			
			//echo '<pre>'; print_r($countryList); echo '</pre>'; exit;
			
			foreach ($countryList as $key => $val) 
			{
			   if (strtolower($val['label']) === strtolower($needle)) {
				   $country_name = $val['value'];
				   break;
			   }
			}
			  
			//$sql  		.= " AND SFOA.country_id like ('%$country_name%')"; 
		}
	 
		
		
		
		if(!empty($price)) {
			if($price == 'less_than_15k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=15000 "; 				
			}else if($price == 'less_than_30k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=30000 "; 				
			}else if($price == 'less_than_50k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=50000 ";
			}else if($price == 'more_than_50k'){
				$sql  		.= " AND sales_flat_order.base_grand_total >=50000 ";
			}
		}
			
		$sql .= " group by sales_flat_order.customer_id order by sales_flat_order.entity_id desc";
		
		$results = $this->db->query($sql);  
		
		 
		 
		if(count($results->result_array())>0 && $from_flag == 1 && $to_flag == 1){ 
			$data['data']= $results->result_array();
		}else{  
			$data['data']= array('noData'=>'emptydta');
		}	
		
 
		//$this->pagination->initialize($config);
		
		$this->load->view('templates/header'); 
        $this->load->view("customer_lists/index",$data);
		$this->load->view('templates/footer');
		
		
	}
public function export()
	{ 
		$message_arr = array('');
		$this->load->helper('csv');
		$order_status=$_GET['order_status'];
		//echo "<pre>"; print_r($order_status); die;
		//$order_status 	= implode("','",$_GET['order_status']); die;
		
		if($this->input->get()) {	
			
		$todatepicker 		= ($this->input->get('todatepicker'));
		$fromdatepicker 	= ($this->input->get('fromdatepicker')); 
		
		$state		        = $order_status; 
			 
			if(!empty($todatepicker)){
			$from_flag = 1;
			$from_date = $todatepicker;
		}
		
		if(!empty($fromdatepicker)){					
			$to_flag = 1;
			$to_date = $fromdatepicker; 							
		}
		
		if(!empty($state)){
			
			$implode_state = implode("','",$state); 
			 
		}
		}
		
		
		
		$sql = $this->getCsv($todatepicker,$fromdatepicker,$email,$region,$country_id,$price,$city,$postcode,$total_times_ordered
		,$firstname,$lastname,$state);
		
		
		
		foreach($sql->result_object as $row) {
			
			//****************************** get payment label query************************************
			
			
			
			
			$created_at 		= $row->created_at; 
			$name		 		= $row->name;
			$sku 				= $row->sku;
			$product_price 		= $row->product_price;
			$base_grand_total	= $row->base_grand_total;			
			$firstname 			= $row->firstname;
			$lastname			= $row->lastname;			
			$email 				= $row->email; 
			$region				= $row->region; 
			$city				= $row->city;			
			$Postcode 			= $row->postcode;
			$telephone			= $row->telephone;			
			$Postcode 			= $row->postcode;
						
						
			$array[] = array('created Date'=>$created_at, 'Product Name'=>$name,'Sku'=>$sku,'Product price'=>$product_price,'Grand Total'=>$base_grand_total,'Firstname'=>$firstname,'Lastname'=>$lastname,'Email'=>$email,'Region'=>$region,'City'=>$city,'Postcode'=>$Postcode,'Telephone'=>$telephone); 
		}
		
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 array_to_csv($array,'items_'.date('d-M-y').'.csv'); 
		 
	}

	public function getCsv($to_date,$from_date,$email,$region,$country_id,$price,$city,$postcode,$total_times_ordered
		,$firstname,$lastname,$state){	
			
		if(!empty($state)){
			
			$implode_state = $state;//implode("','",$state); 
			 
		}	
			
	   $sql = "SELECT DISTINCT sales_flat_order.state,
       sales_flat_order_item.name,
       sales_flat_order_item.sku,
       sales_flat_order.created_at,
       sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order_address.email,
       sales_flat_order_address.city,
       sales_flat_order_address.region,
       sales_flat_order_address.postcode,
       sales_flat_order_address.country_id,
       sales_flat_order_address.telephone,
       sales_flat_order_item.base_price AS product_price,
       sales_flat_order.base_grand_total
  FROM    (   sales_flat_order_item sales_flat_order_item
           INNER JOIN
              sales_flat_order sales_flat_order
           ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_order_address sales_flat_order_address
       ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
	   
 WHERE (    
			1
			
			)";
			
		if(!empty($to_date) || !empty($from_date)){
			
			$sql  		.= " AND sales_flat_order.created_at  between '$to_date 00:00:00' and '$from_date 23:59:59'"; 
		} 
		
		if(!empty($state)){
			
			$order_status1 	= explode(',',$state); 
		    $implode_state 	= implode("','",$order_status1);
			
			$sql  		.= " AND sales_flat_order.state in ('$implode_state')";  
		}
		
					
		if(!empty($country_id)){
			
			$countryList = Mage::getResourceModel('directory/country_collection')
							->loadData()
							->toOptionArray(false);
			$needle = $country_id;
			
			$country_name = '';
			
			
			
			foreach ($countryList as $key => $val) 
			{
			   if (strtolower($val['label']) === strtolower($needle)) {
				   $country_name = $val['value'];
				   break;
			   }
			}
			  
			//$sql  		.= " AND SFOA.country_id like ('%$country_name%')"; 
		}
	 
		
		
		
		if(!empty($price)) {
			if($price == 'less_than_15k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=15000 "; 				
			}else if($price == 'less_than_30k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=30000 "; 				
			}else if($price == 'less_than_50k'){
				$sql  		.= " AND sales_flat_order.base_grand_total <=50000 ";
			}else if($price == 'more_than_50k'){
				$sql  		.= " AND sales_flat_order.base_grand_total >=50000 ";
			}
		}
			
		$sql .= " group by sales_flat_order.customer_id order by sales_flat_order.entity_id desc";
			
		$results = $this->db->query($sql); 			
		$result = $results->result();  
		
		
		
		rsort($results); 
		return $results ;
	}	
	
	public function sold_product_count()
	{
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("customer_lists/sold_product_count");
		$this->load->view('templates/footer');
	
	}
	 
	 
	 
	 
}

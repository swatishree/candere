<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_product_orders_count extends CI_Controller  {
	
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
		 
		$sku 				= ($this->input->get('sku'));
		
		$total_times_ordered= ($this->input->get('times_ordered'));
		 
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
		
		if(!empty($state)){
			
			$implode_state = implode("','",$state); 
			 
		}
		
		$sql = "select 
			sales_flat_order.customer_id,
			sales_flat_order.customer_email,
			CONCAT_WS(' ',sales_flat_order.customer_firstname,sales_flat_order.customer_lastname) as customer_name , 
			( select count(sfo.entity_id) from sales_flat_order sfo where sfo.customer_id = sales_flat_order.customer_id and sfo.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59' and sfo.state in ('$implode_state'))	as times_ordered,    
			( select count(sfo.entity_id) from sales_flat_order sfo where sfo.customer_id = sales_flat_order.customer_id and sfo.state = 'complete' and sfo.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59') as complete_orders, 
			( select count(sfo.entity_id) from sales_flat_order sfo where sfo.customer_id = sales_flat_order.customer_id and sfo.state = 'processing' and sfo.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59') as processing_orders,
			((select  country_id from sales_flat_order_address join sales_flat_order sfo on (sales_flat_order_address.parent_id = sfo.entity_id) where  sales_flat_order_address.address_type='billing' and sfo.customer_id = sales_flat_order.customer_id group by sfo.customer_id))  as country_id,
			((select  region from sales_flat_order_address join sales_flat_order sfo on (sales_flat_order_address.parent_id = sfo.entity_id) where  sales_flat_order_address.address_type='billing' and sfo.customer_id = sales_flat_order.customer_id group by sfo.customer_id))  as region,
			((select  city from sales_flat_order_address join sales_flat_order sfo on (sales_flat_order_address.parent_id = sfo.entity_id) where  sales_flat_order_address.address_type='billing' and sfo.customer_id = sales_flat_order.customer_id group by sfo.customer_id))  as city,
			((select  postcode from sales_flat_order_address join sales_flat_order sfo on (sales_flat_order_address.parent_id = sfo.entity_id) where  sales_flat_order_address.address_type='billing' and sfo.customer_id = sales_flat_order.customer_id group by sfo.customer_id))  as postcode 
		from 
			sales_flat_order where 1 ";
		
	
		
		if(!empty($todatepicker) || !empty($fromdatepicker)){
			$sql  		.= " AND sales_flat_order.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59'"; 
		} 
		 
		if(!empty($email)){
			$sql  		.= " AND sales_flat_order.customer_email like ('%$email%')"; 
		}
		
		if(!empty($state)){
			
			$implode_state = implode("','",$state); 
			$sql  		.= " AND sales_flat_order.state in ('$implode_state')"; 
		}
	 
		if(!empty($firstname)){
			$sql  		.= " AND sales_flat_order.customer_firstname like '%$firstname%'"; 
		} 
		
		if(!empty($lastname)){
			$sql  		.= " AND sales_flat_order.customer_lastname like '%$lastname%'"; 
		} 
		  
		$get_data = http_build_query($_GET);
		
		$config['base_url'] 	= base_url()."index.php/customer_orders_count/index/pageno?$get_data"; 
		$config['total_rows'] 	= (($from_flag == 1 && $to_flag == 1)?$this->db->query($sql)->num_rows():0);
		$config['per_page'] 	= 50;
		$config['uri_segment'] 	= 1;
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
		
		$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;
		if($start != 0){ 
			$start = (($start - 1) * $limit); 
		}else{
			 $start = 0; 
		} 
		
		$data['total_count'] = $this->db->query($sql)->num_rows(); 
		
		
		//$sql .= " group by sales_flat_order.customer_id order by sales_flat_order.entity_id desc limit  $start, $limit";
		$sql .= " group by sales_flat_order.customer_id order by sales_flat_order.entity_id desc";
		 
		$results = $this->db->query($sql);  
		
		 
		 
		if(count($results->result_array())>0 && $from_flag == 1 && $to_flag == 1){ 
			$data['data']= $results->result_array();
		}else{  
			$data['data']= array('noData'=>'emptydta');
		}	
		
 
		//$this->pagination->initialize($config);
		
		$this->load->view('templates/header'); 
        $this->load->view("customer_product_orders_count/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	 
	 
	 
}

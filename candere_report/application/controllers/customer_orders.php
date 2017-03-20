<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_orders extends CI_Controller  {
	
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
		$city 				= ($this->input->get('city'));
		$region 			= ($this->input->get('region'));
		$country_id 		= ($this->input->get('country_id'));
		$postcode 			= ($this->input->get('postcode'));
		$firstname 			= ($this->input->get('first_name'));
		$lastname 			= ($this->input->get('last_name'));
		$affiliate_source 	= ($this->input->get('affiliate_source'));
		$affiliate_medium 	= ($this->input->get('affiliate_medium'));
		
		$sql = "
		select 			
			sales_flat_order.increment_id,
			CONCAT_WS(' ',sales_flat_order.customer_firstname,sales_flat_order.customer_lastname) as customer_name,
			sales_flat_order.customer_email,
			sales_order_status_label.label as status,
			sales_flat_order.remote_ip,
			sales_flat_order.order_currency_code,
			sales_flat_order.created_at,
			sales_flat_order_item.sku,
			sales_flat_order_item.name,
			sales_flat_order_item.base_price,
			sales_flat_order_item.price,
			sales_flat_order_item.base_discount_amount,
			sales_flat_order_item.discount_amount,
			sales_flat_order.base_grand_total,
			sales_flat_order.base_total_paid,
			sales_flat_order.grand_total,
			sales_flat_order.total_paid,
			sales_flat_order_address.country_id,
			sales_flat_order_address.city,
			sales_flat_order_address.region,
			sales_flat_order_address.postcode,
			sales_flat_order.coupon_code,
			sales_flat_order.coupon_code2,
			sales_flat_order.coupon_code3,
			sales_flat_order.coupon_code4,
			sales_flat_order.coupon_code5,
			
		  `sales_flat_order`.affiliate_id,
		  `sales_flat_order`.affiliate_source,
		  `sales_flat_order`.affiliate_medium,
		  `sales_flat_order`.affiliate_term,
		  `sales_flat_order`.affiliate_content
				from sales_flat_order 
					join 
				sales_flat_order_address 
					on ( sales_flat_order.entity_id = sales_flat_order_address.parent_id )
				 join sales_flat_order_item 
					on (sales_flat_order.entity_id = sales_flat_order_item.order_id) 
					
				join sales_order_status_label on (sales_order_status_label.status = sales_flat_order.status)	
					where  sales_flat_order_address.address_type = 'billing'";
		
		if(!empty($todatepicker)){
			$from_date = $todatepicker;
		}
		
		if(!empty($fromdatepicker)){					
			$to_date = $fromdatepicker; 							
		}
		
		if(!empty($todatepicker) || !empty($fromdatepicker)){
			$sql  		.= " AND sales_flat_order.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59'"; 
		} 
				
		 
		if(!empty($email)){
			$sql  		.= " AND sales_flat_order.email like ('%$email%')"; 
		}
		
		if(!empty($city)){
			$sql  		.= " AND sales_flat_order_address.city like ('%$city%')"; 
		}
		
		if(!empty($region)){
			$sql  		.= " AND sales_flat_order_address.region like ('%$region%')"; 
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
			  
			$sql  		.= " AND sales_flat_order_address.country_id like ('%$country_name%')"; 
		}
		
		if(!empty($postcode)){
			$sql  		.= " AND sales_flat_order_address.postcode like ('%$postcode%')"; 
		}
		
		if(!empty($firstname)){
			$sql  		.= " AND sales_flat_order.customer_firstname like '%$firstname%'"; 
		} 
		
		if(!empty($lastname)){
			$sql  		.= " AND sales_flat_order.customer_lastname like '%$lastname%'"; 
		} 
		
		
		if(!empty($affiliate_source) || !empty($affiliate_source)){
			$sql  		.= " AND `sales_flat_order`.affiliate_source like '%$affiliate_source%'"; 
		} 
		
		if(!empty($affiliate_medium) || !empty($affiliate_medium)){
			$sql  		.= " AND `sales_flat_order`.affiliate_medium like '%$affiliate_medium%'"; 
		} 
		 
		$get_data = http_build_query($_GET);
		
		$config['base_url'] 	= base_url()."index.php/customer_orders/index/pageno?$get_data"; 
		$config['total_rows'] 	= $this->db->query($sql)->num_rows();
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
		
		
		$sql .= " order by sales_flat_order.created_at desc limit  $start, $limit";
		 
		$results = $this->db->query($sql);  
		
		
		 
		if(count($results->result_array())>0){ 
			$data['data']= $results->result_array();
		}else{  
			$data['data']= array('noData'=>'emptydta');
		}	
		$this->pagination->initialize($config);
		
		$this->load->view('templates/header'); 
        $this->load->view("customer_orders/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	 
	 
	 
}

<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Abandoned_carts extends CI_Controller  {
	
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
		$name 				= ($this->input->get('name'));
		
		$sql = "SELECT
				  `main_table`.created_at,
				  `main_table`.updated_at,
				  `main_table`.items_qty,
				  `main_table`.quote_currency_code,
				  `main_table`.base_currency_code,
				  `main_table`.grand_total,
				  `main_table`.base_grand_total,
				  `main_table`.customer_email,
				  `main_table`.customer_firstname,
				  `main_table`.customer_lastname,
				  `main_table`.coupon_code,
				  `main_table`.coupon_code2,
				  `main_table`.coupon_code3,
				  `main_table`.coupon_code4,
				  `main_table`.coupon_code5,
				  `main_table`.customer_gender,
				  `main_table`.greeting_card_from,
				  `main_table`.greeting_card_to,
				  `main_table`.greeting_card,
				  `main_table`.personal_message,
				  `main_table`.affiliate_id,
				  `main_table`.affiliate_source,
				  `main_table`.affiliate_medium,
				  `main_table`.affiliate_term,
				  `main_table`.affiliate_content, 
				  quote_item.sku AS `sku`,
				  quote_item.name AS `name`,
				  quote_item.price AS `price`,
				  `option`.value as options
				FROM `sales_flat_quote` AS `main_table`
				INNER JOIN `sales_flat_quote_item` AS `quote_item` ON quote_item.quote_id = main_table.entity_id
				INNER JOIN `sales_flat_quote_item_option` AS `option` ON option.item_id = quote_item.item_id
				  INNER JOIN `customer_entity` AS `cust_email` ON cust_email.entity_id = main_table.customer_id
				  INNER JOIN `customer_entity_varchar` AS `cust_fname`
					ON cust_fname.entity_id = main_table.customer_id AND cust_fname.attribute_id = 5
				  INNER JOIN `customer_entity_varchar` AS `cust_lname`
					ON cust_lname.entity_id = main_table.customer_id AND cust_lname.attribute_id = 7
				WHERE (items_count != '0') AND (main_table.is_active = '1') AND (option.code = 'additional_options')";
		 
		 
	 
		if(!empty($todatepicker)){
			$from_date = $todatepicker;
		}
		
		if(!empty($fromdatepicker)){					
			$to_date = $fromdatepicker; 							
		}
		
		if(!empty($todatepicker) || !empty($fromdatepicker)){
			$sql  		.= " AND `main_table`.created_at  between '$from_date 00:00:00' and '$to_date 23:59:59'"; 
		} 
		
		if(!empty($name) || !empty($name)){
			$sql  		.= " AND `quote_item`.name like '%$name%'"; 
		}
		
		if(!empty($sku) || !empty($sku)){
			$sql  		.= " AND `quote_item`.sku like '%$sku%'"; 
		} 
		
		if(!empty($affiliate_source) || !empty($affiliate_source)){
			$sql  		.= " AND `quote_item`.affiliate_source like '%$affiliate_source%'"; 
		} 
		
		if(!empty($affiliate_medium) || !empty($affiliate_medium)){
			$sql  		.= " AND `quote_item`.affiliate_medium like '%$affiliate_medium%'"; 
		} 
		 
		
		$get_data = http_build_query($_GET);
		
		$config['base_url'] 	= base_url()."index.php/abandoned_carts/index/pageno?$get_data"; 
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
		
		
		$sql .= " order by created_at desc limit  $start, $limit";
		 
		$results = $this->db->query($sql);  
		
		
		 
		if(count($results->result_array())>0){ 
			$data['data']= $results->result_array();
		}else{  
			$data['data']= array('noData'=>'emptydta');
		}	
		$this->pagination->initialize($config);
		
		$this->load->view('templates/header'); 
        $this->load->view("abandoned_carts/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	 
	 
	 
}

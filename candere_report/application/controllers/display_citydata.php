<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Display_citydata extends CI_Controller  {
	 private $user_account = 'user_account';
    private $user_info = 'user_info';
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		
		if($_GET){
		 
			$config['page_query_string'] = true;
			
		}else{
		 
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount = $this->db->count_all('sales_flat_order_address');
				
		$config['base_url'] 	= base_url()."index.php/display_citydata/index";
		$config['total_rows'] 	= $recordsCount;
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
		//$config['page_query_string'] = true;
			
		
		$limit = $config['per_page'];
		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
		
		$data = array('');
		
		$sql = "select sales_flat_order.increment_id as 'Order_Id',SFOA.postcode,SFOA.city,SFOI.name as 'Product_Name', sales_flat_order.created_at,SFOA.region_id,DCR.default_name,
		SFOI.sku as Sku,CONCAT(IFNULL(sales_flat_order.customer_firstname,' '),' ',IFNULL(sales_flat_order.customer_lastname,' ')) as 'Custome_Name',SFOI.base_price,sales_flat_order.remote_ip
		
		from sales_flat_order
		INNER join sales_flat_order_address SFOA on (sales_flat_order.entity_id=SFOA.parent_id)
		INNER join directory_country_region DCR on (DCR.region_id=SFOA.region_id)
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		
	    order by sales_flat_order.increment_id desc limit $start, $limit";
		
		$count_sql_query = "select sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name', 
		SFOI.sku as Sku,CONCAT(IFNULL(sales_flat_order.customer_firstname,' '),' ',IFNULL(sales_flat_order.customer_lastname,' ')) as 'Custome Name',SFOI.base_price
		
		from sales_flat_order
		
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		
	    order by sales_flat_order.increment_id desc";
		
		if($this->input->get()) {	
			
			$limit 				= $limit ;
					
			$address_type 		= $this->input->get('address_type'); 
			$city 			     = $this->input->get('city'); 
			$postcode 			= $this->input->get('postcode' );
			$todatepicker 		= $this->input->get('todatepicker');//strtotime($this->input->get('todatepicker'));
			$fromdatepicker 	= $this->input->get('fromdatepicker');//strtotime($this->input->get('fromdatepicker'));
			$created_at 	    =($this->input->get('created_at'));
			$region 			= implode("','",$this->input->get('region'));
			$order_status 	    = implode("','",$this->input->get('order_status')); 
			
			$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;	
			
			$start = ($start !== 0) ? (int)$start : 1;
			$start = (($start - 1) * $limit); 	
			
			
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/display_citydata/index/pageno?$get_data";
			
			$search_array = array();
			
			if(!empty($address_type)){
				$search_array['address_type'] = "SFOA.address_type = '".$address_type."'" ;
				
			}
			
			if(!empty($city)){
				$search_array['city'] = "SFOA.city LIKE '%".$city."%'";
				
			}
			
			if(!empty($postcode)){
				$search_array['postcode'] = "SFOA.postcode ='".$postcode."'" ;
				
				
			}  
			
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
			if(!empty($created_at)){					
			
				$search_array['created_at']  = "sales_flat_order.created_at LIKE '%".$created_at."%'"  ;				
			}
			
			if(!empty($todatepicker) || !empty($fromdatepicker)){
				$search_array['date']  = "sales_flat_order.created_at between '$from_date' and '$to_date'";
			}
			if(!empty($order_status)){
				$search_array['order_status'] = "sales_flat_order.status in ('$order_status')"  ; 
			}
			if(!empty($region)){
				$search_array['region'] = "SFOA.region in ('$region')"  ; 
			}
				
					
			$condition = implode(' AND ',$search_array); 
			
		$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;	
			
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
			
		$sql = "select  sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name', 
		SFOI.sku as Sku,CONCAT(IFNULL(sales_flat_order.customer_firstname,' '),' ',IFNULL(sales_flat_order.customer_lastname,' ')) as 'Custome_Name',SFOI.base_price,sales_flat_order.remote_ip,SFOA.region ,DCR.default_name,SFOA.city,SFOA.postcode
		
		from sales_flat_order
		INNER join sales_flat_order_address SFOA on (sales_flat_order.entity_id=SFOA.parent_id)
		INNER join directory_country_region DCR on (DCR.region_id=SFOA.region_id)
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		where  $condition
	    order by sales_flat_order.increment_id desc limit $start, $limit";
		
		$count_sql_query = "select  sales_flat_order.increment_id as 'Order_Id'
		
		from sales_flat_order
		INNER join sales_flat_order_address SFOA on (sales_flat_order.entity_id=SFOA.parent_id)
		INNER join directory_country_region DCR on (DCR.region_id=SFOA.region_id)
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		where  $condition
	    order by sales_flat_order.increment_id desc";
			
			$data['limit'] 		= $limit;
			$data['start'] 		= $start;
					
		}
		 
		$results = $this->db->query($sql);  
		$count_sql_query_result = $this->db->query($count_sql_query);  
		
		$recordsCount = $count_sql_query_result->num_rows();
				
		if(count($results->result_array())>0){ 
			$data['search_data']= $results->result_array();
		}else{  
			$data['search_data']= array('noData'=>'emptydta');
		}	
		
		
		$config['total_rows'] 	= $recordsCount;
		
		$this->pagination->initialize($config);
						
		
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['results_count'] = $recordsCount;
		$this->load->view('templates/header'); 
        $this->load->view("display_citydata/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	
	
	
	//************************************************** Last Updated by Bharat 281215 *****************************
	public function getCsv(){
		 
		
		if($this->input->get()) {	
			
			
			$address_type 		= $this->input->get('address_type'); 
			$city 			    = $this->input->get('city'); 
			$postcode 			= $this->input->get('postcode' );
			$todatepicker 		= $this->input->get('todatepicker');//strtotime($this->input->get('todatepicker'));
			$fromdatepicker 	= $this->input->get('fromdatepicker');//strtotime($this->input->get('fromdatepicker'));
			$created_at 	    =($this->input->get('created_at'));
			$region1 			= $this->input->get('region');// implode("','",$this->input->get('region'));
			$order_status1 	    = $this->input->get('order_status');//implode("'' '",$this->input->get('order_status')); 
			
			$order_status1 	= explode(',',$order_status1); 
		    $order_status 	= implode("','",$order_status1);
			
			$region1 	= explode(',',$region1); 
		    $region 	= implode("','",$region1);
			
			
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/display_citydata/index/pageno?$get_data";
			
			$search_array = array();
			
			if(!empty($address_type)){
				$search_array['address_type'] = "SFOA.address_type = '".$address_type."'" ;
				
			}
			
			if(!empty($city)){
				$search_array['city'] = "SFOA.city LIKE '%".$city."%'";
				
			}
			
			if(!empty($postcode)){
				$search_array['postcode'] = "SFOA.postcode ='".$postcode."'" ;
				
				
			}  
			
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
			if(!empty($created_at)){					
			
				$search_array['created_at']  = "sales_flat_order.created_at LIKE '%".$created_at."%'"  ;				
			}
			
			if(!empty($todatepicker) || !empty($fromdatepicker)){
				$search_array['date']  = "sales_flat_order.created_at between '$from_date' and '$to_date'";
			}
			if(!empty($order_status)){
				$search_array['order_status'] = "sales_flat_order.status in ('$order_status')"  ; 
			}
			if(!empty($region)){
				$search_array['region'] = "SFOA.region in ('$region')"  ; 
			}
				
					
		$condition = implode(' AND ',$search_array);
		
			
		$sql = "select DISTINCT sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name', 
		SFOI.sku as Sku,CONCAT(IFNULL(sales_flat_order.customer_firstname,' '),' ',IFNULL(sales_flat_order.customer_lastname,' ')) as 'Custome_Name',SFOI.base_price,sales_flat_order.remote_ip,SFOA.region ,DCR.default_name as 'State',SFOA.city,SFOA.postcode
		
		from sales_flat_order
		INNER join sales_flat_order_address SFOA on (sales_flat_order.entity_id=SFOA.parent_id)
		INNER join directory_country_region DCR on (DCR.region_id=SFOA.region_id)
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		where  $condition
	    order by sales_flat_order.increment_id desc";
			
			
		}
		 
		 
		$results = $this->db->query($sql);  
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		$delimiter = ",";
        $newline = "\r\n";
		$data = $this->dbutil->csv_from_result($results, $delimiter, $newline);
	   	force_download('Report--'.date('d-m-Y H-i').".csv", $data);
		
	}
	
	 
	 
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
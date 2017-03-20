<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wishlist_report extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}

	public function index()
	{ //echo "==";
	
	
	
	if($_GET){
		 
			$config['page_query_string'] = true;
			
		}else{
		 
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount = $this->db->count_all('wishlist_item');
				
		$config['base_url'] 	= base_url()."index.php/wishlist_report/index";
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





	$sql = "SELECT b.email, c.value AS name, f.entity_id as pid,a.updated_at, d.added_at, d.product_id,e.sku as Sku, e.name, SUM(g.qty_ordered) AS purchased
				FROM `wishlist` AS a
				INNER JOIN customer_entity AS b ON a.customer_id = b.entity_id
				INNER JOIN customer_entity_varchar AS c ON a.customer_id = c.entity_id AND c.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'firstname' AND entity_type_id = b.entity_type_id)
				INNER JOIN wishlist_item AS d ON a.wishlist_id = d.wishlist_id
				INNER JOIN catalog_product_flat_1 AS e ON d.product_id = e.entity_id
				LEFT JOIN sales_flat_order AS f ON f.customer_email = b.email
				LEFT JOIN sales_flat_order_item AS g ON (f.entity_id = g.order_id AND g.sku LIKE CONCAT(e.sku,'%') AND g.product_type = 'simple')
				GROUP BY b.email, c.value, a.updated_at, d.added_at, d.product_id, e.name  desc limit $start, $limit";
		
		$count_sql_query = "SELECT b.email, c.value AS name, f.entity_id as pid,a.updated_at, d.added_at, d.product_id,e.sku as Sku, e.name, SUM(g.qty_ordered) AS purchased
				FROM `wishlist` AS a
				INNER JOIN customer_entity AS b ON a.customer_id = b.entity_id
				INNER JOIN customer_entity_varchar AS c ON a.customer_id = c.entity_id AND c.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'firstname' AND entity_type_id = b.entity_type_id)
				INNER JOIN wishlist_item AS d ON a.wishlist_id = d.wishlist_id
				INNER JOIN catalog_product_flat_1 AS e ON d.product_id = e.entity_id
				LEFT JOIN sales_flat_order AS f ON f.customer_email = b.email
				LEFT JOIN sales_flat_order_item AS g ON (f.entity_id = g.order_id AND g.sku LIKE CONCAT(e.sku,'%') AND g.product_type = 'simple')
				GROUP BY b.email, c.value, a.updated_at, d.added_at, d.product_id, e.name desc";
		
			if($this->input->get()) {	
				
				$limit 				= $limit ;
				
				$todatepicker 		= $this->input->get('todatepicker');//strtotime($this->input->get('todatepicker'));
				$fromdatepicker 	= $this->input->get('fromdatepicker');//strtotime($this->input->get('fromdatepicker'));
							
				$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;	
			
			//$start = ($start !== 0) ? (int)$start : 1;
			//$start = (($start - 1) * $limit); 	
			
			
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/wishlist_report/index/pageno?$get_data";
			
			$search_array = array(); 
			
				
			
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
			
			if(!empty($todatepicker) || !empty($fromdatepicker)){
				$condition  = "d.added_at >= '$from_date 00:00:00' and  d.added_at <= '$to_date 23:59:59'"; 
			}
				
				
					
			//$condition = implode(' AND ',$search_array); 
			
			
			
			$sql = "SELECT b.email, c.value AS name, f.entity_id as pid,a.updated_at, d.added_at, d.product_id,e.sku as Sku, e.name, SUM(g.qty_ordered) AS purchased FROM `wishlist` AS a INNER JOIN customer_entity AS b ON a.customer_id = b.entity_id  INNER JOIN customer_entity_varchar AS c ON a.customer_id = c.entity_id AND c.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'firstname' AND entity_type_id = b.entity_type_id) INNER JOIN wishlist_item AS d ON a.wishlist_id = d.wishlist_id INNER JOIN catalog_product_flat_1 AS e ON d.product_id = e.entity_id LEFT JOIN sales_flat_order AS f ON f.customer_email = b.email  LEFT JOIN sales_flat_order_item AS g ON (f.entity_id = g.order_id AND g.sku LIKE CONCAT(e.sku,'%') AND g.product_type = 'simple') where ($condition) GROUP BY d.added_at desc limit $start, $limit";  
			
			$count_sql_query = "SELECT b.email, c.value AS name, f.entity_id as pid,a.updated_at, d.added_at, d.product_id,e.sku as Sku, e.name, SUM(g.qty_ordered) AS purchased
				FROM `wishlist` AS a
				INNER JOIN customer_entity AS b ON a.customer_id = b.entity_id
				INNER JOIN customer_entity_varchar AS c ON a.customer_id = c.entity_id AND c.attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'firstname' AND entity_type_id = b.entity_type_id)
				INNER JOIN wishlist_item AS d ON a.wishlist_id = d.wishlist_id
				INNER JOIN catalog_product_flat_1 AS e ON d.product_id = e.entity_id
				LEFT JOIN sales_flat_order AS f ON f.customer_email = b.email
				LEFT JOIN sales_flat_order_item AS g ON (f.entity_id = g.order_id AND g.sku LIKE CONCAT(e.sku,'%') AND g.product_type = 'simple')
				where ($condition) GROUP BY d.added_at";
			
			$data['limit'] 		= $limit;
			$data['start'] 		= $start; 
					
		}
		
		
		
		
		
	    $resource 		= Mage::getSingleton('core/resource');
	    $readConnection = $resource->getConnection('core_read');  
				
	
		$results = $this->db->query($sql); 
		
		$count_sql_query_result = $this->db->query($count_sql_query);  
		
		$recordsCount = $count_sql_query_result->num_rows();
		 
		//$recordsCount = $results->num_rows();
				
		if(count($results->result_array())>0){ 
			$data['search_data']= $results->result_array();
		}else{  
			$data['search_data']= array('noData'=>'emptydta');
		}	
		
		//
		$config['total_rows'] 	= $recordsCount;
		
		$this->pagination->initialize($config);
						
		
		//$data['limit'] = $limit;
		//$data['start'] = $start;
		$data['results_count'] = $recordsCount;
		$this->load->view('templates/header'); 
        $this->load->view("wishlist_report/index",$data);
		$this->load->view('templates/footer');
		
		
	}



	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
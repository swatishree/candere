<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_ordered extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		
		$message_arr = array(''); 
	  
	 
		$this->load->view('templates/header'); 
        $this->load->view("products_ordered/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function exportproductsorderedcount()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		 
		$sql =	"SELECT distinct state from sales_order_status_state"; 

		$results = $this->db->query($sql);
		
		$results_order_state = $this->db->query($sql);
			 
		$result_state = $results_order_state->result_array();
		
		
		
		
		$product_header = array(
			 
				'0'=>'Product Name',
				'1'=>'Sku',
			 
		);
		  
		$header = array();
		foreach($result_state as $order_state){ 
		
			$header[] = $order_state['state'];
		}
		 
		 $result_header[] = array_merge($product_header, $header);
		 
	 
		$sql = "select distinct name,product_id,sku from sales_flat_order_item join sales_flat_order on sales_flat_order_item.order_id = sales_flat_order.entity_id order by sales_flat_order.entity_id desc";
				
		$results_products_ordered = $this->db->query($sql);
	 
		$result_product_array = $results_products_ordered->result_array();
		
		 
		foreach($result_product_array as $key=>$result_products){ 
			 
				$table_array_data[$result_products['product_id']][] = $result_products['name'];
				$table_array_data[$result_products['product_id']][] = $result_products['sku'];
			 
				foreach($result_state as $order_state){
					
					
				$sql = 'select count(product_id) as count from sales_flat_order_item join sales_flat_order on (sales_flat_order_item.order_id = sales_flat_order.entity_id)   where sales_flat_order_item.product_id = '.$result_products['product_id'].' and sales_flat_order.state = "'.$order_state['state'].'"';
					
					$query = $this->db->query($sql);
					$res = $query->result();  // this returns an object of all results
					
				 
					$row = $res[0]->count;     
					 
					$table_array_data[$result_products['product_id']][] = $row; 
					
				} 
				 
		} 
		$result = array_merge($result_header, $table_array_data);
		  
		array_to_csv($result,'sales_orders_with_products_count'.date('d-M-y').'.csv');
	}
	 
	 
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */

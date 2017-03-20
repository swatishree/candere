<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_price extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
		set_time_limit(0);
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		$this->load->view('templates/header'); 
        $this->load->view('export_price/index',$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export_product_price()
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$range_from	= $_REQUEST['range_from'];
		$range_to	= $_REQUEST['range_to'];
		
		$whr_data_string = '';
		
		if($range_from != '' && $range_to != '')
		{
			$whr_data_string = 'and date_range between "'.$range_from.'" and "'.$range_to.'"';
			
		}
		//$whr_data_string =  'and diamond_name="SIIJ"';
		
		$sel_products = "select * from erp_order order by id desc";
		
		$res_products = mysql_query($sel_products);
		while($row_products = mysql_fetch_assoc($res_products))
		{			
			$order_id			= $row_products['order_id'];
			$name 				= $row_products['customer_name']." ".$row_products['customer_lastname'];
			$email	 			= $row_products['customer_email'];
			$product_name 		= $row_products['product_name'];
			$sku		 		= $row_products['sku'];
			$selling_price		= $row_products['unit_price'];
			$actual_cost_price	= $row_products['actual_cost_price'];	

			$array[] = array('Order Id'=>$order_id, 'Customer Name'=>$name, 'Email'=>$email, 'Product Name'=>$product_name, 'SKU'=>$sku, 'Selling Price'=>$selling_price, 'Actual Cost Price'=>$actual_cost_price);
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_price_'.date('d-M-y'));
		unset($array);
		
	}
}
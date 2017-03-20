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
		$range_from	= date('Y-m-d', strtotime($_REQUEST['range_from'])); 
		$range_to	= date('Y-m-d', strtotime($_REQUEST['range_to']));
		$whr_str = '';
		if($range_from != '1970-01-01' && $range_to != '1970-01-01'):
			$whr_str = "where order_placed_date between '".$range_from."' and '".$range_to."'";
		endif;
		
		$sel_products = "select * from erp_order $whr_str order by id desc";	
		$query 			 = $this->db->query($sel_products);
		$row_products	 = $query->result();
		
		$data['selectdata'] = $row_products;			
		$this->load->view('templates/header');
		$this->load->view('export_price/index',$data);	
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
		    $currency_code		= $row_products['order_currency_code'];
			$baseCurrencyCode 	= Mage::app()->getBaseCurrencyCode();			
			$allowedCurrencies	= Mage::getModel('directory/currency')->getConfigAllowCurrencies();			
			$currencyRates 		= Mage::getModel('directory/currency')->getCurrencyRates($baseCurrencyCode, array_values($allowedCurrencies));						
			$currency_rate 		= $selling_price / $currencyRates[$currency_code];
			
			$margin 			= (($currency_rate - $actual_cost_price) / $currency_rate) * 100;
			
			
			
			$array[] = array('Order Id'=>$order_id, 'Customer Name'=>$name, 'Email'=>$email, 'Product Name'=>$product_name, 'SKU'=>$sku, 'Selling Price'=>$currency_rate, 'Actual Cost Price'=>$actual_cost_price, 'Margin'=>$margin);
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_price_'.date('d-M-y'));
		unset($array);
		
	}
}
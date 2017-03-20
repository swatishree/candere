<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_position extends CI_Controller  {
	
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
        $this->load->view('export_position/index',$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function position()
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$todays_date = date('Y-m-d h:i:s');
		$new_timestamp = strtotime('-3 months', strtotime($todays_date));
		$date_interval =  date("Y-m-d h:i:s",$new_timestamp);
		echo $sel_products = "select sku, product_id from sales_flat_order_item where created_at between '".$date_interval."' and '".$todays_date."'"; exit;
		$res_products = mysql_query($sel_products);
		while($row_products = mysql_fetch_assoc($res_products))
		{
			$sku	 = $row_products['sku'];
			$product_id	 = $row_products['product_id'];
			$array[] = array('sku'=>$sku, 'product_id'=>$product_id);
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_position_items_'.date('d-M-y'));
		unset($array);
		
	}
}
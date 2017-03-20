<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_default_price extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
		set_time_limit(0);
	}
	 
	public function index()
	{
		$range_from		= date('Y-m-d', strtotime($_REQUEST['range_from'])); 
		$range_to		= 	date('Y-m-d', strtotime($_REQUEST['range_to']));
		
		$sku			=	$_REQUEST['sku'];
		$product_type	=	$_REQUEST['product_type'];
		$whr_str 	= '';		
		
		if($sku != '')
		{
			$whr_str = "where sku like  '%".$sku."%' ";
		}
		elseif($product_type != '')
		{
			$whr_str = "where material_value like  '%".$product_type."%' ";
		}
		else
		{
			if($range_from != '1970-01-01' && $range_to != '1970-01-01'):
				$whr_str = "where created_at between '".$range_from."' and '".$range_to."'";
			else:
				$todays_date				=	date('Y-m-d');
				$date						=	date_create($todays_date);
				date_sub($date,date_interval_create_from_date_string("10 days"));
				$range_from					=	date_format($date,"Y-m-d");
				$range_to					=	date('Y-m-d');
				$whr_str = "where created_at between '".$range_from."' and '".$range_to."'";
			endif;
		}
		
		$sel_products 	 = "select * from catalog_product_flat_1 $whr_str order by entity_id desc limit 0, 100";	
		$query 			 = $this->db->query($sel_products);
		$row_products	 = $query->result();		

		$data['selectdata'] = $row_products;
		$this->load->view('templates/header');
		$this->load->view('export_default_price/index',$data);	
	}
}
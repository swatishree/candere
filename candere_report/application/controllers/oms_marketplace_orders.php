<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Oms_Marketplace_Orders extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
		set_time_limit(0);
	}
	
	public function index() 
	{
		$this->load->view('templates/header'); 
        $this->load->view("oms_marketplace_orders/index");
		$this->load->view('templates/footer');
	}
	
	public function export() 
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT erp_order.order_id,   erp_order.marketplace_item_id,   concat(erp_order.customer_name, ' ', erp_order.customer_lastname)      AS customer_name,   erp_order.customer_email,   erp_order.contact_number,   erp_order.buyer_address,   erp_order.shipping_country,   erp_order.sku,   erp_order.product_name,   erp_order.expected_delivery_date,   erp_order.dispatch_date,   erp_order.quantity,   erp_order.unit_price,  erp_order.order_placed_date,   erp_order.marketplace,   mststatus.status_name  FROM    erp_order erp_order       INNER JOIN          mststatus mststatus       ON (erp_order.status = mststatus.status_id) WHERE (erp_order.marketplace != 'magento') ORDER BY erp_order.expected_delivery_date DESC";
		$results = $this->db->query($sql);
		$result = $results->result();
		
		if($result) {
			
			foreach($result as $value ) {
				$order_id 				= $value->order_id;
				$order_item_id 			= $value->marketplace_item_id;
				$customer_name 			= $value->customer_name;
				$customer_email 		= $value->customer_email;
				$contact_number 		= $value->contact_number;
				$buyer_address 			= $value->buyer_address;
				$shipping_country 		= $value->shipping_country;
				$sku 					= $value->sku;
				$product_name 			= $value->product_name;
				$expected_delivery_date = date('d-M-y', strtotime($value->expected_delivery_date));
				$dispatch_date 			= date('d-M-y', strtotime($value->dispatch_date));
				$quantity 				= $value->quantity;
				$unit_price 			= $value->unit_price;
				$order_placed_date 		= date('d-M-y', strtotime($value->order_placed_date));
				$marketplace 			= $value->marketplace;
				$status_name 			= $value->status_name;
				
				$array[] = array('order_id'=>$order_id, 'marketplace'=>$marketplace, 'order_item_id'=>$order_item_id, 'order_placed_date'=>$order_placed_date, 'expected_delivery_date'=>$expected_delivery_date, 'dispatch_date'=>$dispatch_date, 'customer_name'=>$customer_name, 'customer_email'=>$customer_email, 'contact_number'=>$contact_number, 'buyer_address'=>$buyer_address, 'shipping_country'=>$shipping_country, 'sku'=>$sku, 'product_name'=>$product_name,  'quantity'=>$quantity, 'unit_price'=>$unit_price, 'status_name'=>$status_name);
			}
			unset($result);
		}	
		
		array_to_csv($array,'marketplace_orders'.date('d-M-y').'.csv');
		unset($array);
			
	}
	
}	
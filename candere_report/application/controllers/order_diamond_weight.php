<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_Diamond_Weight extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		set_time_limit(0);
		$this->db->cache_delete_all();
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("order_diamond_weight_export/index");
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT DISTINCT sales_flat_order.entity_id,
                sales_flat_order.base_grand_total,
                sales_flat_order.increment_id,
                sales_flat_order.created_at,
                sales_flat_order_item.product_id,
                sales_flat_order_item.weight,
                sales_flat_order_item.sku,
                sales_flat_order_item.name
			  FROM    sales_flat_order_item sales_flat_order_item
				   INNER JOIN
					  sales_flat_order sales_flat_order
				   ON (sales_flat_order_item.order_id = sales_flat_order.entity_id)
				   where sales_flat_order.created_at between '2015-04-01' AND '2015-04-30'
				   order by sales_flat_order.entity_id DESC";
 
		$results = $this->db->query($sql);
		$result = $results->result_array();
		
		foreach($result as $row) {
			
			$product_id 		= $row['product_id'];
			$sku 				= $row['sku'];
			$product_name 		= $row['name'];
			$base_grand_total 	= $row['base_grand_total'];
			$increment_id 		= $row['increment_id'];
			$created_at 		= $row['created_at'];
			
			//$product_options 		= $row['product_options'];
			
			//$prod_options = unserialize(urldecode($product_options));
			
			$_product = Mage::getModel('catalog/product')->load($product_id);
			
			
			/************************ Diamond *************************/

			$total_diamond_weight = 0;		
			
			$diamond_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_status');
													
			$collection_details_diamond_status = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_status->getId())->getFirstItem();
			
			
			$status1 = $collection_details_diamond_status->getDiamond_1();
			$status2 = $collection_details_diamond_status->getDiamond_2();
			$status3 = $collection_details_diamond_status->getDiamond_3();
			$status4 = $collection_details_diamond_status->getDiamond_4();
			$status5 = $collection_details_diamond_status->getDiamond_5();
			$status6 = $collection_details_diamond_status->getDiamond_6();
			$status7 = $collection_details_diamond_status->getDiamond_7();
			
			if ($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1) {
							 
				$diamond_one_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_one_total_weight');
				 
				$collection_details_weight = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_one_total_weight->getId())->getFirstItem();
				  
				$diamond_1_weight = $collection_details_weight->getDiamond_1();
				$diamond_2_weight = $collection_details_weight->getDiamond_2();
				$diamond_3_weight = $collection_details_weight->getDiamond_3();
				$diamond_4_weight = $collection_details_weight->getDiamond_4();
				$diamond_5_weight = $collection_details_weight->getDiamond_5();
				$diamond_6_weight = $collection_details_weight->getDiamond_6();
				$diamond_7_weight = $collection_details_weight->getDiamond_7(); 
				
				  				
				if ($status1 == 1) {
					$total_diamond_weight +=  $diamond_1_weight;	
				}
				if ($status2 == 1) {
					$total_diamond_weight +=  $diamond_2_weight;	
				}
				if ($status3 == 1) {
					$total_diamond_weight +=  $diamond_3_weight;	
				}
				if ($status4 == 1) {
					$total_diamond_weight +=  $diamond_4_weight;	
				}
				if ($status5 == 1) {
					$total_diamond_weight +=  $diamond_5_weight;	
				}
				if ($status6 == 1) {
					$total_diamond_weight +=  $diamond_6_weight;	
				}
				if ($status7 == 1) {
					$total_diamond_weight +=  $diamond_7_weight;	
				}				
			}
			/************************ Diamond *************************/	
			
			
			/************************ Gemstone *************************/	
			
			$total_gemstone_weight = 0; 
			
			$gemstone_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone_status');
													
			$collection_details_gemstone_status = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_status->getId())->getFirstItem();
						
			$gem_status1 = $collection_details_gemstone_status->getGemstone_1();
			$gem_status2 = $collection_details_gemstone_status->getGemstone_2();
			$gem_status3 = $collection_details_gemstone_status->getGemstone_3();
			$gem_status4 = $collection_details_gemstone_status->getGemstone_4();
			$gem_status5 = $collection_details_gemstone_status->getGemstone_5();
			
			if ($gem_status1 == 1 || $gem_status2 == 1 || $gem_status3 == 1 || $gem_status4 == 1 || $gem_status5 == 1) {
				
				$gemstone_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone_total_weight');
				 
				$collection_details_gem_weight = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_total_weight->getId())->getFirstItem();
				  
				$gemstone_1_weight = $collection_details_gem_weight->getGemstone_1();
				$gemstone_2_weight = $collection_details_gem_weight->getGemstone_2();
				$gemstone_3_weight = $collection_details_gem_weight->getGemstone_3();
				$gemstone_4_weight = $collection_details_gem_weight->getGemstone_4();
				$gemstone_5_weight = $collection_details_gem_weight->getGemstone_5();
				
				if ($gem_status1 == 1) {
					$total_gemstone_weight +=  $gemstone_1_weight;	
				}
				if ($gem_status2 == 1) {
					$total_gemstone_weight +=  $gemstone_2_weight;	
				}
				if ($gem_status3 == 1) {
					$total_gemstone_weight +=  $gemstone_3_weight;	
				}
				if ($gem_status4 == 1) {
					$total_gemstone_weight +=  $gemstone_4_weight;	
				}
				if ($gem_status5 == 1) {
					$total_gemstone_weight +=  $gemstone_5_weight;	
				}
			}	  
			
			/************************ Gemstone *************************/	
			
		
			$array[] = array('sku'=>$sku, 'order_id'=>$increment_id, 'order_date'=>$created_at, 'total_diamond_weight'=>$total_diamond_weight, 'total_gemstone_weight'=>$total_gemstone_weight, 'sales_price'=>$base_grand_total);
			
			unset($sku);
			unset($increment_id);
			unset($created_at);
			unset($total_diamond_weight);
			unset($total_gemstone_weight);
			unset($base_grand_total);
			
		}
				
		array_to_csv($array,'order_diamond_weight'.date('d-M-y'));
		
		unset($array);
	}
	
	
	
		
}


<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Matching_Product_Export extends CI_Controller  {
	
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
        $this->load->view("matching_product_export/index");
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT DISTINCT
			   catalog_product_entity_varchar.attribute_id,
			   catalog_product_entity_varchar.entity_id,
			   catalog_product_entity_varchar.value 
		  FROM    eav_attribute eav_attribute
			   INNER JOIN
				  catalog_product_entity_varchar catalog_product_entity_varchar
			   ON (eav_attribute.attribute_id =
					  catalog_product_entity_varchar.attribute_id)
		 WHERE (catalog_product_entity_varchar.attribute_id = 296)";
 
		$results = $this->db->query($sql);
		$result = $results->result();
		
		
		$array = array();
		$link_data = array('');
		
		foreach($result as $rj) {
			
			$parent_entity_id 		= $rj->entity_id;
			$matching_sku 			= $rj->value;
			
			if($matching_sku) {
				$matching_product_id 	= Mage::getModel("catalog/product")->getIdBySku($matching_sku);
				
				$query = $this->db->select('link_id')
					  ->from('catalog_product_link')
					  ->where('product_id', $parent_entity_id)
					  ->where('linked_product_id', $matching_product_id)
					  ->where('link_type_id', '1')
					  ->get();
				$link_data = $query->row();
								
				$link_id = $link_data->link_id;
				
				//echo $this->db->last_query();
				//echo '<pre>'; print_r($link_data); echo '</pre>'; exit;
				
				if(!$link_id) {
					
					$data = array(
								   'product_id' 		=> $parent_entity_id ,
								   'linked_product_id' 	=> $matching_product_id,
								   'link_type_id' 		=> 1
								);
					$this->db->insert('catalog_product_link', $data);
					
					//$insert_id = $this->db->insert_id();
				}
				
				$array[] = array('parent_product_id'=>$parent_entity_id,'matching_product_id'=>$matching_product_id, 'matching_product_sku'=>$matching_sku);
			}
						
			
			
			
		}
				
		array_to_csv($array,'candere_matching_products_'.date('d-M-y'));
	}
	
	
	
		
}


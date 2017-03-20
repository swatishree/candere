<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Candere_Gold_Diamond_Products extends CI_Controller  {
	
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
        $this->load->view("candere_gold_diamond_products/index");
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 	
		set_time_limit(0);
		$this->db->cache_delete_all();
		
		$this->load->helper('csv');
		$label 	= $this->input->get('label');
		$sql 	= $this->myqueryfunction($label);
		$this->load->dbutil();
		$array = array();
					
		if($sql){
			
			foreach($sql as $value){
				
				$product_id 			= $value['product_id']; 
				$metal_id	 			= $value['metal_id']; 
				$product_type			= $value['product_type']; 
				$sku					= $value['sku']; 
				$purity_id				= $value['purity_id']; 
				$name					= $value['name']; 
				$metal					= $value['metal']; 
				$purity					= $value['purity'];
				$url					= $value['url'];
				$expected_delivery_date	= $value['expected_delivery_date'];
				$height					= $value['height']; 
				$width					= $value['width']; 
				$short_description		= $value['short_description']; 
				$default_metal_weight	= $value['weight']; 
				$default_total_weight	= $value['total_weight']; 
				$design_no				= $value['design_no']; 
				$gender					= $value['gender']; 
				$product_status			= $value['product_status']; 
				$total_weight	 		= $value['total_weight']; 
				$metal_weight	 		= $value['weight'];
				$base_metal_weight		= $value['weight'];
							
				$offer_percent 			= 1;
				$old_price 				= 0;
				$base_new_price 		= 0;
				$new_price 				= 0;
												
				$_product 	= Mage::getModel('catalog/product')->load($product_id);
				
				$old_price 	= round($this->getBaseProductPrice($product_id, 'price'));
												
				$base_new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
				$new_price 		= $base_new_price;
								
				if($base_new_price == null){
					$base_new_price = $old_price;
					$new_price 		= $old_price;
				}
						
				//$new_price 		= round($base_new_price);
				$offer_percent 	= ($new_price / $old_price);
								
				
				$sql = "SELECT  GROUP_CONCAT(catalog_category_entity_varchar.value SEPARATOR',') AS category
				FROM
				 (((metal_options_enabled metal_options_enabled
				 INNER JOIN
				 catalog_product_entity_varchar catalog_product_entity_varchar
				 ON (metal_options_enabled.product_id = catalog_product_entity_varchar.entity_id))
				 INNER JOIN
				 catalog_category_product catalog_category_product
				 ON (metal_options_enabled.product_id = catalog_category_product.product_id))
				 INNER JOIN
				 catalog_category_entity_varchar catalog_category_entity_varchar
				 ON (catalog_category_product.category_id = catalog_category_entity_varchar.entity_id))
				 INNER JOIN
				 pricing_table_metal_options pricing_table_metal_options
				 ON (metal_options_enabled.metal_id = pricing_table_metal_options.metal_id) AND (metal_options_enabled.product_id = pricing_table_metal_options.product_id)
				WHERE (catalog_category_entity_varchar.attribute_id  = 41 AND ((((pricing_table_metal_options.status  = 1 AND metal_options_enabled.isdefault  = 1) AND metal_options_enabled.status  = 1 AND metal_options_enabled.product_id  = $product_id) AND pricing_table_metal_options.isdefault  = 1) AND catalog_product_entity_varchar.attribute_id  = 71)) GROUP BY pricing_table_metal_options.sku";
				$results 	= $this->db->query($sql);
				$result 	= $results->result();
				 
				if($result){
					foreach($result as $rslt){ 
						$category  = $rslt->category;
					} 
				}else{
					$category  = '' ;   
				}
				unset($result);
				
				
				$sql =	"SELECT diamond_1,diamond_2,diamond_3,diamond_4,diamond_5,diamond_6,diamond_7 from  diamond_attributes where product_id = $product_id and attribute_id = 263"; 

				$results = $this->db->query($sql);
				$result = $results->result_array();
				if($result){
				
					foreach($result as $value){ 
						
						$diamond_1 = $value['diamond_1'] ;
						$diamond_2 = $value['diamond_2'] ;
						$diamond_3 = $value['diamond_3'] ;
						$diamond_4 = $value['diamond_4'] ;
						$diamond_5 = $value['diamond_5'] ;
						$diamond_6 = $value['diamond_6'] ;
						$diamond_7 = $value['diamond_7'] ; 
						
						$diamond_1_clarity = '';
						$diamond_2_clarity = '';
						$diamond_3_clarity = '';
						$diamond_4_clarity = '';
						$diamond_5_clarity = '';
						$diamond_6_clarity = '';
						$diamond_7_clarity = '';
						
						$diamond_1_shape 	= '';
						$diamond_2_shape 	= '';
						$diamond_3_shape 	= '';
						$diamond_4_shape 	= '';
						$diamond_5_shape 	= '';
						$diamond_6_shape 	= '';
						$diamond_7_shape 	= '';
						
						$diamond_1_color	= '';
						$diamond_2_color	= '';
						$diamond_3_color	= '';
						$diamond_4_color	= '';
						$diamond_5_color	= '';
						$diamond_6_color	= '';
						$diamond_7_color	= ''; 
						
						$diamond_1_weight	= '';
						$diamond_2_weight	= '';
						$diamond_3_weight	= '';
						$diamond_4_weight	= '';
						$diamond_5_weight	= '';
						$diamond_6_weight	= '';
						$diamond_7_weight	= '';
						
						$diamond_1_no_of_diamonds = '';
						$diamond_2_no_of_diamonds = '';
						$diamond_3_no_of_diamonds = '';
						$diamond_4_no_of_diamonds = '';
						$diamond_5_no_of_diamonds = '';
						$diamond_6_no_of_diamonds = '';
						$diamond_7_no_of_diamonds = '';
						
						$diamond_1_setting_type = '';
						$diamond_2_setting_type = '';
						$diamond_3_setting_type = '';
						$diamond_4_setting_type = '';
						$diamond_5_setting_type = '';
						$diamond_6_setting_type = '';
						$diamond_7_setting_type = '';
							
						$sql = "SELECT eav_attribute_option_value_1.value AS clarity_1,
							   eav_attribute_option_value_2.value AS clarity_2,
							   eav_attribute_option_value_3.value AS clarity_3,
							   eav_attribute_option_value_4.value AS clarity_4,
							   eav_attribute_option_value_5.value AS clarity_5,
							   eav_attribute_option_value_6.value AS clarity_6,
							   eav_attribute_option_value_7.value AS clarity_7
						  FROM    (   (   (   (   (   (   diamond_attributes diamond_attributes
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value_5
													   ON (diamond_attributes.diamond_5 =
															  eav_attribute_option_value_5.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (diamond_attributes.diamond_1 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (diamond_attributes.diamond_2 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_3
										   ON (diamond_attributes.diamond_3 =
												  eav_attribute_option_value_3.option_id))
									   INNER JOIN
										  eav_attribute_option_value eav_attribute_option_value_4
									   ON (diamond_attributes.diamond_4 =
											  eav_attribute_option_value_4.option_id))
								   INNER JOIN
									  eav_attribute_option_value eav_attribute_option_value_6
								   ON (diamond_attributes.diamond_6 =
										  eav_attribute_option_value_6.option_id))
							   INNER JOIN
								  eav_attribute_option_value eav_attribute_option_value_7
							   ON (diamond_attributes.diamond_7 =
									  eav_attribute_option_value_7.option_id)
						 WHERE (    diamond_attributes.product_id = $product_id
								AND diamond_attributes.attribute_id = '149')"; 
									
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){  
							$diamond_1_clarity = $result['clarity_1'] ;
							$diamond_2_clarity = $result['clarity_2'];
							$diamond_3_clarity = $result['clarity_3'];
							$diamond_4_clarity = $result['clarity_4'];
							$diamond_5_clarity = $result['clarity_5'];
							$diamond_6_clarity = $result['clarity_6'];
							$diamond_7_clarity = $result['clarity_7'];
						} 
							
							
						$sql = "SELECT eav_attribute_option_value_1.value AS shape_1,
							   eav_attribute_option_value_2.value AS shape_2,
							   eav_attribute_option_value_3.value AS shape_3,
							   eav_attribute_option_value_4.value AS shape_4,
							   eav_attribute_option_value_5.value AS shape_5,
							   eav_attribute_option_value_6.value AS shape_6,
							   eav_attribute_option_value_7.value AS shape_7
						  FROM    (   (   (   (   (   (   diamond_attributes diamond_attributes
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value_5
													   ON (diamond_attributes.diamond_5 =
															  eav_attribute_option_value_5.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (diamond_attributes.diamond_1 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (diamond_attributes.diamond_2 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_3
										   ON (diamond_attributes.diamond_3 =
												  eav_attribute_option_value_3.option_id))
									   INNER JOIN
										  eav_attribute_option_value eav_attribute_option_value_4
									   ON (diamond_attributes.diamond_4 =
											  eav_attribute_option_value_4.option_id))
								   INNER JOIN
									  eav_attribute_option_value eav_attribute_option_value_6
								   ON (diamond_attributes.diamond_6 =
										  eav_attribute_option_value_6.option_id))
							   INNER JOIN
								  eav_attribute_option_value eav_attribute_option_value_7
							   ON (diamond_attributes.diamond_7 =
									  eav_attribute_option_value_7.option_id)
						 WHERE (    diamond_attributes.product_id = $product_id
								AND diamond_attributes.attribute_id = '152')"; 
								
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){ 
							 
							$diamond_1_shape 	= $result['shape_1'];
							$diamond_2_shape 	= $result['shape_2'];
							$diamond_3_shape 	= $result['shape_3'];
							$diamond_4_shape 	= $result['shape_4'];
							$diamond_5_shape 	= $result['shape_5'];
							$diamond_6_shape 	= $result['shape_6'];
							$diamond_7_shape 	= $result['shape_7'];
						}
							
						$sql = "SELECT eav_attribute_option_value_1.value AS color_1,
							   eav_attribute_option_value_2.value AS color_2,
							   eav_attribute_option_value_3.value AS color_3,
							   eav_attribute_option_value_4.value AS color_4,
							   eav_attribute_option_value_5.value AS color_5,
							   eav_attribute_option_value_6.value AS color_6,
							   eav_attribute_option_value_7.value AS color_7
						  FROM    (   (   (   (   (   (   diamond_attributes diamond_attributes
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value_5
													   ON (diamond_attributes.diamond_5 =
															  eav_attribute_option_value_5.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (diamond_attributes.diamond_1 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (diamond_attributes.diamond_2 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_3
										   ON (diamond_attributes.diamond_3 =
												  eav_attribute_option_value_3.option_id))
									   INNER JOIN
										  eav_attribute_option_value eav_attribute_option_value_4
									   ON (diamond_attributes.diamond_4 =
											  eav_attribute_option_value_4.option_id))
								   INNER JOIN
									  eav_attribute_option_value eav_attribute_option_value_6
								   ON (diamond_attributes.diamond_6 =
										  eav_attribute_option_value_6.option_id))
							   INNER JOIN
								  eav_attribute_option_value eav_attribute_option_value_7
							   ON (diamond_attributes.diamond_7 =
									  eav_attribute_option_value_7.option_id)
						 WHERE (    diamond_attributes.product_id = $product_id
								AND diamond_attributes.attribute_id = '150')"; 
								
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){  
							$diamond_1_color	= $result['color_1'];
							$diamond_2_color	= $result['color_2'];
							$diamond_3_color	= $result['color_3'];
							$diamond_4_color	= $result['color_4'];
							$diamond_5_color	= $result['color_5'];
							$diamond_6_color	= $result['color_6'];
							$diamond_7_color	= $result['color_7']; 
						}
							
						$sql = "SELECT eav_attribute_option_value_1.value AS setting_type_1,
							   eav_attribute_option_value_2.value AS setting_type_2,
							   eav_attribute_option_value_3.value AS setting_type_3,
							   eav_attribute_option_value_4.value AS setting_type_4,
							   eav_attribute_option_value_5.value AS setting_type_5,
							   eav_attribute_option_value_6.value AS setting_type_6,
							   eav_attribute_option_value_7.value AS setting_type_7
						  FROM    (   (   (   (   (   (   diamond_attributes diamond_attributes
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value_5
													   ON (diamond_attributes.diamond_5 =
															  eav_attribute_option_value_5.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (diamond_attributes.diamond_1 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (diamond_attributes.diamond_2 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_3
										   ON (diamond_attributes.diamond_3 =
												  eav_attribute_option_value_3.option_id))
									   INNER JOIN
										  eav_attribute_option_value eav_attribute_option_value_4
									   ON (diamond_attributes.diamond_4 =
											  eav_attribute_option_value_4.option_id))
								   INNER JOIN
									  eav_attribute_option_value eav_attribute_option_value_6
								   ON (diamond_attributes.diamond_6 =
										  eav_attribute_option_value_6.option_id))
							   INNER JOIN
								  eav_attribute_option_value eav_attribute_option_value_7
							   ON (diamond_attributes.diamond_7 =
									  eav_attribute_option_value_7.option_id)
						 WHERE (    diamond_attributes.product_id = $product_id
								AND diamond_attributes.attribute_id = '239')"; 
								
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){  
							$diamond_1_setting_type = $result['setting_type_1'];
							$diamond_2_setting_type = $result['setting_type_2'];
							$diamond_3_setting_type = $result['setting_type_3'];
							$diamond_4_setting_type = $result['setting_type_4'];
							$diamond_5_setting_type = $result['setting_type_5'];
							$diamond_6_setting_type = $result['setting_type_6'];
							$diamond_7_setting_type = $result['setting_type_7'];
						}
							
						$sql = "select diamond_1,diamond_2,diamond_3,diamond_4,diamond_5,diamond_5,diamond_6,diamond_7 from diamond_attributes where attribute_id = 154 and product_id = $product_id";
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){  
							$diamond_1_weight	= $result['diamond_1'];
							$diamond_2_weight	= $result['diamond_2'];
							$diamond_3_weight	= $result['diamond_3'];
							$diamond_4_weight	= $result['diamond_4'];
							$diamond_5_weight	= $result['diamond_5'];
							$diamond_6_weight	= $result['diamond_6'];
							$diamond_7_weight	= $result['diamond_7'];
						}
						
						$sql = "select diamond_1,diamond_2,diamond_3,diamond_4,diamond_5,diamond_5,diamond_6,diamond_7 from diamond_attributes where attribute_id = 249 and product_id = $product_id";
						$results = $this->db->query($sql);
						$result = $results->row_array();
						if($result){  
							$diamond_1_no_of_diamonds = $result['diamond_1'];
							$diamond_2_no_of_diamonds = $result['diamond_2'];
							$diamond_3_no_of_diamonds = $result['diamond_3'];
							$diamond_4_no_of_diamonds = $result['diamond_4'];
							$diamond_5_no_of_diamonds = $result['diamond_5'];
							$diamond_6_no_of_diamonds = $result['diamond_6'];
							$diamond_7_no_of_diamonds = $result['diamond_7'];
						}
				
						if($diamond_1 == 1){ 
							$diamond_1_clarity = $diamond_1_clarity ;
							$diamond_1_shape = $diamond_1_shape ;
							$diamond_1_color = $diamond_1_color ;
							$diamond_1_weight = $diamond_1_weight ;
							$diamond_1_no_of_diamonds = $diamond_1_no_of_diamonds ;
							$diamond_1_setting_type = $diamond_1_setting_type ;
						}else{
							$diamond_1_clarity = '';
							$diamond_1_shape = '';
							$diamond_1_color = '';
							$diamond_1_weight = '';
							$diamond_1_no_of_diamonds = '';
							$diamond_1_setting_type= '';
						}
						if($diamond_2 == 1){ 
							$diamond_2_clarity = $diamond_2_clarity ;
							$diamond_2_shape = $diamond_2_shape ;
							$diamond_2_color = $diamond_2_color ;
							$diamond_2_weight = $diamond_2_weight ;
							$diamond_2_no_of_diamonds = $diamond_2_no_of_diamonds ;
							$diamond_2_setting_type = $diamond_2_setting_type ;
						}else{
							$diamond_2_clarity = '';
							$diamond_2_shape = '';
							$diamond_2_color = '';
							$diamond_2_weight = '';
							$diamond_2_no_of_diamonds = '';
							$diamond_2_setting_type= '';
						}
						if($diamond_3 == 1){ 
							$diamond_3_clarity = $diamond_3_clarity ;
							$diamond_3_shape = $diamond_3_shape ;
							$diamond_3_color = $diamond_3_color ;
							$diamond_3_weight = $diamond_3_weight ;
							$diamond_3_no_of_diamonds = $diamond_3_no_of_diamonds ;
							$diamond_3_setting_type = $diamond_3_setting_type ;
						}else{
							$diamond_3_clarity = '';
							$diamond_3_shape = '';
							$diamond_3_color = '';
							$diamond_3_weight = '';
							$diamond_3_no_of_diamonds = '';
							$diamond_3_setting_type= '';
						}
						if($diamond_4 == 1){ 
							$diamond_4_clarity = $diamond_4_clarity ;
							$diamond_4_shape = $diamond_4_shape ;
							$diamond_4_color = $diamond_4_color ;
							$diamond_4_weight = $diamond_4_weight ;
							$diamond_4_no_of_diamonds = $diamond_4_no_of_diamonds ;
							$diamond_4_setting_type = $diamond_4_setting_type ;
						}else{
							$diamond_4_clarity = '';
							$diamond_4_shape = '';
							$diamond_4_color = '';
							$diamond_4_weight = '';
							$diamond_4_no_of_diamonds = '';
							$diamond_4_setting_type= '';
						}
						
						if($diamond_5 == 1){ 
							$diamond_5_clarity = $diamond_5_clarity ;
							$diamond_5_shape = $diamond_5_shape ;
							$diamond_5_color = $diamond_5_color ;
							$diamond_5_weight = $diamond_5_weight ;
							$diamond_5_no_of_diamonds = $diamond_5_no_of_diamonds ;
							$diamond_5_setting_type = $diamond_5_setting_type ;
						}else{
							$diamond_5_clarity = '';
							$diamond_5_shape = '';
							$diamond_5_color = '';
							$diamond_5_weight = '';
							$diamond_5_no_of_diamonds = '';
							$diamond_5_setting_type= '';
						}
						if($diamond_6 == 1){ 
							$diamond_6_clarity = $diamond_6_clarity ;
							$diamond_6_shape = $diamond_6_shape ;
							$diamond_6_color = $diamond_6_color ;
							$diamond_6_weight = $diamond_6_weight ;
							$diamond_6_no_of_diamonds = $diamond_6_no_of_diamonds ;
							$diamond_6_setting_type = $diamond_6_setting_type ;
						}else{
							$diamond_6_clarity = '';
							$diamond_6_shape = '';
							$diamond_6_color = '';
							$diamond_6_weight = '';
							$diamond_6_no_of_diamonds = '';
							$diamond_6_setting_type= '';
						}
						if($diamond_7 == 1){ 
							$diamond_7_clarity = $diamond_7_clarity ;
							$diamond_7_shape = $diamond_7_shape ;
							$diamond_7_color = $diamond_7_color ;
							$diamond_7_weight = $diamond_7_weight ;
							$diamond_7_no_of_diamonds = $diamond_7_no_of_diamonds ;  
							$diamond_7_setting_type = $diamond_7_setting_type ;   
						}else{
							$diamond_7_clarity = '';
							$diamond_7_shape = '';
							$diamond_7_color = '';
							$diamond_7_weight = '';
							$diamond_7_no_of_diamonds = '';
							$diamond_7_setting_type= '';
						}
						
						$gemstone_1_total_gemstone = ''; 
						$gemstone_2_total_gemstone = ''; 
						$gemstone_3_total_gemstone = ''; 
						$gemstone_4_total_gemstone = ''; 
						$gemstone_5_total_gemstone = '';  
						
						$gemstone_1_shape 	= '';
						$gemstone_2_shape 	= '';
						$gemstone_3_shape 	= '';
						$gemstone_4_shape 	= '';
						$gemstone_5_shape 	= ''; 
						
						$gemstone_1_type 	= '';
						$gemstone_2_type 	= '';
						$gemstone_3_type 	= '';
						$gemstone_4_type 	= '';
						$gemstone_5_type 	= ''; 
						
						$gemstone_1_weight 	= '';
						$gemstone_2_weight 	= '';
						$gemstone_3_weight 	= '';
						$gemstone_4_weight	= '';
						$gemstone_5_weight	= ''; 
						
						$gemstone_1 	= '';
						$gemstone_2 	= '';
						$gemstone_3 	= '';
						$gemstone_4 	= '';
						$gemstone_5 	= ''; 
						
						$sql =	"SELECT gemstone_1,gemstone_2,gemstone_3,gemstone_4,gemstone_5 from  gemstone_attributes where product_id = $product_id and attribute_id = 262";
						$results = $this->db->query($sql);
						$result = $results->result_array();
						 
						if($result){
						
							foreach($result as $value){ 
								$gemstone_1 	= $value['gemstone_1'];
								$gemstone_2 	= $value['gemstone_2'];
								$gemstone_3 	= $value['gemstone_3'];
								$gemstone_4 	= $value['gemstone_4'];
								$gemstone_5 	= $value['gemstone_5']; 
								
								$sql = "SELECT eav_attribute_option_value.value AS shape_1,
										   eav_attribute_option_value_1.value AS shape_2,
										   eav_attribute_option_value_2.value AS shape_3,
										   eav_attribute_option_value_3.value AS shape_4,
										   eav_attribute_option_value_4.value AS shape_5
									  FROM    (   (   (   (   gemstone_attributes gemstone_attributes
														   INNER JOIN
															  eav_attribute_option_value eav_attribute_option_value_3
														   ON (gemstone_attributes.gemstone_4 =
																  eav_attribute_option_value_3.option_id))
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value
													   ON (gemstone_attributes.gemstone_1 =
															  eav_attribute_option_value.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (gemstone_attributes.gemstone_2 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (gemstone_attributes.gemstone_3 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_4
										   ON (gemstone_attributes.gemstone_5 =
												  eav_attribute_option_value_4.option_id)
									 WHERE     (gemstone_attributes.attribute_id = 218)
										   AND (gemstone_attributes.product_id = $product_id)";
								$results = $this->db->query($sql);
								$result = $results->row_array();
								
								if($result){   
									$gemstone_1_shape	= $result['shape_1'];
									$gemstone_2_shape	= $result['shape_2'];
									$gemstone_3_shape	= $result['shape_3'];
									$gemstone_4_shape	= $result['shape_4'];
									$gemstone_5_shape	= $result['shape_5'];
								} 
								
								$sql = "select gemstone_1 as weight_1 ,gemstone_2 as weight_2 ,gemstone_3  as weight_3 ,gemstone_4 as weight_4 ,gemstone_5 as weight_5  from gemstone_attributes where attribute_id = 219 and product_id = $product_id";
								$results = $this->db->query($sql);
								$result = $results->row_array();
								if($result){   
									$gemstone_1_weight	= $result['weight_1'];
									$gemstone_2_weight	= $result['weight_2'];
									$gemstone_3_weight	= $result['weight_3'];
									$gemstone_4_weight	= $result['weight_4'];
									$gemstone_5_weight	= $result['weight_5'];
								}
																
								$sql = "SELECT eav_attribute_option_value.value AS total_stone_1,
										   eav_attribute_option_value_1.value AS total_stone_2,
										   eav_attribute_option_value_2.value AS total_stone_3,
										   eav_attribute_option_value_3.value AS total_stone_4,
										   eav_attribute_option_value_4.value AS total_stone_5
									  FROM    (   (   (   (   gemstone_attributes gemstone_attributes
														   INNER JOIN
															  eav_attribute_option_value eav_attribute_option_value_3
														   ON (gemstone_attributes.gemstone_4 =
																  eav_attribute_option_value_3.option_id))
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value
													   ON (gemstone_attributes.gemstone_1 =
															  eav_attribute_option_value.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (gemstone_attributes.gemstone_2 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (gemstone_attributes.gemstone_3 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_4
										   ON (gemstone_attributes.gemstone_5 =
												  eav_attribute_option_value_4.option_id)
									 WHERE     (gemstone_attributes.attribute_id = 217)
										   AND (gemstone_attributes.product_id = $product_id)"; 
									
								$results = $this->db->query($sql);
								$result = $results->row_array();
								if($result){  
									$gemstone_1_total_gemstone	= $result['total_stone_1'];
									$gemstone_2_total_gemstone	= $result['total_stone_2'];
									$gemstone_3_total_gemstone	= $result['total_stone_3'];
									$gemstone_4_total_gemstone	= $result['total_stone_4'];
									$gemstone_5_total_gemstone	= $result['total_stone_5']; 
								}
								
								$sql = "SELECT eav_attribute_option_value.value AS type_1,
										   eav_attribute_option_value_1.value AS type_2,
										   eav_attribute_option_value_2.value AS type_3,
										   eav_attribute_option_value_3.value AS type_4,
										   eav_attribute_option_value_4.value AS type_5
									  FROM    (   (   (   (   gemstone_attributes gemstone_attributes
														   INNER JOIN
															  eav_attribute_option_value eav_attribute_option_value_3
														   ON (gemstone_attributes.gemstone_4 =
																  eav_attribute_option_value_3.option_id))
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value
													   ON (gemstone_attributes.gemstone_1 =
															  eav_attribute_option_value.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (gemstone_attributes.gemstone_2 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (gemstone_attributes.gemstone_3 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_4
										   ON (gemstone_attributes.gemstone_5 =
												  eav_attribute_option_value_4.option_id)
									 WHERE     (gemstone_attributes.attribute_id = 216)
										   AND (gemstone_attributes.product_id = $product_id)"; 
									
								$results = $this->db->query($sql);
								$result = $results->row_array();
								if($result){  
									$gemstone_1_type	= $result['type_1'];
									$gemstone_2_type	= $result['type_2'];
									$gemstone_3_type	= $result['type_3'];
									$gemstone_4_type	= $result['type_4'];
									$gemstone_5_type	= $result['type_5']; 
								}
								
								$sql = "SELECT eav_attribute_option_value.value AS color_1,
										   eav_attribute_option_value_1.value AS color_2,
										   eav_attribute_option_value_2.value AS color_3,
										   eav_attribute_option_value_3.value AS color_4,
										   eav_attribute_option_value_4.value AS color_5
									  FROM    (   (   (   (   gemstone_attributes gemstone_attributes
														   INNER JOIN
															  eav_attribute_option_value eav_attribute_option_value_3
														   ON (gemstone_attributes.gemstone_4 =
																  eav_attribute_option_value_3.option_id))
													   INNER JOIN
														  eav_attribute_option_value eav_attribute_option_value
													   ON (gemstone_attributes.gemstone_1 =
															  eav_attribute_option_value.option_id))
												   INNER JOIN
													  eav_attribute_option_value eav_attribute_option_value_1
												   ON (gemstone_attributes.gemstone_2 =
														  eav_attribute_option_value_1.option_id))
											   INNER JOIN
												  eav_attribute_option_value eav_attribute_option_value_2
											   ON (gemstone_attributes.gemstone_3 =
													  eav_attribute_option_value_2.option_id))
										   INNER JOIN
											  eav_attribute_option_value eav_attribute_option_value_4
										   ON (gemstone_attributes.gemstone_5 =
												  eav_attribute_option_value_4.option_id)
									 WHERE     (gemstone_attributes.attribute_id = 285)
										   AND (gemstone_attributes.product_id = $product_id)"; 
									
								$results = $this->db->query($sql);
								$result = $results->row_array();
								if($result){  
									$gemstone_1_color	= $result['color_1'];
									$gemstone_2_color	= $result['color_2'];
									$gemstone_3_color	= $result['color_3'];
									$gemstone_4_color	= $result['color_4'];
									$gemstone_5_color	= $result['color_5']; 
								}
																
								if($gemstone_1 == 1){ 
									$gemstone_1_total_gemstone = $gemstone_1_total_gemstone ;
									$gemstone_1_type = $gemstone_1_type ;
									$gemstone_1_color = $gemstone_1_color ;
									$gemstone_1_shape = $gemstone_1_shape ;
									$gemstone_1_weight = $gemstone_1_weight ; 
								}else{
									$gemstone_1_total_gemstone = '';
									$gemstone_1_type = '';
									$gemstone_1_color = '';
									$gemstone_1_shape = '';
									$gemstone_1_weight = ''; 
								}
								
								if($gemstone_2 == 1){ 
									$gemstone_2_total_gemstone = $gemstone_2_total_gemstone ;
									$gemstone_2_type = $gemstone_2_type ;
									$gemstone_2_color = $gemstone_2_color ;
									$gemstone_2_shape = $gemstone_2_shape ;
									$gemstone_2_weight = $gemstone_2_weight ; 
								}else{
									$gemstone_2_total_gemstone = '';
									$gemstone_2_type = '';
									$gemstone_2_color = '';
									$gemstone_2_shape = '';
									$gemstone_2_weight = ''; 
								}
								
								if($gemstone_3 == 1){ 
									$gemstone_3_total_gemstone = $gemstone_3_total_gemstone ;
									$gemstone_3_type = $gemstone_3_type ;
									$gemstone_3_color = $gemstone_3_color ;
									$gemstone_3_shape = $gemstone_3_shape ;
									$gemstone_3_weight = $gemstone_3_weight ; 
								}else{
									$gemstone_3_total_gemstone = '';
									$gemstone_3_type = '';
									$gemstone_3_color = '';
									$gemstone_3_shape = '';
									$gemstone_3_weight = ''; 
								}
								
								if($gemstone_4 == 1){ 
									$gemstone_4_total_gemstone = $gemstone_4_total_gemstone ;
									$gemstone_4_type = $gemstone_4_type ;
									$gemstone_4_color = $gemstone_4_color ;
									$gemstone_4_shape = $gemstone_4_shape ;
									$gemstone_4_weight = $gemstone_4_weight ; 
								}else{
									$gemstone_4_total_gemstone = '';
									$gemstone_4_type = '';
									$gemstone_4_color = '';
									$gemstone_4_shape = '';
									$gemstone_4_weight = ''; 
								}
								
								if($gemstone_5 == 1){ 
									$gemstone_5_total_gemstone = $gemstone_5_total_gemstone ;
									$gemstone_5_type = $gemstone_5_type ;
									$gemstone_5_color = $gemstone_5_color ;
									$gemstone_5_shape = $gemstone_5_shape ;
									$gemstone_5_weight = $gemstone_5_weight ; 
								}else{
									$gemstone_5_total_gemstone = '';
									$gemstone_5_type = '';
									$gemstone_5_color = '';
									$gemstone_5_shape = '';
									$gemstone_5_weight = ''; 
								}
							}
						}
					} 
					
				}
				unset($result);
				
								
				$sql = "SELECT catalog_product_entity_media_gallery.value AS img 
				  FROM    catalog_product_entity_media_gallery catalog_product_entity_media_gallery
					   INNER JOIN
						  catalog_product_entity_media_gallery_value catalog_product_entity_media_gallery_value
					   ON (catalog_product_entity_media_gallery.value_id =
							  catalog_product_entity_media_gallery_value.value_id)
				 WHERE     (catalog_product_entity_media_gallery_value.disabled = 0 
					   AND catalog_product_entity_media_gallery.entity_id = ? AND catalog_product_entity_media_gallery_value.metal = ? )
				ORDER BY catalog_product_entity_media_gallery_value.position ASC
				 LIMIT 4"; 
				$results_images = $this->db->query($sql, array($product_id, $metal_id));
				$results_imgs = $results_images->result_array() ;
				$img_counter = 1 ;
				
				$errors = array_filter($results_imgs);
 
				if (!empty($errors)) {
	 
					foreach($results_imgs as $images){
						
						$img_array['img_'.$img_counter]  = Mage::getBaseUrl().'media/catalog/product'.$images['img']; 
						
						$img_counter++ ;
					}  
					unset($results_imgs);
				}
				
				unset($errors);
				
											
				$default_metal_karat = Mage::helper('function')->get_default_metal_karat($product_id, $product_type);
				
				$base_purity_id = $default_metal_karat['purity'];
														
				$customized_design_pricing = array('');
				$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$length,$thickeness,$diamond_selection,$offer_percent,$base_purity_id);
														
				$metal_weight 			= $customized_design_pricing['metal_weight'];
				$total_weight 			= $customized_design_pricing['total_weight'];
				$old_price 				= $customized_design_pricing['old_price'];
				$new_price 				= $customized_design_pricing['new_price'];
				$gold_cost 				= $customized_design_pricing['gold_cost'];
				$making_cost 			= $customized_design_pricing['making_cost'];
				$vat_cost 				= $customized_design_pricing['vat_cost'];
				$base_18k_diamond_cost 	= $customized_design_pricing['base_18k_diamond_cost'];
				$gemstone_cost 			= $customized_design_pricing['gemstone_cost'];
				$metal 					= $customized_design_pricing['metal'];
				$purity 				= $customized_design_pricing['purity'];
				$emi 					= $customized_design_pricing['emi'];
				$sku 					= $customized_design_pricing['sku'];
				$gold_price 			= $customized_design_pricing['gold_price'];
				$gemstone_flag 			= $customized_design_pricing['gemstone_flag'];
				$diamond_flag 			= $customized_design_pricing['diamond_flag'];
				
				$base_metal_weight 		= $customized_design_pricing['metal_weight'];
				
				$array[] = array('product_id'=>$product_id, 'sku'=>$sku, 'metal_id'=>$metal_id, 'purity_id'=>$purity_id, 'name'=>$name, 'metal'=>$metal, 'purity'=>$purity, 'url'=>$url, 'expected_delivery_date'=>$expected_delivery_date, 'height'=>$height, 'width'=>$width, 'short_description'=>$short_description, 'default_metal_weight'=>$metal_weight,  'default_total_weight'=>$total_weight,   'product_type'=>$product_type,   'design_no'=>$design_no,  'gender'=>$gender, 'product_status'=>$product_status, 'category'=>$category, 'price'=>$old_price, 'price_after_discount'=>$new_price, 'diamond_1_clarity'=>$diamond_1_clarity,'diamond_1_shape'=>$diamond_1_shape,'diamond_1_color'=>$diamond_1_color,'diamond_1_weight'=>$diamond_1_weight,'diamond_1_no_of_diamonds'=>$diamond_1_no_of_diamonds,'diamond_1_setting_type'=>$diamond_1_setting_type, 'diamond_2_clarity'=>$diamond_2_clarity, 'diamond_2_shape'=>$diamond_2_shape,'diamond_2_color'=>$diamond_2_color,'diamond_2_weight'=>$diamond_2_weight,'diamond_2_no_of_diamonds'=>$diamond_2_no_of_diamonds,'diamond_2_setting_type'=>$diamond_2_setting_type, 'diamond_3_clarity'=>$diamond_3_clarity, 'diamond_3_shape'=>$diamond_3_shape,'diamond_3_color'=>$diamond_3_color,'diamond_3_weight'=>$diamond_3_weight,'diamond_3_no_of_diamonds'=>$diamond_3_no_of_diamonds,'diamond_3_setting_type'=>$diamond_3_setting_type, 'diamond_4_clarity'=>$diamond_4_clarity, 'diamond_4_shape'=>$diamond_4_shape,'diamond_4_color'=>$diamond_4_color,'diamond_4_weight'=>$diamond_4_weight,'diamond_4_no_of_diamonds'=>$diamond_4_no_of_diamonds,'diamond_4_setting_type'=>$diamond_4_setting_type, 'diamond_5_clarity'=>$diamond_5_clarity, 'diamond_5_shape'=>$diamond_5_shape,'diamond_5_color'=>$diamond_5_color,'diamond_5_weight'=>$diamond_5_weight,'diamond_5_no_of_diamonds'=>$diamond_5_no_of_diamonds,'diamond_5_setting_type'=>$diamond_5_setting_type, 'diamond_6_clarity'=>$diamond_6_clarity, 'diamond_6_shape'=>$diamond_6_shape,'diamond_6_color'=>$diamond_6_color,'diamond_6_weight'=>$diamond_6_weight,'diamond_6_no_of_diamonds'=>$diamond_6_no_of_diamonds,'diamond_6_setting_type'=>$diamond_6_setting_type, 'diamond_7_clarity'=>$diamond_7_clarity, 'diamond_7_shape'=>$diamond_7_shape,'diamond_7_color'=>$diamond_7_color,'diamond_7_weight'=>$diamond_7_weight,'diamond_7_no_of_diamonds'=>$diamond_7_no_of_diamonds,'diamond_7_setting_type'=>$diamond_7_setting_type, 'gemstone_1_total_gemstone'=>$gemstone_1_total_gemstone, 'gemstone_1_type'=>$gemstone_1_type,'gemstone_1_color'=>$gemstone_1_color,'gemstone_1_shape'=>$gemstone_1_shape,'gemstone_1_weight'=>$gemstone_1_weight, 'gemstone_2_total_gemstone'=>$gemstone_2_total_gemstone, 'gemstone_2_type'=>$gemstone_2_type,'gemstone_2_color'=>$gemstone_2_color,'gemstone_2_shape'=>$gemstone_2_shape,'gemstone_2_weight'=>$gemstone_2_weight, 'gemstone_3_total_gemstone'=>$gemstone_3_total_gemstone, 'gemstone_3_type'=>$gemstone_3_type,'gemstone_3_color'=>$gemstone_3_color,'gemstone_3_shape'=>$gemstone_3_shape,'gemstone_3_weight'=>$gemstone_3_weight, 'gemstone_4_total_gemstone'=>$gemstone_4_total_gemstone, 'gemstone_4_type'=>$gemstone_4_type,'gemstone_4_color'=>$gemstone_4_color,'gemstone_4_shape'=>$gemstone_4_shape,'gemstone_4_weight'=>$gemstone_4_weight, 'gemstone_5_total_gemstone'=>$gemstone_5_total_gemstone, 'gemstone_5_type'=>$gemstone_5_type,'gemstone_5_color'=>$gemstone_5_color,'gemstone_5_shape'=>$gemstone_5_shape,'gemstone_5_weight'=>$gemstone_5_weight, 'img_1' => $img_array['img_1'], 'img_2' => $img_array['img_2'], 'img_3' => $img_array['img_3'],'img_4' => $img_array['img_4']);
								
				
				$sql = "SELECT DISTINCT
						   pricing_table_metal_options.purity AS purity_id,
						   metal_options_enabled.metal_id,
						   pricing_table_metal_options.isdefault
					  FROM    pricing_table_metal_options pricing_table_metal_options
						   INNER JOIN
							  metal_options_enabled metal_options_enabled
						   ON (pricing_table_metal_options.product_id =
								  metal_options_enabled.product_id)
					 WHERE (    metal_options_enabled.isdefault = 1
							AND (    (    (    (    pricing_table_metal_options.product_id = $product_id
												AND pricing_table_metal_options.status = 1)
										   AND metal_options_enabled.isdefault = 1)
									  AND metal_options_enabled.status = 1)
								 AND pricing_table_metal_options.isdefault = 0))";
				$purity_data 	= $this->db->query($sql);
				$purity_result 	= $purity_data->row();
				
				$purity_id_non_default = $purity_result->purity_id;
								
				if($purity_id_non_default) {
				
					$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($default_metal_weight,$default_total_weight,$purity_id_non_default,$product_type);
					
					$metal_weight 			= number_format($get_weights['metal_weight'],2);
					$total_weight 			= number_format($get_weights['total_weight'],2); 
					$gold_price				= round($get_weights['gold_price']); 
					
					if($metal_weight <= 2){
						$making_charges = 950;
					}else{
						$making_charges = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_making_charges', Mage::app()->getStore());	
					} 
					
					$gold_cost			= round($metal_weight * $gold_price);
					//$base_18k_making_cost 	= round($metal_weight * $making_charges);
										
					if($gemstone_flag == 1 || $diamond_flag == 1){ 
						$base_18k_making_cost = round($metal_weight * $making_charges) ;
					}else{   
						$base_18k_making_cost = round(($making_cost / $base_metal_weight) * $metal_weight); 
					} 
								
					if($gemstone_flag == 1 && $diamond_flag == 1){ 
						$vat_cost = round(($gold_cost + $base_18k_making_cost + $base_18k_diamond_cost + $gemstone_cost) * 0.01);
						$new_price = round($gold_cost + $base_18k_making_cost + $base_18k_diamond_cost + $vat_cost + $gemstone_cost);  
					}else if($gemstone_flag == 1 && $diamond_flag == 0){ 
						$vat_cost = round(($gold_cost + $base_18k_making_cost + $gemstone_cost) * 0.01);
						$new_price = round($gold_cost + $base_18k_making_cost + $gemstone_cost + $vat_cost);  
					}else if($gemstone_flag == 0 && $diamond_flag == 1){  
						$vat_cost = round(($gold_cost + $base_18k_making_cost + $base_18k_diamond_cost) * 0.01);
						$new_price = round($gold_cost + $base_18k_making_cost + $base_18k_diamond_cost + $vat_cost);
					}else{
												
						$gold_cost 		= round($metal_weight * $gold_price);		
						$making_cost 	= round(($making_cost / $base_metal_weight) * $metal_weight);
						$vat_cost 		= round(($gold_cost + $making_cost) * 0.01);
						$new_price 		= round($gold_cost + $making_cost + $vat_cost);
					}
										
					$old_price = round($new_price / $offer_percent);
							
					$array[] = array('product_id'=>$product_id, 'sku'=>$sku, 'metal_id' => $metal_id,'purity_id' => $purity_id_non_default, 'name'=>$name, 'metal'=>$metal, 'purity'=>$purity, 'url'=>$url, 'expected_delivery_date'=>$expected_delivery_date, 'height'=>$height, 'width'=>$width, 'short_description'=>$short_description, 'default_metal_weight'=>$metal_weight, 'default_total_weight'=>$total_weight, 'product_type'=>$product_type, 'design_no'=>$design_no, 'gender'=>$gender, 'product_status'=>$product_status,  'category'=>$category, 'price'=>$old_price,'price_after_discount'=>$new_price, 'diamond_1_clarity'=>$diamond_1_clarity,'diamond_1_shape'=>$diamond_1_shape,'diamond_1_color'=>$diamond_1_color,'diamond_1_weight'=>$diamond_1_weight,'diamond_1_no_of_diamonds'=>$diamond_1_no_of_diamonds,'diamond_1_setting_type'=>$diamond_1_setting_type, 'diamond_2_clarity'=>$diamond_2_clarity, 'diamond_2_shape'=>$diamond_2_shape,'diamond_2_color'=>$diamond_2_color,'diamond_2_weight'=>$diamond_2_weight,'diamond_2_no_of_diamonds'=>$diamond_2_no_of_diamonds,'diamond_2_setting_type'=>$diamond_2_setting_type, 'diamond_3_clarity'=>$diamond_3_clarity, 'diamond_3_shape'=>$diamond_3_shape,'diamond_3_color'=>$diamond_3_color,'diamond_3_weight'=>$diamond_3_weight,'diamond_3_no_of_diamonds'=>$diamond_3_no_of_diamonds,'diamond_3_setting_type'=>$diamond_3_setting_type, 'diamond_4_clarity'=>$diamond_4_clarity, 'diamond_4_shape'=>$diamond_4_shape,'diamond_4_color'=>$diamond_4_color,'diamond_4_weight'=>$diamond_4_weight,'diamond_4_no_of_diamonds'=>$diamond_4_no_of_diamonds,'diamond_4_setting_type'=>$diamond_4_setting_type, 'diamond_5_clarity'=>$diamond_5_clarity, 'diamond_5_shape'=>$diamond_5_shape,'diamond_5_color'=>$diamond_5_color,'diamond_5_weight'=>$diamond_5_weight,'diamond_5_no_of_diamonds'=>$diamond_5_no_of_diamonds,'diamond_5_setting_type'=>$diamond_5_setting_type, 'diamond_6_clarity'=>$diamond_6_clarity, 'diamond_6_shape'=>$diamond_6_shape,'diamond_6_color'=>$diamond_6_color,'diamond_6_weight'=>$diamond_6_weight,'diamond_6_no_of_diamonds'=>$diamond_6_no_of_diamonds,'diamond_6_setting_type'=>$diamond_6_setting_type, 'diamond_7_clarity'=>$diamond_7_clarity, 'diamond_7_shape'=>$diamond_7_shape,'diamond_7_color'=>$diamond_7_color,'diamond_7_weight'=>$diamond_7_weight,'diamond_7_no_of_diamonds'=>$diamond_7_no_of_diamonds,'diamond_7_setting_type'=>$diamond_7_setting_type, 'gemstone_1_total_gemstone'=>$gemstone_1_total_gemstone, 'gemstone_1_type'=>$gemstone_1_type,'gemstone_1_color'=>$gemstone_1_color,'gemstone_1_shape'=>$gemstone_1_shape,'gemstone_1_weight'=>$gemstone_1_weight, 'gemstone_2_total_gemstone'=>$gemstone_2_total_gemstone, 'gemstone_2_type'=>$gemstone_2_type,'gemstone_2_color'=>$gemstone_2_color,'gemstone_2_shape'=>$gemstone_2_shape,'gemstone_2_weight'=>$gemstone_2_weight, 'gemstone_3_total_gemstone'=>$gemstone_3_total_gemstone, 'gemstone_3_type'=>$gemstone_3_type,'gemstone_3_color'=>$gemstone_3_color,'gemstone_3_shape'=>$gemstone_3_shape,'gemstone_3_weight'=>$gemstone_3_weight, 'gemstone_4_total_gemstone'=>$gemstone_4_total_gemstone, 'gemstone_4_type'=>$gemstone_4_type,'gemstone_4_color'=>$gemstone_4_color,'gemstone_4_shape'=>$gemstone_4_shape,'gemstone_4_weight'=>$gemstone_4_weight, 'gemstone_5_total_gemstone'=>$gemstone_5_total_gemstone, 'gemstone_5_type'=>$gemstone_5_type,'gemstone_5_color'=>$gemstone_5_color,'gemstone_5_shape'=>$gemstone_5_shape,'gemstone_5_weight'=>$gemstone_5_weight, 'img_1' => $img_array['img_1'], 'img_2' => $img_array['img_2'], 'img_3' => $img_array['img_3'],'img_4' => $img_array['img_4']);
				}
					
			}
			unset($sql);
		}
		
		//echo '<pre>'; print_r($array); echo '</pre>'; exit;
		
		array_to_csv($array,'candere_'.$label.'_'.date('d-M-y').'.csv'); 
		
		unset($array);
	} 
	 
		
	public function getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$length,$thickeness,$diamond_selection,$offer_percent,$base_purity_id){ 
		  
		$diamond_gemstone_weight_metal_weight_1 = 0;
		$diamond_gemstone_weight_metal_weight_2 = 0;
		$diamond_gemstone_weight_metal_weight_3 = 0;
		$diamond_gemstone_weight_metal_weight_4 = 0;
		$diamond_gemstone_weight_metal_weight_5 = 0;
		$diamond_gemstone_weight_metal_weight_6 = 0;
		$diamond_gemstone_weight_metal_weight_7 = 0;

		$diamond_gemstone_weight_stone_1 = 0;
		$diamond_gemstone_weight_stone_2 = 0;
		$diamond_gemstone_weight_stone_3 = 0;
		$diamond_gemstone_weight_stone_4 = 0;
		$diamond_gemstone_weight_stone_5 = 0;
		$diamond_gemstone_weight_stone_6 = 0;
		$diamond_gemstone_weight_stone_7 = 0;
		  
		preg_match_all('/\d+(\.\d+)?/', $length, $matches); 
		$length = end($matches[0]);   
		
		preg_match_all('/\d+(\.\d+)?/', $thickeness, $matches);  
		$thickness = end($matches[0]);    
		
		$_product = Mage::getModel('catalog/product')->load($product_id);
		 
		$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
		$currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
		 
		$product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(), 'candere_product_type'); 
		
		$metal_weight = $_product->getDefault_metal_weight(); 
		$total_weight = $_product->getTotal_weight(); 
				
		$diamond_gemstone_weight =  $_product->getDiamond_gemstone_weight();
		
		if(strlen($diamond_selection) > 1){
			$base_price_field = $diamond_selection.'_price';
		}else{
			$base_price_field = 'price';
		}
				
		$sql = "select sku from pricing_table_metal_options  where metal_id = $metal_id and purity = $purity_id and product_id = $product_id";
		
		$readConnection 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		$sku = $readConnection->fetchOne($sql);	 
		
		$base_old_price = $this->getBaseProductPrice($product_id,$base_price_field); 
				
		$base_new_price = round($base_old_price * $offer_percent);
				
		$product_diamond_gemstone_flag = $this->getProductDiamondandGemstoneCost($product_id,$product_type,$metal_weight,$total_weight,$base_new_price,$purity_id);
		
		$gemstone_flag 			= $product_diamond_gemstone_flag['gemstone_flag'];
		$diamond_flag 			= $product_diamond_gemstone_flag['diamond_flag'];
		$gemstone_cost 			= $product_diamond_gemstone_flag['gemstone_cost'];   
		$base_18k_gold_price 	= $product_diamond_gemstone_flag['base_18k_gold_price'];   
		$base_18k_gold_cost 	= $product_diamond_gemstone_flag['base_18k_gold_cost'];   
		$base_18k_making_cost 	= $product_diamond_gemstone_flag['base_18k_making_cost'];   
		$base_18k_vat_cost 		= $product_diamond_gemstone_flag['base_18k_vat_cost'];   
		$base_18k_diamond_cost 	= $product_diamond_gemstone_flag['base_18k_diamond_cost'];   
		$base_total_weight 		= $product_diamond_gemstone_flag['total_weight'];   
		$base_metal_weight 		= $product_diamond_gemstone_flag['metal_weight'];   
		
		
		if($base_metal_weight <= 2){
			$making_charges = 950;
		}else{
			$making_charges = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_making_charges', Mage::app()->getStore());	
		} 
	
		/**********************************************************************/
		 
		$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($metal_weight,$total_weight,$purity_id,$product_type);
		
		$gold_price			= round($get_weights['gold_price']);  
		
		$metal_weight 		= $get_weights['metal_weight'];
		$total_weight 		= $get_weights['total_weight'];
	  	 
		if($product_type == 'Coins'){
			 $new_price = $base_new_price;
			 $old_price = $base_new_price;
		}else if($product_type == 'Chains' || $product_type == 'Bracelets'){  
			  
			$gold_cost = round($metal_weight * $gold_price);
			   
			if($gemstone_flag == 1 || $diamond_flag == 1){ 
				$making_cost = round($metal_weight * $making_charges);
			}else{    
				$making_cost = round(($base_18k_making_cost / $base_metal_weight) * $metal_weight); 
			}
			
			$vat_cost = round(($gold_cost + $making_cost + $base_18k_diamond_cost + $gemstone_cost) * 0.01); 
			
			$new_price = round($gold_cost + $making_cost + $base_18k_diamond_cost + $vat_cost + $gemstone_cost);
			   
			/************************************************************/
			$diamond_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_status');
										
			$collection_details_diamond_status = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_status->getId())->getFirstItem();
			
			$status1 = $collection_details_diamond_status->getDiamond_1();
			$status2 = $collection_details_diamond_status->getDiamond_2();
			$status3 = $collection_details_diamond_status->getDiamond_3();
			$status4 = $collection_details_diamond_status->getDiamond_4();
			$status5 = $collection_details_diamond_status->getDiamond_5();
			$status6 = $collection_details_diamond_status->getDiamond_6();
			$status7 = $collection_details_diamond_status->getDiamond_7();

			
			if ($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1) {
				
				$default_length =  trim(str_replace('inches','',Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getBracelets_length(),'bracelets_length')));
			 
				$diamond_one_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_one_total_weight');
				 
				$collection_details_weight = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_one_total_weight->getId())->getFirstItem();
				  				  
				$diamond_1_weight = $collection_details_weight->getDiamond_1();
				$diamond_2_weight =  $collection_details_weight->getDiamond_2();
				$diamond_3_weight = $collection_details_weight->getDiamond_3();
				$diamond_4_weight = $collection_details_weight->getDiamond_4();
				$diamond_5_weight = $collection_details_weight->getDiamond_5();
				$diamond_6_weight = $collection_details_weight->getDiamond_6();
				$diamond_7_weight = $collection_details_weight->getDiamond_7(); 
				  
				$diamond_one_total_no_of_stones = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_one_total_no_of_stones');

				$collection_details_stones = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_one_total_no_of_stones->getId())->getFirstItem();

				$diamond_1_stones = $collection_details_stones->getDiamond_1();
				$diamond_2_stones =  $collection_details_stones->getDiamond_2();
				$diamond_3_stones = $collection_details_stones->getDiamond_3();
				$diamond_4_stones = $collection_details_stones->getDiamond_4();
				$diamond_5_stones = $collection_details_stones->getDiamond_5();
				$diamond_6_stones = $collection_details_stones->getDiamond_6();
				$diamond_7_stones = $collection_details_stones->getDiamond_7(); 

				$diamond_gemstone_weight_metal_weight_1 = number_format(($diamond_1_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_2 = number_format(($diamond_2_weight / $default_length) * $length,2).' carat' ;
				$diamond_gemstone_weight_metal_weight_3 = number_format(($diamond_3_weight / $default_length) * $length,2).' carat';
				$diamond_gemstone_weight_metal_weight_4 = number_format(($diamond_4_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_5 = number_format(($diamond_5_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_6 = number_format(($diamond_6_weight / $default_length) * $length,2).' carat' ;
				$diamond_gemstone_weight_metal_weight_7 = number_format(($diamond_7_weight / $default_length) * $length,2) .' carat';

				$diamond_gemstone_weight_stone_1 = round(($diamond_1_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_2 = round(($diamond_2_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_3 = round(($diamond_3_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_4 = round(($diamond_4_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_5 = round(($diamond_5_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_6 = round(($diamond_6_stones / $default_length) * $length) ;
				$diamond_gemstone_weight_stone_7 = round(($diamond_7_stones / $default_length) * $length) ;
			 }		
			/***********************************************************************/
		}else{  
			$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender');
		
			if($gender == 'Male'){
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore());
			}else{
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore());
			}
			 			 
				$gold_price	= round($gold_price);
				$gold_cost 	= round($metal_weight * $gold_price);
				
				if($gemstone_flag == 1 || $diamond_flag == 1){ 
					$making_cost = round($metal_weight * $making_charges) ;
				}else{   
					$making_cost = round(($base_18k_making_cost / $base_metal_weight) * $metal_weight); 
				}
				 				 
				if($gemstone_flag == 1 && $diamond_flag == 1){ 
					$vat_cost = round(($gold_cost + $making_cost + $base_18k_diamond_cost + $gemstone_cost) * 0.01);
					$new_price = round($gold_cost + $making_cost + $base_18k_diamond_cost + $vat_cost + $gemstone_cost);  
				}else if($gemstone_flag == 1 && $diamond_flag == 0){ 
					$vat_cost = round(($gold_cost + $making_cost + $gemstone_cost) * 0.01);
					$new_price = round($gold_cost + $making_cost + $gemstone_cost + $vat_cost);  
				}else if($gemstone_flag == 0 && $diamond_flag == 1){  
					$vat_cost = round(($gold_cost + $making_cost + $base_18k_diamond_cost) * 0.01);  
					$new_price = round($gold_cost + $making_cost + $base_18k_diamond_cost + $vat_cost); 
				}else{  
					$gold_cost 				= round($metal_weight * $gold_price) ;
					$base_old_price 		= $base_new_price;
					$base_new_price 		= ($base_old_price * $offer_percent) ; 
					$making_cost 			= 0 ;
					    
					$making_cost = round(($base_18k_making_cost / $base_metal_weight) * $metal_weight);
					$vat_cost = round(($gold_cost + $making_cost) * 0.01);
					$new_price = round($gold_cost + $making_cost + $vat_cost); 
				}
		}  
		$old_price = round($new_price / $offer_percent);
				 
		$metal 	= Mage::helper('function')->get_metal_attribute_name($metal_id);
		$purity = Mage::helper('function')->get_karat_attribute_name($purity_id);
		
		$new_price = Mage::helper('directory')->currencyConvert($new_price ,$baseCurrencyCode, $currentCurrencyCode);
		$old_price = Mage::helper('directory')->currencyConvert($old_price ,$baseCurrencyCode, $currentCurrencyCode);
		/**********************************************************************/
		
		
		$metal_weight = number_format($metal_weight,2);
		$total_weight = number_format($total_weight,2);
		
		$is_emi_enabled = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/emienable', Mage::app()->getStore()) ;
		
		if($is_emi_enabled){
			$emi_in_months = (Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/emiinmonths', Mage::app()->getStore()) != '') ? Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/emiinmonths', Mage::app()->getStore()) : 0;
			
			$emi = round($new_price / $emi_in_months) ;
		}else{
			$emi = 0;
		} 
		
		$gold_cost = Mage::helper('directory')->currencyConvert($gold_cost ,$baseCurrencyCode, $currentCurrencyCode);
		$making_cost = Mage::helper('directory')->currencyConvert($making_cost ,$baseCurrencyCode, $currentCurrencyCode);
		$base_18k_diamond_cost = Mage::helper('directory')->currencyConvert($base_18k_diamond_cost ,$baseCurrencyCode, $currentCurrencyCode);
		$vat_cost = Mage::helper('directory')->currencyConvert($vat_cost ,$baseCurrencyCode, $currentCurrencyCode);
		$gemstone_cost = Mage::helper('directory')->currencyConvert($gemstone_cost ,$baseCurrencyCode, $currentCurrencyCode);
	 
		return array('metal_weight'=>$metal_weight,'total_weight'=>$total_weight,'old_price'=>$old_price,'new_price'=>$new_price,'gold_cost'=>$gold_cost,'making_cost'=>$making_cost,'vat_cost'=>$vat_cost,'gold_cost'=>$gold_cost,'base_18k_diamond_cost'=>$base_18k_diamond_cost,'gemstone_cost'=>$gemstone_cost,'metal'=>$metal,'purity'=>$purity,'emi'=>$emi,'sku'=>$sku,'diamond_gemstone_weight_metal_weight_1'=>$diamond_gemstone_weight_metal_weight_1,'diamond_gemstone_weight_metal_weight_2'=>$diamond_gemstone_weight_metal_weight_2 ,'diamond_gemstone_weight_metal_weight_3'=>$diamond_gemstone_weight_metal_weight_3,'diamond_gemstone_weight_metal_weight_4'=>$diamond_gemstone_weight_metal_weight_4,'diamond_gemstone_weight_metal_weight_5'=>$diamond_gemstone_weight_metal_weight_5,'diamond_gemstone_weight_metal_weight_6'=>$diamond_gemstone_weight_metal_weight_6,'diamond_gemstone_weight_metal_weight_7'=>$diamond_gemstone_weight_metal_weight_7 ,'diamond_gemstone_weight_stone_1'=>$diamond_gemstone_weight_stone_1, 'diamond_gemstone_weight_stone_2'=>$diamond_gemstone_weight_stone_2,'diamond_gemstone_weight_stone_3'=>$diamond_gemstone_weight_stone_3,'diamond_gemstone_weight_stone_4'=>$diamond_gemstone_weight_stone_4,'diamond_gemstone_weight_stone_5'=>$diamond_gemstone_weight_stone_5,'diamond_gemstone_weight_stone_6'=>$diamond_gemstone_weight_stone_6,'diamond_gemstone_weight_stone_7'=>$diamond_gemstone_weight_stone_7, 'gold_price'=>$gold_price, 'gemstone_flag'=>$gemstone_flag, 'diamond_flag'=>$diamond_flag);
	}
	
	
	public function getProductDiamondandGemstoneCost($product_id,$product_type,$metal_weight,$total_weight,$base_new_price,$purity_id){  
		
		if($metal_weight <= 2){
			$making_charges = 950;
		}else{
			$making_charges = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_making_charges', Mage::app()->getStore());	
		}
		
		$read 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		
		$gemstone_cost = 0;
		$gemstone_price_weight_1 = 0;
		$gemstone_price_weight_2 = 0;
		$gemstone_price_weight_3 = 0;
		$gemstone_price_weight_4 = 0;
		$gemstone_price_weight_5 = 0;
		
		$diamond_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_status');
			
		$collection_details_diamond_status = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_status->getId())->getFirstItem();
	 
		$status1 = $collection_details_diamond_status->getDiamond_1();
		$status2 = $collection_details_diamond_status->getDiamond_2();
		$status3 = $collection_details_diamond_status->getDiamond_3();
		$status4 = $collection_details_diamond_status->getDiamond_4();
		$status5 = $collection_details_diamond_status->getDiamond_5();
		$status6 = $collection_details_diamond_status->getDiamond_6();
		$status7 = $collection_details_diamond_status->getDiamond_7();

		$gemstone_cost 	= 0;
		$diamond_flag 	= 0;
		if ($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1 || $status6 == 1 || $status7 == 1) {
			$diamond_flag = 1;
		}
		 
		$gemstone_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone_status');

		$collection_details_gemstone_status = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_status->getId())->getFirstItem();

		$status1 = $collection_details_gemstone_status->getGemstone_1();
		$status2 = $collection_details_gemstone_status->getGemstone_2();
		$status3 = $collection_details_gemstone_status->getGemstone_3();
		$status4 = $collection_details_gemstone_status->getGemstone_4();
		$status5 = $collection_details_gemstone_status->getGemstone_5();
		
		$gemstone_flag = 0;
		
		if ($status1 == 1 || $status2 == 1 || $status3 == 1 || $status4 == 1 || $status5 == 1) {
			$gemstone_flag = 1;
		} 
		
		if($gemstone_flag == 1){
			$gemstone = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone');

			$collection_gemstone = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone->getId())->getFirstItem();
			 
			$gemstone_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone_total_weight');

			$collection_details_total_weight = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_total_weight->getId())->getFirstItem();
			
			if($collection_details_total_weight){
			
				$gemstone_weight_1 = $collection_details_total_weight->getGemstone_1();
				$gemstone_weight_2 = $collection_details_total_weight->getGemstone_2();
				$gemstone_weight_3 = $collection_details_total_weight->getGemstone_3();
				$gemstone_weight_4 = $collection_details_total_weight->getGemstone_4();
				$gemstone_weight_5 = $collection_details_total_weight->getGemstone_5();
				 
				if($gemstone_weight_1 > 0){
					$gemstone_1 = $collection_gemstone->getGemstone_1();  
					 
					$gemstone_price_1 = $read->fetchOne('SELECT price from gemstone_price_master where gemstone_id = "'.$gemstone_1.'"');
					
					$gemstone_price_weight_1 =  $gemstone_weight_1 * $gemstone_price_1;
				}
				if($gemstone_weight_2 > 0){
					$gemstone_2 = $collection_gemstone->getGemstone_2();
					
					$gemstone_price_2 = $read->fetchOne('SELECT price from gemstone_price_master where gemstone_id = "'.$gemstone_2.'"');

					$gemstone_price_weight_2 =  $gemstone_weight_2 * $gemstone_price_2;	
				}
				if($gemstone_weight_3 > 0){
					$gemstone_3 = $collection_gemstone->getGemstone_3();
					
					$gemstone_price_3 = $read->fetchOne('SELECT price from gemstone_price_master where gemstone_id = "'.$gemstone_3.'"');
					
					$gemstone_price_weight_3 = $gemstone_weight_3 * $gemstone_price_3;	
				}
				if($gemstone_weight_4 > 0){
					$gemstone_4 = $collection_gemstone->getGemstone_4();
					
					$gemstone_price_4 = $read->fetchOne('SELECT price from gemstone_price_master where gemstone_id = "'.$gemstone_4.'"');
					
					$gemstone_price_weight_4 = $gemstone_weight_4 * $gemstone_price_4;
				}
				if($gemstone_weight_5 > 0){
					$gemstone_5 = $collection_gemstone->getGemstone_5();
					
					$gemstone_price_5 = $read->fetchOne('SELECT price from gemstone_price_master where gemstone_id = "'.$gemstone_5.'"');
					
					$gemstone_price_weight_5 = $gemstone_weight_5 * $gemstone_price_5;
				}
				
				$gemstone_cost  =  $gemstone_price_weight_1 + $gemstone_price_weight_2 + $gemstone_price_weight_3 + $gemstone_price_weight_4 + $gemstone_price_weight_5  ;
			} 
		}
		 		 
		$default_metal_karat = Mage::helper('function')->get_default_metal_karat($product_id, $product_type); 
			
		$metal_id 			= $default_metal_karat['metal_id'];
		//$purity_id 			= $default_metal_karat['purity'];
		$ring_sizer_enabled = $default_metal_karat['ring_sizer'];
				
		$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($metal_weight,$total_weight,$purity_id,$product_type);
						
		$metal_weight = number_format($get_weights['metal_weight'],2);
		$total_weight = number_format($get_weights['total_weight'],2); 
		
		$base_18k_gold_price	= round($get_weights['gold_price']); 
	 
		$base_18k_gold_cost		= round($metal_weight * $base_18k_gold_price) ;
		
		$base_18k_making_cost 	= round($metal_weight * $making_charges) ;
		
		$base_18k_vat_cost 		= round($base_new_price / 101);
		 
		if($gemstone_flag == 1 || $diamond_flag == 1){ 
			$base_18k_diamond_cost 	= $base_new_price - ($base_18k_gold_cost + $base_18k_making_cost + $base_18k_vat_cost + $gemstone_cost);  
		}else{ 
			$base_18k_diamond_cost 	= 0 ;
			$base_18k_making_cost = $base_new_price - ($base_18k_gold_cost + $base_18k_vat_cost); 
		}
		
		if($gemstone_flag == 1 && $diamond_flag == 1){ 
			$gemstone_cost  = $gemstone_cost ;
			$base_18k_diamond_cost  = $base_18k_diamond_cost ;
		}else if($gemstone_flag == 1 && $diamond_flag == 0){ 
			$gemstone_cost  = $gemstone_cost + $base_18k_diamond_cost;
			$base_18k_diamond_cost  = 0 ;
		}else if($gemstone_flag == 0 && $diamond_flag == 1){ 
			$gemstone_cost  = 0 ;
			$base_18k_diamond_cost  = $base_18k_diamond_cost;
		}else{
			$gemstone_cost  = 0;
			$base_18k_diamond_cost  = 0 ;
		} 
		 
		return array('metal_id' => $metal_id,'purity_id' => $purity_id,'ring_sizer_enabled' => $ring_sizer_enabled,'diamond_flag' => $diamond_flag,'gemstone_flag' => $gemstone_flag,'gemstone_cost' => $gemstone_cost,'base_18k_gold_price' => $base_18k_gold_price,'base_18k_gold_cost' => $base_18k_gold_cost,'base_18k_making_cost' => $base_18k_making_cost,'base_18k_vat_cost' => $base_18k_vat_cost,'base_18k_diamond_cost'=>$base_18k_diamond_cost,'metal_weight'=>$metal_weight,'total_weight'=>$total_weight);
	}
	
		
	public function myqueryfunction($label){	
		$this->db->cache_delete_all();
		
		if($label=='gold') {
			$is_diamond = 1;
		} else {
			$is_diamond = 0;
		}
		///AND	(pricing_table_metal_options.sku = 'GR00161')
			
		$sql =	"SELECT DISTINCT
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.sku,
       pricing_table_metal_options.metal_id,
       catalog_product_entity_varchar.value AS name,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar_1.value AS url,
       catalog_product_entity_varchar_3.value AS expected_delivery_date,
       catalog_product_entity_varchar_4.value AS height,
       catalog_product_entity_varchar_5.value AS width,
       catalog_product_entity_text.value AS short_description,
       catalog_product_entity_varchar_7.value AS weight,
       catalog_product_entity_varchar_6.value AS total_weight,
       eav_attribute_option_value_2.value AS product_type,
       catalog_product_entity_varchar_8.value AS design_no,
       eav_attribute_option_value_3.value AS gender,
       IF(catalog_product_entity_int_1.value = 1, 'Enabled', 'Disabled')
          AS product_status,
       pricing_table_metal_options.price,
       pricing_table_metal_options.purity AS purity_id
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   catalog_product_entity_int catalog_product_entity_int_3
                                                                                   INNER JOIN
                                                                                      eav_attribute_option_value eav_attribute_option_value_3
                                                                                   ON (catalog_product_entity_int_3.value =
                                                                                          eav_attribute_option_value_3.option_id))
                                                                               INNER JOIN
                                                                                  metal_options_enabled metal_options_enabled
                                                                               ON (metal_options_enabled.product_id =
                                                                                      catalog_product_entity_int_3.entity_id))
                                                                           INNER JOIN
                                                                              catalog_product_entity_varchar catalog_product_entity_varchar_7
                                                                           ON (metal_options_enabled.product_id =
                                                                                  catalog_product_entity_varchar_7.entity_id))
                                                                       INNER JOIN
                                                                          pricing_table_metal_options pricing_table_metal_options
                                                                       ON     (metal_options_enabled.product_id =
                                                                                  pricing_table_metal_options.product_id)
                                                                          AND (metal_options_enabled.metal_id =
                                                                                  pricing_table_metal_options.metal_id))
                                                                   INNER JOIN
                                                                      catalog_product_entity_varchar catalog_product_entity_varchar_2
                                                                   ON (pricing_table_metal_options.product_id =
                                                                          catalog_product_entity_varchar_2.entity_id))
                                                               INNER JOIN
                                                                  catalog_product_entity_varchar catalog_product_entity_varchar
                                                               ON (pricing_table_metal_options.product_id =
                                                                      catalog_product_entity_varchar.entity_id))
                                                           INNER JOIN
                                                              catalog_product_entity_int catalog_product_entity_int_1
                                                           ON (pricing_table_metal_options.product_id =
                                                                  catalog_product_entity_int_1.entity_id))
                                                       INNER JOIN
                                                          catalog_product_entity_int catalog_product_entity_int_2
                                                       ON (pricing_table_metal_options.product_id =
                                                              catalog_product_entity_int_2.entity_id))
                                                   INNER JOIN
                                                      eav_attribute_option_value eav_attribute_option_value
                                                   ON (pricing_table_metal_options.metal_id =
                                                          eav_attribute_option_value.option_id))
                                               INNER JOIN
                                                  catalog_product_entity_varchar catalog_product_entity_varchar_4
                                               ON (pricing_table_metal_options.product_id =
                                                      catalog_product_entity_varchar_4.entity_id))
                                           INNER JOIN
                                              catalog_product_entity_varchar catalog_product_entity_varchar_1
                                           ON (pricing_table_metal_options.product_id =
                                                  catalog_product_entity_varchar_1.entity_id))
                                       INNER JOIN
                                          eav_attribute_option_value eav_attribute_option_value_1
                                       ON (pricing_table_metal_options.purity =
                                              eav_attribute_option_value_1.option_id))
                                   INNER JOIN
                                      catalog_product_entity_varchar catalog_product_entity_varchar_3
                                   ON (pricing_table_metal_options.product_id =
                                          catalog_product_entity_varchar_3.entity_id))
                               INNER JOIN
                                  catalog_product_entity_int catalog_product_entity_int_4
                               ON (pricing_table_metal_options.product_id =
                                      catalog_product_entity_int_4.entity_id))
                           INNER JOIN
                              catalog_product_entity_text catalog_product_entity_text
                           ON (metal_options_enabled.product_id =
                                  catalog_product_entity_text.entity_id))
                       INNER JOIN
                          catalog_product_entity_varchar catalog_product_entity_varchar_5
                       ON (metal_options_enabled.product_id =
                              catalog_product_entity_varchar_5.entity_id))
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar_8
                   ON (metal_options_enabled.product_id =
                          catalog_product_entity_varchar_8.entity_id))
               INNER JOIN
                  catalog_product_entity_varchar catalog_product_entity_varchar_6
               ON (metal_options_enabled.product_id =
                      catalog_product_entity_varchar_6.entity_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (metal_options_enabled.product_id =
                  catalog_product_entity_int.entity_id))
       INNER JOIN
          eav_attribute_option_value eav_attribute_option_value_2
       ON (catalog_product_entity_int.value =
              eav_attribute_option_value_2.option_id)
 WHERE     (catalog_product_entity_int_4.attribute_id = 277)
       AND (catalog_product_entity_int_4.value = $is_diamond)
       AND (    catalog_product_entity_int_3.attribute_id = 163
            AND (    catalog_product_entity_varchar_8.attribute_id = 135
                 AND (    catalog_product_entity_varchar_7.attribute_id = 282
                      AND (    (    (    catalog_product_entity_int_1.attribute_id =
                                            96
											AND catalog_product_entity_int_1.value = 1
                                     AND catalog_product_entity_int_2.attribute_id =
                                            102)
                                AND catalog_product_entity_int_2.value = 4)
                           AND (    (    (    (    catalog_product_entity_varchar_5.attribute_id =
                                                      165
                                               AND catalog_product_entity_text.attribute_id =
                                                      73)
                                          AND catalog_product_entity_varchar_6.attribute_id =
                                                 229)
                                     AND catalog_product_entity_int.attribute_id =
                                            272)
                                AND (    (    (    (    (    (    (    metal_options_enabled.status =
                                                                          1
                                                                   AND metal_options_enabled.isdefault =
                                                                          1)
                                                              AND pricing_table_metal_options.status =
                                                                     1)
                                                         AND pricing_table_metal_options.isdefault =
                                                                1)
                                                    AND catalog_product_entity_varchar.attribute_id =
                                                           71)
                                               AND catalog_product_entity_varchar_1.attribute_id =
                                                      98)
                                          AND catalog_product_entity_varchar_3.attribute_id =
                                                 162)
                                     AND catalog_product_entity_varchar_4.attribute_id =
                                            164))))))
ORDER BY metal_options_enabled.product_id DESC";

		$results = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
		$result = $results->result_array();
		return $result ;
	}
	
	public function getBaseProductPrice($product_id,$base_price_field){
		
		$sql = "SELECT  pricing_table_metal_options.".$base_price_field." as price 
			  FROM   metal_options_enabled metal_options_enabled
				   INNER JOIN
					  pricing_table_metal_options pricing_table_metal_options
				   ON     (metal_options_enabled.product_id =
							  pricing_table_metal_options.product_id)
					  AND (metal_options_enabled.metal_id =
							  pricing_table_metal_options.metal_id)
			 WHERE     (metal_options_enabled.status = 1)
				   AND (pricing_table_metal_options.status = 1)
				   AND (metal_options_enabled.isdefault = 1)
				   AND (pricing_table_metal_options.isdefault = 1)
				   AND (metal_options_enabled.product_id = $product_id)";
		 
		$readConnection 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		$base_price 		= $readConnection->fetchOne($sql);	 
 	
		return $base_price ;	 
	}
	
}


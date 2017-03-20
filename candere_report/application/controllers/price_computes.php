<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Price_Computes extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
		set_time_limit(0);
		$this->load->helper('csv');
	}
	
	public function index()
	{
		$this->load->view('templates/header'); 
        $this->load->view('price_compute/index',$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function get_product_details()
	{	 
		$this->db->cache_delete_all();
		$product_type = $this->input->get('product_type', TRUE);
		
		$products =  $this->sql_query_export_products_without_dropdown($product_type);
		
		$data_table = array();
				  
		foreach($products as $key=>$value) 
		{
			$product_id 			= $value['product_id'];
			$product_name 			= $value['name'];
			$product_sku 			= $value['sku'];
			$width 					= $value['width'];
			$status 				= $value['status'];
			$metal_id 				= $value['metal_id'];
			$metal_name				= $value['metal'];
			$purity_id 				= $value['purity_id'];
			$purity_name			= $value['purity'];
			$metal_weight 			= $value['default_metal_weight'];
			$total_weight 			= $value['default_total_weight'];
			$price 					= $value['price'];
			$ring_sizer_enabled		= $value['ring_sizer'];
			$diamond_gemstone_weight= $value['diamond_gemstone_weight'];
			$gender 				= $value['gender'];
			$bracelets_length 		= $value['bracelet_length'];
			$chain_length 			= $value['chain_length'];
			$candere_product_type 	= $value['candere_product_type'];
			$candere_product_type_id= $value['candere_product_type_id'];
			
			$_product = Mage::getModel('catalog/product')->load($product_id); 
	  
			/**********************************************************/
			$base_weight        = $metal_weight; 
			$metal_thickness    = $width;
			$product_type 		= $candere_product_type;	
			
			if($product_type == 'Bracelets'){
				$default_chain_length =  trim(str_replace('inches','',$bracelets_length));
			}else if($product_type == 'Chains'){
				$default_chain_length =  trim(str_replace('(in)','',$chain_length));
			}else{
				$default_chain_length = 0 ;
			}	
			 
			if($gender == 'Male'){
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
			}else{
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
			}
			
			$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($base_weight,$total_weight,$purity_id,$product_type);
					
			$base_weight  = number_format($get_weights['metal_weight'],2);
			$metal_weight  = $get_weights['metal_weight'];
			$total_weight = number_format($get_weights['total_weight'],2); 
			$gold_price   = $get_weights['gold_price']; 
			

			if($product_type == 'Chains'){ 
				$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'chain_length'); 
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_chain_size', Mage::app()->getStore()) ; 
			}else if($product_type == 'Bangles'){ 
				$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bangle_ring_size'); 
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_bangle_size', Mage::app()->getStore()) ; 
			}else if($product_type == 'Kada'){ 
				$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'kada_ring_size'); 
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_kada_size', Mage::app()->getStore()) ;
			}else if($product_type == 'Bracelets'){ 
				$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bracelets_length'); 
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_bracelet_size', Mage::app()->getStore()) ;
				
				$diamond_gemstone_weight_metal_weight = $diamond_gemstone_weight; 
				
			}else{
				$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');

				if($gender == 'Male'){
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore());
				}else{
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
				}			
			}
			
			$product_status = ($status==1)?'Enabled':'Disabled';
			
					 
			if($ring_sizer_enabled == 1){
				   $base_price  = $price;
						
				foreach ($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect ) { 
					if($attribute_collect['label'] !=''){  
						
						$label = $attribute_collect['label'] ;
						
						$explode_label = explode("&nbsp;", $label);
						
						
						$selected_size_readable = current($explode_label) ;
						
						$selected_size = trim(str_replace('inches','',str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label)))))) ;
						 
									
						if($product_type == 'Bracelets'){   
						
							$label = 'NA';
							
							$metal_weight = number_format(($base_weight / $default_chain_length) * $selected_size,2);
							
							$diamond_gemstone_weight_metal_weight = number_format(($diamond_gemstone_weight / $default_chain_length) * $selected_size,2);
							
							$total_weight = $metal_weight + $diamond_gemstone_weight_metal_weight;
							
							$price = ($base_price / $default_chain_length) * $selected_size;
							
							$total_metal_weight = $metal_weight;
							 
						}else if($product_type == 'Chains'){  
											
							$metal_weight = number_format(($base_weight / $default_chain_length) * $selected_size,2); 
							$total_weight = $metal_weight + $diamond_gemstone_weight;
							$price = ($base_price / $base_weight) * $metal_weight;
							//$price = ($base_price / $default_chain_length) * $selected_size ;
							$total_metal_weight = $metal_weight;
													
						}else{
						
							$total_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight + $diamond_gemstone_weight,2);
							
							$total_metal_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight,2);
							
							$metal_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight,2);
							
							$vat_difference = (($metal_weight - $base_weight) * $gold_price) / 101; 
							
							$price = ((($metal_weight - $base_weight) * $gold_price) + $base_price) + $vat_difference;
						}
						
						$old_price = $price;
						 
						$new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
							
						if($new_price == null){
							$new_price = $old_price ;
						}  
						
						if($product_type == 'Chains'){
						
							$collection = Mage::getModel('chainmmvariations/chainmmvariations')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('product_type', $candere_product_type_id)->addFieldToFilter('status', 1)->addFieldToSelect('width_mm')->addFieldToSelect('weight_gms')->addFieldToSelect('chain_default');
							
							if($collection){
								foreach($collection as $value){
								
								$selected_computed_weight = number_format(((float)((($value->getWeight_gms()) / $default_chain_length) * $selected_size)), 2, '.', '');
							
								$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($selected_computed_weight,$selected_computed_weight,$purity_id,'') ; 
							
								$selected_computed_weight = $get_weights['metal_weight'];
							
								$price = (($old_price / $metal_weight) * $selected_computed_weight);
								
								$old_price = $price;
								
								$new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
							
								if($new_price == null){
									$new_price = $old_price ;
								}  
						 				
								$data_table[] = array('product_id'=>$product_id, 'product_name'=>$product_name,'product_sku'=>$product_sku,'product_type'=>$product_type,'metal_weight'=>$metal_weight,'total_weight'=>$total_weight,'metal_name'=>$metal_name,'purity_name'=>$purity_name,'product_status'=>$product_status,'selected_size'=>$selected_size_readable,'selected_size (mm)'=>$selected_size,'size_label'=>str_replace('&nbsp;',' ',$label),'thickness'=>$value->getWidthMm(),'price_before_discount'=>round($old_price,0),'price_after_discount'=>round($new_price,0));
								}			
							}
							
						}
						else 
						{ 
								
								$data_table[] = array('product_id'=>$product_id, 'product_name'=>$product_name,'product_sku'=>$product_sku,'product_type'=>$product_type,'metal_weight'=>$metal_weight,'total_weight'=>$total_weight,'metal_name'=>$metal_name,'purity_name'=>$purity_name,'product_status'=>$product_status,'selected_size'=>$selected_size_readable,'selected_size (mm)'=>$selected_size,'size_label'=>str_replace('&nbsp;',' ',$label),'price_before_discount'=>round($old_price,0),'price_after_discount'=>round($new_price,0));
						}
					}
				}
				
			}
			else
			{ 
				$old_price = $price;
				$new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
					
				if($new_price == null){
					$new_price = $old_price ;
				}
					
				$label 						= 'N/A';
				$selected_size 				= 'N/A';
				$selected_size_readable 	= 'N/A';
				 
					
				$data_table[] = array('product_id'=>$product_id, 'product_name'=>$product_name,'product_sku'=>$product_sku,'product_type'=>$product_type,'metal_weight'=>$metal_weight,'total_weight'=>$total_weight,'metal_name'=>$metal_name,'purity_name'=>$purity_name,'product_status'=>$product_status,'selected_size'=>$selected_size_readable,'selected_size (mm)'=>$selected_size,'size_label'=>str_replace('&nbsp;',' ',$label),'price_before_discount'=>round($old_price,0),'price_after_discount'=>round($new_price,0));	
			} 
			/**********************************************************/			
						
			unset($product_id);
			unset($product_sku);
			unset($metal_id);
			unset($purity_id);
			unset($ring_sizer_enabled);
			unset($value);
			unset($_product);
		}	
		
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		array_to_csv($data_table,'export_items_'.date('d-M-y').'.csv'); 
		
		unset($data_table);
		  
	}
	
	 
	public function sql_query_export_products_without_dropdown($product_type)
	{
		$sql = "SELECT pricing_table_metal_options.sku,
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.purity AS purity_id,
       pricing_table_metal_options.metal_id,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name,
       pricing_table_metal_options.price,
       catalog_product_entity_varchar_1.value AS default_metal_weight,
       catalog_product_entity_varchar_2.value AS default_total_weight,
       metal_options_enabled.ring_sizer,
       catalog_product_entity_varchar_3.value AS width,
       catalog_product_entity_varchar_4.value AS diamond_gemstone_weight,
       eav_attribute_option_value_2.value AS candere_product_type,
       eav_attribute_option_value_2.option_id AS candere_product_type_id,
       eav_attribute_option_value_3.value AS gender,
       eav_attribute_option_value_4.value AS chain_length,
       eav_attribute_option_value_5.value AS bracelet_length,
       pricing_table_metal_options.status AS status,
       catalog_product_entity_int_5.value AS prod_status
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                                                                           INNER JOIN
                                                                              catalog_product_entity_varchar catalog_product_entity_varchar
                                                                           ON (pricing_table_metal_options.product_id =
                                                                                  catalog_product_entity_varchar.entity_id))
                                                                       INNER JOIN
                                                                          catalog_product_entity_varchar catalog_product_entity_varchar_2
                                                                       ON (pricing_table_metal_options.product_id =
                                                                              catalog_product_entity_varchar_2.entity_id))
                                                                   INNER JOIN
                                                                      metal_options_enabled metal_options_enabled
                                                                   ON     (pricing_table_metal_options.product_id =
                                                                              metal_options_enabled.product_id)
                                                                      AND (pricing_table_metal_options.metal_id =
                                                                              metal_options_enabled.metal_id))
                                                               INNER JOIN
                                                                  catalog_product_entity_varchar catalog_product_entity_varchar_4
                                                               ON (pricing_table_metal_options.product_id =
                                                                      catalog_product_entity_varchar_4.entity_id))
                                                           INNER JOIN
                                                              catalog_product_entity_int catalog_product_entity_int_1
                                                           ON (pricing_table_metal_options.product_id =
                                                                  catalog_product_entity_int_1.entity_id))
                                                       INNER JOIN
                                                          eav_attribute_option_value eav_attribute_option_value_2
                                                       ON (catalog_product_entity_int_1.value =
                                                              eav_attribute_option_value_2.option_id))
                                                   INNER JOIN
                                                      catalog_product_entity_int catalog_product_entity_int
                                                   ON (pricing_table_metal_options.product_id =
                                                          catalog_product_entity_int.entity_id))
                                               INNER JOIN
                                                  catalog_product_entity_varchar catalog_product_entity_varchar_1
                                               ON (pricing_table_metal_options.product_id =
                                                      catalog_product_entity_varchar_1.entity_id))
                                           INNER JOIN
                                              eav_attribute_option_value eav_attribute_option_value
                                           ON (pricing_table_metal_options.metal_id =
                                                  eav_attribute_option_value.option_id))
                                       INNER JOIN
                                          eav_attribute_option_value eav_attribute_option_value_1
                                       ON (pricing_table_metal_options.purity =
                                              eav_attribute_option_value_1.option_id))
                                   INNER JOIN
                                      catalog_product_entity_varchar catalog_product_entity_varchar_3
                                   ON (pricing_table_metal_options.product_id =
                                          catalog_product_entity_varchar_3.entity_id))
                               INNER JOIN
                                  catalog_product_entity_int catalog_product_entity_int_2
                               ON (pricing_table_metal_options.product_id =
                                      catalog_product_entity_int_2.entity_id))
                           INNER JOIN
                              eav_attribute_option_value eav_attribute_option_value_3
                           ON (catalog_product_entity_int_2.value =
                                  eav_attribute_option_value_3.option_id))
                       LEFT OUTER JOIN
                          catalog_product_entity_int catalog_product_entity_int_3
                       ON (pricing_table_metal_options.product_id =
                              catalog_product_entity_int_3.entity_id))
                   LEFT OUTER JOIN
                      eav_attribute_option_value eav_attribute_option_value_4
                   ON (catalog_product_entity_int_3.value =
                          eav_attribute_option_value_4.option_id))
               LEFT OUTER JOIN
                  catalog_product_entity_int catalog_product_entity_int_4
               ON (pricing_table_metal_options.product_id =
                      catalog_product_entity_int_4.entity_id))
           LEFT OUTER JOIN
              eav_attribute_option_value eav_attribute_option_value_5
           ON (catalog_product_entity_int_4.value =
                  eav_attribute_option_value_5.option_id))
       INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_5
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_5.entity_id)
 WHERE (    (    catalog_product_entity_int_5.attribute_id = 96
             AND catalog_product_entity_int_5.value = 1)
        AND (    catalog_product_entity_int_4.attribute_id = 276
             AND (    catalog_product_entity_int_3.attribute_id = 275
                  AND (    (    (    (    catalog_product_entity_varchar_3.attribute_id =
                                             165
                                      AND catalog_product_entity_varchar_4.attribute_id =
                                             281)
                                 AND catalog_product_entity_int_1.attribute_id =
                                        272)
                            AND catalog_product_entity_int_2.attribute_id =
                                   163)
                       AND (    metal_options_enabled.status = 1
                            AND (    (    (    (    (    pricing_table_metal_options.status =
                                                            1
                                                     AND catalog_product_entity_varchar.attribute_id =
                                                            71)
                                                AND catalog_product_entity_int.attribute_id =
                                                       272)
                                           AND catalog_product_entity_int.value =
                                                  $product_type)
                                      AND catalog_product_entity_varchar_1.attribute_id =
                                             282)
                                 AND catalog_product_entity_varchar_2.attribute_id =
                                        229))))))";
	
		$results = $this->db->query($sql);
		return $result = $results->result_array();
	}
	
	
}	
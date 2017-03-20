<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_rings_with_dropdown extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("export_rings_with_dropdown/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export_products_without_dropdown(){
		$product_label = $this->input->get('product_label');
		 
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
	 
		$sql = $this->sql_query_export_products_without_dropdown();
		
		$array[] = array('Product Name','Sku','Metal','Purity','Metal Weight','Total Weight','Price','Product Status'); 
		
		 
		if($sql){
			foreach($sql as $key=>$value){
				
				$base_weight        = $value['default_metal_weight']; 
				$metal_weight       = $value['default_metal_weight'];  
				$total_weight 		= $value['default_total_weight'];
				$base_price         = $value['price']; 
				$purity_id			= $value['purity_id']; 
				
				$_product = Mage::getModel('catalog/product')->load($value['product_id']); 
				 
				$diamond_gemstone_weight =  $_product->getDiamond_gemstone_weight();
				 
				$product_type =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(),'candere_product_type');
				
				$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender'); 
				 
				
				if($gender == 'Male'){
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
				}else{
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
				}
			
				$price              = 0; 
				$base_weight        = $_product->getDefault_metal_weight(); 
				$metal_weight       = $_product->getDefault_metal_weight(); 
				$metal_thickness    = $_product->getWidth(); 
				$total_weight 		= $_product->getTotal_weight();
				$base_price         = $_product->getPrice();  
				 
				$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($base_weight,$total_weight,$purity_id,$product_type);
				
				$base_weight  = number_format($get_weights['metal_weight'],2);
				
				$metal_weight  = $get_weights['metal_weight'];
				
				$total_weight = number_format($get_weights['total_weight'],2); 
				
				$price = $value['price'];
				   
				
				if($_product->getStatus() == 1){
					$status = 'Enabled';
				}else{
					$status = 'Disabled';
				}
				
				$array[] = array($_product->getName(),$value['sku'],$value['metal'],$value['purity'],$metal_weight,$total_weight,$price,$status) ;
				
				unset($status);
				unset($price);
				unset($base_weight); 
				unset($metal_weight);
				unset($total_weight); 	 
				unset($_product);	
			}
		}
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		 
		array_to_csv($array,'export_'.$product_label.'_items_'.date('d-M-y').'.csv'); 
		
		unset($array);		 
	}
	
	public function sql_query_export_products_without_dropdown(){
		$this->db->cache_delete_all();
		 
		$product_type = array(624,644,585,584);
		 
		 
		$sql =	"SELECT pricing_table_metal_options.sku,
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.purity as purity_id,
       pricing_table_metal_options.metal_id,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name,
       pricing_table_metal_options.price,
       catalog_product_entity_varchar_1.value AS default_metal_weight,
       catalog_product_entity_varchar_2.value AS default_total_weight
  FROM    (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                           INNER JOIN
                              eav_attribute_option_value eav_attribute_option_value
                           ON (pricing_table_metal_options.metal_id =
                                  eav_attribute_option_value.option_id))
                       INNER JOIN
                          eav_attribute_option_value eav_attribute_option_value_1
                       ON (pricing_table_metal_options.purity =
                              eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_varchar.entity_id))
               INNER JOIN
                 catalog_product_entity_int catalog_product_entity_int
               ON (pricing_table_metal_options.product_id =
                      catalog_product_entity_int.entity_id))
           INNER JOIN
             catalog_product_entity_varchar catalog_product_entity_varchar_1
           ON (pricing_table_metal_options.product_id =
                  catalog_product_entity_varchar_1.entity_id))
       INNER JOIN
         catalog_product_entity_varchar catalog_product_entity_varchar_2
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_varchar_2.entity_id)
 WHERE     (pricing_table_metal_options.status = 1)
       AND (catalog_product_entity_varchar.attribute_id = 71)
       AND (catalog_product_entity_int.attribute_id = 272)
       AND (catalog_product_entity_int.value IN (".implode(',',$product_type)."))
       AND (catalog_product_entity_varchar_1.attribute_id = 282)
       AND (catalog_product_entity_varchar_2.attribute_id = 229)"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		 
		return $result ;
	}
	
	
	
	public function export_chains_bracelets(){
		$product_label = $this->input->get('product_label');
		 
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
	 
		$sql = $this->sql_query_chains_bracelets($product_label);
		
		$array[] = array('Product Name','Sku','Metal','Purity','Metal Weight','Total Weight','Length','Thickness (mm)','Weight (gms)','Price','Product Status'); 
		
		if($product_label == 'chain'){ 
			$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'chain_length'); 
			$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_chain_size', Mage::app()->getStore()) ;
		}else{
			$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bracelets_length'); 
			$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_bracelet_size', Mage::app()->getStore()) ;
		}
		
		$attribute_chain_thickness  = Mage::getModel('eav/config')->getAttribute('catalog_product', 'chain_thickness'); 
		
		
		
		if($sql){
			foreach($sql as $key=>$value){
				
				$base_weight        = $value['default_metal_weight']; 
				$metal_weight       = $value['default_metal_weight'];  
				$total_weight 		= $value['default_total_weight'];
				$base_price         = $value['price']; 
				$purity_id			= $value['purity_id']; 
				
				$_product = Mage::getModel('catalog/product')->load($value['product_id']); 
				
				$diamond_gemstone_weight 	= $_product->getDiamond_gemstone_weight();
				
				$default_chain_length =  trim(str_replace('(in)','',Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getChain_length(),'chain_length')));
				
				$collection = Mage::getModel('custompricing/pricingmetaloptions')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('store_id', 0)->addFieldToFilter('status', 1)->addFieldToFilter('metal_id', $metal_id)->addFieldToFilter('purity', $purity_id)->addFieldToSelect('price')->getFirstItem();
				if($collection->getPrice() != 0){   
					$base_price  = $collection->getPrice();
				}
				foreach ( $attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect ) { 
					if($attribute_collect['label'] !=''){  
						 
						$label = $attribute_collect['label'] ;
						
						$explode_label = explode("&nbsp;", $label);
						
						$selected_size_label = trim(end($explode_label)) ; 
						
						$selected_size = trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label))))) ;
						
						$selected_computed_weight = number_format(($base_weight / $default_chain_length) * $selected_size,2);
										
						$selected_length_price = ceil(($base_price / $base_weight) * $selected_computed_weight);
						
						
						
						$total_weight = $selected_computed_weight + $diamond_gemstone_weight;
					  
						$total_metal_weight = $selected_computed_weight;
						
						$selected_length_weight = $selected_computed_weight;
						
						if($_product->getStatus() == 1){
							$status = 'Enabled';
						}else{
							$status = 'Disabled';
						}
						
						$collection = Mage::getModel('chainmmvariations/chainmmvariations')->getCollection()->addFieldToFilter('product_id', $_product->getId())->addFieldToFilter('product_type', $_product->getCandere_product_type())->addFieldToFilter('status', 1)->addFieldToSelect('width_mm')->addFieldToSelect('weight_gms')->addFieldToSelect('chain_default');
						
						if($collection){
							foreach($collection as $collect_value){ 
								
								$width_mm = $collect_value->getWidth_mm() ;
							 
								$selected_computed_weight = number_format((float)((($collect_value->getWeight_gms()) / $default_chain_length) * $selected_size), 2, '.', '');
								
								$price = ceil(($selected_length_price / $selected_length_weight) * $selected_computed_weight);
								
								$array[] = array($_product->getName(),$value['sku'],$value['metal'],$value['purity'],$total_metal_weight,$total_weight,$selected_size_label,$width_mm,$selected_computed_weight,$price,$status) ;
								
								unset($width_mm);
								unset($selected_computed_weight);
								unset($price);
							}
						} 
					}
				}

				unset($status);
				unset($price);
				unset($base_weight);
				unset($selected_size_ring);
				unset($metal_weight);
				unset($total_weight); 	
				unset($value); 
				unset($_product);	
			}
		}
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		 
		array_to_csv($array,'export_'.$product_label.'_items_'.date('d-M-y').'.csv'); 
		
		unset($array);		 
	}
	
	public function sql_query_chains_bracelets($product_label){
		$this->db->cache_delete_all();
		
		
		if($product_label == 'chain'){
			$product_type = array(590);
		}else{
			$product_type = array(591);
		}
		 
		$sql =	"SELECT pricing_table_metal_options.sku,
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.purity as purity_id,
       pricing_table_metal_options.metal_id,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name,
       pricing_table_metal_options.price,
       catalog_product_entity_varchar_1.value AS default_metal_weight,
       catalog_product_entity_varchar_2.value AS default_total_weight
  FROM    (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                           INNER JOIN
                              eav_attribute_option_value eav_attribute_option_value
                           ON (pricing_table_metal_options.metal_id =
                                  eav_attribute_option_value.option_id))
                       INNER JOIN
                          eav_attribute_option_value eav_attribute_option_value_1
                       ON (pricing_table_metal_options.purity =
                              eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_varchar.entity_id))
               INNER JOIN
                 catalog_product_entity_int catalog_product_entity_int
               ON (pricing_table_metal_options.product_id =
                      catalog_product_entity_int.entity_id))
           INNER JOIN
             catalog_product_entity_varchar catalog_product_entity_varchar_1
           ON (pricing_table_metal_options.product_id =
                  catalog_product_entity_varchar_1.entity_id))
       INNER JOIN
         catalog_product_entity_varchar catalog_product_entity_varchar_2
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_varchar_2.entity_id)
 WHERE     (pricing_table_metal_options.status = 1)
       AND (catalog_product_entity_varchar.attribute_id = 71)
       AND (catalog_product_entity_int.attribute_id = 272)
       AND (catalog_product_entity_int.value IN (".implode(',',$product_type)."))
       AND (catalog_product_entity_varchar_1.attribute_id = 282)
       AND (catalog_product_entity_varchar_2.attribute_id = 229)"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		 
		return $result ;
	}
	
	public function export()
	{  
		$product_label = $this->input->get('product_label');
		 
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
	 
		$sql = $this->sql_query($product_label);
		
		$array[] = array('Product Name','Sku','Metal','Purity','Metal Weight','Total Weight','Size','Size (mm)','Price','
		Selling Price','Product Status'); 
		
		 $collection = Mage::getResourceModel('catalog/product_collection') ->addAttributeToSelect(array('sku', 'name', 'description', 'price'));
		$flag = 0;
		if($sql){
			foreach($sql as $value){
				//echo "<pre>";
				//print_r($value); exit;
				
				$product_id			= $value['product_id'];
				$product 			= Mage::getModel('catalog/product')->load($product_id);
				$sku				= $product->getSku();
				$base_weight        = $value['default_metal_weight'];
				//$base_price         = $result_price[0]['price'];
				
				$metal_weight 		= $product->getDefault_metal_weight();			
				$total_weight 		= $product->getTotal_weight();	
				
				$default_metal_karat	= Mage::helper('function')->get_default_metal_karat($product->getId());
				$metal_id 				= $default_metal_karat['metal_id'];
				$purity_id 				= $default_metal_karat['purity'];			
				$metal_weight 			= $product->getDefault_metal_weight();			
				$total_weight 			= $product->getTotal_weight();
				$resource 		= Mage::getSingleton('core/resource');
				$readConnection = $resource->getConnection('core_read');  
				
				if($metal_id > 0 && $purity_id > 0)
				{
					$sql = 'SELECT siij_price,sigh_price,vsgh_price,vvsgh_price,vvsef_price,diamond_default FROM pricing_table_metal_options pricing_table_metal_options
				 WHERE (product_id = '.$product->getId().' and metal_id = '.$metal_id.' and purity = '.$purity_id.' and store_id = 0)  and (siij_price !=0 or sigh_price!=0 or vsgh_price!=0 or vvsgh_price!=0 or vvsef_price!=0)';
					$results = $readConnection->fetchRow($sql);
					if($results['diamond_default'] != '')
					{
						$diamond_default = explode('_',$results['diamond_default']);
						$diamond_color_value = $diamond_default[0];
						$diamond_clarity_value = $diamond_default[1];
					}
					else
					{
						$diamond_color_value = 'si';
						$diamond_clarity_value = 'gh';
					}
				}
			   
				$product_type =  Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(),'candere_product_type');
				
				$diamond_selection=$diamond_color_value.$diamond_clarity_value;
				
				$product_diamond_gemstone_flag = Mage::helper('function')->getProductDiamondandGemstoneCostValue($product_id,$product_type,$metal_weight,$total_weight,$purity_id, $diamond_color_value, $diamond_clarity_value);
				
				
				/************************************************************/
			
				$default_length 		= $product_diamond_gemstone_flag['default_length'];
				$thickness				= 0;
				if($product_type == 'Chains') {
					$default_length =  trim(Mage::helper('function')->get_attribute_name_and_value_frontend($product->getChain_length(),'chain_length'));
					$thickness = $product->getWidth();
				}

				$clarity 				= $product_diamond_gemstone_flag['diamond_clarity'];
				$color 					= $product_diamond_gemstone_flag['diamond_color'];
				$diamond_selection		= $product_diamond_gemstone_flag['diamond_clarity'].$product_diamond_gemstone_flag['diamond_color'];
				
				$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$default_length,$thickness,$diamond_selection,$purity_id,$clarity,$color);
				
				//echo "<pre>";
				//print_r($product_price_details); exit;
				$base_price         = $product_price_details['old_price'];
				$_product = Mage::getModel('catalog/product')->load($value['product_id']); 
				
				if($product_label == 'ring'){
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					
					$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender');
						 
						 
					if($gender == 'Male'){
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
					}else{
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
					}
					
				}else if($product_label == 'band'){
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					
					$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender');
						 
						 
					if($gender == 'Male'){
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
					}else{
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
					}
					
				}else if($product_label == 'bangle'){
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bangle_ring_size'); 

					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_bangle_size', Mage::app()->getStore()) ; 
					
				}else if($product_label == 'kada'){
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'kada_ring_size'); 
					
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_kada_size', Mage::app()->getStore()) ;
					
				}else{
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					
					$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender');
						 
						 
					if($gender == 'Male'){
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
					}else{
						$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
					}
				}
				
				$diamond_gemstone_weight =  $_product->getDiamond_gemstone_weight();
				 
				$product_type =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(),'candere_product_type'); 
				
				$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($base_weight,$total_weight,$purity_id,$product_type);
		
				$base_weight  = number_format($get_weights['metal_weight'],2);
				
				$metal_weight  = $get_weights['metal_weight'];
				
				$total_weight = number_format($get_weights['total_weight'],2); 
				$gold_price   = $get_weights['gold_price']; 
				
				
				foreach ( $attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect ) { 
					if($attribute_collect['label'] !=''){  
						 
						$label = $attribute_collect['label']; 
						
						$explode_label = explode("&nbsp;", $label);
						
						$selected_size_ring = trim(current($explode_label)); 
						$selected_size_ring_mm = trim(end($explode_label)); 
						
						$selected_size = trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label)))));
						 
						$total_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight + $diamond_gemstone_weight,2);
						
						//14k -- 49   ==== 18k -- 50 purity 
						
						if(trim($value['purity']) == '14K')
							$purity_id = 49;
						else if(trim($value['purity']) == '18K')
							$purity_id = 50;
						else if(trim($value['purity']) == '22K')
							$purity_id = 589;
						else if(trim($value['purity']) == '9K')
							$purity_id = 51;
						else if(trim($value['purity']) == 'platinum')
							$purity_id = 538;
						$total_metal_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight,2);
						
						$metal_weight = number_format(((($base_weight / $multiply_factor) * $selected_size) - $base_weight) + $base_weight,2);
						
						//$price = ceil(((($metal_weight - $base_weight) * $gold_price) + $base_price));

						if($_product->getStatus() == 1){
							$status = 'Enabled';
						}else{
							$status = 'Disabled';
						}						
						/*echo "pro id--".$product_id."--metal id--".$value['metal_id']."--label--".$label."--thick--".$thickness."--dia sel--".$diamond_selection."--purity id--".$purity_id."--clarit--".$clarity."--color--".$color;
						exit;*/
						$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$value['metal_id'],$purity_id,$label,$thickness,$diamond_selection,$purity_id,$clarity,$color);
				
						//echo "<pre>";
						//print_r($product_price_details);
						$price         = $product_price_details['old_price'];
						$new_price     = $product_price_details['new_price'];
						
						$array[] = array($_product->getName(),$sku,$value['metal'],$value['purity'],$metal_weight,$total_weight,$selected_size_ring,$selected_size_ring_mm,$price,$new_price,$status);
					}
				}
				unset($status);
				unset($price);
				unset($new_price);
				unset($base_weight);
				unset($selected_size_ring);
				unset($metal_weight);
				unset($total_weight); 	
				unset($value); 
				unset($_product);
			}
		} 
 
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		 
		array_to_csv($array,'export_'.$product_label.'_items_'.date('d-M-y').'.csv'); 
		
		unset($array);		
	} 
	   
	
	public function sql_query($product_label){	
	
		$this->db->cache_delete_all();
		
		
		if($product_label == 'ring'){
			$product_type = array(583);
		}else if($product_label == 'band'){
			$product_type = array(587);
		}else if($product_label == 'bangle'){
			$product_type = array(586);
		}else if($product_label == 'kada'){
			$product_type = array(648);
		}else  if($product_label == 'bracelet'){
			$product_type = array(591);
		}else{
			$product_type = array(10000000);
		}	
		 
		$sql =	"SELECT pricing_table_metal_options.sku,
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.purity as purity_id,
       pricing_table_metal_options.metal_id,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name,
       pricing_table_metal_options.price,
	   
       catalog_product_entity_varchar_1.value AS default_metal_weight,
       catalog_product_entity_varchar_2.value AS default_total_weight
  FROM    (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                           INNER JOIN
                              eav_attribute_option_value eav_attribute_option_value
                           ON (pricing_table_metal_options.metal_id =
                                  eav_attribute_option_value.option_id))
                       INNER JOIN
                          eav_attribute_option_value eav_attribute_option_value_1
                       ON (pricing_table_metal_options.purity =
                              eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_varchar.entity_id))
               INNER JOIN
                 catalog_product_entity_int catalog_product_entity_int
               ON (pricing_table_metal_options.product_id =
                      catalog_product_entity_int.entity_id))
           INNER JOIN
             catalog_product_entity_varchar catalog_product_entity_varchar_1
           ON (pricing_table_metal_options.product_id =
                  catalog_product_entity_varchar_1.entity_id))
       INNER JOIN
         catalog_product_entity_varchar catalog_product_entity_varchar_2
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_varchar_2.entity_id)
 WHERE     (pricing_table_metal_options.status = 1)
       AND (catalog_product_entity_varchar.attribute_id = 71)
       AND (catalog_product_entity_int.attribute_id = 272)
       AND (catalog_product_entity_int.value IN (".implode(',',$product_type)."))
       AND (catalog_product_entity_varchar_1.attribute_id = 282)
       AND (catalog_product_entity_varchar_2.attribute_id = 229) limit 1,10"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		
		return $result ;
	}
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
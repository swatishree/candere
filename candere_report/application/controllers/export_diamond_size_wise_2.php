<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_diamond_size_wise_2 extends CI_Controller  {
	
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
        $this->load->view('export_diamond_size_wise_2/index',$message_arr);
		$this->load->view('templates/footer');
	}
		
	public function export_chains_bracelets(){
	
		set_time_limit(0);
		$product_label = $this->input->get('product_label');
		$limit_range = $this->input->get('limit');
		$diamond_filter 	= $this->input->get('diamond_selection');
		
		$this->db->cache_delete_all();
		$message_arr = array('');
		$this->load->helper('csv');
	
		$sql = $this->myqueryfunction($product_label,$limit_range='');
		
		if($product_label =='chains'){
			$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'chain_length'); 
		} else if($product_label =='bracelets'){
			$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bracelets_length'); 
		}
		
		if($sql){
			foreach($sql as $value){
				$gold_product			= $value['gold_product'];
									
				if($gold_product == 0) {
				
					$product_id 			= $value['product_id']; 
					$metal_id	 			= $value['metal_id']; 
					$product_type			= $value['product_type'];
					$purity_id				= $value['purity_id']; 
					$name					= $value['name']; 
					
					$offer_percent 			= 1;
					$old_price 				= 0;
					$base_new_price 		= 0;
					$new_price 				= 0;
						
					$_product 	= Mage::getModel('catalog/product')->load($product_id);
													
					$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender'); 
					
					$old_price 	= round($this->getBaseProductPrice($product_id, 'price'));
													
					$base_new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
					$new_price 		= $base_new_price;
									
					if($base_new_price == null){
						$base_new_price = $old_price;
						$new_price 		= $old_price;
					}
					
					$offer_percent 	= ($new_price / $old_price);
												
					$default_metal_karat = Mage::helper('function')->get_default_metal_karat($product_id, $product_type);
					
					$base_purity_id 			= $default_metal_karat['purity'];
					
					$customized_design_pricing 		= array('');
					$customized_bracelet_pricing 	= array('');
					
					$hide_ring_sizes = 0;
					$_categories = $_product->getCategoryCollection();
					foreach ($_categories as $_category){
						if($_category->getId()==96){
							$hide_ring_sizes = 1;
						}
					}
									
					foreach($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect) { 
						if($attribute_collect['label'] !=''){
												
							if($product_label=='chains') {
									
								$label 					= $attribute_collect['label'];
								$explode_label 			= explode("&nbsp;", $label);
								$selected_size_label 	= trim(end($explode_label)); 
															
								$selected_size = trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label)))));
								
								if($hide_ring_sizes == 1 && $selected_size > 18){
									continue;
								} 
								
								$collection = Mage::getModel('chainmmvariations/chainmmvariations')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('product_type', $_product->getCandere_product_type())->addFieldToFilter('status', 1)->addFieldToSelect('width_mm')->addFieldToSelect('weight_gms')->addFieldToSelect('chain_default');
							
								if($collection){
								foreach($collection as $collect_value){
									
									$chain_thickness = $collect_value->getWidth_mm();
															
									$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness,$diamond_selection=0,$offer_percent,$base_purity_id);
																			
									$metal_weight 	= $customized_design_pricing['metal_weight'];
									$total_weight 	= $customized_design_pricing['total_weight'];
									$old_price 		= $customized_design_pricing['old_price'];
									$new_price 		= $customized_design_pricing['new_price'];
									$metal 			= $customized_design_pricing['metal'];
									$purity 		= $customized_design_pricing['purity'];
									$sku 			= $customized_design_pricing['sku'];
									
									if(($metal_weight != 0 || $metal_weight != '') && ($old_price != 0)) {
										$array[] = array('sku'=>$sku, 'metal'=>$metal, 'purity'=>$purity, 'name'=>$name, 'width'=>$chain_thickness, 'selected_size_label'=>$selected_size_label, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>$old_price, 'price_after_discount'=>$new_price); 
									}
																
									unset($chain_thickness);
									unset($metal_weight);
									unset($total_weight);
									unset($old_price);
									unset($new_price);
								}
								unset($collection);
							}
						} else if($product_label=='bracelets') {
						
							$siij_price				= $value['siij_price'];
							$sigh_price				= $value['sigh_price'];
							$vsgh_price				= $value['vsgh_price'];	
							$vvsef_price			= $value['vvsef_price'];
							
							$label 					= $attribute_collect['label'] ;
							$explode_label 			= explode("&nbsp;", $label);
							$selected_size_label 	= trim(end($explode_label)) ; 
							$selected_size 			= trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label))))) ;
							
							if($diamond_filter != 'ALL') {
								
								if($sigh_price != 0 || $siij_price != 0 || $vsgh_price != 0 || $vvsef_price != 0) {
								
									$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection=$diamond_filter,$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing['metal_weight'];
									$total_weight 	= $customized_design_pricing['total_weight'];
									$metal 			= $customized_design_pricing['metal'];
									$purity 		= $customized_design_pricing['purity'];
									$sku 			= $customized_design_pricing['sku'];
									
									$old_price = !empty($customized_design_pricing['old_price']) ? $customized_design_pricing['old_price'] : 0;
									$new_price = !empty($customized_design_pricing['new_price']) ? $customized_design_pricing['new_price'] : 0;
								}
															
								if($old_price != 0 && ($metal_weight != 0 || $metal_weight != ''))	{ 
									$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name, 'Selected size label'=>$selected_size_label, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type, 'MRP'=>$old_price,'SELLING PRICE'=>$new_price,'Diamond_name'=>$diamond_filter); 
								}
								
								unset($metal_weight,$total_weight);
								unset($old_price,$new_price);
								unset($customized_design_pricing);
							
							} else {
								
								if($siij_price != 0) {
									$customized_design_pricing_siij = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='siij',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_siij['metal_weight'];
									$total_weight 	= $customized_design_pricing_siij['total_weight'];
									$metal 			= $customized_design_pricing_siij['metal'];
									$purity 		= $customized_design_pricing_siij['purity'];
									$sku 			= $customized_design_pricing_siij['sku'];
									
									$siij_old_price = !empty($customized_design_pricing_siij['old_price']) ? $customized_design_pricing_siij['old_price'] : 0;
									$siij_new_price = !empty($customized_design_pricing_siij['new_price']) ? $customized_design_pricing_siij['new_price'] : 0;
								}
								
								if($sigh_price != 0) {
									$customized_design_pricing_sigh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='sigh',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_sigh['metal_weight'];
									$total_weight 	= $customized_design_pricing_sigh['total_weight'];
									$metal 			= $customized_design_pricing_sigh['metal'];
									$purity 		= $customized_design_pricing_sigh['purity'];
									$sku 			= $customized_design_pricing_sigh['sku'];
									
									$sigh_old_price = !empty($customized_design_pricing_sigh['old_price']) ? $customized_design_pricing_sigh['old_price'] : 0;
									$sigh_new_price = !empty($customized_design_pricing_sigh['new_price']) ? $customized_design_pricing_sigh['new_price'] : 0;
								}
							
								if($vsgh_price != 0) {
									$customized_design_pricing_vsgh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='vsgh',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_vsgh['metal_weight'];
									$total_weight 	= $customized_design_pricing_vsgh['total_weight'];
									$metal 			= $customized_design_pricing_vsgh['metal'];
									$purity 		= $customized_design_pricing_vsgh['purity'];
									$sku 			= $customized_design_pricing_vsgh['sku'];
									
									$vsgh_old_price = !empty($customized_design_pricing_vsgh['old_price']) ? $customized_design_pricing_vsgh['old_price'] : 0;
									$vsgh_new_price = !empty($customized_design_pricing_vsgh['new_price']) ? $customized_design_pricing_vsgh['new_price'] : 0;
								}	
								
								if($vvsef_price != 0) {			
									$customized_design_pricing_vvsef = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='vvsef',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_vvsef['metal_weight'];
									$total_weight 	= $customized_design_pricing_vvsef['total_weight'];
									$metal 			= $customized_design_pricing_vvsef['metal'];
									$purity 		= $customized_design_pricing_vvsef['purity'];
									$sku 			= $customized_design_pricing_vvsef['sku'];
									
									$vvsef_old_price = !empty($customized_design_pricing_vvsef['old_price']) ? $customized_design_pricing_vvsef['old_price'] : 0;
									$vvsef_new_price = !empty($customized_design_pricing_vvsef['new_price']) ? $customized_design_pricing_vvsef['new_price'] : 0;
								}
								
								if($metal_weight != 0 || $metal_weight !='') {
									$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name, 'Selected size label'=>$selected_size_label, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type, 'SIIJ MRP'=>$siij_old_price,'SIIJ SELLING PRICE'=>$siij_new_price,'SIGH MRP'=>$sigh_old_price,'SIGH SELLING PRICE'=>$sigh_new_price,'VSGH MRP'=>$vsgh_old_price,'VSGH SELLING PRICE'=>$vsgh_new_price,'VVSEF MRP'=>$vvsef_old_price,'VVSEF SELLING PRICE'=>$vvsef_new_price);	
								}
									
								
								unset($customized_design_pricing_sigh, $customized_design_pricing_siij, $customized_design_pricing_vsgh, $customized_design_pricing_vvsef);
								unset($metal_weight,$total_weight);
							}
						}						
					}
						
					}	/// End foreach for attribute_collection	
					
					unset($_product);	
					unset($value);		
				}
			}
			unset($sql);
			
			array_to_csv($array,'export_'.$product_label.'_'.$diamond_filter.'_'.date('d-M-y')); 
			unset($array);	 
		} else {
			echo 'NO Records Found';
			redirect('export_diamond_size_wise_2/index', 'refresh');
		}
	}
	
	public function export_products_without_dropdown(){
	
		set_time_limit(0);
		$this->db->cache_delete_all();
		$message_arr = array('');
		$this->load->helper('csv');
		$this->load->dbutil();
		
		$product_label 		= $this->input->get('product_label');
		$limit_range 		= $this->input->get('limit');
		$diamond_filter 	= $this->input->get('diamond_selection');
				
		$sql = $this->myqueryfunction($product_label,$limit_range='');
				 
		if($sql){
				
			foreach($sql as $value){
				
				$gold_product			= $value['gold_product'];
				
				if($gold_product == 0) {
					
					$product_id 			= $value['product_id'];
					$metal_id	 			= $value['metal_id'];
					$product_type			= $value['product_type'];
					$purity_id				= $value['purity_id'];
					$name					= $value['name'];
					
					$siij_price				= $value['siij_price'];
					$sigh_price				= $value['sigh_price'];
					$vsgh_price				= $value['vsgh_price'];	
					$vvsef_price			= $value['vvsef_price'];
				
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
						
						$offer_percent 	= ($new_price / $old_price);
													
						$default_metal_karat = Mage::helper('function')->get_default_metal_karat($product_id, $product_type);
						
						$base_purity_id 			= $default_metal_karat['purity'];
						$diamond_gemstone_weight 	= $_product->getDiamond_gemstone_weight();
					
					
											
						if($diamond_filter != 'ALL') {
						
							//echo $product_id .' - '. $metal_id .' - '. $purity_id .' - '.  $selected_size=0 .' - '.  $chain_thickness=0 .' - '. $diamond_selection=$diamond_filter .' - '.  $offer_percent .' - '.  $base_purity_id; exit;
												
							$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection=$diamond_filter,$offer_percent,$base_purity_id);
							
							//echo '<pre>'; print_r($customized_design_pricing); echo '</pre>'; exit;
							
							
							$metal_weight 	= $customized_design_pricing['metal_weight'];
							$total_weight 	= $customized_design_pricing['total_weight'];
							$metal 			= $customized_design_pricing['metal'];
							$purity 		= $customized_design_pricing['purity'];
							$sku 			= $customized_design_pricing['sku'];
							
							$old_price= !empty($customized_design_pricing['old_price']) ? $customized_design_pricing['old_price'] : 0;
							$new_price= !empty($customized_design_pricing['new_price']) ? $customized_design_pricing['new_price'] : 0;
							
							if($old_price != 0 && $metal_weight !=0)	{
								$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type, 'MRP'=>$old_price,'SELLING PRICE'=>$new_price, 'Diamond_name'=>$diamond_filter);
							}
							
							unset($customized_design_pricing);
							unset($metal_weight,$total_weight);
							unset($old_price,$new_price);
							unset($_product);
																				
						} else {
												
							if($siij_price != 0) {
							
								$customized_design_pricing_siij = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='siij',$offer_percent,$base_purity_id);
								
								$metal_weight 	= $customized_design_pricing_siij['metal_weight'];
								$total_weight 	= $customized_design_pricing_siij['total_weight'];
								$metal 			= $customized_design_pricing_siij['metal'];
								$purity 		= $customized_design_pricing_siij['purity'];
								$sku 			= $customized_design_pricing_siij['sku'];
								
								$siij_old_price = !empty($customized_design_pricing_siij['old_price']) ? $customized_design_pricing_siij['old_price'] : 0;
								$siij_new_price = !empty($customized_design_pricing_siij['new_price']) ? $customized_design_pricing_siij['new_price'] : 0;
							} 
							
							if($sigh_price != 0) {
								$customized_design_pricing_sigh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='sigh',$offer_percent,$base_purity_id);
								
								$metal_weight 	= $customized_design_pricing_sigh['metal_weight'];
								$total_weight 	= $customized_design_pricing_sigh['total_weight'];
								$metal 			= $customized_design_pricing_sigh['metal'];
								$purity 		= $customized_design_pricing_sigh['purity'];
								$sku 			= $customized_design_pricing_sigh['sku'];
								
								$sigh_old_price = !empty($customized_design_pricing_sigh['old_price']) ? $customized_design_pricing_sigh['old_price'] : 0;
								$sigh_new_price = !empty($customized_design_pricing_sigh['new_price']) ? $customized_design_pricing_sigh['new_price'] : 0;
							} 
							
							if($vsgh_price != 0) {
								$customized_design_pricing_vsgh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='vsgh',$offer_percent,$base_purity_id);
								
								$metal_weight 	= $customized_design_pricing_vsgh['metal_weight'];
								$total_weight 	= $customized_design_pricing_vsgh['total_weight'];
								$metal 			= $customized_design_pricing_vsgh['metal'];
								$purity 		= $customized_design_pricing_vsgh['purity'];
								$sku 			= $customized_design_pricing_vsgh['sku'];
								
								$vsgh_old_price = !empty($customized_design_pricing_vsgh['old_price']) ? $customized_design_pricing_vsgh['old_price'] : 0;
								$vsgh_new_price = !empty($customized_design_pricing_vsgh['new_price']) ? $customized_design_pricing_vsgh['new_price'] : 0;
							} 
							
							if($vvsef_price != 0) {			
								$customized_design_pricing_vvsef = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='vvsef',$offer_percent,$base_purity_id);
								
								$metal_weight 	= $customized_design_pricing_vvsef['metal_weight'];
								$total_weight 	= $customized_design_pricing_vvsef['total_weight'];
								$metal 			= $customized_design_pricing_vvsef['metal'];
								$purity 		= $customized_design_pricing_vvsef['purity'];
								$sku 			= $customized_design_pricing_vvsef['sku'];
								
								$vvsef_old_price = !empty($customized_design_pricing_vvsef['old_price']) ? $customized_design_pricing_vvsef['old_price'] : 0;
								$vvsef_new_price = !empty($customized_design_pricing_vvsef['new_price']) ? $customized_design_pricing_vvsef['new_price'] : 0;
							} 
							
							if($siij_price == 0 && $sigh_price == 0 && $vsgh_price == 0 && $vvsef_price == 0) {
														
								$customized_design_pricing_none = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='',$offer_percent,$base_purity_id);
								
								$metal_weight 	= $customized_design_pricing_none['metal_weight'];
								$total_weight 	= $customized_design_pricing_none['total_weight'];
								$metal 			= $customized_design_pricing_none['metal'];
								$purity 		= $customized_design_pricing_none['purity'];
								$sku 			= $customized_design_pricing_none['sku'];
								
								$gem_old_price = !empty($customized_design_pricing_none['old_price']) ? $customized_design_pricing_none['old_price'] : 0;
								$gem_new_price = !empty($customized_design_pricing_none['new_price']) ? $customized_design_pricing_none['new_price'] : 0;
							}
								
							if($metal_weight != 0 || $metal_weight !='')	{
								$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type, 'SIIJ MRP'=>$siij_old_price,'SIIJ SELLING PRICE'=>$siij_new_price,'SIGH MRP'=>$sigh_old_price,'SIGH SELLING PRICE'=>$sigh_new_price,'VSGH MRP'=>$vsgh_old_price,'VSGH SELLING PRICE'=>$vsgh_new_price,'VVSEF MRP'=>$vvsef_old_price,'VVSEF SELLING PRICE'=>$vvsef_new_price, 'Gem Old Price'=>$gem_old_price, 'Gem New Price'=>$gem_new_price);
							}
							
							unset($customized_design_pricing_sigh, $customized_design_pricing_siij, $customized_design_pricing_vsgh, $customized_design_pricing_vvsef, $customized_design_pricing_none);
							unset($metal_weight,$total_weight);
							unset($_product);
							unset($product_id);
							unset($siij_old_price,$siij_new_price,$sigh_old_price,$sigh_new_price,$vsgh_old_price,$vsgh_new_price,$vvsef_old_price,$vvsef_new_price,$gem_old_price,$gem_new_price);												
						}
						
									
				}	
			}
			
			header('Content-Type: text/html; charset=utf-8');
			header('Content-Transfer-Encoding: binary');
			 
			array_to_csv($array,'export_'.$product_label.'_'.$diamond_filter.'_'.date('d-M-y')); 
			unset($array);
			unset($sql);	
			
		} else {
			echo 'NO Records Found';
			redirect('export_diamond_size_wise_2/index', 'refresh');
		}
	}
	
	public function export()
	{  
		$this->db->cache_delete_all();
		$message_arr = array('');
		$this->load->helper('csv');
	 
		$product_label 		= $this->input->get('product_label');
		$limit_range 		= $this->input->get('limit');
		$limit_range_lbl 	= $this->input->get('limit_range');
		$diamond_filter 	= $this->input->get('diamond_selection');
		$sql 				= $this->myqueryfunction($product_label,$limit_range);
		
			 
		if($sql){
			
			foreach($sql as $key=>$value){
				
				$gold_product			= $value['gold_product'];
				
				if($gold_product == 0) {
					
					$product_id 			= $value['product_id']; 
					$metal_id	 			= $value['metal_id']; 
					$product_type			= $value['product_type'];
					$purity_id				= $value['purity_id']; 
					$name					= $value['name']; 
					
					$siij_price				= $value['siij_price'];
					$sigh_price				= $value['sigh_price']; 
					$vsgh_price				= $value['vsgh_price'];				
					$vvsef_price			= $value['vvsef_price'];
				
					$offer_percent 			= 1;
					$old_price 				= 0;
					$base_new_price 		= 0;
					$new_price 				= 0;
					
					$_product = Mage::getModel('catalog/product')->load($value['product_id']);
					
					$old_price 	= round($this->getBaseProductPrice($product_id, 'price'));
													
					$base_new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($_product,$old_price);
					$new_price 		= $base_new_price;
									
					if($base_new_price == null){
						$base_new_price = $old_price;
						$new_price 		= $old_price;
					}
					
					$offer_percent 	= ($new_price / $old_price);
												
					$default_metal_karat = Mage::helper('function')->get_default_metal_karat($product_id, $product_type);
					
					$base_purity_id 			= $default_metal_karat['purity'];
					$diamond_gemstone_weight 	= $_product->getDiamond_gemstone_weight();

					if($product_label == 'rings'){
						$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					}else if($product_label == 'bands'){
						$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					}else if($product_label == 'bangles'){
						$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bangle_ring_size'); 
					}else if($product_label == 'kada'){
						$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'kada_ring_size'); 
					}else{
						$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer');
					}
					
					$customized_design_pricing 	= array('');
										
					foreach($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect) { 
						if($attribute_collect['label'] !=''){  
							$label 					= $attribute_collect['label'] ;
							$explode_label 			= explode("&nbsp;", $label);
							$selected_size_label 	= trim(end($explode_label)) ; 
							$selected_size 			= trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label)))));
							
							$selected_length  = $explode_label[0];
							$size_in_inches = number_format(0.0393701* $selected_size,2);
							
							if($diamond_filter != 'ALL') {
							
								if($siij_price != 0 || $sigh_price != 0 || $vsgh_price != 0 || $vvsef_price != 0) {
								
								
									if($product_id == '3149') {
										$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection=$diamond_filter,$offer_percent,$base_purity_id);
										
										echo '<pre>'; print_r($customized_design_pricing) ; echo '</pre>'; exit;
									}
									
									$customized_design_pricing = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection=$diamond_filter,$offer_percent,$base_purity_id);
								
								
									$metal_weight 	= $customized_design_pricing['metal_weight'];
									$total_weight 	= $customized_design_pricing['total_weight'];
									$metal 			= $customized_design_pricing['metal'];
									$purity 		= $customized_design_pricing['purity'];
									$sku 			= $customized_design_pricing['sku'];
															
									$old_price = !empty($customized_design_pricing['old_price']) ? $customized_design_pricing['old_price'] : 0;
									$new_price = !empty($customized_design_pricing['new_price']) ? $customized_design_pricing['new_price'] : 0;
																						
									if($old_price != 0 && $metal_weight != 0) {
										$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name,'Selected Length'=>$selected_length, 'selected size label'=>$selected_size_label, 'Size in inches'=>$size_in_inches, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type,'MRP'=>$old_price,'SELLING PRICE'=>$new_price, 'Diamond_name'=>$diamond_filter);
									}
									
									unset($metal_weight,$total_weight);
									unset($old_price,$new_price);
									unset($selected_length);
									unset($customized_design_pricing);
								}
																
							}else {
															
								if($siij_price != 0) {
									$customized_design_pricing_siij = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='siij',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_siij['metal_weight'];
									$total_weight 	= $customized_design_pricing_siij['total_weight'];
									$metal 			= $customized_design_pricing_siij['metal'];
									$purity 		= $customized_design_pricing_siij['purity'];
									$sku 			= $customized_design_pricing_siij['sku'];
									
									$siij_old_price = !empty($customized_design_pricing_siij['old_price']) ? $customized_design_pricing_siij['old_price'] : 0;
									$siij_new_price = !empty($customized_design_pricing_siij['new_price']) ? $customized_design_pricing_siij['new_price'] : 0;
								}
								
								if($sigh_price != 0) {
									$customized_design_pricing_sigh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='sigh',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_sigh['metal_weight'];
									$total_weight 	= $customized_design_pricing_sigh['total_weight'];
									$metal 			= $customized_design_pricing_sigh['metal'];
									$purity 		= $customized_design_pricing_sigh['purity'];
									$sku 			= $customized_design_pricing_sigh['sku'];
									
									$sigh_old_price = !empty($customized_design_pricing_sigh['old_price']) ? $customized_design_pricing_sigh['old_price'] : 0;
									$sigh_new_price = !empty($customized_design_pricing_sigh['new_price']) ? $customized_design_pricing_sigh['new_price'] : 0;
								}
							
								if($vsgh_price != 0) {
									$customized_design_pricing_vsgh = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='vsgh',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_vsgh['metal_weight'];
									$total_weight 	= $customized_design_pricing_vsgh['total_weight'];
									$metal 			= $customized_design_pricing_vsgh['metal'];
									$purity 		= $customized_design_pricing_vsgh['purity'];
									$sku 			= $customized_design_pricing_vsgh['sku'];
									
									$vsgh_old_price = !empty($customized_design_pricing_vsgh['old_price']) ? $customized_design_pricing_vsgh['old_price'] : 0;
									$vsgh_new_price = !empty($customized_design_pricing_vsgh['new_price']) ? $customized_design_pricing_vsgh['new_price'] : 0;
								}	
								
								if($vvsef_price != 0) {			
									$customized_design_pricing_vvsef = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size,$chain_thickness=0,$diamond_selection='vvsef',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_vvsef['metal_weight'];
									$total_weight 	= $customized_design_pricing_vvsef['total_weight'];
									$metal 			= $customized_design_pricing_vvsef['metal'];
									$purity 		= $customized_design_pricing_vvsef['purity'];
									$sku 			= $customized_design_pricing_vvsef['sku'];
									
									$vvsef_old_price = !empty($customized_design_pricing_vvsef['old_price']) ? $customized_design_pricing_vvsef['old_price'] : 0;
									$vvsef_new_price = !empty($customized_design_pricing_vvsef['new_price']) ? $customized_design_pricing_vvsef['new_price'] : 0;
								}
								
								if($siij_price == 0 && $sigh_price == 0 && $vsgh_price == 0 && $vvsef_price == 0) {
													
									$customized_design_pricing_none = $this->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$selected_size=0,$chain_thickness=0,$diamond_selection='',$offer_percent,$base_purity_id);
									
									$metal_weight 	= $customized_design_pricing_none['metal_weight'];
									$total_weight 	= $customized_design_pricing_none['total_weight'];
									$metal 			= $customized_design_pricing_none['metal'];
									$purity 		= $customized_design_pricing_none['purity'];
									$sku 			= $customized_design_pricing_none['sku'];
									
									$gem_old_price = !empty($customized_design_pricing_none['old_price']) ? $customized_design_pricing_none['old_price'] : 0;
									$gem_new_price = !empty($customized_design_pricing_none['new_price']) ? $customized_design_pricing_none['new_price'] : 0;
								}
								
								if($metal_weight != 0 || $metal_weight != '')	 {
									$array[] = array('SKU'=>$sku, 'Metal'=>$metal, 'Purity'=>$purity, 'Name'=>$name, 'selected size label'=>$selected_size_label, 'Size in inches'=>$size_in_inches, 'Metal Weight in Gms'=>$metal_weight, 'Total Weight in Gms'=>$total_weight, 'Product Type'=>$product_type, 'SIIJ MRP'=>$siij_old_price,'SIIJ SELLING PRICE'=>$siij_new_price,'SIGH MRP'=>$sigh_old_price,'SIGH SELLING PRICE'=>$sigh_new_price,'VSGH MRP'=>$vsgh_old_price,'VSGH SELLING PRICE'=>$vsgh_new_price,'VVSEF MRP'=>$vvsef_old_price,'VVSEF SELLING PRICE'=>$vvsef_new_price,'Gem Old Price'=> $gem_old_price,'Gem New Price' => $gem_new_price);
								}
								
									
								unset($customized_design_pricing_sigh, $customized_design_pricing_siij, $customized_design_pricing_vsgh, $customized_design_pricing_vvsef,$customized_design_pricing_none);
								unset($metal_weight,$total_weight);
								unset($siij_old_price,$siij_new_price,$sigh_old_price,$sigh_new_price,$vsgh_old_price,$vsgh_new_price,$vvsef_old_price,$vvsef_new_price,$gem_old_price,$gem_new_price);
							}
						}
					}	
					
					//unset($attribute_collect);
					unset($attribute_collection);
					unset($_product);
					//unset($value);
				}
			}
			unset($sql);
			
			$this->load->dbutil();
			header('Content-Type: text/html; charset=utf-8');
			header('Content-Transfer-Encoding: binary');
			
			array_to_csv($array,'export_'.$product_label.'_'.$diamond_filter.'_'.date('d-M-y').'_'.$limit_range_lbl); 
			unset($array);
		
		} else {
			echo 'No Records Found';
			redirect('export_diamond_size_wise_2/index', 'refresh');
		}	
	} 
	   
	public function myqueryfunction($product_label,$limit_range){	
	
		$this->db->cache_delete_all();
		///AND	(pricing_table_metal_options.sku = 'GR00161')
		
		//$limit_range = 'limit 0,10';
			
		if($product_label =='rings'){
			$product_type = array(583);
		}else if($product_label =='bands'){
			$product_type = array(587);
		}else if($product_label =='bangles'){
			$product_type = array(586);
		}else if($product_label =='kada'){
			$product_type = array(648);
		}else if($product_label =='chains'){
			$product_type = array(590);
		}else if($product_label =='bracelets'){
			$product_type = array(591);
		} else if($product_label =='nose_pins'){
			$product_type = array(624);
		} else if($product_label =='earrings'){
			$product_type = array(584);
		} else if($product_label =='pendants'){
			$product_type = array(585);
		} else if($product_label =='coins'){
			$product_type = array(644);
		} else if($product_label =='necklaces'){
			$product_type = array(682);
		} else {
			$product_type = array(10000000);
		}
						
		$sql =	"SELECT pricing_table_metal_options.sku,
		   pricing_table_metal_options.product_id,
		   pricing_table_metal_options.purity AS purity_id,
		   pricing_table_metal_options.metal_id,
		   eav_attribute_option_value.value AS metal,
		   eav_attribute_option_value_1.value AS purity,
		   catalog_product_entity_varchar.value AS name,
		   pricing_table_metal_options.price,
		   pricing_table_metal_options.siij_price,
		   pricing_table_metal_options.sigh_price,
		   pricing_table_metal_options.vsgh_price,
		   pricing_table_metal_options.vvsef_price,
		   catalog_product_entity_varchar_1.value AS default_metal_weight,
		   catalog_product_entity_varchar_2.value AS default_total_weight,
		   eav_attribute_option_value_2.value AS product_type,
		   catalog_product_entity_int_2.value AS gold_product,
		   if(catalog_product_entity_int_1.value = 1, 'Enabled', 'Disabled')
			  AS product_status
	  FROM    (   (   (   (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
										   INNER JOIN
											  catalog_product_entity_varchar catalog_product_entity_varchar_2
										   ON (pricing_table_metal_options.product_id =
												  catalog_product_entity_varchar_2.entity_id))
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
							  catalog_product_entity_varchar catalog_product_entity_varchar_1
						   ON (pricing_table_metal_options.product_id =
								  catalog_product_entity_varchar_1.entity_id))
					   INNER JOIN
						  catalog_product_entity_int catalog_product_entity_int
					   ON (pricing_table_metal_options.product_id =
							  catalog_product_entity_int.entity_id))
				   INNER JOIN
					  eav_attribute_option_value eav_attribute_option_value_2
				   ON (catalog_product_entity_int.value =
						  eav_attribute_option_value_2.option_id))
			   INNER JOIN
				  catalog_product_entity_int catalog_product_entity_int_1
			   ON (pricing_table_metal_options.product_id =
					  catalog_product_entity_int_1.entity_id))
		   INNER JOIN
			  catalog_product_entity_int catalog_product_entity_int_2
		   ON (pricing_table_metal_options.product_id =
				  catalog_product_entity_int_2.entity_id)
	 WHERE     (catalog_product_entity_int_2.attribute_id = 277)		
		   AND (catalog_product_entity_int_2.value = 0)
		   AND (    (    catalog_product_entity_int_1.attribute_id = 96
					 AND catalog_product_entity_int_1.value = 1)
				AND (    (    (    (    (    pricing_table_metal_options.status =
												1
										 AND catalog_product_entity_varchar.attribute_id =
												71)
									AND catalog_product_entity_int.attribute_id =
										   272)
							   AND catalog_product_entity_int.value IN (".implode(',',$product_type)."))
						  AND catalog_product_entity_varchar_1.attribute_id = 282)
					 AND catalog_product_entity_varchar_2.attribute_id = 229))
	ORDER BY pricing_table_metal_options.sku DESC $limit_range";

		$results = $this->db->query($sql);
		
		//echo $this->db->last_query(); exit;
		$result = $results->result_array();
		return $result ;
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
						
		if(strlen($diamond_selection) > 1){
			$base_price_field = strtolower($diamond_selection).'_price';
		}else{
			$base_price_field = 'price';
		}
					
				
		$base_old_price = $this->getBaseProductPrice($product_id,$base_price_field);
		$base_new_price = round($base_old_price * $offer_percent);
		
		
		$sql = "select sku from pricing_table_metal_options where metal_id = '$metal_id' and purity = '$purity_id' and product_id = '$product_id'";
		$readConnection 	= Mage::getSingleton('core/resource')->getConnection('core_read');
		$sku = $readConnection->fetchOne($sql);
		
		
		/***** Changed by Niteen on 28th Dec 2015 **/
		if($base_old_price != 0.00) {
			
			$product_diamond_gemstone_flag = $this->getProductDiamondandGemstoneCost($product_id,$product_type,$metal_weight,$total_weight,$base_new_price,$base_purity_id);
		
			//echo '<pre>'; print_r($product_diamond_gemstone_flag); echo '</pre>'; exit;
			
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
		
		}
	
		
	
		/**********************************************************************/
		$get_weights = $this->calculate_product_weights_in_cart($_product,$metal_id,$purity_id,$length,$thickness);
		$metal_weight 		= $get_weights['metal_weight'];
		$total_weight 		= $get_weights['total_weight'];  
	
		$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($base_metal_weight,$base_total_weight,$purity_id,$product_type);
	   
		$gold_price		= round($get_weights['gold_price']);  
	  
		if($product_type == 'Coins'){
			 $new_price = $base_new_price;
			 $old_price = $base_new_price;
		}else if($product_type == 'Chains' || $product_type == 'Bracelets'){  
			  
			$gold_cost = round($metal_weight * $gold_price) ;  
			   
			if($gemstone_flag == 1 || $diamond_flag == 1){ 
				$making_cost = round($metal_weight * $making_charges) ;
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
				$diamond_2_stones = $collection_details_stones->getDiamond_2();
				$diamond_3_stones = $collection_details_stones->getDiamond_3();
				$diamond_4_stones = $collection_details_stones->getDiamond_4();
				$diamond_5_stones = $collection_details_stones->getDiamond_5();
				$diamond_6_stones = $collection_details_stones->getDiamond_6();
				$diamond_7_stones = $collection_details_stones->getDiamond_7(); 
				  
				$diamond_gemstone_weight_metal_weight_1 = number_format(($diamond_1_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_2 = number_format(($diamond_2_weight / $default_length) * $length,2).' carat';
				$diamond_gemstone_weight_metal_weight_3 = number_format(($diamond_3_weight / $default_length) * $length,2).' carat';
				$diamond_gemstone_weight_metal_weight_4 = number_format(($diamond_4_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_5 = number_format(($diamond_5_weight / $default_length) * $length,2) .' carat';
				$diamond_gemstone_weight_metal_weight_6 = number_format(($diamond_6_weight / $default_length) * $length,2).' carat';
				$diamond_gemstone_weight_metal_weight_7 = number_format(($diamond_7_weight / $default_length) * $length,2) .' carat';

				$diamond_gemstone_weight_stone_1 = round(($diamond_1_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_2 = round(($diamond_2_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_3 = round(($diamond_3_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_4 = round(($diamond_4_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_5 = round(($diamond_5_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_6 = round(($diamond_6_stones / $default_length) * $length);
				$diamond_gemstone_weight_stone_7 = round(($diamond_7_stones / $default_length) * $length);
			 }		
			/************************************************************/   
		}else{  
			$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getGender(),'gender');
		
			if($gender == 'Male'){
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore()) ;
			}else{
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore()) ;
			}
			 
				$gold_price	  = round($gold_price);
										 
				$gold_cost = round($metal_weight * $gold_price) ;
			
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
		
		
		unset($product_id); 
	 
		return array('metal_weight'=>$metal_weight,'total_weight'=>$total_weight,'old_price'=>$old_price,'new_price'=>$new_price,'gold_cost'=>$gold_cost,'making_cost'=>$making_cost,'vat_cost'=>$vat_cost,'gold_cost'=>$gold_cost,'base_18k_diamond_cost'=>$base_18k_diamond_cost,'gemstone_cost'=>$gemstone_cost,'metal'=>$metal,'purity'=>$purity,'emi'=>$emi,'sku'=>$sku,'diamond_gemstone_weight_metal_weight_1'=>$diamond_gemstone_weight_metal_weight_1,'diamond_gemstone_weight_metal_weight_2'=>$diamond_gemstone_weight_metal_weight_2 ,'diamond_gemstone_weight_metal_weight_3'=>$diamond_gemstone_weight_metal_weight_3,'diamond_gemstone_weight_metal_weight_4'=>$diamond_gemstone_weight_metal_weight_4,'diamond_gemstone_weight_metal_weight_5'=>$diamond_gemstone_weight_metal_weight_5,'diamond_gemstone_weight_metal_weight_6'=>$diamond_gemstone_weight_metal_weight_6,'diamond_gemstone_weight_metal_weight_7'=>$diamond_gemstone_weight_metal_weight_7 ,'diamond_gemstone_weight_stone_1'=>$diamond_gemstone_weight_stone_1, 'diamond_gemstone_weight_stone_2'=>$diamond_gemstone_weight_stone_2,'diamond_gemstone_weight_stone_3'=>$diamond_gemstone_weight_stone_3,'diamond_gemstone_weight_stone_4'=>$diamond_gemstone_weight_stone_4,'diamond_gemstone_weight_stone_5'=>$diamond_gemstone_weight_stone_5,'diamond_gemstone_weight_stone_6'=>$diamond_gemstone_weight_stone_6,'diamond_gemstone_weight_stone_7'=>$diamond_gemstone_weight_stone_7);
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

		$gemstone_cost = 0;
		$diamond_flag = 0;
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
				
				$gemstone_cost  =  $gemstone_price_weight_1 + $gemstone_price_weight_2 + $gemstone_price_weight_3 + $gemstone_price_weight_4 + $gemstone_price_weight_5;
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
	
	
	public function calculate_product_weights_in_cart($product,$metal_id,$purity_id,$size,$chain_thickness)
	{			 
		$chain_length = $size; 
		
		$productId = $product->getId() ;
		$product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(), 'candere_product_type'); 
			  
		$metal_weight			= 0;
		$total_weight			= 0; 
		$diamond_gemstone_weight= 0;
		$ring_sizer_enabled		= 0; 
				 
		if(empty($metal_id) && empty($purity_id)){
			$default_metal_karat = Mage::helper('function')->get_default_metal_karat($productId, $product_type);

			$metal_id 			= $default_metal_karat['metal_id'];
			$purity_id 			= $default_metal_karat['purity'];
			$ring_sizer_enabled = $default_metal_karat['ring_sizer'];  
			
			$metal 	= Mage::helper('function')->get_metal_attribute_name($metal_id);
			$purity = Mage::helper('function')->get_karat_attribute_name($purity_id);
		}

		$get_default_metal = Mage::getModel('custompricing/metaloptionsenabled')->getCollection()->addFieldToFilter('product_id', $productId)->addFieldToFilter('store_id',0)->addFieldToFilter('status',1)->addFieldToFilter('isdefault',1)->addFieldToSelect('ring_sizer')->getFirstItem(); 
			
		$ring_sizer_enabled = $get_default_metal->getRing_sizer();	
		    
		$base_weight        = $product->getDefault_metal_weight(); 
		$total_weight 		= $product->getTotal_weight(); 
	
		$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($base_weight,$total_weight,$purity_id,$product_type);
		 
		$base_weight  = number_format($get_weights['metal_weight'],2);
		$total_weight = number_format($get_weights['total_weight'],2); 
		$gold_price   = $get_weights['gold_price'];  
		
		$diamond_gemstone_weight =  $product->getDiamond_gemstone_weight();
		
		if($product_type == 'Chains' || $product_type == 'Bracelets'){
			if($product_type == 'Bracelets'){
			
				$default_length = trim(str_replace('inches','',Mage::helper('function')->get_attribute_name_and_value_frontend($product->getBracelets_length(),'bracelets_length')));
				 	
				$metal_weight = number_format(($base_weight / $default_length) * $size,2) ;
										 
				$diamond_gemstone_weight_metal_weight = number_format(($diamond_gemstone_weight / $default_length) * $size,2) ;
				
				$total_weight = $metal_weight + $diamond_gemstone_weight_metal_weight ;
				
				$price = ($base_price / $default_length) * $size;
				 
			}else if($product_type == 'Chains'){
				$default_length =  trim(str_replace('(in)','',Mage::helper('function')->get_attribute_name_and_value_frontend($product->getChain_length(),'chain_length')));
											
				$collection = Mage::getModel('chainmmvariations/chainmmvariations')->getCollection()
								->addFieldToFilter('product_id', $productId)
								->addFieldToFilter('product_type', $product->getCandere_product_type())
								->addFieldToFilter('width_mm', $chain_thickness)
								->addFieldToFilter('status', 1)
								->addFieldToSelect('weight_gms');
								
				$weight = $collection->getFirstItem()->getWeight_gms();
												
				$selected_computed_weight = number_format(((float)((($weight) / $default_length) * $size)), 2, '.', '');
												 
				$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($selected_computed_weight,$selected_computed_weight,$purity_id,'');
												
				$selected_computed_weight = $get_weights['metal_weight'];
				
				$metal_weight = $selected_computed_weight;
				$total_weight = $selected_computed_weight + $diamond_gemstone_weight;
				 
			} else{
				$default_length = 22;
				$metal_weight 	= number_format(($base_weight / $default_length) * $size,2);
				$total_weight 	= $metal_weight + $diamond_gemstone_weight;
			}	  
		}else if($ring_sizer_enabled == 1){
			
			if($product_type == 'Bangles') {
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_bangle_size', Mage::app()->getStore());
			}
			else if($product_type == 'Kada') {
				$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_kada_size', Mage::app()->getStore()) ;
			}
			else {
				$gender =  Mage::helper('function')->get_attribute_name_and_value_frontend($product->getGender(),'gender');
				
				if($gender == 'Male'){
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_men', Mage::app()->getStore());
				}else{
					$multiply_factor = Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/default_base_size_women', Mage::app()->getStore());
				}
			}
				
			$total_weight = number_format(((($base_weight / $multiply_factor) * $size) - $base_weight) + $base_weight + $diamond_gemstone_weight,2);
			
			$metal_weight = number_format(((($base_weight / $multiply_factor) * $size) - $base_weight) + $base_weight,2);
			
		}else{  
			$total_weight 	= $total_weight;
			$metal_weight 	= $base_weight;		
		}				  
						
		$final_data = array('metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'purity_id'=>$purity_id );
			
		unset($product);
		return $final_data;
	}
	
	
	public function export_sku_with_design(){ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');

		$sql = "SELECT DISTINCT
       catalog_product_entity_varchar.value as design_number, catalog_product_entity.sku
  FROM    catalog_product_entity catalog_product_entity
       INNER JOIN
          catalog_product_entity_varchar catalog_product_entity_varchar
       ON (catalog_product_entity.entity_id =
              catalog_product_entity_varchar.entity_id)
 WHERE (catalog_product_entity_varchar.attribute_id = 135)";
		 
		$results = $this->db->query($sql);
		$result = $results->result_array();
				
		if($result) {
			$array[0]['design_number'] 		= 'design_number';
			$array[0]['sku'] 				= 'sku';
			
			foreach($result as $value ) {
				
				$design_number 			= $value['design_number']; 
				$sku	 				= $value['sku']; 
															
				$array[] = array('sku'=>$sku, 'design_number'=>$design_number);
				
			}
			unset($result);
		}
		
		array_to_csv($array,'sku_with_design_'.date('d-M-y').'.csv'); 
		unset($array);
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


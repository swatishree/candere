<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_products_all_size extends CI_Controller  {
	
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
        $this->load->view('export_products_all_size/index',$message_arr);
		$this->load->view('templates/footer');
	}
	
	/*public function export_products()
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		
		
		
		// STart of Ratio Reports
		$sel_clicked = "select * from catalog_product_flat_1 where  most_clicked > 0";
		
		// End of Ratio Reports
		//echo "sel--".$sel_products; exit;
		
		$res_clicked = mysql_query($sel_clicked);
		while($row_products = mysql_fetch_assoc($res_clicked))
		{
			//Ratio Reports
			
			$product 				= Mage::getModel('catalog/product')->load($row_products['entity_id']);			
			$product_name 			= $product->getName();
			$product_type 			= Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(),'candere_product_type');
			$metal_weight 			= $row_products['metal_weight'];
			$diamond_weight_value	= $row_products['diamond_weight_value'];
			$most_clicked 			= $row_products['most_clicked'];
			$sku				= $row_products['sku'];
			
			if($sku != '')
			{
				$array[] = array('sku'=>$sku, 'product_type'=>$product_type, 'most_clicked'=>$most_clicked);
			}
			
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_'.$category.'_items_'.date('d-M-y').'_'.$all_products);
		unset($array);
	}*/
	
	
	public function export_products_ratios()
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$all_products	= $_REQUEST['all_products'];
		$type	= $_REQUEST['type'];
		$purity	= $_REQUEST['purity'];
		
		$range_from	= $_REQUEST['range_from'];
		$range_to	= $_REQUEST['range_to'];
		$diamond_quality	= $_REQUEST['diamond_quality'];
		
		$whr_data_string = '';
		
		if($range_from != '' && $range_to != '')
		{
			$whr_data_string = 'and date_range between "'.$range_from.'" and "'.$range_to.'"';
			
		}
		$whr_data_string =  'and diamond_name="SIIJ"';
		$all_products_explode = explode('_', $all_products);
		$limit_range = 'limit '.$all_products_explode[0].','.$all_products_explode[1].'';
		
		if(($category == 'Nose Pins' || $category == 'Pendants' || $category == 'Necklaces' || $category == 'Earrings') && $sku != '')
		{
			$array[] = array('SKU', 'White SKU', 'Metal', 'White Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name');
		}
		else if($sku != '')
		{
			$array[] = array('SKU', 'Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name', 'Selected Length', 'Selected Size Label');
		}
		if($purity == '14K')
		{
			$market_place_table = 'product_price_market_place';
		}
		if($purity == '14K' && $category == 'Nose Pins')
		{
			$market_place_table = 'product_price_market_place_pendant';
		}
		if($purity == '18K')
		{
			$market_place_table = 'product_price_market_place_pendant';
		}
		if($purity == '22K')
		{
			$market_place_table = 'product_price_rings_bands';
		}
		
		// STart of Ratio Reports
		$sel_reports = "select * from catalog_product_flat_1 where  ratio > 0";
		
		// End of Ratio Reports
		//echo "sel--".$sel_products; exit;
		
		$res_products = mysql_query($sel_reports);
		while($row_products = mysql_fetch_assoc($res_products))
		{
			//Ratio Reports
			
			$product 				= Mage::getModel('catalog/product')->load($row_products['entity_id']);			
			$product_name 			= $product->getName();
			$product_type 			= Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(),'candere_product_type');
			$metal_weight 			= $row_products['metal_weight'];
			$diamond_weight_value	= $row_products['diamond_weight_value'];
			$ratio 			= $row_products['ratio'];
			$sku				= $row_products['sku'];
			
			if($sku != '')
			{
				$array[] = array('sku'=>$sku, 'product_type'=>$product_type, 'metal_weight'=>$metal_weight, 'diamond_weight_value'=>$diamond_weight_value, 'ratio'=>$ratio);
			}
			
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_'.$category.'_items_'.date('d-M-y').'_'.$all_products);
		unset($array);
		
	}
	
	public function export_products()
	{
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$all_products	= $_REQUEST['all_products'];
		$type	= $_REQUEST['type'];
		$purity	= $_REQUEST['purity'];
		
		$range_from	= $_REQUEST['range_from'];
		$range_to	= $_REQUEST['range_to'];
		$diamond_quality	= $_REQUEST['diamond_quality'];
		
		$whr_data_string = '';
		
		if($range_from != '' && $range_to != '')
		{
			$whr_data_string = 'and date_range between "'.$range_from.'" and "'.$range_to.'"';
			
		}
		$whr_data_string =  'and diamond_name="SIIJ"';
		$all_products_explode = explode('_', $all_products);
		$limit_range = 'limit '.$all_products_explode[0].','.$all_products_explode[1].'';
		
		if(($category == 'Nose Pins' || $category == 'Pendants' || $category == 'Necklaces' || $category == 'Earrings') && $sku != '')
		{
			$array[] = array('SKU', 'White SKU', 'Metal', 'White Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name');
		}
		else if($sku != '')
		{
			$array[] = array('SKU', 'Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name', 'Selected Length', 'Selected Size Label');
		}
		
		/*if(($category == 'Rings' || $category == 'Bands') && $purity != '22K')
			$market_place_table = 'product_price_rings_bands';
		else if(($category == 'Rings' || $category == 'Bands' ) && $purity == '22K')
			$market_place_table = 'product_price_market_place_pendant';
		else if(($category == 'Earrings' || $category == 'Pendants' || $category == 'Necklaces' || $category == 'Nose Pins') && ($purity == '14K' || $purity == '22K' || $purity == '18K'))
			$market_place_table = 'product_price_market_place_pendant';
		else if(($category == 'Chains' ) && ($purity == '18K' || $purity == '22K' || $purity == '14K'))
			$market_place_table = 'product_price_market_place_pendant';
		else if(($category == 'Bangles' || $category == 'Kada' || $category == 'Bracelets') &&  $purity == '22K')
			$market_place_table = 'product_price_market_place_pendant';
		else 
			$market_place_table = 'product_price_market_place';
		
		if($type == 'diamond')
			$sel_products = "select * from $market_place_table where product_type= '".$category."' and purity='".$purity."' and diamond_flag =1 $whr_data_string group by metal_weight, sku";
		else if($type == 'gold')
			$sel_products = "select * from $market_place_table where product_type= '".$category."' and purity='".$purity."' and gold_flag =1 $whr_data_string group by metal_weight, sku ";
		else if($type == 'gemstone')
			$sel_products = "select * from $market_place_table where product_type= '".$category."' and purity='".$purity."' and diamond_flag =0 and gemstone_flag=1 $whr_data_string group by metal_weight, sku";
		else if($type == 'gold_coins')
			$sel_products = "select * from catalog_product_flat_1 where candere_product_type_value= 'Coins'";
		else
			$sel_products = "select * from $market_place_table where product_type= '".$category."' and purity='".$purity."' $whr_data_string group by metal_weight, sku";*/
		
		//echo "pur--".$purity."--cat--".$category;
		if($purity == '14K')
		{
			$market_place_table = 'product_price_market_place';
		}
		/*if($purity == '14K' && $category == 'Nose Pins')
		{
			$market_place_table = 'product_price_market_place_pendant';
		}*/
		if($purity == '18K')
		{
			$market_place_table = 'product_price_market_place_pendant';
		}
		if($purity == '22K')
		{
			$market_place_table = 'product_price_rings_bands';
		}
		
		$sel_products = "select * from $market_place_table where  purity='".$purity."' group by metal_weight, sku";
		
		$res_products = mysql_query($sel_products);
		while($row_products = mysql_fetch_assoc($res_products))
		{			
			$sku				= $row_products['sku'];
			$metal 				= $row_products['metal'];
			$purity 			= $row_products['purity'];
			$product_name 		= $row_products['name'];
			$metal_weight 		= $row_products['metal_weight'];
			$total_weight		= $row_products['total_weight'];
			$product_type		= $row_products['product_type'];
			if($type == 'gold_coins')
			$old_price 			= $row_products['price'];
			else
			$old_price 			= $row_products['old_price'];
			$new_price 			= $row_products['selling_price'];
			$diamond_quality	= $row_products['diamond_name'];
			$selected_length	= $row_products['selected_length'];
			$selected_size_label= $row_products['selected_size_label'];
			$white_sku			= $row_products['white_sku'];
			$white_metal= $row_products['white_metal'];
			
			
			
			if(($category == 'Nose Pins' || $category == 'Pendants' || $category == 'Necklaces' || $category == 'Earrings' || $category == 'Earrings') && $sku != '')
			{
				$array[] = array('sku'=>$sku, 'white_sku'=>$white_sku, 'metal'=>$metal, 'white_metal'=>$white_metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>$diamond_quality);
			}
			else if($sku != '')
			{
				$array[] = array('sku'=>$sku, 'white_sku'=>$white_sku, 'metal'=>$metal, 'white_metal'=>$white_metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>$diamond_quality,'selected_length'=>$selected_length, 'selected_size_label'=>$selected_size_label);
			}
			
			
		}
		
		$this->load->dbutil();
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');		
		
		array_to_csv($array,'export_'.$category.'_items_'.date('d-M-y').'_'.$all_products);
		unset($array);
		
	}
	
	public function export_products_packed_n_ready()
	{
		$category 		= $_REQUEST['category'];
		/*if($category == 'Bands' || $category == 'Rings')
		{
			set_time_limit(0);
			$this->db->cache_delete_all();
			$this->load->helper('csv');
			$all_products	= $_REQUEST['all_products'];
			$all_products_explode = explode('_', $all_products);
			$limit_range = 'limit '.$all_products_explode[0].','.$all_products_explode[1].'';
			
			$array[] = array('SKU', 'Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name', 'Selected Length', 'Selected Size Label');
			
			//$sel_products = "select * from product_price_market_place where product_type='Bands' and purity='14K'";
			$sel_products = "select * from product_price_market_place limit 0, 1000"; 
			$res_products = mysql_query($sel_products);
			while($row_products = mysql_fetch_assoc($res_products))
			{
				$sku				= $row_products['sku'];
				
				$metal 				= $row_products['metal'];
				$purity 			= $row_products['purity'];
				$product_name 		= $row_products['name'];
				$metal_weight 		= $row_products['metal_weight'];
				$total_weight		= $row_products['total_weight'];
				$product_type		= $row_products['product_type'];
				$old_price 			= $row_products['old_price'];
				$new_price 			= $row_products['selling_price'];
				$diamond_quality	= $row_products['diamond_name'];
				$selected_length	= $row_products['selected_length'];
				$selected_size_label= $row_products['selected_size_label'];
				
				//if($sku != '')
				//{
					$array[] = array('sku'=>$sku, 'metal'=>$metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>$diamond_quality,'selected_length'=>$selected_length, 'selected_size_label'=>$selected_size_label);
				//}
			}
			
			$this->load->dbutil();
			header('Content-Type: text/html; charset=utf-8');
			header('Content-Transfer-Encoding: binary');		
			
			array_to_csv($array,'export_Rings_items_'.date('d-M-y').'_'.$all_products);
			unset($array);
		}
		else
		{	 */	
			set_time_limit(0);
			$this->db->cache_delete_all();
			$this->load->helper('csv');
			
			$all_products	= $_REQUEST['all_products'];
			$all_products_explode = explode('_', $all_products);
			
			/*echo "<pre>";
			print_r($_REQUEST);
			echo "</pre>";*/
			
			$metal_id 		= $_REQUEST['metal_selection'];
			$purity_id 		= $_REQUEST['purity'];
			$category 		= $_REQUEST['category'];
			$products_packed_ready 		= $_REQUEST['products_packed_ready'];
			$limit_range = '';
			
			if($products_packed_ready == 'all_products')
			{
				$limit_range = 'limit '.$all_products_explode[0].','.$all_products_explode[1].'';
				$str		 = "where candere_product_type_value = '".$category."' and entity_id  in ('3430',  '4674',  '1084',  '1098',  '1639',  '3432',  '1729',  '3431',  '5710',  '5711',  '5712',  '5750',  '5751',  '5752',  '4674',  '4671',  '4673')";
			}
			
			if($products_packed_ready == 'packed_ready')
			{
				$str		 = "where entity_id not in ('3430',  '4674',  '1084',  '1098',  '1639',  '3432',  '1729',  '3431',  '5710',  '5711',  '5712',  '5750',  '5751',  '5752',  '4674',  '4671',  '4673')";
				$metal_id 		= '';
				$purity_id 		= '';
				$category 		= '';
				$str			= '';
			}
			
			//-select * from catalog_product_flat_1 where candere_product_type_value = 'Rings' and entity_id not in ('3430', '4674', '1084', '1098', '1639', '3432', '1729', '3431', '5710', '5711', '5712', '5750', '5751', '5752', '4674', '4671', '4673') limit 307,357  $limit_range
			echo "sel---".$sel_products = "select * from catalog_product_flat_1 $str "; exit;
			
			//$sel_products = "SELECT c.* FROM catalog_product_flat_1 c LEFT JOIN pricing_table_metal_options p ON c.entity_id=p.product_id";
			
			$res_products = mysql_query($sel_products);
			
			$array[] = array('SKU', 'Metal', 'Purity', 'Name', 'Metal Weight in Gms', 'Total Weight in Gms', 'Product Type', 'MRP', 'Selling Price', 'Diamond Name', 'Selected Length', 'Selected Size Label');
			
			while($row_products = mysql_fetch_assoc($res_products))
			{
				$product_id 	= $row_products['entity_id'];
				// ||  $product_id  == '92' || $product_id  == '1184'
				if($product_id  == '92'):

				if($products_packed_ready == 'packed_ready')
				{
					$default_metal_karat	= Mage::helper('function')->get_default_metal_karat($product_id);
					$metal_id 				= $default_metal_karat['metal_id'];
					$purity_id 				= $default_metal_karat['purity'];
				}
				
				if($metal_id == '60')
					$metal = 'Yellow Gold';
				else if($metal_id == '59')
					$metal = 'White Gold';
				else
					$metal = '';
				
				if($purity_id == '49')
					$purity = '14K';
				else if($purity_id == '50')
					$purity = '18K';
				else if($purity_id == '589')
					$purity = '22K';
				else if($purity_id == '51')
					$purity = '9K';
				else if($purity_id == '538')
					$purity = 'Platinum';
				else if($purity_id == '24K')
				{
					$purity 				= '24K';
					$default_metal_karat	= Mage::helper('function')->get_default_metal_karat($product_id);
					$metal_id 				= $default_metal_karat['metal_id'];
					$purity_id 				= $default_metal_karat['purity'];
				}
				else
					$purity = '';
				
				$diamond_quality 		= $_REQUEST['diamond_quality'];
				$diamond_quality_explode = explode('_', $diamond_quality);
				$product 				= Mage::getModel('catalog/product')->load($product_id);
				
				$categories 		= $product->getCategoryIds();
				
				$product_name 			= $product->getName() ;
				$old_price				= $product->getPrice();
				$metal_weight 			= $product->getDefault_metal_weight();			
				$total_weight 			= $product->getTotal_weight();			
				$diamond_color_value 	= $diamond_quality_explode[0];
				$diamond_clarity_value  = $diamond_quality_explode[1];
				
				$product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(), 'candere_product_type');
				
				$product_diamond_gemstone_flag = Mage::helper('function')->getProductDiamondandGemstoneCostValue($product_id,$product_type,$metal_weight,$total_weight,$purity_id, $diamond_color_value, $diamond_clarity_value);
				
				$default_length 		= $product_diamond_gemstone_flag['default_length'];
				$thickness				= 0;
				if($product_type == 'Chains') {
					$default_length =  trim(Mage::helper('function')->get_attribute_name_and_value_frontend($product->getChain_length(),'chain_length'));
					$thickness = $product->getWidth();
				}

				$clarity 				= $product_diamond_gemstone_flag['diamond_clarity'];
				$color 					= $product_diamond_gemstone_flag['diamond_color'];			
				$diamond_selection		= $product_diamond_gemstone_flag['diamond_clarity'].$product_diamond_gemstone_flag['diamond_color'];
				
				if($product_type == 'Chains'){ 
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'chain_length'); 
				}else if($product_type == 'Bangles'){ 
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bangle_ring_size'); 
				}else if($product_type == 'Kada'){ 
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'kada_ring_size');  
				}else if($product_type == 'Bracelets'){ 
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'bracelets_length'); 
				}else if($product_type == 'Rings'){ 
					$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ring_sizer'); 
				}
				
				if(in_array('259', $categories))
					$display = "yes";
				else if(in_array('340', $categories))
					$display = "yes";
				else
					$display = "no";
				
				echo "--dis--".$display;
				
				echo "--dis prod--".$display_product;
				if($product_type == 'Chains' || $product_type == 'Bangles' || $product_type == 'Kada' || $product_type == 'Bracelets' || $product_type == 'Rings')
					$display_product = 'yes';
				else
					$display_product = 'no';
				
				echo $display."-d--p-".$display_product; exit;
				
				//echo "dis---".$display."---".$products_packed_ready; exit;
				//if($products_packed_ready == 'all_products')
				//{
					echo "sel sku---".$sel_sku = "select * from pricing_table_metal_options where product_id=".$product_id." and metal_id=".$metal_id." and purity=".$purity_id."";
					$res_sku = $this->db->query($sel_sku);
					$row_sku = $res_sku->result_array();
					$sku	 = $row_sku[0]['sku'];
					if($sku != ''){
						/*if($display == 'no' && $display_product == 'yes'){
							foreach($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect)
							{ 
								if($attribute_collect['label'] !='')
								{
									$label 					= $attribute_collect['label'] ;
									$explode_label 			= explode("&nbsp;", $label);
									$selected_size_label 	= trim(end($explode_label)) ; 
									$selected_size 			= trim(str_replace('ANNA','',str_replace('(in)','',str_replace('mm','',end($explode_label)))));						
									$selected_length 		= $explode_label[0];						
									//$size_in_inches 		= number_format(0.0393701* $selected_size,2);
									
									$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$label,$thickness,$diamond_selection,$purity_id,$clarity,$color);
							
									
									$old_price 				= $product_price_details['old_price'];
									$new_price 				= $product_price_details['new_price'];
									$metal_weight 			= $product_price_details['metal_weight'];
									$total_weight			= $product_price_details['total_weight'];
															
									$array[] = array('sku'=>$sku, 'metal'=>$metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>str_replace('_', ' ',strtoupper($diamond_quality)),'selected_length'=>$selected_length, 'selected_size_label'=>$selected_size_label);
								}
								
								unset($metal_weight);
								unset($total_weight);
								unset($old_price);
								unset($new_price);
								unset($selected_length);
								unset($selected_size_label);
							}			
						}
						else
						{*/
							$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$default_length,$thickness,$diamond_selection,$purity_id,$clarity,$color);

							/*echo "<pre>";
							print_r($product_price_details);
							echo "</pre>"; exit;*/
								
							
							$old_price 				= $product_price_details['old_price'];
							$new_price 				= $product_price_details['new_price'];
							$metal_weight 			= $product_price_details['metal_weight'];
							$total_weight			= $product_price_details['total_weight'];
							
							$array[] = array('sku'=>$sku, 'metal'=>$metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>str_replace('_', ' ',strtoupper($diamond_quality)));	
						//}
					}
				//}
				
				if($products_packed_ready == 'packed_ready' && $display == 'yes')
				{
					$sku					= $product->getSku();
					$default_metal_karat	= Mage::helper('function')->get_default_metal_karat($product_id);
					$metal_id 				= $default_metal_karat['metal_id'];
					$purity_id 				= $default_metal_karat['purity'];			
					$metal_weight 			= $product->getDefault_metal_weight();			
					$total_weight 			= $product->getTotal_weight();

					$resource 		= Mage::getSingleton('core/resource');
					$readConnection = $resource->getConnection('core_read');  
					
					$sql = 'SELECT siij_price,sigh_price,vsgh_price,vvsgh_price,vvsef_price,diamond_default FROM pricing_table_metal_options pricing_table_metal_options
				 WHERE (product_id = '.$product_id.' and metal_id = '.$metal_id.' and purity = '.$purity_id.' and store_id = 0)  and (siij_price !=0 or sigh_price!=0 or vsgh_price!=0 or vvsgh_price!=0 or vvsef_price!=0)';
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
					
					$diamond_selection = $diamond_color_value.$diamond_clarity_value;
					
					if($display_product = 'yes')
					{
						foreach($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect)
						{ 
							if($attribute_collect['label'] !='')
							{
								$label 					= $attribute_collect['label'] ;
								
								$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$label,$thickness,$diamond_selection,$purity_id,$clarity,$color);
							}
						}
					}
					else
					{
						$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($product_id,$metal_id,$purity_id,$default_length,$thickness,$diamond_selection,$purity_id,$diamond_color_value,$diamond_clarity_value);
					}
					
					if($product_type == 'Bands' || $product_type == 'Rings')
						$ring_length = Mage::helper('function')->get_attribute_name_and_value_frontend($product->getDeals_ring_sizer(), 'deals_ring_sizer');
					
					$old_price 				= $product_price_details['old_price'];
					$new_price 				= $product_price_details['new_price'];
					$metal_weight 			= $product_price_details['metal_weight'];
					$total_weight			= $product_price_details['total_weight'];
					
					$array[] = array('sku'=>$sku, 'metal'=>$metal, 'purity'=>$purity, 'name'=>$product_name, 'metal_weight'=>$metal_weight, 'total_weight'=>$total_weight, 'product_type'=>$product_type, 'old_price'=>round($old_price), 'selling_price'=>round($new_price), 'diamond_name'=>strtoupper($diamond_color_value.$diamond_clarity_value), 'ring_length' => $ring_length);
				}
				endif;
			}
			
			//$data['msg'] = $array;
			//$this->load->view('export_products_all_size/index',$data);
			$this->load->dbutil();
			header('Content-Type: text/html; charset=utf-8');
			header('Content-Transfer-Encoding: binary');
			
			if($category == '')
				$category = $products_packed_ready;
			//array_to_csv($array,'export_'.$product_label.'_items_'.date('d-M-y').'_'.$all_products);
			array_to_csv($array,'export_'.$category.'_items_'.date('d-M-y').'_'.$all_products);
			unset($array);
		}
	//}
}
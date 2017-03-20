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
	
	public function export_products_report()
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
	
	public function export_products()
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
			//$products_packed_ready 		= $_REQUEST['products_packed_ready'];
			$limit_range = '';
			echo "--pack ready--".$products_packed_ready 		= 'packed_ready';
			
			
			
				$str		 = "where sku in ('VRGR001','VRGR002','VRGR003','VRGR004','VRGR005','VRGR006','VRGR007','VRGR008','VRGR009','VRLR008','VRLR009','VRLR010','VRLR012','VRLR015','VRLR017','VRLR040','VRLR041','VRLR042','VRLR043','VRLR044','VRLR045','VRLR046','VRLR048','VRLR049','VRLR050','VRLR051','VRLR052','VRLR053','VRLR054','VRLR055','VRLR056','VRLR057','VRLR058','VRLR059','VRLR060','VRLR061','VRLR062','VRLR063','VRLR064','VRLR066','VRLR068','VRLR070','VRLR072','VRLR074','VRLR076','VRLR078','VRLR080','VRLR082','VRLR086','VRLR088','VRLR090','VRLR092','VRLR094','VRLR096','VRLR098','SD00002','SD00014','SD00018','SD00019','SD00020')";
				
			
			//-select * from catalog_product_flat_1 where candere_product_type_value = 'Rings' and entity_id not in ('3430', '4674', '1084', '1098', '1639', '3432', '1729', '3431', '5710', '5711', '5712', '5750', '5751', '5752', '4674', '4671', '4673') limit 307,357  $limit_range
			$sel_products = "select * from catalog_product_flat_1 $str ";
			
			//$sel_products = "SELECT c.* FROM catalog_product_flat_1 c LEFT JOIN pricing_table_metal_options p ON c.entity_id=p.product_id";
			
			$res_products = mysql_query($sel_products);
			
			$array[] = array('SKU', 'Ring Length');
			
			while($row_products = mysql_fetch_assoc($res_products))
			{
				$product_id 	= $row_products['entity_id'];
				$sku 	= $row_products['sku'];
				// ||  $product_id  == '92' || $product_id  == '1184'
				//if($product_id  == '92'):

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
				
				echo "pro type===".$product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(), 'candere_product_type');
				
				echo "======ring lent----".$ring_length = Mage::helper('function')->get_attribute_name_and_value_frontend($product->getDeals_ring_sizer(), 'deals_ring_sizer');
				
				
		
				preg_match_all('/\d+(\.\d+)?/', $length, $matches); 
				echo "--length--".$length = end($matches[0]);
				
				
				
				
			//	endif;
			
			
			$array[] = array('sku'=>$sku, 'Ring Size'=>$ring_length);
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
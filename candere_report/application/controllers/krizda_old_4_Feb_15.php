<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Krizda extends CI_Controller  {
	
	public function __construct()
	{
		set_time_limit(0);
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("krizda/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 	
		set_time_limit(0);
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunction();
		$this->load->dbutil();
		$array = array();
		if($sql){
			$counter = 1 ; 
			
			$array[0]['id'] = 'id';
			$array[0]['sku'] = 'sku';
			$array[0]['price'] = 'price';
			$array[0]['metal_id'] = 'metal_id';
			$array[0]['name'] = 'name';
			$array[0]['metal'] = 'metal';
			$array[0]['purity'] = 'purity';
			$array[0]['url'] = 'url';
			$array[0]['expected_delivery_date'] = 'expected_delivery_date';
			$array[0]['height'] = 'height';
			$array[0]['width'] = 'width';
			$array[0]['short_description'] = 'short_description';
			$array[0]['metal_weight'] = 'metal_weight';
			$array[0]['total_weight'] = 'total_weight';
			$array[0]['product_type'] = 'product_type'; 
			$array[0]['design_no'] = 'design_no';
			$array[0]['gender'] = 'gender';
			$array[0]['product_status'] = 'product_status';
			$array[0]['category'] = 'category';
			$array[0]['diamond_1_clarity'] = 'diamond_1_clarity';
			$array[0]['diamond_1_shape'] = 'diamond_1_shape';
			$array[0]['diamond_1_color'] = 'diamond_1_color';
			$array[0]['diamond_1_weight'] = 'diamond_1_weight';
			$array[0]['diamond_1_no_of_diamonds'] = 'diamond_1_no_of_diamonds';
			$array[0]['diamond_1_setting_type'] = 'diamond_1_setting_type';
			
			$array[0]['diamond_2_clarity'] = 'diamond_2_clarity';
			$array[0]['diamond_2_shape'] = 'diamond_2_shape';
			$array[0]['diamond_2_color'] = 'diamond_2_color';
			$array[0]['diamond_2_weight'] = 'diamond_2_weight';
			$array[0]['diamond_2_no_of_diamonds'] = 'diamond_2_no_of_diamonds';
			$array[0]['diamond_2_setting_type'] = 'diamond_2_setting_type';
			
			$array[0]['diamond_3_clarity'] = 'diamond_3_clarity';
			$array[0]['diamond_3_shape'] = 'diamond_3_shape';
			$array[0]['diamond_3_color'] = 'diamond_3_color';
			$array[0]['diamond_3_weight'] = 'diamond_3_weight';
			$array[0]['diamond_3_no_of_diamonds'] = 'diamond_3_no_of_diamonds';
			$array[0]['diamond_3_setting_type'] = 'diamond_3_setting_type';
			
			$array[0]['diamond_4_clarity'] = 'diamond_4_clarity';
			$array[0]['diamond_4_shape'] = 'diamond_4_shape';
			$array[0]['diamond_4_color'] = 'diamond_4_color';
			$array[0]['diamond_4_weight'] = 'diamond_4_weight';
			$array[0]['diamond_4_no_of_diamonds'] = 'diamond_4_no_of_diamonds';
			$array[0]['diamond_4_setting_type'] = 'diamond_4_setting_type';
			
			$array[0]['diamond_5_clarity'] = 'diamond_5_clarity';
			$array[0]['diamond_5_shape'] = 'diamond_5_shape';
			$array[0]['diamond_5_color'] = 'diamond_5_color';
			$array[0]['diamond_5_weight'] = 'diamond_5_weight';
			$array[0]['diamond_5_no_of_diamonds'] = 'diamond_5_no_of_diamonds';
			$array[0]['diamond_5_setting_type'] = 'diamond_5_setting_type';
			
			$array[0]['diamond_6_clarity'] = 'diamond_6_clarity';
			$array[0]['diamond_6_shape'] = 'diamond_6_shape';
			$array[0]['diamond_6_color'] = 'diamond_6_color';
			$array[0]['diamond_6_weight'] = 'diamond_6_weight';
			$array[0]['diamond_6_no_of_diamonds'] = 'diamond_6_no_of_diamonds';
			$array[0]['diamond_6_setting_type'] = 'diamond_6_setting_type';
			
			$array[0]['diamond_7_clarity'] = 'diamond_7_clarity';
			$array[0]['diamond_7_shape'] = 'diamond_7_shape';
			$array[0]['diamond_7_color'] = 'diamond_7_color';
			$array[0]['diamond_7_weight'] = 'diamond_7_weight';
			$array[0]['diamond_7_no_of_diamonds'] = 'diamond_7_no_of_diamonds';
			$array[0]['diamond_7_setting_type'] = 'diamond_7_setting_type';
			
			
			$array[0]['gemstone_1_total_gemstone'] = 'gemstone_1_total_gemstone';
			$array[0]['gemstone_1_type'] = 'gemstone_1_type';
			$array[0]['gemstone_1_color'] = 'gemstone_1_color';
			$array[0]['gemstone_1_shape'] = 'gemstone_1_shape';
			$array[0]['gemstone_1_weight'] = 'gemstone_1_weight';
			
			$array[0]['gemstone_2_total_gemstone'] = 'gemstone_2_total_gemstone';
			$array[0]['gemstone_2_type'] = 'gemstone_2_type';
			$array[0]['gemstone_2_color'] = 'gemstone_2_color';
			$array[0]['gemstone_2_shape'] = 'gemstone_2_shape';
			$array[0]['gemstone_2_weight'] = 'gemstone_2_weight';
			
			$array[0]['gemstone_3_total_gemstone'] = 'gemstone_3_total_gemstone';
			$array[0]['gemstone_3_type'] = 'gemstone_3_type';
			$array[0]['gemstone_3_color'] = 'gemstone_3_color';
			$array[0]['gemstone_3_shape'] = 'gemstone_3_shape';
			$array[0]['gemstone_3_weight'] = 'gemstone_3_weight';
			
			$array[0]['gemstone_4_total_gemstone'] = 'gemstone_4_total_gemstone';
			$array[0]['gemstone_4_type'] = 'gemstone_4_type';
			$array[0]['gemstone_4_color'] = 'gemstone_4_color';
			$array[0]['gemstone_4_shape'] = 'gemstone_4_shape';
			$array[0]['gemstone_4_weight'] = 'gemstone_4_weight';
			
			$array[0]['gemstone_5_total_gemstone'] = 'gemstone_5_total_gemstone';
			$array[0]['gemstone_5_type'] = 'gemstone_5_type';
			$array[0]['gemstone_5_color'] = 'gemstone_5_color';
			$array[0]['gemstone_5_shape'] = 'gemstone_5_shape';
			$array[0]['gemstone_5_weight'] = 'gemstone_5_weight';
			 
			$array[0]['img_1'] = 'img_1';
			$array[0]['img_2'] = 'img_2';
			$array[0]['img_3'] = 'img_3';
			$array[0]['img_4'] = 'img_4'; 
			
			foreach($sql as $value){
				 	
				 $product_id = $value['product_id']; 
				 $metal_id	 = $value['metal_id']; 
			
				 $array[$counter] = $value ;
				 
				if($value['metal_id'] == 58)
				{
					//platinum
					$image_code = 256;
				}
				if($value['metal_id'] == 59)
				{
					//White Gold
					$image_code = 258;
				}
				
				if($value['metal_id'] == 60)
				{
					//Yellow Gold
					$image_code = 259;
				}
				
				if($value['metal_id'] == 61)
				{
					//Rose Gold
					$image_code = 257;
				}
				$product_status = '';
				if($value['product_status'] == 1)
				{ 
					$product_status = 'Enabled';
				}else{
					$product_status = 'Disabled';
				}
				 	 
				$sql =	"SELECT  GROUP_CONCAT(catalog_category_entity_varchar.value SEPARATOR',') AS category
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

				$results = $this->db->query($sql);
				$result = $results->result_array();
				 
				if($result){
					foreach($result as $rslt){ 
						$array[$counter]['category']  = $rslt['category'] ;   
					} 
				}else{
					$array[$counter]['category']  = '' ;   
				}
				
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
							$array[$counter]['diamond_1_clarity'] = $diamond_1_clarity ;
							$array[$counter]['diamond_1_shape'] = $diamond_1_shape ;
							$array[$counter]['diamond_1_color'] = $diamond_1_color ;
							$array[$counter]['diamond_1_weight'] = $diamond_1_weight ;$array[$counter]['diamond_1_no_of_diamonds'] = $diamond_1_no_of_diamonds ;
							$array[$counter]['diamond_1_setting_type'] = $diamond_1_setting_type ;
						}else{
							$array[$counter]['diamond_1_clarity'] = '';
							$array[$counter]['diamond_1_shape'] = '';
							$array[$counter]['diamond_1_color'] = '';
							$array[$counter]['diamond_1_weight'] = '';
							$array[$counter]['diamond_1_no_of_diamonds'] = '';
							$array[$counter]['diamond_1_setting_type']= '';
						}
						if($diamond_2 == 1){ 
							$array[$counter]['diamond_2_clarity'] = $diamond_2_clarity ;
							$array[$counter]['diamond_2_shape'] = $diamond_2_shape ;
							$array[$counter]['diamond_2_color'] = $diamond_2_color ;
							$array[$counter]['diamond_2_weight'] = $diamond_2_weight ;
							$array[$counter]['diamond_2_no_of_diamonds'] = $diamond_2_no_of_diamonds ;
							$array[$counter]['diamond_2_setting_type'] = $diamond_2_setting_type ;
						}else{
							$array[$counter]['diamond_2_clarity'] = '';
							$array[$counter]['diamond_2_shape'] = '';
							$array[$counter]['diamond_2_color'] = '';
							$array[$counter]['diamond_2_weight'] = '';
							$array[$counter]['diamond_2_no_of_diamonds'] = '';
							$array[$counter]['diamond_2_setting_type']= '';
						}
						if($diamond_3 == 1){ 
							$array[$counter]['diamond_3_clarity'] = $diamond_3_clarity ;
							$array[$counter]['diamond_3_shape'] = $diamond_3_shape ;
							$array[$counter]['diamond_3_color'] = $diamond_3_color ;
							$array[$counter]['diamond_3_weight'] = $diamond_3_weight ;
							$array[$counter]['diamond_3_no_of_diamonds'] = $diamond_3_no_of_diamonds ;
							$array[$counter]['diamond_3_setting_type'] = $diamond_3_setting_type ;
						}else{
							$array[$counter]['diamond_3_clarity'] = '';
							$array[$counter]['diamond_3_shape'] = '';
							$array[$counter]['diamond_3_color'] = '';
							$array[$counter]['diamond_3_weight'] = '';
							$array[$counter]['diamond_3_no_of_diamonds'] = '';
							$array[$counter]['diamond_3_setting_type']= '';
						}
						if($diamond_4 == 1){ 
							$array[$counter]['diamond_4_clarity'] = $diamond_4_clarity ;
							$array[$counter]['diamond_4_shape'] = $diamond_4_shape ;
							$array[$counter]['diamond_4_color'] = $diamond_4_color ;
							$array[$counter]['diamond_4_weight'] = $diamond_4_weight ;
							$array[$counter]['diamond_4_no_of_diamonds'] = $diamond_4_no_of_diamonds ;
							$array[$counter]['diamond_4_setting_type'] = $diamond_4_setting_type ;
						}else{
							$array[$counter]['diamond_4_clarity'] = '';
							$array[$counter]['diamond_4_shape'] = '';
							$array[$counter]['diamond_4_color'] = '';
							$array[$counter]['diamond_4_weight'] = '';
							$array[$counter]['diamond_4_no_of_diamonds'] = '';
							$array[$counter]['diamond_4_setting_type']= '';
						}
						
						if($diamond_5 == 1){ 
							$array[$counter]['diamond_5_clarity'] = $diamond_5_clarity ;
							$array[$counter]['diamond_5_shape'] = $diamond_5_shape ;
							$array[$counter]['diamond_5_color'] = $diamond_5_color ;
							$array[$counter]['diamond_5_weight'] = $diamond_5_weight ;
							$array[$counter]['diamond_5_no_of_diamonds'] = $diamond_5_no_of_diamonds ;
							$array[$counter]['diamond_5_setting_type'] = $diamond_5_setting_type ;
						}else{
							$array[$counter]['diamond_5_clarity'] = '';
							$array[$counter]['diamond_5_shape'] = '';
							$array[$counter]['diamond_5_color'] = '';
							$array[$counter]['diamond_5_weight'] = '';
							$array[$counter]['diamond_5_no_of_diamonds'] = '';
							$array[$counter]['diamond_5_setting_type']= '';
						}
						if($diamond_6 == 1){ 
							$array[$counter]['diamond_6_clarity'] = $diamond_6_clarity ;
							$array[$counter]['diamond_6_shape'] = $diamond_6_shape ;
							$array[$counter]['diamond_6_color'] = $diamond_6_color ;
							$array[$counter]['diamond_6_weight'] = $diamond_6_weight ;
							$array[$counter]['diamond_6_no_of_diamonds'] = $diamond_6_no_of_diamonds ;
							$array[$counter]['diamond_6_setting_type'] = $diamond_6_setting_type ;
						}else{
							$array[$counter]['diamond_6_clarity'] = '';
							$array[$counter]['diamond_6_shape'] = '';
							$array[$counter]['diamond_6_color'] = '';
							$array[$counter]['diamond_6_weight'] = '';
							$array[$counter]['diamond_6_no_of_diamonds'] = '';
							$array[$counter]['diamond_6_setting_type']= '';
						}
						if($diamond_7 == 1){ 
							$array[$counter]['diamond_7_clarity'] = $diamond_7_clarity ;
							$array[$counter]['diamond_7_shape'] = $diamond_7_shape ;
							$array[$counter]['diamond_7_color'] = $diamond_7_color ;
							$array[$counter]['diamond_7_weight'] = $diamond_7_weight ;
							$array[$counter]['diamond_7_no_of_diamonds'] = $diamond_7_no_of_diamonds ;  
							$array[$counter]['diamond_7_setting_type'] = $diamond_7_setting_type ;   
						}else{
							$array[$counter]['diamond_7_clarity'] = '';
							$array[$counter]['diamond_7_shape'] = '';
							$array[$counter]['diamond_7_color'] = '';
							$array[$counter]['diamond_7_weight'] = '';
							$array[$counter]['diamond_7_no_of_diamonds'] = '';
							$array[$counter]['diamond_7_setting_type']= '';
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
								
								//$sql = "select gemstone_1 as shape_1 ,gemstone_2 as shape_2 ,gemstone_3  as shape_3 ,gemstone_4 as shape_4 ,gemstone_5 as shape_5  from gemstone_attributes where attribute_id = 218 and product_id = $product_id";
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
									$array[$counter]['gemstone_1_total_gemstone'] = $gemstone_1_total_gemstone ;
									$array[$counter]['gemstone_1_type'] = $gemstone_1_type ;
									$array[$counter]['gemstone_1_color'] = $gemstone_1_color ;
									$array[$counter]['gemstone_1_shape'] = $gemstone_1_shape ;
									$array[$counter]['gemstone_1_weight'] = $gemstone_1_weight ; 
								}else{
									$array[$counter]['gemstone_1_total_gemstone'] = '';
									$array[$counter]['gemstone_1_type'] = '';
									$array[$counter]['gemstone_1_color'] = '';
									$array[$counter]['gemstone_1_shape'] = '';
									$array[$counter]['gemstone_1_weight'] = ''; 
								}
								
								if($gemstone_2 == 1){ 
									$array[$counter]['gemstone_2_total_gemstone'] = $gemstone_2_total_gemstone ;
									$array[$counter]['gemstone_2_type'] = $gemstone_2_type ;
									$array[$counter]['gemstone_2_color'] = $gemstone_2_color ;
									$array[$counter]['gemstone_2_shape'] = $gemstone_2_shape ;
									$array[$counter]['gemstone_2_weight'] = $gemstone_2_weight ; 
								}else{
									$array[$counter]['gemstone_2_total_gemstone'] = '';
									$array[$counter]['gemstone_2_type'] = '';
									$array[$counter]['gemstone_2_color'] = '';
									$array[$counter]['gemstone_2_shape'] = '';
									$array[$counter]['gemstone_2_weight'] = ''; 
								}
								
								if($gemstone_3 == 1){ 
									$array[$counter]['gemstone_3_total_gemstone'] = $gemstone_3_total_gemstone ;
									$array[$counter]['gemstone_3_type'] = $gemstone_3_type ;
									$array[$counter]['gemstone_3_color'] = $gemstone_3_color ;
									$array[$counter]['gemstone_3_shape'] = $gemstone_3_shape ;
									$array[$counter]['gemstone_3_weight'] = $gemstone_3_weight ; 
								}else{
									$array[$counter]['gemstone_3_total_gemstone'] = '';
									$array[$counter]['gemstone_3_type'] = '';
									$array[$counter]['gemstone_3_color'] = '';
									$array[$counter]['gemstone_3_shape'] = '';
									$array[$counter]['gemstone_3_weight'] = ''; 
								}
								
								if($gemstone_4 == 1){ 
									$array[$counter]['gemstone_4_total_gemstone'] = $gemstone_4_total_gemstone ;
									$array[$counter]['gemstone_4_type'] = $gemstone_4_type ;
									$array[$counter]['gemstone_4_color'] = $gemstone_4_color ;
									$array[$counter]['gemstone_4_shape'] = $gemstone_4_shape ;
									$array[$counter]['gemstone_4_weight'] = $gemstone_4_weight ; 
								}else{
									$array[$counter]['gemstone_4_total_gemstone'] = '';
									$array[$counter]['gemstone_4_type'] = '';
									$array[$counter]['gemstone_4_color'] = '';
									$array[$counter]['gemstone_4_shape'] = '';
									$array[$counter]['gemstone_4_weight'] = ''; 
								}
								
								if($gemstone_5 == 1){ 
									$array[$counter]['gemstone_5_total_gemstone'] = $gemstone_5_total_gemstone ;
									$array[$counter]['gemstone_5_type'] = $gemstone_5_type ;
									$array[$counter]['gemstone_5_color'] = $gemstone_5_color ;
									$array[$counter]['gemstone_5_shape'] = $gemstone_5_shape ;
									$array[$counter]['gemstone_5_weight'] = $gemstone_5_weight ; 
								}else{
									$array[$counter]['gemstone_5_total_gemstone'] = '';
									$array[$counter]['gemstone_5_type'] = '';
									$array[$counter]['gemstone_5_color'] = '';
									$array[$counter]['gemstone_5_shape'] = '';
									$array[$counter]['gemstone_5_weight'] = ''; 
								}
							}
						}
					} 
					
				}
				
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
						
						$array[$counter]['img_'.$img_counter]  = Mage::getBaseUrl().'media/catalog/product'.$images['img'] ; 
						
						$img_counter++ ;
					}  
				}
				
				$counter++;
			}
		}
		  
	 
		array_to_csv($array,'krizda_Products_'.date('dMy').'.csv'); 
		
		unset($array);
		//$this->load->helper('url'); 
		//redirect('/jungleeexport/index');
	} 
	 
	public function myqueryfunction(){	
	$this->db->cache_delete_all();
		//$this->db->insert('pricingupdate', $pricingupdate);	
		$sql =	"SELECT DISTINCT
       pricing_table_metal_options.product_id,
       pricing_table_metal_options.sku,
       pricing_table_metal_options.price,
       pricing_table_metal_options.metal_id,
       catalog_product_entity_varchar.value AS name,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar_1.value AS url,
       catalog_product_entity_varchar_3.value AS expected_delivery_date,
       catalog_product_entity_varchar_4.value AS width,
       catalog_product_entity_varchar_5.value AS height,
       catalog_product_entity_text.value AS short_description,
       catalog_product_entity_varchar_7.value AS weight,
       catalog_product_entity_varchar_6.value AS total_weight,
       eav_attribute_option_value_2.value AS product_type,
       catalog_product_entity_varchar_8.value AS design_no,
       eav_attribute_option_value_3.value AS gender,
       IF(catalog_product_entity_int_1.value = 1, 'Enabled', 'Disabled')
          AS product_status
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                                                                               INNER JOIN
                                                                                  catalog_product_entity_int catalog_product_entity_int_2
                                                                               ON (pricing_table_metal_options.product_id =
                                                                                      catalog_product_entity_int_2.entity_id))
                                                                           INNER JOIN
                                                                              metal_options_enabled metal_options_enabled
                                                                           ON     (metal_options_enabled.product_id =
                                                                                      pricing_table_metal_options.product_id)
                                                                              AND (metal_options_enabled.metal_id =
                                                                                      pricing_table_metal_options.metal_id))
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
                                                          eav_attribute_option_value_2.option_id))
                                               INNER JOIN
                                                  catalog_product_entity_varchar catalog_product_entity_varchar_7
                                               ON (metal_options_enabled.product_id =
                                                      catalog_product_entity_varchar_7.entity_id))
                                           INNER JOIN
                                              catalog_product_entity_int catalog_product_entity_int_3
                                           ON (metal_options_enabled.product_id =
                                                  catalog_product_entity_int_3.entity_id))
                                       INNER JOIN
                                          eav_attribute_option_value eav_attribute_option_value_3
                                       ON (catalog_product_entity_int_3.value =
                                              eav_attribute_option_value_3.option_id))
                                   INNER JOIN
                                      catalog_product_entity_varchar catalog_product_entity_varchar_2
                                   ON (pricing_table_metal_options.product_id =
                                          catalog_product_entity_varchar_2.entity_id))
                               INNER JOIN
                                  catalog_product_entity_varchar catalog_product_entity_varchar
                               ON (pricing_table_metal_options.product_id =
                                      catalog_product_entity_varchar.entity_id))
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
          catalog_product_entity_int catalog_product_entity_int_1
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_1.entity_id)
 WHERE (    catalog_product_entity_int_3.attribute_id = 163
        AND (    catalog_product_entity_varchar_8.attribute_id = 135
             AND (    catalog_product_entity_varchar_7.attribute_id = 282
                  AND (    (    (    catalog_product_entity_int_1.attribute_id =
                                        96
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
                            AND (    (    (    (    (    (    metal_options_enabled.status =
                                                                 1
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
ORDER BY metal_options_enabled.product_id ASC"; 

		$results = $this->db->query($sql);
		$result = $results->result_array();
		return $result ;
	}	
	
	public function exportimages()
	{ 
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunctionimages(); 
		$this->load->dbutil(); 
		array_to_csv($sql,'Default_Images_'.date('dMy').'.csv');  
	} 
	
	public function myqueryfunctionimages(){
		$this->db->cache_delete_all();
		$result_array = array();
		$sql =	"SELECT pricing_table_metal_options.sku,
		pricing_table_metal_options.metal_id,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name,
       metal_options_enabled.product_id
  FROM    (   (   (   pricing_table_metal_options pricing_table_metal_options
                   INNER JOIN
                      eav_attribute_option_value eav_attribute_option_value_1
                   ON (pricing_table_metal_options.purity =
                          eav_attribute_option_value_1.option_id))
               INNER JOIN
                  metal_options_enabled metal_options_enabled
               ON     (metal_options_enabled.product_id =
                          pricing_table_metal_options.product_id)
                  AND (metal_options_enabled.metal_id =
                          pricing_table_metal_options.metal_id))
           INNER JOIN
              eav_attribute_option_value eav_attribute_option_value
           ON (metal_options_enabled.metal_id =
                  eav_attribute_option_value.option_id))
       INNER JOIN
          catalog_product_entity_varchar catalog_product_entity_varchar
       ON (metal_options_enabled.product_id =
              catalog_product_entity_varchar.entity_id)
 WHERE     (pricing_table_metal_options.status = 1)
       AND (pricing_table_metal_options.isdefault = 1) 
       AND (metal_options_enabled.status = 1) 
       AND (catalog_product_entity_varchar.attribute_id = 71)"; 

		$results = $this->db->query($sql);
		$result = $results->result_array();
		if($result){ 
			$result_array[0][0] = 'sku';
			$result_array[0][1] = 'name';
			$result_array[0][2] = 'metal';
			$result_array[0][3] = 'purity';
			$result_array[0][4] = 'image'; 
			$result_array[0][5] = 'sku';
			$result_array[0][6] = 'name';
			$result_array[0][7] = 'metal';
			$result_array[0][8] = 'purity';
			$result_array[0][9] = 'image'; 
			foreach($result as $key=>$rslt){
				$product_id = $rslt['product_id'];
				if($rslt['metal_id'] == 58)
				{
					//platinum
					$image_code = 256;
				}
				if($rslt['metal_id'] == 59)
				{
					//White Gold
					$image_code = 258;
				}
				
				if($rslt['metal_id'] == 60)
				{
					//Yellow Gold
					$image_code = 259;
				}
				
				if($rslt['metal_id'] == 61)
				{
					//Rose Gold
					$image_code = 257;
				}
				
				 
				$sql = "SELECT catalog_product_entity_varchar.value as img
				  FROM catalog_product_entity_varchar catalog_product_entity_varchar
				 WHERE  (catalog_product_entity_varchar.entity_id = ?)
					   AND (catalog_product_entity_varchar.attribute_id = ?)"; 
				
				$results_images = $this->db->query($sql, array($product_id, $image_code));
				$results_imgs = array_pop($results_images->result_array());
				if($results_imgs){
					$result_array[$rslt['product_id']][] = $rslt['sku'];
					$result_array[$rslt['product_id']][] = $rslt['name'];
					$result_array[$rslt['product_id']][] = $rslt['metal'];
					$result_array[$rslt['product_id']][] = $rslt['purity'];
					$result_array[$rslt['product_id']][] = Mage::getBaseUrl().'media/catalog/product'.$results_imgs['img'];  
				}				
			}
		}	 
			//$sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
			//$this->db->query($sql, array(3, 'live', 'Rick')); 
		 
		return $result_array ;
	}	
	
	public function exportproductscategory()
	{ 
		$this->db->cache_delete_all();
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunctioncategory(); 
		$this->load->dbutil(); 
		query_to_csv($sql,true,'Default_Category_Products'.date('dMy').'.csv');  
	} 
	
	public function myqueryfunctioncategory(){	
		$this->db->cache_delete_all();
		//$this->db->insert('pricingupdate', $pricingupdate);	
		$sql =	"SELECT  pricing_table_metal_options.sku
 , catalog_product_entity_varchar.value as name
 , GROUP_CONCAT(catalog_category_entity_varchar.value SEPARATOR',') AS category
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
WHERE (catalog_category_entity_varchar.attribute_id  = 41 AND ((((pricing_table_metal_options.status  = 1 AND metal_options_enabled.isdefault  = 1) AND metal_options_enabled.status  = 1) AND pricing_table_metal_options.isdefault  = 1) AND catalog_product_entity_varchar.attribute_id  = 71))
GROUP BY pricing_table_metal_options.sku"; 

		$results = $this->db->query($sql);
		$result = $results->result_array();
		return $results ;
	}
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
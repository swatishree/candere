<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Filters extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database();
	}
	
	public function index()
	{
		$message_arr = array('');
		$this->load->view('templates/header');
        $this->load->view("filters/index",$message_arr);
		$this->load->view('templates/footer');
	}

	public function submit()
	{
		set_time_limit(0);
		$message_arr = array('');
		$this->load->library('upload'); 
		$this->load->library('form_validation');
		$this->load->library('session');
		
		if (isset($_POST['submit']))
        { 
			if (!file_exists('csvtemp')) {
				mkdir('csvtemp', 0777, true);
			}
            $config['upload_path'] = "./csvtemp/";
			$config['allowed_types'] = '*';
			 
            $this->upload->initialize($config);
			$messages  = '';
			
			foreach($_FILES as $field => $file)
            {
                if($file['error'] == 0)
                {	
                    if($this->upload->do_upload($field))
                    {
						$upload_data = $this->upload->data();					
						$full_path = $upload_data['full_path'];
						
						$this->db->query("TRUNCATE chain_filter");
														
						$sql =	"LOAD DATA LOCAL INFILE '{$full_path}' INTO TABLE chain_filter FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (id,sku,filter_name,filter_value)";
						$this->db->query($sql);
                    }
                } 
			}
			
			$query = $this->db->query("select distinct(sku) from chain_filter");
			$sku_data = $query->result();
				
			foreach($sku_data as $row) {
			
				$product_sku 	= $row->sku; 
				$product_id 	= Mage::getModel("catalog/product")->getIdBySku($product_sku);
				
				if($product_id) {
					$_product 		= Mage::getModel('catalog/product')->load($product_id); 
					$thickness 		= $_product->getWidth();
					$total_weight 	= $_product->getTotalWeight(); 
										
					if($thickness >= 0 && $thickness <= 0.99) {
						$thickness_name = 'Very Thin';
					} else if($thickness >= 1 && $thickness <= 1.99) {
						$thickness_name = 'Thin';
					} else if($thickness >= 2 && $thickness <= 2.99) {
						$thickness_name = 'Medium';
					} else if($thickness >= 3 && $thickness <= 3.99) {
						$thickness_name = 'Broad';
					} else if($thickness >= 4) {
						$thickness_name = 'Very Broad';
					}
					
					$data_thickness['sku'] 			= $product_sku;
					$data_thickness['filter_name'] 	= 'Thickness in mm';
					$data_thickness['filter_value'] = addslashes($thickness_name);
					
					$query 		= $this->db->query("select id from chain_filter where sku='$product_sku' AND filter_name='Thickness in mm' AND filter_value='$thickness_name' ");
					$res_style 	= $query->row();
					$id_thk 	= $res_style->id;
					if(!$id_thk) {
						$this->db->insert('chain_filter', $data_thickness);
					}
					unset($data_thickness);
						
					if($total_weight >=0 && $total_weight <=4.99) {
						$total_weight_name = 'Below 5 gms';
					} else if($total_weight >=5 && $total_weight <=9.99) {
						$total_weight_name = '5 To 10 gms';
					} else if($total_weight >=10 && $total_weight <=14.99) {
						$total_weight_name = '10 To 15 gms';
					} else if($total_weight >=15 && $total_weight <=19.99) {
						$total_weight_name = '15 To 20 gms';
					} else if($total_weight >=20 && $total_weight <=24.99) {
						$total_weight_name = '20 To 25 gms';
					} else if($total_weight >=25 && $total_weight <=29.99) {
						$total_weight_name = '25 To 30 gms';
					} else if($total_weight >=30 && $total_weight <=34.99) {
						$total_weight_name = '30 To 35 gms';
					} else if($total_weight >=35 && $total_weight <=39.99) {
						$total_weight_name = '35 To 40 gms';
					} else if($total_weight >=40 && $total_weight <=44.99) {
						$total_weight_name = '40 To 45 gms';
					} else if($total_weight >=45 && $total_weight <=49.99) {
						$total_weight_name = '45 To 50 gms';
					} else if($total_weight >=50 && $total_weight <=54.99) {
						$total_weight_name = '50 To 55 gms';
					} else if($total_weight >=55 && $total_weight <=59.99) {
						$total_weight_name = '55 To 60 gms';
					} else if($total_weight >=60 && $total_weight <=64.99) {
						$total_weight_name = '60 To 65 gms';
					} else if($total_weight >=65 && $total_weight <=69.99) {
						$total_weight_name = '65 To 70 gms';
					} else if($total_weight >=70 && $total_weight <=74.99) {
						$total_weight_name = '70 To 75 gms';
					} else if($total_weight >=75 && $total_weight <=79.99) {
						$total_weight_name = '75 To 80 gms';
					} else if($total_weight >=80 && $total_weight <=84.99) {
						$total_weight_name = '80 To 85 gms';
					} else if($total_weight >=85 && $total_weight <=89.99) {
						$total_weight_name = '85 To 90 gms';
					} else if($total_weight >=90 && $total_weight <=94.99) {
						$total_weight_name = '90 To 95 gms';
					} else if($total_weight >=95 && $total_weight <=100) {
						$total_weight_name = '95 To 100 gms';
					} else if($total_weight > 100) {
						$total_weight_name = 'Above 100 gms';
					}
					
					$data_weight['sku'] 			= $product_sku;
					$data_weight['filter_name'] 	= 'Weight gms';
					$data_weight['filter_value'] 	= $total_weight_name;
					
					$query 		= $this->db->query("select id from chain_filter where sku='$product_sku' AND filter_name='Weight gms' AND filter_value='$total_weight_name' ");
					$res_style 	= $query->row();
					$id_wt 		= $res_style->id;
					if(!$id_wt) {
						$this->db->insert('chain_filter', $data_weight);
					}
					unset($data_weight);
										
					if($total_weight >=0 && $total_weight <=14.99) {
						$style_name = 'Daily Wear';
					} else if($total_weight >=15 && $total_weight <=29.99) {
						$style_name = 'Traditional Wear';
					} else if($total_weight >=30 && $total_weight <=100) {
						$style_name = 'Party Wear';
					}
					
					$style_array['sku'] 			= $product_sku;
					$style_array['filter_name'] 	= 'Style';
					$style_array['filter_value'] 	= trim($style_name);
					
					$query 		= $this->db->query("select id from chain_filter where sku='$product_sku' AND filter_name='Style' AND filter_value='$style_name' ");
					$res_style 	= $query->row();
					$id_style 	= $res_style->id;
					if(!$id_style) {
						$this->db->insert('chain_filter', $style_array);
					}
					unset($style_array);
										
					
					if($total_weight >=0 && $total_weight <=9.99) {
						$age_array[$product_sku][]= 'Below 20 years';
					} else if($total_weight >=10 && $total_weight <=14.99) {
						$age_array[$product_sku][]= 'Below 20 years';
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '45 To 60 years';
						$age_array[$product_sku][]= 'Above 60 years';
					} else if($total_weight >=15 && $total_weight <=39.99) {
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '35 To 45 years';
						$age_array[$product_sku][]= '45 To 60 years';
						$age_array[$product_sku][]= 'Above 60 years';
					} else if($total_weight >=40 && $total_weight <=44.99) {
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '35 To 45 years';
						$age_array[$product_sku][]= '45 To 60 years';
					} else if($total_weight >=45 && $total_weight <=49.99) {
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '35 To 45 years';
						$age_array[$product_sku][]= '45 To 60 years';
					} else if($total_weight >=50 && $total_weight <=54.99) {
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '35 To 45 years';
					} else if($total_weight >=55 && $total_weight <=59.99) {
						$age_array[$product_sku][]= '20 To 35 years';
						$age_array[$product_sku][]= '35 To 45 years';
					} else if($total_weight >=60 && $total_weight <=100) {
						$age_array[$product_sku][]= '20 To 35 years';
					}
										
					foreach($age_array as $key=>$value) {
						$data_age = array();
						foreach($value as $rj) {
							$data_age['sku'] 			= $key;
							$data_age['filter_name'] 	= 'Age';
							$data_age['filter_value'] 	= mysql_real_escape_string($rj);
							
							$query 		= $this->db->query("select id from chain_filter where sku='$key' AND filter_name='Age' AND filter_value='".mysql_real_escape_string($rj)."' ");
							$res_age 	= $query->row();
							$id_age		= $res_age->id;
							if(!$id_age) {
								$this->db->insert('chain_filter', $data_age);
							}					
							unset($data_age);
						}
						unset($key, $value);
					}
					unset($age_array);
					
					
					if($total_weight >=0 && $total_weight <=4.99) {
						$occassion_array[$product_sku][]= 'Valentine\'s Day';
						$occassion_array[$product_sku][]= 'Birthday';
					} else if($total_weight >=5 && $total_weight <=9.99) {
						$occassion_array[$product_sku][]= 'Valentine\'s Day';
						$occassion_array[$product_sku][]= 'Birthday';
						$occassion_array[$product_sku][]= 'Anniversary';
					} else if($total_weight >=10 && $total_weight <=14.99) {
						$occassion_array[$product_sku][]= 'Anniversary';
						$occassion_array[$product_sku][]= 'Wedding';
					} else if($total_weight >=15 && $total_weight <=19.99) {
						$occassion_array[$product_sku][]= 'Anniversary';
						$occassion_array[$product_sku][]= 'Wedding';
					} else if($total_weight >=20 && $total_weight <=40) {
						$occassion_array[$product_sku][]= 'Wedding';
					}
					
					foreach($occassion_array as $key2=>$value2) {
						$data_occassion = array();
						foreach($value2 as $rj2) {
							$data_occassion['sku'] 			= $key2;
							$data_occassion['filter_name'] 	= 'Special Occassion';
							$data_occassion['filter_value'] = $rj2;
														
							$query 		= $this->db->query("select id from chain_filter where sku='$key2' AND filter_name='Special Occassion' AND filter_value= '".addslashes(mysql_real_escape_string($rj2))."' ");
							$res_ocas 	= $query->row();
							$id_ocas 	= $res_ocas->id;
							if(!$id_ocas) {
								$this->db->insert('chain_filter', $data_occassion);
							}
							unset($data_occassion);
						}
						unset($key2, $value2);
					}
					unset($_product, $occassion_array);
				}
								
			} //// Main Foreach for sku data 
			unset($sku_data);
			
			$query = $this->db->query("SELECT distinct(filter_name) FROM chain_filter");
			$filter_data = $query->result();
			
			if($filter_data) {
				foreach($filter_data as $rw) {
						
					$filter_name = trim($rw->filter_name);
					
					$sql = $this->db->query("SELECT attribute_id FROM eav_attribute WHERE frontend_label = '$filter_name'");
					$attribute 		= $sql->row();
					$attribute_id 	= $attribute->attribute_id;
					
					$sql = $this->db->query("SELECT distinct(filter_value) FROM chain_filter WHERE filter_name='$filter_name'");
					$options = $sql->result();
														
					if($options){
						foreach($options as $option) {
							
							$filter_value = addslashes($option->filter_value);
							
							$sql = $this->db->query("SELECT DISTINCT chain_filter.filter_value, eav_attribute_option.option_id  FROM    (   eav_attribute_option_value eav_attribute_option_value INNER JOIN  chain_filter chain_filter  ON (eav_attribute_option_value.value = chain_filter.filter_value))  INNER JOIN  eav_attribute_option eav_attribute_option   ON (eav_attribute_option.option_id =  eav_attribute_option_value.option_id) WHERE (chain_filter.filter_value = '$filter_value') ");
							$options = $sql->row();
														
							$option_id 	= $options->option_id;
							
							if(!$option_id) {
								$options_data['attribute_id'] 			= $attribute_id;
								$options_data['sort_order'] 			= '';
								$options_data['visible_in_frontend'] 	= 1;
								
								$this->db->insert('eav_attribute_option', $options_data);
								unset($options_data);
								
								$insert_id = $this->db->insert_id();
																
								$options_values['option_id'] 	= $insert_id;
								$options_values['store_id'] 	= 0;
								$options_values['value'] 		= $filter_value;
							
								$this->db->insert('eav_attribute_option_value', $options_values);
								
								unset($options_values);
							}
						}
						unset($options);
					}
				}	 ////End foreach add filter attribute
				unset($filter_data);
			} 		//// End if	
			
						
			$query 	= $this->db->query("select distinct(sku) from chain_filter order by sku");
			$result = $query->result();
						
			foreach($result as $nb) {
				
				$filter_sku = $nb->sku;
				$entity_id 	= Mage::getModel("catalog/product")->getIdBySku($filter_sku);
				
				$query 	= $this->db->query("select filter_name, filter_value from chain_filter where sku='$filter_sku' order by filter_name");
				$res_data = $query->result();
				
				if($res_data && isset($entity_id)) {
					foreach($res_data as $ss) {
						$frontend_label = trim($ss->filter_name);
						$value 			= trim(stripslashes($ss->filter_value));
						
						$query 	= $this->db->query("select attribute_id, frontend_input from eav_attribute where frontend_label='$frontend_label'");
						$eav_res 		= $query->row();
												
						$attribute_id 	= $eav_res->attribute_id;
						$frontend_input = $eav_res->frontend_input;
						
						if($frontend_input=='select') {
							$query 	= $this->db->query("select option_id from eav_attribute_option_value where value='$value'");
							$value_res = $query->row();							
							$option_id = $value_res->option_id;
													
							$query 		= $this->db->query("select value_id from catalog_product_entity_int where entity_id=$entity_id AND attribute_id=$attribute_id AND value=$option_id");
							$row_exist 	= $query->row();
							$value_id 	= $row_exist->value_id;
							
							if(!$value_id) {
								$catalog_data['entity_type_id'] = 4;
								$catalog_data['attribute_id'] 	= $attribute_id;
								$catalog_data['store_id'] 		= 0;
								$catalog_data['entity_id'] 		= $entity_id;
								$catalog_data['value'] 			= $option_id;
								
								$this->db->insert('catalog_product_entity_int', $catalog_data);
								unset($catalog_data);
							} else {
								$cat_data_int['value'] 			= $option_id;
								$key3['value_id'] 				= $value_id;
											
								$this->db->update('catalog_product_entity_int', $cat_data_int, $key3);
								unset($cat_data_int);
							}
						}
					}
					unset($res_data);
				}			
			}
			unset($result);
									
			
			$query = $this->db->query("SELECT DISTINCT catalog_product_entity.entity_id, eav_attribute_option.attribute_id, group_concat(DISTINCT eav_attribute_option_value.option_id SEPARATOR',') AS option_id, catalog_product_entity_varchar.value_id
					FROM
					 ((((catalog_product_entity catalog_product_entity
					 INNER JOIN
					 catalog_product_entity_varchar catalog_product_entity_varchar
					 ON (catalog_product_entity.entity_id = catalog_product_entity_varchar.entity_id))
					 INNER JOIN
					 chain_filter chain_filter
					 ON (chain_filter.sku = catalog_product_entity.sku))
					 INNER JOIN
					 eav_attribute eav_attribute
					 ON (chain_filter.filter_name = eav_attribute.frontend_label))
					 INNER JOIN
					 eav_attribute_option_value eav_attribute_option_value
					 ON (chain_filter.filter_value = eav_attribute_option_value.value))
					 INNER JOIN
					 eav_attribute_option eav_attribute_option
					 ON (eav_attribute_option_value.option_id = eav_attribute_option.option_id)
					 AND (eav_attribute.attribute_id = eav_attribute_option.attribute_id)
					WHERE eav_attribute.frontend_input  = 'multiselect'
					GROUP BY catalog_product_entity.entity_id
					 , eav_attribute_option.attribute_id");
			$value_res = $query->result();
						
			foreach($value_res as $ab) {
				
				$ent_id = $ab->entity_id;
				$att_id = $ab->attribute_id;
				$opt_id = $ab->option_id;
				$val_id = $ab->value_id;
					
				$query 	= $this->db->query("select value_id, value from catalog_product_entity_varchar where entity_id=$ent_id AND attribute_id=$att_id");
				$row_exist 	= $query->row();
								
				$value_id 	= $row_exist->value_id;
				$value 		= $row_exist->value;
								
				if($value_id) {
										
					if($value) {
						$cat_data_value 	= trim($value.','.$opt_id);
					} else {
						$cat_data_value 	= trim($opt_id);
					}
					
					$str = implode(',',array_unique(explode(',',$cat_data_value)));
					
					$cat_data['value'] 		= $str;
					$key['value_id'] 		= $value_id;
								
					$this->db->update('catalog_product_entity_varchar', $cat_data, $key);
										
					unset($cat_data, $key);
					
				} else {
				
					$var_data['entity_type_id'] = 4;
					$var_data['attribute_id'] 	= $att_id;
					$var_data['store_id'] 		= 0;
					$var_data['entity_id'] 		= $ent_id;
					$var_data['value'] 			= trim($opt_id);
				
					$this->db->insert('catalog_product_entity_varchar', $var_data);
					
					//echo $this->db->last_query().'<br><br>'; 
					unset($var_data);
				}  
			}
			unset($value_res);
        } 
		
		//$this->db->query("delete from catalog_product_index_eav where entity_id in (select distinct entity_id from catalog_product_entity where sku NOT IN (select distinct sku from chain_filter)) and attribute_id IN (select distinct attribute_id from eav_attribute where frontend_label IN (select distinct filter_name from chain_filter)) and attribute_id != 207");
			
			
		//$this->db->query("delete from catalog_product_index_eav_idx where entity_id in (select distinct entity_id from catalog_product_entity where sku NOT IN (select distinct sku from chain_filter)) and attribute_id IN (select distinct attribute_id from eav_attribute where frontend_label IN (select distinct filter_name from chain_filter)) and attribute_id != 207");	
		
		
		redirect('filters/index');
	}
	
	
		 
}

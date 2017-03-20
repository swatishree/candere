<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gold_coin_update_price extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		//$this->load->model('pricingupdate_model');
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		$this->load->library('form_validation');
		
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("gold_coin_update_price/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function submit()
	{ 
		$message_arr = array('');
		 
		
		  
		if (isset($_POST['submit']))
        { 
			 $password 		= trim($_POST['password']); 
			 
			 $gold_update_password 	= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_update_password'));

			 if($password != $gold_update_password){
				$message_arr[] = 'You are not authorised for this action';	
				$this->session->set_flashdata('message_arr', $message_arr);
				redirect('/gold_coin_update_price/index');
			 }	
			 
			 $gold_price_995 		= trim($_POST['gold_price_995']); 
			 $gold_price_999 		= trim($_POST['gold_price_999']); 
			 $gold_price_999_9 		= trim($_POST['gold_price_999_9']); 
			 
			 
			 $sql = "UPDATE  `core_config_data` SET `value` = '".$gold_price_999_9."' WHERE `path` ='systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_gold_price_999_9'";

			$this->db->query($sql);

			$sql = "update `core_config_data` set `value` = '".$gold_price_999."' where `path` = 'systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_gold_price_999'";

			$this->db->query($sql);

			$sql = "update `core_config_data` set `value` = '".$gold_price_995."' where `path` = 'systemfieldsgroupsectioncode/systemfieldsgroupcode/all_products_gold_price'";

			$this->db->query($sql);
			
			
			 $processing_cost_1_gm 	= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_1_gm')); 
			 $processing_cost_2_gm 	= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_2_gm')); 
			 $processing_cost_5_gm 	= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_5_gm')); 
			 $processing_cost_10_gm = trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_10_gm')); 
			 $processing_cost_20_gm = trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_20_gm')); 
			 $processing_cost_50_gm = trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_processing_cost_50_gm')); 
			 $margin 				= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/gold_coin_margin')); 
			 
			 $sql = "insert into gold_coin_price_history(gold_price_995,gold_price_999,gold_price_999_9,processing_cost_1_gm,processing_cost_2_gm,processing_cost_5_gm,processing_cost_10_gm,processing_cost_20_gm,processing_cost_50_gm,margin) values ($gold_price_995,$gold_price_999,$gold_price_999_9,$processing_cost_1_gm,$processing_cost_2_gm,$processing_cost_5_gm,$processing_cost_10_gm,$processing_cost_20_gm,$processing_cost_50_gm,$margin)" ;
		 
			 $this->db->query($sql);
					
			 if(empty($gold_price_995) && empty($gold_price_999) && empty($processing_cost_1_gm) && empty($processing_cost_2_gm) && empty($processing_cost_5_gm) && empty($processing_cost_10_gm)&& empty($processing_cost_20_gm) && empty($processing_cost_50_gm) && empty($margin)){
			 
				return $message_arr;
				redirect('/gold_coin_update_price/index');
			 }
			 
			 $sql = "SELECT catalog_product_entity_int.entity_id AS product_id,
       catalog_product_entity_varchar.value AS weight,
       eav_attribute_option_value.value AS purity,
       catalog_product_entity_varchar_1.value AS name
  FROM    (   (   (   catalog_product_entity_int catalog_product_entity_int
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar
                   ON (catalog_product_entity_int.entity_id =
                          catalog_product_entity_varchar.entity_id))
               INNER JOIN
                  catalog_product_entity_int catalog_product_entity_int_1
               ON (catalog_product_entity_int.entity_id =
                      catalog_product_entity_int_1.entity_id))
           INNER JOIN
              eav_attribute_option_value eav_attribute_option_value
           ON (catalog_product_entity_int_1.value =
                  eav_attribute_option_value.option_id))
       INNER JOIN
          catalog_product_entity_varchar catalog_product_entity_varchar_1
       ON (catalog_product_entity_int.entity_id =
              catalog_product_entity_varchar_1.entity_id)
 WHERE     (catalog_product_entity_varchar_1.attribute_id = 71)
       AND (    (    catalog_product_entity_varchar.attribute_id = 282
                 AND catalog_product_entity_int_1.attribute_id = 286)
            AND (    catalog_product_entity_int.value = 644
                 AND catalog_product_entity_int.attribute_id = 272))" ;
			 
			$results = $this->db->query($sql);
			if($results){
				$result = $results->result_array() ;
				$name = '';
				foreach($result as $value){
					$product_id = $value['product_id'];
					$weight 	= $value['weight'];
					$purity	 	= $value['purity'];
					/************************999.9*******************************/
					if($weight == 1 && $purity == 999.9){
						 $price 	= ((($gold_price_999_9 * $weight) + $processing_cost_1_gm) * (1 + $margin)) ;
					}	
					if($weight == 2 && $purity == 999.9){
						 $price 	= ((($gold_price_999_9 * $weight)+ $processing_cost_2_gm) * (1 + $margin)) ;
					}
					if($weight == 5 && $purity == 999.9){
						$price 	= ((($gold_price_999_9 * $weight) + $processing_cost_5_gm) * (1 + $margin)) ; 
					}
					if($weight == 10 && $purity == 999.9){
						 $price 	= ((($gold_price_999_9 * $weight) + $processing_cost_10_gm) * (1 + $margin)) ;
					}
					if($weight == 20 && $purity == 999.9){
						 $price 	= ((($gold_price_999_9 * $weight) + $processing_cost_20_gm) * (1 + $margin)) ;
					}
					if($weight == 50 && $purity == 999.9){
						  $price 	= ((($gold_price_999_9 * $weight) + $processing_cost_50_gm) * (1 + $margin)) ;
					}
					/************************end 999.9*******************************/
					
					/************************999*******************************/
					if($weight == 1 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_1_gm) * (1 + $margin)) ;
					}	
					if($weight == 2 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_2_gm) * (1 + $margin)) ;
					}
					if($weight == 5 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_5_gm) * (1 + $margin)) ;
					}
					if($weight == 10 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_10_gm) * (1 + $margin)) ;
					}
					if($weight == 20 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_20_gm) * (1 + $margin)) ;
						 
					}
					if($weight == 50 && $purity == 999){
						 $price 	= ((($gold_price_999 * $weight) + $processing_cost_50_gm) * (1 + $margin)) ;
					
					}
					/************************end 999.9*******************************/
					
					/************************999*******************************/
					if($weight == 1 && $purity == 995){
						$price 	= ((($gold_price_995 * $weight) + $processing_cost_1_gm) * (1 + $margin)) ;	
					}	
					if($weight == 2 && $purity == 995){
						$price 	= ((($gold_price_995 * $weight) + $processing_cost_2_gm) * (1 + $margin)) ; 
					}
					if($weight == 5 && $purity == 995){
						 $price 	= ((($gold_price_995 * $weight) + $processing_cost_5_gm) * (1 + $margin)) ;
					}
					if($weight == 10 && $purity == 995){
						 $price 	= ((($gold_price_995 * $weight) + $processing_cost_10_gm) * (1 + $margin)) ;
					}
					if($weight == 20 && $purity == 995){
						 $price 	= ((($gold_price_995 * $weight) + $processing_cost_20_gm) * (1 + $margin)) ;
					}
					if($weight == 50 && $purity == 995){
						$price 	= ((($gold_price_995 * $weight) + $processing_cost_50_gm) * (1 + $margin)) ;
					}
					/************************end 999.9*******************************/
					    
					$this->db->trans_start(); 
					 
					$sql = "update catalog_product_entity_decimal set value = ". ceil($price) ." where entity_id = $product_id and attribute_id = 75" ;
					 
					$this->db->query($sql);
					
					$name .= $value['name'] .' - Updated Price = '. ceil($price) .'<br/>';  
					
					$sql = "update pricing_table_metal_options set price = ". ceil($price) ." where product_id = $product_id and purity = 641" ;
					 
					$this->db->query($sql);
					 
					$this->db->trans_complete(); 	
		  
				}
				$message_arr[] = '<b> '.$name.'</b><br/>';
			}
			/********************************************************/
			$message =  urlencode('995 Price : Rs.'.($gold_price_995 * 10).' , 999 Price : Rs.'.($gold_price_999 * 10).' , 999.9 Price : Rs.'.($gold_price_999_9 * 10));
			
						$phone_no = '8286761405,9920429559,8879235168,8898727239,8976118367,9892451561';

  			  
			//$url = 'http://182.18.143.160/smsnew/api/msgsub.php?tranxid=1215&login=candere&psw=candere123&sender=LM-CANDER&mobile='.$phone_no.'&message='.$message.'&ack=NO';
			
			$url = 'http://esandesh.in/sendsmsv2.asp?user=candere1&password=candere123&sender=CANDER&sendercdma=CANDER&text='.$message.'&PhoneNumber='.$phone_no.'&track=1'; 
			 
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_VERBOSE, true); 
			curl_setopt($ch, CURLOPT_HEADER, true); 
			curl_setopt($ch, CURLOPT_NOBODY, true); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
			curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
			$ret = curl_exec($ch); 
			 
			curl_close($ch); 
        } 
		
		$this->session->set_flashdata('message_arr', $message_arr);
		redirect('/gold_coin_update_price/index');
	}
	  
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
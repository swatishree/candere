<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Candereexport extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('candereexport_model');
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("candereexport/index",$message_arr);
		$this->load->view('templates/footer');
	} 
	 
	public function export()
	{ 
		$message_arr = array('');
		
		$this->load->helper('csv');
		$sql = $this->candere_product_pricing_export();
		$this->load->dbutil(); 
		array_to_csv($sql,'all_products_pricing_'.date('dMy').'.csv'); 
		 
	}
	
	public function export_all_products_with_images()
	{ 
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->export_all_products_with_images_with_default_images();
		$this->load->dbutil(); 
		 
		array_to_csv($sql,'Products_'.date('dMy').'.csv');  
	} 
	
	public function candere_product_pricing_export(){	
 
		
		$sql =	"SELECT pricing_table_metal_options.sku,pricing_table_metal_options.product_id,
       pricing_table_metal_options.price,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar.value AS name
  FROM    (   (   (   pricing_table_metal_options pricing_table_metal_options
                   INNER JOIN
                      eav_attribute_option_value eav_attribute_option_value_1
                   ON (pricing_table_metal_options.purity =
                          eav_attribute_option_value_1.option_id))
               INNER JOIN
                  metal_options_enabled metal_options_enabled
               ON (metal_options_enabled.product_id =
                      pricing_table_metal_options.product_id))
           INNER JOIN
              eav_attribute_option_value eav_attribute_option_value
           ON (metal_options_enabled.metal_id =
                  eav_attribute_option_value.option_id))
       INNER JOIN
          catalog_product_entity_varchar catalog_product_entity_varchar
       ON (metal_options_enabled.product_id =
              catalog_product_entity_varchar.entity_id)
 WHERE (catalog_product_entity_varchar.attribute_id = 71)"; 

		$results = $this->db->query($sql); 
		$result = $results->result_array();
		
		
		$cntr = 1 ;
		$new_array['C00000']['name'] = 'name';
		$new_array['C00000']['sku'] = 'sku';
		$new_array['C00000']['product_id'] = 'product_id';
		$new_array['C00000']['18K'] = '18K'; 
		$new_array['C00000']['14K'] = '14K';
		$new_array['C00000']['9K'] = '9K';
		$new_array['C00000']['22K'] = '22K';
		foreach($result as $counter=>$rslt){
			$arr[$rslt['sku']]['name'] = $rslt['name']; 
			$arr[$rslt['sku']]['sku'] = $rslt['sku'];  
			$arr[$rslt['sku']][$rslt['metal']][$rslt['purity']]['price'] = $rslt['price'];  
			
			$new_array[$rslt['sku']]['name'] = $rslt['name'];
			$new_array[$rslt['sku']]['sku'] = $rslt['sku']; 
			$new_array[$rslt['sku']]['product_id'] = $rslt['product_id']; 
			
			$new_array[$rslt['sku']]['18K'] = $arr[$rslt['sku']][$rslt['metal']]['18K']['price']; 
			
			$new_array[$rslt['sku']]['14K'] = $arr[$rslt['sku']][$rslt['metal']]['14K']['price']; 
			$new_array[$rslt['sku']]['9K'] = $arr[$rslt['sku']][$rslt['metal']]['9K']['price'];  
			$new_array[$rslt['sku']]['22K'] = $arr[$rslt['sku']][$rslt['metal']]['22K']['price'];   
		} 
		 
		return $new_array ;
	}	
	
	
	
	public function export_all_products_with_images_with_default_images(){
		$result_array = array();
		$sql =	"SELECT pricing_table_metal_options.sku,
		pricing_table_metal_options.metal_id,
		pricing_table_metal_options.price,
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
			$result_array[0][5] = 'price'; 
			$result_array[0][6] = 'sku';
			$result_array[0][7] = 'name';
			$result_array[0][8] = 'metal';
			$result_array[0][9] = 'purity';
			$result_array[0][10] = 'image'; 
			$result_array[0][11] = 'price'; 
			$result_array[0][12] = 'sku';
			$result_array[0][13] = 'name';
			$result_array[0][14] = 'metal';
			$result_array[0][15] = 'purity';
			$result_array[0][16] = 'image'; 
			$result_array[0][17] = 'price'; 
			$result_array[0][18] = 'sku';
			$result_array[0][19] = 'name';
			$result_array[0][20] = 'metal';
			$result_array[0][21] = 'purity';
			$result_array[0][22] = 'image'; 
			$result_array[0][23] = 'price';  
			$result_array[0][24] = 'sku';
			$result_array[0][25] = 'name';
			$result_array[0][26] = 'metal';
			$result_array[0][27] = 'purity';
			$result_array[0][28] = 'image'; 
			$result_array[0][29] = 'price';  
			$result_array[0][30] = 'sku';
			$result_array[0][31] = 'name';
			$result_array[0][32] = 'metal';
			$result_array[0][33] = 'purity';
			$result_array[0][34] = 'image'; 
			$result_array[0][35] = 'price';  
			$result_array[0][36] = 'sku';
			$result_array[0][37] = 'name';
			$result_array[0][38] = 'metal';
			$result_array[0][39] = 'purity';
			$result_array[0][40] = 'image'; 
			$result_array[0][41] = 'price'; 
			 
			$result_array[0][42] = 'sku';
			$result_array[0][43] = 'name';
			$result_array[0][44] = 'metal';
			$result_array[0][45] = 'purity';
			$result_array[0][46] = 'image'; 
			$result_array[0][47] = 'price'; 
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
					$result_array[$rslt['product_id']][] = $rslt['price'];  
				}				
			}
		}	 
			//$sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
			//$this->db->query($sql, array(3, 'live', 'Rick')); 
		 
		
		return $result_array ;
	}	
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
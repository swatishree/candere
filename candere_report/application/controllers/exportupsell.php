<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exportupsell extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("exportupsell/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 
		
		
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunction();
		
		
		if(!empty($sql)){
		
				$product_array[$records[0]]['sku'] = 'Sku';    
				$product_array[$records[0]]['name'] = 'Name';  
				$product_array[$records[0]]['related_product_sku_1'] = 'Related Product 1 Sku' ;  
				$product_array[$records[0]]['related_product_name_1'] = 'Related Product 1 Name' ;
				$product_array[$records[0]]['related_product_sku_2'] = 'Related Product 2 Sku' ;  
				$product_array[$records[0]]['related_product_name_2'] = 'Related Product 2 Name' ;
				$product_array[$records[0]]['related_product_sku_3'] = 'Related Product 3 Sku' ;  
				$product_array[$records[0]]['related_product_name_3'] = 'Related Product 3 Name' ;
				$product_array[$records[0]]['related_product_sku_4'] = 'Related Product 4 Sku' ;  
				$product_array[$records[0]]['related_product_name_4'] = 'Related Product 4 Name' ;
				
			foreach($sql as $cntr => $records){
				 
				//$product_array[$records['product_id']][$records['sku']] = $records['name'];
				
				$product_array[$records['product_id']]['sku'] = $records['sku'];    
				$product_array[$records['product_id']]['name'] = $records['name'];  
				$product_array[$records['product_id']]['related_product_sku_'.$cntr] = $records['related_product_sku'];  
				$product_array[$records['product_id']]['related_product_name_'.$cntr] = $records['related_product_name'];
			    
			}
		}
	 
		$this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		//$this->export->to_excel($sql, 'junglee_export'); 	
		array_to_csv($product_array,'related_products_'.date('d-M-y').'.csv'); 
		//$this->load->helper('url'); 
		//redirect('/jungleeexport/index');
	} 
	  
	
	public function myqueryfunction(){	
		 
		$sql =	"SELECT metal_options_enabled.product_id,
       catalog_product_entity_varchar.value AS name,
       pricing_table_metal_options.sku,
       catalog_product_entity_varchar_1.value AS related_product_name,
       catalog_product_entity.sku as related_product_sku
  FROM    (   (   (   (   (   metal_options_enabled metal_options_enabled
                           INNER JOIN
                              catalog_product_link catalog_product_link
                           ON (metal_options_enabled.product_id =
                                  catalog_product_link.product_id))
                       INNER JOIN
                          pricing_table_metal_options pricing_table_metal_options
                       ON     (metal_options_enabled.product_id =
                                  pricing_table_metal_options.product_id)
                          AND (metal_options_enabled.metal_id =
                                  pricing_table_metal_options.metal_id))
                   INNER JOIN
                      catalog_product_entity_int catalog_product_entity_int
                   ON (metal_options_enabled.product_id =
                          catalog_product_entity_int.entity_id))
               INNER JOIN
                  catalog_product_entity_varchar catalog_product_entity_varchar
               ON (metal_options_enabled.product_id =
                      catalog_product_entity_varchar.entity_id))
           INNER JOIN
              catalog_product_entity_varchar catalog_product_entity_varchar_1
           ON (catalog_product_link.linked_product_id =
                  catalog_product_entity_varchar_1.entity_id))
       INNER JOIN
          catalog_product_entity catalog_product_entity
       ON (catalog_product_link.linked_product_id =
              catalog_product_entity.entity_id)
 WHERE     (catalog_product_link.link_type_id = 4)
       AND (catalog_product_entity_varchar_1.attribute_id = 71)
       AND (    (    (    (    (    (    metal_options_enabled.status = 1
                                     AND metal_options_enabled.isdefault = 1)
                                AND catalog_product_entity_int.value = 1)
                           AND catalog_product_entity_int.attribute_id = 96)
                      AND catalog_product_entity_varchar.attribute_id = 71)
                 AND pricing_table_metal_options.isdefault = 1)
            AND pricing_table_metal_options.status = 1)"; 

		$results = $this->db->query($sql);
		$result = $results->result_array();
		return $result ;
	}
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Description_export_update extends CI_Controller  {

	public function __construct()
	{
		parent::__construct();  	
	}
	
	public function index()
	{ 
		$message_arr = array(''); 
		$this->load->view('templates/header'); 
        $this->load->view("description_export_update/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export()
	{  
		$message_arr = array('');
		$this->load->helper('csv');
		$sql = $this->query_to_export_description();
		
		$this->load->dbutil();
		
		query_to_csv($sql,true,'description_update'.date('d-M-y').'.csv'); 
		 
	} 

	public function query_to_export_description()
	{
		$sql =	"SELECT  catalog_product_entity.sku
 , catalog_product_entity_varchar.value AS name
 , GROUP_CONCAT(catalog_category_entity_varchar.value SEPARATOR',') AS category_name
 , catalog_product_entity_text.value AS description
 , catalog_product_entity_text_1.value AS short_description
 , eav_attribute_option_value.value AS product_type
 , IF(catalog_product_entity_int_1.value=1, 'Enabled', 'Disabled') AS status
FROM
 (((((((catalog_product_entity catalog_product_entity
 INNER JOIN
 catalog_product_entity_text catalog_product_entity_text_1
 ON (catalog_product_entity.entity_id = catalog_product_entity_text_1.entity_id))
 INNER JOIN
 catalog_product_entity_text catalog_product_entity_text
 ON (catalog_product_entity.entity_id = catalog_product_entity_text.entity_id))
 INNER JOIN
 catalog_product_entity_int catalog_product_entity_int_1
 ON (catalog_product_entity.entity_id = catalog_product_entity_int_1.entity_id))
 INNER JOIN
 catalog_product_entity_int catalog_product_entity_int
 ON (catalog_product_entity.entity_id = catalog_product_entity_int.entity_id))
 INNER JOIN
 eav_attribute_option_value eav_attribute_option_value
 ON (catalog_product_entity_int.value = eav_attribute_option_value.option_id))
 INNER JOIN
 catalog_product_entity_varchar catalog_product_entity_varchar
 ON (catalog_product_entity.entity_id = catalog_product_entity_varchar.entity_id))
 INNER JOIN
 catalog_category_product catalog_category_product
 ON (catalog_product_entity.entity_id = catalog_category_product.product_id))
 INNER JOIN
 catalog_category_entity_varchar catalog_category_entity_varchar
 ON (catalog_category_product.category_id = catalog_category_entity_varchar.entity_id)
WHERE (catalog_category_entity_varchar.attribute_id  = 41 AND (catalog_product_entity_int_1.attribute_id  = 96 AND (((catalog_product_entity_varchar.attribute_id  = 71 AND catalog_product_entity_text.attribute_id  = 72) AND catalog_product_entity_text_1.attribute_id  = 73) AND catalog_product_entity_int.attribute_id  = 272)))
GROUP BY catalog_product_entity.sku"; 

		$results = $this->db->query($sql); 
		
		return $results;
	}
	
}
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jungleeexport extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('jungleeexport_model');
	}
	 
	public function index()
	{ 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("jungleeexport/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export()
	{ 
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunction();
		$this->load->dbutil();
		 
		//$this->export->to_excel($sql, 'junglee_export'); 	
		query_to_csv($sql,true,'Products_'.date('dMy').'.csv'); 
		//$this->load->helper('url'); 
		//redirect('/jungleeexport/index');
	} 
	
	public function customerorderexport()
	{ 
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->mycustomerorderexportqueryfunction();
		$this->load->dbutil();
		 
		//$this->export->to_excel($sql, 'junglee_export'); 	
		query_to_csv($sql,true,'Customer_order_'.date('dMy').'.csv'); 
		//$this->load->helper('url'); 
		//redirect('/jungleeexport/index');
	} 
	
	public function customerpendingorderexport()
	{ 
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->mycustomerpendingorderexportqueryfunction();
		$this->load->dbutil();
		 
		//$this->export->to_excel($sql, 'junglee_export'); 	
		query_to_csv($sql,true,'Customer_order_'.date('dMy').'.csv'); 
		//$this->load->helper('url'); 
		//redirect('/jungleeexport/index');
	}
	
	public function mycustomerpendingorderexportqueryfunction(){	
		//$this->db->insert('pricingupdate', $pricingupdate);	
		$sql =	"SELECT sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order_address.email,
       sales_flat_order_address.telephone,
       sales_flat_order_address.fax,
       sales_flat_order_address.region,
       sales_flat_order_address.street,
       sales_flat_order_address.city,
       sales_flat_order_address.postcode,
       sales_flat_order_address.country_id AS country
  FROM    sales_flat_order_address sales_flat_order_address
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_address.customer_id =
              sales_flat_order.customer_id)
 WHERE (sales_flat_order.status IN
           ('canceled',
            'cancelled_as_per_customer_reques',
            'cancelled_customer_not_respondin',
            'payment_recieved',
            'fraud',
            'pending',
            'pending_payment',
            'pending_payu_payment'))
GROUP BY sales_flat_order_address.customer_id
ORDER BY sales_flat_order_address.entity_id DESC"; 

		$results = $this->db->query($sql); 
		return $results ;
	}	
	
	
	public function mycustomerorderexportqueryfunction(){	
		//$this->db->insert('pricingupdate', $pricingupdate);	
		$sql =	"SELECT sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order_address.email,
       sales_flat_order_address.telephone,
       sales_flat_order_address.fax,
       sales_flat_order_address.region,
       sales_flat_order_address.street,
       sales_flat_order_address.city,
       sales_flat_order_address.postcode,
       sales_flat_order_address.country_id AS country
  FROM    sales_flat_order_address sales_flat_order_address
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_address.customer_id =
              sales_flat_order.customer_id)
 WHERE (sales_flat_order.status NOT IN
           ('canceled',
            'cancelled_as_per_customer_reques',
            'cancelled_customer_not_respondin',
            'payment_recieved',
            'fraud',
            'pending',
            'pending_payment',
            'pending_payu_payment'))
GROUP BY sales_flat_order_address.customer_id
ORDER BY sales_flat_order_address.entity_id DESC"; 

		$results = $this->db->query($sql); 
		return $results ;
	}	
	
	public function myqueryfunction(){	
		//$this->db->insert('pricingupdate', $pricingupdate);	
		$sql =	"SELECT DISTINCT
       pricing_table_metal_options.sku,
       pricing_table_metal_options.weight,
       pricing_table_metal_options.price,
       catalog_product_entity_varchar.value AS name,
       eav_attribute_option_value.value AS metal,
       eav_attribute_option_value_1.value AS purity,
       catalog_product_entity_varchar_1.value AS url,
       catalog_product_entity_varchar_3.value AS expected_delivery_date,
       catalog_product_entity_varchar_4.value AS width,
       catalog_product_entity_varchar_5.value AS height,
       catalog_product_entity_text.value AS short_description,
       catalog_product_entity_varchar_6.value AS total_weight,
       eav_attribute_option_value_2.value AS product_type
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   metal_options_enabled metal_options_enabled
                                                       INNER JOIN
                                                          catalog_product_entity_varchar catalog_product_entity_varchar_5
                                                       ON (metal_options_enabled.product_id =
                                                              catalog_product_entity_varchar_5.entity_id))
                                                   INNER JOIN
                                                      catalog_product_entity_text catalog_product_entity_text
                                                   ON (metal_options_enabled.product_id =
                                                          catalog_product_entity_text.entity_id))
                                               INNER JOIN
                                                  pricing_table_metal_options pricing_table_metal_options
                                               ON     (metal_options_enabled.product_id =
                                                          pricing_table_metal_options.product_id)
                                                  AND (metal_options_enabled.metal_id =
                                                          pricing_table_metal_options.metal_id))
                                           INNER JOIN
                                              catalog_product_entity_varchar catalog_product_entity_varchar_1
                                           ON (pricing_table_metal_options.product_id =
                                                  catalog_product_entity_varchar_1.entity_id))
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
                              eav_attribute_option_value eav_attribute_option_value_1
                           ON (pricing_table_metal_options.purity =
                                  eav_attribute_option_value_1.option_id))
                       INNER JOIN
                          catalog_product_entity_varchar catalog_product_entity_varchar_3
                       ON (pricing_table_metal_options.product_id =
                              catalog_product_entity_varchar_3.entity_id))
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar_4
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_varchar_4.entity_id))
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
              eav_attribute_option_value_2.option_id)
 WHERE (    (    (    (    catalog_product_entity_varchar_5.attribute_id =
                              165
                       AND catalog_product_entity_text.attribute_id = 73)
                  AND catalog_product_entity_varchar_6.attribute_id = 229)
             AND catalog_product_entity_int.attribute_id = 272)
        AND (    (    (    (    (    (    (    metal_options_enabled.status =
                                                  1
                                           AND metal_options_enabled.isdefault =
                                                  1)
                                      AND pricing_table_metal_options.status =
                                             1)
                                 AND pricing_table_metal_options.isdefault =
                                        1)
                            AND catalog_product_entity_varchar.attribute_id =
                                   71)
                       AND catalog_product_entity_varchar_1.attribute_id = 98)
                  AND catalog_product_entity_varchar_3.attribute_id = 162)
             AND catalog_product_entity_varchar_4.attribute_id = 164))"; 

		$results = $this->db->query($sql);
		$result = $results->result_array();
		return $results ;
	}	
	
	public function exportimages()
	{ 
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunctionimages(); 
		$this->load->dbutil(); 
		array_to_csv($sql,'Default_Images_'.date('dMy').'.csv');  
	} 
	
	public function myqueryfunctionimages(){
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
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunctioncategory(); 
		$this->load->dbutil(); 
		query_to_csv($sql,true,'Default_Category_Products'.date('dMy').'.csv');  
	} 
	
	public function myqueryfunctioncategory(){	
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
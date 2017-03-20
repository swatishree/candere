<div class="messages">
	<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		}
	?>
</div>

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/export_order_details_with_customer_shipping_address">Export All Order with Status and Customer Shipping Address</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/exportorderaffiliate">Export All Order with Affiliates</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/export">Export All Order Items</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/customer_address_with_order_export">Export Customer Address with order Id with products</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/customer_address_with_order_export_without_product">Export Customer Address with order Id without product</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/get_orders_customers_data?price=50000">Export All Processing & Complete Orders with Customer Details price below 50000</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/get_orders_customers_data?price=100000">Export All Processing & Complete Orders with Customer Details price between 50000 and 1,00,000</a></h1> <br>

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/get_orders_customers_data?price=100001">Export All Processing & Complete Orders with Customer Details price above 1,00,000</a></h1> <br>

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/exportorders/get_abandoned_mail_data">Export All Abandoned Mail Sent details</a></h1> <br>  

<h1>Order State Vs Product Type List<br>  <br>  

<?php
	
		$sql =	"SELECT distinct state from sales_order_status_state"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		
		$table = '<table border="1" cellspacing="0" cellpadding="5">';
		
		
		
		$sql = 'SELECT 
				   eav_attribute_option_value.value as label, catalog_product_entity_int.value
			  FROM    catalog_product_entity_int catalog_product_entity_int
				   INNER JOIN
					  eav_attribute_option_value eav_attribute_option_value
				   ON (catalog_product_entity_int.value =
						  eav_attribute_option_value.option_id)
			 WHERE (catalog_product_entity_int.attribute_id = 272)
			GROUP BY eav_attribute_option_value.value'; 

			$results_product_type = $this->db->query($sql);
			 
			$result_product_type = $results_product_type->result_array();
			
			$table .= '<tr>';
			  
			$table .= '<td>Order State</td>';
			
			
			foreach($result_product_type as $product_type){
				
				 
				$table .= '<td align="center">'.$product_type['label'] .'</td>';
			}
			
		foreach($result as $states){
			 
			$sql = 'SELECT 
				   eav_attribute_option_value.value as label, catalog_product_entity_int.value
			  FROM    catalog_product_entity_int catalog_product_entity_int
				   INNER JOIN
					  eav_attribute_option_value eav_attribute_option_value
				   ON (catalog_product_entity_int.value =
						  eav_attribute_option_value.option_id)
			 WHERE (catalog_product_entity_int.attribute_id = 272)
			GROUP BY eav_attribute_option_value.value'; 

			$results_product_type = $this->db->query($sql);
			 
			$result_product_type = $results_product_type->result_array();
			
			$table .= '<tr>';
			  
			$table .= '<td >'.ucwords(str_replace('_',' ',$states['state'])).'</td>';
			
			
			foreach($result_product_type as $product_type){
				
				 
				$sql = 'SELECT count(catalog_product_entity_int.value) as count
						  FROM    (   sales_flat_order_item sales_flat_order_item
								   INNER JOIN
									  catalog_product_entity_int catalog_product_entity_int
								   ON (sales_flat_order_item.product_id =
										  catalog_product_entity_int.entity_id))
							   INNER JOIN
								  sales_flat_order sales_flat_order
							   ON (sales_flat_order.entity_id = sales_flat_order_item.order_id)
						 WHERE     (catalog_product_entity_int.attribute_id = 272)
							   AND (catalog_product_entity_int.value = '.$product_type['value'].')
							   AND (sales_flat_order.state IS NOT NULL) AND (sales_flat_order.state = "'.$states['state'].'")';
					$query = $this->db->query($sql);
					 $result = $query->row_array();
					 $count = $result['count'];
				 
					$table .= '<td align="center">'.$count  .'</td>';
			}
			 
			$table .= '</tr>';
			
			 
		}
		
		$table .= '</table>';
		
		echo $table ;
?>

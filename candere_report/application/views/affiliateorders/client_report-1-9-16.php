<div class="messages">
<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		} 
			
		$sql = 'select distinct state from sales_order_status_state';
		 
		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		
		$result[]['state'] = 'All';
?>
</div>
<br> 
<br>
 <style>
	select#order_status{  width: 150px;  height: 130px;}
 </style>
 
 <script>


 jQuery(function() {
jQuery( "#date_from" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy/mm/dd'
	});

jQuery( "#date_to" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy/mm/dd'
	});
});
</script>

<?php
	$date_from = '';
	$date_to = '';
	$order_status = '';
	if(isset($_POST) && !empty($_POST)){
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to']; 
		$order_status = $_POST['order_status'];  
	}
?>
<div style="margin:0 auto; text-align: center;">
<h1>Select Filter for Affiliate Report</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
		<select name="order_status[]" id="order_status" multiple>
			<?php
				foreach($result as $states){
					$select = '';
					if(isset($_POST) && !empty($_POST)){
						if (in_array($states['state'], $order_status)) {
							 
							$select= 'selected';
						}
					}else{	
						if($states['state'] == 'complete' || $states['state'] == 'processing'){
							$select= 'selected';
						}
					}
			?>
					<option value="<?php echo $states['state'] ;?>" <?php echo $select ; ?>><?php echo ucwords(str_replace('_',' ',$states['state'])); ?></option>
			<?php
				}
			?>
			
		</select>
		 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date From" name='date_from' id='date_from' value="<?php echo $date_from ;?>"> 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date To" name='date_to' id='date_to' value="<?php echo $date_to ;?>"> 
		<br><br><br>
		<input type="submit" name="submit" value="submit">
	</form>
</div>  
<br>  

<?php 
	if(isset($_POST) && !empty($_POST)){
	
	if($_POST['order_status'][0]=='All'){
		$_POST['order_status'] = array('complete','processing','new','pending_payment','closed','canceled','holded','payment_review');
	}
	
	$order_status 	= implode("','",$_POST['order_status']);
	
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
	
	$where = '';
	//if ((strpos($order_status, 'canceled') !== false)  || (strpos($order_status, 'closed') !== false) ){
		$where = 'AND sales_flat_order.base_total_paid > 0';
	//}
		
			
				$sql = "SELECT sales_flat_order.increment_id AS order_id,
						   sales_flat_order.base_grand_total,
						   sales_flat_order.grand_total,
						   sales_flat_order.total_paid,
						   sales_flat_order.order_currency_code,
						   sales_flat_order.base_currency_code,
						   sales_flat_order_address.region,
						   sales_flat_order_address.city,
						   sales_flat_order_address.postcode,
						  sales_flat_order_address.country_id,
						   
						   CONCAT(
							if(sales_flat_order.coupon_code  IS NULL,'',sales_flat_order.coupon_code), 
							if(sales_flat_order.coupon_code2  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code2)), 
                            if(sales_flat_order.coupon_code3  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code3)),
                            if(sales_flat_order.coupon_code4  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code4)),
                            if(sales_flat_order.coupon_code5  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code5))
					        
								)
								AS coupon_code,
                            
							CONCAT(
							if(sales_flat_order.base_coupon_amount IS NULL OR sales_flat_order.base_coupon_amount=0,'', sales_flat_order.base_coupon_amount), 
							if(sales_flat_order.base_coupon_amount2 IS NULL OR sales_flat_order.base_coupon_amount2=0,'', CONCAT(',',sales_flat_order.base_coupon_amount2)),
                            if(sales_flat_order.base_coupon_amount3 IS NULL OR sales_flat_order.base_coupon_amount3=0,'', CONCAT(',',sales_flat_order.base_coupon_amount3)),	 
							if(sales_flat_order.base_coupon_amount4 IS NULL OR sales_flat_order.base_coupon_amount4=0,'', CONCAT(',',sales_flat_order.base_coupon_amount4)),
 							if(sales_flat_order.base_coupon_amount5 IS NULL OR sales_flat_order.base_coupon_amount5=0,'', CONCAT(',',sales_flat_order.base_coupon_amount5))
 							)
                            AS base_coupon_amount,
						   
						   sales_flat_order.affiliate_id,
						   sales_flat_order.affiliate_medium,
						   sales_flat_order.affiliate_source,
						   sales_flat_order_item.product_id,
						   sales_flat_order_item.sku,
						   sales_flat_order_payment.method AS payment_method,
						   sales_order_status.label AS order_status,
						   sales_flat_order_item.base_row_total AS base_item_price,
						   sales_flat_order_item.base_discount_invoiced AS base_discount_invoiced,
						   sales_flat_order_item.base_discount_amount AS base_discount_amount,
						   sales_flat_order_item.product_options,
						   sales_flat_order_item.qty_ordered,
						   sales_flat_order_item.name,
						   sales_flat_order.base_shipping_amount,
						   sales_flat_order_item.product_options,
						   DATE_ADD(sales_flat_order.created_at, INTERVAL '05:30' HOUR_MINUTE) AS created_at
					  FROM    (   (   sales_flat_order sales_flat_order
								   INNER JOIN
									  sales_order_status sales_order_status
								   ON (sales_flat_order.state = sales_order_status.status))
							   INNER JOIN
								  sales_flat_order_item sales_flat_order_item
							   ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
						   INNER JOIN
							  sales_flat_order_payment sales_flat_order_payment
						   ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)						   
					   INNER JOIN sales_flat_order_address sales_flat_order_address 
					   ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
				   
					   
				WHERE (sales_flat_order_address.address_type = 'billing' AND sales_flat_order.state IN ('$order_status') And (sales_flat_order.created_at between '$mysql_date_from' AND '$mysql_date_to') $where) ORDER BY sales_flat_order.entity_id DESC";
		
		 
		 
		$results 	= $this->db->query($sql);
		
		//echo $this->db->last_query();
		
		$result 	= $results->result_array();
		
		//echo '<pre>'; print_r($result); echo '</pre>'; exit;
		 
		if(count($result) > 0){
?>
	 
<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">
	<tr> 
		<th colspan="55">
			<span style="float:left;"><?php echo count($result) ;?> Records Found</span> 
		</th> 
	</tr>
	<tr>
		<th>Order Id</th>
		<th>Product Type</th>
		<th>Gold/Diamond</th>
		<th>SKU</th>
		<th>QTY</th>
		<th>Coupon code</th>
		<th>Coupon amount</th>
		<th>Item Price in INR</th>
		<th>Shipping in INR</th>
		<th>Order Date (Y-M-D)</th>
		<th>Payment Method</th>
		<th>Order Status</th>
		<th>Affiliate</th>
		<th>Affiliate Medium</th>
		<th>Affiliate Source</th>
		<th>City</th>
		<th>Country</th>
		<th>State</th>
		<th>Pincode</th>
		<th>Metal</th>
		<th>Purity</th>
		<th>Metal Weight in Gms</th>
		<th>Total Weight in Gms</th>
		<th>Diamond 1 Clarity</th>
		<th>Diamond 1 Shape</th>
		<th>Diamond 1 Color</th>
		<th>Diamond 1 Type</th>
		<th>Diamond 1 Weight</th>
		<th>Diamond 1 Diamonds</th>		
		<th>Diamond 2 Clarity</th>
		<th>Diamond 2 Shape</th>
		<th>Diamond 2 Color</th>
		<th>Diamond 2 Type</th>
		<th>Diamond 2 Weight</th>
		<th>Diamond 2 Diamonds</th>		
		<th>Diamond 3 Clarity</th>
		<th>Diamond 3 Shape</th>
		<th>Diamond 3 Color</th>
		<th>Diamond 3 Type</th>
		<th>Diamond 3 Weight</th>
		<th>Diamond 3 Diamonds</th>				
		<th>Diamond 4 Clarity</th>
		<th>Diamond 4 Shape</th>
		<th>Diamond 4 Color</th>
		<th>Diamond 4 Type</th>
		<th>Diamond 4 Weight</th>
		<th>Diamond 4 Diamonds</th>		
		<th>Diamond 5 Clarity</th>
		<th>Diamond 5 Shape</th>
		<th>Diamond 5 Color</th>
		<th>Diamond 5 Type</th>
		<th>Diamond 5 Weight</th>
		<th>Diamond 5 Diamonds</th>		
		<th>Diamond 6 Clarity</th>
		<th>Diamond 6 Shape</th>
		<th>Diamond 6 Color</th>
		<th>Diamond 6 Type</th>
		<th>Diamond 6 Weight</th>
		<th>Diamond 6 Diamonds</th>		
		<th>Diamond 7 Clarity</th>
		<th>Diamond 7 Shape</th>
		<th>Diamond 7 Color</th>
		<th>Diamond 7 Type</th>
		<th>Diamond 7 Weight</th>
		<th>Diamond 7 Diamonds</th>	
				
		<th>Gemstone 1 Color</th>	
		<th>Gemstone 1 Shape</th>
		<th>Gemstone 1 Weight</th>		
		<th>Gemstone 1 Type</th>
		<th>Gemstone 1 No of Gemstones</th>	
		<th>Gemstone 2 Color</th>	
		<th>Gemstone 2 Shape</th>
		<th>Gemstone 2 Weight</th>		
		<th>Gemstone 2 Type</th>
		<th>Gemstone 2 No of Gemstones</th>		
		<th>Gemstone 3 Color</th>	
		<th>Gemstone 3 Shape</th>
		<th>Gemstone 3 Weight</th>		
		<th>Gemstone 3 Type</th>
		<th>Gemstone 3 No of Gemstones</th>		
		<th>Gemstone 4 Color</th>	
		<th>Gemstone 4 Shape</th>
		<th>Gemstone 4 Weight</th>		
		<th>Gemstone 4 Type</th>
		<th>Gemstone 4 No of Gemstones</th>		
		<th>Gemstone 5 Color</th>	
		<th>Gemstone 5 Shape</th>
		<th>Gemstone 5 Weight</th>		
		<th>Gemstone 5 Type</th>
		<th>Gemstone 5 No of Gemstones</th>
				
	</tr>
<?php
		foreach($result as $rslt){
		
		$diamond_1_color 			= '';		
						$diamond_1_clarity 			= '';	
						$diamond_1_shape 			= '';
						$diamond_1_setting_type 	= '';
						$diamond_1_weight 			= '';
						$diamond_1_no_of_diamonds 	= '';		
						$diamond_2_color 			= '';
						$diamond_2_clarity 			= '';	
						$diamond_2_shape 			= '';							
						$diamond_2_setting_type 	= '';
						$diamond_2_weight 			= '';
						$diamond_2_no_of_diamonds 	= '';
						$diamond_3_color 			= '';
						$diamond_3_clarity 			= '';	
						$diamond_3_shape 			= '';							
						$diamond_3_setting_type 	= '';
						$diamond_3_weight 			= '';
						$diamond_3_no_of_diamonds 	= '';
						$diamond_4_color 			= '';
						$diamond_4_clarity 			= '';	
						$diamond_4_shape 			= '';							
						$diamond_4_setting_type 	= '';
						$diamond_4_weight 			= '';
						$diamond_4_no_of_diamonds 	= '';
						$diamond_5_color 			= '';
						$diamond_5_clarity 			= '';	
						$diamond_5_shape 			= '';							
						$diamond_5_setting_type 	= '';
						$diamond_5_weight 			= '';
						$diamond_5_no_of_diamonds 	= '';	
						$diamond_6_color 			= '';
						$diamond_6_clarity 			= '';	
						$diamond_6_shape 			= '';							
						$diamond_6_setting_type 	= '';
						$diamond_6_weight 			= '';
						$diamond_6_no_of_diamonds 	= '';	
						$diamond_7_color 			= '';
						$diamond_7_clarity 			= '';	
						$diamond_7_shape 			= '';							
						$diamond_7_setting_type 	= '';
						$diamond_7_weight 			= '';
						$diamond_7_no_of_diamonds 	= '';
		
		
				

				$country 		= Mage::getModel('directory/country')->loadByCode($rslt['country_id']);
				$country_name 	= $country->getName();
					
?>
			<tr>
				<td><?php echo $rslt['order_id'];?></td> 
				<td>
					<?php 
						$product_id 		= $rslt['product_id'];
						$product_options 	= unserialize($rslt['product_options']);
						
						$metal = isset($product_options['info_buyRequest']['extra_options']['Metal']) ? $product_options['info_buyRequest']['extra_options']['Metal'] : '';
						
						$Purity = isset($product_options['info_buyRequest']['extra_options']['Purity']) ? $product_options['info_buyRequest']['extra_options']['Purity'] : '';
						
						$metal_weight = isset($product_options['info_buyRequest']['extra_options']['Metal Weight (Approx)']) ? $product_options['info_buyRequest']['extra_options']['Metal Weight (Approx)'] : '';
									 
			
						$metal_weight = str_replace("Gms"," ",$metal_weight); 
						
						$total_weight_approx = isset($product_options['info_buyRequest']['custom_params']['total_weight_approx']) ? $product_options['info_buyRequest']['custom_params']['total_weight_approx'] : '';
						$total_weight_approx = str_replace("Gms"," ",$total_weight_approx); 
							
						$sql = 'SELECT catalog_product_entity_int.value as type
							  FROM catalog_product_entity_int catalog_product_entity_int
							 WHERE     (catalog_product_entity_int.entity_id = '.$product_id.')
								   AND (catalog_product_entity_int.attribute_id = 277)';
							
						$type 	= $this->db->query($sql)->row();
						
						if($type->type == 0){
							$is_type='Diamond';
						}else{
							$is_type='Gold';
						}
								
						$product_type = 'SELECT eav_attribute_option_value.value as product_type
							  FROM    catalog_product_entity_int catalog_product_entity_int
								   INNER JOIN
									  eav_attribute_option_value eav_attribute_option_value
								   ON (catalog_product_entity_int.value =
										  eav_attribute_option_value.option_id)
							 WHERE     (catalog_product_entity_int.entity_id = '.$product_id.')
								   AND (catalog_product_entity_int.attribute_id = 272)';   
						
						$results 	= $this->db->query($product_type)->row();
						
						//echo ($results->product_type .' ('.$is_type.') ').'<br/>';
						echo $results->product_type;
						
						?>
					</td> 
					<td><?php echo $is_type ?></td>
					
																	
						<?php	
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
							

						$sql =	"SELECT diamond_1,diamond_2,diamond_3,diamond_4,diamond_5,diamond_6,diamond_7 from  diamond_attributes where product_id = $product_id and attribute_id = 263";
						
						$results = $this->db->query($sql);
						$status_result = array_shift($results->result_array());						
														
						$diamond_1 = $status_result['diamond_1'];
						$diamond_2 = $status_result['diamond_2'];
						$diamond_3 = $status_result['diamond_3'];
						$diamond_4 = $status_result['diamond_4'];
						$diamond_5 = $status_result['diamond_5'];
						$diamond_6 = $status_result['diamond_6'];
						$diamond_7 = $status_result['diamond_7'];
											
											
						
						$product_options	=	unserialize($rslt['product_options']);
		
						$diamond_color 		= $product_options['info_buyRequest']['extra_options']['Diamond Color']; 
						$diamond_clarity 	= $product_options['info_buyRequest']['extra_options']['Diamond Clarity'];
												
						if($diamond_color != '' || $diamond_color == NULL) {
											
							if($diamond_1 == 1) {
								$diamond_1_color 			= $diamond_color;
								
								$diamond_1_shape 			= $diamond_1_shape;
								$diamond_1_setting_type 	= $diamond_1_setting_type;
								$diamond_1_weight 			= $diamond_1_weight;
								$diamond_1_no_of_diamonds 	= $diamond_1_no_of_diamonds;
							}else {
								$diamond_1_color 			= '';
								
								$diamond_1_shape 			= '';
								$diamond_1_setting_type 	= '';
								$diamond_1_weight 			= '';
								$diamond_1_no_of_diamonds 	= '';
							}
							
							if($diamond_2 == 1) {
								$diamond_2_color 			= $diamond_color;
								
								$diamond_2_shape 			= $diamond_2_shape;							
								$diamond_2_setting_type 	= $diamond_2_setting_type;
								$diamond_2_weight 			= $diamond_2_weight;
								$diamond_2_no_of_diamonds 	= $diamond_2_no_of_diamonds;
							}else {
								$diamond_2_color 			= '';
								
								$diamond_2_shape 			= '';							
								$diamond_2_setting_type 	= '';
								$diamond_2_weight 			= '';
								$diamond_2_no_of_diamonds 	= '';
							}
							
							if($diamond_3 == 1) {
								$diamond_3_color 			= $diamond_color;
								
								$diamond_3_shape 			= $diamond_3_shape;							
								$diamond_3_setting_type 	= $diamond_3_setting_type;
								$diamond_3_weight 			= $diamond_3_weight;
								$diamond_3_no_of_diamonds 	= $diamond_3_no_of_diamonds;
							}else {
								$diamond_3_color 			= '';
								
								$diamond_3_shape 			= '';							
								$diamond_3_setting_type 	= '';
								$diamond_3_weight 			= '';
								$diamond_3_no_of_diamonds 	= '';
							}
							
							if($diamond_4 == 1) {
								$diamond_4_color 			= $diamond_color;
								
								$diamond_4_shape 			= $diamond_4_shape;							
								$diamond_4_setting_type 	= $diamond_4_setting_type;
								$diamond_4_weight 			= $diamond_4_weight;
								$diamond_4_no_of_diamonds 	= $diamond_4_no_of_diamonds;
							}else {
								$diamond_4_color 			= '';
								
								$diamond_4_shape 			= '';							
								$diamond_4_setting_type 	= '';
								$diamond_4_weight 			= '';
								$diamond_4_no_of_diamonds 	= '';
							}
							
							if($diamond_5 == 1) {
								$diamond_5_color 			= $diamond_color;
								
								$diamond_5_shape 			= $diamond_5_shape;							
								$diamond_5_setting_type 	= $diamond_5_setting_type;
								$diamond_5_weight 			= $diamond_5_weight;
								$diamond_5_no_of_diamonds 	= $diamond_5_no_of_diamonds;
							}else {
								$diamond_5_color 			= '';
								
								$diamond_5_shape 			= '';							
								$diamond_5_setting_type 	= '';
								$diamond_5_weight 			= '';
								$diamond_5_no_of_diamonds 	= '';
							}
							
							if($diamond_6 == 1) {
								$diamond_6_color 			= $diamond_color;
								
								$diamond_6_shape 			= $diamond_6_shape;							
								$diamond_6_setting_type 	= $diamond_6_setting_type;
								$diamond_6_weight 			= $diamond_6_weight;
								$diamond_6_no_of_diamonds 	= $diamond_6_no_of_diamonds;
							}else {
								$diamond_6_color 			= '';
								
								$diamond_6_shape 			= '';							
								$diamond_6_setting_type 	= '';
								$diamond_6_weight 			= '';
								$diamond_6_no_of_diamonds 	= '';
							}	
							
							if($diamond_7 == 1) {
								$diamond_7_color 			= $diamond_color;
								
								$diamond_7_shape 			= $diamond_7_shape;							
								$diamond_7_setting_type 	= $diamond_7_setting_type;
								$diamond_7_weight 			= $diamond_7_weight;
								$diamond_7_no_of_diamonds 	= $diamond_7_no_of_diamonds;
							}else {
								$diamond_7_color 			= '';
								
								$diamond_7_shape 			= '';							
								$diamond_7_setting_type 	= '';
								$diamond_7_weight 			= '';
								$diamond_7_no_of_diamonds 	= '';
							}
						}
						
						if($diamond_clarity != '' || $diamond_clarity == NULL) {
							
							if($diamond_1 == 1) {
								$diamond_1_clarity 			= $diamond_clarity;
							}else {
								$diamond_1_clarity 			= '';
							}							
							if($diamond_2 == 1) {
								$diamond_2_clarity 			= $diamond_clarity;
							}else {
								$diamond_2_clarity 			= '';
							}							
							if($diamond_3 == 1) {
								$diamond_3_clarity 			= $diamond_clarity;
							}else {
								$diamond_3_clarity 			= '';
							}							
							if($diamond_4 == 1) {
								$diamond_4_clarity 			= $diamond_clarity;
							}else {
								$diamond_4_clarity 			= '';
							}							
							if($diamond_5 == 1) {
								$diamond_5_clarity 			= $diamond_clarity;
							}else {
								$diamond_5_clarity 			= '';
							}							
							if($diamond_6 == 1) {
								$diamond_6_clarity 			= $diamond_clarity;
							}else {
								$diamond_6_clarity 			= '';
							}							
							if($diamond_7 == 1) {
								$diamond_7_clarity 			= $diamond_clarity;
							}else {
								$diamond_7_clarity 			= '';
							}
						}
												
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
																
								
							$sql =	"SELECT gemstone_1,gemstone_2,gemstone_3,gemstone_4,gemstone_5 from gemstone_attributes where product_id = $product_id and attribute_id = 262";
														
							$gem_status_results = $this->db->query($sql);
							$gem_status_result = array_shift($gem_status_results->result_array());
															
							$gemstone_1 = $gem_status_result['gemstone_1'];
							$gemstone_2 = $gem_status_result['gemstone_2'];
							$gemstone_3 = $gem_status_result['gemstone_3'];
							$gemstone_4 = $gem_status_result['gemstone_4'];
							$gemstone_5 = $gem_status_result['gemstone_5'];
							
							if($gemstone_1 == 1){ 
								$gemstone_1_total_gemstone = $gemstone_1_total_gemstone ;
								$gemstone_1_type = $gemstone_1_type ;
								$gemstone_1_color = $gemstone_1_color ;
								$gemstone_1_shape = $gemstone_1_shape ;
								$gemstone_1_weight = $gemstone_1_weight ; 
							}else{
								$gemstone_1_total_gemstone = '';
								$gemstone_1_type = '';
								$gemstone_1_color = '';
								$gemstone_1_shape = '';
								$gemstone_1_weight = ''; 
							}
														
							if($gemstone_2 == 1){ 
									$gemstone_2_total_gemstone = $gemstone_2_total_gemstone ;
									$gemstone_2_type = $gemstone_2_type ;
									$gemstone_2_color = $gemstone_2_color ;
									$gemstone_2_shape = $gemstone_2_shape ;
									$gemstone_2_weight = $gemstone_2_weight ; 
								}else{
									$gemstone_2_total_gemstone = '';
									$gemstone_2_type = '';
									$gemstone_2_color = '';
									$gemstone_2_shape = '';
									$gemstone_2_weight = ''; 
								}
								
								if($gemstone_3 == 1){ 
									$gemstone_3_total_gemstone = $gemstone_3_total_gemstone ;
									$gemstone_3_type = $gemstone_3_type ;
									$gemstone_3_color = $gemstone_3_color ;
									$gemstone_3_shape = $gemstone_3_shape ;
									$gemstone_3_weight = $gemstone_3_weight ; 
								}else{
									$gemstone_3_total_gemstone = '';
									$gemstone_3_type = '';
									$gemstone_3_color = '';
									$gemstone_3_shape = '';
									$gemstone_3_weight = ''; 
								}
								
								if($gemstone_4 == 1){ 
									$gemstone_4_total_gemstone = $gemstone_4_total_gemstone ;
									$gemstone_4_type = $gemstone_4_type ;
									$gemstone_4_color = $gemstone_4_color ;
									$gemstone_4_shape = $gemstone_4_shape ;
									$gemstone_4_weight = $gemstone_4_weight ; 
								}else{
									$gemstone_4_total_gemstone = '';
									$gemstone_4_type = '';
									$gemstone_4_color = '';
									$gemstone_4_shape = '';
									$gemstone_4_weight = ''; 
								}
								
								if($gemstone_5 == 1){ 
									$gemstone_5_total_gemstone = $gemstone_5_total_gemstone ;
									$gemstone_5_type = $gemstone_5_type ;
									$gemstone_5_color = $gemstone_5_color ;
									$gemstone_5_shape = $gemstone_5_shape ;
									$gemstone_5_weight = $gemstone_5_weight ; 
								}else{
									$gemstone_5_total_gemstone = '';
									$gemstone_5_type = '';
									$gemstone_5_color = '';
									$gemstone_5_shape = '';
									$gemstone_5_weight = '';
								}
					?>
				
				 
				<?php
						
					if($rslt['sku'] == 'FS0001' || $rslt['sku'] == 'FG0001') {
						$prod_data 				= explode('gms', $rslt['name']);
						$metal_weight 			= $prod_data[0];
						$total_weight_approx 	= $prod_data[0];
						$metal 					= trim(str_replace('coin', '', $prod_data[1]));
						$Purity 				= '995K';
					}
					if($rslt['sku'] == 'GCR5000') {
						$prod_data 				= explode('gm', $rslt['name']);
						$metal_weight 			= $prod_data[0];
						$total_weight_approx 	= $prod_data[0];
						$metal 					= trim(str_replace('coin', '', $prod_data[1]));
						$Purity 				= '995K';
					}
				?>
				
				<td><?php echo $rslt['sku']; ?></td>
				<td><?php echo $rslt['qty_ordered']; ?></td>
				<td><?php echo $rslt['coupon_code']; ?></td>	
				<td><?php echo $rslt['base_coupon_amount']; ?></td>		
				
				<td><?php echo number_format($rslt['base_item_price'] - $rslt['base_discount_amount'] ,2) ;?></td>
				<td><?php echo number_format($rslt['base_shipping_amount'] ,2) ;?></td>
				<td><?php echo date("Y-m-d", strtotime($rslt['created_at'])); ?></td>
				<td><?php echo Mage::getStoreConfig('payment/' .$rslt['payment_method']. '/title'); ?></td>
				<td><?php echo $rslt['order_status'];?></td>				
				<td><?php echo $rslt['affiliate_id'];?></td>				
				<td><?php echo $rslt['affiliate_medium'];?></td>				
				<td><?php echo $rslt['affiliate_source'];?></td>				
				<td><?php echo $rslt['city'];?></td>				
				<td><?php echo $country_name;?></td>				
				<td><?php echo $rslt['region'];?></td>				
				<td><?php echo $rslt['postcode'];?></td>				
						
				<td><?php echo $metal; ?></td>
				<td><?php echo $Purity; ?></td>
				<td><?php echo $metal_weight; ?></td>
				<td><?php echo $total_weight_approx; ?></td>
				
				<td><?php echo $diamond_1_clarity; ?></td>
				<td><?php echo $diamond_1_shape; ?></td>
				<td><?php echo $diamond_1_color; ?></td>
				<td><?php echo $diamond_1_setting_type; ?></td>
				<td><?php echo $diamond_1_weight; ?></td>
				<td><?php echo $diamond_1_no_of_diamonds; ?></td>
				
				<td><?php echo $diamond_2_clarity; ?></td>
				<td><?php echo $diamond_2_shape; ?></td>
				<td><?php echo $diamond_2_color; ?></td>
				<td><?php echo $diamond_2_setting_type; ?></td>
				<td><?php echo $diamond_2_weight; ?></td>
				<td><?php echo $diamond_2_no_of_diamonds; ?></td>
				
				<td><?php echo $diamond_3_clarity; ?></td>
				<td><?php echo $diamond_3_shape; ?></td>
				<td><?php echo $diamond_3_color; ?></td>
				<td><?php echo $diamond_3_setting_type; ?></td>
				<td><?php echo $diamond_3_weight; ?></td>
				<td><?php echo $diamond_3_no_of_diamonds; ?></td>
				
				<td><?php echo $diamond_4_clarity; ?></td>
				<td><?php echo $diamond_4_shape; ?></td>
				<td><?php echo $diamond_4_color; ?></td>
				<td><?php echo $diamond_4_setting_type; ?></td>
				<td><?php echo $diamond_4_weight; ?></td>
				<td><?php echo $diamond_4_no_of_diamonds; ?></td>
				
				<td><?php echo $diamond_5_clarity; ?></td>
				<td><?php echo $diamond_5_shape; ?></td>
				<td><?php echo $diamond_5_color; ?></td>
				<td><?php echo $diamond_5_setting_type; ?></td>
				<td><?php echo $diamond_5_weight; ?></td>
				<td><?php echo $diamond_5_no_of_diamonds; ?></td>
				
				
				<td><?php echo $diamond_6_clarity; ?></td>
				<td><?php echo $diamond_6_shape; ?></td>
				<td><?php echo $diamond_6_color; ?></td>
				<td><?php echo $diamond_6_setting_type; ?></td>
				<td><?php echo $diamond_6_weight; ?></td>
				<td><?php echo $diamond_6_no_of_diamonds; ?></td>
								
				<td><?php echo $diamond_7_clarity; ?></td>
				<td><?php echo $diamond_7_shape; ?></td>
				<td><?php echo $diamond_7_color; ?></td>
				<td><?php echo $diamond_7_setting_type; ?></td>
				<td><?php echo $diamond_7_weight; ?></td>
				<td><?php echo $diamond_7_no_of_diamonds; ?></td>
											
				<td><?php echo $gemstone_1_color; ?></td>
				<td><?php echo $gemstone_1_shape; ?></td>
				<td><?php echo $gemstone_1_weight; ?></td>
				<td><?php echo $gemstone_1_type; ?></td>
				<td><?php echo $gemstone_1_total_gemstone; ?></td>
				
				<td><?php echo $gemstone_2_color; ?></td>
				<td><?php echo $gemstone_2_shape; ?></td>
				<td><?php echo $gemstone_2_weight; ?></td>
				<td><?php echo $gemstone_2_type; ?></td>
				<td><?php echo $gemstone_2_total_gemstone; ?></td>
				
				<td><?php echo $gemstone_3_color; ?></td>
				<td><?php echo $gemstone_3_shape; ?></td>
				<td><?php echo $gemstone_3_weight; ?></td>
				<td><?php echo $gemstone_3_type; ?></td>
				<td><?php echo $gemstone_3_total_gemstone; ?></td>
				
				<td><?php echo $gemstone_4_color; ?></td>
				<td><?php echo $gemstone_4_shape; ?></td>
				<td><?php echo $gemstone_4_weight; ?></td>
				<td><?php echo $gemstone_4_type; ?></td>
				<td><?php echo $gemstone_4_total_gemstone; ?></td>
				
				<td><?php echo $gemstone_5_color; ?></td>
				<td><?php echo $gemstone_5_shape; ?></td>
				<td><?php echo $gemstone_5_weight; ?></td>
				<td><?php echo $gemstone_5_type; ?></td>
				<td><?php echo $gemstone_5_total_gemstone; ?></td>
				
			</tr>
<?php
			}
?>
	</table>
<?php
		}else{
			echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
		}
	}
?>

<?php		
	}
?>   

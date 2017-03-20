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
	
	$order_status 	= implode("','",$_POST['order_status']);
	
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
	
	
		if (strpos($order_status,'canceled') !== false || strpos($order_status,'closed') !== false ) {
			
			$sql = "SELECT sales_flat_order.increment_id AS order_id,
						   sales_flat_order.base_grand_total,
						   sales_flat_order.grand_total,
						   sales_flat_order.total_paid,
						   sales_flat_order.order_currency_code,
						   sales_flat_order.base_currency_code,
						   sales_flat_order_address.region,
						   sales_flat_order_address.city,
						   sales_flat_order_address.postcode,
						   sales_flat_order_address.firstname,
						   sales_flat_order_address.lastname,
						   sales_flat_order_item.product_id,
						   sales_flat_order_item.sku,
						   sales_order_status.label AS order_status,
						   sales_flat_order_item.base_row_total AS base_item_price,
						   sales_flat_order_item.base_discount_invoiced AS base_discount_invoiced,
						   sales_flat_order_item.base_discount_amount AS base_discount_amount,
						   sales_flat_order_item.product_options,
						   sales_flat_order_item.qty_ordered,
						   sales_flat_order_item.name,
						   sales_flat_order_item.description,
						   sales_flat_order.base_shipping_amount,
						   sales_flat_order_item.product_options,
						   DATE_ADD(sales_flat_creditmemo.created_at, INTERVAL '05:30' HOUR_MINUTE) AS created_at
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
				   
						   INNER JOIN
							 sales_flat_creditmemo sales_flat_creditmemo
							 ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
					 WHERE (sales_flat_order_address.address_type = 'billing' AND sales_flat_order.state IN ('canceled','closed') And (sales_flat_creditmemo.created_at between '$mysql_date_from' AND '$mysql_date_to')) ORDER BY sales_flat_order.entity_id DESC";
		
		} else {
			
				$sql = "SELECT sales_flat_order.increment_id AS order_id,
						   sales_flat_order.base_grand_total,
						   sales_flat_order.grand_total,
						   sales_flat_order.total_paid,
						   sales_flat_order.order_currency_code,
						   sales_flat_order.base_currency_code,
						   sales_flat_order_address.region,
						   sales_flat_order_address.city,
						   sales_flat_order_address.postcode,
						   sales_flat_order_address.firstname,
						   sales_flat_order_address.lastname,
						   sales_flat_order_item.product_id,
						   sales_flat_order_item.sku,
						   sales_flat_order_item.additional_data,
						   sales_order_status.label AS order_status,
						   sales_flat_order_item.base_row_total AS base_item_price,
						   sales_flat_order_item.base_discount_invoiced AS base_discount_invoiced,
						   sales_flat_order_item.base_discount_amount AS base_discount_amount,
						   sales_flat_order_item.product_options,
						   sales_flat_order_item.qty_ordered,
						   sales_flat_order_item.name,
						   sales_flat_order.base_shipping_amount,
						   sales_flat_order_item.product_options,
						   sales_flat_order_item.description,
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
				   
					   
				WHERE (sales_flat_order_address.address_type = 'billing' AND sales_flat_order.state IN ('$order_status') And (sales_flat_order.created_at between '$mysql_date_from' AND '$mysql_date_to')) ORDER BY sales_flat_order.entity_id DESC";
		}
		 
		 
		$results 	= $this->db->query($sql);
		
		//echo $this->db->last_query(); exit;
		
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
		<th>SKU</th>
		<th>QTY</th>
		<th>Item Price in INR</th>
		
		<th>Order Date (Y-M-D)</th>
		<th>Order Status</th>
		<th>City</th>
		<th>Region</th>
		<th>Pincode</th>
		<th>Metal</th>
		<th>Purity</th>
		<th>Metal Weight in Gms</th>
		<th>Total Weight in Gms</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Customization</th>
		<th>Size</th>
				
	</tr>
<?php
		foreach($result as $rslt){
		
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
						
						$additional_options = $product_options['additional_options'];
						
						$ring_size = '';
						if($additional_options) {
							foreach($additional_options as $row) {
															
								if($row['label'] == 'Ring Size') {
									$ring_size = str_replace('&nbsp;', '&nbsp;&nbsp;', ($row['value']));
								}
									
								if($row['label'] == 'Bangle Size') {
									$ring_size = str_replace('&nbsp;', '&nbsp;&nbsp;', ($row['value']));
								}	

								if($row['label'] == 'Kada Size') {
									$ring_size = str_replace('&nbsp;', '&nbsp;&nbsp;', ($row['value']));
								}	
									
							}
						}
						
									 
			
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
						
						echo ($results->product_type .' ('.$is_type.') ').'<br/>';
					?>
				</td> 
				 
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
				
				
				<td><?php echo number_format($rslt['base_item_price'] - $rslt['base_discount_amount'] ,2) ;?></td>
				
				<td><?php echo date("Y-m-d", strtotime($rslt['created_at'])); ?></td>
				<td><?php echo $rslt['order_status'];?></td>				
				<td><?php echo $rslt['city'];?></td>				
				<td><?php echo $rslt['region'];?></td>				
				<td><?php echo $rslt['postcode'];?></td>				
						
				<td><?php echo $metal; ?></td>
				<td><?php echo $Purity; ?></td>
				<td><?php echo $metal_weight; ?></td>
				<td><?php echo $total_weight_approx; ?></td>
				<td><?php echo $rslt['firstname']; ?></td>
				<td><?php echo $rslt['lastname']; ?></td>
				<td width="50px"><?php echo $rslt['description']; ?></td>
				<td width="50px"><?php echo $ring_size; ?></td>
				
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

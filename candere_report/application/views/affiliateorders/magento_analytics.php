

<div style="margin:20 auto; text-align: center;">
<h1>Magneto Analytics</h1>
	
<?php
	$date_from 		= '';
	$date_to 		= '';
	$order_status 	= '';
	if(isset($_POST) && !empty($_POST)){
		$date_from 		= $_POST['date_from'];
		$date_to 		= $_POST['date_to']; 
		$order_status 	= $_POST['order_status'];  
	}
?>

	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
		<input type="text" required placeholder="Date From" name='date_from' id='date_from' value="<?php echo $date_from ;?>"> 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date To" name='date_to' id='date_to' value="<?php echo $date_to ;?>"> 
		<br><br><br>
		<input type="submit" name="submit" value="submit">
	</form>
</div>  
<br> 

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
	
	if(isset($_POST) && !empty($_POST)){ ?>
	
		<table border="1" cellpadding="5" cellspacing="0" style="margin:40 auto; text-align: center;">
			<tr>
				<th>Campaign</th>		
				<th>Affiliate</th>
				<th>Publisher</th> 
				<th>IP Address</th> 
				<th>City</th> 
				<th>State</th> 
				<th>Country</th> 
				<th>Pincode</th> 
				<th>Product Type</th> 
				<th>Price Range</th> 
				<th>SKU</th>
				<th>Updated At</th>
				<th>reserved_order_id</th>
			</tr>	
	
	<?php
	
		$date_from 		= strtotime($_POST['date_from']);
		$date_to 		= strtotime($_POST['date_to']);
		 
		$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
		$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
		 
		if($date_from > $date_to){
			echo 'date from should be less than date to';
		}else{
			$sql = "SELECT sales_flat_quote.remote_ip,
				   sales_flat_quote_address.city,
				   sales_flat_quote_address.region,
				   sales_flat_quote_address.postcode,
				   sales_flat_quote_address.country_id,
				   sales_flat_quote_address.telephone,
				   sales_flat_quote_item.sku,
				   sales_flat_quote_item.product_id,
				   sales_flat_quote_item.name,
				   sales_flat_quote.updated_at,
				   sales_flat_quote.affiliate_id,
				   sales_flat_quote.affiliate_source,
				   sales_flat_quote.affiliate_medium,
				   sales_flat_quote.checkout_method,
				   sales_flat_quote.customer_id,
				   sales_flat_quote.customer_firstname,
				   sales_flat_quote.customer_lastname,
				   sales_flat_quote.customer_email,
				   sales_flat_quote.reserved_order_id,
				   sales_flat_quote_item.base_row_total
			  FROM    (   sales_flat_quote_address sales_flat_quote_address
					   INNER JOIN
						  sales_flat_quote sales_flat_quote
					   ON (sales_flat_quote_address.quote_id = sales_flat_quote.entity_id))
				   INNER JOIN
					  sales_flat_quote_item sales_flat_quote_item
				   ON (sales_flat_quote_item.quote_id = sales_flat_quote.entity_id) where sales_flat_quote.updated_at between '$mysql_date_from' AND '$mysql_date_to' order by sales_flat_quote.updated_at desc";
				 
					$type_results 		= $this->db->query($sql);
					$type_result 		= $type_results->result_array();
						
					foreach($type_result as $row) {
					
						$customer_firstname 	= $row['customer_firstname'];
						$customer_lastname 		= $row['customer_lastname'];
						$customer_email 		= $row['customer_email'];
						$remote_ip 				= $row['remote_ip'];
						$city 					= $row['city'];
						$region 				= $row['region'];
						$postcode 				= $row['postcode'];
						$country_id 			= $row['country_id'];
						$sku 					= $row['sku'];
						$base_row_total 		= $row['base_row_total'];
						$affiliate_id 			= $row['affiliate_id'];
						$affiliate_source 		= $row['affiliate_source'];
						$affiliate_medium 		= $row['affiliate_medium'];
						$product_id 			= $row['product_id'];
						$updated_at 			= $row['updated_at'];
						$reserved_order_id 		= $row['reserved_order_id'];
						
			
						$query2 = $this->db->query("SELECT eav_attribute_option_value.value as product_type
			  FROM    (   eav_attribute_option eav_attribute_option
					   INNER JOIN
						  eav_attribute_option_value eav_attribute_option_value
					   ON (eav_attribute_option.option_id =
							  eav_attribute_option_value.option_id))
				   INNER JOIN
					  catalog_product_entity_int catalog_product_entity_int
				   ON (catalog_product_entity_int.value = eav_attribute_option.option_id)
			 WHERE (catalog_product_entity_int.attribute_id = 272 AND catalog_product_entity_int.entity_id = $product_id ) ");

			$row 			= $query2->row();
			$product_type 	= $row->product_type;					
	?>
							
					<tr>
						<td><?php echo $affiliate_id;?></td> 
						<td><?php echo $affiliate_source;?></td> 
						<td><?php echo $affiliate_medium;?></td> 
						<td><?php echo $remote_ip;?></td> 
						<td><?php echo $city;?></td> 
						<td><?php echo $region;?></td> 
						<td><?php echo $country_id;?></td> 
						<td><?php echo $postcode;?></td> 
						<td><?php echo $product_type;?></td> 
						<td><?php echo $base_row_total;?></td> 
						<td><?php echo $sku;?></td> 
						<td><?php echo $updated_at;?></td>
						<td><?php echo $reserved_order_id;?></td>
					</tr>
			<?php  }  
		}
	}
?>			
		
</table>

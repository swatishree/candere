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
	
	//echo '<pre>'; print_r($_POST['order_status']);	echo '</pre>'; exit;
	
	
	
	$order_status 	= implode("','",$_POST['order_status']);
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	
	
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
		 
		 $sql = "SELECT sales_flat_order.increment_id AS order_id,
				   sales_flat_order.base_grand_total,
				   sales_flat_order.base_total_paid,
				   sales_flat_order.grand_total,
				   sales_flat_order.total_paid,
				   sales_flat_order.order_currency_code,
				   sales_flat_order.base_currency_code,
				   sales_flat_order.affiliate_id, 
				   sales_flat_order.customer_firstname, 
				   sales_flat_order.customer_lastname, 
				   sales_flat_order.customer_email, 
				   sales_flat_order.state, 
				   sales_flat_order_address.telephone,
				   sales_flat_order_address.city,
				   GROUP_CONCAT(sales_flat_order_item.sku SEPARATOR',') AS sku,				  			
				   GROUP_CONCAT(sales_flat_order_item.product_id SEPARATOR',') AS product_id,
				   
				   CONCAT(
						if(sales_flat_order.coupon_code  IS NULL,'',sales_flat_order.coupon_code), 
						if(sales_flat_order.coupon_code2  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code2)), 
						if(sales_flat_order.coupon_code3  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code3)),
						if(sales_flat_order.coupon_code4  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code4)),
						if(sales_flat_order.coupon_code5  IS NULL,'',CONCAT(',',sales_flat_order.coupon_code5))
					) AS coupon_code,
								
				   DATE_ADD(sales_flat_order.created_at, INTERVAL '05:30' HOUR_MINUTE)
          AS created_at,
				   sales_flat_order_payment.method AS payment_method,
				   sales_order_status.label as order_status
			  FROM    (   sales_flat_order sales_flat_order
					   INNER JOIN
						  sales_order_status sales_order_status
					   ON (sales_flat_order.status = sales_order_status.status))
				   INNER JOIN
					 sales_flat_order_payment sales_flat_order_payment
				   ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
				   INNER JOIN
                  sales_flat_order_item sales_flat_order_item
					   ON (sales_flat_order.entity_id =
							  sales_flat_order_item.order_id)
				INNER JOIN
			 sales_flat_order_address sales_flat_order_address
			 ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
				   where sales_flat_order_address.address_type = 'billing' AND sales_flat_order.state in ('$order_status') And (sales_flat_order.created_at between '$mysql_date_from' AND '$mysql_date_to')
				    GROUP BY sales_flat_order.increment_id
			ORDER BY sales_flat_order.entity_id DESC";
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		 
		 
		if(count($result) > 0){
		 
?>
	 
<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">
	<tr> 
		<th colspan="13">
			<span style="float:left;"><?php echo count($result) ;?> Records Found</span> 
		</th> 
	</tr>
	<tr>
		<th>Order Id</th>
		<th>Product Type</th>
		<th>SKU</th>		
		<th>Grand Total(Base Currency)</th>
		<th>Grand Total Paid(Base Currency)</th>
		<th>Grand Total(Order Currency)</th>
		<th>Grand Total Paid(Order Currency)</th>
		<th>Coupon Code</th>
		<th>Affiliate Id</th>
		<th>Ordered Date (Y-M-D)</th>
		<th>Payment Method</th>		
		<th>Firstname</th>
		<th>Lastname</th>
		<th>Telephone</th>
		<th>Email Id</th>
		<th>City</th>
		<th>order_status</th>
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['order_id'];?></td> 
				<td>
					<?php 
						$product_id = explode(',',$rslt['product_id']);
						
						foreach($product_id as $ids){
							
							$sql = 'SELECT catalog_product_entity_int.value as type
								  FROM catalog_product_entity_int catalog_product_entity_int
								 WHERE     (catalog_product_entity_int.entity_id = '.$ids.')
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
								 WHERE     (catalog_product_entity_int.entity_id = '.$ids.')
									   AND (catalog_product_entity_int.attribute_id = 272)';   
							
							$results 	= $this->db->query($product_type)->row();
							
							echo ($results->product_type .' ('.$is_type.') ').'<br/>';
						}
							
						 
					?>
				</td> 
				<td><?php echo $rslt['sku']?></td>
				<td><?php echo number_format($rslt['base_grand_total'],2);?></td>
				<td><?php echo $rslt['base_currency_code'].' '.number_format($rslt['base_total_paid'],2);?></td> 
				<td><?php echo $rslt['order_currency_code'].' '.number_format($rslt['grand_total'],2);?></td> 
				<td><?php echo $rslt['order_currency_code'].' '.number_format($rslt['total_paid'],2);?></td> 
				<td><?php echo $rslt['coupon_code']?></td> 
				<td><?php echo $rslt['affiliate_id'];?></td> 
				<td><?php echo $rslt['created_at'];?></td>
				<td><?php echo Mage::getStoreConfig('payment/' .$rslt['payment_method']. '/title'); ?></td>
				
				<td><?php echo $rslt['customer_firstname'];?></td>
				<td><?php echo $rslt['customer_lastname'];?></td>
				<td><?php echo $rslt['telephone'];?></td>
				<td><?php echo $rslt['customer_email'];?></td>
				<td><?php echo $rslt['city'];?></td>
				<td><?php echo $rslt['state'];?></td>
				
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

 


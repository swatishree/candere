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
		 $sql ="SELECT DISTINCT sales_flat_order.state,
                sales_flat_order_address.firstname,
                sales_flat_order_address.lastname,
                sales_flat_order_address.email,
                sales_flat_order_address.region,
                sales_flat_order_address.postcode,
                sales_flat_order_address.city,
                sales_flat_order_address.telephone,
                sales_flat_order_address.country_id,
                sales_flat_order_item.name,
                sales_flat_order_item.product_id,
                sales_flat_order_item.sku,
                sales_flat_order_item.base_price,
                sales_flat_order.increment_id,
                sales_flat_order_item.product_options
  FROM    (   sales_flat_order_address sales_flat_order_address
           INNER JOIN
              sales_flat_order sales_flat_order
           ON (sales_flat_order_address.parent_id =
                  sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_order_item sales_flat_order_item
       ON (sales_flat_order_item.order_id = sales_flat_order.entity_id)
 WHERE (sales_flat_order_address.address_type = 'billing' and sales_flat_order.created_at between '$mysql_date_from' and '$mysql_date_to')
GROUP BY sales_flat_order_address.email";

		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		
		//echo '<pre>'; print_r($result); echo '</pre>'; exit;
		 
		if(count($result) > 0){
		 
?>
	 
<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">
	<tr> 
		<th colspan="13">
			<span style="float:left;"><?php echo count($result) ;?> Records Found</span> 
		</th> 
	</tr>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Phone Number</th>
		<th>Lead Source</th>
		<th>Notes</th>
		<th>Lead Stage</th>
		<th>Address 1</th>
		<th>Address 2</th>
		<th>City</th>
		<th>State</th>
		<th>Country</th>
		<th>Zip</th>
		<th>Owner</th>
		<th>SKU</th>
		<th>Product Name</th>
		<th>Order Id</th>
		<th>Metal</th>
		<th>Product Type</th>
		<th>Product Value</th>
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['firstname'];?></td> 
				<td><?php echo $rslt['lastname']?></td>
				<td><?php echo $rslt['email']?></td>
				<td><?php echo $rslt['telephone']?></td>
				<td><?php echo '' ?></td>
				<td><?php echo '' ?></td>
				<td><?php echo '' ?></td>
				<td><?php echo '1' ?></td>
				<td><?php echo '2' ?></td>
				<td><?php echo $rslt['city'] ?></td>
				<td><?php echo $rslt['region'] ?></td>
				<td><?php echo $rslt['country_id'] ?></td>
				<td><?php echo $rslt['postcode'] ?></td>
				<td><?php echo 'owner' ?></td>
				<td><?php echo $rslt['sku'] ?></td>
				<td><?php echo $rslt['name'] ?></td>
				<td><?php echo $rslt['increment_id'] ?></td>
				<td><?php echo 'type' ?></td>
				<td><?php echo $rslt['base_price'] ?></td>
				
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

 


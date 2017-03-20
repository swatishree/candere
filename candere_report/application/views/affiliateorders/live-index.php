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
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from); 
	$mysql_date_to = date('Y-m-d',$date_to); 
	 
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
				   
				   where sales_flat_order.state in ('$order_status') And (sales_flat_order.created_at between '$mysql_date_from' AND '$mysql_date_to')
			ORDER BY sales_flat_order.entity_id DESC";
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		if(count($result) > 0){
?>
	 
<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">
	<tr>
		<th>Order Id</th>
		<th>Grand Total(Base Currency)</th>
		<th>Grand Total Paid(Base Currency)</th>
		<th>Grand Total(Order Currency)</th>
		<th>Grand Total Paid(Order Currency)</th>
		<th>Affiliate Id</th>
		<th>Oredered Date (Y-M-D)</th>
		<th>Payment Method</th>
		<th>Order Status</th>
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['order_id'];?></td> 
				<td><?php echo $rslt['base_currency_code'].' '.number_format($rslt['base_grand_total'],2);?></td>
				<td><?php echo $rslt['base_currency_code'].' '.number_format($rslt['base_total_paid'],2);?></td> 
				<td><?php echo $rslt['order_currency_code'].' '.number_format($rslt['grand_total'],2);?></td> 
				<td><?php echo $rslt['order_currency_code'].' '.number_format($rslt['total_paid'],2);?></td> 
				<td><?php echo $rslt['affiliate_id'];?></td> 
				<td><?php echo $rslt['created_at'];?></td>
				<td><?php echo Mage::getStoreConfig('payment/' .$rslt['payment_method']. '/title'); ?></td>
				<td><?php echo $rslt['order_status'];?></td>
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

 


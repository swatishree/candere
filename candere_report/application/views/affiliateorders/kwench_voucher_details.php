
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
<h1>Kwench Voucher Details</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
		
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
	
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
		 
		 $sql = "SELECT DISTINCT salesrule_coupon.code,
                salesrule_coupon.times_used,
                salesrule_coupon.created_at,
                salesrule.name,
                salesrule.discount_amount
  FROM    salesrule_coupon salesrule_coupon
       INNER JOIN
          salesrule salesrule
       ON (salesrule_coupon.rule_id = salesrule.rule_id)
 WHERE (salesrule_coupon.code LIKE 'KW%' and salesrule_coupon.created_at between '$mysql_date_from' AND '$mysql_date_to') ";
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
		<th>Code</th>
		<th>Times used</th>		
		<th>Name</th>
		<th>Coupon amount</th>
		<th>Created at</th>		
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['code'];?></td> 				 
				<td><?php echo $rslt['times_used']?></td>
				<td><?php echo $rslt['name']?></td> 
				<td><?php echo $rslt['discount_amount']?></td> 
				<td><?php echo $rslt['created_at'];?></td>				
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

 


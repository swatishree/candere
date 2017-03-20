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
<br> 
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
	$date_from = '';
	$date_to = ''; 
	if(isset($_POST) && !empty($_POST)){
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];  
		
		 
	}
?>
<div style="margin:0 auto; text-align: center;">
<h1>Select Filter for Customer Registration Report</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
		 
		<select name="is_verified[]" id="is_verified" multiple>
			 
			<option value="0" selected>Not Verified</option>
			<option value="1" selected>Verified</option>
			 
			
		</select>
		 
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
	$is_verified 	= implode(",",$_POST['is_verified']);
	 
	 
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
		 
		$sql = "SELECT   entity_id,email,is_verified,affiliate_id,affiliate_term,affiliate_medium,affiliate_content,affiliate_campaign ,DATE_ADD(customer_entity.created_at, INTERVAL '05:30' HOUR_MINUTE) AS created_at ,DATE_ADD(customer_entity.updated_at, INTERVAL '05:30' HOUR_MINUTE) as updated_at
          
			  FROM    customer_entity customer_entity 
				   where is_verified in ($is_verified) And (customer_entity.created_at between '$mysql_date_from' AND '$mysql_date_to') 
			ORDER BY  entity_id DESC";
			
			 
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		 
		 
		if(count($result) > 0){
		
?>
	 
<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">
	<tr> 
		<th colspan="10">
			<span style="float:left;"><?php echo count($result) ;?> Records Found</span> 
		</th> 
	</tr>
	<tr>
		<th>Customer Id</th>
		<th>Email</th>
		<th>Is Verified</th>
		<th>Affiliate Source</th>
		<th>Affiliate Term</th>
		<th>Affiliate Medium</th> 
		<th>Affiliate Content</th>
		<th>Affiliate Campaign</th>
		<th>Created At</th>
		<th>Updated At</th>
	</tr>
<?php
			foreach($result as $rslt){
?> 
			<tr>
				<td><?php echo $rslt['entity_id'];?></td>  
				<td><?php echo $rslt['email'] ?></td> 
				<td>
					<?php 
						if($rslt['is_verified'] == 0){
							echo 'Not Verified';
						}else{
							echo 'Verified';
						}
					?>
				</td> 
				<td><?php echo $rslt['affiliate_id'] ?></td> 
				<td><?php echo $rslt['affiliate_term'] ?></td> 
				<td><?php echo $rslt['affiliate_medium'] ?></td> 
				<td><?php echo $rslt['affiliate_content'] ?></td> 
				<td><?php echo $rslt['affiliate_campaign'] ?></td> 
				<td><?php echo $rslt['created_at'] ?></td> 
				<td><?php echo $rslt['updated_at'] ?></td> 
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

 


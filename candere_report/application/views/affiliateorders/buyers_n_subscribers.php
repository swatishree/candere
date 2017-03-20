<div class="messages">
<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		} 
			
		$sql = 'select distinct flag from customer_queries';
		 
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
	$user_type = '';
	if(isset($_POST) && !empty($_POST)){
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to']; 
		$user_type = $_POST['user_type']; 
		
		 
	}
?>
<div style="margin:0 auto; text-align: center;">
<h1>Buyers and subscribers report</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo base_url().'index.php/';?>affiliateorders/download/">
		<select name="user_type" id="user_type">			
			<option value="Buyers" <?php if('Buyers'==$user_type) echo 'selected="selected"' ; ?>>Buyers</option>
			<option value="Subscribers" <?php if('Subscribers'==$user_type) echo 'selected="selected"' ; ?>>Subscribers</option>			
		</select>
		 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date From" name='date_from' id='date_from'> 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date To" name='date_to' id='date_to'> 
		<br><br><br>
		<input type="submit" name="submit" value="submit">
	</form>
</div>  
<br>  


<?php 
	if(isset($_POST) && !empty($_POST)){
	
	$user_type 	= $_POST['user_type'];
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to)
	{
		echo 'date from should be less than date to';
	}
	else
	{
		if($user_type=='Buyers')
		{			
		 $sql = "select Distinct b.email, b.firstname, b.lastname, b.region, b.postcode, a.state, a.base_grand_total, a.created_at ,b.telephone, b.city, b.country_id 
		 from 
		 sales_flat_order a inner join sales_flat_order_address b 
		 on a.entity_id = b.parent_id 
		
		 where b.address_type = 'billing'
		 and  a.created_at between '$mysql_date_from' AND '$mysql_date_to' group by b.email ";
		
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
				<th>Email</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Region</th>
				<th>Postcode</th>
				<th>State</th>
				<th>Base grand total</th>
				<th>Telephone</th>
				<th>City</th>				 
				<th>Country name</th>			 
			</tr>
		<?php
					foreach($result as $rslt){
		?>
					<tr>
						<td><?php echo $rslt['email'];?></td> 
						<td><?php echo $rslt['firstname'];?></td> 
						<td><?php echo $rslt['lastname'];?></td> 
						<td><?php echo $rslt['region'];?></td> 
						<td><?php echo $rslt['postcode'];?></td> 
						<td><?php echo $rslt['state'];?></td> 
						<td><?php echo $rslt['base_grand_total'];?></td> 
						<td><?php echo $rslt['telephone'];?></td> 
						<td><?php echo $rslt['city'];?></td> 
					 
						<td><?php echo $country_name=Mage::app()->getLocale()->getCountryTranslation($rslt['country_id']); ?></td> 
						 
					</tr>
		<?php
					}
		?>
			</table>
<?php
		}
		else
		{
			echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
		}
	}
	
	

	if($user_type=='Subscribers')
	{
		
		$sql = "Select subscriber_email,subscriber_status,subscription_date from newsletter_subscriber where subscriber_status=1 and subscription_date between '$mysql_date_from' AND '$mysql_date_to' " ;
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
		<th>subscriber_email</th>
		 
	 
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['subscriber_email'];?></td> 
				 
				 
			</tr>
<?php
			}
?>
	</table>
<?php
		}
		else
		{
			echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
		}
				
	}
		
	}
	 
?>

<?php		
	}
?>   

 


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
	$order_status = '';
	if(isset($_POST) && !empty($_POST)){
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to']; 
		//$order_status = $_POST['order_status']; 
		
		 
	}
?>
<div style="margin:0 auto; text-align: center;">
<h1>Lead Activity</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
	 
		 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date From" name='date_from' id='date_from' value="<?php echo $date_from ;?>"> 
		&nbsp;&nbsp;
		<input type="text" required placeholder="Date To" name='date_to' id='date_to' value="<?php echo $date_to ;?>"> 
		<br><br><br>
		<input type="submit" name="submit" value="submit">
		<button type="submit" name="camper" formaction="<?php echo base_url().'index.php/';?>affiliateorders/download1/">Download</button>
	</form>
</div>  
<br>  


<?php 
	if(isset($_POST) && !empty($_POST)){
	
 
	
	//echo '<pre>'; print_r($_POST['order_status']);	echo '</pre>'; exit;
	
	
	
 	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	
	
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
		 
		 $sql = "SELECT * from leadsquared where LastVisitDate between '$mysql_date_from' AND '$mysql_date_to'
				    
			ORDER BY LastVisitDate  DESC";
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
		<th>Id</th>
		<th>EmailAddress</th>
		<th>FirstName</th>		
		<th>LastName</th>
		<th>Phone</th>
		<th>Source</th>
		<th>ProspectStage</th>
		<th>PageViewsPerVisit</th>
		<th>AvgTimePerVisit</th>
		<th>OwnerIdName</th>
		<th>CreatedOn</th>
		<th>LastVisitDate</th>		
		 
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['id'];?></td> 
			 
				
				<td><?php echo $rslt['EmailAddress'];?></td>
				<td><?php echo $rslt['FirstName'];?></td>
				<td><?php echo $rslt['LastName'];?></td>
				<td><?php echo $rslt['Phone'];?></td>
				<td><?php echo $rslt['Source'];?></td>
				<td><?php echo $rslt['ProspectStage'];?></td>
				<td><?php echo $rslt['PageViewsPerVisit'];?></td>
				<td><?php echo $rslt['AvgTimePerVisit'];?></td>
				<td><?php echo $rslt['OwnerIdName'];?></td>
				<td><?php echo $rslt['CreatedOn'];?></td>
				<td><?php echo $rslt['LastVisitDate'];?></td>
				
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

 


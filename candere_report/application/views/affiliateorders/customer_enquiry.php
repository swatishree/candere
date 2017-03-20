<div class="messages">
<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		} 
			
		$sql = "select distinct flag from customer_queries where flag NOT IN('Product_page_popup_inquiry','yatra_popup')";
		 
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
	$flag = '';
	if(isset($_POST) && !empty($_POST)){
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to']; 
		$flag = $_POST['flag']; 
		
		 
	}
?>
<div style="margin:0 auto; text-align: center;">
<h1>Customer enquiry</h1>
	
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
		<select name="flag" id="flag">
			<?php
				foreach($result as $states){
				 
					 
			?>
							<option value="<?php echo $states['flag'] ;?>" <?php if($states['flag']==$flag) echo 'selected="selected"' ; ?>><?php echo $states['flag']; ?></option>
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
	
	$flag 	= $_POST['flag'];
	$date_from 		= strtotime($_POST['date_from']);
	$date_to 		= strtotime($_POST['date_to']);
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
	 
	if($date_from > $date_to){
		echo 'date from should be less than date to';
	}else{
		 
		 $sql = "SELECT DISTINCT name, email , contact_no, addres_text, question ,product_name , created_at, affiliate_id from customer_queries where created_at between '$mysql_date_from' AND '$mysql_date_to' and flag= '$flag'  ";
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
		<th>Name</th>
		<th>Email</th>
		<th>Address</th>
		<th>Contact no</th>
		<th>Question</th>
		<th>Product Name</th>
		<th>Created At</th>
		<th>Affiliate id</th>
	 
	</tr>
<?php
			foreach($result as $rslt){
?>
			<tr>
				<td><?php echo $rslt['name'];?></td> 
				<td><?php echo $rslt['email'];?></td> 
				<td><?php echo ($rslt['addres_text'] ? $rslt['addres_text'] : 'N/A'); ?></td> 
				<td><?php echo $rslt['contact_no'];?></td> 
				<td><?php echo $rslt['question'];?></td> 
				<td><?php echo $rslt['product_name'];?></td> 
				<td><?php echo $rslt['created_at'];?></td> 
				<td><?php echo $rslt['affiliate_id'];?></td> 
				 
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

 


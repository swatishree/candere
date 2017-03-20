<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Father's Contest</title>
	   	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<style type="text/css">

	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style>

		
  


	<body>
	   <table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<th align="center">Name</th>
				<th align="center">phone No.</th>
				<th align="center">Email</th>
				<th align="center">Message</th>
				<th align="center">Date</th>
				
			</tr>
		</thead>  
			
	<?php
	 echo '<div style="color:#d83c3c; float:left; margin-top:5px; margin-left:502"><b>Father\'s Contestant Data</b></div> <br>';
	 //echo '<div style="color:#d83c3c; float:left; margin-top:5px; margin-left:502"><b>Total Records  : '.count($data).'</b></div>';
	 
	 //echo "<pre>";
	 //print_r($data);
	 
	 
			foreach($data as $row){
				
				//echo $row['usename'];
								
			if((!empty($row['usename']) and ($row['usename']!= NULL ))  && (!empty($row['phone'])!="" and $row['phone']!=NULL) && (!empty($row['email']) and $row['email']!=NULL) && (!empty($row['created_date']) and $row['created_date']!=NULL)){
				
				
					
				?>
					<tr>
							<td align="center"><?php echo  $row['usename'] ;?></td>
							<td align="center"><?php echo  $row['phone'] ;?></td>
							<td align="center"><?php echo  $row['email'] ;?></td>
							<td align="center"><?php echo  $row['message'] ;?></td>
							<td align="center"><?php echo  $row['created_date'] ;?></td>
							
					</tr>
				<?php  
				}			
			}
		 
	?>
	</table>
				
	</body>
</html>

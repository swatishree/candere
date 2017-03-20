<script>
  $(function() {
    $( "#from" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#to" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>
  
<br><br><br>



<?php 
$sql = $this->db->query("SELECT * from sales_order_status");

$order_status 	= $sql->result(); ?> 

<form method="post" name="search_order" action="<?php echo $this->config->base_url(); ?>/index.php/service_enquiry/export_report">

<label for="from"><b>From:</b></label>
<input type="text" name="from" id="from" value="<?php echo set_value('from'); ?>"> 
<br><br>
<label for="to"><b>To:</b></label>
<input type="text" name="to" id="to" value="<?php echo set_value('to'); ?>"> 

<br><br>
 
<select name="flag">
	<option>Solitaires</option>
	<option>Product</option>
	<option>Gold Coins</option>
</select>	
<br><br>
<input type="submit" name="sub_btn" value="Submit" />
</form> 


<?php	
				
if(!empty($RowsSelected))
{
?>

<p><b>Total Count : <?php echo count($RowsSelected); ?></b></p>
<br>

<table style="font-size:16px" border="1" padding="5px" id="example" cellspacing=0 cellpadding=0 width="100%">
<thead>
	<tr height="25">
		<th width="100">Name</th>
		<th>Email</th>
		<th>Contact No</th>
		<th  width="500px">Question</th>
		<th  width="100">Flag</th>
		<th>Product Name</th>
		<th  width="200">Date</th>
	</tr>
</thead>
<tbody>
<?php
		foreach($RowsSelected as $rj)
		{	 
		?>
		
		<tr height="25">			
			<td align="center"><?php echo $rj->name;?></td> 
			<td align="center"><?php echo $rj->email;?></td> 
			<td align="center"><?php echo $rj->contact_no;?></td> 
			<td align="center"><?php echo $rj->question;?></td> 
			<td align="center"><?php echo $rj->flag;?></td> 
			<td align="center"><?php echo $rj->product_name;?></td> 
			<td align="center"><?php echo $rj->created_at;?></td> 
		</tr>					
					
	<?php } ?>					
</tbody>
</table>

<?php } else { 
	
	echo '<p style="color:red;"><b>No Records Found</b></p>';
	
 } ?>

<script>
  $(function() {
    $( "#order_date_from" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#order_date_to" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>
  
<br><br><br>



<?php 
$sql = $this->db->query("SELECT * from sales_order_status");

$order_status 	= $sql->result(); ?>


<form method="post" name="search_order" action="<?php echo $this->config->base_url(); ?>/index.php/sales_order_report/export_report">

<label for="order_date_from"><b>Order Date From:</b></label>
<input type="text" name="order_date_from" id="order_date_from" value="<?php echo set_value('order_date_from'); ?>"> 
<br><br>
<label for="order_date_to"><b>Order Date To:</b></label>
<input type="text" name="order_date_to" id="order_date_to" value="<?php echo set_value('order_date_to'); ?>"> 

<br><br>

<label for="order_status"><b>Order Status:</b></label>
<select name="order_status">
	<option value=0>Select Status</option>
	<?php
		
		foreach($order_status as $row) { ?>
		<option value="<?php echo $row->status; ?>"><?php echo $row->label; ?></option>';
		<?php }
	?>
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

<table style="font-size:16px" border="1" id="example" cellspacing=0 cellpadding=0 width="1000">
<thead>
	<tr height="25">
		<th>Order Id</th>
		<th>Order Date</th>
		<th>Product Name</th>
		<th>Order Value</th>
		<th>Status</th>
	</tr>
</thead>
<tbody>
<?php
		foreach($RowsSelected as $rj)
		{	
			$order_date_timestamp = strtotime($rj->order_date);
			$order_date = date('Y-m-d', $order_date_timestamp);
		?>
		
		<tr height="25">			
			<td align="center"><?php echo $rj->order_id;?></td>
			<td align="center"><?php echo $order_date;?></td>
			<td align="center"><?php echo $rj->product_name;?></td>
			<td align="center"><?php echo $rj->base_grand_total;?></td>
			<td align="center"><?php echo $rj->order_status;?></td>
		</tr>					
					
	<?php } ?>					
</tbody>
</table>

<?php } else { 
	
	echo '<p style="color:red;"><b>No Records Found</b></p>';
	
 } ?>

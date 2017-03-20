<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
});
</script>

<div class="nav-top clearfix" style="display:table;min-height:50px;"><span style="font-size: 18px;font-weight: bold;">Order Management</span></div>
<?php 	$_username 		= @$this->session->userdata('_username');	
		$logout_url 	= base_url().'index.php/login/logout';  ?>
		
<ul id="nav">
    <li><a href="#">Home</a></li>
	<li><a href="<?php echo "http://candere.com/dashboard_report/admin/pages/report.php"; ?>" target="_blank">Dashboard</a></li>
 	<?php if($_username!='') { ?>
	<li><a href="<?php echo $logout_url ?>">Logout ( <?php echo ucwords($_username) ?> )</a></li>
	<?php } ?>
</ul>
<?php
	$_user_id 		= @$this->session->userdata('_user_id');
	$query_inboxes	= $this->db->query("select email_id from email_activities where email_to = '".$_user_id."'");
	$query_inbox 	= $query_inboxes->result();
?>
<div id="quotescointainer">
<div id="quotesleft">
<ul id="buttons">
   <?php
   if($this->session->userdata('_username')=='sales' || $this->session->userdata('_username')=='marketplace' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
	    <li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li>
  
   <?php } ?>
   <?php
   if($this->session->userdata('_username')=='cad' || $this->session->userdata('_username')=='Rupesh Jain' || $this->session->userdata('_username')=='manufacturing')
   { ?>
	    <li><a href="<?php echo base_url('index.php/erp_order/to_do')?>"><b>To Do List</b></a></li>  
   <?php } ?>
   
	 <?php
   if( $this->session->userdata('_username')=='cad' || $this->session->userdata('_username')=='manufacturing' || $this->session->userdata('_username')=='procurement' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
    <li><a href="<?php echo base_url('index.php/erp_order/processing_orders')?>"><b>Processing Orders</b></a></li>
	
	 <?php } ?>
	 
     <?php
   if($this->session->userdata('_username')=='logisitic' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
	<li><a href="<?php echo base_url('index.php/erp_order/archieved_orders')?>"><b>Shipped Orders</b></a></li>
     <?php } ?>
	<li class="active"><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/completed_orders')?>"><b>Completed Orders</b></a></li>
	<?php if($this->session->userdata('_username')=='procurement' || $this->session->userdata('_username')=='Rupesh Jain')  { ?>
	<li><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>"><b>Vendor List</b></a></li>
    <?php } ?>
	<li><a href="<?php echo base_url('index.php/erp_order/send_email?param=inbox')?>"><b>Send Email (<?php echo count($query_inbox); ?>)</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/delayed')?>"><b>Delayed Delivery</b></a></li>
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php
 $sl_val = str_replace("'","",$this->session->userdata('search_by')) ;
 $selected_status = $this->session->userdata('search_by_status') ;
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/product_updates').'">';
		$options = array(
 				  'Magento'  =>       'Magento',
				  'flipkart'  =>       'flipkart',
				  'Amazon.in'  =>		'Amazon.in',
				  'velvetcase'  =>		'velvetcase',
				  'shopclues'  =>		'shopclues',
				  'snapdeal'  =>		'snapdeal',
				  'amazon.com'  =>		'amazon.com',
				  'wys'        =>		'wys',
				  'Gold24.in'  =>		'Gold24.in',
				  'Joharishop'  =>		'Joharishop',
				  'BullionIndia'  =>	'BullionIndia',
				  'Paytm'  =>		'Paytm'
				);
				
		$query = $this->db->query('SELECT status_name , sequence FROM mststatus order by sequence asc');
		$status_data = $query->result();
       
 	    foreach($status_data as $ab)
		{			
			$status_option[$ab->sequence] = $ab->status_name;
		}
		echo '<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:100px;height:31px;" value="'.set_value('search_order_id').'">';		
		echo form_multiselect('search_by_status[]', $status_option, $selected_status, 'id="search_by_status" class="SlectBox" style="width:150px;"');
		echo form_multiselect('search_by[]', $options, $sl_val, 'id="search_by" class="SlectBox" style="width:150px;"');
		echo '<input type="submit" name="sts_submit" value="Search" class="styled-button-1">';
		echo '</form>'; ?>
<form method="post" action="<?php echo base_url('index.php/erp_order/reset_search') ; ?>">
<input type="hidden" name="viewtype" value="updates">
<input type="submit" name="sts_submit" value="reset" class="styled-button-1">
</form>
</div>

<div id="quotesright" style="padding-top:10px;">	
<?php 
echo '<form name="form_sort" id="form_sort" method="POST" action="'.$_SERVER['PHP_SELF'].'">';
$options = array(
				  'order_id'  				=> 'Order Id',
				  'dispatch_date'  			=> 'Dispatch Date',
				  'order_placed_date'  		=> 'Order Placed Date',				  
				);
echo form_dropdown('order_dispatch_date', $options, set_value('order_dispatch_date'), 'id="order_dispatch_date1" class="SlectBox" style="width:150px;" onchange="this.form.submit();"');
echo '<input type="hidden" name="direction" id="direction" value="" title="Set Descending Direction"></a>';
echo '<a href="?dir=asc" style="text-decoration:none;display:none;" id="dir_toggle_2" class="change_dir"><img src="'.base_url('themes/images/desc_arrow.gif').'">';
echo '<a href="?dir=desc" style="text-decoration:none;display:none;" id="dir_toggle" class="change_dir">
<img src="'.base_url('themes/images/asc_arrow.gif').'" title="Set Descending Direction"></a>';
echo '<a href="?dir=asc" style="text-decoration:none;display:none;" id="dir_toggle_2" class="change_dir"><img src="'.base_url('themes/images/desc_arrow.gif').'" title="Set Ascending Direction"></a>';
echo '</form>'; ?>
<form action="<?php echo base_url('index.php/erp_order/product_updates'); ?>" enctype="multipart/form-data" method="post">
	<br /> 
	<input type = "submit" value = "Export Data" name="sbmt_order" id="sbmt_order" class="styled-button-1" style="width:150px;" />
</form>
</div>
<script>
$(document).ready(function() {
	$("#dir_toggle").click(function(){
		$("#dir_toggle_2").show();
		$("#dir_toggle").hide();
		var status_id = $(this).attr('href').split('=');
		$.cookie("sort_dir", status_id[1], { expires: 1 });
		$('#direction').val($.cookie("sort_dir")); 
		$("#form_sort").submit();
		return false;
	});
	
	$("#dir_toggle_2").click(function(){
		$("#dir_toggle_2").hide();
		$("#dir_toggle").show();
		var status_id = $(this).attr('href').split('=');
		$.cookie("sort_dir", status_id[1], { expires: 1 });
		$('#direction').val($.cookie("sort_dir"));  
		$("#form_sort").submit();
		return false;
	});
	
	if($.cookie("sort_dir") == 'asc'){
		$("#dir_toggle").show();
	} else if($.cookie("sort_dir") == 'desc'){
		$("#dir_toggle_2").show();
	} else {
		$("#dir_toggle").show();
	}
	
	//$('#direction').val($.cookie("sort_dir"));	
});

function chk_link()
{
	
}
</script>
</div>
	<table width="100%" cellspacing=0 cellpadding=0 id="product_update_table" style="margin: 0 auto; padding:1px 10px 20px 10px;">
	<tbody>
		<?php		
		if($_REQUEST['param'] == 'error')
		{ ?>
			<tr><th colspan="9" style="color:red;"><?php echo 'The image you are attempting to upload exceedes the maximum height or width'; ?></td>
			</tr>
			<tr><th colspan="9">&nbsp;</th></tr>
		<?php } ?>
		<?php		
		if($_REQUEST['param'] == 'success')
		{ ?>
			<tr><th colspan="9" style="color:green;"><?php echo 'Image uploaded successfully'; ?></td></tr>
			<tr><th colspan="9">&nbsp;</th></tr>
		<?php } ?>
		<tr style="height:40px;">
			<!--<th class="th_color">Id</th> -->
			<th class="th_color">Image</th>
			<th class="th_color">Ready Image</th>
			<th class="th_color">Order Id</th>
			<th class="th_color">Order Product Id</th>
			<th class="th_color">SKU</th>
			<th class="th_color">Marketplace</th>
			<th class="th_color">Product Name</th>
			<th class="th_color">Status</th>
			<th class="th_color">Final Weight</th>
			<th class="th_color">Sent Mail</th>
			<th class="th_color">Order history</th>
		</tr>
								
		<?php if($prod_updates) {
			$pr_counter = 1;
			$row_count = 1;
			$prod_data 	= array();
			$prod_array = array();
						
			foreach($prod_updates as $pru) { 
				
				if(!in_array($pru->order_id,$prod_data)) {
					$pr_counter++;
				}
				$bgclass= ($pr_counter%2==0) ? 'bg_2' : 'bg_1';
								
				$prod_data = array_merge($prod_array, array('order_id'=>$pru->order_id));
				$prod_data = array_filter($prod_data);
				
				
				$query 		= $this->db->query("select ready_image,gold_weight,diamond_weight,gemstone_weight from erp_order where id='$pru->erp_order_id'");
				$ready_image = $query->row();
				
				//echo $this->db->last_query();
				/*foreach($ready_image as $image):				
					$ready_image_value = $image;
				endforeach;*/
				
			?>
				
				<tr class="<?php echo $bgclass ?>">				
					<!--<td align="center" class="bottom left"><?php //echo $row_count; ?></td>-->
					<td align="center" class="left bottom" style="padding:10px;"><?php echo '<img src="'.str_replace('cdn','www',$pru->product_image).'" width="100" height="100">' ?></td><td class="bottom">
						<?php 
						echo "<br>";
						if($ready_image->ready_image != '')
						{
							?>
							<img src="<?php echo $ready_image->ready_image; ?>" width="50px;" height="50px;">
							<?php
						} 
						echo "<br><br><br>";?>
						<form action="<?php echo base_url('index.php/erp_order/ready_image'); ?>"  enctype="multipart/form-data"  method = "post">
							<input type="file" name="ready_image" id="ready_image" size = "20" value="" /> 
							<input type="hidden" name="erp_order_id" value="<?php echo $pru->erp_order_id; ?>">
							<input type="hidden" name="order_id" value="<?php echo $pru->order_id; ?>">
							<br /><br /> 
							<input type="submit" value="upload" /> 
						</form>	
					</td>
					<td align="center" class="bottom"><a href="<?php echo base_url('index.php/erp_order/add_finished?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'') ?>" id="div_popup"><?php echo $pru->order_id ?></a>
					</td>
					<td align="center" class="bottom"><?php echo $pru->erp_order_id ?></td>
					<td align="center" class="bottom"><?php echo $pru->sku ?></td>
					<td align="center" class="bottom"><?php echo $pru->mktplace_name ?></td>
					<td align="center" class="bottom"><?php echo $pru->product_name ?></td>
					<td align="center" class="bottom"><?php echo $pru->status_name; ?></td>
					<td align="center" class="bottom"><a href="<?php echo base_url('index.php/erp_order/weight_update?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'&id='.$pru->id.'') ?>" id="div_popup">Weight Update</a><br>
					<?php 
						if($ready_image->gold_weight != '') { echo "<br>Gold wt. - ".$ready_image->gold_weight; }
						if($ready_image->diamond_weight != '') { echo "<br>Diamond wt. -  ".$ready_image->diamond_weight; }
						if($ready_image->gemstone_weight != '') { echo "<br>Gemstone wt. - ".$ready_image->gemstone_weight; }
					?>
					</td>
					<td align="center" class="bottom"><a href="<?php echo base_url('index.php/erp_order/send_mail?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'&id='.$pru->id.'') ?>" id="div_popup">Sent Mail</a></td>
					<td align="left" class="bottom right" style="padding:5px;">
					<?php
						$query = "select * from trnorderprocessing where order_id='$pru->order_id' and order_item_id = '$pru->order_item_id'" ;
						$results = $this->db->query($query);					  
						$result 	= $results->result_array(); ?>
						<table style=" cellpadding:1px; border:solid 1px;width: 100% ; text-align:left;">
							<tr>
								<th>status</th>
								<th>date</th>
								<th>department</th>
								<th>notes</th>
							</tr>
							<?php						
								$count = count($result);
								$i = 0 ;
									foreach($result as $res)
									{							
							?>						
							<tr>
								<td>
									<?php
										$query = "select status_name from mststatus where sequence= ".$res['order_status_id'] ; 
										$results = $this->db->query($query);
										$result 	= $results->result_array();
										echo $result[0]['status_name']; ?> </td>
								<td><?php echo $res['updated_date']; ?></td>
								<td> <?php echo $res['updated_by'] ; ?></td>
								<td> <?php echo $res['notes'] ; ?></td>
							</tr>
							<tr>
							   <td></td>
							   <td></td>
							   <td></td>
							   <td></td>
							</tr>
							<?php }	?>								 
						</table>
					</td>
				</tr>
			<?php
			$row_count++;
			}
		} ?>
			</tbody>
		</table>
<!-- Pagination for Product update list -->
<?php echo $this->pagination->create_links(); ?>

<script type='text/javascript'>
$(document).ready(function () {
	$('.popbox').popbox();
	
	$('#order_table tr').click(function(){
		var cid = $(this).attr('id');
		
		$('#OrderStatusID_'+cid).change(function(){
			if($("#OrderStatusID_"+cid+" option:selected").val()==1) {
				$("#vendor_dis_"+cid).hide();
			} else {
				$("#vendor_dis_"+cid).show();
			}
			if($("#OrderStatusID_"+cid+" option:selected").val()==2) {
				$("#greeting_dis_"+cid).hide();
			} else {
				$("#greeting_dis_"+cid).show();
			}
		});
	});
});

$('#selectAll').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});	

$('#select_all').click(function() {
    $('#status_id option').prop('selected', true);
});

/*$(document).ready(function(){
    $('#div_popup').click(function(){
        window.location = $(this).data('href');
        return false;
    });
});*/
</script>
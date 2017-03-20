<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
});
  
$(document).ready(function(){
	$('#order_table tr').hover(function() {
		var rid = $(this).attr('id');
		$("#edit_dispatch_date_"+rid).click(function(){
			$("#dispatch_form_"+rid).toggle();
		});
		
		$( "#updated_dispatch_date_"+rid ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo base_url(); ?>themes/images/calendar.gif",
			buttonImageOnly: true,
			buttonText: "Select date"
		});
		
		$("#cancel_order_"+rid).click(function(){
			$("#cancel_order_form_"+rid).toggle();
			$("#order_update_"+rid).toggle();
		});
		
		$("#edit_price_"+rid).click(function(){
			$("#update_price_form_"+rid).toggle();
		});
	})
});

function save_order(tr_id) {
	var flag 		= confirm("Do you want to update this order?");
	var form_data 	= $("#order_update_"+tr_id).serialize();
      	 
    if(flag==true){
		 $.ajax({
			type: 'POST',
			url : "<?php echo base_url()?>index.php/erp_order/order_save",
			data : form_data,
			success : function(result) {
				if(result=='success')
					alert("Order Updated successfully");
				else
					alert("Something went wrong. Please try againg.");
				
				//window.location.href ="<?php echo base_url()?>index.php/erp_order/archieved_orders";
				
				location.reload();
			}
		}); 
   } 
}

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
});
</script>

<div class="nav-top clearfix" style="display:table;min-height:50px;"><span style="font-size: 18px;font-weight: bold;">Order Management</span></div>


<?php 	$_username 		= @$this->session->userdata('_username');	
	    $logout_url 	= base_url().'index.php/login/logout';  ?>
		
<ul id="nav">
      <li><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>">Home</a></li>
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
	<li><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
	 <li><a href="<?php echo base_url('index.php/erp_order/completed_orders')?>"><b>Completed Orders</b></a></li>
	 <?php
   if($this->session->userdata('_username')=='procurement' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
	 <li class="active"><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>"><b>Vendor List</b></a></li>
     <?php } ?>
	 <li><a href="<?php echo base_url('index.php/erp_order/send_email?param=inbox')?>"><b>Send Email (<?php echo count($query_inbox); ?>)</b></a></li>
	 <li><a href="<?php echo base_url('index.php/erp_order/delayed')?>"><b>Delayed Delivery</b></a></li>
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php	
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/vendor_list').'">';
		$allow_status 	= @$this->session->userdata('order_status'); 
		$show_orders 	= $this->erpmodel->getAllStatus();
		
		$user_status = '';
			foreach($show_orders as $ab){
				$user_status[$ab->status_id] = $ab->status_name;
			}
		echo '<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:250px;height:31px;" value="'.set_value('search_order_id').'">';	
		echo '<input type="submit" name="sts_submit" value="Search" class="styled-button-1">';
echo '</form>'; ?>
</div>

<div id="quotesright" style="padding-top:16px;"></div>
<form action="<?php echo base_url('index.php/erp_order/vendor_list'); ?>" enctype="multipart/form-data" method="post">
	<br /> 
	<input type = "submit" value = "Export Data" name="sbmt_vendor_list" id="sbmt_vendor_list" class="styled-button-1" style="width:150px;" />
</form>
</div>

<?php 		
	$order_table = '';
	$order_table = '<table width="100%" cellspacing=0 cellpadding=0 name="order_table" id="order_table" class="tablesorter" style="padding:0 10px 20px 10px;">
		<tr height="40" style="padding-bottom:100px;">			
			<th align="left" class="th_color" style="width:200px;">Vendor Name</th>
			<th class="th_color">Order Lists</th>
		</tr>'; ?>	
		<?php
if($selectdata)
{			
	$array 		= array();
	$data 		= array();
	$counter 	= 1;
	$trCounter 	= 1;
	foreach($selectdata as $row){
		$vendor_id		= $row->vendor_id;
		$vendor_name	= $row->vendor_name;		
		$vendor_email 	= $row->vendor_email;
		
		$sql_vendor_order_list = "SELECT o.order_id, o.order_product_id, o.order_item_id, o.vendor_assigned_date, o.vendor_recieved_date FROM trnorderprocessing o where o.vendor_id=".$vendor_id." and order_status_id='9' group by order_status_id order by o.id desc";
		$query_order_list 	   = $this->db->query($sql_vendor_order_list);
		$vendor_data	       = $query_order_list->result();

		if(!in_array($vendor_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';

		$order_table .= '<tr class="'.$bgclass.' main_tr" id="'.$trCounter.'">	
			<td class="border bottom left" style="padding-top:10px;color:#0066cc;" width="200">'.ucwords($vendor_name).'</td>
			<td class="bottom left right " valign="top"  >';
			
			if(count($vendor_data) > 0){
				
					foreach($vendor_data as $vendor_list)
					{
						$order_id			= $vendor_list->order_id;
						$order_product_id	= $vendor_list->order_product_id;
						$order_item_id		= $vendor_list->order_item_id;
						
						$sql_product_list   = "SELECT o.product_name, o.sku, o.order_placed_date, o.dispatch_date, ed.* FROM erp_order o left join erp_order_details ed on o.id=ed.erp_order_id where o.id=".$order_product_id;
						$query_product_list = $this->db->query($sql_product_list);
						$product_data	    = $query_product_list->result();
						
						$order_placed_date	= $product_data[0]->order_placed_date;
						$dispatch_date	= $product_data[0]->dispatch_date;
						$name				= $product_data[0]->product_name;
						$sku				= $product_data[0]->sku;
						$product_image		= $product_data[0]->product_image;
						
						$product_type		= $product_data[0]->product_type;
						$metal				= $product_data[0]->metal;
						$purity				= $product_data[0]->purity;
						$height				= $product_data[0]->height;
						$width				= $product_data[0]->width;
						$top_thickness		= $product_data[0]->top_thickness;
						
						$top_height			= $product_data[0]->top_height;
						$bottom_thickness	= $product_data[0]->bottom_thickness;
						$metal_weight		= $product_data[0]->metal_weight;
						$total_weight		= $product_data[0]->total_weight;
						$width				= $product_data[0]->width;
						$top_thickness		= $product_data[0]->top_thickness;
						
						$no_of_stones	= $product_data[0]->no_of_stones;
						$chain_thickness= $product_data[0]->chain_thickness;
						$chain_length	= $product_data[0]->chain_length;
						$bracelet_length= $product_data[0]->bracelet_length;
						$bangle_size	= $product_data[0]->bangle_size;
						$kada_size		= $product_data[0]->kada_size;
						$ring_size		= $product_data[0]->ring_size;
						
						if(date('d-m-Y', strtotime($vendor_list->vendor_assigned_date)) != '01-01-1970' && date('d-m-Y', strtotime($vendor_list->vendor_assigned_date)) != '30-11--0001')
						{
							$vendor_assigned_date	= date('d-m-Y', strtotime($vendor_list->vendor_assigned_date));
						}
						
						if(date('d-m-Y', strtotime($vendor_list->vendor_recieved_date)) != '01-01-1970' && date('d-m-Y', strtotime($vendor_list->vendor_recieved_date)) != '30-11--0001')
						{
							$vendor_recieved_date	= date('d-m-Y', strtotime($vendor_list->vendor_recieved_date));
						}
						
						if(date('d-m-Y', strtotime($order_placed_date)) != '01-01-1970' && date('d-m-Y', strtotime($order_placed_date)) != '30-11--0001')
						{
							$order_placed_date	= date('d-m-Y', strtotime($order_placed_date));
						}
						
						if(date('d-m-Y', strtotime($dispatch_date)) != '01-01-1970' && date('d-m-Y', strtotime($dispatch_date)) != '30-11--0001')
						{
							$dispatch_date	= date('d-m-Y', strtotime($dispatch_date));
						}
						
						if($vendor_recieved_date != '')
							$status = 'Done';
						else
							$status = 'Onprocess';
			
					$order_table .= '<table cellpadding="0" cellspacing="0" border="0" width="90%" >
									<tr>
										<td>&nbsp;<img src="'.str_replace('cdn','www',$product_image).'" height="120" width="120" class="img_padding"></td>
										<td><b>Order Id : </b>'.$order_id.' <br><b>Order Item Id :</b>'.$order_item_id.'<br><b>Name :</b>'.$name.'<br><b>SKU :</b>'.$sku.'<br><b>Product Type :</b>'.$product_type.'</td>
										
										<td><b>Metal :</b>'.$metal.'<br><b>Purity :</b>'.$purity.'<br><b>Height :</b>'.$height.'<br><b>Width :</b>'.$width.'<br><b>Top Thickness :</b>'.$top_thickness.'</td>
										
										<td><b>Top Height :</b>'.$top_height.'<br><b>Bottom Thickness :</b>'.$bottom_thickness.'<br><b>Ring Size :</b>'.$ring_size.'<br><b>Height :</b>'.$height.'<br><b>Metal Weight :</b>'.$metal_weight.'</td>
										
										
										<td><b>Total Weight :</b>'.$total_weight.'<br><b>Chain Length :</b>'.$chain_length.'<br><b>Bracelet Length :</b>'.$bracelet_length.'<br><b>Bangle Size :</b>'.$bangle_size.'<br><b>Kada Size :</b>'.$kada_size.'</td>
										
										<td><b>No of stones :</b>'.$no_of_stones.'<br><b>Chain Thickness :</b>'.$chain_thickness.' <br><b>Status :</b>'.$status.'</td>
										
										<td><b>Order Date :</b>'.$order_placed_date.'<br><b>Order Assigned Date :</b>'.$vendor_assigned_date.'<br><b>Order Received Date :</b>'.$vendor_recieved_date.'<br><b>Status :</b>'.$status.'<br><b>Dispatch Date :</b>'.$dispatch_date.'</td>
									</tr>';
					?>
					<?php
					/*	foreach($vendor_data as $vendor_list)
						{
							$order_id				= $vendor_list->order_id;
							$order_product_id		= $vendor_list->order_product_id;
							$order_item_id		= $vendor_list->order_item_id;
							
							$sql_product_list   = "SELECT o.product_name, o.sku, ed.product_image FROM erp_order o left join erp_order_details ed on o.id=ed.erp_order_id where o.id=".$order_product_id;
							$query_product_list = $this->db->query($sql_product_list);
							$product_data	    = $query_product_list->result();
							
							$name				= $product_data[0]->product_name;
							$sku				= $product_data[0]->sku;
							$product_image		= $product_data[0]->product_image;
							
							if(date('d-m-Y', strtotime($vendor_list->vendor_assigned_date)) != '01-01-1970' && date('d-m-Y', strtotime($vendor_list->vendor_assigned_date)) != '30-11--0001')
							{
								$vendor_assigned_date	= date('d-m-Y', strtotime($vendor_list->vendor_assigned_date));
							}
							
							if(date('d-m-Y', strtotime($vendor_list->vendor_recieved_date)) != '01-01-1970' && date('d-m-Y', strtotime($vendor_list->vendor_recieved_date)) != '30-11--0001')
							{
								$vendor_recieved_date	= date('d-m-Y', strtotime($vendor_list->vendor_recieved_date));
							}
							
							if($vendor_recieved_date != '')
								$status = 'Done';
							else
								$status = 'Onprocess';
					
					$order_table .= '<tr><td style="color:#0066cc;"></td><td style="color:#0066cc;"></td><td style="color:#0066cc;"></td></tr>
						<tr><td style="color:#0066cc;"></td><td></td><td style="color:#0066cc;"></td></tr>
						<tr><td><b>Assigned Date :</b>'.$vendor_assigned_date.'</td><td><b></td><td style="color:#0066cc;"></td></tr>						
						<tr><td><b>Received Date :</b>'.$vendor_recieved_date.'</td><td><b>Metal :</b>'.$status.'</td><td style="color:#0066cc;"><b>Top Thickness :</b>'.$name.'</td></tr>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>'; */
						}
				$order_table .= '</table>';
			} 
			$order_table .= '</td></tr>';
		$trCounter++;
	}
}
?>
<?php $order_table .= '</table>';
echo $order_table; ?>

<!-- Pagination for To do list -->

<?php
	echo $this->pagination->create_links();
 ?>
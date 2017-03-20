<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
});

$(document).ready(function(){
	$('#process_table tr').hover(function() {
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

function myFunction(tr_id) {
   var flag = confirm("Do you want to cancel this order?");
   var form_data = $("#cancel_order_form_"+tr_id).serialize();
      
   if(flag==true){
		 $.ajax({
			type: 'POST',
			url : "<?php echo base_url()?>index.php/erp_order/cancel_order",
			data : form_data,
			success : function(result) {
				if(result=='success')
					alert("Order Cancelled successfully");
				else
					alert("Something went wrong. Please try againg.");
				
				window.location.href ="<?php echo base_url()?>index.php/erp_order/processing_orders";
			}
		}); 
   }
}

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

function set_next_state(tr_id) {
	var flag 		= confirm("Do you want to update this order?");
	var form_data 	= $("#order_update_"+tr_id).serialize();
      	 
    if(flag==true){
		 $.ajax({
			type: 'POST',
			url : "<?php echo base_url()?>index.php/erp_order/set_next_state",
			data : form_data,
			success : function(result) {
				 if(result=='success')
					alert("Order Updated successfully");
				else
					alert("Something went wrong. Please try againg.");
				
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
	
	$('#direction').val($.cookie("sort_dir"));	
});
</script>

<div class="nav-top clearfix" style="display:table;min-height:50px;"><span style="font-size: 18px;font-weight: bold;">Order Management</span></div>


<?php 	$_username 		= @$this->session->userdata('_username');	
		$logout_url 	= base_url().'index.php/login/logout';  ?>
		
<ul id="nav">
      <li><a href="#">Home</a></li>
      <li><a href="<?php echo base_url('index.php/erp_order/create_marketplace_order') ?>">Create Market-place order</a></li>
	  <?php if($_username!='') { ?>
		<li><a href="<?php echo $logout_url ?>">Logout ( <?php echo ucwords($_username) ?> )</a></li>
	  <?php } ?>
</ul>

<div id="quotescointainer">
<div id="quotesleft">
<ul id="buttons">
    <li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li>
    <li  class="active"><a href="<?php echo base_url('index.php/erp_order/processing_orders')?>"><b>Processing Orders</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/archieved_orders')?>"><b>Archieved Orders</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php	
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/processing_orders').'">';
		$allow_status 	= @$this->session->userdata('order_status'); 
		$show_orders 	= $this->erpmodel->getAllStatus();
		
		$user_status = '';
			foreach($show_orders as $ab){
				$user_status[$ab->status_id] = $ab->status_name;
			}
			
		echo '<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:100px;height:31px;" value="'.set_value('search_order_id').'">';	
		echo $status_dropdown = form_multiselect('search_status_id[]', $user_status, set_value('search_status_id'), 'id="search_status_id" class="SlectBox" placeholder="Select Status"');	
		echo '<input type="submit" name="sts_submit" value="Search" class="styled-button-1">';
		//echo '<input type="submit" id="select_all" name="select_all" value="Select All " class="styled-button-1"></span>'; 
echo '</form>'; ?>
</div>

<div id="quotesright" style="padding-top:16px;">		
<?php
echo '<form name="form_sort" id="form_sort" method="POST" action="'.$_SERVER['PHP_SELF'].'">';
$options = array(
				  'expected_delivery_date'  => 'Dispatch Date',
				  'order_placed_date'  		=> 'Order Placed Date',
				  'order_id'  				=> 'Order Id',
				);
echo form_dropdown('order_dispatch_date', $options, set_value('order_dispatch_date'), 'id="order_dispatch_date" class="SlectBox" style="width:150px;" onchange="this.form.submit();"');
echo '<input type="hidden" name="direction" id="direction" value="">';
echo '<a href="?dir=desc" style="text-decoration:none;display:none;" id="dir_toggle" class="change_dir">
<img src="'.base_url('themes/images/asc_arrow.gif').'" title="Set Descending Direction"></a>';
echo '<a href="?dir=asc" style="text-decoration:none;display:none;" id="dir_toggle_2" class="change_dir"><img src="'.base_url('themes/images/desc_arrow.gif').'" title="Set Ascending Direction"></a>';
echo '</form>'; ?>			
</div>
</div>

<?php 
	$process_table = '';
	$process_table = '<table width="100%" cellspacing=0 cellpadding=0 class="process_table" name="process_table" id="process_table" style="padding:0 10px 20px 10px;">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color">&nbsp;</th>
			<th colspan="2" align="left" class=" th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color">Dispatch Date</th>
			<th align="left" class="th_color">Order Action</th>
			
		</tr>'; ?>		
<?php
if($processdata)
{
	$array 		= array();
	$counter 	= 1;
	$trProcess 	= 1;
	$_username 	= @$this->session->userdata('_username');
	$_admin 	= @$this->session->userdata('_admin');
	$order_status 	= @$this->session->userdata('order_status');
	$_allow_cancel 	= @$this->session->userdata('_allow_cancel');
	
	$process_status 	= $this->erpmodel->getProcessingStatus($order_status);
	$all_vendors 		= $this->erpmodel->getAllVendors();
	$getAllGreetings	= $this->erpmodel->getAllGreetings();
		
	$process_status_option[''] = 'Select Status';
		foreach($process_status as $nb){
			$process_status_option[$nb->status_id] = $nb->status_name;
		}
		
	$vendor_option[''] = 'Select Vendor';
		foreach($all_vendors as $rw){ 
			$vendor_option[$rw->VendorID] = $rw->VendorName;
		}	
	
	$greeting_option[''] = 'Select Greeting';
		foreach($getAllGreetings as $rg){ 
			$greeting_option[$rg->greeting_card_id] = $rg->greeting_card_name;
		}
				
	foreach($processdata as $rj){
		$erp_id 	= $rj->id;
		$order_id 	= $rj->order_id;
		$product_id = $rj->product_id;
		$erp_order_id 		= $rj->erp_order_id;
		$order_product_id 	= $rj->order_product_id;
			
		$expected_delivery_date = $rj->expected_delivery_date;
		$dispatch_date 			= $rj->dispatch_date;
		
		if(strtotime($dispatch_date) < time()) {
			$dispatch_date 	= date("Y-m-d");
		} else {
			$dispatch_date 	= $rj->dispatch_date;
		}
						
		$personal_message 	= $rj->personal_message;
		$greeting_card_id 	= $rj->greeting_card_id;
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);			
		$getOrderData		= $this->erpmodel->getOrderData($order_id);
		$getOrderNotes		= $this->erpmodel->getOrderNotes($order_id, $order_product_id);
		
		$last_notes 		= end($getOrderNotes);
		$initial_note 		= $last_notes->notes;
				
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, g:i a', strtotime($nt->updated_date));
				$all_notes .='<div class="notes_area"><br>
							<span style="float:left;"><b>'.$this->erpmodel->getStatusName($nt->order_status_id).'</b></span>
							<span style="float:right;"><b>'.$updated_date.'</b></span><br>
							<span style="float:left;"><b>'.$nt->updated_by.'</b></span><br>';
							if($nt->notes !='') {
								$all_notes .= '<p style="float:left; margin-left:0px;">'.$nt->notes.'</p>';
							}
							$all_notes .= '</div><br>';
			}
		}
		
		if(in_array($rj->status, explode(',',$allow_status))) {
			$disable_vendor = '';
		} else {
			$disable_vendor = 'disabled';
		}
		$disable_vendor = ($disable_vendor == 'disabled') ? 'disabled' : '';
			
		if(in_array($rj->order_status_id, explode(',',$allow_status))) {
			$disable_status = '';
		} else {
			$disable_status = 'disabled';
		}
		$disable_status = ($disable_status == 'disabled') ? 'disabled' : '';
		
		$order_status_id 	= $getOrderData[0]->order_status_id;
		$vendor_id 			= $getOrderData[0]->vendor_id; 
		$notes 				= $getOrderData[0]->notes; 
		$greeting_card_id 	= $getOrderData[0]->greeting_card_id; 
		$website_id 		= $getOrderData[0]->website_id; 
				
		$disable = ($greeting_card_id==0) ? '' : "disabled";
		
		$key['status_id'] 	= $order_status_id;
		$getStatus			= $this->erpmodel->GetInfoRow('mstStatus',$key);
		$status_name		= $getStatus[0]->status_name;
				
		$status_dropdown = form_dropdown('order_status_id', $process_status_option, $order_status_id, 'id="OrderStatusID_'.$trProcess.'" class="tb10" '.$disable_status.' ');
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="VendorID_'.$trProcess.'", class="tb10" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trProcess.'", class="dropWidth", '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
		
		if($rj->updated_price !=''){
			$unit_price = $rj->updated_price;
		} else {
			$unit_price = $rj->unit_price;
		}
				
		$total = number_format(($rj->unit_price*$rj->quantity) + $rj->shipping_amount + $rj->discount_amount,2);
		
		$usd_total_1 = (($unit_price*$rj->quantity) + $rj->shipping_amount + $rj->discount_amount);
		$usd_total = number_format($usd_total_1*0.016,2);
		
		$diamond_1_stones 		= '<td>'.$rj->diamond_1_stones.'</td>';
		$diamond_1_weight 		= '<td>'.$rj->diamond_1_weight.'</td>';
		$diamond_1_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_1_clarity).'</td>';
		$diamond_1_shape 		= '<td>'.$rj->diamond_1_shape.'</td>';
		$diamond_1_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_1_color).'</td>';
		$diamond_1_setting_type = '<td>'.$rj->diamond_1_setting_type.'</td>';
		$diamond_2_stones 		= '<td>'.$rj->diamond_2_stones.'</td>';
		$diamond_2_weight 		= '<td>'.$rj->diamond_2_weight.'</td>';
		$diamond_2_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_2_clarity).'</td>';
		$diamond_2_shape 		= '<td>'.$rj->diamond_2_shape.'</td>';
		$diamond_2_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_2_color).'</td>';
		$diamond_2_setting_type = '<td>'.$rj->diamond_2_setting_type.'</td>';
		$diamond_3_stones 		= '<td>'.$rj->diamond_3_stones.'</td>';
		$diamond_3_weight 		= '<td>'.$rj->diamond_3_weight.'</td>';
		$diamond_3_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_3_clarity).'</td>';
		$diamond_3_shape 		= '<td>'.$rj->diamond_3_shape.'</td>';
		$diamond_3_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_3_color).'</td>';
		$diamond_3_setting_type = '<td>'.$rj->diamond_3_setting_type.'</td>';
		$diamond_4_stones 		= '<td>'.$rj->diamond_4_stones.'</td>';
		$diamond_4_weight 		= '<td>'.$rj->diamond_4_weight.'</td>';
		$diamond_4_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_4_clarity).'</td>';
		$diamond_4_shape 		= '<td>'.$rj->diamond_4_shape.'</td>';
		$diamond_4_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_4_color).'</td>';
		$diamond_4_setting_type = '<td>'.$rj->diamond_4_setting_type.'</td>';
		$diamond_5_stones 		= '<td>'.$rj->diamond_5_stones.'</td>';
		$diamond_5_weight 		= '<td>'.$rj->diamond_5_weight.'</td>';
		$diamond_5_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_5_clarity).'</td>';
		$diamond_5_shape 		= '<td>'.$rj->diamond_5_shape.'</td>';
		$diamond_5_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_5_color).'</td>';
		$diamond_5_setting_type = '<td>'.$rj->diamond_5_setting_type.'</td>';
		$diamond_6_stones 		= '<td>'.$rj->diamond_6_stones.'</td>';
		$diamond_6_weight 		= '<td>'.$rj->diamond_6_weight.'</td>';
		$diamond_6_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_6_clarity).'</td>';
		$diamond_6_shape 		= '<td>'.$rj->diamond_6_shape.'</td>';
		$diamond_6_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_6_color).'</td>';
		$diamond_6_setting_type = '<td>'.$rj->diamond_6_setting_type.'</td>';
		$diamond_7_stones 		= '<td>'.$rj->diamond_7_stones.'</td>';
		$diamond_7_weight 		= '<td>'.$rj->diamond_7_weight.'</td>';
		$diamond_7_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rj->diamond_7_clarity).'</td>';
		$diamond_7_shape 		= '<td>'.$rj->diamond_7_shape.'</td>';
		$diamond_7_color 		= '<td>'.$this->erpmodel->getDiamondColor($rj->diamond_7_color).'</td>';
		$diamond_7_setting_type = '<td>'.$rj->diamond_7_setting_type.'</td>';
		$gemstone_1_stone 		= '<td>'.$rj->gemstone_1_stone.'</td>';
		$gemstone_1_type 		= '<td>'.$rj->gemstone_1_type.'</td>';
		$gemstone_1_color 		= '<td>'.$rj->gemstone_1_color.'</td>';
		$gemstone_1_shape 		= '<td>'.$rj->gemstone_1_shape.'</td>';
		$gemstone_1_setting_type= '<td>'.$rj->gemstone_1_setting_type.'</td>';
		$gemstone_1_weight 		= '<td>'.$rj->gemstone_1_weight.'</td>';
		$gemstone_2_stone 		= '<td>'.$rj->gemstone_2_stone.'</td>';
		$gemstone_2_type 		= '<td>'.$rj->gemstone_2_type.'</td>';
		$gemstone_2_color 		= '<td>'.$rj->gemstone_2_color.'</td>';
		$gemstone_2_shape 		= '<td>'.$rj->gemstone_2_shape.'</td>';
		$gemstone_2_setting_type= '<td>'.$rj->gemstone_2_setting_type.'</td>';
		$gemstone_2_weight 		= '<td>'.$rj->gemstone_2_weight.'</td>';
		$gemstone_3_stone 		= '<td>'.$rj->gemstone_3_stone.'</td>';
		$gemstone_3_type 		= '<td>'.$rj->gemstone_3_type.'</td>';
		$gemstone_3_color 		= '<td>'.$rj->gemstone_3_color.'</td>';
		$gemstone_3_shape 		= '<td>'.$rj->gemstone_3_shape.'</td>';
		$gemstone_3_setting_type= '<td>'.$rj->gemstone_3_setting_type.'</td>';
		$gemstone_3_weight 		= '<td>'.$rj->gemstone_3_weight.'</td>';
		$gemstone_4_stone 		= '<td>'.$rj->gemstone_4_stone.'</td>';
		$gemstone_4_type 		= '<td>'.$rj->gemstone_4_type.'</td>';
		$gemstone_4_color 		= '<td>'.$rj->gemstone_4_color.'</td>';
		$gemstone_4_shape 		= '<td>'.$rj->gemstone_4_shape.'</td>';
		$gemstone_4_setting_type= '<td>'.$rj->gemstone_4_setting_type.'</td>';
		$gemstone_4_weight 		= '<td>'.$rj->gemstone_4_weight.'</td>';
		$gemstone_5_stone 		= '<td>'.$rj->gemstone_5_stone.'</td>';
		$gemstone_5_type 		= '<td>'.$rj->gemstone_5_type.'</td>';
		$gemstone_5_color 		= '<td>'.$rj->gemstone_5_color.'</td>';
		$gemstone_5_shape 		= '<td>'.$rj->gemstone_5_shape.'</td>';
		$gemstone_5_setting_type= '<td>'.$rj->gemstone_5_setting_type.'</td>';
		$gemstone_5_weight 		= '<td>'.$rj->gemstone_5_weight.'</td>';
		
		$product_url = str_replace('candere_report/',$rj->product_url,base_url()); 
			
		$process_table .= '<tr class="'.$bgclass.' main_tr" id="'.$trProcess.'"  >
			<td class="border left bottom" width="20" valign="top" style="padding-top:40px;">&nbsp;</td>	
			<td class="border bottom" width="275" style="color:#0066cc;" valign="top">
			<b>Order Id : '.$rj->order_id.'</b><br>
			<img src="'.$rj->product_image.'" height="120" width="120" class="img_padding"></td>
					
			<td class="bottom" width="580" valign="top" style="padding-top:10px;">
				<table name="product_data" width="100%">
					<tbody>
						<tr><td><b>SKU : </b>'.$rj->sku.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b>						
							</td></tr>
						<tr><td><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$rj->product_name.'</a></b>&nbsp;&nbsp;&nbsp;<b style="color:#0066CC;float:right;margin-right:10%;">'.$rj->design_identifier.'</b></td>
						</tr>
						<tr>
							<td width="400">
							<table name="order_data" width="100%">
							<tbody>
								<tr><td width="200"><b>Order Date : </b>'.date("F j, Y", strtotime($rj->order_placed_date)).'</td></tr>';
								
								$process_table .='<tr>';
								if($rj->metal!='') {
									$process_table .='<td><b>Metal : </b>'.$rj->metal.'</td>';
								}
								if($rj->purity!='') {
									$process_table .='<td><b>Purity : </b>'.$rj->purity.'</td>';
								}
								$process_table .='</tr>';
								
								$process_table .='<tr>';
								if($rj->height!='') {
									$process_table .= '<td><b>Height : </b>'.$rj->height.' mm</td>';
								}
								if($rj->height!='') {
									$process_table .= '<td><b>Width : </b>'.$rj->width.' mm</td>';
								}
								$process_table .='</tr>';
								
								$process_table .= '<tr>';
								if($rj->top_thickness) {
									$process_table .='<td width="150" class="nowrap"><b>Top Thickness : </b>'.$rj->top_thickness.' mm</td>';
									}
								if($rj->bottom_thickness) {	
									$process_table .='<td width="150" class="nowrap"><b>Bottom Thickness : </b>'.$rj->bottom_thickness.' mm</td>';
								}
								$process_table .= '</tr>';
								
								$process_table .= '<tr>';
								if($rj->top_height!='') {
									$process_table .= ' <td width="125"><b>Top Height : </b>'.$rj->top_height.'</td>';
								}	
								if($rj->total_weight!='') {	
									$process_table .='<td width="140"><b>Total Weight : </b>'.$rj->total_weight.'</td>';
								}
								$process_table .= '</tr></tbody>
							</table>
							</td>
						</tr>
					</tbody>	
				</table>
			</td>
			
			<td class="bottom" width="200" valign="top" style="padding-top:10px;">';
			
			$quan_class = ($rj->quantity > 1) ? 'red' : '';
			
			$price_class = ($row->total_due > 0) ? 'red' : '';
			
			$edit_image = base_url('themes/images/edit.png');		
			
			$process_table .= '<table name="order_detail">
					<tbody>
						<tr><td><b>Qty : <span class="'.$quan_class.'">'.$rj->quantity.'</span></b>';
						if($_allow_cancel) {
						$process_table .= '<span style="margin-right: -60%;float: right;"><img src="'.$edit_image.'" id="edit_price_'.$trProcess.'" width="12" height="12"></span>';
						}
						$process_table .= '</td></tr>
						<tr><td>Value : </td><td>'.$rj->unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$rj->shipping_amount.'</td></tr>
						<tr><td>Discount : </td><td>'.-($rj->discount_amount).'</td></tr>
						<tr><td><b>Total : </b></td><td><b class="'.$price_class.'">'.$total.'</b></td></tr>
						<tr><td><b>Total in USD: </b></td><td><b class="'.$price_class.'">'.$usd_total.'</b></td></tr>
					</tbody>	
				</table>';
			
			if($_allow_cancel) {
				$process_table .= '<form method="post" name="update_price_form" id="update_price_form_'.$trProcess.'" action="'.base_url('index.php/erp_order/update_price').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$rj->order_id.'">
					<input type="hidden" name="product_id" value="'.$rj->product_id.'">
					<input type="text" name="updated_price" id="updated_price_'.$trProcess.'" class="tb10" style="width:110px;">
					<input type="submit" name="submit_price" id="submit_price" value="Update Price" class="styled-button-1" style="width:110px;">
				</form>';	
			}
				
			$process_table .= '</td>
			<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
			$process_table .= '<p>'.$rj->customer_name .' '. $rj->customer_lastname.'</p><br>
								<p>'.$rj->shipping_country.'</p><br>
								<p class="red">'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>
			</td>';
						
			$process_table .= '<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
						
			$process_table .= '<span id="dispatch_date">'.date("F j, Y", strtotime($dispatch_date)).'</span>';
			
			if($_allow_cancel) {
				$process_table .= '<span style="margin-left:15px;"><img src="'.$edit_image.'" id="edit_dispatch_date_'.$trProcess.'" width="12" height="12"></span>
				<form method="post" name="dispatch_form" id="dispatch_form_'.$trProcess.'" action="'.base_url('index.php/erp_order/update_dispatch_date').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$rj->order_id.'">
					<input type="hidden" name="product_id" value="'.$rj->product_id.'">
					<input type="text" name="updated_dispatch_date" id="updated_dispatch_date_'.$trProcess.'" class="tb10" style="width:110px;">
					<input type="hidden" name="controller" value="processing_orders">
					<input type="submit" name="submit_date" id="submit_date" value="Update Date" class="styled-button-1" style="width:110px;">
				</form>';
			}
						
			$process_table .= '</td>
			<td class="bottom right" style="padding-bottom: 4px;" width="300">';
			
			if($_allow_cancel) {
			
				$process_table .='<span style="margin-right: 25%;float: right;margin-top: 5px;"><img id="cancel_order_'.$trProcess.'" src="'.base_url('themes/images/cancel.jpg').'" alt="Cancel Order" border="0" height="12" width="12"></span>';	
				$process_table .= '<form method="POST" action="#" name="cancel_order_form" id="cancel_order_form_'.$trProcess.'" style="display:none;">
				<input type="hidden" name="order_id" value="'.$order_id.'" />
				<input type="hidden" name="order_product_id" value="'.$erp_order_id.'" />
				<input type="hidden" name="product_id" value="'.$product_id.'" />
				<input type="hidden" name="order_status_id" value="11" />
				<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />
				<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />
				<input type="hidden" name="personal_message" value="'.$personal_message.'" />
				<input type="hidden" name="website_id" value="'.$website_id.'" />
				<p><b>Notes</b></p>	
				<textarea name="notes" class="tb10"></textarea><br>
				<button type="button" name="btn_submit" class="styled-button-1" style="width:120px;" onclick="myFunction('.$trProcess.');">Cancel Order</button>
				</form>';
			}
										
			$process_table .='<form method="POST" action="#" name="order_update" id="order_update_'.$trProcess.'">';
			$process_table .='<input type="hidden" name="controller" value="processing_orders" />';
			$process_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
			$process_table .='<input type="hidden" name="order_product_id" value="'.$erp_order_id.'" />';
			$process_table .='<input type="hidden" name="order_status_id_hidden" value="'.$rj->order_status_id.'" />';
			$process_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />';
			$process_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';

			$process_table .= '<div id="status_'.$trProcess.'"><p><b>Status</b></p>';
			$process_table .= $status_dropdown.'<br></div>';
						
			$process_table .= '<div id="vendor_dis_'.$trProcess.'"><p><b>Vendor</b></p>';
			$process_table .= $vendor_dropdown.'<br></div>';
			
			//$process_table .= '<div id="greeting_dis_'.$trProcess.'"><label><b>Greeting Card</b></label>$greeting_dropdown.'<br>';
			
			$process_table .= '</div>';
			$process_table .= '<p><b>Notes</b></p>';
			$process_table .= '<textarea name="notes" class="tb10"></textarea><br>';
			$process_table .= '<button type="button" name="btn_submit" class="styled-button-1" onclick="save_order('.$trProcess.');">Update</button>';
			
			if($disable_status=='') {
				$process_table .= '<button type="button" name="btn_submit" class="styled-button-1" style="margin-left:10px;" onclick="set_next_state('.$trProcess.')" '.$disable_status.'>Next</button>';
			}
			
			$process_table .='</form>';
			
			$process_table .='<div class="popbox" >
							<a class="open" href="#" style="text-decoration:none;"><b style="font-size:20px;margin-top:0px;float:right;margin-right:38%;">+</b></a>
							<div class="collapse">
							  <div class="box">
								<div class="arrow"></div>
								<div class="arrow-border"></div>
								<div id="abcd">'.$all_notes.'</div>
							  </div>
							</div>
						  </div>';
						  
			$process_table .= '</td>';
		$process_table .= '</tr>';
		
		if($rj->diamond_1_status==1 || $rj->diamond_2_status==1 || $rj->diamond_3_status==1 || $rj->diamond_4_status==1 || $rj->diamond_5_status==1 || $rj->diamond_6_status==1 || $rj->diamond_7_status==1) {
		
		$process_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left"></td>';
				
		if($rj->diamond_1_status==1 || $rj->diamond_2_status==1 || $rj->diamond_3_status==1 || $rj->diamond_4_status==1 || $rj->diamond_5_status==1 || $rj->diamond_6_status==1 || $rj->diamond_7_status==1) {
		$process_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table style="display: table;width:auto;white-space: nowrap;" class="diamond_detail" id="diamond_detail">
			<tr><td colspan="8" ><b><u>Diamond Details</u></b></td></tr>
			<tr>
				<td><b>Clarity</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_clarity;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_clarity;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_4_clarity;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_clarity;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_clarity;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_clarity;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_clarity;}
				
			$process_table .='</tr>
			<tr><td><b>Color</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_color;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_color;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_color;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_color;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_color;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_color;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_color;}
						

			$process_table .= '</tr>
			<tr><td><b>Shape</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_shape;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_shape;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_shape;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_shape;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_shape;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_shape;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_shape;}
				
			$process_table .= '</tr>
			<tr><td><b>No. of Diamonds</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_stones;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_stones;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_stones;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_stones;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_stones;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_stones;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_stones;}
				
			$process_table .='</tr>
			<tr><td><b>Diamond Weight</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_weight;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_weight;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_weight;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_weight;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_weight;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_weight;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_weight;}
			
			$process_table .='</tr>
			<tr><td><b>Setting Type</b></td>';
			if($rj->diamond_1_status==1){$process_table .= $diamond_1_setting_type;}
			if($rj->diamond_2_status==1){$process_table .= $diamond_2_setting_type;}
			if($rj->diamond_3_status==1){$process_table .= $diamond_3_setting_type;}
			if($rj->diamond_4_status==1){$process_table .= $diamond_4_setting_type;}
			if($rj->diamond_5_status==1){$process_table .= $diamond_5_setting_type;}
			if($rj->diamond_6_status==1){$process_table .= $diamond_6_setting_type;}
			if($rj->diamond_7_status==1){$process_table .= $diamond_7_setting_type;}
				
			$process_table .= '</tr>
			</table>
		</td>
		<td class="bottom"></td>';
		}
		else {
			$process_table .= '<td colspan="3" align="center" class="bottom btm_padding"></td>';
		}
			
		if($rj->gem_1_status==1 || $rj->gem_2_status==1 || $rj->gem_3_status==1 || $rj->gem_4_status==1 || $rj->gem_5_status==1) {
		$process_table .= '<td colspan="3" align="center" class="top_btm_padding bottom right">
			<table style="display: table;width:auto;white-space: nowrap;" name="gemstone_detail" id="gemstone_detail">
			<tr><td colspan="6"><b><u>Gemstone Details</u></b></td></tr>
			<tr><td><b>No. of Gemstones</b></td>';
			
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_stone;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_stone;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_stone;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_stone;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_stone;}
				
			$process_table .='</tr>
			<tr><td><b>Gemstone Type</b></td>';
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_type;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_type;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_type;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_type;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_type;}
				
			$process_table .= '</tr>
			<tr><td><b>Gemstone Color</b></td>';
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_color;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_color;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_color;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_color;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_color;}
			
			$process_table .= '</tr>
			<tr><td><b>Shape</b></td>';
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_shape;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_shape;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_shape;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_shape;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_shape;}
			
			$process_table .= '</tr>
			<tr><td><b>Gemstone Weight</b></td>';
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_weight;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_weight;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_weight;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_weight;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_weight;}
				
			$process_table .= '</tr>
			<tr><td><b>Setting Type</b></td>';
			if($rj->gem_1_status==1){$process_table .= $gemstone_1_setting_type;}
			if($rj->gem_2_status==1){$process_table .= $gemstone_2_setting_type;}
			if($rj->gem_3_status==1){$process_table .= $gemstone_3_setting_type;}
			if($rj->gem_4_status==1){$process_table .= $gemstone_4_setting_type;}
			if($rj->gem_5_status==1){$process_table .= $gemstone_5_setting_type;}
				
			$process_table .= '</tr>
			</table>
		</td>';
		} else {
			$process_table .= '<td colspan="3" align="center" class="bottom right btm_padding"></td>';
		}
			$process_table .= '</tr>';
		}
		$trProcess++;
	}
} ?>
<?php $process_table .= '</table>';
echo $process_table; ?>

<!-- Pagination for Processing list -->
<?php 
if(count($processdata) > 10) {
	echo $this->pagination->create_links();
} ?>
		

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
</script>

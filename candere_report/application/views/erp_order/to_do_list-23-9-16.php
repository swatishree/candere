
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
				
				window.location.href ="<?php echo base_url()?>index.php/erp_order/to_do_list";
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
	//var flag 		= confirm("Do you want to update this order?");
	var form_data 	= $("#order_update_"+tr_id).serialize();
      	 //alert(form_data);
    //if(flag==true){
		 $.ajax({
			type: 'POST',
			url : "<?php echo base_url()?>index.php/erp_order/set_next_state",
			data : form_data,
			success : function(result) {
				 if(result=='success')
					//alert("Order Updated successfully");
				location.reload(); 
				else
					alert("Something went wrong. Please try againg.");
				
				location.reload(); 
			}
		}); 
   //} 
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
	
	//$('#direction').val($.cookie("sort_dir"));	
});
</script>

<div class="nav-top clearfix" style="display:table;min-height:50px;"><span style="font-size: 18px;font-weight: bold;">Order Management</span></div>


<?php 	$_username 		= @$this->session->userdata('_username');	
	    $logout_url 	= base_url().'index.php/login/logout';  ?>
		
<ul id="nav">
      <li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>">Home</a></li>
 	  <?php if($_username!='') { ?>
		<li><a href="<?php echo $logout_url ?>">Logout ( <?php echo ucwords($_username) ?> )</a></li>
	  <?php } ?>
</ul>

<div id="quotescointainer">
<div id="quotesleft">
<ul id="buttons">
   <?php
   if($this->session->userdata('_username')=='sales' || $this->session->userdata('_username')=='marketplace' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
	    <li class="active"><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li>
  
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
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php	
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/to_do_list').'">';
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
<span>		
<?php
echo '<form name="form_sort" id="form_sort" method="POST" action="'.$_SERVER['PHP_SELF'].'">';

$options = array(
				  'dispatch_date'  		=> 'Dispatch Date',
				  'order_placed_date'  	=> 'Order Placed Date',
				  'order_id'  			=> 'Order Id',
				);
echo form_dropdown('order_dispatch_date', $options, set_value('order_dispatch_date'), 'id="order_dispatch_date" class="SlectBox" style="width:150px;" onchange="this.form.submit();"');
echo '<input type="hidden" name="direction" id="direction" value="">';
echo '<a href="?dir=desc" style="text-decoration:none;display:none;" id="dir_toggle" class="change_dir">
<img src="'.base_url('themes/images/asc_arrow.gif').'" title="Set Descending Direction"></a>';
echo '<a href="?dir=asc" style="text-decoration:none;display:none;" id="dir_toggle_2" class="change_dir"><img src="'.base_url('themes/images/desc_arrow.gif').'" title="Set Ascending Direction"></a>';

echo '</form>'; ?>
</span>
			
</div>
</div>

<?php 		
	$order_table = '';
	$order_table = '<table width="100%" cellspacing=0 cellpadding=0 name="order_table" id="order_table" class="tablesorter" style="padding:0 10px 20px 10px;">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color">&nbsp;</th>
			<th colspan="2" align="left" class="th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color">Dispatch Date</th>
			<th align="left" class="th_color">Order Action</th>
		</tr>'; ?>					  

		
		
		<?php


if($selectdata)
{
	$array 		= array();
	$data 		= array();
	$counter 	= 1;
	$trCounter 	= 1;
	$_username 		= @$this->session->userdata('_username');
	$_allow_cancel 	= @$this->session->userdata('_allow_cancel');
	
	$order_status 	= $this->erpmodel->getAllStatus();
	$all_vendors 	= $this->erpmodel->getAllVendors();
	$getAllGreetings= $this->erpmodel->getAllGreetings();
		
	$status_option[''] = 'Select Status';
		foreach($order_status as $nb){
			$status_option[$nb->status_id] = $nb->status_name;
		}
		
	$vendor_option[''] = 'Select Vendor';
		foreach($all_vendors as $rw){ 
			$vendor_option[$rw->VendorID] = $rw->VendorName;
		}	
	
	$greeting_option[''] = 'Select Greeting';
		foreach($getAllGreetings as $rg){ 
			$greeting_option[$rg->greeting_card_id] = $rg->greeting_card_name;
		}
				
	foreach($selectdata as $row){
		$erp_id 			= $row->id;
		$order_id 			= $row->order_id;
		
		$product_id 		= $row->product_id;
		$erp_order_id 		= $row->erp_order_id;
		$personal_message 	= $row->personal_message;
		$greeting_card_id 	= $row->greeting_card_id;
		$order_product_id 	= $row->order_product_id;
		$order_item_id 	= $row->order_item_id;
				
		$expected_delivery_date = $row->expected_delivery_date;
		 $dispatch_date 			= $row->dispatch_date;
		
		if(strtotime($dispatch_date) < time()) {
			$dispatch_date 	= date("Y-m-d");
		} else {
			$dispatch_date 	= $row->dispatch_date;
		}
				
		
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);
					
		$getOrderData	= $this->erpmodel->getOrderData($order_id,$order_product_id);
		$getOrderNotes	= $this->erpmodel->getOrderNotes($order_id, $order_product_id);
		
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, H:i:s', strtotime($nt->updated_date));
				
				$all_notes .='<div class="notes_area"><br>
							<span style="float:left;"><b>'.$this->erpmodel->getStatusName($nt->order_status_id).'</b></span>
							<span style="float:right;"><b>'.$updated_date.'</b></span><br>
							<span style="float:left;"><b>'.$nt->updated_by.'</b></span><br>';
							if($nt->notes !='') {
								$all_notes .= '<span style="float:left;">'.$nt->notes.'</span>';
							}
							$all_notes .= '</div><br>';
			}
		}
		
		if(in_array($row->status, explode(',',$allow_status))) {
			$disable_status = '';
		} else {
			$disable_status = 'disabled';
		}
		
		$vend_status = ($disable_status == 'disabled') ? 'disabled' : '';
		
		$order_status_id 	= $getOrderData[0]->order_status_id;
		$vendor_id 			= $getOrderData[0]->vendor_id; 
		$notes 				= $getOrderData[0]->notes; 
		$greeting_card_id 	= $getOrderData[0]->greeting_card_id; 
		$website_id 		= $getOrderData[0]->website_id; 
				
		$disable = ($greeting_card_id==0) ? '' : "disabled";
		
		$key['status_id'] 	= $order_status_id;
		$getStatus			= $this->erpmodel->GetInfoRow('mststatus',$key);
		$status_name		= $getStatus[0]->status_name;
				
		$status_dropdown = form_dropdown('order_status_id', $status_option, $order_status_id, 'id="OrderStatusID_'.$trCounter.'" class="dropWidth" ');
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="VendorID_'.$trCounter.'", class="dropWidth" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trCounter.'", class="dropWidth", '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
		
		if($row->updated_price !=''){
			$unit_price = $row->updated_price;
		} else {
			$unit_price = $row->unit_price;
		}
				
		$total = number_format(($unit_price*$row->quantity) + $row->shipping_amount + $row->discount_amount,2);
		
		$usd_total_1 = (($unit_price*$row->quantity) + $row->shipping_amount + $row->discount_amount);
		$usd_total = number_format($usd_total_1*0.016,2);
		
		$diamond_1_stones 		= '<td>'.$row->diamond_1_stones.'</td>';
		$diamond_1_weight 		= '<td>'.$row->diamond_1_weight.'</td>';
		$diamond_1_clarity 		= '<td>'.$row->diamond_1_clarity.'</td>';
		$diamond_1_shape 		= '<td>'.$row->diamond_1_shape.'</td>';
		$diamond_1_color 		= '<td>'.$row->diamond_1_color.'</td>';
		$diamond_1_setting_type = '<td>'.$row->diamond_1_setting_type.'</td>';
		$diamond_2_stones 		= '<td>'.$row->diamond_2_stones.'</td>';
		$diamond_2_weight 		= '<td>'.$row->diamond_2_weight.'</td>';
		$diamond_2_clarity 		= '<td>'.$row->diamond_2_clarity.'</td>';
		$diamond_2_shape 		= '<td>'.$row->diamond_2_shape.'</td>';
		$diamond_2_color 		= '<td>'.$row->diamond_2_color.'</td>';
		$diamond_2_setting_type = '<td>'.$row->diamond_2_setting_type.'</td>';
		$diamond_3_stones 		= '<td>'.$row->diamond_3_stones.'</td>';
		$diamond_3_weight 		= '<td>'.$row->diamond_3_weight.'</td>';
		$diamond_3_clarity 		= '<td>'.$row->diamond_3_clarity.'</td>';
		$diamond_3_shape 		= '<td>'.$row->diamond_3_shape.'</td>';
		$diamond_3_color 		= '<td>'.$row->diamond_3_color.'</td>';
		$diamond_3_setting_type = '<td>'.$row->diamond_3_setting_type.'</td>';
		$diamond_4_stones 		= '<td>'.$row->diamond_4_stones.'</td>';
		$diamond_4_weight 		= '<td>'.$row->diamond_4_weight.'</td>';
		$diamond_4_clarity 		= '<td width="60">'.$row->diamond_4_clarity.'</td>';
		$diamond_4_shape 		= '<td>'.$row->diamond_4_shape.'</td>';
		$diamond_4_color 		= '<td>'.$row->diamond_4_color.'</td>';
		$diamond_4_setting_type = '<td>'.$row->diamond_4_setting_type.'</td>';
		$diamond_5_stones 		= '<td>'.$row->diamond_5_stones.'</td>';
		$diamond_5_weight 		= '<td>'.$row->diamond_5_weight.'</td>';
		$diamond_5_clarity 		= '<td>'.$row->diamond_5_clarity.'</td>';
		$diamond_5_shape 		= '<td>'.$row->diamond_5_shape.'</td>';
		$diamond_5_color 		= '<td>'.$row->diamond_5_color.'</td>';
		$diamond_5_setting_type = '<td>'.$row->diamond_5_setting_type.'</td>';
		$diamond_6_stones 		= '<td>'.$row->diamond_6_stones.'</td>';
		$diamond_6_weight 		= '<td>'.$row->diamond_6_weight.'</td>';
		$diamond_6_clarity 		= '<td>'.$row->diamond_6_clarity.'</td>';
		$diamond_6_shape 		= '<td>'.$row->diamond_6_shape.'</td>';
		$diamond_6_color 		= '<td>'.$row->diamond_6_color.'</td>';
		$diamond_6_setting_type = '<td>'.$row->diamond_6_setting_type.'</td>';
		$diamond_7_stones 		= '<td>'.$row->diamond_7_stones.'</td>';
		$diamond_7_weight 		= '<td>'.$row->diamond_7_weight.'</td>';
		$diamond_7_clarity 		= '<td>'.$row->diamond_7_clarity.'</td>';
		$diamond_7_shape 		= '<td>'.$row->diamond_7_shape.'</td>';
		$diamond_7_color 		= '<td>'.$row->diamond_7_color.'</td>';
		$diamond_7_setting_type = '<td>'.$row->diamond_7_setting_type.'</td>';
		$gemstone_1_stone 		= '<td>'.$row->gemstone_1_stone.'</td>';
		$gemstone_1_type 		= '<td>'.$row->gemstone_1_type.'</td>';
		$gemstone_1_color 		= '<td>'.$row->gemstone_1_color.'</td>';
		$gemstone_1_shape 		= '<td>'.$row->gemstone_1_shape.'</td>';
		$gemstone_1_setting_type= '<td>'.$row->gemstone_1_setting_type.'</td>';
		$gemstone_1_weight 		= '<td>'.$row->gemstone_1_weight.'</td>';
		$gemstone_2_stone 		= '<td>'.$row->gemstone_2_stone.'</td>';
		$gemstone_2_type 		= '<td>'.$row->gemstone_2_type.'</td>';
		$gemstone_2_color 		= '<td>'.$row->gemstone_2_color.'</td>';
		$gemstone_2_shape 		= '<td>'.$row->gemstone_2_shape.'</td>';
		$gemstone_2_setting_type= '<td>'.$row->gemstone_2_setting_type.'</td>';
		$gemstone_2_weight 		= '<td>'.$row->gemstone_2_weight.'</td>';
		$gemstone_3_stone 		= '<td>'.$row->gemstone_3_stone.'</td>';
		$gemstone_3_type 		= '<td>'.$row->gemstone_3_type.'</td>';
		$gemstone_3_color 		= '<td>'.$row->gemstone_3_color.'</td>';
		$gemstone_3_shape 		= '<td>'.$row->gemstone_3_shape.'</td>';
		$gemstone_3_setting_type= '<td>'.$row->gemstone_3_setting_type.'</td>';
		$gemstone_3_weight 		= '<td>'.$row->gemstone_3_weight.'</td>';
		$gemstone_4_stone 		= '<td>'.$row->gemstone_4_stone.'</td>';
		$gemstone_4_type 		= '<td>'.$row->gemstone_4_type.'</td>';
		$gemstone_4_color 		= '<td>'.$row->gemstone_4_color.'</td>';
		$gemstone_4_shape 		= '<td>'.$row->gemstone_4_shape.'</td>';
		$gemstone_4_setting_type= '<td>'.$row->gemstone_4_setting_type.'</td>';
		$gemstone_4_weight 		= '<td>'.$row->gemstone_4_weight.'</td>';
		$gemstone_5_stone 		= '<td>'.$row->gemstone_5_stone.'</td>';
		$gemstone_5_type 		= '<td>'.$row->gemstone_5_type.'</td>';
		$gemstone_5_color 		= '<td>'.$row->gemstone_5_color.'</td>';
		$gemstone_5_shape 		= '<td>'.$row->gemstone_5_shape.'</td>';
		$gemstone_5_setting_type= '<td>'.$row->gemstone_5_setting_type.'</td>';
		$gemstone_5_weight 		= '<td>'.$row->gemstone_5_weight.'</td>';
		
		$product_url = str_replace('candere_report/',$row->product_url,base_url()); 
			

		$order_table .= '<tr class="'.$bgclass.' main_tr" id="'.$trCounter.'"  >
			<td class="border left bottom" width="20" valign="top" style="padding-top:40px;">&nbsp;</td>	
			<td class="border bottom" width="275" style="color:#0066cc;" valign="top" style="padding-top:10px;">
			<b>Order Id : '.$row->order_id.'</b><br>
			<b>Order Item Id : '.$row->order_item_id.'</b><br>
			<b>Agent Name : '.$row->agent_name.'</b><br>
			<a target="_blank" href="'.$row->product_image.'"><img src="'.$row->product_image.'" height="120" width="120" class="img_padding"></a>
			 
			
			
			<form action="'.base_url('index.php/erp_order/showimage').'" target="_blank" enctype="multipart/form-data"  method = "post">
		 <input type="hidden" name="erp_order_id" value="'.$row->erp_order_id.'">
		 <input type="hidden" name="order_item_id" value="'.$row->order_item_id.'">
		 <input type="hidden" name="product_id" value="'.$row->product_id.'">
		 <input type="hidden" name="metal" value="'.$row->metal.'">
         <br /><br /> 
         <input type = "submit" value = "more images" /> 
      </form> 
	  
			<form action="'.base_url('index.php/erp_order/imageupload').'"  enctype="multipart/form-data"  method = "post">
         <input type = "file" name = "myimage" size = "20" /> 
		 <input type="hidden" name="erp_order_id" value="'.$row->erp_order_id.'">
         <br /><br /> 
         <input type = "submit" value = "upload" /> 
      </form> 
	  
	  <form action="'.base_url('index.php/erp_order/exportdata').'"  enctype="multipart/form-data"  method = "post">
		 <input type="hidden" name="erp_order_id" value="'.$row->erp_order_id.'">
		 <input type="hidden" name="order_id" value="'.$row->order_id.'">
         <br /><br /> 
         <input type = "submit" value = "export data" /> 
      </form> 
	  
	  
			
			</td>
					
			<td class="bottom" width="580" style="padding-top:10px;" valign="top">
				<table name="product_data" width="100%" style="">
					<tbody>
						<tr><td><b>SKU : </b>'.$row->sku.'&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b>
							</td></tr>
                          <tr><td><b>CUSTOM SKU : </b>'.$row->sku_custom.'&nbsp;&nbsp;&nbsp;
 							</td></tr>								
						<tr><td width="100"><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$row->product_name.'</a></b> &nbsp;&nbsp;&nbsp;<b style="color:#0066CC;float:right;margin-right:10%;">'.$row->design_identifier.'</b></td>
						</tr>
						<tr>
							<td width="400">
							<table name="order_data" width="100%">
							<tbody>
								<tr><td width="200"><b>Order Date : </b>'.date("F j, Y", strtotime($row->order_placed_date)).'</td>
								</tr>';
								
								$order_table .='<tr>';
								if($row->metal!='') {
									$order_table .='<td><b>Metal : </b>'.$row->metal.'</td>';
								}
								$order_table .='</tr>';
								$order_table .='<tr>';
								
								if($row->mktplace_name!='')
								{
									$order_table .='<td><b>Marketplace name : </b>'.$row->mktplace_name.'</td>';
								}
								$order_table .='</tr>';
								$order_table .='<tr>';
								if($row->mktplace_order_id!='')
								{
									$order_table .='<td><b>Marketplace Order id : </b>'.$row->mktplace_order_id.'</td>';
								}
								$order_table .='</tr>';
								$order_table .='<tr>';
								if($row->mktplace_sub_order_id!='')
								{
									$order_table .='<td><b>Marketplace Sub Order Id : </b>'.$row->mktplace_sub_order_id.'</td>';
								}
								$order_table .='</tr>';
								$order_table .='<tr>';
								if($row->purity!='') {
									$order_table .='<td><b>Purity : </b>'.$row->purity.'</td>';
								}
								$order_table .='</tr>';
								
								$order_table .='<tr>';
								if($row->height!='') {
									$order_table .= '<td><b>Height : </b>'.$row->height.' mm</td>';
								}
								if($row->height!='') {
									$order_table .= '<td><b>Width : </b>'.$row->width.' mm</td>';
								}
								$order_table .='</tr>';
								$order_table .='<tr>';
								
								if($row->engrave_message!='') {
									$order_table .= '<td><b>Engrave Message : </b>'.$row->engrave_message.'</td>';
								}
								$order_table .='</tr>';
								
								
								$order_table .='<tr>';
								
								if($row->ring_size!='0') {
									$order_table .= '<td><b>Ring Size : </b>'.$row->ring_size.'</td>';
								}
								$order_table .='</tr>';
								
								$order_table .= '<tr>';
								if($row->top_thickness) {
									$order_table .='<td width="150"><b>Top Thickness : </b>'.$row->top_thickness.' mm</td>';
									}
								if($row->bottom_thickness) {	
									$order_table .='<td width="150" class="nowrap"><b>Bottom Thickness :</b>'.$row->bottom_thickness.' mm</td>';
								}
								$order_table .= '</tr>';
								
								
								$order_table .= '<tr>';
								if($row->bracelet_length) {
									$order_table .='<td width="150"><b>bracelet length : </b>'.$row->bracelet_length.' mm</td>';
									}
								if($row->bangle_size) {	
									$order_table .='<td width="150" class="nowrap"><b>bangle_size :</b>'.$row->bangle_size.' mm</td>';
								}
								$order_table .= '</tr>';
								
								
								$order_table .= '<tr>';
								if($row->chain_thickness) {
									$order_table .='<td width="150"><b>chain Thickness : </b>'.$row->chain_thickness.' mm</td>';
									}
								if($row->chain_length) {	
									$order_table .='<td width="150" class="nowrap"><b>Chain Length:</b>'.$row->chain_length.' mm</td>';
								}
								$order_table .= '</tr>';
								
								$order_table .= '<tr>';
								if($row->top_height!='') {
									$order_table .= ' <td width="125"><b>Top Height : </b>'.$row->top_height.' mm</td>';
								}	
								if($row->total_weight!='') {	
									$order_table .='<td width="140"><b>Total Weight : </b>'.$row->total_weight.' gms</td>';
								}
								if($row->metal_weight!='') {	
									$order_table .='<td width="140"><b>Metal Weight : </b>'.$row->metal_weight.' gms</td>';
								}
								
								
								
								
								$order_table .= '<tr>';
								if($row->description!='') {	
									$order_table .='<td width="140"><b>special comments: : </b>'.$row->description.'</td>';
								}
								$order_table .= '</tr>';
								
								
								$order_table .= '<tr>';
								
								
								
								if($row->buyer_address!='') {	
									$order_table .='<td width="140"><b>Buyer Address : </b>'.$row->buyer_address.'</td>';
								}
								
								$order_table .= '</tr></tbody>
							</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			
			<td class="bottom" width="200" valign="top" style="padding-top:10px;">';
			
			$quan_class = ($row->quantity > 1) ? 'red' : '';
			
			$price_class = ($row->total_due > 0) ? 'red' : '';
			
			$edit_image = base_url('themes/images/edit.png');
			
			$order_table .= '<table name="order_detail" width="100%">
					<tbody>
						<tr><td valign="top"> 
						<b>Qty : <span class="'.$quan_class.'">'.$row->quantity.'</span></b>';
						if($_allow_cancel) {
						$order_table .= '<span style="margin-right: -60%;float: right;"><img src="'.$edit_image.'" id="edit_price_'.$trCounter.'" width="12" height="12"></span>';
						}
						$order_table .= '</td></tr>
						<tr><td>Value : </td><td>'.$unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$row->shipping_amount.'</td></tr>
						<tr><td>Discount : </td><td>'.-($row->discount_amount).'</td></tr>
						<tr><td><b>Total in Rs: </b></td><td><b class="'.$price_class.'">'.$total.'</b></td></tr>
						<tr><td><b>Total in USD: </b></td><td><b class="'.$price_class.'">'.$usd_total.'</b></td></tr>
					</tbody>	
				</table>';
				
			if($_allow_cancel) {
				$order_table .= '
				<form method="post" name="update_price_form" id="update_price_form_'.$trCounter.'" action="'.base_url('index.php/erp_order/update_price').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$row->order_id.'">
					<input type="hidden" name="product_id" value="'.$row->product_id.'">
					<input type="hidden" name="controller" value="to_do_list">
					<input type="text" name="updated_price" id="updated_price_'.$trCounter.'" class="tb10" style="width:110px;">
					<input type="submit" name="submit_price" id="submit_price" value="Update Price" class="styled-button-1" style="width:110px;margin-top:5px;">
				</form>';
			}	
			
			$order_table .='</td>
			<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
			$order_table .= '<p>'.$row->customer_name .' '. $row->customer_lastname.'</p><br>
								<p>'.$row->shipping_country.'</p><br>
								<p class="red">'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>';
			$order_table .= '</td>';
			$order_table .= '<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
			$order_table .= '<span id="dispatch_date">'.date("F j, Y", strtotime($dispatch_date)).'</span>';
			
			if($_allow_cancel) { 
				$order_table .= '<span style="margin-left:10px;"><img src="'.$edit_image.'" id="edit_dispatch_date_'.$trCounter.'" width="10" height="10"></span>
			
				<form method="post" name="dispatch_form" id="dispatch_form_'.$trCounter.'" action="'.base_url('index.php/erp_order/update_dispatch_date').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$row->order_id.'">
					<input type="hidden" name="product_id" value="'.$row->product_id.'">
					<input type="hidden" name="controller" value="to_do_list">
					<input type="text" name="updated_dispatch_date" id="updated_dispatch_date_'.$trCounter.'" class="tb10" style="width:110px;">
					<input type="submit" name="submit_date" id="submit_date" value="Update Date" class="styled-button-1" style="width:110px;">
				</form>';
			}
						
			$order_table .= '</td>
			
			<td class="bottom right" width="300" valign="top" style="padding-top:10px;">';
			
			
		if($_allow_cancel) {	
		$order_table .='<span style="margin-right: 25%;float: right;margin-top: 10px;"><img id="cancel_order_'.$trCounter.'" src="'.base_url('themes/images/cancel.jpg').'" alt="Cancel Order" border="0" height="12" width="12"></span>';			
		$order_table .= '<form method="POST" action="#" name="cancel_order_form" id="cancel_order_form_'.$trCounter.'" style="display:none;">
		<input type="hidden" name="order_id" value="'.$order_id.'" />
		<input type="hidden" name="order_product_id" value="'.$erp_order_id.'" />
		<input type="hidden" name="product_id" value="'.$product_id.'" />
		<input type="hidden" name="order_status_id" value="11" />
		<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />
		<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />
		<input type="hidden" name="personal_message" value="'.$personal_message.'" />
		<input type="hidden" name="website_id" value="'.$website_id.'" />
		<p><b>Notes</b></p>	
		<textarea name="notes" class="tb10"></textarea><br><br>
		<button type="button" name="btn_submit" class="styled-button-1" style="width:115px;" onclick="myFunction('.$trCounter.');" >Cancel Order</button>
		</form>';
			}
		
		$order_table .='<form method="POST" action="#" name="order_update" id="order_update_'.$trCounter.'" style="">';
			
		$order_table .='<input type="hidden" name="controller" value="to_do_list" />';
		$order_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
		$order_table .='<input type="hidden" name="order_product_id" value="'.$erp_order_id.'" />';
		$order_table .='<input type="hidden" name="order_item_id" value="'.$order_item_id.'" />';
		$order_table .='<input type="hidden" name="order_status_id_1" value="'.$row->order_status_id.'" />';
		$order_table .='<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />';
		$order_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />';
		$order_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';
		$order_table .='<input type="hidden" name="website_id" value="'.$website_id.'" />';
		$order_table .= '<p><b>Notes</b></p>';
		$order_table .= '<textarea name="notes" class="tb10"></textarea><br><br>';
		//$order_table .= '<input type="submit" name="btn_submit" value="Next" class="styled-button-1">';
		$order_table .= '<button type="button" name="btn_submit" class="styled-button-1" onclick="set_next_state('.$trCounter.');">Next</button>';
		$order_table .='</form>';
					
		$order_table .='<div class="popbox">
							<a class="open" href="#" style="text-decoration:none;"><b style="font-size:20px;margin-top:0px;">+</b></a>
							<div class="collapse">
							  <div class="box">
								<div class="arrow"></div>
								<div class="arrow-border"></div>
								<div id="abcd">'.$all_notes.'</div>
							  </div>
							</div>
						  </div>';
					
		$order_table .= '</td></tr>';
		
		// if($row->diamond_1_status==1 || $row->diamond_2_status==1 || $row->diamond_3_status==1 || $row->diamond_4_status==1 || $row->diamond_5_status==1 || $row->diamond_6_status==1 || $row->diamond_7_status==1) {
		
		$order_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left">&nbsp;</td>';
				
		if($row->diamond_1_status==1 || $row->diamond_2_status==1 || $row->diamond_3_status==1 || $row->diamond_4_status==1 || $row->diamond_5_status==1 || $row->diamond_6_status==1 || $row->diamond_7_status==1) {
		$order_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table class="diamond_detail" id="diamond_detail" style="display: table;width:auto;white-space: nowrap;">
			<tr><td colspan="8" align="left"><b><u>Diamond Details</u></b></td></tr>
			<tr>
				<td><b>Clarity</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_clarity;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_clarity;}
				if($row->diamond_3_status==1){$order_table .= $diamond_4_clarity;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_clarity;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_clarity;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_clarity;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_clarity;}
				
			$order_table .='</tr>
			<tr><td><b>Color</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_color;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_color;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_color;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_color;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_color;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_color;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_color;}
			
			$order_table .= '</tr>
			<tr><td><b>Shape</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_shape;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_shape;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_shape;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_shape;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_shape;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_shape;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_shape;}
				
			$order_table .= '</tr>
			<tr><td><b>No. of Diamonds</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_stones;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_stones;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_stones;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_stones;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_stones;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_stones;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_stones;}
				
			$order_table .='</tr>
			<tr><td><b>Diamond Weight</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_weight;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_weight;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_weight;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_weight;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_weight;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_weight;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_weight;}
			
			$order_table .='</tr>
			<tr><td><b>Setting Type</b></td>';
			if($row->diamond_1_status==1){$order_table .= $diamond_1_setting_type;}
			if($row->diamond_2_status==1){$order_table .= $diamond_2_setting_type;}
			if($row->diamond_3_status==1){$order_table .= $diamond_3_setting_type;}
			if($row->diamond_4_status==1){$order_table .= $diamond_4_setting_type;}
			if($row->diamond_5_status==1){$order_table .= $diamond_5_setting_type;}
			if($row->diamond_6_status==1){$order_table .= $diamond_6_setting_type;}
			if($row->diamond_7_status==1){$order_table .= $diamond_7_setting_type;}
				
			$order_table .= '</tr>
			</table>
		</td>
		<td class="bottom">&nbsp;</td>';
		}
		else {
			$order_table .= '<td colspan="3" align="center" class="bottom btm_padding">&nbsp;</td>';
		}
			
		if($row->gem_1_status==1 || $row->gem_2_status==1 || $row->gem_3_status==1 || $row->gem_4_status==1 || $row->gem_5_status==1) {
			 
		$order_table .= '<td colspan="3" align="center" class="top_btm_padding bottom right">
			<table style="display: table;width:auto;white-space: nowrap;" name="gemstone_detail" id="gemstone_detail">
			<tr><td colspan="6"><b><u>Gemstone Details</u></b></td></tr>
			<tr><td><b>No. of Gemstones</b></td>';
			
			if($row->gem_1_status==1){$order_table .= $gemstone_1_stone;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_stone;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_stone;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_stone;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_stone;}
				
			$order_table .='</tr>
			<tr><td><b>Gemstone Type</b></td>';
			if($row->gem_1_status==1){$order_table .= $gemstone_1_type;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_type;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_type;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_type;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_type;}
				
			$order_table .= '</tr>
			<tr><td><b>Gemstone Color</b></td>';
			if($row->gem_1_status==1){$order_table .= $gemstone_1_color;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_color;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_color;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_color;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_color;}
			
			$order_table .= '</tr>
			<tr><td><b>Shape</b></td>';
			if($row->gem_1_status==1){$order_table .= $gemstone_1_shape;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_shape;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_shape;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_shape;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_shape;}
			
			$order_table .= '</tr>
			<tr><td><b>Gemstone Weight</b></td>';
			if($row->gem_1_status==1){$order_table .= $gemstone_1_weight;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_weight;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_weight;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_weight;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_weight;}
				
			$order_table .= '</tr>
			<tr><td><b>Setting Type</b></td>';
			if($row->gem_1_status==1){$order_table .= $gemstone_1_setting_type;}
			if($row->gem_2_status==1){$order_table .= $gemstone_2_setting_type;}
			if($row->gem_3_status==1){$order_table .= $gemstone_3_setting_type;}
			if($row->gem_4_status==1){$order_table .= $gemstone_4_setting_type;}
			if($row->gem_5_status==1){$order_table .= $gemstone_5_setting_type;}
				
			$order_table .= '</tr>
			</table>
		</td>';
		} else {
			$order_table .= '<td colspan="3" align="center" class="bottom right btm_padding">&nbsp;</td>';
		}
			$order_table .= '</tr>';
		//}
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

<?php
        // print_r($myimage);
		if($myimage) {
	 
	 
	 for($i=0;$i<count($myimage);$i++)
	 {
		 echo '<img src="'.$myimage[$i].'" width="500" height="500"/>' ;
		  
		 
	 }  ?>
	 
	  <button onclick="location.href='<?php echo base_url();?>index.php/erp_order/to_do_list'">Back</button>
	 
	<?php
}
 ?>


<?php
// $this->email->from('akhilesh.pandey@candere.com','Akhilesh');
// $this->email->to('akhi.90.pandey@candere.com');
 
// $this->email->subject('Email Test');
// $this->email->message('Testing the email class.');
// $this->email->send();
?>

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

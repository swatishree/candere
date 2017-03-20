<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
});

$(document).ready(function(){
	$('#complete_table tr').hover(function() {
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
				
				window.location.href ="<?php echo base_url()?>index.php/erp_order/cancelled_orders";
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
				
				//window.location.href ="<?php echo base_url()?>index.php/erp_order/cancelled_orders";
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
	
	//$('#direction').val($.cookie("sort_dir"));	
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
   if($this->session->userdata('_username')=='cad' || $this->session->userdata('_username')=='manufacturing' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?>
	    <li><a href="<?php echo base_url('index.php/erp_order/to_do')?>"><b>To Do</b></a></li>  
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
	<li class="active"><a href="<?php echo base_url('index.php/erp_order/completed_orders')?>"><b>Completed Orders</b></a></li>
	<?php
    if($this->session->userdata('_username')=='procurement' || $this->session->userdata('_username')=='Rupesh Jain')
    { ?>
	 <li><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>"><b>Vendor List</b></a></li>
     <?php } ?>
	 <li><a href="<?php echo base_url('index.php/erp_order/send_email?param=inbox')?>"><b>Send Email (<?php echo count($query_inbox); ?>)</b></a></li>
	 <li><a href="<?php echo base_url('index.php/erp_order/delayed')?>"><b>Delayed Delivery</b></a></li>
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php	
$sl_val = str_replace("'","",$this->session->userdata('search_by')) ;
 $options1 = array(
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
				  'BullionIndia'  =>		'BullionIndia',
				  'Paytm'  =>		'Paytm'
				);
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/completed_orders').'">';
		$allow_status 	= @$this->session->userdata('order_status'); 
		$show_orders 	= $this->erpmodel->getAllStatus();
		
		$user_status = '';
		foreach($show_orders as $ab){
			$user_status[$ab->status_id] = $ab->status_name;
		}
			
		echo '<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:100px;height:31px;" value="'.set_value('search_order_id').'">';	
		echo form_multiselect('search_by[]', $options1, $sl_val, 'id="search_by" class="SlectBox" style="width:150px;"');
		//echo $status_dropdown = form_multiselect('search_status_id[]', $user_status, set_value('search_status_id'), 'id="search_status_id" class="SlectBox" placeholder="Select Status"');	
		echo '<input type="submit" name="sts_submit" value="Search" class="styled-button-1">';
		//echo '<input type="submit" id="select_all" name="select_all" value="Select All " class="styled-button-1"></span>'; 
echo '</form>'; ?>
<form method="post" action="<?php echo base_url('index.php/erp_order/reset_search') ; ?>">
<input type="hidden" name="viewtype" value="complete">
<input type="submit" name="sts_submit" value="reset" class="styled-button-1">
</form>

</div>

<div id="quotesright" style="padding-top:16px;">
<span>			
<?php
echo '<form name="form_completed_sort" id="form_completed_sort" method="POST" action="'.$_SERVER['PHP_SELF'].'">';
$options = array(
					'order_id'  				=> 'Order Id',
					'dispatch_date'  			=> 'Dispatch Date',
					'order_placed_date'  		=> 'Order Placed Date',				  
				);
echo form_dropdown('order_dispatch_date', $options, set_value('order_dispatch_date'), 'id="order_dispatch_date_1" class="SlectBox" style="width:150px;" onchange="this.form.submit();"');
echo '<input type="hidden" name="direction_1" id="direction_1" value="">';
echo '<a href="?dir1=desc" style="text-decoration:none;display:none;" id="dir_toggle" class="change_dir">
<img src="'.base_url('themes/images/asc_arrow.gif').'" title="Set Descending Direction"></a>';
echo '<a href="?dir=asc" style="text-decoration:none;display:none;" id="dir_toggle_2" class="change_dir"><img src="'.base_url('themes/images/desc_arrow.gif').'" title="Set Ascending Direction"></a>';
echo '</form>'; ?>	
<script>
$(document).ready(function() {
	$("#dir_toggle").click(function(){
		$("#dir_toggle_2").show();
		$("#dir_toggle").hide();
		var status_id = $(this).attr('href').split('=');
		$.cookie("sort_dir", status_id[1], { expires: 1 });
		$('#direction').val($.cookie("sort_dir")); 
		$("#form_completed_sort").submit();
		return false;
	});
	
	$("#dir_toggle_2").click(function(){
		$("#dir_toggle_2").hide();
		$("#dir_toggle").show();
		var status_id = $(this).attr('href').split('=');
		$.cookie("sort_dir", status_id[1], { expires: 1 });
		$('#direction').val($.cookie("sort_dir"));  
		$("#form_completed_sort").submit();
		return false;
	});
	if($.cookie("sort_dir") == 'asc'){
		$("#dir_toggle").show();
		return false;
	} else if($.cookie("sort_dir") == 'desc'){
		$("#dir_toggle_2").show();
		return false;
	} else {
		$("#dir_toggle").show();
		return false;
	}
	
	//$('#direction').val($.cookie("sort_dir"));	
});
</script>
</span>
			
</div>
<form action="<?php echo base_url('index.php/erp_order/completed_orders'); ?>" enctype="multipart/form-data" method="post">
	<br /> 
	<input type = "submit" value = "Export Data" name="sbmt_completed_order" id="sbmt_completed_order" class="styled-button-1" style="width:150px;" />
</form>
</div>
	
<?php 
	$complete_table = '';
	$complete_table = '<table width="100%" cellspacing=0 cellpadding=0 class="complete_table" name="complete_table" id="complete_table" style="padding:0 10px 20px 10px;">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color">&nbsp;</th>
			<th colspan="2" align="left" class="th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color">Dispatch Date</th>
			<th align="left" class="th_color">Order Action</th>
		</tr>'; ?>		
<?php
if($completedata1)
{
	$array 		= array();
	$counter 	= 1;
	$trCount 	= 1;
	$_username 	= @$this->session->userdata('_username');
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
				
	foreach($completedata1 as $rss){
		$erp_id 	= $rss->id;
		$order_id 	= $rss->order_id;
		$product_id = $rss->product_id;
		$erp_order_id = $rss->erp_order_id;
		$order_product_id = $rss->order_product_id;
		
		$expected_delivery_date = $rss->expected_delivery_date;
		$dispatch_date 			= $rss->dispatch_date;
		
		/*if(strtotime($dispatch_date) < time()) {
			$dispatch_date 	= date("Y-m-d");
		} else {
			$dispatch_date 	= $rss->dispatch_date;
		}*/
		
		$personal_message 	= $rss->personal_message;
		$greeting_card_id 	= $rss->greeting_card_id;
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);		
		$getOrderData		= $this->erpmodel->getOrderData($order_id,$order_product_id);
		$getOrderNotes		= $this->erpmodel->getOrderNotes($order_id,$order_product_id);
			
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, g:i a', strtotime($nt->updated_date));
				
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
		
		if(in_array($rss->status, explode(',',$allow_status))) {
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
				
		$stat_disable 	= ($order_status_id==0) ? '' : "disabled";
		$ven_disable 	= ($vendor_id==0) ? '' : "disabled";
		$disable 		= ($greeting_card_id==0) ? '' : "disabled";
		
		$key['sequence'] 	= $order_status_id;
		$getStatus			= $this->erpmodel->GetInfoRow('mststatus',$key);
		$status_name		= $getStatus[0]->status_name;
				
		$status_dropdown = form_dropdown('order_status_id', $status_option, $order_status_id, 'id="OrderStatusID_'.$trCount.'" class="dropWidth" ');
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="VendorID_'.$trCount.'", class="dropWidth" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trCount.'" class="dropWidth"  '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
		
		if($rss->updated_price !=''){
			$unit_price = $rss->updated_price;
		} else {
			$unit_price = $rss->unit_price;
		}
				
		$total = number_format(($rss->unit_price*$rss->quantity) + $rss->shipping_amount + $rss->discount_amount,2);
		$usd_total_1 = (($unit_price*$rss->quantity) + $rss->shipping_amount + $rss->discount_amount);
		$usd_total = number_format($usd_total_1*0.016,2);
		
		$diamond_1_stones 		= '<td>'.$rss->diamond_1_stones.'</td>';
		$diamond_1_weight 		= '<td>'.$rss->diamond_1_weight.'</td>';
		$diamond_1_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_1_clarity).'</td>';
		$diamond_1_shape 		= '<td>'.$rss->diamond_1_shape.'</td>';
		$diamond_1_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_1_color).'</td>';
		$diamond_1_setting_type = '<td>'.$rss->diamond_1_setting_type.'</td>';
		$diamond_2_stones 		= '<td>'.$rss->diamond_2_stones.'</td>';
		$diamond_2_weight 		= '<td>'.$rss->diamond_2_weight.'</td>';
		$diamond_2_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_2_clarity).'</td>';
		$diamond_2_shape 		= '<td>'.$rss->diamond_2_shape.'</td>';
		$diamond_2_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_2_color).'</td>';
		$diamond_2_setting_type = '<td>'.$rss->diamond_2_setting_type.'</td>';
		$diamond_3_stones 		= '<td>'.$rss->diamond_3_stones.'</td>';
		$diamond_3_weight 		= '<td>'.$rss->diamond_3_weight.'</td>';
		$diamond_3_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_3_clarity).'</td>';
		$diamond_3_shape 		= '<td>'.$rss->diamond_3_shape.'</td>';
		$diamond_3_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_3_color).'</td>';
		$diamond_3_setting_type = '<td>'.$rss->diamond_3_setting_type.'</td>';
		$diamond_4_stones 		= '<td>'.$rss->diamond_4_stones.'</td>';
		$diamond_4_weight 		= '<td>'.$rss->diamond_4_weight.'</td>';
		$diamond_4_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_4_clarity).'</td>';
		$diamond_4_shape 		= '<td>'.$rss->diamond_4_shape.'</td>';
		$diamond_4_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_4_color).'</td>';
		$diamond_4_setting_type = '<td>'.$rss->diamond_4_setting_type.'</td>';
		$diamond_5_stones 		= '<td>'.$rss->diamond_5_stones.'</td>';
		$diamond_5_weight 		= '<td>'.$rss->diamond_5_weight.'</td>';
		$diamond_5_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_5_clarity).'</td>';
		$diamond_5_shape 		= '<td>'.$rss->diamond_5_shape.'</td>';
		$diamond_5_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_5_color).'</td>';
		$diamond_5_setting_type = '<td>'.$rss->diamond_5_setting_type.'</td>';
		$diamond_6_stones 		= '<td>'.$rss->diamond_6_stones.'</td>';
		$diamond_6_weight 		= '<td>'.$rss->diamond_6_weight.'</td>';
		$diamond_6_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_6_clarity).'</td>';
		$diamond_6_shape 		= '<td>'.$rss->diamond_6_shape.'</td>';
		$diamond_6_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_6_color).'</td>';
		$diamond_6_setting_type = '<td>'.$rss->diamond_6_setting_type.'</td>';
		$diamond_7_stones 		= '<td>'.$rss->diamond_7_stones.'</td>';
		$diamond_7_weight 		= '<td>'.$rss->diamond_7_weight.'</td>';
		$diamond_7_clarity 		= '<td>'.$this->erpmodel->getDiamondClarity($rss->diamond_7_clarity).'</td>';
		$diamond_7_shape 		= '<td>'.$rss->diamond_7_shape.'</td>';
		$diamond_7_color 		= '<td>'.$this->erpmodel->getDiamondColor($rss->diamond_7_color).'</td>';
		$diamond_7_setting_type = '<td>'.$rss->diamond_7_setting_type.'</td>';
		$gemstone_1_stone 		= '<td>'.$rss->gemstone_1_stone.'</td>';
		$gemstone_1_type 		= '<td>'.$rss->gemstone_1_type.'</td>';
		$gemstone_1_color 		= '<td>'.$rss->gemstone_1_color.'</td>';
		$gemstone_1_shape 		= '<td>'.$rss->gemstone_1_shape.'</td>';
		$gemstone_1_setting_type= '<td>'.$rss->gemstone_1_setting_type.'</td>';
		$gemstone_1_weight 		= '<td>'.$rss->gemstone_1_weight.'</td>';
		$gemstone_2_stone 		= '<td>'.$rss->gemstone_2_stone.'</td>';
		$gemstone_2_type 		= '<td>'.$rss->gemstone_2_type.'</td>';
		$gemstone_2_color 		= '<td>'.$rss->gemstone_2_color.'</td>';
		$gemstone_2_shape 		= '<td>'.$rss->gemstone_2_shape.'</td>';
		$gemstone_2_setting_type= '<td>'.$rss->gemstone_2_setting_type.'</td>';
		$gemstone_2_weight 		= '<td>'.$rss->gemstone_2_weight.'</td>';
		$gemstone_3_stone 		= '<td>'.$rss->gemstone_3_stone.'</td>';
		$gemstone_3_type 		= '<td>'.$rss->gemstone_3_type.'</td>';
		$gemstone_3_color 		= '<td>'.$rss->gemstone_3_color.'</td>';
		$gemstone_3_shape 		= '<td>'.$rss->gemstone_3_shape.'</td>';
		$gemstone_3_setting_type= '<td>'.$rss->gemstone_3_setting_type.'</td>';
		$gemstone_3_weight 		= '<td>'.$rss->gemstone_3_weight.'</td>';
		$gemstone_4_stone 		= '<td>'.$rss->gemstone_4_stone.'</td>';
		$gemstone_4_type 		= '<td>'.$rss->gemstone_4_type.'</td>';
		$gemstone_4_color 		= '<td>'.$rss->gemstone_4_color.'</td>';
		$gemstone_4_shape 		= '<td>'.$rss->gemstone_4_shape.'</td>';
		$gemstone_4_setting_type= '<td>'.$rss->gemstone_4_setting_type.'</td>';
		$gemstone_4_weight 		= '<td>'.$rss->gemstone_4_weight.'</td>';
		$gemstone_5_stone 		= '<td>'.$rss->gemstone_5_stone.'</td>';
		$gemstone_5_type 		= '<td>'.$rss->gemstone_5_type.'</td>';
		$gemstone_5_color 		= '<td>'.$rss->gemstone_5_color.'</td>';
		$gemstone_5_shape 		= '<td>'.$rss->gemstone_5_shape.'</td>';
		$gemstone_5_setting_type= '<td>'.$rss->gemstone_5_setting_type.'</td>';
		$gemstone_5_weight 		= '<td>'.$rss->gemstone_5_weight.'</td>';
		
		$product_url = str_replace('candere_report/',$rss->product_url,base_url()); 
			
		$complete_table .= '<tr class="'.$bgclass.' main_tr" id="'.$trCount.'"  >
			<td class="border left bottom" width="20" valign="top" style="padding-top:40px;">&nbsp;</td>	
			<td class="border bottom" width="275" style="color:#0066cc;" valign="top">
			<b>Order Id : '.$rss->order_id.'</b><br>
			<img src="'.str_replace('cdn','www',$rss->product_image).'" height="120" width="120" class="img_padding"></td>
					
			<td class="bottom" width="580" valign="top" style="padding-top:10px;">
				<table name="product_data" width="100%">
					<tbody>
						<tr><td><b>SKU : </b>'.$rss->sku.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b><br>
							
							</td></tr>	
						<tr><td><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$rss->product_name.'</a></b>&nbsp;&nbsp;&nbsp;<b style="color:#0066CC;float:right;margin-right:15%;">'.$rss->design_identifier.'</b></td>
						
						</tr>
						<tr>
							<td width="400">
							<table name="order_data" width="100%">
							<tbody>
								<tr><td width="200"><b>Order Date : </b>'.date("F j, Y", strtotime($rss->order_placed_date)).'</td></tr>';
								
								$complete_table .='<tr>';
								if($rss->metal!='') {
									$complete_table .='<td><b>Metal : </b>'.$rss->metal.'</td>';
								}
								if($rss->purity!='') {
									$complete_table .='<td><b>Purity : </b>'.$rss->purity.'</td>';
								}
								$complete_table .='</tr>';
								
								$complete_table .='<tr>';
								if($rss->height!='') {
									$complete_table .= '<td><b>Height : </b>'.$rss->height.' mm</td>';
								}
								if($rss->height!='') {
									$complete_table .= '<td><b>Width : </b>'.$rss->width.' mm</td>';
								}
								$complete_table .='</tr>';
								
								$complete_table .= '<tr>';
								if($rss->top_thickness) {
									$complete_table .='<td width="150"><b>Top Thickness : </b>'.$rss->top_thickness.' mm</td>';
									}
								if($rss->bottom_thickness) {	
									$complete_table .='<td width="150" class="nowrap"><b>Bottom Thickness : </b>'.$rss->bottom_thickness.' mm</td>';
								}
								$complete_table .= '</tr>';
								
								$complete_table .= '<tr>';
								if($rss->top_height!='') {
									$complete_table .= ' <td width="125"><b>Top Height : </b>'.$rss->top_height.' mm</td>';
								}	
								if($rss->total_weight!='') {	
									$complete_table .='<td width="140"><b>Total Weight : </b>'.$rss->total_weight.' gms</td>';
								}
								$complete_table .= '</tr></tbody>
							</table>
							</td>
						</tr>
					</tbody>	
				</table>
			</td>
			
			<td class="bottom" width="200" valign="top" style="padding-top:10px;">';
			
			$quan_class = ($rss->quantity > 1) ? 'red' : '';
			
			$price_class = ($row->total_due > 0) ? 'red' : '';
			
			$edit_image = base_url('themes/images/edit.png');			
			
			$complete_table .= '<table name="order_detail">
					<tbody>
						<tr><td><b>Qty : <span class="'.$quan_class.'">'.$rss->quantity.'</span></b>';
				
				if($_allow_cancel) {
						
						$complete_table .= '<span style="margin-right: -60%;float: right;"><img src="'.$edit_image.'" id="edit_price_'.$trCount.'" width="12" height="12"></span>';
				}
						$complete_table .= '</td></tr>
						<tr><td>Value : </td><td>'.$rss->unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$rss->shipping_amount.'</td></tr>
						<tr><td>Discount : </td><td>'.-($rss->discount_amount).'</td></tr>
						<tr><td><b>Total : </b></td><td><b class="'.$price_class.'">'.$total.'</b></td></tr>
						<tr><td><b>Total in USD: </b></td><td><b class="'.$price_class.'">'.$usd_total.'</b></td></tr>
					</tbody>	
				</table>';
								
			if($_allow_cancel) {			
				$complete_table .= '
				<form method="post" name="update_price_form" id="update_price_form_'.$trCount.'" action="'.base_url('index.php/erp_order/update_price').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$row->order_id.'">
					<input type="hidden" name="product_id" value="'.$row->product_id.'">
					<input type="text" name="updated_price" id="updated_price_'.$trCount.'" class="tb10" style="width:110px;">
					<input type="submit" name="submit_price" id="submit_price" value="Update Price" class="styled-button-1" style="width:110px;">
				</form>';	
			}
			
			$complete_table .='</td>
			<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
			$complete_table .= '<p>'.$rss->customer_name .' '. $rss->customer_lastname.'</p><br>
								<p>'.$rss->shipping_country.'</p><br>
								<p class="red">'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>
			</td>';
			
			$complete_table .= '<td class="bottom" width="250" valign="top" style="padding-top:10px;">';
			
			$complete_table .= '<span id="dispatch_date">'.date("F j, Y", strtotime($dispatch_date)).'</span>';
			
			if($_allow_cancel) {	
			
				$complete_table .= '<span style="margin-left:15px;"><img src="'.$edit_image.'" id="edit_dispatch_date_'.$trCount.'" width="12" height="12"></span>
				
				<form method="post" name="dispatch_form" id="dispatch_form_'.$trCount.'" action="'.base_url('index.php/erp_order/update_dispatch_date').'" style="display:none;">
					<input type="hidden" name="order_id" value="'.$rss->order_id.'">
					<input type="hidden" name="product_id" value="'.$rss->product_id.'">
					<input type="text" name="updated_dispatch_date" id="updated_dispatch_date_'.$trCount.'" class="tb10" style="width:110px;">
					<input type="hidden" name="controller" value="cancelled_orders">
					<input type="submit" name="submit_date" id="submit_date" value="Update Date" class="styled-button-1" style="width:110px;">
				</form>';
			}
			
			$complete_table .= '</td>
			
			<td class="bottom right" width="300" valign="top">';
			if($_allow_cancel) {
				$complete_table .='<span style="margin-right: 25%;float: right;margin-top: 10px;"><img id="cancel_order_'.$trCount.'" src="'.base_url('themes/images/cancel.jpg').'" alt="Cancel Order" border="0" height="12" width="12"></span>';			
				$complete_table .= '<form method="POST" action="#" name="cancel_order_form" id="cancel_order_form_'.$trCount.'" style="display:none;margin-top: 10px;">
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
				<button type="button" name="btn_submit" class="styled-button-1" style="width:120px;" onclick="myFunction('.$trCount.');" >Cancel Order</button>
				</form>';
			}
		
			$complete_table .='<form method="POST" action="#" name="order_update" id="order_update_'.$trCount.'" style="margin-top: 10px;">';
			
			$complete_table .='<input type="hidden" name="controller" value="cancelled_orders" />';
			$complete_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
			$complete_table .='<input type="hidden" name="order_product_id" value="'.$erp_id.'" />';
			$complete_table .='<input type="hidden" name="order_status_id" value="'.$order_status_id.'" />';
			$complete_table .='<input type="hidden" name="order_item_id" value="'.$order_item_id.'" />';
			$complete_table .='<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />';
			$complete_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'">';
			$complete_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';
			$complete_table .= '<p><b>Notes</b></p>';
			$complete_table .= '<textarea name="notes" class="tb10"></textarea><br><br>';
			//$complete_table .= '<input type="submit" name="btn_submit" value="Update" class="styled-button-1">';
			$complete_table .= '<button type="button" name="btn_submit" class="styled-button-1" onclick="save_order('.$trCount.');">Update</button>';
			
			$complete_table .='</form>';
			
			$complete_table .='<div class="popbox">
							<a class="open" href="#" style="text-decoration:none;"><b style="font-size:20px;margin-top:0px;">+</b></a>
							<div class="collapse">
							  <div class="box">
								<div class="arrow"></div>
								<div class="arrow-border"></div>
								<div id="abcd">'.$all_notes.'</div>
							  </div>
							</div>
						  </div>';
						  
			$complete_table .= '</td></tr>';
		
		if($rss->diamond_1_status==1 || $rss->diamond_2_status==1 || $rss->diamond_3_status==1 || $rss->diamond_4_status==1 || $rss->diamond_5_status==1 || $rss->diamond_6_status==1 || $rss->diamond_7_status==1) {
		
		$complete_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left">&nbsp;</td>';
				
		if($rss->diamond_1_status==1 || $rss->diamond_2_status==1 || $rss->diamond_3_status==1 || $rss->diamond_4_status==1 || $rss->diamond_5_status==1 || $rss->diamond_6_status==1 || $rss->diamond_7_status==1) {
		$complete_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table style="display: table;width:auto;white-space: nowrap;" class="diamond_detail" id="diamond_detail">
			<tr><td colspan="8"><b><u>Diamond Details</u></b></td></tr>
			<tr>
				<td><b>Clarity</b></td>';
				if($rss->diamond_1_status==1){$complete_table .= $diamond_1_clarity;}
				if($rss->diamond_2_status==1){$complete_table .= $diamond_2_clarity;}
				if($rss->diamond_3_status==1){$complete_table .= $diamond_4_clarity;}
				if($rss->diamond_4_status==1){$complete_table .= $diamond_4_clarity;}
				if($rss->diamond_5_status==1){$complete_table .= $diamond_5_clarity;}
				if($rss->diamond_6_status==1){$complete_table .= $diamond_6_clarity;}
				if($rss->diamond_7_status==1){$complete_table .= $diamond_7_clarity;}
				
			$complete_table .='</tr>
			<tr><td><b>Color</b></td>';
				if($rss->diamond_1_status==1){$complete_table .= $diamond_1_color;}
				if($rss->diamond_2_status==1){$complete_table .= $diamond_2_color;}
				if($rss->diamond_3_status==1){$complete_table .= $diamond_3_color;}
				if($rss->diamond_4_status==1){$complete_table .= $diamond_4_color;}
				if($rss->diamond_5_status==1){$complete_table .= $diamond_5_color;}
				if($rss->diamond_6_status==1){$complete_table .= $diamond_6_color;}
				if($rss->diamond_7_status==1){$complete_table .= $diamond_7_color;}
												
			$complete_table .= '</tr>
			<tr><td><b>No. of Diamonds</b></td>';
				if($rss->diamond_1_status==1){$complete_table .= $diamond_1_stones;}
				if($rss->diamond_2_status==1){$complete_table .= $diamond_2_stones;}
				if($rss->diamond_3_status==1){$complete_table .= $diamond_3_stones;}
				if($rss->diamond_4_status==1){$complete_table .= $diamond_4_stones;}
				if($rss->diamond_5_status==1){$complete_table .= $diamond_5_stones;}
				if($rss->diamond_6_status==1){$complete_table .= $diamond_6_stones;}
				if($rss->diamond_7_status==1){$complete_table .= $diamond_7_stones;}
				
			$complete_table .= '</tr>
			<tr><td><b>Shape</b></td>';
				if($rss->diamond_1_status==1){$complete_table .= $diamond_1_shape;}
				if($rss->diamond_2_status==1){$complete_table .= $diamond_2_shape;}
				if($rss->diamond_3_status==1){$complete_table .= $diamond_3_shape;}
				if($rss->diamond_4_status==1){$complete_table .= $diamond_4_shape;}
				if($rss->diamond_5_status==1){$complete_table .= $diamond_5_shape;}
				if($rss->diamond_6_status==1){$complete_table .= $diamond_6_shape;}
				if($rss->diamond_7_status==1){$complete_table .= $diamond_7_shape;}
			
			$complete_table .='</tr>
			<tr><td><b>Diamond Weight</b></td>';
				if($rss->diamond_1_status==1){$complete_table .= $diamond_1_weight;}
				if($rss->diamond_2_status==1){$complete_table .= $diamond_2_weight;}
				if($rss->diamond_3_status==1){$complete_table .= $diamond_3_weight;}
				if($rss->diamond_4_status==1){$complete_table .= $diamond_4_weight;}
				if($rss->diamond_5_status==1){$complete_table .= $diamond_5_weight;}
				if($rss->diamond_6_status==1){$complete_table .= $diamond_6_weight;}
				if($rss->diamond_7_status==1){$complete_table .= $diamond_7_weight;}
			
			$complete_table .='</tr>
			<tr><td><b>Setting Type</b></td>';
			if($rss->diamond_1_status==1){$complete_table .= $diamond_1_setting_type;}
			if($rss->diamond_2_status==1){$complete_table .= $diamond_2_setting_type;}
			if($rss->diamond_3_status==1){$complete_table .= $diamond_3_setting_type;}
			if($rss->diamond_4_status==1){$complete_table .= $diamond_4_setting_type;}
			if($rss->diamond_5_status==1){$complete_table .= $diamond_5_setting_type;}
			if($rss->diamond_6_status==1){$complete_table .= $diamond_6_setting_type;}
			if($rss->diamond_7_status==1){$complete_table .= $diamond_7_setting_type;}
				
			$complete_table .= '</tr>
			</table>
		</td>
		<td class="bottom">&nbsp;</td>';
		}
		else {
			$complete_table .= '<td colspan="3" align="center" class="bottom btm_padding">&nbsp;</td>';
		}
			
		if($rss->gem_1_status==1 || $rss->gem_2_status==1 || $rss->gem_3_status==1 || $rss->gem_4_status==1 || $rss->gem_5_status==1) {
		$complete_table .= '<td colspan="3" align="center" class="top_btm_padding bottom right">
			<table style="display: table;width:auto;white-space: nowrap;" name="gemstone_detail" id="gemstone_detail">
			<tr><td colspan="6" align="center"><b><u>Gemstone Details</u></b></td></tr>
			<tr><td><b><u>No. of Gemstones</u></b></td>';
			
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_stone;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_stone;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_stone;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_stone;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_stone;}
				
			$complete_table .='</tr>
			<tr><td><b>Gemstone Type</b></td>';
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_type;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_type;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_type;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_type;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_type;}
				
			$complete_table .= '</tr>
			<tr><td><b>Gemstone Color</b></td>';
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_color;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_color;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_color;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_color;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_color;}
			
			$complete_table .= '</tr>
			<tr><td><b>Shape</b></td>';
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_shape;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_shape;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_shape;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_shape;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_shape;}
			
			$complete_table .= '</tr>
			<tr><td><b>Gemstone Weight</b></td>';
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_weight;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_weight;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_weight;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_weight;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_weight;}
				
			$complete_table .= '</tr>
			<tr><td><b>Setting Type</b></td>';
			if($rss->gem_1_status==1){$complete_table .= $gemstone_1_setting_type;}
			if($rss->gem_2_status==1){$complete_table .= $gemstone_2_setting_type;}
			if($rss->gem_3_status==1){$complete_table .= $gemstone_3_setting_type;}
			if($rss->gem_4_status==1){$complete_table .= $gemstone_4_setting_type;}
			if($rss->gem_5_status==1){$complete_table .= $gemstone_5_setting_type;}
				
			$complete_table .= '</tr>
			</table>
		</td>';
		} else {
			$complete_table .= '<td colspan="3" align="center" class="bottom right btm_padding">&nbsp;</td>';
		}
			$complete_table .= '</tr>';
		}
		$trCount++;
	}
} ?>
<?php $complete_table .= '</table>';
echo $complete_table; ?>

<!-- Pagination for cancelled_orders list -->
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
</script>

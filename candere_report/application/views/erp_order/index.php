<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
	
	$('.tab_menu').click(function(e){
		var element = $(this);
        var data_counter = element.attr("data-counter");
		$.cookie("data_counter", data_counter, { expires: 7 });
		
		/*$.ajax({
			type: "POST",
			url: "<?php echo base_url('index.php/erp_order/index')?>",
			data: {'data_counter': data_counter },
			success: function(result)
			{
				//alert(result);
			}
		}); */
	});
});

//Line no 15281 
$(function() {
	$("#tabs" ).tabs({
		active : $.cookie("data_counter"),
	});
});
</script>

<div style="margin-left:35%;">
<?php	
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/search_orders').'">';
		$allow_status 	= @$this->session->userdata('order_status'); 
		$show_orders 	= $this->erpmodel->getAllStatus();
		
		$user_status = '';
			foreach($show_orders as $ab){
				$user_status[$ab->status_id] = $ab->status_name;
			}
			
		echo $status_dropdown = form_multiselect('status_id[]', $user_status, set_value('status_id'), 'id="status_id" class="SlectBox" placeholder="Select Status"');	
		
		//echo '<input type="button" id="select_all" name="select_all" value="Select All " class="styled-button-1"> '; 
		
		echo '<input type="submit" name="sts_submit" value="View" class="styled-button-1" >';
		echo '</form>'; ?>
</div>		

        
        
<div id="tabs">
<ul>
	<li><a href="#tabs-1" class="tab_menu" data-counter='0'>To Do list</a></li>
	<li><a href="#tabs-2" class="tab_menu" data-counter='1'>Processing Orders</a></li>
	<li><a href="#tabs-3" class="tab_menu" data-counter='2'>Archieved Orders</a></li>
	<li><a href="#tabs-4" class="tab_menu" data-counter='3'>Product Updates</a></li>
</ul>
<div id="tabs-1" data-counter="0" style="padding-bottom:3%;">
<p>
<?php 
	$order_table = '';
	$order_table = '<table width="100%" cellspacing=0 cellpadding=0 class="order_table" name="order_table" id="order_table">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color"><input type="checkbox" id="selectAll" /></th>
			<th colspan="2" align="left" class=" th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color" >Dispatch By</th>
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
	
	$order_status 	= $this->erpmodel->getAllStatus();
	$all_vendors 	= $this->erpmodel->getAllVendors();
	$getAllGreetings= $this->erpmodel->getAllGreetings();
		
	$status_option[''] = 'Select Status';
		foreach($order_status as $nb){
			$status_option[$nb->status_id] = $nb->status_name;
		}
		
	$vendor_option[''] = 'Select Vendor';
		foreach($all_vendors as $rw){ 
			$vendor_option[$rw->vendor_id] = $rw->vendor_name;
		}	
	
	$greeting_option[''] = 'Select Greeting';
		foreach($getAllGreetings as $rg){ 
			$greeting_option[$rg->greeting_card_id] = $rg->greeting_card_name;
		}
				
	foreach($selectdata as $row){
		$erp_id 		= $row->id;
		$order_id 		= $row->order_id;
		$product_id 	= $row->product_id;
		$erp_order_id 	= $row->erp_order_id;
		$personal_message 	= $row->personal_message;
		$greeting_card_id 	= $row->greeting_card_id;
		$order_product_id 	= $row->order_product_id;
		
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);
					
		$getOrderData	= $this->erpmodel->getOrderData($order_id);
		$getOrderNotes	= $this->erpmodel->getOrderNotes($order_id, $order_product_id);
		
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, g:i a', strtotime($nt->updated_date));
				
				$all_notes .='<div class="notes_area"><br>
								<span style="float:left;"><b>'.$this->erpmodel->getStatusName($nt->order_status_id).'</b></span>
								<span style="float:right;"><b>'.$updated_date.'</b></span><br>
								<span style="float:left;"><b>'.$nt->updated_by.'</b></span><br>
								<span style="float:left;"><b>'.$nt->notes.'</b></span><br>
								</div><br>';
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
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="vendor_id_'.$trCounter.'", class="dropWidth" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trCounter.'", class="dropWidth", '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
				
		$total = number_format(($row->unit_price*$row->quantity) + $row->shipping_amount + $row->discount_amount,2);
		
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
		$diamond_4_clarity 		= '<td>'.$row->diamond_4_clarity.'</td>';
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
			<td class="border left bottom"><input type="checkbox" name="chk_order"></td>	
			<td class="border bottom" width="150" style="color:#0066cc;">
			<b>Order Id : </b>'.$row->order_id.'<br>
			<img src="'.$row->product_image.'" height="120" width="120" class="img_padding"></td>
					
			<td class="bottom" width="400">
				<table name="product_data" width="100%">
					<tbody>
						<tr><td><b>SKU : </b>'.$row->sku.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b>
							</td></tr>	
						<tr><td><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$row->product_name.'</a></b></td></tr>
						<tr>
							<td width="400">
							<table name="order_data" width="100%">
							<tbody>
								<tr><td width="200"><b>Order Date : </b>'.date("F j, Y", strtotime($row->order_placed_date)).'</td></tr>';
								
								$order_table .='<tr>';
								if($row->metal!='') {
									$order_table .='<td><b>Metal : </b>'.$row->metal.'</td>';
								}
								if($row->purity!='') {
									$order_table .='<td><b>Purity : </b>'.$row->purity.'</td>';
								}
								$order_table .='</tr>';
								
								$order_table .='<tr>';
								if($row->height!='') {
									$order_table .= '<td><b>Height : </b>'.$row->height.'</td>';
								}
								if($row->height!='') {
									$order_table .= '<td><b>Width : </b>'.$row->width.'</td>';
								}
								$order_table .='</tr>';
								
								$order_table .= '<tr>';
								if($row->top_thickness) {
									$order_table .='<td width="150"><b>Top Thickness : </b>'.$row->top_thickness.'</td>';
									}
								if($row->bottom_thickness) {	
									$order_table .='<td width="150"><b>Bottom Thickness : </b>'.$row->bottom_thickness.'</td>';
								}
								$order_table .= '</tr>';
								
								$order_table .= '<tr>';
								if($row->top_height!='') {
									$order_table .= ' <td width="125"><b>Top Height : </b>'.$row->top_height.'</td>';
								}	
								if($row->total_weight!='') {	
									$order_table .='<td width="140"><b>Total Weight : </b>'.$row->total_weight.'</td>';
								}
								$order_table .= '</tr></tbody>
							</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			
			<td class="bottom" width="150" valign="top">';
			
			$quan_class = ($row->quantity > 1) ? 'red' : '';
			
			$order_table .= '<br><br><table name="order_detail">
					<tbody>
						<tr><td valign="top">
						<b>Qty : <span class="'.$quan_class.'">'.$row->quantity.'</span></b></td></tr>
						<tr><td>Value : </td><td>'.$row->unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$row->shipping_amount.'</td></tr>
						<tr><td><b>Total : </b></td><td><b>'.$total.'</b></td></tr>
					</tbody>	
				</table>
			</td>
			<td class="bottom" width="180" valign="">';
			$order_table .= '<p>'.$row->customer_name .' '. $row->customer_lastname.'</p><br>
								<p>'.$row->shipping_country.'</p><br>
								<p class="red">'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>
			</td>';
			
			$order_table .= '<td class="bottom" width="180" valign="top">';
			
			$order_table .= '<br><br> '.date("F j, Y", strtotime($row->expected_delivery_date)).'</td>
			
			<td class="bottom right" style="padding-bottom: 20px;">';
									
		$order_table .='<br><br><form method="POST" action="'.base_url('index.php/erp_order/order_save').'" name="order_update" id="order_update">';
			
		$order_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
		$order_table .='<input type="hidden" name="order_product_id" value="'.$erp_id.'" />';
		$order_table .='<input type="hidden" name="order_status_id" value="3" />';
		$order_table .='<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />';
		$order_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />';
		$order_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';
		$order_table .='<input type="hidden" name="website_id" value="'.$website_id.'" />';
		$order_table .= '<p><b>Notes</b></p>';
		$order_table .= '<textarea name="notes" class="dropWidth"></textarea><br>';
		$order_table .= '<input type="submit" name="btn_submit" value="Next" class="styled-button-1">';$order_table .='</form>';
			
		$order_table .='<div class="popbox">
						<a class="open" href="#">+</a>
							<div class="collapse">
								<div class="box">
									<div class="arrow"></div>
									<div class="arrow-border"></div>
									<div id="abcd">'.$all_notes.'</div>
								</div>
							</div>
					  </div>'; 
		$order_table .= '</td></tr>';
		
		if($row->diamond_1_status==1 || $row->diamond_2_status==1 || $row->diamond_3_status==1 || $row->diamond_4_status==1 || $row->diamond_5_status==1 || $row->diamond_6_status==1 || $row->diamond_7_status==1) {
		
		$order_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left"></td>';
				
		if($row->diamond_1_status==1 || $row->diamond_2_status==1 || $row->diamond_3_status==1 || $row->diamond_4_status==1 || $row->diamond_5_status==1 || $row->diamond_6_status==1 || $row->diamond_7_status==1) {
		$order_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table width="100%" style="border: 1px solid black;" class="diamond_detail">
			<tr><td colspan="8" align="center"><b><u>Diamond Details</u></b></td></tr>
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
			<tr><td><b>No. of Diamonds</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_stones;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_stones;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_stones;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_stones;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_stones;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_stones;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_stones;}
				
			$order_table .= '</tr>
			<tr><td><b>Shape</b></td>';
				if($row->diamond_1_status==1){$order_table .= $diamond_1_shape;}
				if($row->diamond_2_status==1){$order_table .= $diamond_2_shape;}
				if($row->diamond_3_status==1){$order_table .= $diamond_3_shape;}
				if($row->diamond_4_status==1){$order_table .= $diamond_4_shape;}
				if($row->diamond_5_status==1){$order_table .= $diamond_5_shape;}
				if($row->diamond_6_status==1){$order_table .= $diamond_6_shape;}
				if($row->diamond_7_status==1){$order_table .= $diamond_7_shape;}
			
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
		<td class="bottom"></td>';
		}
		else {
			$order_table .= '<td colspan="3" align="center" class="bottom btm_padding"></td>';
		}
			
		if($row->gem_1_status==1 || $row->gem_2_status==1 || $row->gem_3_status==1 || $row->gem_4_status==1 || $row->gem_5_status==1) {
		$order_table .= '<td colspan="3" align="center" class="top_btm_padding bottom right">
			<table width="90%" style="border: 1px solid black;" name="gemstone_detail">
			<tr><td colspan="6" align="center"><b><u>Gemstone Details</u></b></td></tr>
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
			$order_table .= '<td colspan="3" align="center" class="bottom right btm_padding"></td>';
		}
			$order_table .= '</tr>';
		}
		$trCounter++;
	}
}
?>
<?php $order_table .= '</table>';
echo $order_table; ?>

<!-- Pagination for To do list -->
<?php if($selectdata) {
	echo $this->pagination->create_links();
} ?>
</p>
</div>


<div id="tabs-2" data-counter="1" style="padding-bottom:3%;">	  
<p>
<?php 
	$process_table = '';
	$process_table = '<table width="100%" cellspacing=0 cellpadding=0 class="process_table" name="process_table" id="process_table">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color"><input type="checkbox" id="selectAll" /></th>
			<th colspan="2" align="left" class=" th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color" >Dispatch By</th>
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
	
	if($_admin == 'Y'){
		$process_status 	= $this->erpmodel->getAllStatus($order_status);
	} else {
		$process_status 	= $this->erpmodel->getProcessingStatus($order_status);
	}
	
	$all_vendors 		= $this->erpmodel->getAllVendors();
	$getAllGreetings	= $this->erpmodel->getAllGreetings();
		
	$process_status_option[''] = 'Select Status';
		foreach($process_status as $nb){
			$process_status_option[$nb->status_id] = $nb->status_name;
		}
		
	$vendor_option[''] = 'Select Vendor';
		foreach($all_vendors as $rw){ 
			$vendor_option[$rw->vendor_id] = $rw->vendor_name;
		}	
	
	$greeting_option[''] = 'Select Greeting';
		foreach($getAllGreetings as $rg){ 
			$greeting_option[$rg->greeting_card_id] = $rg->greeting_card_name;
		}
				
	foreach($processdata as $rj){
		$erp_id 	= $rj->id;
		$order_id 	= $rj->order_id;
		$product_id = $rj->product_id;
		$erp_order_id = $rj->erp_order_id;
		$order_product_id = $rj->order_product_id;
		
		$personal_message 	= $rj->personal_message;
		$greeting_card_id 	= $rj->greeting_card_id;
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);			
		$getOrderData		= $this->erpmodel->getOrderData($order_id);
		$getOrderNotes		= $this->erpmodel->getOrderNotes($order_id, $order_product_id);
		
		$last_notes 	= end($getOrderNotes);
		$initial_note 	= $last_notes->notes;
				
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, g:i a', strtotime($nt->updated_date));
				$all_notes .='<div class="notes_area"><br>
								<span style="float:left;"><b>'.$this->erpmodel->getStatusName($nt->order_status_id).'</b></span>
								<span style="float:right;"><b>'.$updated_date.'</b></span><br>
								<span style="float:left;"><b>'.$nt->updated_by.'</b></span><br>
								<span style="float:left;"><b>'.$nt->notes.'</b></span><br>
								</div><br>';
			}
		}
		
		if(in_array($rj->status, explode(',',$allow_status))) {
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
				
		$status_dropdown = form_dropdown('order_status_id', $process_status_option, $order_status_id, 'id="OrderStatusID_'.$trProcess.'" class="dropWidth" ');
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="vendor_id_'.$trProcess.'", class="dropWidth" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trProcess.'", class="dropWidth", '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
				
		$total = number_format(($rj->unit_price*$rj->quantity) + $rj->shipping_amount + $rj->discount_amount,2);
		
		$diamond_1_stones 		= '<td>'.$rj->diamond_1_stones.'</td>';
		$diamond_1_weight 		= '<td>'.$rj->diamond_1_weight.'</td>';
		$diamond_1_clarity 		= '<td>'.$rj->diamond_1_clarity.'</td>';
		$diamond_1_shape 		= '<td>'.$rj->diamond_1_shape.'</td>';
		$diamond_1_color 		= '<td>'.$rj->diamond_1_color.'</td>';
		$diamond_1_setting_type = '<td>'.$rj->diamond_1_setting_type.'</td>';
		$diamond_2_stones 		= '<td>'.$rj->diamond_2_stones.'</td>';
		$diamond_2_weight 		= '<td>'.$rj->diamond_2_weight.'</td>';
		$diamond_2_clarity 		= '<td>'.$rj->diamond_2_clarity.'</td>';
		$diamond_2_shape 		= '<td>'.$rj->diamond_2_shape.'</td>';
		$diamond_2_color 		= '<td>'.$rj->diamond_2_color.'</td>';
		$diamond_2_setting_type = '<td>'.$rj->diamond_2_setting_type.'</td>';
		$diamond_3_stones 		= '<td>'.$rj->diamond_3_stones.'</td>';
		$diamond_3_weight 		= '<td>'.$rj->diamond_3_weight.'</td>';
		$diamond_3_clarity 		= '<td>'.$rj->diamond_3_clarity.'</td>';
		$diamond_3_shape 		= '<td>'.$rj->diamond_3_shape.'</td>';
		$diamond_3_color 		= '<td>'.$rj->diamond_3_color.'</td>';
		$diamond_3_setting_type = '<td>'.$rj->diamond_3_setting_type.'</td>';
		$diamond_4_stones 		= '<td>'.$rj->diamond_4_stones.'</td>';
		$diamond_4_weight 		= '<td>'.$rj->diamond_4_weight.'</td>';
		$diamond_4_clarity 		= '<td>'.$rj->diamond_4_clarity.'</td>';
		$diamond_4_shape 		= '<td>'.$rj->diamond_4_shape.'</td>';
		$diamond_4_color 		= '<td>'.$rj->diamond_4_color.'</td>';
		$diamond_4_setting_type = '<td>'.$rj->diamond_4_setting_type.'</td>';
		$diamond_5_stones 		= '<td>'.$rj->diamond_5_stones.'</td>';
		$diamond_5_weight 		= '<td>'.$rj->diamond_5_weight.'</td>';
		$diamond_5_clarity 		= '<td>'.$rj->diamond_5_clarity.'</td>';
		$diamond_5_shape 		= '<td>'.$rj->diamond_5_shape.'</td>';
		$diamond_5_color 		= '<td>'.$rj->diamond_5_color.'</td>';
		$diamond_5_setting_type = '<td>'.$rj->diamond_5_setting_type.'</td>';
		$diamond_6_stones 		= '<td>'.$rj->diamond_6_stones.'</td>';
		$diamond_6_weight 		= '<td>'.$rj->diamond_6_weight.'</td>';
		$diamond_6_clarity 		= '<td>'.$rj->diamond_6_clarity.'</td>';
		$diamond_6_shape 		= '<td>'.$rj->diamond_6_shape.'</td>';
		$diamond_6_color 		= '<td>'.$rj->diamond_6_color.'</td>';
		$diamond_6_setting_type = '<td>'.$rj->diamond_6_setting_type.'</td>';
		$diamond_7_stones 		= '<td>'.$rj->diamond_7_stones.'</td>';
		$diamond_7_weight 		= '<td>'.$rj->diamond_7_weight.'</td>';
		$diamond_7_clarity 		= '<td>'.$rj->diamond_7_clarity.'</td>';
		$diamond_7_shape 		= '<td>'.$rj->diamond_7_shape.'</td>';
		$diamond_7_color 		= '<td>'.$rj->diamond_7_color.'</td>';
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
			<td class="border left bottom"><input type="checkbox" name="chk_order"></td>	
			<td class="border bottom" width="150" style="color:#0066cc;" valign="top">
			<b>Order Id : </b>'.$rj->order_id.'<br>
			<img src="'.$rj->product_image.'" height="120" width="120" class="img_padding"></td>
					
			<td class="bottom" width="400">
				<table name="product_data" width="100%">
					<tbody>
						<tr><td><b>SKU : </b>'.$rj->sku.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b>						
							</td></tr>
						<tr><td><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$rj->product_name.'</a></b></td></tr>
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
									$process_table .= '<td><b>Height : </b>'.$rj->height.'</td>';
								}
								if($rj->height!='') {
									$process_table .= '<td><b>Width : </b>'.$rj->width.'</td>';
								}
								$process_table .='</tr>';
								
								$process_table .= '<tr>';
								if($rj->top_thickness) {
									$process_table .='<td width="150"><b>Top Thickness : </b>'.$rj->top_thickness.'</td>';
									}
								if($rj->bottom_thickness) {	
									$process_table .='<td width="150"><b>Bottom Thickness : </b>'.$rj->bottom_thickness.'</td>';
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
			
			<td class="bottom" width="150" valign="top">';
			
			$quan_class = ($rj->quantity > 1) ? 'red' : '';
			
			$process_table .= '	<br><br><table name="order_detail">
					<tbody>
						<tr><td><b>Qty : <span class="'.$quan_class.'">'.$rj->quantity.'</span></b></td></tr>
						<tr><td>Value : </td><td>'.$rj->unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$rj->shipping_amount.'</td></tr>
						<tr><td><b>Total : </b></td><td><b>'.$total.'</b></td></tr>
					</tbody>	
				</table>
			</td>
			<td class="bottom" width="180" valign="">';
			
			$process_table .= '<p>'.$rj->customer_name .' '. $rj->customer_lastname.'</p><br>
								<p>'.$rj->shipping_country.'</p><br>
								<p>'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>
			</td>';
						
			$process_table .= '<td class="bottom" width="180" valign="top">';
						
			$process_table .= '<br><br><br> '.date("F j, Y", strtotime($rj->expected_delivery_date)).'</td>
			<td class="bottom" style="padding-bottom: 20px;">';
										
			$process_table .='<form method="POST" action="'.base_url('index.php/erp_order/order_save').'" name="order_update" id="order_update">';
			
			$process_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
			$process_table .='<input type="hidden" name="order_product_id" value="'.$erp_id.'" />';
			$process_table .='<input type="hidden" name="order_status_id" value="3" />';
			$process_table .='<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />';
			$process_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'" />';
			$process_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';

			$process_table .= '<div id="status_'.$trProcess.'"><p><b>Status</b></p>';
			$process_table .= $status_dropdown.'<br></div>';
						
			$process_table .= '<div id="vendor_dis_'.$trProcess.'"><p><b>Vendor</b></p>';
			$process_table .= $vendor_dropdown.'<br></div>';
			
			//$process_table .= '<div id="greeting_dis_'.$trProcess.'"><label><b>Greeting Card</b></label>$greeting_dropdown.'<br>';
			
			$process_table .= '</div>';
						
			$process_table .= '<p><b>Notes</b></p>';
			$process_table .= '<textarea name="notes" class="dropWidth"></textarea><br>';
						
			$process_table .= '<input type="submit" name="btn_submit" value="Update" class="styled-button-1">';
						
			$process_table .='</form>';
			
			$process_table .='<div class="popbox">
							<a class="open" href="#">+</a>
							<div class="collapse">
							  <div class="box">
								<div class="arrow"></div>
								<div class="arrow-border"></div>
								<div id="abcd">'.$all_notes.'</div>
							  </div>
							</div>
						  </div>';
						  
			$process_table .= '</td>';
			/*$process_table .= '<td class="right bottom">
					<span><a href="'.base_url().'index.php/erp_order/addfinishedproductdetails?erp_order_id='.$order_id.'&order_product_id='.$erp_order_id.'" style="color:#0066CC;text-decoration:none;">Add Finished Product Details</a></span>
			</td>*/
			
		$process_table .= '</tr>';
		
		if($rj->diamond_1_status==1 || $rj->diamond_2_status==1 || $rj->diamond_3_status==1 || $rj->diamond_4_status==1 || $rj->diamond_5_status==1 || $rj->diamond_6_status==1 || $rj->diamond_7_status==1) {
		
		$process_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left"></td>';
				
		if($rj->diamond_1_status==1 || $rj->diamond_2_status==1 || $rj->diamond_3_status==1 || $rj->diamond_4_status==1 || $rj->diamond_5_status==1 || $rj->diamond_6_status==1 || $rj->diamond_7_status==1) {
		$process_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table width="100%" style="border: 1px solid black;" class="diamond_detail">
			<tr><td colspan="8" align="center"><b><u>Diamond Details</u></b></td></tr>
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
			<tr><td><b>No. of Diamonds</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_stones;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_stones;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_stones;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_stones;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_stones;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_stones;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_stones;}
				
			$process_table .= '</tr>
			<tr><td><b>Shape</b></td>';
				if($rj->diamond_1_status==1){$process_table .= $diamond_1_shape;}
				if($rj->diamond_2_status==1){$process_table .= $diamond_2_shape;}
				if($rj->diamond_3_status==1){$process_table .= $diamond_3_shape;}
				if($rj->diamond_4_status==1){$process_table .= $diamond_4_shape;}
				if($rj->diamond_5_status==1){$process_table .= $diamond_5_shape;}
				if($rj->diamond_6_status==1){$process_table .= $diamond_6_shape;}
				if($rj->diamond_7_status==1){$process_table .= $diamond_7_shape;}
			
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
			<table width="90%" style="border: 1px solid black;" name="gemstone_detail">
			<tr><td colspan="6" align="center"><b><u>Gemstone Details</u></b></td></tr>
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
if($processdata) {
	echo $this->pagination->create_links();
} ?>
</p>		
</div>

<div id="tabs-3" data-counter="2"style="padding-bottom:3%;">
<p>		
	 <?php 
	$complete_table = '';
	$complete_table = '<table width="100%" cellspacing=0 cellpadding=0 class="complete_table" name="complete_table" id="complete_table">
		<tr height="40" style="padding-bottom:100px;">
			<th class="th_color"><input type="checkbox" id="selectAll" /></th>
			<th colspan="2" align="left" class=" th_color">Order Summary</th>
			<th align="left" class="th_color">Quantity and Price</th>
			<th align="left" class="th_color">Buyer Details</th>
			<th align="left" class="th_color" >Dispatch By</th>
			<th align="left" class="th_color">Order Action</th>
			
		</tr>'; ?>		
<?php
if($completedata)
{
	$array 		= array();
	$counter 	= 1;
	$trCount 	= 1;
	$_username 	= @$this->session->userdata('_username');
	
	$order_status 	= $this->erpmodel->getAllStatus();
	$all_vendors 	= $this->erpmodel->getAllVendors();
	$getAllGreetings= $this->erpmodel->getAllGreetings();
		
	$status_option[''] = 'Select Status';
		foreach($order_status as $nb){
			$status_option[$nb->status_id] = $nb->status_name;
		}
		
	$vendor_option[''] = 'Select Vendor';
		foreach($all_vendors as $rw){ 
			$vendor_option[$rw->vendor_id] = $rw->vendor_name;
		}	
	
	$greeting_option[''] = 'Select Greeting';
		foreach($getAllGreetings as $rg){ 
			$greeting_option[$rg->greeting_card_id] = $rg->greeting_card_name;
		}
				
	foreach($completedata as $rss){
		$erp_id 	= $rss->id;
		$order_id 	= $rss->order_id;
		$product_id = $rss->product_id;
		$order_product_id = $rss->order_product_id;
		
		$personal_message 	= $rss->personal_message;
		$greeting_card_id 	= $rss->greeting_card_id;
		$greeting_card_name = $this->erpmodel->getGreeting($greeting_card_id);		
		$getOrderData		= $this->erpmodel->getOrderData($order_id);
		$getOrderNotes		= $this->erpmodel->getOrderNotes($order_id,$order_product_id);
			
		$all_notes = '';
		if($getOrderNotes) {
			foreach($getOrderNotes as $nt){
				$updated_date = date('F j, Y, g:i a', strtotime($nt->updated_date));
				
				$all_notes .='<div class="notes_area"><br>
								<span style="float:left;"><b>'.$this->erpmodel->getStatusName($nt->order_status_id).'</b></span>
								<span style="float:right;"><b>'.$updated_date.'</b></span><br>
								<span style="float:left;"><b>'.$nt->updated_by.'</b></span><br>
								<span style="float:left;"><b>'.$nt->notes.'</b></span><br>
								</div><br>';
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
		
		$key['status_id'] 	= $order_status_id;
		$getStatus			= $this->erpmodel->GetInfoRow('mststatus',$key);
		$status_name		= $getStatus[0]->status_name;
				
		$status_dropdown = form_dropdown('order_status_id', $status_option, $order_status_id, 'id="OrderStatusID_'.$trCount.'" class="dropWidth" ');
		
		$vendor_dropdown = form_dropdown('vendor_id', $vendor_option, $vendor_id,'id="vendor_id_'.$trCount.'", class="dropWidth" ');
		
		$greeting_dropdown = form_dropdown('greeting_card_id', $greeting_option, $greeting_card_id, 'id="GreetingCardId_'.$trCount.'" class="dropWidth"  '.$disable.'');
					
		if(!in_array($order_id,$data)) {
			$counter++;
		}
		
		$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';
						
		$data = array_merge($array, array('order_id'=>$order_id));
		$data = array_filter($data);
				
		$total = number_format(($rss->unit_price*$rss->quantity) + $rss->shipping_amount + $rss->discount_amount,2);
		
		$diamond_1_stones 		= '<td>'.$rss->diamond_1_stones.'</td>';
		$diamond_1_weight 		= '<td>'.$rss->diamond_1_weight.'</td>';
		$diamond_1_clarity 		= '<td>'.$rss->diamond_1_clarity.'</td>';
		$diamond_1_shape 		= '<td>'.$rss->diamond_1_shape.'</td>';
		$diamond_1_color 		= '<td>'.$rss->diamond_1_color.'</td>';
		$diamond_1_setting_type = '<td>'.$rss->diamond_1_setting_type.'</td>';
		$diamond_2_stones 		= '<td>'.$rss->diamond_2_stones.'</td>';
		$diamond_2_weight 		= '<td>'.$rss->diamond_2_weight.'</td>';
		$diamond_2_clarity 		= '<td>'.$rss->diamond_2_clarity.'</td>';
		$diamond_2_shape 		= '<td>'.$rss->diamond_2_shape.'</td>';
		$diamond_2_color 		= '<td>'.$rss->diamond_2_color.'</td>';
		$diamond_2_setting_type = '<td>'.$rss->diamond_2_setting_type.'</td>';
		$diamond_3_stones 		= '<td>'.$rss->diamond_3_stones.'</td>';
		$diamond_3_weight 		= '<td>'.$rss->diamond_3_weight.'</td>';
		$diamond_3_clarity 		= '<td>'.$rss->diamond_3_clarity.'</td>';
		$diamond_3_shape 		= '<td>'.$rss->diamond_3_shape.'</td>';
		$diamond_3_color 		= '<td>'.$rss->diamond_3_color.'</td>';
		$diamond_3_setting_type = '<td>'.$rss->diamond_3_setting_type.'</td>';
		$diamond_4_stones 		= '<td>'.$rss->diamond_4_stones.'</td>';
		$diamond_4_weight 		= '<td>'.$rss->diamond_4_weight.'</td>';
		$diamond_4_clarity 		= '<td>'.$rss->diamond_4_clarity.'</td>';
		$diamond_4_shape 		= '<td>'.$rss->diamond_4_shape.'</td>';
		$diamond_4_color 		= '<td>'.$rss->diamond_4_color.'</td>';
		$diamond_4_setting_type = '<td>'.$rss->diamond_4_setting_type.'</td>';
		$diamond_5_stones 		= '<td>'.$rss->diamond_5_stones.'</td>';
		$diamond_5_weight 		= '<td>'.$rss->diamond_5_weight.'</td>';
		$diamond_5_clarity 		= '<td>'.$rss->diamond_5_clarity.'</td>';
		$diamond_5_shape 		= '<td>'.$rss->diamond_5_shape.'</td>';
		$diamond_5_color 		= '<td>'.$rss->diamond_5_color.'</td>';
		$diamond_5_setting_type = '<td>'.$rss->diamond_5_setting_type.'</td>';
		$diamond_6_stones 		= '<td>'.$rss->diamond_6_stones.'</td>';
		$diamond_6_weight 		= '<td>'.$rss->diamond_6_weight.'</td>';
		$diamond_6_clarity 		= '<td>'.$rss->diamond_6_clarity.'</td>';
		$diamond_6_shape 		= '<td>'.$rss->diamond_6_shape.'</td>';
		$diamond_6_color 		= '<td>'.$rss->diamond_6_color.'</td>';
		$diamond_6_setting_type = '<td>'.$rss->diamond_6_setting_type.'</td>';
		$diamond_7_stones 		= '<td>'.$rss->diamond_7_stones.'</td>';
		$diamond_7_weight 		= '<td>'.$rss->diamond_7_weight.'</td>';
		$diamond_7_clarity 		= '<td>'.$rss->diamond_7_clarity.'</td>';
		$diamond_7_shape 		= '<td>'.$rss->diamond_7_shape.'</td>';
		$diamond_7_color 		= '<td>'.$rss->diamond_7_color.'</td>';
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
			<td class="border left bottom"><input type="checkbox" name="chk_order"></td>	
			<td class="border bottom" width="150" style="color:#0066cc;">
			<b>Order Id : </b>'.$rss->order_id.'<br>
			<img src="'.$rss->product_image.'" height="120" width="120" class="img_padding"></td>
					
			<td class="bottom" width="400">
				<table name="product_data" width="100%">
					<tbody>
						<tr><td><b>SKU : </b>'.$rss->sku.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<b>Status : <u class="red">'.$status_name.'</u></b><br>
							
							</td></tr>	
						<tr><td><b><a href="'.$product_url.'" style="color:#0066CC;text-decoration:none;" target="_blank">'.$rss->product_name.'</a></b></td></tr>
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
									$complete_table .= '<td><b>Height : </b>'.$rss->height.'</td>';
								}
								if($rss->height!='') {
									$complete_table .= '<td><b>Width : </b>'.$rss->width.'</td>';
								}
								$complete_table .='</tr>';
								
								$complete_table .= '<tr>';
								if($rss->top_thickness) {
									$complete_table .='<td width="150"><b>Top Thickness : </b>'.$rss->top_thickness.'</td>';
									}
								if($rss->bottom_thickness) {	
									$complete_table .='<td width="150"><b>Bottom Thickness : </b>'.$rss->bottom_thickness.'</td>';
								}
								$complete_table .= '</tr>';
								
								$complete_table .= '<tr>';
								if($rss->top_height!='') {
									$complete_table .= ' <td width="125"><b>Top Height : </b>'.$rss->top_height.'</td>';
								}	
								if($rss->total_weight!='') {	
									$complete_table .='<td width="140"><b>Total Weight : </b>'.$rss->total_weight.'</td>';
								}
								$complete_table .= '</tr></tbody>
							</table>
							</td>
						</tr>
					</tbody>	
				</table>
			</td>
			
			<td class="bottom" width="150" valign="top">';
			
			$quan_class = ($rss->quantity > 1) ? 'red' : '';
			
			$complete_table .= '<br><br><table name="order_detail">
					<tbody>
						<tr><td><b>Qty : <span class="'.$quan_class.'">'.$rss->quantity.'</span></b></td></tr>
						<tr><td>Value : </td><td>'.$rss->unit_price.'</td></tr>
						<tr><td>Shipping : </td><td>'.$rss->shipping_amount.'</td></tr>
						<tr><td><b>Total : </b></td><td><b>'.$total.'</b></td></tr>
					</tbody>	
				</table>
			</td>
			<td class="bottom" width="180" valign="">';
			$complete_table .= '<p>'.$rss->customer_name .' '. $rss->customer_lastname.'</p><br>
								<p>'.$rss->shipping_country.'</p><br>
								<p class="red">'.$greeting_card_name.'</p><br>
								<p>'.$personal_message.'</p><br>
								<p>'.$initial_note.'</p>
			</td>';
			
			$complete_table .= '<td class="bottom" width="180" valign="top">';
			
			$complete_table .= '<br><br>'.date("F j, Y", strtotime($rss->expected_delivery_date)).'</td>
			<td class="bottom" style="padding-bottom: 20px;">';
										
			$complete_table .='<br><br><form method="POST" action="'.base_url('index.php/erp_order/order_save').'" name="order_update" id="order_update">';
			
			$complete_table .='<input type="hidden" name="order_id" value="'.$order_id.'" />';
			$complete_table .='<input type="hidden" name="order_product_id" value="'.$erp_id.'" />';
			$complete_table .='<input type="hidden" name="order_status_id" value="'.$order_status_id.'" />';
			$complete_table .='<input type="hidden" name="vendor_id" value="'.$vendor_id.'" />';
			$complete_table .='<input type="hidden" name="greeting_card_id" value="'.$greeting_card_id.'">';
			$complete_table .='<input type="hidden" name="personal_message" value="'.$personal_message.'" />';
			
			//$complete_table .= '<div id="status_'.$trCount.'"> <p><b>Status</b></p>';
			//$complete_table .= $status_dropdown.'<br></div>';
						
			//$complete_table .= '<div id="vendor_dis_'.$trCount.'"> <p><b>Vendor</b></p>';
			//$complete_table .= $vendor_dropdown.'<br></div>';
			
			//$complete_table .= '<div id="greeting_dis_'.$trCount.'"><p><b>Greeting Card</b></p>';
			//$complete_table .= $greeting_dropdown.'<br></div>';
			
			$complete_table .= '<p><b>Notes</b></p>';
			$complete_table .= '<textarea name="notes" class="dropWidth"></textarea><br>';
						
			$complete_table .= '<input type="submit" name="btn_submit" value="Update" class="styled-button-1">';
						
			$complete_table .='</form>';
			
			$complete_table .='<div class="popbox">
							<a class="open" href="#">+</a>
							<div class="collapse">
							  <div class="box">
								<div class="arrow"></div>
								<div class="arrow-border"></div>
								<div id="abcd">'.$all_notes.'</div>
							  </div>
							</div>
						  </div>';
						  
			$complete_table .= '</td>
			<td class="right bottom">
					
			</td>
		</tr>';
		
		if($rss->diamond_1_status==1 || $rss->diamond_2_status==1 || $rss->diamond_3_status==1 || $rss->diamond_4_status==1 || $rss->diamond_5_status==1 || $rss->diamond_6_status==1 || $rss->diamond_7_status==1) {
		
		$complete_table .= '<tr class="'.$bgclass.' sub_tr">
		<td class="bottom left"></td>';
				
		if($rss->diamond_1_status==1 || $rss->diamond_2_status==1 || $rss->diamond_3_status==1 || $rss->diamond_4_status==1 || $rss->diamond_5_status==1 || $rss->diamond_6_status==1 || $rss->diamond_7_status==1) {
		$complete_table .= '<td colspan="3" class="top_btm_padding bottom">
		<table width="100%" style="border: 1px solid black;" class="diamond_detail">
			<tr><td colspan="8" align="center"><b><u>Diamond Details</u></b></td></tr>
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
		<td class="bottom"></td>';
		}
		else {
			$complete_table .= '<td colspan="3" align="center" class="bottom btm_padding"></td>';
		}
			
		if($rss->gem_1_status==1 || $rss->gem_2_status==1 || $rss->gem_3_status==1 || $rss->gem_4_status==1 || $rss->gem_5_status==1) {
		$complete_table .= '<td colspan="3" align="center" class="top_btm_padding bottom right">
			<table width="90%" style="border: 1px solid black;" name="gemstone_detail">
			<tr><td colspan="6" align="center"><b><u>Gemstone Details</u></b></td></tr>
			<tr><td><b>No. of Gemstones</b></td>';
			
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
			$complete_table .= '<td colspan="3" align="center" class="bottom right btm_padding"></td>';
		}
			$complete_table .= '</tr>';
		}
		$trCount++;
	}
} ?>
<?php $complete_table .= '</table>';
echo $complete_table; ?>

<!-- Pagination for Archieved list -->
<?php 
if($completedata) {
	echo $this->pagination->create_links();
} ?>
</p>			          
</div>					
					
<div id="tabs-4" data-counter="3" style="padding-bottom:3%;">
<p>
  <table width="100%" cellspacing=0 cellpadding=0 id="product_update_table" style="margin: 0 auto;">
				<tbody>
					<tr style="height:40px;">
						<th class="th_color">Id</th>
						<th class="th_color">Image</th>
						<th class="th_color">Order Id</th>
						<th class="th_color">Product Id</th>
						<th class="th_color">SKU</th>
						<th class="th_color">Product Name</th>
						<th class="th_color">Status</th>
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
			?>				
				<tr class="<?php echo $bgclass ?>" data-href="<?php echo base_url('index.php/erp_order/addfinishedproductdetails?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'') ?>">
						<td align="center" class="bottom left"><?php echo $row_count; ?></td>
						<td align="center" class="left bottom" style="padding:10px;"><?php echo '<img src="'.$pru->product_image.'" width="100" height="100">' ?></td>
						<td align="center" class="bottom"><?php echo $pru->order_id ?></td>
						<td align="center" class="bottom"><?php echo $pru->erp_order_id ?></td>
						<td align="center" class="bottom"><?php echo $pru->sku ?></td>
						<td align="center" class="bottom"><?php echo $pru->product_name ?></td>
						<td align="center" class="bottom right"><?php echo $pru->status_name ?></td>
				</tr>
			<?php
			$row_count++;
			}
		} ?>
			</tbody>
		</table>

<!-- Pagination for Product update list -->
<?php 
if($prod_updates) {
	echo $this->pagination->create_links();
} ?>
</p>	 
</div>			
</div>
		

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

$(document).ready(function(){
    $('#product_update_table tr').click(function(){
        window.location = $(this).data('href');
        return false;
    });
});
</script>

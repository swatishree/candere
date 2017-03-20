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
					alert("Something went wrong. Please try again.");
				
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
		$_user_id 		= @$this->session->userdata('_user_id');	
	    $logout_url 	= base_url().'index.php/login/logout';

		$query_inboxes	= $this->db->query("select email_id from email_activities where email_to = '".$_user_id."'");
		$query_inbox 	= $query_inboxes->result();
		$query_outboxes	= $this->db->query("select email_id from email_activities where email_from = '".$_user_id."'");
		$query_outbox 	= $query_outboxes->result();
		
		$query_dept	= $this->db->query("select user_id,email from user_signup where status = 'A'");
		$query_department 	= $query_dept->result();
		//echo $this->db->last_query();		
?>
		
<ul id="nav">
      <li><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>">Home</a></li>
	  <li><a href="<?php echo "http://candere.com/dashboard_report/admin/pages/report.php"; ?>" target="_blank">Dashboard</a></li>
 	  <?php if($_username!='') { ?>
		<li><a href="<?php echo $logout_url ?>">Logout ( <?php echo ucwords($_username) ?> )</a></li>
	  <?php } ?>
</ul>
<div id="quotescointainer">
<div id="quotesleft">
<ul id="buttons">
   <?php
   if($this->session->userdata('_username')=='sales' || $this->session->userdata('_username')=='marketplace' || $this->session->userdata('_username')=='Rupesh Jain')
   { ?><li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li><?php } ?>
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
	 <li><a href="<?php echo base_url('index.php/erp_order/vendor_list')?>"><b>Vendor List</b></a></li>
     <?php } ?>
	 <li class="active"><a href="<?php echo base_url('index.php/erp_order/send_email?param=inbox')?>"><b>Send Email (<?php echo count($query_inbox); ?>)</b></a></li>
	 <li><a href="<?php echo base_url('index.php/erp_order/delayed')?>"><b>Delayed Delivery</b></a></li>
</ul>
</div>
<br><br>
<div id="quotescenter" style="padding-top:10px;">
<form name="srch_frm" id="srch_frm" method="post" action="<?php echo base_url('index.php/erp_order/send_email?param='.$_REQUEST['param']); ?>">
<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:150px;height:31px;" value="<?php echo set_value('search_order_id'); ?>">
<input type="submit" name="sts_submit" value="Search" class="styled-button-1">
</form>

</div>

<div id="quotesright" style="padding-top:16px;">
<form name="frmdept" id="frmdept" method="post" action="<?php echo base_url('index.php/erp_order/send_email?param='.$_REQUEST['param']); ?>">
	<select name="search_dept" id="search_dept" class="tb10" style="width:150px;height:31px;">
	<option value="">Select</option>
	<?php
		foreach($query_department as $query_dep):		
	?>
		<option value="<?php echo $query_dep->user_id; ?>"><?php echo $query_dep->email; ?></option>
	<?php endforeach; ?>
	</select><input type="submit" name="sbmt" value="Search" class="styled-button-1">
</form>
</div>
</div>
<br><br>
<table width="100%" cellspacing=0 cellpadding=0 border="0">	
	<tr>
		<td width="10%" height="100%" valign="top">
			<table cellspacing=0 cellpadding=0 border="0">
				<tr>
					<td style="width:200px;padding:10 40"><a href="<?php echo base_url('index.php/erp_order/send_email?param=inbox')?>"><b>Inbox (<?php echo count($query_inbox); ?>)</b></a></td>
				</tr>
				<tr>
					<td style="width:200px;padding:10 40"><a href="<?php echo base_url('index.php/erp_order/send_email?param=outbox')?>"><b>Outbox (<?php echo count($query_outbox); ?>)</b></a></td>
				</tr>
				<tr>
					<td style="width:200px;padding:10 40"><a href="<?php echo base_url('index.php/erp_order/send_email?param=sent_mail')?>"><b>Compose Mail</b></a></td>
				</tr>
			</table>		
		</td>
		<td width="90%" height="100%">
		<?php
		
			if($_REQUEST['param'] == 'inbox')
				$title = 'From';
			else if($_REQUEST['param'] == 'outbox')
				$title = 'To';
			if($_REQUEST['param'] == 'inbox' || $_REQUEST['param'] == 'outbox')
			{
				$order_table = '';
				$order_table = '<u><h1>'.ucfirst($_REQUEST['param']).'</h1></u><br><table width="100%" cellspacing=0 cellpadding=0 name="order_table" id="order_table" class="tablesorter" style="padding:0 10px 20px 10px;" border="0">
				<tr height="40" style="padding-bottom:100px;">					
					<th align="left" class="th_color" style="width:150px;padding-left:20px;">'.$title.'</th>
					<th class="th_color"style="width:150px;">Priority</th>
					<th class="th_color"style="width:150px;">Subject</th>
					<th class="th_color"style="width:800px;">Content</th>
					<th class="th_color"style="width:100px;">Recieved Date</th>
				</tr>'; 
				if($selectdata)
				{			
					$array 		= array();
					$data 		= array();
					$counter 	= 1;
					$trCounter 	= 1;
					foreach($selectdata as $row){
						$email_id		= $row->email_id;
						$email_to		= $row->email_to;		
						$email_from 	= $row->email_from;
						$username 	= $row->username;
						$subject 	= $row->subject;
						$content 	= $row->content;
						$priority 	= $row->priority;
						$recieved_date 	= $row->recieved_date;
						
						if($recieved_date == '1970-01-01')
							$recieved_date = '';

						if(!in_array($vendor_id,$data)) {
							$counter++;
						}
						
						$bgclass= ($counter%2==0) ? 'bg_2' : 'bg_1';

						$order_table .= '<tr class="'.$bgclass.' main_tr" id="'.$trCounter.'">
							<td class="border bottom left" style="padding:10px 20px;color:#0066cc;" valign="top">'.ucfirst($username).'</td><td class="bottom left right" valign="top" style="padding:10px 20px;color:#0066cc;">Priority: '.ucfirst($priority).'</td><td class="bottom left right" valign="top" style="padding:10px 20px;color:#0066cc;">'.ucfirst($priority).'</td>
							<td class="bottom left right" valign="top" style="padding:10px 20px;color:#0066cc;">'.ucfirst($subject).'</td><td class="bottom left right" valign="top" style="padding:10px 20px;color:#0066cc;">'.htmlspecialchars_decode($content).'</td><td class="bottom left right" valign="top" style="padding:10px 20px;color:#0066cc;">'.date('d-m-Y H:i:s a', strtotime($recieved_date)).'</td></tr>';
						$trCounter++;
					}
				} 
				
				$order_table .= '</table>';
				echo $order_table;
			}
			
			if($_REQUEST['param'] == 'sent_mail')
			{
				?>
					
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="//code.jquery.com/jquery-1.8.0.min.js"></script>
<script type="text/javascript">



$(function(){
$(".search_keyword").keyup(function() 
{ 
	var search_keyword_value = $(this).val();
	var dataString = 'search_keyword='+ search_keyword_value;
	$.ajax({
		type: 'POST',
		url : "<?php echo base_url()?>index.php/erp_order/search",
		data : dataString,
		success : function(result) {
			$("#result").html(result).show();
		}
	});
});

$("#result").live("click",function(e){
	var $clicked = $(e.target);
	var $name = $clicked.find('.country_name').html();
	var decoded = $("<div/>").html($name).text(); 
	$('#search_keyword_id').val(decoded);
	var search_keyword_value = decoded;
	var dataString = 'search_keyword='+ search_keyword_value;
	$.ajax({
		type: 'POST',
		url : "<?php echo base_url()?>index.php/erp_order/search_value",
		data : dataString,
		success : function(result) {
			$("#div_product_details").show();
			$("#div_regards").show();
			$("#div_details").html(result);
			$("#product_details").val(result);
			
		}
	});
});
$(document).live("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search_keyword")){
		$("#result").fadeOut(); 
	}
});
$('#search_keyword_id').click(function(){
	$("#result").fadeIn();
});
});
</script>
</head>

<body>
	
</body>
</html>
<style type="text/css">
	.web{
		font-family:tahoma;
		size:12px;
		top:10%;
		border:1px solid #CDCDCD;
		border-radius:10px;
		padding:10px;
		width:38%;
		margin:auto;
	}
	h1{
		margin: 3px 0;
		font-size: 13px;
		text-decoration: underline;
	}
	.tLink{
		font-family:tahoma;
		size:12px;
		padding-left:10px;
		text-align:center;
	}
	#search_keyword_id
	{
		width:300px;
		border:solid 1px #CDCDCD;
		padding:6px;
		font-size:14px;
	}
	#result
	{
		position:absolute;
		width:320px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CDCDCD solid;
		background-color: white;
	}
	.show
	{
		font-family:tahoma;
		padding:10px; 
		border-bottom:1px #CDCDCD dashed;
		font-size:15px; 
	}
	.show:hover
	{
		background:#364956;
		color:#FFF;
		cursor:pointer;
	}
</style><h1>Sent Mail</h1>
				<table width="100%" cellspacing=0 cellpadding=0 name="order_table" id="order_table" class="tablesorter" style="padding:0 10px 20px 10px;" border="0">
					<form method="post" name="frm_email" id="frm_email" action="<?php echo base_url('index.php/erp_order/send_email?param=sent_mail'); ?>" >
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" style="color:green;padding-left:250px;"><?php echo $selectdata; ?></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr rowspan="2">
							<td width="20%" style="padding-left:250px;" valign="top" >To:</td>
							<td>
								<?php
								
								$user_signup = $this->db->query("select user_id, email from user_signup where status='A'");
								$user_data = $user_signup->result();								
											
								foreach($user_data as $user_data)
								{
									$user_id	.= $user_data->user_id. ", ";
									$email		.= $user_data->email. ", ";
								}
								
								$user_implode = explode(', ', rtrim($user_id, ", "));
								$email_implode = explode(', ', rtrim($email, ", "));
								
								$user_email = array_combine($user_implode, $email_implode);							
								
								 ?>
								<select name="user_email[]" id="user_email" style="padding: 9 10 64 22" multiple>
									<?php foreach($user_email as $key=>$value) { ?>
									<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" style="padding-left:250px;">Priority:</td>
							<td>
								<select name="priority" id="priority" class="search_keyword" style="width:200px;height:30px;"  >
									<option value="Normal">Normal</option>
									<option value="High">High</option>
									<option value="Critical">Critical</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" style="padding-left:250px;">Subject:</td>
							<td><input type="text" name="subject" id="subject" value="" style="width:800px;height:30px;" /></td>
						</tr>						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" style="padding-left:250px;">Order No:</td>
							<td><input type="text" class="search_keyword" id="search_keyword_id" name="order_no" value=""  /><div id="result"></div><input type="hidden" name="product_details" id="product_details" value=""  />
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" style="padding-left:250px;"></td>
							<td>&nbsp;</td>
						</tr>
						<tr id="div_product_details" style="display:none;">
							<td valign="top" style="padding-left:250px;">&nbsp;</td>
							<td><div id="div_details"></div></td>
						</tr>						
						
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td valign="top" style="padding-left:250px;">Content:</td>
							<td><textarea name="content" id="content" style="width:800px;height:100px;"></textarea></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr id="div_regards" style="display:none;padding-left:250px;">
							<td valign="top" style="padding-left:250px;">&nbsp;</td>
							<td>Regards,<br>(<?php echo ucfirst($_username); ?>)</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-left:340px;"><input type="submit" name="submit_email" id="submit_email" value="Sent Email" class="styled-button-1" style="width:110px;"></td>
						</tr>
					</form>
				</table>
		<?php }	?>
		</td>
	</tr>
</table>
<!-- Pagination for To do list -->

<?php
	echo $this->pagination->create_links();
 ?>
<style>
.form-style-9 ul li .field-split {
width: 30%;
}
.ui-datepicker-trigger{float: right;margin-right: -32%;}
label {
font-weight: bold; }
</style>

<div class="nav-top clearfix" style="display:table;min-height:50px;"><span style="font-size: 18px;font-weight: bold;">Order Management</span></div>

<?php 

	$_username 		= @$this->session->userdata('_username');	
	$logout_url 	= base_url().'index.php/login/logout';  ?>
		
<ul id="nav">
      <li><a href="#">Home</a></li>
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
<div id="quotesleft" >
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
<div id="quotescenter" style="padding-top:5px;"></div>
<div id="quotesright" style="padding-top:5px;"></div>
</div>

<?php
 $query = $this->db->select("*")
              ->from('erp_order') 
              ->where('id', $selectdata->id)
              
              ->get();
	$order_data = $query->row();
	
	if(isset($order_data->id))
	{   
		$order_id 				= $order_data->order_id;
		$order_product_id 		= $order_data->order_item_id;
		$gold_weight 			= $order_data->gold_weight;
		$diamond_weight 		= $order_data->diamond_weight;
		$gemstone_weight 		= $order_data->gemstone_weight;		 
	}
	else
	{ 
		$order_id 				= '';
		$order_product_id 		= '';
		$receipt_date 			= '';
		$gold_weight 			= '';
		$diamond_weight 		= '';
		$gemstone_weight		= '';
	}

$form_action 	= base_url('index.php/erp_order/saveproductweightdetails');

  ?>

<div style="padding-top:60px;">

<h1 style="float:left; width:200px; color: #305A72;  margin-left:6%; font-size:13px; clear:both; ">Update Final Weight</h1>

<form class="form-style-9" name="flip_order_form" id="flip_order_form" method="post" action="<?php echo $form_action ?>" style="">
<input type="hidden" name="id" value='<?php echo $selectdata->id ?>'>
<input type="hidden" name="order_product_id" value='<?php echo $selectdata->erp_order_id ?>'>
<input type="hidden" name="order_item_id" value='<?php echo $selectdata->order_item_id ?>'>

<ul>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Order ID</label>
    <input type="text" name="order_id" class="field-style field-split align-left" value="<?php echo $selectdata->order_id ?>" readonly />
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Order Product Name</label>
    <input type="text" name="product_name" id="product_name" class="field-style field-split align-left"  value="<?php echo $selectdata->product_name ?>" readonly />	 
</li>
<li style="clear:both;">
  <label style="float: left;margin-left: 2%;width:125px;">  Gold Weight </label><input type="text" name="gold_weight" id="gold_weight" class="field-style field-split align-left"  value="<?php echo $gold_weight; ?>"  /><br/>
</li>

<li style="clear:both;">

 <label style="float: left;margin-left: 2%;width:125px;"> Diamond weight</label><input type="text" name="diamond_weight" id="diamond_weight" class="field-style field-split align-left"  value="<?php echo $diamond_weight; ?>"  /><br/>	
 </li>

<li style="clear:both;">
<label style="float: left;margin-left: 2%;width:125px;">  Gemstone weight</label><input type="text" name="gemstone_weight" id="gemstone_weight" class="field-style field-split align-left"  value="<?php echo $gemstone_weight; ?>"  /><br/>
</li>


<li style="clear:both;">
	<span style="display:inline;margin-left:12%;">
	<input type="submit" name="submit" value="Submit" class="styled-button-1 ">
	<input type="button" class="styled-button-1" value="Back" onClick="history.back();return true;" style="margin-left:10px;">
	</span>
</li>
</ul>
</form>

</div>
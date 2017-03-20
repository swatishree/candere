<style>
.form-style-9 ul li .field-split {
width: 30%;
}
.ui-datepicker-trigger{float: right;margin-right: -32%;}
label {
font-weight: bold; }
</style>

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
<div id="quotesleft" >
<ul id="buttons">
    <li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/processing_orders')?>"><b>Processing Orders</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/archieved_orders')?>"><b>Archieved Orders</b></a></li>
    <li class="active"><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
</ul>
</div>
<div id="quotescenter" style="padding-top:5px;"></div>
<div id="quotesright" style="padding-top:5px;"></div>
</div>

<script>
$(function() {
	$( "#datepicker" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo base_url(); ?>themes/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date"
	});
	$("#datepicker").datepicker("setDate", new Date());
});
</script>

<?php
$query = $this->db->select("*")
              ->from('trnfinishedproduct') 
              ->where('order_id', $selectdata->order_id)
              ->where('order_product_id', $selectdata->order_product_id)
              ->get();
$order_data = $query->row();
//echo '<pre>'; print_r($order_data); exit;
	
	if(isset($order_data->id)){   
		$order_id 				= $order_data->order_id;
		$order_product_id 		= $order_data->order_product_id;
		$total_diamond_count 	= $order_data->total_diamond_count;
		$receipt_date 			= $order_data->receipt_date;
		$metal_id 				= $order_data->metal_id;
		$metal_purity_id 		= $order_data->metal_purity_id;
		$metal_weight 			= $order_data->metal_weight;
		$total_weight 			= $order_data->total_weight;
		$total_gemstone_count 	= $order_data->total_gemstone_count;
		$diamond_1_count 		= $order_data->diamond_1_count;
		$diamond_1_weight 		= $order_data->diamond_1_weight;
		$diamond_1_clarity 		= $order_data->diamond_1_clarity;
		$diamond_1_color 		= $order_data->diamond_1_color;
		$diamond_2_count 		= $order_data->diamond_2_count;
		$diamond_3_count 		= $order_data->diamond_3_count;
		$diamond_2_weight 		= $order_data->diamond_2_weight;
		$diamond_2_clarity 		= $order_data->diamond_2_clarity;
		$diamond_2_color 		= $order_data->diamond_2_color;
		$diamond_3_weight 		= $order_data->diamond_3_weight;
		$diamond_3_count 		= $order_data->diamond_3_count;
		$diamond_3_clarity 		= $order_data->diamond_3_clarity;
		$diamond_3_color 		= $order_data->diamond_3_color;
		$diamond_4_count 		= $order_data->diamond_4_count;
		$diamond_4_weight 		= $order_data->diamond_4_weight;
		$diamond_4_clarity 		= $order_data->diamond_4_clarity;
		$diamond_4_color 		= $order_data->diamond_4_color;
		$diamond_5_count 		= $order_data->diamond_5_count;
		$diamond_5_weight 		= $order_data->diamond_5_weight;
		$diamond_5_clarity 		= $order_data->diamond_5_clarity;
		$diamond_5_color 		= $order_data->diamond_5_color;
		$diamond_6_count 		= $order_data->diamond_6_count;
		$diamond_6_weight 		= $order_data->diamond_6_weight;
		$diamond_6_clarity 		= $order_data->diamond_6_clarity;
		$diamond_6_color 		= $order_data->diamond_6_color;
		$diamond_7_count 		= $order_data->diamond_7_count;
		$diamond_7_weight 		= $order_data->diamond_7_weight;
		$diamond_7_clarity 		= $order_data->diamond_7_clarity;
		$diamond_7_color 		= $order_data->diamond_7_color; 
		$gemstone_1_name 		= $order_data->gemstone_1_name;
		$gemstone_1_count 		= $order_data->gemstone_1_count;
		$gemstone_1_weight 		= $order_data->gemstone_1_weight;
		$gemstone_2_name 		= $order_data->gemstone_2_name; 
		$gemstone_2_count 		= $order_data->gemstone_2_count;
		$gemstone_2_weight		= $order_data->gemstone_2_weight;
		$gemstone_3_name 		= $order_data->gemstone_3_name; 
		$gemstone_3_count 		= $order_data->gemstone_3_count;
		$gemstone_3_weight 		= $order_data->gemstone_3_weight; 
		$gemstone_4_name 		= $order_data->gemstone_4_name;
		$gemstone_4_count 		= $order_data->gemstone_4_count;
		$gemstone_4_weight 		= $order_data->gemstone_4_weight;
		$gemstone_5_name 		= $order_data->gemstone_5_name; 
		$gemstone_5_count 		= $order_data->gemstone_5_count;
		$gemstone_5_weight 		= $order_data->gemstone_5_weight;
	}else{ 
		$order_id 				= '';
		$order_product_id 		= '';
		$receipt_date 			= '';
		$metal_id 				= '';
		$metal_purity_id 		= '';
		$total_diamond_count 	= '';
		$metal_weight 			= '';
		$total_weight 			= '';
		$total_gemstone_count 	= '';
		$diamond_1_count 		= '';
		$diamond_1_weight 		= '';
		$diamond_1_clarity 		= '';
		$diamond_1_color 		= '';
		$diamond_2_count 		= '';
		$diamond_3_count 		= '';
		$diamond_2_weight 		= '';
		$diamond_2_clarity 		= '';
		$diamond_2_color 		= '';
		$diamond_3_weight 		= '';
		$diamond_3_count 		= '';
		$diamond_3_clarity 		= '';
		$diamond_3_color 		= '';
		$diamond_4_count 		= '';
		$diamond_4_weight 		= '';
		$diamond_4_clarity 		= '';
		$diamond_4_color 		= '';
		$diamond_5_count 		= '';
		$diamond_5_weight 		= '';
		$diamond_5_clarity 		= '';
		$diamond_5_color 		= '';
		$diamond_6_count 		= '';
		$diamond_6_weight 		= '';
		$diamond_6_clarity		= '';
		$diamond_6_color 		= '';
		$diamond_7_count 		= '';
		$diamond_7_weight 		= '';
		$diamond_7_clarity 		= '';
		$diamond_7_color 		= '';
		$gemstone_1_name 		= ''; 
		$gemstone_1_count 		= '';
		$gemstone_1_weight 		= '';
		$gemstone_2_name 		= '';
		$gemstone_2_count 		= ''; 
		$gemstone_2_weight 		= '';
		$gemstone_3_name 		= ''; 
		$gemstone_3_count 		= '';
		$gemstone_3_weight 		= '';
		$gemstone_4_name 		= ''; 
		$gemstone_4_count 		= '';
		$gemstone_4_weight 		= '';
		$gemstone_5_name 		= ''; 
		$gemstone_5_count 		= '';
		$gemstone_5_weight 		= '';
	}

$form_action 	= base_url('index.php/erp_order/saveproductdetails');
$base_url 		= base_url('index.php/erp_order/to_do_list');

$key['status'] 	= 1;

// $metal_values 	= $this->erpmodel->GetInfoRow('metal_values',$key);
// $metal_option[''] = 'Select Metal';
// foreach($metal_values as $metal) {
	// $metal_option[$metal->metal_id] = $metal->metal_value;
// }
// $metal_dropdown = form_dropdown('metal_id', $metal_option,$metal_id,'id="metal_id" class="field-style field-split align-left" style="float: left;margin-left: 6%;"');


// $purity_values 	= $this->erpmodel->GetInfoRow('metal_purity_values',$key);
// $purity_option[''] = 'Select Purity';
// foreach($purity_values as $purity) {
	// $purity_option[$purity->metal_purity_id] = $purity->purity_value;
// }
// $purity_dropdown = form_dropdown('metal_purity_id',$purity_option,$metal_purity_id,'id="metal_purity_id" class="field-style field-split align-left" style="float: left;margin-left: 6%;"');


// $clarity_values 	= $this->erpmodel->GetInfoRow('diamond_clarity',$key);
// $clarity_option[''] = 'Select Clarity';
// foreach($clarity_values as $clarity) {
	// $clarity_option[$clarity->clarity_id] = $clarity->clarity_name;
// }
// $clarity_1_dropdown = form_dropdown('diamond_1_clarity',$clarity_option,$diamond_1_clarity,'id="diamond_1_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_2_dropdown = form_dropdown('diamond_2_clarity',$clarity_option,$diamond_2_clarity,'id="diamond_2_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_3_dropdown = form_dropdown('diamond_3_clarity',$clarity_option,$diamond_3_clarity,'id="diamond_3_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_4_dropdown = form_dropdown('diamond_4_clarity',$clarity_option,$diamond_4_clarity,'id="diamond_4_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_5_dropdown = form_dropdown('diamond_5_clarity',$clarity_option,$diamond_5_clarity,'id="diamond_5_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_6_dropdown = form_dropdown('diamond_6_clarity',$clarity_option,$diamond_6_clarity,'id="diamond_6_clarity" class="field-style field-split align-left" style="width:130px;"');
// $clarity_7_dropdown = form_dropdown('diamond_7_clarity',$clarity_option,$diamond_7_clarity,'id="diamond_7_clarity" class="field-style field-split align-left" style="width:130px;"');

// $color_values 		= $this->erpmodel->GetInfoRow('diamond_color',$key);
// $color_option[''] 	= 'Select Color';
// foreach($color_values as $color) {
	// $color_option[$color->color_id] = $color->color_value;
// }
 

// $color_1_dropdown = form_dropdown('diamond_1_color',$color_option, $diamond_1_color,'id="diamond_1_color" class="field-style field-split align-left" style="width:130px;"');
// $color_2_dropdown = form_dropdown('diamond_2_color',$color_option, $diamond_2_color,'id="diamond_2_color" class="field-style field-split align-left" style="width:130px;"');
// $color_3_dropdown = form_dropdown('diamond_3_color',$color_option, $diamond_3_color,'id="diamond_3_color" class="field-style field-split align-left" style="width:130px;"');
// $color_4_dropdown = form_dropdown('diamond_4_color',$color_option, $diamond_4_color,'id="diamond_4_color" class="field-style field-split align-left" style="width:130px;"');
// $color_5_dropdown = form_dropdown('diamond_5_color',$color_option, $diamond_5_color,'id="diamond_5_color" class="field-style field-split align-left" style="width:130px;"');
// $color_6_dropdown = form_dropdown('diamond_6_color',$color_option, $diamond_6_color,'id="diamond_6_color" class="field-style field-split align-left" style="width:130px;"');
// $color_7_dropdown = form_dropdown('diamond_7_color',$color_option, $diamond_7_color,'id="diamond_7_color" class="field-style field-split align-left" style="width:130px;"');
// $color_7_dropdown = form_dropdown('diamond_7_color',$color_option, $diamond_7_color,'id="diamond_7_color" class="field-style field-split align-left" style="width:130px;"'); ?>

<div style="padding-top:60px;">

<h1 style="float:left; width:200px; color: #305A72;  margin-left:6%; font-size:13px; clear:both; ">Add Finished Product Details</h1>

<form class="form-style-9" name="flip_order_form" id="flip_order_form" method="post" action="<?php echo $form_action ?>" style="">

<input type="hidden" name="order_product_id" value='<?php echo $selectdata->erp_order_id ?>'>
<input type="hidden" name="order_item_id" value='<?php echo $selectdata->order_item_id ?>'>

<ul>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Order ID</label>
    <input type="text" name="order_id" class="field-style field-split align-left" value="<?php echo $selectdata->order_id ?>" readonly />
	<span style="float: right;margin: -2% 7% 0 0;"><img src="<?php echo $selectdata->product_image ?>" height="120" width="120" class="img_padding"> </span>
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Order Product Name</label>
    <input type="text" name="product_name" id="product_name" class="field-style field-split align-left"  value="<?php echo $selectdata->product_name ?>" readonly />
	
	
	 
</li>


 

 


 

<li style="clear:both;">
</li>


<?php if($selectdata->diamond_1_status == 1 || $selectdata->diamond_2_status == 1 || $selectdata->diamond_3_status == 1 || $selectdata->diamond_4_status == 1 || $selectdata->diamond_5_status == 1 || $selectdata->diamond_6_status == 1 || $selectdata->diamond_7_status == 1 ){ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond Count</label>
	
	<?php if($selectdata->diamond_1_status == 1){ ?>
   diamond_1_count&nbsp;&nbsp;<input type="text" name="diamond_1_count" id="diamond_1_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_count ?>" />
   <?php } ?>
	
	<?php if($selectdata->diamond_2_status == 1){ ?>
	diamond_2_count&nbsp;&nbsp;<input type="text" name="diamond_2_count" id="diamond_2_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_3_status == 1){ ?>
	diamond_3_count&nbsp;&nbsp;<input type="text" name="diamond_3_count" id="diamond_3_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_4_status == 1){ ?>
	diamond_4_count&nbsp;&nbsp;<input type="text" name="diamond_4_count" id="diamond_4_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_5_status == 1){ ?>
	diamond_5_count&nbsp;&nbsp;<input type="text" name="diamond_5_count" id="diamond_5_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_6_status == 1){ ?>
	diamond_6_count&nbsp;&nbsp;<input type="text" name="diamond_6_count" id="diamond_6_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_7_status == 1){ ?>
	diamond_7_count&nbsp;&nbsp;<input type="text" name="diamond_7_count" id="diamond_7_count" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_count ?>" />
	<?php } ?>
</li>





<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond Size</label>
	
	<?php if($selectdata->diamond_1_status == 1){ ?>
   diamond_1_size&nbsp;&nbsp;<input type="text" name="diamond_1_size" id="diamond_1_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_size ?>" />
   <?php } ?>
	
	<?php if($selectdata->diamond_2_status == 1){ ?>
	diamond_2_size&nbsp;&nbsp;<input type="text" name="diamond_2_size" id="diamond_2_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_size ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_3_status == 1){ ?>
	diamond_3_size&nbsp;&nbsp;<input type="text" name="diamond_3_size" id="diamond_3_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_size ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_4_status == 1){ ?>
	diamond_4_size&nbsp;&nbsp;<input type="text" name="diamond_4_size" id="diamond_4_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_size ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_5_status == 1){ ?>
	diamond_5_size&nbsp;&nbsp;<input type="text" name="diamond_5_size" id="diamond_5_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_size ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_6_status == 1){ ?>
	diamond_6_size&nbsp;&nbsp;<input type="text" name="diamond_6_size" id="diamond_6_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_size ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_7_status == 1){ ?>
	diamond_7_size&nbsp;&nbsp;<input type="text" name="diamond_7_size" id="diamond_7_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_size ?>" />
	<?php } ?>
</li>


<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond Weight</label>
	
	<?php if($selectdata->diamond_1_status == 1){ ?>
    diamond_1_weight &nbsp;&nbsp;<input type="text" name="diamond_1_weight" id="diamond_1_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_2_status == 1){ ?>
	diamond_2_weight &nbsp;&nbsp;<input type="text" name="diamond_2_weight" id="diamond_2_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_3_status == 1){ ?>
	diamond_3_weight &nbsp;&nbsp;<input type="text" name="diamond_3_weight" id="diamond_3_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_4_status == 1){ ?>
	diamond_4_weight &nbsp;&nbsp;<input type="text" name="diamond_4_weight" id="diamond_4_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_5_status == 1){ ?>
	diamond_5_weight &nbsp;&nbsp;<input type="text" name="diamond_5_weight" id="diamond_5_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_6_status == 1){ ?>
	diamond_6_weight &nbsp;&nbsp;<input type="text" name="diamond_6_weight" id="diamond_6_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->diamond_7_status == 1){ ?>
	diamond_7_weight &nbsp;&nbsp;<input type="text" name="diamond_7_weight" id="diamond_7_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_weight ?>" />
	<?php } ?>
</li>

 

 

<?php } ?>

<li style="clear:both;">
</li>

<?php if($selectdata->gem_1_status == 1 || $selectdata->gem_2_status == 1 || $selectdata->gem_3_status == 1 || $selectdata->gem_4_status == 1 || $selectdata->gem_5_status == 1) { ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone Name</label>
	
	<?php if($selectdata->gem_1_status == 1){ ?>
    <input type="text" name="gemstone_1_name" id="gemstone_1_name" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_name ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_2_status == 1){ ?>
	<input type="text" name="gemstone_2_name" id="gemstone_2_name" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_name ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_3_status == 1){ ?>
	<input type="text" name="gemstone_3_name" id="gemstone_3_name" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_name ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_4_status == 1){ ?>
	<input type="text" name="gemstone_4_name" id="gemstone_4_name" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_name ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_5_status == 1){ ?>
	<input type="text" name="gemstone_5_name" id="gemstone_5_name" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_name ?>" />
	<?php } ?>
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone Count</label>
	
	<?php if($selectdata->gem_1_status == 1){ ?>
    <input type="text" name="gemstone_1_count" id="gemstone_1_count" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_2_status == 1){ ?>
	<input type="text" name="gemstone_2_count" id="gemstone_2_count" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_3_status == 1){ ?>
	<input type="text" name="gemstone_3_count" id="gemstone_3_count" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_4_status == 1){ ?>
	<input type="text" name="gemstone_4_count" id="gemstone_4_count" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_count ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_5_status == 1){ ?>
	<input type="text" name="gemstone_5_count" id="gemstone_5_count" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_count ?>" />
	<?php } ?>
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone Weight</label>
	
	<?php if($selectdata->gem_1_status == 1){ ?>
    <input type="text" name="gemstone_1_weight" id="gemstone_1_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_2_status == 1){ ?>
	<input type="text" name="gemstone_2_weight" id="gemstone_2_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_3_status == 1){ ?>
	<input type="text" name="gemstone_3_weight" id="gemstone_3_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_4_status == 1){ ?>
	<input type="text" name="gemstone_4_weight" id="gemstone_4_weight" class="field-style field-split" style="width:130px;" value="<?php echo $gemstone_4_weight ?>" />
	<?php } ?>
	
	<?php if($selectdata->gem_5_status == 1){ ?>
	<input type="text" name="gemstone_5_weight" id="gemstone_5_weight" class="field-style field-split" style="width:130px;" value="<?php echo $gemstone_5_weight ?>" />
	<?php } ?>
</li>

<?php } ?>


<li style="clear:both;">
	<span style="display:inline;margin-left:12%;">
	<input type="submit" name="submit" value="Submit" class="styled-button-1 ">
	<input type="button" class="styled-button-1" value="Back" onClick="history.back();return true;" style="margin-left:10px;">
	</span>
</li>
</ul>
</form>

</div>
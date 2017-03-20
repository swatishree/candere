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
              ->from('erp_order_details') 
              ->where('erp_order_id', $selectdata->id)
              
              ->get();
$order_data = $query->row();
// echo '<pre>'; print_r($order_data); exit;
	
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
		
		$diamond_1_status 		= $order_data->diamond_1_status;
		$diamond_1_stones 		= $order_data->diamond_1_stones;
		$diamond_1_weight 		= $order_data->diamond_1_weight;
		$diamond_1_clarity 		= $order_data->diamond_1_clarity;
		$diamond_1_color 		= $order_data->diamond_1_color;
		$diamond_1_size 		= $order_data->diamond_1_size;
		$diamond_1_shape 		= $order_data->diamond_1_shape;
		$diamond_1_setting_type = $order_data->diamond_1_setting_type;
		
		$diamond_2_status 		= $order_data->diamond_2_status;
		$diamond_2_stones 		= $order_data->diamond_2_stones;
		$diamond_2_weight 		= $order_data->diamond_2_weight;
		$diamond_2_clarity 		= $order_data->diamond_2_clarity;
		$diamond_2_color 		= $order_data->diamond_2_color;
		$diamond_2_size 		= $order_data->diamond_2_size;
		$diamond_2_shape 		= $order_data->diamond_2_shape;
		$diamond_2_setting_type = $order_data->diamond_2_setting_type;
		
		$diamond_3_status 		= $order_data->diamond_3_status;
		$diamond_3_stones		= $order_data->diamond_3_stones;
		$diamond_3_weight 		= $order_data->diamond_3_weight;
		$diamond_3_clarity 		= $order_data->diamond_3_clarity;
		$diamond_3_color 		= $order_data->diamond_3_color;
		$diamond_3_size 		= $order_data->diamond_3_size;
		$diamond_3_shape 		= $order_data->diamond_3_shape;
		$diamond_3_setting_type = $order_data->diamond_3_setting_type;
		
		$diamond_4_status 		= $order_data->diamond_4_status;
		$diamond_4_stones 		= $order_data->diamond_4_stones;
		$diamond_4_weight 		= $order_data->diamond_4_weight;
		$diamond_4_clarity 		= $order_data->diamond_4_clarity;
		$diamond_4_color 		= $order_data->diamond_4_color;
		$diamond_4_size 		= $order_data->diamond_4_size;
		$diamond_4_shape 		= $order_data->diamond_4_shape;
		$diamond_4_setting_type = $order_data->diamond_4_setting_type;
		
		$diamond_5_status 		= $order_data->diamond_5_status;
		$diamond_5_stones		= $order_data->diamond_5_stones;
		$diamond_5_weight 		= $order_data->diamond_5_weight;
		$diamond_5_clarity 		= $order_data->diamond_5_clarity;
		$diamond_5_color 		= $order_data->diamond_5_color;
		$diamond_5_size 		= $order_data->diamond_5_size;
		$diamond_5_shape 		= $order_data->diamond_5_shape;
		$diamond_5_setting_type = $order_data->diamond_5_setting_type;
		
		$diamond_6_status 		= $order_data->diamond_6_status;
		$diamond_6_stones		= $order_data->diamond_6_stones;
		$diamond_6_weight 		= $order_data->diamond_6_weight;
		$diamond_6_clarity 		= $order_data->diamond_6_clarity;
		$diamond_6_color 		= $order_data->diamond_6_color;
		$diamond_6_size 		= $order_data->diamond_6_size;
		$diamond_6_shape 		= $order_data->diamond_6_shape;
		$diamond_6_setting_type = $order_data->diamond_6_setting_type;
		
		
		$diamond_7_status 		= $order_data->diamond_7_status;
		$diamond_7_stones 		= $order_data->diamond_7_stones;
		$diamond_7_weight 		= $order_data->diamond_7_weight;
		$diamond_7_clarity 		= $order_data->diamond_7_clarity;
		$diamond_7_color 		= $order_data->diamond_7_color;
        $diamond_7_size 		= $order_data->diamond_7_size;
		$diamond_7_shape 		= $order_data->diamond_7_shape;
		$diamond_7_setting_type = $order_data->diamond_7_setting_type;

        $diamond_8_status 		= $order_data->diamond_8_status;
		$diamond_8_stones 		= $order_data->diamond_8_stones;
		$diamond_8_weight 		= $order_data->diamond_8_weight;
		$diamond_8_clarity 		= $order_data->diamond_8_clarity;
		$diamond_8_color 		= $order_data->diamond_8_color;
        $diamond_8_size 		= $order_data->diamond_8_size;
		$diamond_8_shape 		= $order_data->diamond_8_shape;
		$diamond_8_setting_type = $order_data->diamond_8_setting_type;

        $diamond_9_status 		= $order_data->diamond_9_status;
		$diamond_9_stones		= $order_data->diamond_9_stones;
		$diamond_9_weight 		= $order_data->diamond_9_weight;
		$diamond_9_clarity 		= $order_data->diamond_9_clarity;
		$diamond_9_color 		= $order_data->diamond_9_color;
        $diamond_9_size 		= $order_data->diamond_9_size;
		$diamond_9_shape 		= $order_data->diamond_9_shape;
		$diamond_9_setting_type = $order_data->diamond_9_setting_type;

        $diamond_10_status 		= $order_data->diamond_10_status;
		$diamond_10_stones		= $order_data->diamond_10_stones;
		$diamond_10_weight 		= $order_data->diamond_10_weight;
		$diamond_10_clarity 	= $order_data->diamond_10_clarity;
		$diamond_10_color 		= $order_data->diamond_10_color;
        $diamond_10_size 		= $order_data->diamond_10_size;
		$diamond_10_shape 		= $order_data->diamond_10_shape;
		$diamond_10_setting_type = $order_data->diamond_10_setting_type;		
		
		$gem_1_status 		      = $order_data->gem_1_status;
		$gemstone_1_stone 		  = $order_data->gemstone_1_stone;
		$gemstone_1_weight 		  = $order_data->gemstone_1_weight;
		$gemstone_1_type          = $order_data->gemstone_1_type;
		$gemstone_1_shape         = $order_data->gemstone_1_shape;
		$gemstone_1_color         = $order_data->gemstone_1_color;
		$gemstone_1_setting_type  = $order_data->gemstone_1_setting_type;
		
		$gem_2_status 		      = $order_data->gem_2_status;
		$gemstone_2_stone 		  = $order_data->gemstone_2_stone;
		$gemstone_2_weight 		  = $order_data->gemstone_2_weight;
		$gemstone_2_type          = $order_data->gemstone_2_type;
		$gemstone_2_shape         = $order_data->gemstone_2_shape;
		$gemstone_2_color         = $order_data->gemstone_2_color;
		$gemstone_2_setting_type  = $order_data->gemstone_2_setting_type;
		
		$gem_3_status 		      = $order_data->gem_3_status;
		$gemstone_3_stone 		  = $order_data->gemstone_3_stone;
		$gemstone_3_weight 		  = $order_data->gemstone_3_weight;
		$gemstone_3_type          = $order_data->gemstone_3_type;
		$gemstone_3_shape         = $order_data->gemstone_3_shape;
		$gemstone_3_color         = $order_data->gemstone_3_color;
		$gemstone_3_setting_type  = $order_data->gemstone_3_setting_type;
		
		$gem_4_status 		      = $order_data->gem_4_status;
		$gemstone_4_stone 		  = $order_data->gemstone_4_stone;
		$gemstone_4_weight 		  = $order_data->gemstone_4_weight;
		$gemstone_4_type          = $order_data->gemstone_4_type;
		$gemstone_4_shape         = $order_data->gemstone_4_shape;
		$gemstone_4_color         = $order_data->gemstone_4_color;
		$gemstone_4_setting_type  = $order_data->gemstone_4_setting_type;
		
		$gem_5_status 		      = $order_data->gem_5_status;
		$gemstone_5_stone 		  = $order_data->gemstone_5_stone;
		$gemstone_5_weight 		  = $order_data->gemstone_5_weight;
		$gemstone_5_type          = $order_data->gemstone_5_type;
		$gemstone_5_shape         = $order_data->gemstone_5_shape;
		$gemstone_5_color         = $order_data->gemstone_5_color;
		$gemstone_5_setting_type  = $order_data->gemstone_5_setting_type;
		
		$gem_6_status 		      = $order_data->gem_6_status;
		$gemstone_6_stone 		  = $order_data->gemstone_6_stone;
		$gemstone_6_weight 		  = $order_data->gemstone_6_weight;
		$gemstone_6_type          = $order_data->gemstone_6_type;
		$gemstone_6_shape         = $order_data->gemstone_6_shape;
		$gemstone_6_color         = $order_data->gemstone_6_color;
		$gemstone_6_setting_type  = $order_data->gemstone_6_setting_type;
		
		$gem_7_status 		      = $order_data->gem_7_status;
		$gemstone_7_stone 		  = $order_data->gemstone_7_stone;
		$gemstone_7_weight 		  = $order_data->gemstone_7_weight;
		$gemstone_7_type          = $order_data->gemstone_7_type;
		$gemstone_7_shape         = $order_data->gemstone_7_shape;
		$gemstone_7_color         = $order_data->gemstone_7_color;
		$gemstone_7_setting_type  = $order_data->gemstone_7_setting_type;
		
		$gem_8_status 		      = $order_data->gem_8_status;
		$gemstone_8_stone 		  = $order_data->gemstone_8_stone;
		$gemstone_8_weight 		  = $order_data->gemstone_8_weight;
		$gemstone_8_type          = $order_data->gemstone_8_type;
		$gemstone_8_shape         = $order_data->gemstone_8_shape;
		$gemstone_8_color         = $order_data->gemstone_8_color;
		$gemstone_8_setting_type  = $order_data->gemstone_8_setting_type;
		
        $gem_9_status 		      = $order_data->gem_9_status;
		$gemstone_9_stone 		  = $order_data->gemstone_9_stone;
		$gemstone_9_weight 		  = $order_data->gemstone_9_weight;
		$gemstone_9_type          = $order_data->gemstone_9_type;
		$gemstone_9_shape         = $order_data->gemstone_9_shape;
		$gemstone_9_color         = $order_data->gemstone_9_color;
		$gemstone_9_setting_type  = $order_data->gemstone_9_setting_type;
		
		 
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
		
		$diamond_1_status       = '' ;
		$diamond_1_count 		=  '';
		$diamond_1_weight 		= '';
		$diamond_1_clarity 		= '';
		$diamond_1_color 		= '';
		$diamond_1_size 		= '';
		$diamond_1_shape 		= '';
		$diamond_1_setting_type = '';
		
		$diamond_2_status       = '' ;
		$diamond_2_count 		=  '';
		$diamond_2_weight 		= '';
		$diamond_2_clarity 		= '';
		$diamond_2_color 		= '';
		$diamond_2_size 		= '';
		$diamond_2_shape 		= '';
		$diamond_2_setting_type = '';
		
		$diamond_3_status       = '' ;
		$diamond_3_count 		=  '';
		$diamond_3_weight 		= '';
		$diamond_3_clarity 		= '';
		$diamond_3_color 		= '';
		$diamond_3_size 		= '';
		$diamond_3_shape 		= '';
		$diamond_3_setting_type = '';
		
		$diamond_4_status       = '' ;
		$diamond_4_count 		=  '';
		$diamond_4_weight 		= '';
		$diamond_4_clarity 		= '';
		$diamond_4_color 		= '';
		$diamond_4_size 		= '';
		$diamond_4_shape 		= '';
		$diamond_4_setting_type = '';
		
		$diamond_5_status       = '' ;
		$diamond_5_count 		=  '';
		$diamond_5_weight 		= '';
		$diamond_5_clarity 		= '';
		$diamond_5_color 		= '';
		$diamond_5_size 		= '';
		$diamond_5_shape 		= '';
		$diamond_5_setting_type = '';
		
		$diamond_6_status       = '' ;
		$diamond_6_count 		=  '';
		$diamond_6_weight 		= '';
		$diamond_6_clarity 		= '';
		$diamond_6_color 		= '';
		$diamond_6_size 		= '';
		$diamond_6_shape 		= '';
		$diamond_6_setting_type = '';
		
		$diamond_7_status       = '' ;
		$diamond_7_count 		=  '';
		$diamond_7_weight 		= '';
		$diamond_7_clarity 		= '';
		$diamond_7_color 		= '';
		$diamond_7_size 		= '';
		$diamond_7_shape 		= '';
		$diamond_7_setting_type = '';
		
		$diamond_8_status       = '' ;
		$diamond_8_count 		=  '';
		$diamond_8_weight 		= '';
		$diamond_8_clarity 		= '';
		$diamond_8_color 		= '';
		$diamond_8_size 		= '';
		$diamond_8_shape 		= '';
		$diamond_8_setting_type = '';
		
		$diamond_9_status       = '' ;
		$diamond_9_count 		=  '';
		$diamond_9_weight 		= '';
		$diamond_9_clarity 		= '';
		$diamond_9_color 		= '';
		$diamond_9_size 		= '';
		$diamond_9_shape 		= '';
		$diamond_9_setting_type = '';
		
		$diamond_10_status       = '' ;
		$diamond_10_count 		=  '';
		$diamond_10_weight 		= '';
		$diamond_10_clarity 		= '';
		$diamond_10_color 		= '';
		$diamond_10_size 		= '';
		$diamond_10_shape 		= '';
		$diamond_10_setting_type = '';
		
		 
		$gem_1_status             = '' ;
		$gemstone_1_stone 		  = '';
		$gemstone_1_weight 		  = '';
		$gemstone_1_type          = '';
		$gemstone_1_shape         = '';
		$gemstone_1_color         = '';
		$gemstone_1_setting_type  = '';
		
		$gem_2_status             = '' ;
		$gemstone_2_stone 		  = '';
		$gemstone_2_weight 		  = '';
		$gemstone_2_type          = '';
		$gemstone_2_shape         = '';
		$gemstone_2_color         = '';
		$gemstone_2_setting_type  = '';
		
		$gem_3_status             = '' ;
		$gemstone_3_stone 		  = '';
		$gemstone_3_weight 		  = '';
		$gemstone_3_type          = '';
		$gemstone_3_shape         = '';
		$gemstone_3_color         = '';
		$gemstone_3_setting_type  = '';
		
		$gem_4_status             = '' ;
		$gemstone_4_stone 		  = '';
		$gemstone_4_weight 		  = '';
		$gemstone_4_type          = '';
		$gemstone_4_shape         = '';
		$gemstone_4_color         = '';
		$gemstone_4_setting_type  = '';
		
		$gem_5_status             = '' ;
		$gemstone_5_stone 		  = '';
		$gemstone_5_weight 		  = '';
		$gemstone_5_type          = '';
		$gemstone_5_shape         = '';
		$gemstone_5_color         = '';
		$gemstone_5_setting_type  = '';
		
		$gem_6_status             = '' ;
		$gemstone_6_stone 		  = '';
		$gemstone_6_weight 		  = '';
		$gemstone_6_type          = '';
		$gemstone_6_shape         = '';
		$gemstone_6_color         = '';
		$gemstone_6_setting_type  = '';
		
		$gem_7_status             = '' ;
		$gemstone_7_stone 		  = '';
		$gemstone_7_weight 		  = '';
		$gemstone_7_type          = '';
		$gemstone_7_shape         = '';
		$gemstone_7_color         = '';
		$gemstone_7_setting_type  = '';
		
        $gem_8_status             = '' ;
		$gemstone_8_stone 		  = '';
		$gemstone_8_weight 		  = '';
		$gemstone_8_type          = '';
		$gemstone_8_shape         = '';
		$gemstone_8_color         = '';
		$gemstone_8_setting_type  = '';
		
		$gem_9_status             = '' ;
		$gemstone_9_stone 		  = '';
		$gemstone_9_weight 		  = '';
		$gemstone_9_type          = '';
		$gemstone_9_shape         = '';
		$gemstone_9_color         = '';
		$gemstone_9_setting_type  = '';
	}

$form_action 	= base_url('index.php/erp_order/saveproductdetails');
$base_url 		= base_url('index.php/erp_order/to_do_list');

$key['status'] 	= 1;

  ?>

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
	<label style="float: left;margin-left: 2%;width:125px;">Metal Detail</label>

</li>

<li style="clear:both;">
  <label style="float: left;margin-left: 2%;width:125px;">  Metal </label><input type="text" name="metal" id="metal" class="field-style field-split align-left"  value="<?php echo $selectdata->metal ?>" readonly /><br/>

</li>

<li style="clear:both;">

 <label style="float: left;margin-left: 2%;width:125px;"> Metal weight</label><input type="text" name="metal_weight" id="metal_weight" class="field-style field-split align-left"  value="<?php echo $selectdata->metal_weight ?>" readonly /><br/>
	
  
</li>

<li style="clear:both;">
<label style="float: left;margin-left: 2%;width:125px;">  Total weight</label><input type="text" name="total_weight" id="total_weight" class="field-style field-split align-left"  value="<?php echo $selectdata->total_weight ?>" readonly /><br/>
</li>

<li style="clear:both;">
<label style="float: left;margin-left: 2%;width:125px;"> Purity </label><input type="text" name="purity" id="purity" class="field-style field-split align-left"  value="<?php echo $selectdata->purity ?>" readonly /><br/>
   
	
</li>

<li style="clear:both;">
    <label style="float: left;margin-left: 2%;width:125px;">Height</label><input type="text" name="height" id="height" class="field-style field-split align-left"  value="<?php echo $selectdata->height ?>" readonly /><br/>

</li>

<li style="clear:both;">
  <label style="float: left;margin-left: 2%;width:125px;"> Width:</label> <input type="text" name="width" id="width" class="field-style field-split align-left"  value="<?php echo $selectdata->width ?>" readonly /><br/>

</li>


<?php 
	if($selectdata->product_type=='Rings' || $selectdata->product_type=='Bangles' || $selectdata->product_type=='Bands' )
	{ ?>
<li style="clear:both;">
 <label style="float: left;margin-left: 2%;width:125px;">  Top Thickness</label><input type="text" name="top_thickness" id="top_thickness" class="field-style field-split align-left"  value="<?php echo $selectdata->top_thickness ?>" readonly /><br/>
 </li>
	
	<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Top Height</label> <input type="text" name="top_height" id="top_height" class="field-style field-split align-left"  value="<?php echo $selectdata->top_height ?>" readonly /><br/>
	</li>
	
	<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Bottom Thickness</label><input type="text" name="bottom_thickness" id="bottom_thickness" class="field-style field-split align-left"  value="<?php echo $selectdata->bottom_thickness ?>" readonly /><br/>
	</li>
	<?php } ?>




	<?php 
	
	if($selectdata->product_type=='Chains')
	{ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Chain Thickness</label><input type="text" name="chain_thickness" id="chain_thickness" class="field-style field-split align-left"  value="<?php echo $selectdata->chain_thickness ?>" readonly /><br/>
	</li>
	<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Chain Length</label><input type="text" name="chain_length" id="chain_length" class="field-style field-split align-left"  value="<?php echo $selectdata->chain_length ?>" readonly /><br/>
	</li>
	<?php } ?>




<?php 
	if($selectdata->product_type=='Bracelets')
	{ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Bracelet Length</label><input type="text" name="bracelet_length" id="bracelet_length" class="field-style field-split align-left"  value="<?php echo $selectdata->bracelet_length ?>" readonly /><br/>
	</li>
	<?php } ?>



<?php 
	if($selectdata->product_type=='Bangles')
	{ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Bangle Size</label><input type="text" name="bangle_size" id="bangle_size" class="field-style field-split align-left"  value="<?php echo $selectdata->bangle_size ?>" readonly /><br/>
	</li>
	<?php } ?>





<?php 
	if($selectdata->product_type=='Kada')
	{ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Kada Size</label><input type="text" name="kada_size" id="kada_size" class="field-style field-split align-left"  value="<?php echo $selectdata->kada_size ?>" readonly /><br/>
	</li>
	<?php } ?>



<?php 
	if($selectdata->product_type=='Rings' ||  $selectdata->product_type=='Bands')
	{ ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:125px;">Ring Size</label><input type="text" name="ring_size" id="ring_size" class="field-style field-split align-left"  value="<?php echo $selectdata->ring_size ?>" readonly />

	<br/>
	</li>
	<?php } ?>


 

<li style="clear:both;">
</li>

 <?php if($selectdata->diamond_1_status == 1 || $selectdata->diamond_2_status == 1 || $selectdata->diamond_3_status || $selectdata->diamond_4_status == 1 || $selectdata->diamond_5_status == 1 ) { ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 1 detail</label>
	<br/>
	 
	
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diamond color&nbsp;&nbsp;<input type="text" name="diamond_1_color" id="diamond_1_color" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_color ?>" readonly  />  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   Diamond clarity&nbsp;&nbsp;<input type="text" name="diamond_1_clarity" id="diamond_1_clarity" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_clarity ?>" readonly  />
   <br/>
   <br/>
	
	
	diamond_1_status &nbsp;&nbsp;<select name="diamond_1_status">
	<option value="1" <?php if($diamond_1_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_1_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select>
	
  <br/>
  diamond_1_count&nbsp;&nbsp;<input type="text" name="diamond_1_stones" id="diamond_1_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_stones ?>" />  <br/>
   
   diamond_1_size&nbsp;&nbsp;<input type="text" name="diamond_1_size" id="diamond_1_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_size ?>" /><br/>
 	
	diamond_1_weight &nbsp;&nbsp;<input type="text" name="diamond_1_weight" id="diamond_1_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_weight ?>" /><br/>
	
	diamond_1_shape &nbsp;&nbsp;<input type="text" name="diamond_1_shape" id="diamond_1_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_shape ?>" /><br/>
	
	diamond_1_setting_type &nbsp;&nbsp;<input type="text" name="diamond_1_setting_type" id="diamond_1_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_1_setting_type ?>" /><br/>
	
	
	 
</li>


<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 2 detail</label>
	
  <br/>
  diamond_2_status &nbsp;&nbsp;<select name="diamond_2_status">
	<option value="1" <?php if($diamond_2_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_2_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select>
	<br/>
  diamond_2_count&nbsp;&nbsp;<input type="text" name="diamond_2_stones" id="diamond_2_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_stones ?>" />  <br/>
   
   diamond_2_size&nbsp;&nbsp;<input type="text" name="diamond_2_size" id="diamond_2_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_size ?>" /><br/>
 	
	diamond_2_weight &nbsp;&nbsp;<input type="text" name="diamond_2_weight" id="diamond_2_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_weight ?>" /><br/>
	
	diamond_2_shape &nbsp;&nbsp;<input type="text" name="diamond_2_shape" id="diamond_2_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_shape ?>" /><br/>
	
	diamond_2_setting_type &nbsp;&nbsp;<input type="text" name="diamond_2_setting_type" id="diamond_2_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_2_setting_type ?>" /><br/>
	
	
	 
</li>



<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 3 detail</label>
	
  <br/>
  diamond_3_status &nbsp;&nbsp;<select name="diamond_3_status">
	<option value="1" <?php if($diamond_3_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_3_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select> <br/>
  diamond_3_count&nbsp;&nbsp;<input type="text" name="diamond_3_stones" id="diamond_3_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_stones ?>" />  <br/>
   
   diamond_3_size&nbsp;&nbsp;<input type="text" name="diamond_3_size" id="diamond_3_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_size ?>" /><br/>
 	
	diamond_3_weight &nbsp;&nbsp;<input type="text" name="diamond_3_weight" id="diamond_3_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_weight ?>" /><br/>
	
	diamond_3_shape &nbsp;&nbsp;<input type="text" name="diamond_3_shape" id="diamond_3_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_shape ?>" /><br/>
	
	diamond_3_setting_type &nbsp;&nbsp;<input type="text" name="diamond_3_setting_type" id="diamond_3_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_3_setting_type ?>" /><br/>
	
	
	 
</li>


<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 4 detail</label>
	
  <br/>
  diamond_4_status &nbsp;&nbsp;<select name="diamond_4_status">
	<option value="1" <?php if($diamond_4_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_4_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_4_count&nbsp;&nbsp;<input type="text" name="diamond_4_stones" id="diamond_4_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_stones ?>" />  <br/>
   
   diamond_4_size&nbsp;&nbsp;<input type="text" name="diamond_4_size" id="diamond_4_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_size ?>" /><br/>
 	
	diamond_4_weight &nbsp;&nbsp;<input type="text" name="diamond_4_weight" id="diamond_4_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_weight ?>" /><br/>
	
	diamond_4_shape &nbsp;&nbsp;<input type="text" name="diamond_4_shape" id="diamond_4_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_shape ?>" /><br/>
	
	diamond_4_setting_type &nbsp;&nbsp;<input type="text" name="diamond_4_setting_type" id="diamond_4_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_4_setting_type ?>" /><br/>
	
	
	 
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 5 detail</label>
	
  <br/>
  diamond_5_status &nbsp;&nbsp;<select name="diamond_5_status">
	<option value="1" <?php if($diamond_5_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_5_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_5_count&nbsp;&nbsp;<input type="text" name="diamond_5_stones" id="diamond_5_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_stones ?>" />  <br/>
   
   diamond_5_size&nbsp;&nbsp;<input type="text" name="diamond_5_size" id="diamond_5_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_size ?>" /><br/>
 	
	diamond_5_weight &nbsp;&nbsp;<input type="text" name="diamond_5_weight" id="diamond_5_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_weight ?>" /><br/>
	
	diamond_5_shape &nbsp;&nbsp;<input type="text" name="diamond_5_shape" id="diamond_5_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_shape ?>" /><br/>
	
	diamond_5_setting_type &nbsp;&nbsp;<input type="text" name="diamond_5_setting_type" id="diamond_5_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_5_setting_type ?>" /><br/>
	
	
	 
</li>


<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 6 detail</label>
	
  <br/>
  diamond_6_status &nbsp;&nbsp;<select name="diamond_6_status">
	<option value="1" <?php if($diamond_6_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_6_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_6_count&nbsp;&nbsp;<input type="text" name="diamond_6_stones" id="diamond_6_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_stones ?>" />  <br/>
   
   diamond_6_size&nbsp;&nbsp;<input type="text" name="diamond_6_size" id="diamond_6_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_size ?>" /><br/>
 	
	diamond_6_weight &nbsp;&nbsp;<input type="text" name="diamond_6_weight" id="diamond_6_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_weight ?>" /><br/>
	
	diamond_6_shape &nbsp;&nbsp;<input type="text" name="diamond_6_shape" id="diamond_6_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_shape ?>" /><br/>
	
	diamond_6_setting_type &nbsp;&nbsp;<input type="text" name="diamond_6_setting_type" id="diamond_6_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_6_setting_type ?>" /><br/>
	
	
	 
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 7 detail</label>
	
  <br/>
  diamond_7_status &nbsp;&nbsp;<select name="diamond_7_status">
	<option value="1" <?php if($diamond_7_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_7_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_7_count&nbsp;&nbsp;<input type="text" name="diamond_7_stones" id="diamond_7_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_stones ?>" />  <br/>
   
   diamond_7_size&nbsp;&nbsp;<input type="text" name="diamond_7_size" id="diamond_7_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_size ?>" /><br/>
 	
	diamond_7_weight &nbsp;&nbsp;<input type="text" name="diamond_7_weight" id="diamond_7_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_weight ?>" /><br/>
	
	diamond_7_shape &nbsp;&nbsp;<input type="text" name="diamond_7_shape" id="diamond_7_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_shape ?>" /><br/>
	
	diamond_7_setting_type &nbsp;&nbsp;<input type="text" name="diamond_7_setting_type" id="diamond_7_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_7_setting_type ?>" /><br/>
	
	
	 
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 8 detail</label>
	
  <br/>
  diamond_8_status &nbsp;&nbsp;<select name="diamond_8_status">
	<option value="1" <?php if($diamond_8_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_8_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_8_count&nbsp;&nbsp;<input type="text" name="diamond_8_stones" id="diamond_8_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_8_stones ?>" />  <br/>
   
   diamond_8_size&nbsp;&nbsp;<input type="text" name="diamond_8_size" id="diamond_8_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_8_size ?>" /><br/>
 	
	diamond_8_weight &nbsp;&nbsp;<input type="text" name="diamond_8_weight" id="diamond_8_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_8_weight ?>" /><br/>
	
	diamond_8_shape &nbsp;&nbsp;<input type="text" name="diamond_8_shape" id="diamond_8_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_8_shape ?>" /><br/>
	
	diamond_8_setting_type &nbsp;&nbsp;<input type="text" name="diamond_8_setting_type" id="diamond_8_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_8_setting_type ?>" /><br/>
	
	
	 
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 9 detail</label>
	
  <br/>
  diamond_9_status &nbsp;&nbsp;<select name="diamond_9_status">
	<option value="1" <?php if($diamond_9_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_9_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_9_count&nbsp;&nbsp;<input type="text" name="diamond_9_stones" id="diamond_9_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_9_stones ?>" />  <br/>
   
   diamond_9_size&nbsp;&nbsp;<input type="text" name="diamond_9_size" id="diamond_9_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_9_size ?>" /><br/>
 	
	diamond_9_weight &nbsp;&nbsp;<input type="text" name="diamond_9_weight" id="diamond_9_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_9_weight ?>" /><br/>
	
	diamond_9_shape &nbsp;&nbsp;<input type="text" name="diamond_9_shape" id="diamond_9_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_9_shape ?>" /><br/>
	
	diamond_9_setting_type &nbsp;&nbsp;<input type="text" name="diamond_9_setting_type" id="diamond_9_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_9_setting_type ?>" /><br/>
	
	
	 
</li>

<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Diamond 10 detail</label>
	
  <br/>
  diamond_10_status &nbsp;&nbsp;<select name="diamond_10_status">
	<option value="1" <?php if($diamond_10_status=='1')echo 'selected="selected"' ; ?>>Yes</option>
	<option value="0" <?php if($diamond_10_status=='0')echo 'selected="selected"' ; ?>>No</option>
	</select><br/>
  diamond_10_count&nbsp;&nbsp;<input type="text" name="diamond_10_stones" id="diamond_10_stones" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_10_stones ?>" />  <br/>
   
   diamond_10_size&nbsp;&nbsp;<input type="text" name="diamond_10_size" id="diamond_10_size" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_10_size ?>" /><br/>
 	
	diamond_10_weight &nbsp;&nbsp;<input type="text" name="diamond_10_weight" id="diamond_10_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_10_weight ?>" /><br/>
	
	diamond_10_shape &nbsp;&nbsp;<input type="text" name="diamond_10_shape" id="diamond_10_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_10_shape ?>" /><br/>
	
	diamond_10_setting_type &nbsp;&nbsp;<input type="text" name="diamond_10_setting_type" id="diamond_10_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $diamond_10_setting_type ?>" /><br/>
	
	
	 
</li>




 


 

 

 <?php } ?>
 

<li style="clear:both;">
</li>

<?php if($selectdata->gem_1_status == 1 || $selectdata->gem_2_status == 1 || $selectdata->gem_3_status == 1 || $selectdata->gem_4_status == 1 || $selectdata->gem_5_status == 1 || $selectdata->gem_6_status == 1 || $selectdata->gem_7_status == 1 || $selectdata->gem_8_status == 1 || $selectdata->gem_9_status == 1) { ?>
<li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_1_Detail</label>
	
   <br/> 
   gemstone_1_status <select name="gem_1_status">
   <option value="1" <?php if($gem_1_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_1_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   
   gemstone_1_name <input type="text" name="gemstone_1_type" id="gemstone_1_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_type ?>" /><br/>
 	
	  gemstone_1_count <input type="text" name="gemstone_1_stone" id="gemstone_1_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_stone ?>" /><br/>
	  
	  gemstone_1_weight <input type="text" name="gemstone_1_weight" id="gemstone_1_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_weight ?>" /><br/>
	  
	  gemstone_1_shape <input type="text" name="gemstone_1_shape" id="gemstone_1_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_shape ?>" /><br/>
	  gemstone_1_color <input type="text" name="gemstone_1_color" id="gemstone_1_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_color ?>" /><br/>
	gemstone_1_setting_type <input type="text" name="gemstone_1_setting_type" id="gemstone_1_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_1_setting_type ?>" /><br/>
	  
 
 </li>
 
 <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_2_Detail</label>
	
   <br/> 
   gemstone_2_status <select name="gem_2_status">
   <option value="1" <?php if($gem_2_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_2_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_2_name <input type="text" name="gemstone_2_type" id="gemstone_2_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_type ?>" /><br/>
 	
	  gemstone_2_count <input type="text" name="gemstone_2_stone" id="gemstone_2_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_stone ?>" /><br/>
	  
	  gemstone_2_weight <input type="text" name="gemstone_2_weight" id="gemstone_2_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_weight ?>" /><br/>
	  
	  gemstone_2_shape <input type="text" name="gemstone_2_shape" id="gemstone_2_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_shape ?>" /><br/>
	  gemstone_2_color <input type="text" name="gemstone_2_color" id="gemstone_2_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_color ?>" /><br/>
	gemstone_2_setting_type <input type="text" name="gemstone_2_setting_type" id="gemstone_2_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_2_setting_type ?>" /><br/>
	  
 
 </li>
 
 <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_3_Detail</label>
	
   <br/>
gemstone_3_status <select name="gem_3_status">
   <option value="1" <?php if($gem_3_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_3_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_3_name <input type="text" name="gemstone_3_type" id="gemstone_3_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_type ?>" /><br/>
 	
	  gemstone_3_count <input type="text" name="gemstone_3_stone" id="gemstone_3_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_stone ?>" /><br/>
	  
	  gemstone_3_weight <input type="text" name="gemstone_3_weight" id="gemstone_3_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_weight ?>" /><br/>
	  
	  gemstone_3_shape <input type="text" name="gemstone_3_shape" id="gemstone_3_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_shape ?>" /><br/>
	  gemstone_3_color <input type="text" name="gemstone_3_color" id="gemstone_3_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_color ?>" /><br/>
	gemstone_3_setting_type <input type="text" name="gemstone_3_setting_type" id="gemstone_3_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_3_setting_type ?>" /><br/>
	  
 
 </li>
 
  <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_4_Detail</label>
	
   <br/> 
   gemstone_4_status <select name="gem_4_status">
   <option value="1" <?php if($gem_4_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_4_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_4_name <input type="text" name="gemstone_4_type" id="gemstone_4_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_type ?>" /><br/>
 	
	  gemstone_4_count <input type="text" name="gemstone_4_stone" id="gemstone_4_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_stone ?>" /><br/>
	  
	  gemstone_4_weight <input type="text" name="gemstone_4_weight" id="gemstone_4_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_weight ?>" /><br/>
	  
	  gemstone_4_shape <input type="text" name="gemstone_4_shape" id="gemstone_4_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_shape ?>" /><br/>
	  gemstone_4_color <input type="text" name="gemstone_4_color" id="gemstone_4_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_color ?>" /><br/>
	gemstone_4_setting_type <input type="text" name="gemstone_4_setting_type" id="gemstone_4_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_4_setting_type ?>" /><br/>
	  
 
 </li>
 
   <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_5_Detail</label>
	
   <br/> 
    gemstone_5_status <select name="gem_5_status">
   <option value="1" <?php if($gem_5_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_5_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_5_name <input type="text" name="gemstone_5_type" id="gemstone_5_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_type ?>" /><br/>
 	
	  gemstone_5_count <input type="text" name="gemstone_5_stone" id="gemstone_5_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_stone ?>" /><br/>
	  
	  gemstone_5_weight <input type="text" name="gemstone_5_weight" id="gemstone_5_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_weight ?>" /><br/>
	  
	  gemstone_5_shape <input type="text" name="gemstone_5_shape" id="gemstone_5_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_shape ?>" /><br/>
	  gemstone_5_color <input type="text" name="gemstone_5_color" id="gemstone_5_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_color ?>" /><br/>
	gemstone_5_setting_type <input type="text" name="gemstone_5_setting_type" id="gemstone_5_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_5_setting_type ?>" /><br/>
	  
 
 </li>
 
    <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_6_Detail</label>
	
   <br/>
  gemstone_6_status <select name="gem_6_status">
   <option value="1" <?php if($gem_6_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_6_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_6_name <input type="text" name="gemstone_6_type" id="gemstone_6_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_type ?>" /><br/>
 	
	  gemstone_6_count <input type="text" name="gemstone_6_stone" id="gemstone_6_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_stone ?>" /><br/>
	  
	  gemstone_6_weight <input type="text" name="gemstone_6_weight" id="gemstone_6_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_weight ?>" /><br/>
	  
	  gemstone_6_shape <input type="text" name="gemstone_6_shape" id="gemstone_6_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_shape ?>" /><br/>
	  gemstone_6_color <input type="text" name="gemstone_6_color" id="gemstone_6_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_color ?>" /><br/>
	gemstone_6_setting_type <input type="text" name="gemstone_6_setting_type" id="gemstone_6_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_6_setting_type ?>" /><br/>
	  
 
 </li>
 
  <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_7_Detail</label>
	
   <br/>
gemstone_7_status <select name="gem_7_status">
   <option value="1" <?php if($gem_7_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_7_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_7_name <input type="text" name="gemstone_7_type" id="gemstone_7_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_type ?>" /><br/>
 	
	  gemstone_7_count <input type="text" name="gemstone_7_stone" id="gemstone_7_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_stone ?>" /><br/>
	  
	  gemstone_7_weight <input type="text" name="gemstone_7_weight" id="gemstone_7_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_weight ?>" /><br/>
	  
	  gemstone_7_shape <input type="text" name="gemstone_7_shape" id="gemstone_7_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_shape ?>" /><br/>
	  gemstone_7_color <input type="text" name="gemstone_7_color" id="gemstone_7_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_color ?>" /><br/>
	gemstone_7_setting_type <input type="text" name="gemstone_7_setting_type" id="gemstone_7_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_7_setting_type ?>" /><br/>
	  
 
 </li>
 
  <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_8_Detail</label>
	
   <br/>
 gemstone_8_status <select name="gem_8_status">
   <option value="1" <?php if($gem_8_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_8_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_8_name <input type="text" name="gemstone_8_type" id="gemstone_8_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_type ?>" /><br/>
 	
	  gemstone_8_count <input type="text" name="gemstone_8_stone" id="gemstone_8_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_stone ?>" /><br/>
	  
	  gemstone_8_weight <input type="text" name="gemstone_8_weight" id="gemstone_8_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_weight ?>" /><br/>
	  
	  gemstone_8_shape <input type="text" name="gemstone_8_shape" id="gemstone_8_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_shape ?>" /><br/>
	  gemstone_8_color <input type="text" name="gemstone_8_color" id="gemstone_8_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_color ?>" /><br/>
	gemstone_8_setting_type <input type="text" name="gemstone_8_setting_type" id="gemstone_8_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_8_setting_type ?>" /><br/>
	  
 
 </li>
 
 
   <li style="clear:both;">
	<label style="float: left;margin-left: 2%;width:197px;">Gemstone_9_Detail</label>
	
   <br/> 
    gemstone_9_status <select name="gem_9_status">
   <option value="1" <?php if($gem_9_status=='1') echo 'selected="selected"' ; ?> >yes</option>
   <option value="0" <?php if($gem_9_status=='0') echo 'selected="selected"' ; ?>  >no</option>
   </select>
   <br/>
   gemstone_9_name <input type="text" name="gemstone_9_type" id="gemstone_9_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_type ?>" /><br/>
 	
	  gemstone_9_count <input type="text" name="gemstone_9_stone" id="gemstone_9_stone" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_stone ?>" /><br/>
	  
	  gemstone_9_weight <input type="text" name="gemstone_9_weight" id="gemstone_9_weight" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_weight ?>" /><br/>
	  
	  gemstone_9_shape <input type="text" name="gemstone_9_shape" id="gemstone_9_shape" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_shape ?>" /><br/>
	  gemstone_9_color <input type="text" name="gemstone_9_color" id="gemstone_9_color" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_color ?>" /><br/>
	gemstone_9_setting_type <input type="text" name="gemstone_9_setting_type" id="gemstone_9_setting_type" class="field-style field-split" style="width:130px;"  value="<?php echo $gemstone_9_setting_type ?>" /><br/>
	  
 
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
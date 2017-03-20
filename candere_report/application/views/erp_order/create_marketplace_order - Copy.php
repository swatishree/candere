<script>
$(function() {
	$( "#order_placed_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo base_url(); ?>themes/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date"
	});
});

function get_prod_name(skudata)
{
	var res = skudata.split('_');
	sku = res[0];
	
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('index.php/erp_order/get_product_name')?>",
		data: "sku="+sku,
		success: function(data) {
			if(data!='error'){
				$('#product_name').val(data);
				$('#not_found').text('');
			} else {
				$('#not_found').text('Product Not Found');
				$('#product_name').val('');
			}
		}   
	}); 	
}
</script>

<style>
.ui-datepicker-trigger{ margin-left:5px; margin-top:10px; float:left;}
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
    <li><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
</ul>
</div>
<div id="quotescenter" style="padding-top:5px;"></div>
<div id="quotesright" style="padding-top:5px;"></div>
</div>


<div style="padding-top:60px;">


<h1 style="float:left; width:200px; color: #305A72;  margin-left:6%; font-size:13px; clear:both; ">Create Market-place Order</h1>

<?php if(isset($message)) {
		echo '<span style="color:red; float:left; margin-left: 11%; margin-top: 1%; "><b>'.$message.'</b></span>';
} ?>

<form class="form-style-9" name="flip_order_form" id="flip_order_form" method="post" action="<?php echo base_url('index.php/erp_order/create_marketplace_order')?>">

<?php
$countryList = Mage::getModel('directory/country')->getResourceCollection()
					->loadByStore()
					->toOptionArray(true);	?>
<ul>
<li style="clear:both;">
<?php $marketplace_options = array(
			  ''  	=> 'Select Marketplace',
			  'Flipkart'  	=> 'Flipkart',
			  'Snapdeal'  	=> 'Snapdeal'
			);
echo form_dropdown('marketplace', $marketplace_options, set_value('marketplace'), 'id="marketplace" class="field-style field-split align-left" style="margin-left:6%;" '); ?>
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('marketplace'); ?></span>
</div>

<li style="clear:both;">
    <input type="text" name="order_id" class="field-style field-split align-left" placeholder="Order ID" value="<?php echo set_value('order_id'); ?>" />
    <input type="text" name="order_product_id" class="field-style field-split align-right" placeholder="Order item ID" value="<?php echo set_value('order_product_id'); ?>"/>
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('order_id'); ?></span>
	<span class="err_right"><?php echo form_error('order_product_id'); ?></span>
</div>
<li style="clear:both;">
    <input type="text" name="flipkart_sku" id="flipkart_sku" class="field-style field-split align-left" placeholder="SKU" value="<?php echo set_value('flipkart_sku'); ?>" onchange="get_prod_name(this.value);"/>
	<span style="color:red; float:left; margin-left: 8%; margin-top: 1%;" id="not_found"></span>
	<input type="text" name="product_name" id="product_name" class="field-style field-split align-right" placeholder="Product name" value="<?php echo set_value('product_name'); ?>" readonly />
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('flipkart_sku'); ?></span>
	<span class="err_right"><?php echo form_error('product_name'); ?></span>
</div>
<li style="clear:both;">
<?php $metal_options = array(
				  ''  	=> 'Select Metal',
				  'Yellow Gold'  	=> 'Yellow Gold',
				  'White Gold'  	=> 'White Gold'
				);
echo form_dropdown('metal', $metal_options, set_value('metal'), 'id="metal" class="field-style field-split align-left" style="margin-left:6%;" '); ?>
<input type="text" name="size" class="field-style field-split align-right" placeholder="Size in mm" value="<?php echo set_value('size'); ?>" />
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('metal'); ?></span>
	<span class="err_right"><?php echo form_error('size'); ?></span>
</div>
<li style="clear:both;">
	<input type="text" name="metal_weight_approx" class="field-style field-split align-left" placeholder="Metal Weight Approx" value="<?php echo set_value('metal_weight_approx'); ?>" />
	<input type="text" name="total_weight_approx" class="field-style field-split align-right" placeholder="Total Weight Approx" value="<?php echo set_value('total_weight_approx'); ?>" />
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('metal_weight_approx'); ?></span>
	<span class="err_right"><?php echo form_error('total_weight_approx'); ?></span>
</div>
<li style="clear:both;">
	<input type="text" name="quantity" class="field-style field-split align-left" placeholder="Quantity" value="<?php echo set_value('quantity'); ?>" />
	<input type="text" name="price" class="field-style field-split align-right" placeholder="Price" value="<?php echo set_value('price'); ?>" />
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('quantity'); ?></span>
	<span class="err_right"><?php echo form_error('price'); ?></span>
</div>
<li style="clear:both;">
	<input type="text" name="buyer_address" class="field-style field-split align-left" placeholder="Buyer's Address" value="<?php echo set_value('buyer_address'); ?>" />
	<?php $country_option = '';
		foreach($countryList as $row) {
			$country_option[$row['label']] = $row['label'];
		}
	echo $country_dropdown = form_dropdown('shipping_country', $country_option, set_value('shipping_country'), 'id="shipping_country" class="field-style field-split align-right" style="float:right; margin-right:6%;" ');	?>
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('buyer_address'); ?></span>
	<span class="err_right"><?php echo form_error('shipping_country'); ?></span>
</div>

<li style="clear:both;">
	<input type="text" name="order_placed_date" id="order_placed_date" class="field-style field-split align-left" placeholder="Order Date" value="<?php echo set_value('order_placed_date'); ?>" />
<?php $payment_method_options = array(
				  ''  	=> 'Select Marketplace Payment',
				  'COD'  	=> 'COD',
				  'Prepaid' => 'Prepaid',
				);
echo form_dropdown('payment_method', $payment_method_options, set_value('payment_method'), 'id="payment_method" class="field-style field-split align-right" style="float:right; margin-right:6%;" '); ?>
</li>
<div style="clear:both;">
	<span class="err_left"><?php echo form_error('order_placed_date'); ?></span>
</div>
<li style="clear:both;">
	<textarea name="notes" class="field-style" placeholder="Notes" id="notes"></textarea>
</li>
<li>
	<input type="submit" value="Create Order" />
	<input type="button" value="Back" onClick="history.back();return true;" style="margin-left:10px;">
</li>
</ul>
</form>

</div>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Export</title>
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
</head>
<style>

.popHeading{
	margin-bottom:20px;
	font-size:24px;
	font-weight:normal;
	line-height:31px;
	text-transform:uppercase;
	letter-spacing:2px;
	color:#343339;
	margin-bottom:28px;
	padding-left:200px;
}
.popHeading span{
	color:#df6061;
}
.popInputText{
	font-size:13px;
	font-weight:normal;
	padding-top:8px;
	padding-bottom:16px;
}
.popTandC{
	font-size:13px;
	font-weight:normal;
	display:inline-block;
	margin-top:25px;
	margin-bottom:15px;	
}
.popSubC{
	font-size:13px;
	font-weight:normal;
	display:inline-block;
	line-height:19px;
}
.popSignup{
	font-size:20px;
	font-weight:normal;
	width:100%;
	height:36px;
	background-color:#fe8081;
	border:none;
	color:#fff;
	text-transform:uppercase;
	cursor:pointer;
}
.popSignup:focus{
	border:none;
	outline: none;
}
.popFooter{
	font-size:14px;
	line-height:18px;
	font-weight:normal;
	text-align:left;
	padding-left:5px;
}
.popHomeEmail{
	width:100%;
	display:block;
	padding:7px 10px;
	box-sizing:border-box;
	-moz-box-sizing:border-box;
}
.popCheckBox{
	vertical-align:middle;
}

</style>
<script>
function chk_product(obj)
{
	if(obj == 'packed_ready')
		jQuery('#div_hide_show').hide();
	else
		jQuery('#div_hide_show').show();
}
</script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      range_from = $( "#range_from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          range_to.datepicker( "option", "minDate", getDate( this ) );
        }),
      range_to = $( "#range_to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        range_from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
<body>
<!--homepage popup-->
<?php
	
	$todays_date				=	date('Y-m-d');
	$date						=	date_create($todays_date);
	date_sub($date,date_interval_create_from_date_string("10 days"));
	
	if($_REQUEST['range_from'] != '' && $_REQUEST['range_from'] != ''):
		$range_from		=	$_REQUEST['range_from'];
		$range_to		=	$_REQUEST['range_to'];
	else:
		$range_from		=	date_format($date,"m/d/Y");
		$range_to		=	date('m/d/Y');
	endif;
?>
<div >
	<div class="holder">
		
		<br><br>
			<div class="popHeading">Candere <span>Report</span></div>	
			<br><br><br>			
			<table cellpadding="0" cellspacing="0" border="0" width="80%" align="center">
				<form name="frm" id="frm" method="post" action="<?php echo $this->config->base_url(); ?>index.php/export_default_price/index" >
					<tr>
						<td style="width:315px;"><b style="font-size:18px">SKU: </b>&nbsp;
							<input type="text" name="sku" id="sku" value="<?php echo $_REQUEST['sku']; ?>" style="width:250px;height:30px;" >
						</td>
						<td><input type="submit" name="sbmt_sku" id="sbmt_sku" value="Submit"  class="popSignup" style="width:100px;height:30px;"></td>
					</tr>					
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr>
						<td style="width:315px;"><b style="font-size:18px">Type: </b>&nbsp;
							<select name="product_type" id="product_type"  style="width:245px;height:30px;">
							<option value="">--Select Product Type--</option>
								<option value="Gold and Diamonds" <?php if($_REQUEST['product_type'] == 'Gold and Diamonds') { echo 'selected="selected"'; } ?>>Gold and Diamonds</option>
								<option value="Gold, Diamond and Gemstones" <?php if($_REQUEST['product_type'] == 'Gold, Diamond and Gemstones') { echo 'selected="selected"'; } ?>>Gold, Diamond and Gemstones</option>
								<option value="Gold and Gemstones" <?php if($_REQUEST['product_type'] == 'Gold and Gemstones') { echo 'selected="selected"'; } ?>>Gold and Gemstones</option>
								<option value="Only Gold" <?php if($_REQUEST['product_type'] == 'Only Gold') { echo 'selected="selected"'; } ?>>Only Gold</option>
								<option value="Platinum and Diamond" <?php if($_REQUEST['product_type'] == 'Platinum and Diamond') { echo 'selected="selected"'; } ?>>Platinum and Diamond</option>
								<option value="Only Platinum" <?php if($_REQUEST['product_type'] == 'Only Platinum') { echo 'selected="selected"'; } ?>>Only Platinum</option>
							</select>
						</td>
						<td><input type="submit" name="sbmt_sku" id="sbmt_sku" value="Submit"  class="popSignup" style="width:100px;height:30px;"></td>
					</tr>
				</form>
			</table>
			
			<br><br><br>			
			<table cellpadding="0" cellspacing="0" border="0" width="50%" align="center">
				<form name="frm" id="frm" method="post" action="<?php echo $this->config->base_url(); ?>index.php/export_default_price/index" >
					<tr>
						<td style="width:160px;padding-left:300px;font-size:16px"><b>Date Range</b></td>
						<td style="width:375px;">
							<input type="text" name="range_from" id="range_from" value="<?php echo $range_from; ?>" style="width:150px;height:30px;" > to <input type="text" name="range_to" id="range_to" value="<?php echo $range_to; ?>" style="width:150px;height:30px;">
						</td><td><input type="submit" name="sbmt" id="sbmt" value="Submit"  class="popSignup" style="width:150px;"></td>
					</tr>					
					<tr><td colspan="3">&nbsp;</td></tr>
				</form>
			</table>
			
			
			<table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">				
				<tr>
					<td><b>#</b></td>
					<td><b>Name</b></td>
					<td><b>SKU</b></td>
					<td><b>Old Price</b></td>
					<td><b>New Price</b></td>
					<td><b>Actual Cost Price</b></td>
					<td><b>Margin</b></td>
					<td><b>Created Date</b></td>
					<td><b>Product Type</b></td>
				</tr>
				<?php
					$i	=	1;
					foreach($selectdata as $row)
					{
						$name 			= $row->name;
						$sku	 		= $row->sku;
						$old_price		= $row->price;
						$product_id		= $row->entity_id;
						$material_value	= $row->material_value;
						
						$product 		= Mage::getModel('catalog/product')->load($product_id);
						
						$attribute_code = 'new_price';
						$storeId 		= 0;
						$new_price		= Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, 'new_price', $storeId);
						
						$attribute_code = 'cost_price';
						$storeId 		= 0;
						$cost_price 	= Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, 'cost_price', $storeId);
						
						$attribute_code = 'margin';
						$storeId 		= 0;
						$margin		 	= Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, 'margin', $storeId);
						
						$created_at		= $row->created_at;
						if($cost_price > 0):
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $sku; ?></td>
					<td><?php echo round($old_price,2); ?></td>
					<td><?php echo round($new_price,2); ?></td>
					<td><?php echo round($cost_price,2); ?></td>
					<td><?php echo round($margin,2); ?></td>
					<td><?php if($created_at != '') { echo date('d/m/Y',strtotime($created_at)); } ?></td>
					<td><?php echo $material_value; ?></td>
				</tr>
				<?php
						$i++;
						endif;
				} ?>
			</table>
	</div>
</div>
</body>
</html>
 
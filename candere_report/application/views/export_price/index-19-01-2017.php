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
/*$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
    Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
);

$fieldset->addField('start_date', 'date', array(
    'name'      => 'start_date',
    'label'     => Mage::helper('candere_report')->__('Start Date'),
    'image'     => $this->getSkinUrl('images/grid-cal.gif'),
    'format'    => $dateFormatIso,
    'disabled'  => $isElementDisabled,
    'class'     => 'validate-date validate-date-range date-range-custom_theme-from'
));*/
?>
<div >
	<div class="holder">
		
		<br><br>
			<div class="popHeading">Candere <span>Report</span></div>	
			<table cellpadding="0" cellspacing="0" border="0" width="50%" id="div_hide_show" style="display:show;">
				<form name="frm" id="frm" method="post" action="<?php echo $this->config->base_url(); ?>/index.php/export_price/export_product_price" >
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2" align="center"><input type="submit" name="sbmt" id="sbmt" value="Export Price" style="width:320px;" class="popSignup"></td></tr>
				</form>
			</table>
			<br><br><br>			
			<table cellpadding="0" cellspacing="0" border="0" width="50%" align="center">
				<form name="frm" id="frm" method="post" action="<?php echo $this->config->base_url(); ?>/index.php/export_price/index" >
					<tr>
						<td style="width:200px;padding-left:100px;font-size:16px">Date Range</td>
						<td style="width:375px;">
							<input type="text" name="range_from" id="range_from" value="<?php echo $_REQUEST['range_from']; ?>" style="width:150px;height:30px;" > to <input type="text" name="range_to" id="range_to" value="<?php echo $_REQUEST['range_to']; ?>" style="width:150px;height:30px;">
						</td><td><input type="submit" name="sbmt" id="sbmt" value="Submit"  class="popSignup" style="width:150px;"></td>
					</tr>					
					<tr><td colspan="3">&nbsp;</td></tr>
				</form>
			</table>
			
			
			<table cellpadding="0" cellspacing="0" border="1" width="80%" align="center">				
				<tr>
					<td><b>Order Id</b></td>
					<td><b>Customer Name</b></td>
					<td><b>Email</b></td>
					<td><b>Product Name</b></td>
					<td><b>SKU</b></td>
					<td><b>Selling Price</b></td>
					<td><b>Actual Cost Price</b></td>
					<td><b>Margin</b></td>
					<td><b>Order Placed Date</b></td>
				</tr>
				<?php
					foreach($selectdata as $row)
					{
						$erp_id 			= $row->id;
						$order_id 			= $row->order_id;
						$customer_name 		= $row->customer_name." ".$row->customer_lastname;
						$customer_email		= $row->customer_email;
						$product_name	 	= $row->product_name;
						$sku			 	= $row->sku;
						$unit_price		 	= $row->unit_price;
						$actual_cost_price	= $row->actual_cost_price;
						$order_place_date	= $row->order_placed_date;
						$margin	= (($unit_price - $actual_cost_price)/$unit_price) * 100;
				?>
				<tr>
					<td><?php echo $order_id; ?></td>
					<td><?php echo $customer_name; ?></td>
					<td><?php echo $customer_email; ?></td>
					<td><?php echo $product_name; ?></td>
					<td><?php echo $sku; ?></td>
					<td><?php echo $unit_price; ?></td>
					<td><?php echo $actual_cost_price; ?></td>
					<td><?php echo $margin; ?></td>
					<td><?php if($order_place_date != '') { echo date('d/m/Y',strtotime($order_place_date)); } ?></td>
				</tr>
				<?php } ?>
			</table>			
			
	</div>
</div>
</body>
</html>
 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page Popup</title>
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
<body>
<!--homepage popup-->
<div >
	<div class="holder">
		<form name="frm" id="frm" method="post" action="<?php echo $this->config->base_url(); ?>/index.php/export_products_all_size/export_products" >
		<br><br>
			<div class="popHeading">Candere <span>Report</span></div>		
			<table cellpadding="0" cellspacing="0" border="0" width="50%">
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Products</td>
					<td style="width:500px;">
						<select name="products_packed_ready" id="products_packed_ready" style="width:300px;" class="popHomeEmail" onclick="return chk_product(this.value);">
							<option value="all_products">All Products</option>
							<option value="packed_ready">Packed & Ready</option>
						</select>
					</td>
				</tr>
			</table>
			
			<table cellpadding="0" cellspacing="0" border="0" width="50%" id="div_hide_show" style="display:show;">				
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Category</td>
					<td style="width:500px;">
						<select name="category" id="category" style="width:300px;" class="popHomeEmail">
							<option value="Rings">Rings</option>
							<option value="Chains">Chains</option>
							<option value="Bangles">Bangles</option>
							<option value="Kada">Kada</option>
							<option value="Bracelets">Bracelets</option>
							<option value="Packed & Ready<">Packed & Ready</option>
							<option value="Coins">Coins</option>
							<option value="Pendants">Pendants</option>
							<option value="Earrings">Earrings</option>
							<option value="Nose Pins">Nose Pins</option>
							<option value="Necklaces">Necklaces</option>
						</select>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Metal Selection</td>
					<td style="width:500px;">
						<select name="metal_selection" id="metal_selection" style="width:300px;" class="popHomeEmail">
							<option value="60">Yellow Gold</option>
							<option value="59">White Gold</option>
						</select>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Purity</td>
					<td style="width:500px;">
						<select name="purity" id="purity" style="width:300px;" class="popHomeEmail">
							<option value="50">18K</option>
							<option value="49">14K</option>											
							<option value="589">22K</option>
							<option value="51">9K</option>
							<option value="24K">24K</option>
							<option value="538">Platinum</option>
						</select>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Diamond Quality</td>
					<td style="width:500px;">
						<select name="diamond_quality" id="diamond_quality" style="width:300px;" class="popHomeEmail">
							<option value="si_ij">SI IJ</option>
							<option value="si_gh">SI GH</option>
							<option value="vs_gh">VS GH</option>
							<option value="vvs_ef">VVS EF</option>
						</select>
					</td>
				</tr>				
				</table>
				<table cellpadding="0" cellspacing="0" border="0" width="50%">
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td style="width:200px;padding-left:100px;font-size:16px">Select Range</td>
					<td style="width:500px;">
						<select name="all_products" id="all_products" style="width:300px;" class="popHomeEmail">
						<option value="307_310">307 to 330</option>	
						<?php
							for($i=1;$i<=2000;$i++){
								$j=$i+50;
						?>
							<option value="<?php echo $i."_".$j; ?>"><?php echo $i." to ".$j; ?></option>
							<?php $i=$i+50; } ?>
							<option value="1_500">1 to 500</option>							
							<option value="501_1000">501 to 1000</option>
							<option value="1001_1500">1001 to 1500</option>
							<option value="1501_2000">1501 to 2000</option>
							<option value="2001_2500">2001 to 2500</option>
							<option value="2501_3000">2501 to 3000</option>
							<option value="3001_3500">3001 to 3500</option>
							<option value="3501_4000">3501 to 4000</option>
							<option value="4001_4500">4001 to 4500</option>
							<option value="4501_5000">4501 to 5000</option>
							<option value="5001_5500">5001 to 5500</option>
							<option value="5501_6000">5501 to 6000</option>
							<option value="4001_4500">6001 to 6500</option>
							<option value="4501_5000">6501 to 7000</option>
							<option value="1_1000">1 to 1000</option>
							<option value="1001_2000">1001 to 2000</option>
							<option value="2001_3000">2001 to 3000</option>
							<option value="3001_4000">3001 to 4000</option>
							<option value="4001_5000">4001 to 5000</option>
							<option value="5001_6000">5001 to 6000</option>
							<option value="6001_7000">6001 to 7000</option>
						</select>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td colspan="2" align="center"><input type="submit" name="sbmt" id="sbmt" value="Submit" style="width:120px;" class="popSignup"></td></tr>
				<tr><td colspan="2"style="width:200px;padding-left:100px;font-size:16px"><?php
					$product_type = array('Rings', 'Chains', 'Bangles', 'Kada', 'Bracelets', 'Coins', 'Pendants', 'Earrings', 'Nose Pins', 'Necklaces');
					for($i=0; $i<count($product_type); $i++)
					{
						$sel_count = "select * from catalog_product_flat_1 where candere_product_type_value='".$product_type[$i]."'";
						$res_count = mysql_query($sel_count);
						$num_count = mysql_num_rows($res_count);
						
						echo $product_type[$i] ."   --   ".  $num_count . "<br>";
					
					}
				?></td></tr>
				
			</table>
		</form>
	</div>
</div>
</body>
</html>
 
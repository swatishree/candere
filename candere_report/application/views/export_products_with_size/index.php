<div class="messages">
	<html>
		<head></head>
		<body>
			<form name="frm" id="frm" method="post" >					
				<table cellpadding="0" cellspacing="0" border="0" width="70%">
					<tr>
						<td style="width:200px;padding-left:100px;">Metal Selection</td>
						<td style="width:500px;">
							<select name="metal_selection" id="metal_selection" style="width:300px;">
								<option value="YG">Yellow Gold</option>
								<option value="WG">White Gold</option>
								<option value="RG">Rose Gold</option>
							</select>
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td style="width:200px;padding-left:100px;">Purity</td>
						<td style="width:500px;">
							<select name="purity" id="purity" style="width:300px;">
								<option value="49">14K</option>
								<option value="50">18K</option>
								<option value="589">22K</option>
								<option value="51">9K</option>
								<option value="538">Platinum</option>
							</select>
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr>
						<td style="width:200px;padding-left:100px;">Diamond Quality</td>
						<td style="width:500px;">
							<select name="diamond_quality" id="diamond_quality" style="width:300px;">
								<option value="si_ij">SI IJ</option>
								<option value="si_gh">SI GH</option>
								<option value="vs_gh">VS GH</option>
								<option value="vvs_ef">VVS EF</option>
							</select>
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2"><input type="submit" name="sbmt" id="sbmt" value="Submit" style="width:150px;"></td></tr>
				</table>
			</form>
		</body>
	</html>
	
	<h1 style="padding-left:100px;"><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_all_size/export_products">Export Rings with Weight and Ring Sizes <?php echo $limit_range ?></a></h1>
</div>
 
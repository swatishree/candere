<h3 style="font-size:15px;" class="demo-2">Add Finished Product Details</h3>  
 
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
		$order_id = $order_data->order_id;
		$order_product_id = $order_data->order_product_id;
		$total_diamond_count = $order_data->total_diamond_count;
		$receipt_date = $order_data->receipt_date;
		$metal_id = $order_data->metal_id;
		$metal_purity_id = $order_data->metal_purity_id;
		$metal_weight = $order_data->metal_weight;
		$total_weight = $order_data->total_weight;
		$total_gemstone_count = $order_data->total_gemstone_count;
		$diamond_1_count = $order_data->diamond_1_count;
		$diamond_1_weight = $order_data->diamond_1_weight;
		$diamond_1_clarity = $order_data->diamond_1_clarity;
		$diamond_1_color = $order_data->diamond_1_color;
		$diamond_2_count = $order_data->diamond_2_count;
		$diamond_3_count = $order_data->diamond_3_count;
		$diamond_2_weight = $order_data->diamond_2_weight;
		$diamond_2_clarity = $order_data->diamond_2_clarity;
		$diamond_2_color = $order_data->diamond_2_color;
		$diamond_3_weight = $order_data->diamond_3_weight;
		$diamond_3_count = $order_data->diamond_3_count;
		$diamond_3_clarity = $order_data->diamond_3_clarity;
		$diamond_3_color = $order_data->diamond_3_color;
		$diamond_4_count = $order_data->diamond_4_count;
		$diamond_4_weight = $order_data->diamond_4_weight;
		$diamond_4_clarity = $order_data->diamond_4_clarity;
		$diamond_4_color = $order_data->diamond_4_color;
		$diamond_5_count = $order_data->diamond_5_count;
		$diamond_5_weight = $order_data->diamond_5_weight;
		$diamond_5_clarity = $order_data->diamond_5_clarity;
		$diamond_5_color = $order_data->diamond_5_color;
		$diamond_6_count = $order_data->diamond_6_count;
		$diamond_6_weight = $order_data->diamond_6_weight;
		$diamond_6_clarity = $order_data->diamond_6_clarity;
		$diamond_6_color = $order_data->diamond_6_color;
		$diamond_7_count = $order_data->diamond_7_count;
		$diamond_7_weight = $order_data->diamond_7_weight;
		$diamond_7_clarity = $order_data->diamond_7_clarity;
		$diamond_7_color = $order_data->diamond_7_color; 
		$gemstone_1_name = $order_data->gemstone_1_name;
		$gemstone_1_count = $order_data->gemstone_1_count;
		$gemstone_1_weight = $order_data->gemstone_1_weight;
		$gemstone_2_name = $order_data->gemstone_2_name; 
		$gemstone_2_count = $order_data->gemstone_2_count;
		$gemstone_2_weight = $order_data->gemstone_2_weight;
		$gemstone_3_name = $order_data->gemstone_3_name; 
		$gemstone_3_count = $order_data->gemstone_3_count;
		$gemstone_3_weight = $order_data->gemstone_3_weight; 
		$gemstone_4_name = $order_data->gemstone_4_name;
		$gemstone_4_count = $order_data->gemstone_4_count;
		$gemstone_4_weight = $order_data->gemstone_4_weight;
		$gemstone_5_name = $order_data->gemstone_5_name; 
		$gemstone_5_count = $order_data->gemstone_5_count;
		$gemstone_5_weight = $order_data->gemstone_5_weight;
	}else{ 
		$order_id = '';
		$order_product_id = '';
		$receipt_date = '';
		$metal_id = '';
		$metal_purity_id = '';
		$total_diamond_count = '';
		$metal_weight = '';
		$total_weight = '';
		$total_gemstone_count = '';
		$diamond_1_count = '';
		$diamond_1_weight = '';
		$diamond_1_clarity = '';
		$diamond_1_color = '';
		$diamond_2_count = '';
		$diamond_3_count = '';
		$diamond_2_weight = '';
		$diamond_2_clarity = '';
		$diamond_2_color = '';
		$diamond_3_weight = '';
		$diamond_3_count = '';
		$diamond_3_clarity = '';
		$diamond_3_color = '';
		$diamond_4_count = '';
		$diamond_4_weight = '';
		$diamond_4_clarity = '';
		$diamond_4_color = '';
		$diamond_5_count = '';
		$diamond_5_weight = '';
		$diamond_5_clarity = '';
		$diamond_5_color = '';
		$diamond_6_count = '';
		$diamond_6_weight = '';
		$diamond_6_clarity = '';
		$diamond_6_color = '';
		$diamond_7_count = '';
		$diamond_7_weight = '';
		$diamond_7_clarity = '';
		$diamond_7_color = '';
		$gemstone_1_name = ''; 
		$gemstone_1_count = '';
		$gemstone_1_weight = '';
		$gemstone_2_name = '';
		$gemstone_2_count = ''; 
		$gemstone_2_weight = '';
		$gemstone_3_name = ''; 
		$gemstone_3_count = '';
		$gemstone_3_weight = '';
		$gemstone_4_name = ''; 
		$gemstone_4_count = '';
		$gemstone_4_weight = '';
		$gemstone_5_name = ''; 
		$gemstone_5_count = '';
		$gemstone_5_weight = '';
	}

$form_action 	= base_url('index.php/erp_order/saveproductdetails');
$base_url 		= base_url('index.php/erp_order/to_do_list');

$key['status'] 	= 1;

$metal_values 	= $this->erpmodel->GetInfoRow('metal_values',$key);
$metal_option[''] = 'Select Metal';
foreach($metal_values as $metal) {
	$metal_option[$metal->metal_id] = $metal->metal_value;
}
$metal_dropdown = form_dropdown('metal_id', $metal_option,$metal_id,'id="metal_id" class="tb10"');


$purity_values 	= $this->erpmodel->GetInfoRow('metal_purity_values',$key);
$purity_option[''] = 'Select Purity';
foreach($purity_values as $purity) {
	$purity_option[$purity->metal_purity_id] = $purity->purity_value;
}
$purity_dropdown = form_dropdown('metal_purity_id',$purity_option,$metal_purity_id,'id="metal_purity_id" class="tb10"');


$clarity_values 	= $this->erpmodel->GetInfoRow('diamond_clarity',$key);
$clarity_option[''] = 'Select Clarity';
foreach($clarity_values as $clarity) {
	$clarity_option[$clarity->clarity_id] = $clarity->clarity_name;
}
$clarity_1_dropdown = form_dropdown('diamond_1_clarity',$clarity_option,$diamond_1_clarity,'id="diamond_1_clarity" class="tb10"');
$clarity_2_dropdown = form_dropdown('diamond_2_clarity',$clarity_option,$diamond_2_clarity,'id="diamond_2_clarity" class="tb10"');
$clarity_3_dropdown = form_dropdown('diamond_3_clarity',$clarity_option,$diamond_3_clarity,'id="diamond_3_clarity" class="tb10"');
$clarity_4_dropdown = form_dropdown('diamond_4_clarity',$clarity_option,$diamond_4_clarity,'id="diamond_4_clarity" class="tb10"');
$clarity_5_dropdown = form_dropdown('diamond_5_clarity',$clarity_option,$diamond_5_clarity,'id="diamond_5_clarity" class="tb10"');
$clarity_6_dropdown = form_dropdown('diamond_6_clarity',$clarity_option,$diamond_6_clarity,'id="diamond_6_clarity" class="tb10"');
$clarity_7_dropdown = form_dropdown('diamond_7_clarity',$clarity_option,$diamond_7_clarity,'id="diamond_7_clarity" class="tb10"');

$color_values 		= $this->erpmodel->GetInfoRow('diamond_color',$key);
$color_option[''] 	= 'Select Color';
foreach($color_values as $color) {
	$color_option[$color->color_id] = $color->color_value;
}
 

$color_1_dropdown = form_dropdown('diamond_1_color',$color_option, $diamond_1_color,'id="diamond_1_color" class="tb10"');
$color_2_dropdown = form_dropdown('diamond_2_color',$color_option, $diamond_2_color,'id="diamond_2_color" class="tb10"');
$color_3_dropdown = form_dropdown('diamond_3_color',$color_option, $diamond_3_color,'id="diamond_3_color" class="tb10"');
$color_4_dropdown = form_dropdown('diamond_4_color',$color_option, $diamond_4_color,'id="diamond_4_color" class="tb10"');
$color_5_dropdown = form_dropdown('diamond_5_color',$color_option, $diamond_5_color,'id="diamond_5_color" class="tb10"');
$color_6_dropdown = form_dropdown('diamond_6_color',$color_option, $diamond_6_color,'id="diamond_6_color" class="tb10"');
$color_7_dropdown = form_dropdown('diamond_7_color',$color_option, $diamond_7_color,'id="diamond_7_color" class="tb10"');
$color_7_dropdown = form_dropdown('diamond_7_color',$color_option, $diamond_7_color,'id="diamond_7_color" class="tb10"');
 
	  
$order_table = '<form name="prod_details" method="post" action='.$form_action.'>
			
			<input type="hidden" name="order_id" value='.$selectdata->order_id.'>
			<input type="hidden" name="order_product_id" value='.$selectdata->erp_order_id.'>
			
			<table width="100%" cellspacing=0 cellpadding=5 class="order_table" name="order_table" id="order_table" border="1" style="background-color: #D1D1D1;">
				<tr>
					<td><b>Order Id</b></td>  
					<td colspan="3"><b>'.$selectdata->order_id.'</b></td>   
				</tr>
				
				<tr>
					<td><b>Order Product Name</b></td>  
					<td><b>'.$selectdata->product_name.'</b></td>  
					<td colspan="2" align="center">
						<img src="'.$selectdata->product_image.'" height="120" width="120" class="img_padding"> 
					</td>   
				</tr>
				
				<tr>
					<td><b>Receipt Date</b></td>  
					<td><input type="text" name="receipt_date" id="datepicker" value="" class="tb10"></td>  
					<td></td>  
					<td></td>  
				</tr>
				
				<tr>
					<td><b>Metal</b></td>  
					<td>'.$metal_dropdown.'</td>  
				';
			
			
			if($selectdata->diamond_1_status == 1 || $selectdata->diamond_2_status == 1 || $selectdata->diamond_3_status == 1 || $selectdata->diamond_4_status == 1 || $selectdata->diamond_5_status == 1 || $selectdata->diamond_6_status == 1 || $selectdata->diamond_7_status == 1 ){			
			$order_table .= '
			 
				<td><b>Total Diamond Count</b></td>  
				<td><input type="text" name="total_diamond_count"  id="total_diamond_count" value="'.$total_diamond_count.'" class="tb10"></td>  
								  
			';
			}
			
		$order_table .= '			
				</tr>
				
				<tr>
					<td><b>Metal Purity</b></td>  
					<td>'.$purity_dropdown.'</td>  
			';
			
		if($selectdata->gem_1_status == 1 || $selectdata->gem_2_status == 1 || $selectdata->gem_3_status == 1 || $selectdata->gem_4_status == 1 || $selectdata->gem_5_status == 1){			
		
		$order_table .= '<td><b>Total Gemstone Count</b></td> 
		<td><input type="text" name="total_gemstone_count"  id="total_gemstone_count" value="'.$total_gemstone_count.'" class="tb10"></td>';
		} else {
			$order_table .= '<td>&nbsp;</td> <td>&nbsp;</td>';
		}
			
		$order_table .= '</tr>
				
				<tr>
					<td><b>Metal Weight</b></td>  
					<td><input type="text" name="metal_weight" id="metal_weight" value="'.$metal_weight.'" class="tb10"></td> 
					<td><b>Total Weight</b></td>  
					<td><input type="text" name="total_weight" id="total_weight" value="'.$total_weight.'" class="tb10"></td> 				
				</tr>';

 
		 
if($selectdata->diamond_1_status == 1 || $selectdata->diamond_2_status == 1 || $selectdata->diamond_3_status == 1 || $selectdata->diamond_4_status == 1 || $selectdata->diamond_5_status == 1 || $selectdata->diamond_6_status == 1 || $selectdata->diamond_7_status == 1 ){			
$order_table .= '

			<tr>
					<td colspan="4"> 
						<table cellpadding="3" border="0">
							<tr>
								 <td><b>Diamond Count</b></td>';
			if($selectdata->diamond_1_status == 1){
				$order_table .= '<td><input type="text" name="diamond_1_count"  id="diamond_1_count" value="'.$diamond_1_count.'" class="tb10"></td>';
			}
								 
			if($selectdata->diamond_2_status == 1){
				$order_table .= '<td><input type="text" name="diamond_2_count"  id="diamond_2_count" value="'.$diamond_2_count.'" class="tb10"></td>';
			}
			 
			if($selectdata->diamond_3_status == 1){
				$order_table .= '<td><input type="text" name="diamond_3_count"  id="diamond_3_count" value="'.$diamond_3_count.'" class="tb10"></td>';
			}
			if($selectdata->diamond_4_status == 1){
				$order_table .= '<td><input type="text" name="diamond_4_count"  id="diamond_4_count" value="'.$diamond_4_count.'" class="tb10"></td>';
			} 
			if($selectdata->diamond_5_status == 1){
				$order_table .= '<td><input type="text" name="diamond_5_count"  id="diamond_5_count" value="'.$diamond_5_count.'" class="tb10"></td>';
			}	
			if($selectdata->diamond_6_status == 1){
				$order_table .= '<td><input type="text" name="diamond_6_count"  id="diamond_6_count" value="'.$diamond_6_count.'" class="tb10"></td>';
			}		
			if($selectdata->diamond_7_status == 1){
				$order_table .= '<td><input type="text" name="diamond_7_count"  id="diamond_7_count" value="'.$diamond_7_count.'" class="tb10"></td>';
			}			
								 
$order_table .= '</tr>
							<tr>
								 <td><b>Diamond Weight</b></td>
								 ';
			if($selectdata->diamond_1_status == 1){
				$order_table .= '<td><input type="text" name="diamond_1_weight" id="diamond_1_weight" value="'.$diamond_1_weight.'" class="tb10"></td>';
			}
								 
			if($selectdata->diamond_2_status == 1){
				$order_table .= '<td><input type="text" name="diamond_2_weight"  id="diamond_2_weight" value="'.$diamond_2_weight.'" class="tb10"></td>';
			}
			 
			if($selectdata->diamond_3_status == 1){
				$order_table .= '<td><input type="text" name="diamond_3_weight"  id="diamond_3_weight" value="'.$diamond_3_weight.'" class="tb10"></td>';
			}
			if($selectdata->diamond_4_status == 1){
				$order_table .= '<td><input type="text" name="diamond_4_weight"  id="diamond_4_weight" value="'.$diamond_4_weight.'" class="tb10"></td>';
			}
			if($selectdata->diamond_5_status == 1){
				$order_table .= '<td><input type="text" name="diamond_5_weight"  id="diamond_5_weight" value="'.$diamond_5_weight.'" class="tb10"></td>';
			}
			if($selectdata->diamond_6_status == 1){
				$order_table .= '<td><input type="text" name="diamond_6_weight"  id="diamond_6_weight" value="'.$diamond_6_weight.'" class="tb10"></td>';
			}	
			if($selectdata->diamond_7_status == 1){
				$order_table .= '<td><input type="text" name="diamond_7_weight"  id="diamond_7_weight" value="'.$diamond_7_weight.'" class="tb10"></td>';
			}		 
								 
$order_table .= '   
							</tr>
							<tr>
								 <td><b>Diamond Clarity</b></td>
								 ';
			if($selectdata->diamond_1_status == 1){
				$order_table .= '<td>'.$clarity_1_dropdown.'</td>';
			}
								 
			if($selectdata->diamond_2_status == 1){
				$order_table .= '<td>'.$clarity_2_dropdown.'</td>';
			}
			 
			if($selectdata->diamond_3_status == 1){
				$order_table .= '<td>'.$clarity_3_dropdown.'</td>';
			}
			if($selectdata->diamond_4_status == 1){
				$order_table .= '<td>'.$clarity_4_dropdown.'</td>';
			}
			if($selectdata->diamond_5_status == 1){
				$order_table .= '<td>'.$clarity_5_dropdown.'</td>';
			}
			if($selectdata->diamond_6_status == 1){
				$order_table .= '<td>'.$clarity_6_dropdown.'</td>';
			}	
			if($selectdata->diamond_7_status == 1){
				$order_table .= '<td>'.$clarity_7_dropdown.'</td>';
			}		 
								 
$order_table .= ' 
							</tr>
							<tr>
								 <td><b>Diamond Color</b></td>
								  ';
			if($selectdata->diamond_1_status == 1){
				$order_table .= '<td>'.$color_1_dropdown.'</td>';
			}
								 
			if($selectdata->diamond_2_status == 1){
				$order_table .= '<td>'.$color_2_dropdown.'</td>';
			}
			 
			if($selectdata->diamond_3_status == 1){
				$order_table .= '<td>'.$color_3_dropdown.'</td>';
			}
			if($selectdata->diamond_4_status == 1){
				$order_table .= '<td>'.$color_4_dropdown.'</td>';
			}
			if($selectdata->diamond_5_status == 1){
				$order_table .= '<td>'.$clarity_5_dropdown.'</td>';
			}
			if($selectdata->diamond_6_status == 1){
				$order_table .= '<td>'.$clarity_6_dropdown.'</td>';
			}	
			if($selectdata->diamond_7_status == 1){
				$order_table .= '<td>'.$clarity_7_dropdown.'</td>';
			}		 
								 
$order_table .= '
							</tr>
						</table>
					</td>
			</tr>
';
}


if($selectdata->gem_1_status == 1 || $selectdata->gem_2_status == 1 || $selectdata->gem_3_status == 1 || $selectdata->gem_4_status == 1 || $selectdata->gem_5_status == 1){			
$order_table .= '

			<tr>
					<td colspan="4"> 
						<table cellpadding="3" border="0">
							<tr>
								 <td><b>Gemstone Name</b></td>';
			if($selectdata->gem_1_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_1_name"  id="gemstone_1_name" value="'.$gemstone_1_name.'" class="tb10"></td>';
			}
								 
			if($selectdata->gem_2_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_2_name"  id="gemstone_2_name" value="'.$gemstone_2_name.'" class="tb10"></td>';
			}
			 
			if($selectdata->gem_3_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_3_name"  id="gemstone_3_name" value="'.$gemstone_3_name.'" class="tb10"></td>';
			}
			if($selectdata->gem_4_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_4_name"  id="gemstone_4_name" value="'.$gemstone_4_name.'" class="tb10"></td>';
			} 
			if($selectdata->gem_5_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_5_name"  id="gemstone_5_name" value="'.$gemstone_5_name.'" class="tb10"></td>';
			}	 	
								 
$order_table .= '</tr>
							<tr>
								 <td><b>Diamond Count</b></td>
								 ';
			if($selectdata->gem_1_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_1_count"  id="gemstone_1_count" value="'.$gemstone_1_count.'" class="tb10"></td>';
			}
								 
			if($selectdata->gem_2_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_2_count"  id="gemstone_2_count" value="'.$gemstone_2_count.'" class="tb10"></td>';
			}
			 
			if($selectdata->gem_3_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_3_count"  id="gemstone_3_count" value="'.$gemstone_3_count.'" class="tb10"></td>';
			}
			if($selectdata->gem_4_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_4_count"  id="gemstone_4_count" value="'.$gemstone_4_count.'" class="tb10"></td>';
			}
			if($selectdata->gem_5_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_5_count"  id="gemstone_5_count" value="'.$gemstone_5_count.'" class="tb10"></td>';
			} 	 
			
	$order_table .= '</tr>
							<tr>
								 <td><b>Diamond Weight</b></td>
								 ';
			if($selectdata->gem_1_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_1_weight"  id="gemstone_1_weight" value="'.$gemstone_1_weight.'" class="tb10"></td>';
			}
								 
			if($selectdata->gem_2_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_2_weight"  id="gemstone_2_weight" value="'.$gemstone_2_weight.'" class="tb10"></td>';
			}
			 
			if($selectdata->gem_3_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_3_weight"  id="gemstone_3_weight" value="'.$gemstone_3_weight.'" class="tb10"></td>';
			}
			if($selectdata->gem_4_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_4_weight"  id="gemstone_4_weight" value="'.$gemstone_4_weight.'" class="tb10"></td>';
			}
			if($selectdata->gem_5_status == 1){
				$order_table .= '<td><input type="text" name="gemstone_5_weight"  id="gemstone_5_weight" value="'.$gemstone_5_weight.'" class="tb10"></td>';
			} 
								 
$order_table .= '   
							</tr> 
							</tr>
						</table>
					</td>
			</tr>
';
}



$order_table .= <<<EOD
							 
						</table>
					</td>
				</tr>	
EOD;
 

$order_table .= <<<EOD
				<br>
				<tr>
					<td align="center" colspan="2">
						<input type="submit" name="submit" value="Submit" class="styled-button-1">
					</td>
					
					<td>
					<a href="$base_url">Return To Listing</a>
					</td>
				</tr>
			</table>	
			 
		</form>	
EOD;
 
echo $order_table ;

?>

	
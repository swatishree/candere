<?php 
	header('Content-Type: text/html; charset=utf-8');
?>
<div class="messages">
	<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		} 
	?>
	
	<div>Please Note : Please check if order is invoiced and shipped to display orders in this screen</div>
</div>
<script type="text/javascript" src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/default/candere/js/jquery-1.7.2.min.js'; ?>"></script> 
<style>
	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style>
<script>
	jQuery(document).ready(function(){   

		jQuery('.update').click(function() {
           order_id 	=  jQuery(this).attr( "order_id" );
           increment_id	=  jQuery(this).attr( "increment_id" );
           product_id	=  jQuery(this).attr( "product_id" );
           bluedart_pin =  jQuery("#bluedart_pin_" + order_id + "_"+product_id).val();
		   
		   if(order_id != '' && bluedart_pin != ''){
				jQuery("#ajax_message").html('<h2>Please Wait for date to save.</h2>')
				jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/bluedartshippingprint/update", 
				 data: {bluedart_pin: bluedart_pin,order_id:order_id,product_id:product_id},
				 dataType: "text",  
				 cache:false,
				 success: 
					function(data){
						 jQuery("#ajax_message").html('<h2>Order Id '+increment_id+' Updated Successfully</h2>')
					}
				}); 
				  
				return false;
				 
		   }
        });
		
		jQuery('.assignawb').click(function() {
           order_id 	=  jQuery(this).attr( "order_id" );
           increment_id	=  jQuery(this).attr( "increment_id" ); 
           post_code	=  jQuery(this).attr( "post_code" ); 
           product_id	=  jQuery(this).attr( "product_id" ); 
           invoice_no	=  jQuery(this).attr( "invoice_no" ); 
		   
		   if(order_id != '' && increment_id != '' && post_code != '' && invoice_no !=''){
				jQuery("#ajax_message").html('<h2>Please Wait for date to save.</h2>')
				jQuery.ajax({
				 type: "POST",
				 url: "<?php echo base_url(); ?>index.php/bluedartshippingprint/assignawb", 
				 data: {increment_id: increment_id,order_id:order_id,post_code:post_code,invoice_no:invoice_no,product_id:product_id},
				 dataType: "text",  
				 cache:false,
				 success: 
					function(data){ 
						var json = jQuery.parseJSON(data);
						jQuery("#awb_" + order_id + "_"+product_id).html(json.awb);
						jQuery("#bluedart_pin_" + order_id+ "_"+product_id).val(json.bluedart_pin); 
						 jQuery("#ajax_message").html('<h2>Order Id '+increment_id+' Updated Successfully</h2>')
					}
				}); 
				  
				return false;
				 
		   }
        });
		 
	 });
</script>
<h1>Order's to ship</h1> 
<div id="ajax_message"></div>

<form name="create_batch" method="post" id="create_batch" action="<?php echo base_url(); ?>index.php/bluedartshippingprint/create_batch">

<input style="float:left;" type="submit" name="submit" method="post" value="Create Batch">
<br/>
<br/>

<table width="100%" cellpadding="5" cellspacing="0">
		<thead>
			<tr style="background: #ECECEC">
				<th>
					 &nbsp;
				</th>
				<th>
					Batch Id
				</th>
				<th>
					Order Id
				</th>
				<th>
					Product Name
				</th>
				<th>
					Shipping Name
				</th>
				<th>
					Billing Name
				</th> 
				<th>
					Status
				</th>
				<th>
					Order Date
				</th>
				<th>
					Customer Pin
				</th> 
				<th>
					AWB No
				</th> 
				<th>
					Blue Dart Pin
				</th>
				<th>
					Update
				</th> 
				<th>
					Assign
				</th> 
				<th>
					Print
				</th> 
				<th>
					Bluedart Status
				</th>  
				
				<th>
					Received By
				</th>  
				
				<th>
					Date Time
				</th>  
			</tr>
		</thead>
		<tbody> 
			<?php foreach($results as $rslt){ ?>  
			<?php  
				 
				
				 
				$bluedart_pin 				= '' ;
				$awb		  				= '' ; 
				$batch_id					= '' ; 
				$product_id					= 0 ; 
				$bluedart_status 			= '' ; 
				$received_by			 	= '' ; 
				$date_time				 	= '' ; 
				 
				
				$sql = "SELECT id,awb,bluedart_pin,batch_id from bluedart_orders WHERE order_id = ".$rslt['order_id']." and product_id = ".$rslt['product_id']; 
				
				$results 				= $this->db->query($sql); 
				if($results->num_rows() > 0){ 
					$row 			 		= $results->row_array();
					$awb 			 		= $row['awb'] ;
					$bluedart_pin 	 		= $row['bluedart_pin'] ;  
					$batch_id 	 	 		= $row['batch_id'] ;  
					
					$sql = "SELECT status_time,status_date,received_by,status from bluedart_tracking WHERE bluedart_order_id = ".$row['id'] ; 
				
					$results 				= $this->db->query($sql); 
					
					if($results->num_rows() > 0){ 
						$row 			 		= $results->row_array(); 
						  
						if($row['status'] != 'null' && $row['status'] != '' && !empty($row['status'])){
							$bluedart_status 	 	= $row['status'] ; 
						} 
						if($row['received_by'] != 'null' && $row['received_by'] != '' && !empty($row['received_by'])){
							$received_by 	 	= $row['received_by'] ; 
						} 
						
						if($row['status_date'] != 'null' && $row['status_date'] != '' && !empty($row['status_date'])){
							$date_time 	 	.= $row['status_date'] ; 
						} 
						
						if($row['status_time'] != 'null' && $row['status_time'] != '' && !empty($row['status_time'])){
							$date_time 	 	.= ' '.$row['status_time'] ; 
						} 
						 
					}
				}
				
				$query = $this->db->get_where('sales_order_status', array('status' => $rslt['status']));
				$status = $rslt['status'] ; 
				 
				if($query->num_rows() > 0){ 
					$rows 			 = $query->row_array();
					$status 		 = $rows['label'] ; 
				} 
				$_order = Mage::getModel('sales/order')->load($rslt['order_id']);
				$_shippingAddress 	= $_order->getShippingAddress();
				$post_code			= $_shippingAddress->getPostcode();

			?> 
			<tr>  
				<td>	
					<input type="checkbox" name="batch_id[<?php echo $rslt['order_id'] ;?>][<?php echo $rslt['product_id'] ;?>]" id="<?php echo $rslt['order_id'] ;?>" value="<?php echo $rslt['order_id'] ;?>"></button>
				</td>
				<td>
					<?php if($batch_id != 0){ ?>
					<a href="<?php echo base_url(); ?>index.php/bluedartshippingprint/exportmanifest?batch_id=<?php echo $batch_id ;?>"><?php echo $batch_id ;?></a>
					<?php }else{ ?>
						&nbsp;	
					<?php } ?>
				</td>
				<td><?php echo $rslt['order_increment_id'] ; ?></td>
				<td><?php echo $rslt['name'] ; ?></td>
				<td><?php echo $rslt['shipping_name'] ; ?></td>
				<td><?php echo $rslt['billing_name'] ; ?></td> 
				<td><?php echo $status ; ?></td>
				<td><?php echo $rslt['order_created_date'] ; ?></td> 
				<td><?php echo $post_code ?></td> 
				<td>
					<span id="awb_<?php echo $rslt['order_id'] ;?>_<?php echo $rslt['product_id'] ;?>"><?php echo $awb ?></span>
				</td>
				<td>
					<input name="bluedart_pin[<?php echo $rslt['entity_id'] ;?>]" id="bluedart_pin_<?php echo $rslt['order_id'] ;?>_<?php echo $rslt['product_id'] ;?>" value="<?php echo $bluedart_pin ?>" size="10">
				</td>  
				<td>
					<input type="button" name="submit" order_id="<?php echo $rslt['order_id'] ;?>"  increment_id="<?php echo $rslt['order_increment_id'] ;?>" product_id="<?php echo $rslt['product_id'] ;?>"   class="update" value="Update Bluedart Pin"></button>
				</td>
				<td>
					<input type="button" name="submit" order_id="<?php echo $rslt['order_id'] ;?>"  increment_id="<?php echo $rslt['order_increment_id'] ;?>" invoice_no="<?php echo $rslt['invoice_increment_id'] ;?>" post_code="<?php echo $post_code ;?>" product_id="<?php echo $rslt['product_id'] ;?>"  class="assignawb" value="Assign AWB No"></button>
				</td>
				<td>
					<input type="button" name="submit" onclick="location.href='<?php echo base_url(); ?>index.php/bluedartshippingprint/form?order_id=<?php echo $rslt['order_id'] ;?>&product_id=<?php echo $rslt['product_id'] ;?>'" order_id="<?php echo $rslt['order_id'] ;?>" class="print" value="Print"></button>
				</td>
				<td><?php echo $bluedart_status; ?></td>  
				<td><?php echo $received_by; ?></td>  
				<td><?php echo $date_time; ?></td>  
			</tr>
			
			<?php } ?> 
		</tbody>
</table> 
</form>
  
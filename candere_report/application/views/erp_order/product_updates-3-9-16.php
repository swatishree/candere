<script type="text/javascript">
$(document).ready(function () {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
});
</script>

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
<div id="quotesleft">
<ul id="buttons">
    <li><a href="<?php echo base_url('index.php/erp_order/to_do_list')?>"><b>To Do List</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/processing_orders')?>"><b>Processing Orders</b></a></li>
    <li><a href="<?php echo base_url('index.php/erp_order/archieved_orders')?>"><b>Archieved Orders</b></a></li>
    <li class="active"><a href="<?php echo base_url('index.php/erp_order/product_updates')?>"><b>Product Updates</b></a></li>
	<li><a href="<?php echo base_url('index.php/erp_order/cancelled_orders')?>"><b>Cancelled Orders</b></a></li>
	 <li><a href="<?php echo base_url('index.php/erp_order/completed_orders')?>"><b>Completed Orders</b></a></li>
</ul>
</div>

<div id="quotescenter" style="padding-top:10px;">
<?php	
echo '<form method="POST" name="sts_form" action="'.base_url('index.php/erp_order/product_updates').'">';
		$options = array(
				  '1'  => 'Details Not Entered',
				  '2'  => 'Details Entered',
				);
		echo '<input type="text" name="search_order_id" placeholder="Search" class="tb10" style="width:100px;height:31px;" value="'.set_value('search_order_id').'">';	
		echo form_dropdown('search_by', $options, set_value('search_by'), 'id="search_by" class="SlectBox" style="width:150px;" onchange="this.form.submit();"');
		echo '<input type="submit" name="sts_submit" value="Search" class="styled-button-1">';
echo '</form>'; ?>
</div>

<div id="quotesright" style="padding-top:5px;">
<span>			

</span>
			
</div>
</div>

  <table width="100%" cellspacing=0 cellpadding=0 id="product_update_table" style="margin: 0 auto; padding:1px 10px 20px 10px;">
				<tbody>
					<tr style="height:40px;">
						<!--<th class="th_color">Id</th> -->
						<th class="th_color">Image</th>
						<th class="th_color">Order Id</th>
						<th class="th_color">Order Product Id</th>
						<th class="th_color">SKU</th>
						<th class="th_color">Product Name</th>
						<th class="th_color">Status</th>
						<th class="th_color">Order update</th>
					</tr>
								
		<?php if($prod_updates) {
			$pr_counter = 1;
			$row_count = 1;
			$prod_data 	= array();
			$prod_array = array();
						
			foreach($prod_updates as $pru) { 
				
				if(!in_array($pru->order_id,$prod_data)) {
					$pr_counter++;
				}
				$bgclass= ($pr_counter%2==0) ? 'bg_2' : 'bg_1';
								
				$prod_data = array_merge($prod_array, array('order_id'=>$pru->order_id));
				$prod_data = array_filter($prod_data);
			?>				
				<!--<tr class="<?php //echo $bgclass ?>" data-href="<?php //echo base_url('index.php/erp_order/addfinishedproductdetails?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'') ?>">-->
				
				<tr class="<?php echo $bgclass ?>" data-href="<?php echo base_url('index.php/erp_order/add_finished?erp_order_id='.$pru->order_id.'&order_product_id='.$pru->erp_order_id.'') ?>">
				
						<!--<td align="center" class="bottom left"><?php //echo $row_count; ?></td>-->
						<td align="center" class="left bottom" style="padding:10px;"><?php echo '<img src="'.str_replace('cdn','www',$pru->product_image).'" width="100" height="100">' ?></td>
						<td align="center" class="bottom"><?php echo $pru->order_id ?></td>
						<td align="center" class="bottom"><?php echo $pru->erp_order_id ?></td>
						<td align="center" class="bottom"><?php echo $pru->sku ?></td>
						<td align="center" class="bottom"><?php echo $pru->product_name ?></td>
						<td align="center" class="bottom">
						<?php 
						 
						echo $pru->status_name ;
						 
						?>
						</td>
						<td align="center" class="bottom right" style="padding:5px;">
						<?php 
						 
						 
						 $query = "select * from trnorderprocessing where order_id='$pru->order_id'" ;
						  $results = $this->db->query($query);
						  
						  $result 	= $results->result_array(); ?>
						  
                        
						 <table style=" cellpadding:1px; border:solid 1px;width: 100%">
						
						
							 
							
							 <?php						
						 $count = count($result);
                         $i = 0 ;
						foreach($result as $res)
						{
							
							?>
						
						<tr> <td> <?php  $query = "select status_name from mststatus where status_id= ".$res['order_status_id'] ; 
							  $results = $this->db->query($query);
						      $result 	= $results->result_array();
							  echo $result[0]['status_name'].'<br/>' ; ?> </td></tr>
							  <tr> <td> <?php echo $res['updated_date'].'<br/>'; ?> </td></tr>
						<tr> <td> <?php echo $res['updated_by'].'<br/>' ; ?></td></tr>
						   
						
						 
						
							 
						   
						 <?php if(($count-$i)>1) { ?> <td> <hr></td> 
						<?php 
						 }
						$i++ ;
						}
						
						?>
								 
									
									                       
									
								
							                   
						
                      </table>
						</td>
				</tr>
			<?php
			$row_count++;
			}
		} ?>
			</tbody>
		</table>


<!-- Pagination for Product update list -->
<?php 

	echo $this->pagination->create_links();
?>

<script type='text/javascript'>
$(document).ready(function () {
	$('.popbox').popbox();
	
	$('#order_table tr').click(function(){
		var cid = $(this).attr('id');
		
		$('#OrderStatusID_'+cid).change(function(){
			if($("#OrderStatusID_"+cid+" option:selected").val()==1) {
				$("#vendor_dis_"+cid).hide();
			} else {
				$("#vendor_dis_"+cid).show();
			}
			if($("#OrderStatusID_"+cid+" option:selected").val()==2) {
				$("#greeting_dis_"+cid).hide();
			} else {
				$("#greeting_dis_"+cid).show();
			}
		});
	});
});

$('#selectAll').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});	

$('#select_all').click(function() {
    $('#status_id option').prop('selected', true);
});

$(document).ready(function(){
    $('#product_update_table tr').click(function(){
        window.location = $(this).data('href');
        return false;
    });
});
</script>

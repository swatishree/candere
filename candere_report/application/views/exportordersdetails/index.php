<div class="messages">
	<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		}
	?>
</div>
 <style>
	.pagination{    padding: 10px;}
	.seach_invoice_form  {              padding: 51px;                background: #444;        
        -moz-border-radius: 10px;        -webkit-border-radius: 10px;        border-radius: 10px;        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2); box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);    }
		
    .seach_invoice_form  input { width: 330px; padding: 10px 5px; border: 0; 
        -moz-border-radius: 3px 0 0 3px; -webkit-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;		margin-left:890px;		height: 41px; }
    
    .seach_invoice_form  input:focus {        outline: 0;              -moz-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;        -webkit-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;        box-shadow: 0 0 2px rgba(0,0,0,.8) inset;    }
    
    .seach_invoice_form  input::-webkit-input-placeholder {       color: #999;       font-weight: normal;       font-style: italic;    }
    
    .seach_invoice_form  input:-moz-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }
	.seach_invoice_form  input:-ms-input-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }    
    
    .seach_invoice_form  button {
		overflow: visible; position: relative;        float: right;        border: 0;        padding: 0;        cursor: pointer;        height: 40px;        width: 110px;        font: bold 15px/40px 'lucida sans', 'trebuchet MS', 'Tahoma';
        color: #fff;        text-transform: uppercase;        background: #d83c3c;        -moz-border-radius: 0 3px 3px 0;        -webkit-border-radius: 0 3px 3px 0;        border-radius: 0 3px 3px 0;             text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);				    }   
		
	.seach_invoice_form  button:hover{		        background: #e54040;    }	
      
    .seach_invoice_form  button:active,    .seach_invoice_form  button:focus{ background: #c42f2f; }
    
	.seach_invoice_form  button:before { content: ''; position: absolute; border-width: 8px 8px 8px 0; border-style: solid solid solid none; border-color: transparent #d83c3c transparent; top: 12px; left: -6px; }
    
	.seach_invoice_form  button:focus:before{        border-right-color: #c42f2f;		margin-left:800px;    }    
	
	.button_example{    background: #d83c3c none repeat scroll 0 0;    border: 0 none;    color: #fff;    cursor: pointer;      font: bold 15px/40px "lucida sans","trebuchet MS","Tahoma";    height: 35px;    overflow: visible;    padding: 0;        width: 100px; margin-left:353px;}

	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 5px;    padding: 10px 5px;    width: 130px;	margin-top:20px;}
	
	.input_type1{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 15px;    padding: 10px 5px;    width: 130px;	}
	
	.option_{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 15px;    padding: 21px 20px; 	position: absolute;}
    
	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style> 
<script>
$(function(){
	$( "#todatepicker" ).datepicker({ dateFormat: 'yy-mm-dd', maxDate: new Date() });
	$( "#fromdatepicker" ).datepicker({ dateFormat: 'yy-mm-dd' ,maxDate: new Date() });			
});
</script>


	<script type="text/javascript">
	 function validateForm() { 
		
		var fromdatepicker=$("#fromdatepicker").val();
		var todatepicker = $("#todatepicker").val();
			
		
		if(fromdatepicker!=='' && todatepicker==''){
			
			
			alert('FROM date Requied!');
			return false;
		}
		
		if(fromdatepicker=='' && todatepicker!=''){
			
			
			alert('To date Requied!');
			return false;
		}
		
   
	 
		var datdiff=fromdatepicker-todatepicker;
		if(fromdatepicker<todatepicker){
			alert('From date Should be greater to date!');
			
			return false;
		}
	}
    </script>
	<?php
	
	    $sql = 'select distinct status,label from sales_order_status';
		 
		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		
		
		$fromdatepicker = '';
		$todatepicker = '';
		$order_status = '';
	if(isset($_GET) && !empty($_GET)){ 
		$fromdatepicker = $_GET['fromdatepicker'];
		$todatepicker = $_GET['todatepicker']; 
		$order_status = $_GET['order_status']; 
		
		 
	}
		
	
	
	
		
	?>
	<div style="font-size:25;"></div>
	<form  name="myForm"  onsubmit="return validateForm()" action="<?php echo site_url('exportordersdetails/index');?>" chars  method="get" accept-charset='UTF-8'>
    <div class="seach_invoice_form  cf">
	
	</div>
	
	
	<div style="background-position: left;    margin-top: -105px;    position: absolute;">
	
		<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="from date" value='<?php echo trim($_GET['todatepicker']); ?>' required >
		
		<input id="fromdatepicker" name="fromdatepicker" class ='input_type1' type="text" name='to_date' placeholder="to date" value='<?php echo trim($_GET['fromdatepicker']); ?>' required >
			<select required name="order_status[]"  class ='option_' id="order_status" multiple>
			<?php
				foreach($result as $states){ 
					$select = '';

					if(isset($_GET) && !empty($_GET)){ 
						if (in_array($states['status'], $order_status)) {
							 
							$select= 'selected';
						}
					}else{	
						if($states['status'] == 'complete' || $states['status'] == 'processing'){
							$select= 'selected';
						}
					}
					 
			?>
					<option value="<?php echo trim($states['status']) ;?>" <?php echo $select ; ?>><?php echo ucwords(str_replace('_',' ',$states['label'])); ?></option>
			<?php
				}
			?>
			
		</select>
		
		<button  class="button_example"  type="submit">Search</button>
	
	</div>
	
	
	</form>


<?php 
    
	 
	  $order_status = implode(",", $order_status);
	  
	  
		if(count($search_data) > 0){
		 
	 $csv_url = base_url('index.php/exportordersdetails/export?todatepicker='.$_GET['todatepicker'].'&fromdatepicker='.$_GET['fromdatepicker'].'&order_status='.$order_status.'  ');
		$url = base_url('index.php/exportordersdetails/index');
		if($_GET){
		echo '<a style="width: 120px; color: #d83c3c; font-size:16px; position: relative" href="'.$csv_url.'">Export All Order Items </a>' ;
		;
		echo '<div style="color:#d83c3c;margin-left:550px;"><b>Result Counts '. $results_count.'</b></div>';
		
		echo '<a style="width: 120px; color: #d83c3c; font-size:16px; margin-left:1230px; position: relative" href="'.$url.'">Order list </a>' ;
		}
?>
		<div style="padding-bottom: 20px; float:right;display:<?php echo $var1; ?>">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
		
	<table border="1" cellpadding="5" cellspacing="0" style="clear:both;margin:0 auto; text-align: center; margin-top:20px;display:<?php echo $var1;?>">
		
		<tr>
			<th>Created Date</th>
			<th>Order Id</th>
			<th>Customer Name</th>
			<th>Product Name</th>		
			<th>Sku</th>
			<th>Total Qty Ordered</th>		
			<th>Coupon Code</th>
			<th>Product Type</th>
			<th>Product Price</th>			
			<th>Subtotal</th>
			<th>Shipping Amount</th>			
			<th>Discount Amount</th>
			<th>Grand Total</th>
			<th>Total Paid</th>			
			<th>Payment Method</th>
			<th>Track Number</th>		
			<th>Carrier </th>
			<th>Dispatch_date</th>
			<th>Expected Delivery Date</th>
			<th>Mktplace Id</th>
			<th>Mktplace Name</th>
			<th>Status</th>
		</tr>
	<?php
 //echo "<pre>"; print_r($search_data);
			foreach($search_data as $rslt){
			$product_options = unserialize($rslt['product_options']);
			$product_options['product_options'];
			$additional_options = $product_options['additional_options'];
			$last_element = end($additional_options);	
		   // $expected_delivery_date = $last_element['value'] ; 
			$expected_delivery_date = $rslt['Expected_delivery_date']; 
			
			$dispatch_date=date('d,M Y',strtotime('-3 day', strtotime($expected_delivery_date)));
			$Created_Date=date('d,M Y', strtotime($rslt['Created_Date']));
			$expected_delivery_date=date('d,M Y', strtotime($expected_delivery_date));	

		
			//****************************** get payment label query and get product Type ************************************
			 						 
			$var='payment/'.$rslt['method'].'/title';
		    $sql="SELECT value FROM  `core_config_data` WHERE  `path` LIKE  '$var' LIMIT 0 , 1";
		    $results = $this->db->query($sql);			
			$result = $results->result(); 	
			

			//****************************** get payment label query************************************
			
?>
			<tr>
				<td><?php echo $Created_Date;?></td>  
				<td><?php echo $rslt['Order_Id']; ?></td>
				<td><?php echo $rslt['Bill_To']; ?></td>	
				<td><?php echo $rslt['Product_Name'];?></td>
				<td><?php echo $rslt['Sku'];?></td>
				<td><?php echo number_format($rslt['qty_ordered']);?></td>				
				<td>
				<?php echo ($rslt['coupon_code'])? $rslt['coupon_code'].' ': 'N/A'; ?>
					<?php echo ($rslt['coupon_code2'])? $rslt['coupon_code2'].',': ''; ?>
					<?php echo ($rslt['coupon_code3'])? $rslt['coupon_code3'].',':  ''; ?>
					<?php echo ($rslt['coupon_code4'])? $rslt['coupon_code4'].',': ''; ?>
					<?php echo ($rslt['coupon_code5'])? $rslt['coupon_code5']: ''; ?>
				</td>
				<td><?php echo $rslt['producttype']; ?></td>	
				<td><?php echo Mage::helper('core')->currency($rslt['base_price'],true,false);?></td>
				<td><?php echo Mage::helper('core')->currency($rslt['base_row_total'],true,false);?></td>				
				<td><?php echo Mage::helper('core')->currency($rslt['base_shipping_amount'],true,false) ;?></td>
				<td><?php echo Mage::helper('core')->currency($rslt['base_discount_amount'],true,false);?></td>				
				
				<td><?php echo Mage::helper('core')->currency($rslt['grand_total'],true,false);//$rslt['grand_total'];?></td>
				<td><?php echo Mage::helper('core')->currency($rslt['base_total_paid'],true,false);//$rslt['grand_total'];?></td>
				
				<td><?php echo ($result[0]->value) ? $result[0]->value : $rslt['method'] ; ?></td>	
				<td><?php echo ($rslt['track_number'])? $rslt['track_number']: 'N/A';?></td>
				<td><?php echo ($rslt['title'])? $rslt['title']: 'N/A';?></td>
				<td><?php echo $dispatch_date;?></td>				
				<td><?php echo $expected_delivery_date; ?></td>	
				<td><?php echo($rslt['mktplace_order_id'])? $rslt['mktplace_order_id']: 'N/A';?></td>
				<td><?php echo($rslt['mktplace_name'])? $rslt['mktplace_name']: 'N/A';?></td>				
				<td><?php echo $rslt['status'] ; ?></td> 
				
			</tr>
<?php
			}
?>
	</table>
	<div>
	
	<div style="margin-left:1053px; margin-block-end:60px; display:<?php echo $var1; ?>">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
	
<?php

		}else{
			
			echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
		}
		
	
	 
?>



  

 

 
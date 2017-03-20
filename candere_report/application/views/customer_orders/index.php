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
</div> 
<style>
	.pagination{    padding: 10px;}
	.seach_invoice_form  {              padding: 28px;        margin: 30px auto 30px;        background: #444;        
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
	
	.button_example{    background: #d83c3c none repeat scroll 0 0;    border: 0 none;    color: #fff;    cursor: pointer;    float: right;    font: bold 15px/40px "lucida sans","trebuchet MS","Tahoma";    height: 35px;    overflow: visible;    padding: 0;        width: 100px; margin-left:10px;}

	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 5px;    padding: 10px 5px;    width: 130px;	}
	
	.input_type1{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 15px;    padding: 10px 5px;    width: 130px;	}
    
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
		
    if (!$("#orderid").val().match(/\S/) && !$("#invoiceno").val().match(/\S/) && !$("#p_name").val().match(/\S/) && !$("#todatepicker").val().match(/\S/) && !$("#fromdatepicker").val().match(/\S/) && !$("#bill_to").val().match(/\S/) ) {
        alert(" field is required !");
        return false;
    }
	 
		var datdiff=fromdatepicker-todatepicker;
		if(fromdatepicker<todatepicker){
			alert('From date Should B greater!');
			
			return false;
		}
	}
    </script>
<form  name="myForm"  action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()" chars  method="get" accept-charset='UTF-8'>
    <div class="seach_invoice_form  cf">
	
	</div>
	
	 
	<div style="background-position: left;    margin-top: -75px;    position: absolute;">
	 
		
		<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="Created At from date" value='<?php echo $_GET['todatepicker']; ?>'>
		
		<input id="fromdatepicker" name="fromdatepicker" class ='input_type1' type="text" name='to_date' placeholder="Created At to date" value='<?php echo $_GET['fromdatepicker']; ?>'>
		
		<input id="email" name="email" class ='input_type1' type="text" name='email' placeholder="Customer Email" value='<?php echo $_GET['email']; ?>'>
		
		<input id="city" name="city" class ='input_type1' type="text" name='city' placeholder="City" value='<?php echo $_GET['city']; ?>'>
		
		<input id="region" name="region" class ='input_type1' type="text" name='region' placeholder="State" value='<?php echo $_GET['region']; ?>'>
		
		<input id="country_id" name="country_id" class ='input_type1' type="text" name='country_id' placeholder="Country" value='<?php echo $_GET['country_id']; ?>'>
		
		<input id="postcode" name="postcode" class ='input_type1' type="text" name='postcode' placeholder="Pincode" value='<?php echo $_GET['postcode']; ?>'>
		
		<input id="affiliate_source" name="affiliate_source" class ='input_type1' type="text" name='affiliate_source' placeholder="Affiliate Source" value='<?php echo $_GET['affiliate_source']; ?>'>
		
		<input id="affiliate_medium" name="affiliate_medium" class ='input_type1' type="text" name='affiliate_medium' placeholder="Affiliate Medium" value='<?php echo $_GET['affiliate_medium']; ?>'>
			 
		<button  class="button_example"  type="submit">Search</button>
	
	</div>
</form>

<p style="padding: 5px 0 5px 5px; width:40%; float:left; "><a href="<?php echo base_url();?>index.php/customer_orders/index" style="font-size:16px;">Reset All Filters</a></p>

<?php 

	$error = array_filter($data);
 
	if (empty($error)){
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;">No Data Found!!!</div>';		
	}else{ 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;"><b>Total Recors : '. $total_count.'</b></div>';
?>  <div style="padding-bottom: 20px; float:right;">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
	<br>
	
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<th align="center">Order Id</th>
				<th align="center">Order Status</th> 
				<th align="center">Customer Name</th> 
				<th align="center">Customer Email</th> 
				<th align="center">Ip Address</th> 
				<th align="center">Order Currency Code</th> 
				<th align="center">Ordered Date</th> 
				<th align="center">Sku</th> 
				<th align="center">Name</th> 
				<th align="center">Price(Rs)</th> 
				<th align="center">Price(Order Currency)</th>  
				<th align="center">Discount(Rs)</th> 
				<th align="center">Discount(Order Currency)</th>  
				<th align="center">Grand Total(Rs)</th>  
				<th align="center">Total Paid(Rs)</th> 
				<th align="center">Grand Total(Order Currency)</th> 
				<th align="center">Total Paid(Order Currency)</th> 
				<th align="center">Country</th> 
				<th align="center">Region</th> 
				<th align="center">City</th> 
				<th align="center">Pincode</th>  
				<th align="center">Affiliate Id</th>			
				<th align="center">Affiliate Source</th>			
				<th align="center">Affiliate Medium</th>			
				<th align="center">Affiliate Term</th>			
				<th align="center">Affiliate Content</th>	
			</tr>
		</thead>  
			
	<?php
	 
			foreach($data as $row){ 
				
					$options = unserialize($row['options']);
				?>
					<tr>
							<td align="center"><?php echo  $row['increment_id'] ;?></td>
							<td align="center"><?php echo  $row['status'] ;?></td>
							<td align="center"><?php echo  $row['customer_name'] ;?></td>
							<td align="center"><?php echo  $row['customer_email'] ;?></td>
							<td align="center"><?php echo  $row['remote_ip']  ;?></td>   
							<td align="center"><?php echo  $row['order_currency_code']  ;?></td>   
							<td align="center"><?php echo  $row['created_at']  ;?></td>   
							<td align="center"><?php echo  $row['sku']  ;?></td>   
							<td align="center"><?php echo  $row['name']  ;?></td>   
							<td align="center"><?php echo  $row['base_price']  ;?></td>   
							<td align="center"><?php echo  $row['price']  ;?></td>   
							<td align="center"><?php echo  $row['base_discount_amount']  ;?></td>   
							<td align="center"><?php echo  $row['discount_amount']  ;?></td>   
							<td align="center"><?php echo  $row['base_grand_total']  ;?></td>   
							<td align="center"><?php echo  $row['base_total_paid']  ;?></td>    
							<td align="center"><?php echo  $row['grand_total']  ;?></td>   
							<td align="center"><?php echo  $row['total_paid']  ;?></td>   
							<td align="center"><?php echo  $row['country_id']  ;?></td>   
							<td align="center"><?php echo  $row['region']  ;?></td>   
							<td align="center"><?php echo  $row['city']  ;?></td>   
							<td align="center"><?php echo  $row['postcode']  ;?></td>   
							
							<td align="left"><?php echo  $row['affiliate_id'] ;?></td>
							<td align="left"><?php echo  $row['affiliate_source'] ;?></td>
							<td align="left"><?php echo  $row['affiliate_medium'] ;?></td>
							<td align="left"><?php echo  $row['affiliate_term'] ;?></td>
							<td align="left"><?php echo  $row['affiliate_content'] ;?></td>
					</tr>
				<?php   
			}
		 
	?>
	</table>
	<div style="float: right; display: table;">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
<?php  } ?> 

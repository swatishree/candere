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
	.seach_invoice_form  {             margin: 30px auto 30px;        background: #444;        
        -moz-border-radius: 10px;        -webkit-border-radius: 10px;        border-radius: 10px;        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2); box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);  padding: 15px 0 15px 0;
    display: table;
    width: 100%;  }
		
    
    .seach_invoice_form  label {     float: left; padding: 5px; font-weight: bold; color: #FFFFFF; }
    .seach_invoice_form  button {
		overflow: visible; position: relative;        float: left;  margin:0 0 0 15px;      border: 0;        padding: 0;        cursor: pointer;        height: 40px;        width: 110px;         font-weight:bold;
        color: #fff;        text-transform: uppercase;        background: #d83c3c;        -moz-border-radius: 0 3px 3px 0;        -webkit-border-radius: 0 3px 3px 0;        border-radius: 0 3px 3px 0;             text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);				    }   
		
	.seach_invoice_form  button:hover{		        background: #e54040;    }	
      
    .seach_invoice_form  button:active,    .seach_invoice_form  button:focus{ background: #c42f2f; }
    
	.seach_invoice_form  button:before { position: absolute; border-width: 8px 8px 8px 0; border-style: solid solid solid none; border-color: transparent #d83c3c transparent; top: 12px; left: -6px; }
    
	.seach_invoice_form  button:focus:before{        border-right-color: #c42f2f;		margin-left:800px;    }    
 
	input,select{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 5px;    padding: 10px 5px;    width: 130px; float: left;
    width: auto;
    display: table;	}
	 select {     width: 130px; 	}
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
	<?php
	 $sql = "select status from sales_order_status where `status`='complete' or status='processing'";
		 
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
	
<form  name="myForm"  action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()" chars  method="get" accept-charset='UTF-8'>
    <div class="seach_invoice_form  cf">
		 
		 
			<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="Created At from date" value='<?php echo $_GET['todatepicker']; ?>'>
			
			<input id="fromdatepicker" name="fromdatepicker" class ='input_type1' type="text" name='to_date' placeholder="Created At to date" value='<?php echo $_GET['fromdatepicker']; ?>'>
			
			
			
			<select name="price" id="price">
				<option value="">Select Price</option>
				<option value="less_than_15k" <?php if($_GET['price']=='less_than_15k') echo 'selected'; ?> >below Rs. 15,000</option>
				<option value="less_than_30k" <?php if($_GET['price']=='less_than_30k') echo 'selected'; ?> >below Rs. 30,000</option>
				<option value="less_than_50k" <?php if($_GET['price']=='less_than_50k') echo 'selected'; ?> >belowRs. 50,000</option>
				<option value="more_than_50k" <?php if($_GET['price']=='more_than_50k') echo 'selected'; ?> >above Rs. 50,000</option>
			</select>
			
			<!--select name="state[]" id="state" multiple="multiple">
				<option value="processing" selected>Processing</option>	
				<option value="complete">Complete</option>	
			</select-->
		 
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
					<option value="<?php echo $states['status'] ;?>" <?php echo $select ; ?>><?php echo $states['status']; ?></option>
			<?php
				
				}
			?>
			
		</select>
			  
			<button  class="button_example"  type="submit">Search</button>
			 
	</div>
	
	 
	
</form>
 
<?php 

if(isset($_GET) && !empty($_GET)){ 
		$fromdatepicker = $_GET['fromdatepicker'];
		$todatepicker 	= $_GET['todatepicker']; 
		$order_status 	= $_GET['order_status']; 
		
		 
	}
	
	$error = array_filter($data);
	$order_status = implode(",", $order_status);
	
	if (empty($error) || $data['noData'] == 'emptydta'){
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;">No Data Found!!!</div>';		
	}else{ 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;"><b>Total Recors : '. count($data).'</b></div>';
		
		
		if(count($data) > 0){
		 
	 $csv_url = base_url('index.php/customer_lists/export?todatepicker='.$_GET['todatepicker'].'&fromdatepicker='.$_GET['fromdatepicker'].'&order_status='.$order_status.'  ');
		$url = base_url('index.php/customer_lists/index');
		if($_GET){
		echo '<a style="width: 120px; color: #d83c3c; font-size:16px; float:right; position: relative" href="'.$csv_url.'">Export All Order Items </a>' ;
		;
		
		
		}}
		
		
?>  






<div style="padding-bottom: 20px; float:right;">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
	<br>
	
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<th align="center">Created Date</th>
				<th align="center">Product Name</th>
				<th align="center">Sku</th>
				<th align="center">Product price</th>
				<th align="center">Grand Total</th>
				<th align="center">Firstname</th> 
				<th align="center">Lastname</th>  
				<th align="center">Email</th> 
				<th align="center">Telephone</th> 
				<th align="center">Postcode</th> 
				<th align="center">City</th>
				<th align="center">State</th> 				
				<th align="center">Postcode</th> 
			</tr>
		</thead>  
			
	<?php
	 
			foreach($data as $row){ 
				
					$options = unserialize($row['options']);
					
					$country = Mage::getModel('directory/country')->loadByCode($row['country_id']);
				?>
					<tr>
							<td align="center"><?php echo  $row['created_at'] ;?></td>
							<td align="center"><?php echo  $row['name'] ;?></td>
							<td align="center"><?php echo  $row['sku'] ;?></td>
							<td align="center"><?php echo  $row['product_price'] ;?></td>
							<td align="center"><?php echo  $row['base_grand_total'] ;?></td>
							<td align="center"><?php echo  $row['firstname']  ;?></td>   
							<td align="center"><?php echo  $row['lastname']  ;?></td>   
							<td align="center"><?php echo  $row['email']  ;?></td>  
							<td align="center"><?php echo  $row['telephone'];?></td>  
							<td align="center"><?php echo  $row['postcode']  ;?></td>  
							<td align="center"><?php echo  $row['city']  ;?></td>
							<td align="center"><?php echo  $row['region']  ;?></td>							
							<td align="center"><?php echo  $row['postcode']  ;?></td>  
					</tr>
				<?php   
			}
		 
	?>
	</table>
	<div style="float: right; display: table;">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
<?php  } ?> 

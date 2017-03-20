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
	.seach_invoice_form  {              padding: 56px;           background: #444;        
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

	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 5px;    padding: 10px 5px;    width: 130px; float:left;	}
	
	.input_type1{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 15px;    padding: 10px 5px;    width: 130px;	float:left; }
    
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
	$( "#created_at" ).datepicker({ dateFormat: 'yy-mm-dd' ,maxDate: new Date() });	
});
</script>


	<script type="text/javascript">
	 function validateForm() { 
		
		var fromdatepicker=$("#fromdatepicker").val();
		
		var todatepicker = $("#todatepicker").val();
		
		if(fromdatepicker =='' && todatepicker==''){
			
			
			alert('FROM date Requied!');
			return false;
		}
		
		if(fromdatepicker =='' && todatepicker!=''){
			
			
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
	
		$fromdatepicker = '';
		$todatepicker = '';
		$product_type = '';
		$order_status = '';
		$region		 = '';
		
	if(isset($_GET) && !empty($_GET)){ 
		$fromdatepicker = $_GET['fromdatepicker'];
		$todatepicker = $_GET['todatepicker']; 
		$product_type = $_GET['product_type']; 
		$order_status = $_GET['order_status'];
		$region = $_GET['region'];
		 
	}
	
	$sql="SELECT  DISTINCT eav_attribute_option_value.value AS product_type FROM ( ( eav_attribute_option eav_attribute_option INNER JOIN eav_attribute_option_value eav_attribute_option_value ON (eav_attribute_option.option_id = eav_attribute_option_value.option_id)) INNER JOIN catalog_product_entity_int catalog_product_entity_int ON (catalog_product_entity_int.value = eav_attribute_option.option_id)) INNER JOIN catalog_product_entity catalog_product_entity ON (catalog_product_entity.entity_id = catalog_product_entity_int.entity_id) WHERE catalog_product_entity_int.attribute_id = 272";
	
	$results = $this->db->query($sql);
	
	$result = $results->result();
	
	
	$sql_region="select  DISTINCT region from sales_flat_order_address ";
	
	$sql_regions = $this->db->query($sql_region);
	
	$results_sql_region = $sql_regions->result_array();
	
	
	$sql_pincode="select  SFO.increment_id,SFOA.region ,SFOA.city,SFOA.postcode from sales_flat_order_address SFOA
		left join sales_flat_order  SFO on (SFO.entity_id=SFOA.parent_id)
		where SFOA.address_type='billing' and SFO.state='complete' or 
		SFO.state='closed' order by SFO.increment_id desc";
	
	$results_pincodes = $this->db->query($sql_pincode);
	
	$results_pincode = $results_pincodes->result();
	
	
	$sql_state = 'select distinct status,label from sales_order_status';
		 
		$result_sql_state = $this->db->query($sql_state);
		 
		$result_state = $result_sql_state->result_array();
	  
	  if($_GET){
		  $val_dis="display:none";
	  }
	
	?>
<form  name="myForm"  action="<?php echo base_url();?>index.php/display_citydata/index" onsubmit="return validateForm()"   method="get" accept-charset='UTF-8'>
    <div class="seach_invoice_form  cf">
	
	</div>
	
	<div style="background-position: relative;    margin-top: -75px;    position: absolute;">
	
		<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="from date" value='<?php echo $_GET['todatepicker']; ?>'>
		
		<input id="fromdatepicker" name="fromdatepicker" class ='input_type1' type="text" name='to_date' placeholder="to date" value='<?php echo $_GET['fromdatepicker']; ?>'>
		
		<select class="input_type1" name="region[]"  class ='option_' id="region" multiple>
			<?php
				foreach($results_sql_region as $value){ 
					$select = '';
					if($value['region']!="" && $value['region']!="-" && $value['region']!="0"){
					
					if(isset($_GET) && !empty($_GET)){ 
						if (in_array($value['region'], $region)) {
							 
							$select= 'selected';
						}
					}
					 
			?>
					<option value="<?php echo trim($value['region']) ;?>" <?php echo $select ; ?>><?php echo ucwords(str_replace('_',' ',$value['region'])); ?></option>
			<?php
			}
				}
			?>
			
		</select>
		
		<!--select class="input_type1" name="product_type[]"  class ='option_' id="product_type" multiple>
			<?php
				foreach($result as $key => $product_type){ 
					$select = '';

					if(isset($_GET) && !empty($_GET)){ 
						if (in_array($result[$key]->product_type, $product_type)) {
							 
							$select= 'selected';
						}
					}else{	
						// if($states['status'] == 'complete' || $states['status'] == 'processing'){
							// $select= 'selected';
						// }
					}
					 
			?>
					<option value="<?php echo trim($result[$key]->product_type) ;?>" <?php echo $select ; ?>><?php echo ucwords(str_replace('_',' ',$result[$key]->product_type)); ?></option>
			<?php
				}
			?>
			
		</select-->
		
		
		<input id='city' name="city"  placeholder="city" width="50px" class ='input_type1' type="text" value='<?php echo $_GET['city']; ?>'>
		
		<input name="postcode" id='postcode' placeholder="postcode" width="50px" class ='input_type1' type="text" value='<?php echo $_GET['postcode']; ?>'>
		
		 <select class="input_type1" name="address_type" class ='option_' id="address_type">
		  <option value="billing">billing</option>
		  <option value="shipping">shipping</option>		 
		</select> 
		<select  name="order_status[]"  class ='option_' id="order_status" multiple>
			<?php
				foreach($result_state as $states){ 
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

<p style="padding: 5px 0 5px 5px; width:40%; float:left; "><a href="<?php echo base_url();?>index.php/display_citydata/index" style="font-size:16px;">Listing Page</a></p>

<?php 
 
	if($results_count == 0){ 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;">No Data Found!!!</div>';		
	}else{ 
	if($_GET){
		$order_status = implode(",", $order_status);
		$region = implode(",", $region);
		$csv_url = base_url('index.php/display_citydata/getCsv?todatepicker='.$_GET['todatepicker'].'&fromdatepicker='.$_GET['fromdatepicker'].'&postcode='.$_GET['postcode'].'&city='.$_GET['city'].'&order_status='.$order_status.'&region='.trim($region).'  '); 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;"><b>Result Counts '. $results_count.'</b></div>';
		//echo '<div style="color:#d83c3c;"><b>Result Counts '. $results_count.'</b></div>';
		
		echo '<a style="width: 120px;  color: #d83c3c; font-size:16px; float: right;position: relative" href="'.$csv_url.'">download Export</a>' ;
		
	}
		
		
?>  <div style="padding-bottom: 20px; float:right;">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
	<br>
	
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<!--<th align="center">Order_Id</th>-->
				<th align="center">Customer Name</th>
				<th align="center">Product Name</th>
				<th align="center">Sku</th>
				<th align="center">Product Price</th>
				<th align="center">Pin Codes</th>
				<th align="center">Cities</th>
				<th align="center">States</th>
				<th align="center">IP Addresses</th>
						
			</tr>
		</thead>  
			
	<?php
	 
			foreach($search_data as $row){ 
				
				?>
					<tr>    
							<!--<td align="center"><b><?php //echo  $row['Order_Id'] ;?></td>-->
							<td align="center"><b><?php echo  $row['Custome_Name'] ;?></td>
							<td align="center"><b><?php echo  $row['Product_Name'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['Sku'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['base_price'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['postcode'] ;?></td>
							<td align="center"><b><?php echo  $row['city'] ;?></td>
							<td align="center"><b><?php echo  $row['default_name'] ;?></td>							
							<td align="center"><b><?php echo  $row['remote_ip']; ?></b></td>
							
					</tr>
				<?php   
			}
		 
	?>
	</table>
	<div style="margin-left:1053px; margin-block-end:60px;">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
<?php  } ?> 

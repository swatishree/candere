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
		
		$sql = 'select distinct state from sales_order_status_state where state IN ("complete","processing")';
		 
		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
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
jQuery(function(){
	jQuery( "#todatepicker" ).datepicker({ dateFormat: 'yy-mm-dd', maxDate: new Date() });
	jQuery( "#fromdatepicker" ).datepicker({ dateFormat: 'yy-mm-dd' ,maxDate: new Date() });			
});
</script>

	
<?php
	$date_from 	= '';
	$date_to 	= '';
	if(isset($_POST) && !empty($_POST)){
		$date_from 		= $_POST['date_from'];
		$date_to 		= $_POST['date_to']; 
		$order_status 	= $_POST['order_status'];  
		$city 			= $_POST['city'];  
		$region 		= $_POST['region'];  
		$country_id 	= $_POST['country_id'];  
		$price 			= $_POST['price'];  
	}
?>

<form name="myForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" accept-charset='UTF-8'>
    <div class="seach_invoice_form">
	
			<input id="todatepicker" class ='input_type' type="text" name='date_from' placeholder="Created At from date" value='<?php echo $date_from; ?>'>
			
			<input id="fromdatepicker" class ='input_type1' type="text" name='date_to' placeholder="Created At to date" value='<?php echo $date_to; ?>'>
			
			<select name="price" id="price">
				<option value="">Select Price</option>
				<option value="less_than_15k" <?php if($price=='less_than_15k') echo 'selected'; ?> ><= Rs. 15,000</option>
				<option value="less_than_30k" <?php if($price=='less_than_30k') echo 'selected'; ?> ><= Rs. 30,000</option>
				<option value="less_than_50k" <?php if($price=='less_than_50k') echo 'selected'; ?> ><= Rs. 50,000</option>
				<option value="more_than_50k" <?php if($price=='more_than_50k') echo 'selected'; ?> >>= Rs. 50,000</option>
			</select>
			
			<input id="city" name="city" class ='input_type1' type="text" placeholder="City" value='<?php echo $city; ?>'>
		
			<input id="region" name="region" class ='input_type1' type="text" placeholder="State" value='<?php echo $region; ?>'>
		
			<input id="country_id" name="country_id" class ='input_type1' type="text" placeholder="Country" value='<?php echo $country_id; ?>'>
		
			<input id="postcode" name="postcode" class ='input_type1' type="text" placeholder="Pincode" value='<?php echo $postcode; ?>'>
			
			<select name="order_status[]" id="order_status" multiple>
			<?php
				foreach($result as $states){
					$select = '';
					if(isset($_POST) && !empty($_POST)){
						if (in_array($states['state'], $order_status)) {
							 
							$select= 'selected';
						}
					}else{	
						if($states['state'] == 'complete' || $states['state'] == 'processing'){
							$select= 'selected';
						}
					}
			?>
					<option value="<?php echo $states['state'] ;?>" <?php echo $select ; ?>><?php echo ucwords(str_replace('_',' ',$states['state'])); ?></option>
			<?php
				}
			?>
			
		</select>
		 
			<button  class="button_example"  type="submit">Search</button>			 
	</div>
	
</form>
 
 
 <?php 
	if(isset($_POST) && !empty($_POST)){
			
		$implode_state 	= implode("','",$_POST['order_status']);
		
		$date_from 		= strtotime($_POST['date_from']);
		$date_to 		= strtotime($_POST['date_to']);
	 
		$city 				= $_POST['city'];
		$region 			= $_POST['region'];
		$country_id 		= $_POST['country_id'];
		$postcode 			= $_POST['postcode'];
		$price 				= $_POST['price'];
		
		
		$from_date = date('Y-m-d',$date_from).' 00:00:00'; 
		$to_date = date('Y-m-d',$date_to).' 23:59:59'; 
		
				 
		if($from_date > $to_date){
			echo 'date from should be less than date to';
		}else{
		
			
			$sql ="SELECT a.name AS name,
				   a.product_id AS product_id,
				   a.sku AS sku,
				   b.state AS state,
				   b.status AS status,
				   b.affiliate_id AS affiliate_campaign,				   
				   sales_flat_order_address.email,
				   sales_flat_order_address.city,
				   sales_flat_order_address.country_id,
				   sales_flat_order_address.region,
				   sales_flat_order_address.postcode,
				   sales_flat_order_address.telephone,
				   b.increment_id,
				   b.customer_firstname,
				   b.customer_lastname,
					a.product_options,
				   a.base_price
			  FROM    (sales_flat_order_item a
					   INNER JOIN
						  sales_flat_order b
					   ON (a.order_id = b.entity_id))
				   INNER JOIN
					  sales_flat_order_address sales_flat_order_address
				   ON (sales_flat_order_address.parent_id = b.entity_id)
			 WHERE     a.created_at between '$from_date' and '$to_date'";
			
			if(!empty($city)){
				$sql  		.= " AND sales_flat_order_address.city like ('%$city%')"; 
			}
			
			if(!empty($region)){
				$sql  		.= " AND sales_flat_order_address.region like ('%$region%')"; 
			}
			
			if(!empty($postcode)){
				$sql  		.= " AND sales_flat_order_address.postcode like ('%$postcode%')"; 
			}
			
			if(!empty($price)) {
				if($price == 'less_than_15k'){
					$sql  		.= " AND a.base_price <=15000 "; 				
				}else if($price == 'less_than_30k'){
					$sql  		.= " AND a.base_price <=30000 "; 				
				}else if($price == 'less_than_50k'){
					$sql  		.= " AND a.base_price <=50000 ";
				}else if($price == 'more_than_50k'){
					$sql  		.= " AND a.base_price >=50000 ";
				}
			}
			
			if(!empty($country_id)){
			
				$countryList = Mage::getResourceModel('directory/country_collection')
								->loadData()
								->toOptionArray(false);
				$needle = $country_id;
				
				$country_name = '';
							
				foreach ($countryList as $key => $val) 
				{
				   if (strtolower($val['label']) === strtolower($needle)) {
					   $country_name = $val['value'];
					   break;
				   }
				}
				  
				$sql  		.= " AND sales_flat_order_address.country_id like ('%$country_name%')"; 
			}
				
			$sql .= "GROUP BY a.sku ORDER BY sku ASC";
			
			$results = $this->db->query($sql);  
			
			//echo $this->db->last_query(); exit;
			
			$result = $results->result_array();
			
			//echo '<pre>'; print_r($result);	echo '</pre>'; exit;
			
			if($result) { ?>
			
				<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
					<thead>
						<tr>
							<th align="center">Name</th>							
							<th align="center">sku</th>							
							<th align="center">Product Type</th>							
							<th align="center">Metal</th>							
							<th align="center">Product Price</th>							
							<th align="center">Order Id</th> 
							<th align="center">Order State</th> 
							<th align="center">Order Status</th> 
							<!--<th align="center">Qty Ordered</th> -->
							<th align="center">Category Name</th> 
							<th align="center">Email Id</th> 
							<th align="center">Firstname</th> 
							<th align="center">Lastname</th> 							
							<th align="center">Phone Number</th> 							
							<th align="center">City</th> 							
							<th align="center">State</th> 
							<th align="center">Country</th> 
							<th align="center">Pincode</th> 
							<th align="center">Affiliate</th> 
						</tr>
					
					<?php foreach($result as $row) { 
					
						
						$_product 	= Mage::getModel('catalog/product')->load($row['product_id']);  
					
						$categoryIds 	= 	$_product->getCategoryIds();	
						foreach($categoryIds as $_category) {
							$_categ = Mage::getModel('catalog/category')->load($_category);
							$cat_array[$_categ->getLevel()] = $_categ->getPath();
						}
						krsort($cat_array);
						reset($cat_array);
						$a = current($cat_array);
						unset($cat_array);
						$a_cat = explode('/',$a);
						
						$categoryName = '';
						foreach($a_cat as $value) {
							if($value!=1 && $value!=2)
							{
								$_category 		= Mage::getModel('catalog/category')->load($value);
								$categoryName .= ' > '.$_category->getName();
							}
						}
						unset($a_cat);
						$categoryName = ltrim($categoryName, " > ");
						
						
						$country = Mage::getModel('directory/country')->loadByCode($row['country_id']);
						
						$candere_product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(),'candere_product_type');
						
						$product_options = unserialize($row['product_options']);
						
						//echo '<pre>'; print_r($product_options);	echo '</pre>'; exit;
						
						$metal = $product_options['info_buyRequest']['extra_options']['Metal'];
						
					?>
						<tr>
							<th align="center"><?php echo $row['name'] ?></th>
							<th align="center"><?php echo $row['sku'] ?></th>
							<th align="center"><?php echo $candere_product_type ?></th>
							<th align="center"><?php echo $metal ?></th>
							<th align="center"><?php echo $row['base_price'] ?></th>
							<th align="center"><?php echo $row['increment_id'] ?></th>
							<th align="center"><?php echo $row['state'] ?></th>
							<th align="center"><?php echo $row['status'] ?></th>
							<!--<th align="center"><?php //echo floor($row['qty_ordered']) ?></th> -->
							<th align="center"><?php echo $categoryName ?></th> 							
							<th align="center"><?php echo $row['email'] ?></th> 
							<th align="center"><?php echo $row['customer_firstname'] ?></th> 
							<th align="center"><?php echo $row['customer_lastname'] ?></th> 
							<th align="center"><?php echo $row['telephone'] ?></th> 
							<th align="center"><?php echo $row['city'] ?></th> 
							<th align="center"><?php echo $row['region'] ?></th> 
							<th align="center"><?php echo $country->getName() ?></th> 
							<th align="center"><?php echo $row['postcode'] ?></th> 
							<th align="center"><?php echo $row['affiliate_campaign'] ?></th> 
							
						</tr>
					<?php } ?>
					</thead> 
				</table>
			
			<?php
				
			}
		
		}
	
	}
	?>

	
	
	 
 

<?php $this->load->library('session'); ?>
<script>
jQuery(function() {
jQuery( "#date_from" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'
	});
jQuery( "#date_to" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'
	});
});
</script>
<br> 

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_cart_products/export_cart_products_data">Export Cart Products</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_cart_products/export_service_enquiry">Export Service Enquiry</a></h1> <br>  

<style>
	.search_term, .hasDatepicker{height: 28px; width: 130px;}
	.btn_sub {  width: 100px; height: 30px;
</style>


<?php 
	$search_term = '';
	
	if(isset($_POST) && !empty($_POST)){
		
		$search_term 	= $_POST['search_term'];
		$date_from 		= $_POST['date_from'];
		$date_to 		= $_POST['date_to'];
		
		$mysql_date_from = strtotime(date('Y-m-d', strtotime($date_from)));
		$mysql_date_to = strtotime(date('Y-m-d', strtotime($date_to)));
			 
		if($mysql_date_from > $mysql_date_to){
			echo '<p style="color:red;text-align:center;">From date should be less than date to</p>';
		}
	
		$this->session->set_userdata(array(
				'search_term'   => $search_term,
				'date_from'     => $date_from,
				'date_to'       => $date_to,
		));
		$session_search_term   	= $this->session->userdata('search_term');
		$session_date_from   	= $this->session->userdata('date_from');
		$session_date_to  		= $this->session->userdata('date_to');
	 
	if($search_term == 'cart_aban'){
		 
		$sql = "SELECT sales_flat_quote_item.product_id,
       sales_flat_quote_item.sku,
       sales_flat_quote_item.name,
       sales_flat_quote_item.weight,
       sales_flat_quote_item.qty,
       sales_flat_quote_item.price,
       sales_flat_quote_item.base_price,
       sales_flat_quote_item.discount_amount,
       sales_flat_quote_item.product_type,
       sales_flat_quote_item.created_at,
       sales_flat_quote_item.updated_at,
       sales_flat_quote.customer_id,
       sales_flat_quote.customer_firstname,
       sales_flat_quote.customer_lastname,
       sales_flat_quote.customer_email,
       sales_flat_quote.customer_mobile,
       sales_flat_quote.items_qty,
       sales_flat_quote.items_count,
       sales_flat_quote.entity_id,
       sales_flat_quote.reserved_order_id,
       sales_flat_quote.affiliate_id
  FROM    sales_flat_quote_item sales_flat_quote_item
       INNER JOIN
          sales_flat_quote sales_flat_quote
       ON (sales_flat_quote_item.quote_id = sales_flat_quote.entity_id)
 WHERE sales_flat_quote.reserved_order_id IS NULL AND  Date(sales_flat_quote_item.updated_at) between '$date_from' AND '$date_to' order by sales_flat_quote_item.updated_at DESC";
 
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		if(count($result) > 0){
		
		$result_table = "<table border='1' cellpadding='5' cellspacing='0' style='margin:0 auto; text-align: center;'>
			<tr>
				<th>Id</th>
				<th>Sku</th>
				<th>Product Name</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Created On</th>
				<th>Customer Name</th>
				<th>Customer Email</th>
				<th>Affiliate Id</th>
			</tr>";
		
			$count=1;
			foreach($result as $rslt) {	
			$result_table .= "<tr>
						<th>".$count."</th>
						<td>".$rslt['sku']."</td> 
						<td>".$rslt['name']."</td>
						<td>".$rslt['qty']."</td> 
						<td>".number_format($rslt['base_price'],2)."</td> 
						<td>".$rslt['updated_at']."</td> 
						<td>".$rslt['customer_firstname'] .' '. $rslt['customer_lastname']."</td>
						<td>".$rslt['customer_email']."</td>
						<td>".$rslt['affiliate_id']."</td>
					</tr>";
				$count++;
			}
			
		$result_table .="</table>";
		}else{
			echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
		}
		
	} else if($search_term == 'service_enquiry'){
		
		$sql = "SELECT customer_queries.name,
       customer_queries.email,
       customer_queries.contact_no,
       customer_queries.flag,
       customer_queries.product_name,
       customer_queries.created_at,
       customer_queries.affiliate_id,
       catalog_product_entity_varchar.entity_id,
       catalog_product_entity.sku
  FROM    (   catalog_product_entity_varchar catalog_product_entity_varchar
           RIGHT OUTER JOIN
              catalog_product_entity catalog_product_entity
           ON (catalog_product_entity_varchar.entity_id =
                  catalog_product_entity.entity_id))
       RIGHT OUTER JOIN
          customer_queries customer_queries
       ON (customer_queries.product_name =
              catalog_product_entity_varchar.value)
 WHERE     (catalog_product_entity_varchar.attribute_id = 71)
 AND Date(customer_queries.created_at) between '$date_from' AND '$date_to'
ORDER BY customer_queries.created_at DESC";
		$service_results 	= $this->db->query($sql);
		$service_result 	= $service_results->result_array();
		 
		if(count($service_result) > 0){
		
			$result_table .= "<table border='1' cellpadding='5' cellspacing='0' style='margin:0 auto; text-align: center;'>
				<tr>
					<th>Id</th>
					<th>Customer Name</th>
					<th>Customer Email</th>
					<th>Contact No</th>
					<th>Type</th>
					<th>Product Name</th>
					<th>Created At</th>
					<th>Affiliate Id</th>
				</tr>";
			
				$counter =1;
						foreach($service_result as $row){
			
						$result_table .= "<tr>
							<th>".$counter."</th>
							<td>".$row['name']."</td> 
							<td>".$row['email']."</td>
							<td>".$row['contact_no']."</td> 
							<td>".$row['flag']."</td> 
							<td>".$row['product_name']."</td> 
							<td>".$row['created_at']."</td> 
							<td>".$row['affiliate_id']."</td> 
						</tr>";
						$counter++;
					}
				$result_table .= "</table>";
		}else{
				echo '<div style="margin:0 auto; text-align: center;"><h1>No Records Found!!!</h1></div>';
			}
		} 
	}
?>  
	
<div style="margin:0 auto; text-align: center;">
<h2>Search Add to cart products / Customer Enquiry</h2>

<form name="cart_form" id="cart_form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<label for="search_term"><b>Select Term</b></label>

<?php
$search_type=array(
		''=>'Select Term',
		'cart_aban'=>'Cart Abandoned',
		'service_enquiry'=>'Service Enquiry'
	   );
echo form_dropdown('search_term',$search_type, $session_search_term,'id="search_term" class="search_term"');?>

&nbsp;&nbsp;&nbsp;
<input type="text" name="date_from" id="date_from" value="<?php echo $session_date_from ?>" placeholder="Date From"/>
 &nbsp;&nbsp;&nbsp;
<input type="text" name="date_to" id="date_to" value="<?php echo $session_date_to ?>" placeholder="Date To"/>
	

<br><br>
<input type="submit" name="submit" value="submit" class="btn_sub">
<br>
</form>
</div>

<?php echo $result_table; ?>
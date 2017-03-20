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
	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style>  

<table width="100%" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th align="center">
				Order Id
			</th>
			<th align="center">
				Invoice Number
			</th>
			<th align="center">
				Invoice Date
			</th>
			<th align="center">
				Previous Invoice Number
			</th>
			<th align="center">
				Product Name
			</th> 
			<th align="center">
				Grand Total(Base Currency)
			</th> 
			<th align="center">
				Grand Total(Order Currency)
			</th>   
			<th align="center">
				Bill To
			</th>
			<th align="center">
				Order Status
			</th>
			<th align="center">
				Action
			</th>			
		</tr>
	</thead> 
<?php

	$sql = "SELECT candere_invoice.id,
       candere_invoice.invoice_no,
       candere_invoice.previous_invoice_num,
       candere_invoice.invoice_date,
       sales_flat_order.base_grand_total,
       sales_flat_order.grand_total,
       sales_flat_order.increment_id,
       sales_flat_order.customer_firstname,
       sales_flat_order.customer_lastname,
       catalog_product_entity_varchar.value AS name,
       sales_order_status.label AS status,
       sales_flat_order_address.address_type,
       sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       concat(sales_flat_order_address.firstname,
              ' ',
              sales_flat_order_address.lastname)
          AS bill_to
  FROM    (   (   (   candere_invoice candere_invoice
                   INNER JOIN
                      catalog_product_entity_varchar catalog_product_entity_varchar
                   ON (candere_invoice.product_id =
                          catalog_product_entity_varchar.entity_id))
               INNER JOIN
                  sales_flat_order sales_flat_order
               ON (candere_invoice.order_id = sales_flat_order.entity_id))
           INNER JOIN
              sales_order_status sales_order_status
           ON (sales_flat_order.status = sales_order_status.status))
       INNER JOIN
          sales_flat_order_address sales_flat_order_address
       ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
 WHERE (    sales_flat_order_address.address_type = 'billing'
        AND catalog_product_entity_varchar.attribute_id = 71)
ORDER BY candere_invoice.invoice_date DESC limit $start, $limit" ; 
 

 
  $results = $this->db->query($sql); 
   
		
 $result = $results->result_array() ;

 foreach($result as $rslt){  
	
		$update_url = base_url('index.php/display_invoices/update_invoice_num?increment_id='.$rslt['increment_id'].'&invoice_num='.$rslt['invoice_no'].'&id='.$rslt['id'].'  ');
	
		$delete_url = base_url('index.php/display_invoices/delete_invoice?id='.$rslt['id'].'&user=admin');
		
		$user = $this->input->get('user');
  ?>
 
		<tr>
			<td align="center"><?php echo  $rslt['increment_id'] ;?></td>
			<td align="center"><b><?php echo  $rslt['invoice_no'] ;?></b></td>
			<td align="center"><b><?php echo  date('j/m/Y',$rslt['invoice_date']) ;?></b></td>
			<td align="center"><b><?php echo  $rslt['previous_invoice_num'] ;?></b></td>
			<td align="left"><?php echo  $rslt['name'] ;?></td> 
			<td align="left"><?php echo  $rslt['base_grand_total'] ;?></td>
			<td align="left"><?php echo  $rslt['grand_total'] ;?></td>
			<td align="left"><?php echo  $rslt['bill_to'] ;?></td>
			<td align="left"><?php echo  $rslt['status'] ;?></td>
			
			
			<td align="left"><?php echo $key. '<a href="'.$update_url.'">Update</a>' ;?> 
			<?php if($user=='admin') {
							echo $key. '&nbsp;&nbsp;<a href="'.$delete_url.'">Delete</a>' ;
					}
			?>
		</td> 
			
			
		</tr>
 
 <?php 
	
 } ?>  


   
</table>  

<?php  echo $this->pagination->create_links(); ?>

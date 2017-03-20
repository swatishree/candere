<html>
	<form  style = "text-align:center ;" name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
order no: <input type="text" name="orderno" value="<?php if(isset($_POST) && !empty($_POST)){ echo $orderno ; } ?>"><br/><br/>
 
<input type="submit" name="submit" value="submit">
</form>
</html>
<?php

Mage::register('isSecureArea', true); 
 	if(isset($_POST) && !empty($_POST)){
	
	 date_default_timezone_set('Asia/Kolkata');
	$orderno 	= $_POST['orderno'];
	$order = Mage::getModel('sales/order')->loadByIncrementId($orderno);
	//print_r($order);
	// echo $order->getIncrementId();
	// exit ;
	  $sql = 'select status,created_at ,comment from sales_flat_order_status_history where parent_id='.$order->getEntityId();
		 
		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		// echo '<pre>' ;
	 // print_r($result);
	 // echo '</pre>' ;
	
	
	 ?>
	 <h2 style="text-align:center ;">
	 <?php 
	  echo 'order status history for order no '.$orderno ; ?>
	  </h2>
	 <table border=1 align="center" cellpadding="10" style="border-collapse:collapse ;" >
	 
	 <tr><th>status</th><th>date</th><th>comment</th></tr>
	 <?php
	 foreach($result as $res)
	 
	 {  ?>
	   <tr>
	   <?php
		foreach($res as $key=>$value)
		{ ?>
			
			
			 
			<td><?php echo $value ; ?></td>
			 
			
			
			
		<?php
		}  ?>
</tr>

		 
		 
		<?php } ?>

 </table> 
 
 <?php
		
	 
	}
 
       
		
	 
		 
?>

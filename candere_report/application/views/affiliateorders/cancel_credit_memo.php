<?php
Mage::register('isSecureArea', true); 
 	if(isset($_POST) && !empty($_POST)){
	
	$order_status 	= $_POST['order_status'];
	$order_state 	= $_POST['order_state'];
	$orderno 	= $_POST['orderno'];
	$order = Mage::getModel('sales/order')->loadByIncrementId($orderno);
	 
	$creditMemos = $order->getCreditmemosCollection();
	foreach($creditMemos as $cm){ 
		$state = $cm->getState();
		if($state == 3){//Cancelled
			continue;
		}
		 	
		$cm->cancel()
			->save()
			->getOrder()->save();	 

		$cm->delete();
	} 
	
	$order->setBaseDiscountRefunded(0)
			->setBaseShippingRefunded(0)
			->setBaseSubtotalRefunded(0)
			->setBaseTaxRefunded(0)
			->setBaseShippingTaxRefunded(0)
			->setBaseTotalOnlineRefunded(0)
			->setBaseTotalOfflineRefunded(0)
			->setBaseTotalRefunded(0)
			->setTotalOnlineRefunded(0)
			->setTotalOfflineRefunded(0)
			->setDiscountRefunded(0)
			->setShippingRefunded(0)
			->setShippingTaxRefunded(0)
			->setSubtotalRefunded(0)
			->setTaxRefunded(0)
			->setTotalRefunded(0)->save();
			
	//$order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true)->save();
	//$order->setStatus('complete_shippment_confirmed')->save();	
	
	$order->setData('state', $order_state)->save();
    $order->setStatus($order_status)->save();      
	
	$ordered_items = $order->getAllItems();
	
	foreach($ordered_items as $item){     
		$item->setQtyRefunded(0);
		$item->setTaxRefunded(0);
		$item->setBaseTaxRefunded(0);
		$item->setHiddenTaxRefunded(0);
		$item->setBaseHiddenTaxRefunded(0);
		$item->setAmountRefunded(0);
		$item->setBaseAmountRefunded(0);
		$item->setDiscountRefunded(0);
		$item->setBaseDiscountRefunded(0);
		$item->save();
	}
	}
 
        $sql = 'select distinct state from sales_order_status_state';
		 
		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		
	 
		
		
		$sql1 = 'select distinct label ,status from sales_order_status';
		 
		$results1 = $this->db->query($sql1);
		 
		$result1 = $results1->result_array();
		 
?>
<html>
	<form name="frm" method="post" id="frm" action="<?php echo $_SERVER['PHP_SELF']?>">
order no: <input type="text" name="orderno"><br/><br/>
state 
	<select name="order_state" id="order_state">
	<option selected>select state</option>
			<?php
			foreach($result as $states){
				?>
					<option value="<?php echo $states['state'] ;?>"><?php echo ucwords(str_replace('_',' ',$states['state'])); ?></option>
			<?php
				}
			?>
			
			
			
		</select> <br/><br/>
status:
<select name="order_status" id="order_status">
<option selected>select status</option>
			<?php
				foreach($result1 as $status){
			?>
					<option value="<?php echo $status['status'] ;?>"><?php echo $status['label']; ?></option>
			<?php
				}
			?>
			
			
			
		</select> <br/><br/>
<input type="submit" name="submit" value="submit">
</form>
</html>
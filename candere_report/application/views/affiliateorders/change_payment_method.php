<?php
Mage::register('isSecureArea', true); 
$orderId = '70408'; // Incremented Order Id
$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
$payment = $order->getPayment();
$payment->setMethod('cod'); // Assuming 'test' is updated payment method
$payment->save();
$order->save();
<?php

class Payu_PayuCheckout_Model_Shared extends Mage_Payment_Model_Method_Abstract {

    protected $_code = 'payucheckout_shared';
    protected $_isGateway = false;
    protected $_canAuthorize = false;
    protected $_canCapture = true;
    protected $_canCapturePartial = true;
    protected $_canRefund = true;
    protected $_canVoid = true;
    protected $_canUseInternal = true;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canRefundInvoicePartial = true;
    protected $_formBlockType = 'payucheckout/shared_form';
    protected $_paymentMethod = 'shared';
    protected $_order;

    public function cleanString($string) {

        $string_step1 = strip_tags($string);
        $string_step2 = nl2br($string_step1);
        $string_step3 = str_replace("<br />", "<br>", $string_step2);
        $cleaned_string = str_replace("\"", " inch", $string_step3);
        return $cleaned_string;
    }

    /**
     * Get checkout session namespace
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current quote
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote() {
        return $this->getCheckout()->getQuote();
    }

    /**
     * Get order model
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder() {
        if (!$this->_order) {
            $paymentInfo = $this->getInfoInstance();
            $this->_order = Mage::getModel('sales/order')
                    ->loadByIncrementId($paymentInfo->getOrder()->getRealOrderId());
        }
        return $this->_order;
    }

    public function getCustomerId() {
        return Mage::getStoreConfig('payment/' . $this->getCode() . '/customer_id');
    }

    public function getAccepteCurrency() {
        return Mage::getStoreConfig('payment/' . $this->getCode() . '/currency');
    }

    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('payucheckout/shared/redirect');
    }

    /**
     * prepare params array to send it to gateway page via POST
     *
     * @return array
     */
    public function getFormFields() {

        $billing = $this->getOrder()->getBillingAddress();
        $coFields = array();
        $items = $this->getQuote()->getAllItems();
		
		//echo 'getId ' . $this->getQuote()->getId(); exit;
		$payment = $this->getQuote()->getPayment();
        

		$diamond_gemstone_product = 0 ;
		
		$diamond_offer 	= 0;
		$gold_offer 	= 0;
		
        if ($items) {
            $i = 1; 
            foreach ($items as $item) {
                if ($item->getParentItem()) {
                    continue;
                }
				
				$_product = Mage::getModel('catalog/product')->load($item->getProduct_id()) ;  
				
				if($_product->getDiscardFromPriceRules() == 1 && $item->getPrice() > 0){ 
					$diamond_gemstone_product = 1; 
					$gold_offer = 1;
				}else if($_product->getDiscardFromPriceRules() == 0 && $item->getPrice() > 0) {
					$diamond_offer = 1;
				}
				
				unset($_product);			 
				
                $coFields['c_prod_' . $i] = $this->cleanString($item->getSku());
                $coFields['c_name_' . $i] = $this->cleanString($item->getName());
                $coFields['c_description_' . $i] = $this->cleanString($item->getDescription());
                $coFields['c_price_' . $i] = number_format($item->getPrice(), 2, '.', '');
                $i++;
            }
        }

        $request = '';
        foreach ($coFields as $k => $v) {
            $request .= '<' . $k . '>' . $v . '</' . $k . '>';
        }


        $key = Mage::getStoreConfig('payment/payucheckout_shared/key');
        $salt = Mage::getStoreConfig('payment/payucheckout_shared/salt');
        $debug_mode = Mage::getStoreConfig('payment/payucheckout_shared/debug_mode');

        $orderId = $this->getOrder()->getRealOrderId();

        $txnid = $orderId . 'candere';

        $coFields['key'] 			= $key;
        $coFields['txnid'] 			= $txnid;

        $coFields['amount'] 		= number_format($this->getOrder()->getBaseGrandTotal(), 0, '', '');
        $coFields['productinfo'] 	= 'Product Information';
        $coFields['firstname'] 		= $billing->getFirstname();
        $coFields['Lastname'] 		= $billing->getLastname();
        $coFields['City'] 			= $billing->getCity();
        $coFields['State'] 			= $billing->getRegion();
        $coFields['Country'] 		= $billing->getCountry();
        $coFields['Zipcode'] 		= $billing->getPostcode();
        $coFields['email']        	= $this->getOrder()->getCustomerEmail();
        $coFields['phone']        	= $billing->getTelephone(); 

        //$coFields['email'] = 'payu@candere.com';
        

		$coFields['enforce_paymethod']        = 'netbanking|debitcard|creditcard'; 
		
        $coFields['surl'] = Mage::getBaseUrl() . 'payucheckout/shared/success/';
        $coFields['furl'] = Mage::getBaseUrl() . 'payucheckout/shared/failure/';
        $coFields['curl'] = Mage::getBaseUrl() . 'payucheckout/shared/canceled/id/' . $this->getOrder()->getRealOrderId();
 
        //$coFields['Pg'] = 'CC';
				
		$bank_code 		= $payment->getBank_code();
        $pg 			= $payment->getPg();
        $drop_category 	= $payment->getDrop_category();
		
		$coFields['Pg'] 			= $pg;
		$coFields['bank_code'] 		= $bank_code;
        $coFields['drop_category'] 	= $drop_category;
				
		$offer_id 		= Mage::getStoreConfig('payment/payucheckout_shared/offers');
		$gold_offer_id 	= Mage::getStoreConfig('payment/payucheckout_shared/gold_offers');
		
		if($diamond_gemstone_product == 0 && !empty($offer_id)){
			$coFields['offer_key'] = Mage::getStoreConfig('payment/payucheckout_shared/offers');
		}
		
		if($diamond_gemstone_product == 1 && !empty($gold_offer_id)){
			$coFields['offer_key'] = Mage::getStoreConfig('payment/payucheckout_shared/gold_offers');
		}
		
		if($gold_offer==1 &&  $diamond_offer ==1) {
			$coFields['offer_key'] = Mage::getStoreConfig('payment/payucheckout_shared/gold_offers');
		}else if($gold_offer==1 &&  $diamond_offer ==0) {
			$coFields['offer_key'] = Mage::getStoreConfig('payment/payucheckout_shared/gold_offers');
		}else if($gold_offer==0 &&  $diamond_offer ==1) {
			$coFields['offer_key'] = Mage::getStoreConfig('payment/payucheckout_shared/offers');
		}else {
			$coFields['offer_key'] = '';
		}
		
		//echo $coFields['offer_key']; exit;
		
		$checkcouponCode = Mage::getSingleton('checkout/session')->getQuote()->getCouponCode();
			 
			 // if($checkcouponCode)
			       // {
				    // $coFields['offer_key'] = '' ;
              
					// }
					 
					
					 if($checkcouponCode && $checkcouponCode!='FLEUR1K')
			       {
				    $coFields['offer_key'] = '' ;
              
					}
					 if($checkcouponCode && $checkcouponCode=='MC10')
			       {
				    $coFields['offer_key'] = 'Master Card Diamond@2145' ;
              
					}
					 if($checkcouponCode && ($checkcouponCode=='TC524181' || $checkcouponCode=='TC522852' || $checkcouponCode=='TC541919'))
			       {
				    $coFields['offer_key'] = 'Times Card Diamond@2147' ;
              
					}
					

             if ($items) {
				 
            $i = 1; 
            foreach ($items as $item) {
                if ($item->getParentItem()) {
                    continue;
                }
				
				$_product = Mage::getModel('catalog/product')->load($item->getProduct_id()) ;  
				
				  $product_type 		= Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(),'candere_product_type'); 
				if($product_type == 'Coins')
				 {
					
					 $coFields['offer_key'] = '' ;
					 
				 }
				unset($_product);			 
				
               
            }
        }					
		
		
		$debugId = '';
		 
        if ($debug_mode == 1) {

            $requestInfo = $key . '|' . $coFields['txnid'] . '|' . $coFields['amount'] . '|' .
                    $coFields['productinfo'] . '|' . $coFields['firstname'] . '|' . $coFields['email'] . '|' . $debugId . '||||||||||' . $salt;
            $debug = Mage::getModel('payucheckout/api_debug')
                    ->setRequestBody($requestInfo)
                    ->save();

            $debugId = $debug->getId();

            $coFields['udf1'] = $debugId;
            $coFields['Hash'] = hash('sha512', $key . '|' . $coFields['txnid'] . '|' . $coFields['amount'] . '|' .
                    $coFields['productinfo'] . '|' . $coFields['firstname'] . '|' . $coFields['email'] . '|' . $debugId . '||||||||||' . $salt);
        } else {
            $coFields['Hash'] = strtolower(hash('sha512', $key . '|' . $coFields['txnid'] . '|' . $coFields['amount'] . '|' .
                            $coFields['productinfo'] . '|' . $coFields['firstname'] . '|' . $coFields['email'] . '|||||||||||' . $salt));
        }
		
	  // echo '<pre>';
	  // print_r($coFields);
	  // echo '</pre>';
	  // exit ;
        return $coFields;
    }

    /**
     * Get url of Payu payment
     *
     * @return string
     */
    public function getPayuCheckoutSharedUrl() {
        $mode = Mage::getStoreConfig('payment/payucheckout_shared/demo_mode');

        $url = 'https://test.payu.in/_payment.php';

        if ($mode == '') {
            $url = 'https://secure.payu.in/_payment.php';
        }

        return $url;
    }

    /**
     * Get debug flag
     *
     * @return string
     */
    public function getDebug() {
        return Mage::getStoreConfig('payment/' . $this->getCode() . '/debug_flag');
    }

    public function capture(Varien_Object $payment, $amount) {
        $payment->setStatus(self::STATUS_APPROVED)
                ->setLastTransId($this->getTransactionId());

        return $this;
    }

    public function cancel(Varien_Object $payment) {
        $payment->setStatus(self::STATUS_DECLINED)
                ->setLastTransId($this->getTransactionId());

        return $this;
    }

    /**
     * parse response POST array from gateway page and return payment status
     *
     * @return bool
     */
    public function parseResponse() {

        return true;
    }

    /**
     * Return redirect block type
     *
     * @return string
     */
    public function getRedirectBlockType() {
        return $this->_redirectBlockType;
    }

    /**
     * Return payment method type string
     *
     * @return string
     */
    public function getPaymentMethodType() {
        return $this->_paymentMethod;
    }

    public function getResponseOperation($response) {
        $order = Mage::getModel('sales/order');
        $debug_mode = Mage::getStoreConfig('payment/payucheckout_shared/debug_mode');
        $key = Mage::getStoreConfig('payment/payucheckout_shared/key');
        $salt = Mage::getStoreConfig('payment/payucheckout_shared/salt');
        if (isset($response['status'])) {
            $txnid = $response['txnid'];

            $orderid = substr($txnid, 0, strpos($txnid, 'candere'));
            if ($response['status'] == 'success') {
                $status = $response['status'];
                $order->loadByIncrementId($orderid);
                $billing = $order->getBillingAddress();
                $amount = $response['amount'];
                $productinfo = $response['productinfo'];
                $firstname = $response['firstname'];
                $email = $response['email'];
                $keyString = '';
                $Udf1 = $response['udf1'];
                $Udf2 = $response['udf2'];
                $Udf3 = $response['udf3'];
                $Udf4 = $response['udf4'];
                $Udf5 = $response['udf5'];
                $Udf6 = $response['udf6'];
                $Udf7 = $response['udf7'];
                $Udf8 = $response['udf8'];
                $Udf9 = $response['udf9'];
                $Udf10 = $response['udf10'];
                if ($debug_mode == 1) {
                    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $Udf1 . '|' . $Udf2 . '|' . $Udf3 . '|' . $Udf4 . '|' . $Udf5 . '|' . $Udf6 . '|' . $Udf7 . '|' . $Udf8 . '|' . $Udf9 . '|' . $Udf10;
                } else {
                    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $Udf1 . '|' . $Udf2 . '|' . $Udf3 . '|' . $Udf4 . '|' . $Udf5 . '|' . $Udf6 . '|' . $Udf7 . '|' . $Udf8 . '|' . $Udf9 . '|' . $Udf10;
                }

                $keyArray = explode("|", $keyString);
                $reverseKeyArray = array_reverse($keyArray);
                $reverseKeyString = implode("|", $reverseKeyArray);
                $saltString = $salt . '|' . $status . '|' . $reverseKeyString;
                $sentHashString = strtolower(hash('sha512', $saltString));
                $responseHashString = $_REQUEST['hash'];
                if ($sentHashString == $responseHashString) {
					$order->setTotalPaid($amount);
					$order->setBaseTotalPaid($amount);
					
                    $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true);
                    $order->save();
                    $order->sendNewOrderEmail();
					$payment = $order->getPayment();
					if($payment->getMethod() == 'voucherpayment'){
						try {
							/************voucher updates************/
							$resource = Mage::getSingleton('core/resource'); 
							$writeConnection = $resource->getConnection('core_write');
							$query = "UPDATE third_party_vouchers SET is_confirmed_order = 1 WHERE order_id = " . (int)$order->getId() ; 
							$writeConnection->query($query);
							/************voucher updates************/
						} catch (Exception $e) { }
					}
                } else {
                    $order->setState(Mage_Sales_Model_Order::STATE_NEW, true);
                    $order->cancel()->save();
                }

                if ($debug_mode == 1) {
                    $debugId = $response['udf1'];
                    $data = array('response_body' => implode(",", $response));
                    $model = Mage::getModel('payucheckout/api_debug')->load($debugId)->addData($data);
                    $model->setId($id)->save();
                }
            }

            if ($response['status'] == 'failure') {
                $order->loadByIncrementId($orderid);
                $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
                // Inventory updated 
                $this->updateInventory($orderid);

                $order->cancel()->save();

                if ($debug_mode == 1) {
                    $debugId = $response['udf1'];
                    $data = array('response_body' => implode(",", $response));
                    $model = Mage::getModel('payucheckout/api_debug')->load($debugId)->addData($data);
                    $model->setId($id)->save();
                }
            } else if ($response['status'] == 'pending') {
                $order->loadByIncrementId($orderid);
                $order->setState(Mage_Sales_Model_Order::STATE_NEW, true);
                // Inventory updated  
                $this->updateInventory($orderid);
                $order->cancel()->save();

                if ($debug_mode == 1) {
                    $debugId = $response['udf1'];
                    $data = array('response_body' => implode(",", $response));
                    $model = Mage::getModel('payucheckout/api_debug')->load($debugId)->addData($data);
                    $model->setId($id)->save();
                }
            }
        } else {

            $order->loadByIncrementId($response['id']);
            $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
            // Inventory updated 
            $order_id = $response['id'];
            $this->updateInventory($order_id);

            $order->cancel()->save();
        }
    }

    public function updateInventory($order_id) {

        $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
        $items = $order->getAllItems();
        foreach ($items as $itemId => $item) {
            $ordered_quantity = $item->getQtyToInvoice();
            $sku = $item->getSku();
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product->getId())->getQty();

            $updated_inventory = $qtyStock + $ordered_quantity;

            $stockData = $product->getStockItem();
            $stockData->setData('qty', $updated_inventory);
            $stockData->save();
        }
    }
	
	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}
		
		//echo '<pre>'; print_r($data->getData()); echo '</pre>'; exit;
				
		
		$info = $this->getInfoInstance();
		$info->setPg($data->getPg())
			->setBank_code($data->getBank_code())
			->setDrop_category($data->getDrop_category())
			;

		return $this;
	}

}

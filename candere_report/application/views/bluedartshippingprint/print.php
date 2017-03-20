<?php
$_order = Mage::getModel('sales/order')->load($order_id);


 $currentCurrencyCode = $_order->getOrderCurrencyCode(); 

$_shippingAddress = $_order->getShippingAddress();

$first_name = $_shippingAddress->getFirstname();
$last_name = $_shippingAddress->getLastname();
$street = $_shippingAddress->getStreetFull();
$region = $_shippingAddress->getRegion();
$city = $_shippingAddress->getCity();
$post_code = $_shippingAddress->getPostcode();
$telephone = $_shippingAddress->getTelephone();
$country_id = $_shippingAddress->getCountry_id();
?>
<style>
    table tr td{font-size:14px;}
    div{} 
</style>
<script type="text/javascript">
    function PrintDivOnly() {
        var divToPrint = document.getElementById('print_div');
        var popupWin = window.open('', '_blank');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()"><div id="print_div">' + divToPrint.innerHTML + '</div></body></html>');
        popupWin.document.close();
    }
</script>
<a title="Go Back to Orders" style="float: right;" href="<?php echo base_url(); ?>index.php/bluedartshippingprint/">Go Back to Orders</a>

<input name="b_print" style="float: right;margin-right: 30px;" type="button" class="ipt"  onClick="PrintDivOnly();" style="float:right;" value="Print This Now">
<br/><br/>
<div id="print_div">
    <table width="800" style="border: 1px solid;" cellpadding="5">
        <tr>
            <td style="border-bottom: 1px solid;"> 
                <table width="100%" >
                    <tr>
                        <td>
                            <img src="<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/default/candere/images/logobluedart.png'; ?>" alt="Candere.com"/> 
                        </td>
                        <td> 
                            <table>
                                <tr> 
                                    <td>
                                        <strong>Enovate Lifestyles Private Limited</strong>
                                    </td>
                                </tr>
                                <tr> 
                                    <td>
                                        601-602, Om Shakti Samrat CHS Ltd,
                                    </td>
                                </tr>
                                <tr> 
                                    <td>
                                        Plot No. 21,Shakti Niwas,Ramchandra Lane extn,Near Greater Bombay Co-op Bank,Kanchpada,
                                    </td>
                                </tr>
                                <tr> 
                                    <td>
                                        Mumbai - 400064,
                                    </td>
                                </tr>
                                <tr> 
                                    <td>
                                        Maharashtra, India
                                    </td>
                                </tr>
                                <tr> 
                                    <td>
                                        Tel: +91 22 61066262 
                                    </td>
                                </tr>
                            </table>  
                        </td>
                        <td style="border-left: 1px solid;">
                            <table>
                                <tr>
                                    <td>
                                        <b>Invoice No:</b>
                                    </td>
                                    <td>
                                        <?php echo date('Y', time()); ?> / <?php echo date('M', time()); ?> / <?php echo $invoice_no; ?>	 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Invoice Date:</b>
                                    </td>
                                    <td>
                                        <?php echo date('d/m/Y', time()); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>VAT No:</b> 
                                    </td>
                                    <td>
                                        27250999541V
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>CST No:</b> 
                                    </td>
                                    <td>
                                        27250999541C 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> 
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> 
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>  
                        </td>
                    </tr>
                </table>  
            </td>
        </tr> 

        <tr>
            <td style="border-bottom:1px solid;"> 
                <table width="100%">
                    <tr>
                        <td style="width: 268px; "> 
                            &nbsp;
                        </td> 
                        <td style="width: 510px; text-align: right;"> 
                            <table style="width: 100%;">
                                <tr>
                                    <td style="text-align: center;"> 
                                        <p style="font-size:25px">ORDER ID&nbsp;&nbsp;&nbsp;</p>
                                    </td> 
                                    <td style="text-align: center;"> 
                                        <?php  if($_order->getPayment()->getMethodInstance()->getCode() == 'cod'){ ?>
                                        <p style="font-size:26px">Cash On Delivery (COD)&nbsp;&nbsp;&nbsp;</p>
                                        <?php  }else{ ?>
                                        <p style="font-size:30px">PREPAID ORDER&nbsp;&nbsp;&nbsp;</p>
                                        <?php } ?>
                                    </td> 
                                </tr>
                                <tr>
                                    <td style="text-align: center;"> 
                                        <img src="<?php echo base_url() . 'uploads/barcode/' . $increment_id . '.jpg'; ?>" alt="<?php echo $increment_id; ?>"/>
                                    </td> 
                                    <td style="text-align: center;"> 
                                        <img src="<?php echo base_url() . 'uploads/barcode/' . $awb . '.jpg'; ?>" alt="<?php echo $awb; ?>"/>
                                    </td> 
                                </tr>
                            </table> 

                        </td> 
                    </tr>
                </table> 
            </td> 
        </tr>
       
        <tr>
            <td style="border-bottom:1px solid; text-align: right;"> 
                <table cellpadding="5">
                    <tr>
                        <td style="width: 510px;">
                            <table>
                                <tr>
                                    <td>
                                        <b>DELIVER TO</b>
                                    </td> 
                                </tr>
                                <tr>
                                    <td>
                                        <b><?php echo ucwords($first_name); ?> <?php echo ucwords($last_name); ?></b>
                                    </td> 
                                </tr>
                                <?php if (!empty($street)) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $street; ?>
                                        </td> 
                                    </tr> 
                                <?php } ?>
                                <tr>
                                    <td> 
                                        <?php if (!empty($city)) { ?>
                                            <?php echo $city; ?>, 
                                        <?php } ?>
                                        <?php if (!empty($region)) { ?>
                                            <?php echo $region; ?>, 
                                        <?php } ?>
                                        <?php if (!empty($country_id)) { ?>
                                            <?php echo $country_id; ?>
                                        <?php } ?>
                                    </td>
                                </tr> 

                                <tr>
                                    <?php if (!empty($post_code)) { ?>
                                        <td> 
                                            Pincode : <?php echo $post_code; ?> <b><?php echo $bluedart_pin; ?></b>
                                        </td>
                                    <?php } ?>
                                </tr> 


                                <tr>
                                    <?php if (!empty($telephone)) { ?>
                                        <td> 
                                            Tel no : <?php echo $telephone; ?>
                                        </td>
                                    <?php } ?>
                                </tr> 
                               <?php  if($_order->getPayment()->getMethodInstance()->getCode() == 'cod'){ ?>
                                    <tr>
                                        <td> 
                                            <strong style="font-size: 18px;">AMOUNT TO COLLECT <?php echo Mage::app()->getLocale()->currency($currentCurrencyCode)->toCurrency((int)$_order->getTotalDue())  ; ?></strong>
                                        </td>
                                    </tr> 
                               <?php    } else{ ?>
                                     
                                    <tr>
                                        <td> 
                                            <strong style="font-size: 27px;">NO AMOUNT TO BE COLLECTED</strong>
                                        </td>
                                    </tr>   
                                       
                               <?php   }   ?>     

                            </table>  
                        </td> 
                        <td style="width: 268px;">
                            <table style="text-align:left;">
                                <tr>
                                    <td>AWB No :</td> 
                                    <td>&nbsp;&nbsp;<?php echo $awb; ?></td> 
                                </tr>
                                <tr>
                                    <td>Weight :</td> 
                                    <td>&nbsp;&nbsp;500 GMS</td> 
                                </tr>
                                <tr>
                                    <td>Dimensions (Cms) :</td> 
                                    <td>&nbsp;&nbsp;18 X 12 X 5</td> 
                                </tr>
                                <tr>
                                    <td>Order ID :</td> 
                                    <td>&nbsp;&nbsp;<?php echo $increment_id; ?></td> 
                                </tr>
                                <tr>
                                    <td>Order Date :</td>
                                    <td>&nbsp;&nbsp;<?php echo date('d/m/Y', time()); ?></td>
                                </tr> 

                                <tr>
                                    <td>Piece(s) :</td>
                                    <td>&nbsp;&nbsp;1</td>
                                </tr>   

                            </table>  
                        </td> 
                    </tr>
                </table> 
            </td> 
        </tr>
         
        <tr>
            <td style="border-bottom:1px solid;"> 
                <table style="width: 100%;" cellpadding="5">  
                    <tr>
                        <th>
                        <td style="text-align:center;">
                            Sr. No.
                        </td> 
                        </th>
                        <th>
                        <td>
                            Item Description
                        </td> 
                        </th>
                        <th>
                        <td style="text-align:center;">
                            Quantity
                        </td> 
                        </th>
                        <th>
                        <td style="text-align:right;padding-right:30px;">
                            Amount
                        </td> 
                        </th> 
                    </tr> 

                    <tr>
                        <th>
                        <td style="text-align:center;">
                            1
                        </td> 
                        </th>
                        <th>
                        <td>
                            Precious Jewellery
                        </td> 
                        </th>
                        <th>
                        <td style="text-align:center;">
                            1
                        </td> 
                        </th>
                        <th>
                            <?php  if($_order->getPayment()->getMethodInstance()->getCode() == 'cod'){ ?> 
                                    <td style="text-align:right;padding-right:30px;">
                                        <?php echo Mage::app()->getLocale()->currency($currentCurrencyCode)->toCurrency((int)$_order->getTotalDue()) ?>
                                    </td> 
                            <?php  }else{ ?>
                                    
                                    <td style="text-align:right;padding-right:30px;">
                                        <?php echo Mage::app()->getLocale()->currency($currentCurrencyCode)->toCurrency($product_price); ?>
                                    </td> 
                            <?php  } ?>
                        </th> 
                    </tr> 


                </table>   
            </td> 
        </tr>
        <tr>
            <?php  if($_order->getPayment()->getMethodInstance()->getCode() == 'cod'){ ?> 
                    <td style="text-align:right;padding-right:30px;">
                        Total&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo Mage::app()->getLocale()->currency($currentCurrencyCode)->toCurrency((int)$_order->getTotalDue()) ?>
                    </td> 
            <?php  }else{ ?>

                    <td style="border-bottom:1px solid; text-align: right; padding-right:37px;"> 
                        Total&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo Mage::app()->getLocale()->currency($currentCurrencyCode)->toCurrency($product_price); ?>	
                    </td> 
            <?php  } ?>

            
        </tr>
        <tr>
            <td style="border-bottom:1px solid; text-align: center;"> 
                This is an electronically generated document, hence does not require signature
            </td> 
        </tr>
        <tr>
            <td> 
                Return Address: 601-602, Om Shakti Samrat CHS Ltd,Plot No. 21,Shakti Niwas,Ramchandra Lane extn,Near Greater Bombay Co-op Bank,Kanchpada, Mumbai, Maharashtra, India  <b>BOM/JOG / 400064</b> 
            </td> 
        </tr>
    </table>
</div>
<br/>
 
<a style="float: right;" title="Go Back to Orders" href="<?php echo base_url(); ?>index.php/bluedartshippingprint/">Go Back to Orders</a>
<input style="float: right; margin-right: 30px;" name="b_print" type="button" class="ipt"  onClick="PrintDivOnly();" style="float:right;" value="Print This Now"><br/>
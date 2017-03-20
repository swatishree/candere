<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.

 * @category    Atwix Mod
 * @package     Atwix_Tweaks
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2012 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Product_Price_Adminhtml_ProductpriceController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Return some checking result
     *
     * @return void
     */
    public function checkAction()
    {
		set_time_limit(0);
		$collection = Mage::getResourceModel('catalog/product_collection') ->addAttributeToSelect(array('sku', 'name', 'description', 'price'));
		$flag = 0;
		//$metal_id = 0;
		//$purity_id = 0;
		foreach ($collection as $item) {
			$productId 				= $item->getId();
			$product 				= Mage::getModel('catalog/product')->load($productId);			
			$product_type 			= Mage::helper('function')->get_attribute_name_and_value_frontend($product->getCandere_product_type(),'candere_product_type');
			//$productId 				= 3005;
			//@set_time_limit(5);
			/*******************************************/
			
			//echo "--pro id--".$productId 				=3430; //1084 1098 1639  1729  3431 3431 5711 5751 ***failed 4671 4673 4674 *** ++++
			//$product_id = array('1084', '1725', '1726', '1727', '1728', '1729', '1730', '3430', '3431', '3432', '3433', '3434', '4671', '4672','4673','4674', '5709', '5710', '5711', '5712');
			/*
			 sku - solitaire-diamonds
			--pro id--3431--sku--SCR5000  Disabled
			--pro id--3432--sku--SCR5001  Disabled
			--pro id--4672--sku--Amazon Dummy Product
			--pro id--4673--sku--
			--pro id--5711--sku--RP0001  Disabled
			--pro id--5712--sku--GB00175 *** */			
			
			/******************************************/
			
			/*for($i=0;$i<count($product_id); $i++){
			$product 				= Mage::getModel('catalog/product')->load($productId);			
			$product_name 			= $product->getName();
			//echo "<br>--pro id--".$product_id[$i]."--sku--".$sku 			= $product->getSku(); } exit;*/
			//echo "pro id==".$productId 				= 890; '4674',  '1098',  '1639',  '3432',  '3431',  '5711',  '5751',  '4674',  '4673'
			// latest  && $productId > 5974
			if($productId != 1098 && $productId != 1084 && $productId != 1639 && $productId != 3432 && $productId != 3431 && $productId != 5711 && $productId != 5751 && $productId != 4674 && $productId != 4673 && $productId != 5973 && $productId != 5972){
				
				$product_name 			= $product->getName();
						
				$default_metal_karat 	= Mage::helper('function')->get_default_metal_karat($productId, $product_type);
				/*echo "<pre>";
				print_r($default_metal_karat);
				echo "</pre>";*/
				$metal_id 				= $default_metal_karat['metal_id'];
				$purity_id 				= $default_metal_karat['purity'];
				$metal_weight       	= $product->getDefault_metal_weight(); 
				$total_weight 			= $product->getTotal_weight();
				
				$resource 		= Mage::getSingleton('core/resource');
				$readConnection = $resource->getConnection('core_read');  
				
				if($metal_id > 0 && $purity_id > 0 && $productId != '')
				{
					$sql = 'SELECT siij_price,sigh_price,vsgh_price,vvsgh_price,vvsef_price,diamond_default FROM pricing_table_metal_options pricing_table_metal_options
				 WHERE (product_id = '.$productId.' and metal_id = '.$metal_id.' and purity = '.$purity_id.' and store_id = 0)  and (siij_price !=0 or sigh_price!=0 or vsgh_price!=0 or vvsgh_price!=0 or vvsef_price!=0)';
					$results = $readConnection->fetchRow($sql);
					if($results['diamond_default'] != '')
					{
						$diamond_default = explode('_',$results['diamond_default']);
						$clarity = $diamond_default[0];
						$color = $diamond_default[1];
					}
					else
					{
						$clarity = 'si';
						$color = 'gh';
					}
				}
				else
				{
					$clarity = 'si';
					$color = 'gh';
				}
				$old_price = '';
				if($productId > 0 && $product_type != '' && $metal_weight != '' && $total_weight != ''){
					
					if($product_type != 'Coins')
					{
						$product_diamond_gemstone_flag = Mage::helper('function')->getProductDiamondandGemstoneCostValue($productId,$product_type,$metal_weight,$total_weight,$purity_id, $clarity, $color);					
					
						//$old_price = round($product_diamond_gemstone_flag['selling_price']);
					}
					else
					{					
						$get_weights = Mage::helper('function')->get_base_weight_and_total_weight($metal_weight,$total_weight,$purity_id,$product_type);
						
						$metal_weight 	= $get_weights['metal_weight'];
						$total_weight 	= $get_weights['total_weight'];
						$gold_price		= $get_weights['gold_price'];
						if (strpos($product_name, 'Bar') !== false) {
							$gold_price = $get_weights['gold_price_999'];
						}			
						// =((($B$2/10)*A4)+E4)*(1.035) processing_cost_1_gm margin
						$gold_coin_processing = $get_weights['gold_coin_processing'];
						$gold_coin_margin 	  = $get_weights['gold_coin_margin'];
						
						$gold_coin_price = (($gold_price * $metal_weight) + $gold_coin_processing) * (1+ $gold_coin_margin);
						$base_new_price = Mage::getModel('catalogrule/rule')->calcProductPriceRule($product,round($gold_coin_price));
						/*if($base_new_price <= 0)						
							$old_price = $gold_coin_price;
						else
							$old_price = $base_new_price;*/
					}
					
					//echo "----old above-----".$old_price;
					/************************************************************/
				
					$default_length 		= $product_diamond_gemstone_flag['default_length'];
					$thickness				= 0;
					if($product_type == 'Chains') {
						$default_length =  trim(Mage::helper('function')->get_attribute_name_and_value_frontend($product->getChain_length(),'chain_length'));
						$thickness = $product->getWidth();
					}

					$clarity 				= $product_diamond_gemstone_flag['diamond_clarity'];
					$color 					= $product_diamond_gemstone_flag['diamond_color'];
					$diamond_selection		= $product_diamond_gemstone_flag['diamond_clarity'].$product_diamond_gemstone_flag['diamond_color'];
					$product_price_details  = Mage::helper('function')->getCustomizedDesignPricing($productId,$metal_id,$purity_id,$default_length,$thickness,$diamond_selection,$purity_id,$clarity,$color);
					
					/*echo "<pre>";
					print_r($product_price_details);
					echo "</pre>"; exit;*/
					$old_price 				= $product_price_details['old_price_currency'];
					$metal_weight	 		= $product_price_details['metal_weight'];
					$diamond_weight_value	= $product_price_details['diamond_weight_value'];
					$ratio	 				= $product_price_details['ratio'];
					/************************************************************/
					
					$write = Mage::getSingleton('core/resource')->getConnection('core_write');
					$sql = $write->query("
					  UPDATE catalog_product_entity_decimal val
					  SET  val.value = ".round($old_price)."
					  WHERE  val.attribute_id = (
						 SELECT attribute_id FROM eav_attribute eav
						 WHERE eav.entity_type_id = 4 
						   AND eav.attribute_code = 'price'
						) and val.entity_id=".$productId."
					");
					if($diamond_weight_value > 0):
					$sql_flat = $write->query("
					  UPDATE catalog_product_flat_1 vals
					  SET  vals.price = ".round($old_price).", metal_weight = ".$metal_weight.", diamond_weight_value = ".$diamond_weight_value.", ratio = ".$ratio."
					  WHERE vals.entity_id=".$productId."
					");
					endif;
					echo "--success productId--".$productId."--price--".round($old_price)."--";
					
			}
			else
			{
				echo "--failed id--".$productId."--price--".round($old_price)."--";
			}
			//endif;
			}
		}
			$result = "You have successfully updated price. ";
		
		//else
			//$result = "Error while updating price";
		
        Mage::app()->getResponse()->setBody($result);
    }
}
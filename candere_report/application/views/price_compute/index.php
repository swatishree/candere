<?php 
$attribute_collection = Mage::getModel('eav/config')->getAttribute('catalog_product', 'candere_product_type');


if($attribute_collection)
{
	foreach($attribute_collection->getSource()->getAllOptions(true, true) as $attribute_collect) { 
		if($attribute_collect['label'] !='') {
		
			$product_label = $attribute_collect['label'];
			$product_value = $attribute_collect['value'];
			
			$url = base_url('index.php/price_computes/get_product_details/?product_type='.$product_value.'');
			
			echo '<h1><a href="'.$url.'">Export '.$product_label.'  with Metal and Sizing options</a></h1> <br> '; 
		}
		
	}
}

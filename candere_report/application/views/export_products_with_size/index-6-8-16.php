<div class="messages">
	<?php
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
			}
		}
				
		$sql =	"SELECT count(pricing_table_metal_options.sku) as total_count
  FROM       (   (      (   (   pricing_table_metal_options pricing_table_metal_options
                                   INNER JOIN
                                      eav_attribute_option_value eav_attribute_option_value
                                   ON (pricing_table_metal_options.metal_id =
                                          eav_attribute_option_value.option_id))
                               INNER JOIN
                                  eav_attribute_option_value eav_attribute_option_value_1
                               ON (pricing_table_metal_options.purity =
                                      eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_int catalog_product_entity_int
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_int.entity_id))
               INNER JOIN
                  eav_attribute_option_value eav_attribute_option_value_2
               ON (catalog_product_entity_int.value =
                      eav_attribute_option_value_2.option_id))
       INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_1
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_1.entity_id)
 WHERE     (    (    catalog_product_entity_int_1.attribute_id = 96
                 AND catalog_product_entity_int_1.value = 1)
            AND (    (    (    (    (    pricing_table_metal_options.status =
                                            1
                                     )
                                AND catalog_product_entity_int.attribute_id =
                                       272)
                           AND catalog_product_entity_int.value IN (583))
                      )
                ))
ORDER BY pricing_table_metal_options.sku DESC";

		$results = $this->db->query($sql);
		$result = array_shift($results->result());
		$total_ring_count = $result->total_count;
		$limit_array = range(0,$total_ring_count+300,300);
		unset($limit_array[count($limit_array)-1]);
		
		foreach($limit_array as $res) {
			$limit = 'limit '. $res .',300';
			$limit_range = $res+1 .' to '. ($res+300);	
		?>	
			<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export?product_label=rings&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings with Weight and Ring Sizes <?php echo $limit_range ?></a></h1> <br>  
		<?php
		}	
		unset($limit_array);
		unset($limit_range,$limit);
	?>
</div>
<br><br><br>
 
 <?php
$sql =	"SELECT COUNT(pricing_table_metal_options.sku) AS total_count
  FROM    (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                       INNER JOIN
                          eav_attribute_option_value eav_attribute_option_value_1
                       ON (pricing_table_metal_options.purity =
                              eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_int catalog_product_entity_int
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_int.entity_id))
               INNER JOIN
                  eav_attribute_option_value eav_attribute_option_value_2
               ON (catalog_product_entity_int.value =
                      eav_attribute_option_value_2.option_id))
           INNER JOIN
              eav_attribute_option_value eav_attribute_option_value
           ON (pricing_table_metal_options.metal_id =
                  eav_attribute_option_value.option_id))
       INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_1
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_1.entity_id)
 WHERE (    (    catalog_product_entity_int_1.attribute_id = 96
             AND catalog_product_entity_int_1.value = 1)
        AND (    (    pricing_table_metal_options.status = 1
                  AND catalog_product_entity_int.attribute_id = 272)
             AND catalog_product_entity_int.value IN (587)))"; 

		$results = $this->db->query($sql);
		$result = array_shift($results->result());
		$total_band_count = $result->total_count;
		$limit_array = range(0,$total_band_count+300,300);
		
		unset($limit_array[count($limit_array)-1]);
		
		foreach($limit_array as $res) {
			$limit = 'limit '. $res .',300';
			$limit_range = $res+1 .' to '. ($res+300);	
		?>	
			<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export?product_label=bands&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Bands with Weight and Sizes <?php echo $limit_range ?></a></h1> <br>  
		<?php
		}	
	?>
<br>
<br>
<br>

<!--<h1><a href="<?php //echo $this->config->base_url(); ?>/index.php/export_products_with_size/export?product_label=bands">Export Bands with Weight and Ring Sizes</a></h1> <br> -->  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export?product_label=bangles">Export Bangles with Weight and Sizes</a></h1> <br>  
 
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export?product_label=kada">Export Kada with  Weight and Sizes</a></h1> <br>   
 
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export_products_without_dropdown?product_label=necklaces">Export necklaces with Weight and Sizes</a></h1> <br>  
  
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export_chains_bracelets?product_label=chains">Export Chains with Weight and Lenghts</a></h1> <br>   

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export_chains_bracelets?product_label=bracelets">Export Bracelets with Weight and Lenghts</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/export_products_without_dropdown?product_label=products">Export Nose Pins,Earrings,Pendants,Coins</a></h1> <br>  



<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/export_products_with_size/pknready?product_label=pknready">Export Packed & Ready Products</a></h1> <br>  


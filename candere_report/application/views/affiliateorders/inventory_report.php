

<div style="margin:0 auto; text-align: center;">
<h1>Inventory Report</h1>

<table border="1" cellpadding="5" cellspacing="0" style="margin:40 auto; text-align: center;">
	<tr>
		<th>Product Type</th>		
		<th>Only Gold Count</th>
		<th>Diamond Count</th> 
		<th>Gemstone Count</th> 
		<!--<th>Diamond Gemstone Count</th> -->
	</tr>	
	
	<?php 
		$sql = "SELECT DISTINCT
       catalog_product_entity_int.value AS candere_product_type,
       eav_attribute_option_value.value AS product_type
  FROM    (   (   eav_attribute_option eav_attribute_option
               INNER JOIN
                  eav_attribute_option_value eav_attribute_option_value
               ON (eav_attribute_option.option_id =
                      eav_attribute_option_value.option_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (catalog_product_entity_int.value =
                  eav_attribute_option.option_id))
       INNER JOIN
          catalog_product_entity catalog_product_entity
       ON (catalog_product_entity.entity_id =
              catalog_product_entity_int.entity_id)
 WHERE catalog_product_entity_int.attribute_id = 272";
 
		$type_results 		= $this->db->query($sql);
		$type_result 		= $type_results->result_array();
		
		foreach($type_result as $row) {
		
			$candere_product_type = $row['candere_product_type'];
			$product_type = $row['product_type'];
			
			
			/************ Only Gold Products *********/
			$sql = "SELECT DISTINCT COUNT(pricing_table_metal_options.product_id) AS gold_count
  FROM    (   (   catalog_product_entity catalog_product_entity
               INNER JOIN
                  catalog_product_entity_int catalog_product_entity_int_1
               ON (catalog_product_entity.entity_id =
                      catalog_product_entity_int_1.entity_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (catalog_product_entity.entity_id =
                  catalog_product_entity_int.entity_id))
       INNER JOIN
          pricing_table_metal_options pricing_table_metal_options
       ON     (catalog_product_entity.entity_id =
                  pricing_table_metal_options.product_id)
          AND (catalog_product_entity.sku = pricing_table_metal_options.sku)
 WHERE (    (    pricing_table_metal_options.status = 1
             AND pricing_table_metal_options.isdefault = 1)
        AND catalog_product_entity_int.attribute_id = 277 AND catalog_product_entity_int_1.value = $candere_product_type AND catalog_product_entity_int.value = 1 )";
		
			$results 	= $this->db->query($sql);

			//echo $this->db->last_query(); exit;
			
			$result 	= $results->result_array();
			$gold_count = $result[0]['gold_count']; 
			
			
			
			/************ Only Diamond Products *********/
			$sql = "SELECT DISTINCT count(pricing_table_metal_options.product_id) AS diamond_count
  FROM    (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                       INNER JOIN
                          gemstone_attributes gemstone_attributes
                       ON (pricing_table_metal_options.product_id =
                              gemstone_attributes.product_id))
                   INNER JOIN
                      catalog_product_entity catalog_product_entity
                   ON     (catalog_product_entity.entity_id =
                              pricing_table_metal_options.product_id)
                      AND (catalog_product_entity.sku =
                              pricing_table_metal_options.sku))
               INNER JOIN
                  catalog_product_entity_int catalog_product_entity_int_1
               ON (catalog_product_entity.entity_id =
                      catalog_product_entity_int_1.entity_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (catalog_product_entity.entity_id =
                  catalog_product_entity_int.entity_id))
       INNER JOIN
          diamond_attributes diamond_attributes
       ON (pricing_table_metal_options.product_id =
              diamond_attributes.product_id)
	WHERE ( 
		(gemstone_attributes.attribute_id = 262  AND  (gemstone_attributes.gemstone_1 = '0' OR gemstone_attributes.gemstone_2 = '0' OR gemstone_attributes.gemstone_3 = '0' OR gemstone_attributes.gemstone_4 = '0' OR gemstone_attributes.gemstone_5 = '0' ) )
		AND
		( diamond_attributes.attribute_id = '263' AND ( diamond_attributes.diamond_1 = '1' OR diamond_attributes.diamond_2 = '1' OR diamond_attributes.diamond_3 = '1' OR diamond_attributes.diamond_4 = '1' OR diamond_attributes.diamond_5 = '1' OR diamond_attributes.diamond_6 = '1' OR diamond_attributes.diamond_7 = '1' )) 
		AND 
		( pricing_table_metal_options.status = 1 AND pricing_table_metal_options.isdefault = 1 AND catalog_product_entity_int.attribute_id = 277 	AND catalog_product_entity_int_1.value = $candere_product_type AND catalog_product_entity_int.value = 0)	
	)";
		
			$diamond_results 	= $this->db->query($sql);	
			$diamond_result 	= $diamond_results->result_array();
			$diamond_count 		= $diamond_result[0]['diamond_count']; 
			
			
			
			/************ Only Gemstone Products *********/
			$sql = "SELECT DISTINCT count(pricing_table_metal_options.product_id) AS gemstone_count
  FROM    (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                       INNER JOIN
                          gemstone_attributes gemstone_attributes
                       ON (pricing_table_metal_options.product_id =
                              gemstone_attributes.product_id))
                   INNER JOIN
                      catalog_product_entity catalog_product_entity
                   ON     (catalog_product_entity.entity_id =
                              pricing_table_metal_options.product_id)
                      AND (catalog_product_entity.sku =
                              pricing_table_metal_options.sku))
               INNER JOIN
                  catalog_product_entity_int catalog_product_entity_int_1
               ON (catalog_product_entity.entity_id =
                      catalog_product_entity_int_1.entity_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (catalog_product_entity.entity_id =
                  catalog_product_entity_int.entity_id))
       INNER JOIN
          diamond_attributes diamond_attributes
       ON (pricing_table_metal_options.product_id =
              diamond_attributes.product_id)
	WHERE ( 
		(gemstone_attributes.attribute_id = 262  AND  (gemstone_attributes.gemstone_1 = '1' OR gemstone_attributes.gemstone_2 = '1' OR gemstone_attributes.gemstone_3 = '1' OR gemstone_attributes.gemstone_4 = '1' OR gemstone_attributes.gemstone_5 = '1' ) )
		AND
		( diamond_attributes.attribute_id = '263' AND ( diamond_attributes.diamond_1 = '0' OR diamond_attributes.diamond_2 = '0' OR diamond_attributes.diamond_3 = '0' OR diamond_attributes.diamond_4 = '0' OR diamond_attributes.diamond_5 = '0' OR diamond_attributes.diamond_6 = '0' OR diamond_attributes.diamond_7 = '0' )) 
		AND 
		( pricing_table_metal_options.status = 1 AND pricing_table_metal_options.isdefault = 1 AND catalog_product_entity_int.attribute_id = 277 	AND catalog_product_entity_int_1.value = $candere_product_type AND catalog_product_entity_int.value = 0)	
	)";
		
			$gemstone_results 		= $this->db->query($sql);	
			$gemstone_results 		= $gemstone_results->result_array();
			$gemstone_count 		= $gemstone_results[0]['gemstone_count']; 
			
			
			/************ Diamond & Gemstone Products *********/
			
			/*
			$sql = "SELECT DISTINCT count(pricing_table_metal_options.product_id) AS diamond_gemstone_count
  FROM    (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                       INNER JOIN
                          gemstone_attributes gemstone_attributes
                       ON (pricing_table_metal_options.product_id =
                              gemstone_attributes.product_id))
                   INNER JOIN
                      catalog_product_entity catalog_product_entity
                   ON     (catalog_product_entity.entity_id =
                              pricing_table_metal_options.product_id)
                      AND (catalog_product_entity.sku =
                              pricing_table_metal_options.sku))
               INNER JOIN
                  catalog_product_entity_int catalog_product_entity_int_1
               ON (catalog_product_entity.entity_id =
                      catalog_product_entity_int_1.entity_id))
           INNER JOIN
              catalog_product_entity_int catalog_product_entity_int
           ON (catalog_product_entity.entity_id =
                  catalog_product_entity_int.entity_id))
       INNER JOIN
          diamond_attributes diamond_attributes
       ON (pricing_table_metal_options.product_id =
              diamond_attributes.product_id)
	WHERE ( 
		(gemstone_attributes.attribute_id = 262  AND  (gemstone_attributes.gemstone_1 = '1' OR gemstone_attributes.gemstone_2 = '1' OR gemstone_attributes.gemstone_3 = '1' OR gemstone_attributes.gemstone_4 = '1' OR gemstone_attributes.gemstone_5 = '1' ) )
		AND
		( diamond_attributes.attribute_id = '263' AND ( diamond_attributes.diamond_1 = '1' OR diamond_attributes.diamond_2 = '1' OR diamond_attributes.diamond_3 = '1' OR diamond_attributes.diamond_4 = '1' OR diamond_attributes.diamond_5 = '1' OR diamond_attributes.diamond_6 = '1' OR diamond_attributes.diamond_7 = '1' ))
		AND 
		( pricing_table_metal_options.status = 1 AND pricing_table_metal_options.isdefault = 1 AND catalog_product_entity_int.attribute_id = 277 	AND catalog_product_entity_int_1.value = $candere_product_type AND catalog_product_entity_int.value = 0)	
	)";
		
			$diamond_gemstone_results 		= $this->db->query($sql);	
			$diamond_gemstone_result 		= $diamond_gemstone_results->result_array();
			$diamond_gemstone_count 		= $diamond_gemstone_result[0]['diamond_gemstone_count']; 
			*/
		?>
				
				<tr>
					<td><?php echo $product_type;?></td> 
					<td><?php echo $gold_count;?></td> 
					<td><?php echo $diamond_count;?></td> 
					<td><?php echo $gemstone_count;?></td> 
					<!--<td><?php //echo $diamond_gemstone_count;?></td> -->
				</tr>	
	
 
	<?php  }  ?>	
		
</table>
</div>
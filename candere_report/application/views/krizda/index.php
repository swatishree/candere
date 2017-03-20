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

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/krizda/export">Export All Products</a></h1> <br>  
<?php
	$sql = 'SELECT 
				   eav_attribute_option_value.value as label, catalog_product_entity_int.value
			  FROM    catalog_product_entity_int catalog_product_entity_int
				   INNER JOIN
					  eav_attribute_option_value eav_attribute_option_value
				   ON (catalog_product_entity_int.value =
						  eav_attribute_option_value.option_id)
			 WHERE (catalog_product_entity_int.attribute_id = 272)
			GROUP BY eav_attribute_option_value.value'; 

			$results_product_type = $this->db->query($sql);
			 
			$result_product_type = $results_product_type->result_array();
			
		foreach($result_product_type as $product_type){	
?>  

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/krizda/exportDefaultProductsOnly?type=<?php echo $product_type['value'] ;?>">Export All2 <?php echo $product_type['label'] ;?></a></h1> <br>

<?php
	}
?> 
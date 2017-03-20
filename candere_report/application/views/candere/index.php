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

<?php
		$query = $this->db->query("SELECT DISTINCT
								   eav_attribute.attribute_id,
								   eav_attribute_option_value.value
							  FROM    (   eav_attribute_option eav_attribute_option
									   INNER JOIN
										  eav_attribute_option_value eav_attribute_option_value
									   ON (eav_attribute_option.option_id =
											  eav_attribute_option_value.option_id))
								   INNER JOIN
									  eav_attribute eav_attribute
								   ON (eav_attribute.attribute_id = eav_attribute_option.attribute_id)
							 WHERE (eav_attribute.attribute_id = 272)");
		$product_types 	= $query->result();
		
		foreach($product_types as $row) {
			$product_type = $row->value; ?>
			
			<br>
			<h1><a href="<?php echo $this->config->base_url("index.php/candere_products/export?label=$product_type"); ?>">Export All <?php echo $product_type; ?></a></h1>
		<?php 
		} ?>
		
		<br><br>
		<h1><a href="<?php echo $this->config->base_url("index.php/candere_products/export_all_product_images"); ?>">Export All Product Images</a></h1>
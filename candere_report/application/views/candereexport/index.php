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

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/candereexport/export">Export All Products Prices Only</a></h1> 



<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/candereexport/export_all_products_with_images">Export All Products with Images and Metals</a></h1> 
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
			
		<br>
		<h1><a href="<?php echo $this->config->base_url("index.php/candere_gold_diamond_products/export?label=gold"); ?>">Export All Gold Products</a></h1>
		
		<br>
		<h1><a href="<?php echo $this->config->base_url("index.php/candere_gold_diamond_products/export?label=diamond"); ?>">Export All Diamond Products</a></h1>
		
		
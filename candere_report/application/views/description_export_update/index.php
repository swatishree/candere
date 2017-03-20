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

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/description_export_update/export">Export All Products to Update Description</a></h1> <br>  
	 
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

<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/jungleeexport/export">Export All Products</a></h1> <br> 
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/jungleeexport/exportimages">Export All Products Default Images</a></h1> 
 <br>
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/jungleeexport/exportproductscategory">Export All Category Products</a></h1> 
<br> 
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/jungleeexport/customerorderexport">Export Customer With Paid Orders</a></h1> 

<br> 
<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/jungleeexport/customerorderexport">Export Customer With Un Paid Orders</a></h1> 
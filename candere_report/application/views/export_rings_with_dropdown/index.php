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

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export?product_label=ring">Export Rings with Weight and Ring Sizes1</a></h1> <br>  
 
<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export?product_label=band">Export Bands with Weight and Ring Sizes2</a></h1> <br>   

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export?product_label=bangle">Export Bangles with Weight and Sizes3</a></h1> <br>  
 
<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export?product_label=kada">Export Kada with  Weight and Sizes4</a></h1> <br>   
 
<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export_chains_bracelets?product_label=chain">Export Chain with Weight and Lenghts5</a></h1> <br>   

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export_chains_bracelets?product_label=bracelet">Export Bracelet with Weight and Lenghts6</a></h1> <br>  

<h1><a href="<?php echo $this->config->base_url(); ?>index.php/export_rings_with_dropdown/export_products_without_dropdown?product_label=products">Export Nose Pins,Earrings,Pendants,Coins</a></h1> <br>  
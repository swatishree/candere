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


<h1><a href="<?php echo $this->config->base_url(); ?>/index.php/pricingupdate/export_to_csv">Export Pricing CSV</a></h1> <br/> 


<h1>Upload a CSV file Only</h1>  
<h5>
	Column 1 : sku<br/>
	Column 2 : 22k<br/>
	Column 3 : 18k<br/>
	Column 4 : 14k<br/>
	Column 5 : 9k

</h5>  

<?php echo form_open_multipart('pricingupdate/submit'); ?>
	<p>
		<?php echo form_label('File: ', 'file') ?>
		<?php echo form_upload('file') ?>
	</p> 
	
	<p>
		<?php echo form_label('Password: ', 'password') ?> 
		<?php echo form_input(array('name' => 'password','id' => 'password', 'class' => 'required' , 'value' => '','type'=>"password")); ?>
	</p> 
	
	<p><?php echo form_submit('submit', 'Upload the files!') ?></p>
<?php echo form_close() ?>

<script src="<?php echo base_url();?>themes/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>themes/js/jquery-1.9.0.js"></script>		
<script>
$("#vendor_form").validate(
    {
        rules: 
        {
          vendor_name: 
          {
            required: true
          }
          
        },
        messages: 
        {
          vendor_name: 
          {
            required: "Please enter your name"
          }
        }
      });	
</script>
				
	
  <br/><br/>
	<div>
			<div>
				<ul>
					<li>Vendors</li>
					<li>
						<a href="<?php echo base_url(); ?>index.php/vendor">
							List Vendors
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>vendor/create" >
							Create Vendors
						</a>
					</li>
				</ul>
			</div>
			
<?php if($msg) {
	echo '<span style="color:green">'.$msg.'</span>';
}?>	
	<div>
	<form method="post" action="<?php echo base_url('index.php');?>/vendor/create" id="vendor_form" name="vendor_form">
			
			<h3>Create Vendors</h3>
					  
			<div>
				<label for="vendor_name">Vendor Name<font color="red" size=4>*</font></label>
				<div>
					<input type="text" name="vendor_name" value="<?php echo set_value('vendor_name'); ?>" id="vendor_name">
					<?php echo form_error('vendor_name'); ?>		
				</div>
			</div>
					  
			<div>
				<label for="active">Active</label>
				<div>
				<?php
					$active_options = array('1' => 'Yes', '0' => 'No' );
					echo form_dropdown('active', $active_options,set_value('active'),'id="active"');
					echo form_error('active');
				?>
				</div>
			</div>
					 
			<div>
				<button type="submit" id="save2">Save changes</button>
				<button type="button" onclick="window.history.back();">Cancel</button>
			</div>
					
			</form>
		</div>
	</div>
	
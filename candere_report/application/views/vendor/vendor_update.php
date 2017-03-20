
<script src="<?php echo base_url();?>themes/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>themes/js/jquery-1.9.0.js"></script>		
<script>
$("#vendor_updateform").validate(
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

<?php
	foreach($RowInfo as $row)	{
		$vendor_id 		= $row->vendor_id;
		$vendor_name 	= $row->vendor_name;
		$active 		= isset($row->active)?1:0;
		$CreatedBy 		= $row->CreatedBy;
		$CreatedDate 	= $row->CreatedDate;
	}
?>
	
	<br/><br/>
		<div>
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
							<a href="<?php echo base_url(); ?>index.php/vendor/create">
								Create Vendor
							</a>
						</li>
					</ul>
				</div>
			</div>
				
	<?php if($msg) {
		echo '<span style="color:green">'.$msg.'</span>';
	}?>	
	<div>
		<form method="post" action="<?php echo base_url();?>index.php/vendor/vendor_update/<?php echo $vendor_id;?>" id="vendor_updateform" />
					
	<legend>Update Vendors</legend>
		
	<div>
		<label>Vendor Name<font color="red" size=4>*</font></label>
						<div>
 <input type="text" name="vendor_name" value="<?php echo $vendor_name; ?>" id="vendor_name">
 <?php echo form_error('vendor_name'); ?>
						</div>
					  </div>

					  <div>
						<label>Active</label>
						<div>
				<?php
					$active_options = array('1' => 'Yes', '0' => 'No' );
					echo form_dropdown('active', $active_options, $active,'id="active"');
					echo form_error('active');
				?>
					</div>
				  </div>
					  
				<input type="hidden" name="vendor_id" id="ID001" value="<?php echo $vendor_id; ?>">
						  
					<div>
					<button type="submit">Update</button>
					<button type="button" onclick="window.history.back()";>Cancel</button>
					</div>
				 </form>
			</div>
		</div>
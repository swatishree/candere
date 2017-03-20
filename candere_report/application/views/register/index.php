<?php 	$_username 	= @$this->session->userdata('_username');
		$_admin 	= @$this->session->userdata('_admin'); 
?>

<?php 
			if(isset($message)) {
				echo '<div class="basic-grey"><span style="color:red;">'.$message.'</span></div>';
			} ?>	
			
<?php if($_admin=='Y') { ?>
		
		<div class="line">
		<form action="<?php echo base_url('index.php') ?>/login/register" method="post" class="basic-grey" >
					
		<h2>Add New User</h2><br>
			 <label>
			 <span>*Username :</span>
				<input type="text" name="username" placeholder="Username" value="<?php echo set_value('username');?>" >
				<?php echo form_error('username'); ?><br><br>
			 </label>	
			 <label> 
			<span>*Password :</span>
				<input type="password" name="password" placeholder="Password" value="<?php echo set_value('password');?>" >
				<?php echo form_error('password'); ?>  <br><br>
			 </label>
			<label> 
			<span>*Email Id :</span>
				<input type="text" name="email" placeholder="Email Id" value="<?php echo set_value('email');?>" >
				<?php echo form_error('email'); ?>  <br><br>
			</label>
			<label> 
			<span>*Allow Status :</span><br>
				<?php 
				$order_status 	= $this->erpmodel->getAllStatus();
				
				foreach($order_status as $row) {
					echo '<input type="checkbox" name="order_status[]" value="'.$row->status_id.'" />'.$row->status_name.' <br>';
				} ?>
				</label>
				
				<br><br>
				<label>
				<span>*Is Admin :</span>
				<?php
				$options = array(
								  ''	=> 'Select',
								  'Y'  	=> 'Yes',
								  'N'  	=> 'No'
								);
				echo form_dropdown('isadmin', $options); ?>
				<?php echo form_error('isadmin'); ?>  <br><br>
			</label>	
			<label> 
			 <span>&nbsp;</span> 
			<input type="submit" name="reg_btn" class="button" value="Register"> <br><br>
			</label>	
		</form>
    </div> 
	
<?php } 
else { 
		echo '<div class="line"><h3>Access Denied!</h3></div>'; 
	} ?>
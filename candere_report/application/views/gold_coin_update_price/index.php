<?php 
			
	 
		$query = $this->db->query('select gold_price_995,gold_price_999,gold_price_999_9,added_date from gold_coin_price_history where id = (select max(id) from gold_coin_price_history)');

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();  
		   $gold_price_995 		= $row->gold_price_995 ;
		   $gold_price_999 		= $row->gold_price_999 ;
		   $gold_price_999_9 	= $row->gold_price_999_9 ;
		   $added_date 			= $row->added_date ;
		}else{
			$gold_price_995 	= '' ;
		   $gold_price_999 		= '' ;
		   $gold_price_999_9 	= '' ;
		   $added_date		 	= '' ;
		}
?><div class="messages">
Last Updated On : <?php echo $added_date; ?>
</div>
 <?php echo form_open("gold_coin_update_price/submit",array('class' => 'cmxform',"id"=>"gold_coin_update_price")); ?>
	<p>
		<?php echo form_label('Gold Price 995 1gm: ', 'gold_price_995') ?>
		<?php echo form_input(array('name' => 'gold_price_995','id' => 'gold_price_995', 'class' => 'required','type'=>'number' , 'value' => '')); ?> <?php echo '<b>Last Price : '. $gold_price_995.'</b>'; ?>
	</p> 
	<p>
		<?php echo form_label('Gold Price 999 1gm: ', 'gold_price_999') ?>
		<?php echo form_input(array('name' => 'gold_price_999','id' => 'gold_price_999', 'class' => 'required','type'=>'number'  , 'value' => '')); ?> <?php echo '<b>Last Price : '. $gold_price_999.'</b>'; ?>
	</p> 
	<p>
		<?php echo form_label('Gold Price 999.9 1gm: ', 'gold_price_999_9') ?> 
		<?php echo form_input(array('name' => 'gold_price_999_9','id' => 'gold_price_999_9', 'class' => 'required','type'=>'number'  , 'value' => '')); ?>  <?php echo '<b>Last Price : '. $gold_price_999_9.'</b>'; ?>
	</p>  
	<p>
		<?php echo form_label('Password: ', 'password') ?> 
		<?php echo form_input(array('name' => 'password','id' => 'password', 'class' => 'required' , 'value' => '','type'=>"password")); ?>
	</p>  
	<p><?php echo form_submit('submit', 'Submit') ?></p>
<?php echo form_close() ?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function() { 
		jQuery("#gold_coin_update_price").validate(); 
	});	
//]]>   
</script>
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
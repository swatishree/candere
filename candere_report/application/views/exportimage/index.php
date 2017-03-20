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
 <style>
	.pagination{    padding: 10px;}
	.seach_invoice_form  {              padding: 51px;                background: #444;        
        -moz-border-radius: 10px;        -webkit-border-radius: 10px;        border-radius: 10px;        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2); box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);    }
		
    .seach_invoice_form  input { width: 330px; padding: 10px 5px; border: 0; 
        -moz-border-radius: 3px 0 0 3px; -webkit-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;				height: 41px; }
    
    .seach_invoice_form  input:-moz-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }
	.seach_invoice_form  input:-ms-input-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }    
    
    .seach_invoice_form  button {
		overflow: visible; position: relative;    border: 0;        padding: 0;        cursor: pointer;         width: 110px;        font: bold 15px/40px 'lucida sans', 'trebuchet MS', 'Tahoma';
        color: #fff;        text-transform: uppercase;        background: #d83c3c;        -moz-border-radius: 0 3px 3px 0;        -webkit-border-radius: 0 3px 3px 0;        border-radius: 0 3px 3px 0;             text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);				    }   
		
	.seach_invoice_form  button:hover{		        background: #e54040;    }	
      
    .seach_invoice_form  button:active,    .seach_invoice_form  button:focus{ background: #c42f2f; }
    
	.seach_invoice_form  button:before { content: ''; position: absolute; border-width: 8px 8px 8px 0; border-style: solid solid solid none; border-color: transparent #d83c3c transparent; top: 12px; left: -6px; }
    
	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 451px;    padding: 10px 5px;    width: 230px;	margin-top:20px;}
	
</style> 



	
	<?php
	
	
	
		$fromdatepicker = '';
		$todatepicker = '';
		$order_status = '';
	if(isset($_GET) && !empty($_GET)){ 
		$fromdatepicker = $_GET['fromdatepicker'];
		$todatepicker = $_GET['todatepicker']; 
		$order_status = $_GET['order_status']; 
		
		 
	}
		
	
	
	
		
	?>
	
		<form  name="myForm"  onsubmit="return validateForm()" action="<?php echo site_url('exportimage/index');?>" chars  method="POST" accept-charset='UTF-8'>
			<div class="seach_invoice_form  cf">
	
				<input id="sku" name="sku[]" width ="150" class ='input_type' type="text" name='sku' placeholder="sku comma separated" value='<?php echo trim($_GET['sku']); ?>' required >		
		
				<button  class="button_example"  type="submit">Download </button>
	
	
			</div>
	
	
		</form>
		
		<?php
		foreach($data as $path){
			
			echo "<b><br>";
			
			echo "<b>ImagePath=". $path; 
			
		}
		
		?>

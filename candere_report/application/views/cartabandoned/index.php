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
  <title>Candere Valentine’s Contest</title>
	   	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
 <style>
	.pagination{    padding: 10px;}
	.seach_invoice_form  {              padding: 51px;                background: #444;        
        -moz-border-radius: 10px;        -webkit-border-radius: 10px;        border-radius: 10px;        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2); box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);    }
		
    .seach_invoice_form  input {  padding: 10px 5px; border: 0; 
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
	
	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style> 
<script>
$(function(){
	$( "#todatepicker" ).datepicker({ dateFormat: 'yy-mm-dd', maxDate: new Date() });
	$( "#fromdatepicker" ).datepicker({ dateFormat: 'yy-mm-dd' ,maxDate: new Date() });	
	
});
</script>

<script type="text/javascript">
			 function validateForm() { 
				
				var fromdatepicker=$("#fromdatepicker").val();
				
				var todatepicker = $("#todatepicker").val();
				
				if(fromdatepicker =='' && todatepicker==''){
					
					
					alert('FROM date Requied!');
					return false;
				}
				
				if(fromdatepicker =='' && todatepicker!=''){
					
					
					alert('To date Requied!');
					return false;
				}
				
			
			 
				var datdiff=fromdatepicker-todatepicker;
				if(fromdatepicker<todatepicker){
					alert('From date Should be greater to date!');
					
					return false;
				}
			}
 </script>
 
 <?php
if(isset($_POST) && !empty($_POST)){
	
	
	$date_from 		= strtotime($_POST['fromdatepicker']);
	$date_to 		= strtotime($_POST['todatepicker']);
	 
	 
	$mysql_date_from = date('Y-m-d',$date_from).' 00:00:00'; 
	$mysql_date_to = date('Y-m-d',$date_to).' 23:59:59'; 
}
?>

	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateForm()"  accept-charset='UTF-8' method="post" >
		<div class="seach_invoice_form  cf">
	
				<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="from date" value='<?php echo $mysql_date_to; ?>'>
		
				<input id="fromdatepicker" name="fromdatepicker" class ='input_type1' type="text" name='to_date' placeholder="to date" value='<?php echo $mysql_date_from; ?>'>
		
				<button  class="button_example"  type="submit">Search </button>
	
	
			</div>
	</form>
	
	<?php if(count($data)>0){
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;"><b>Result Counts '. count($data).'</b></div>';
		?>
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
			<thead>
					<tr>
						
						<th align="center">Customer Email</th>
						<th align="center">First Name</th>
						<th align="center">Last Name</th>
						<th align="center">Product Name</th>						
						<th align="center">Affiliate</th>
						<th align="center">Date</th>
						
						
					</tr>
				</thead>  
					
			<?php
			 
					foreach($data as $row){ 
						
						?>
							<tr>    
									
									<td align="center"><b><?php echo  $row['customer_email'] ;?></td>
									<td align="center"><b><?php echo  $row['customer_firstname'] ; ?></b></td>
									<td align="center"><b><?php echo  $row['customer_lastname'] ; ?></b></td>
									<td align="center"><b><?php echo  $row['product_name'] ; ?></b></td>									
									<td align="center"><b><?php echo  $row['affiliate_id'] ;?></td>
									<td align="center"><b><?php echo  $row['updated_at'] ;?></td>
									
							</tr>
						<?php   
					}
				 
			?>
	</table>
		
	<?php } else {
		
		
		echo '<div style="color:#d83c3c; float:left; margin-left: 604;"><b>No Record Find !!'.'</b></div>';
		
	}?>



		
	
	 




  

 

 
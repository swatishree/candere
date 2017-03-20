<?php 
	header('Content-Type: text/html; charset=utf-8');
?>
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
	.seach_invoice_form  {              padding: 28px;        margin: 30px auto 30px;        background: #444;        
        -moz-border-radius: 10px;        -webkit-border-radius: 10px;        border-radius: 10px;        -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2); box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);    }
		
    .seach_invoice_form  input { width: 330px; padding: 10px 5px; border: 0; 
        -moz-border-radius: 3px 0 0 3px; -webkit-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;		margin-left:890px;		height: 41px; }
    
    .seach_invoice_form  input:focus {        outline: 0;              -moz-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;        -webkit-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;        box-shadow: 0 0 2px rgba(0,0,0,.8) inset;    }
    
    .seach_invoice_form  input::-webkit-input-placeholder {       color: #999;       font-weight: normal;       font-style: italic;    }
    
    .seach_invoice_form  input:-moz-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }
	.seach_invoice_form  input:-ms-input-placeholder {        color: #999;        font-weight: normal;        font-style: italic;    }    
    
    .seach_invoice_form  button {
		overflow: visible; position: relative;        float: right;        border: 0;        padding: 0;        cursor: pointer;        height: 40px;        width: 110px;        font: bold 15px/40px 'lucida sans', 'trebuchet MS', 'Tahoma';
        color: #fff;        text-transform: uppercase;        background: #d83c3c;        -moz-border-radius: 0 3px 3px 0;        -webkit-border-radius: 0 3px 3px 0;        border-radius: 0 3px 3px 0;             text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);				    }   
		
	.seach_invoice_form  button:hover{		        background: #e54040;    }	
      
    .seach_invoice_form  button:active,    .seach_invoice_form  button:focus{ background: #c42f2f; }
    
	.seach_invoice_form  button:before { content: ''; position: absolute; border-width: 8px 8px 8px 0; border-style: solid solid solid none; border-color: transparent #d83c3c transparent; top: 12px; left: -6px; }
    
	.seach_invoice_form  button:focus:before{        border-right-color: #c42f2f;		margin-left:800px;    }    
	
	.button_example{    background: #d83c3c none repeat scroll 0 0;    border: 0 none;    color: #fff;    cursor: pointer;    float: right;    font: bold 15px/40px "lucida sans","trebuchet MS","Tahoma";    height: 35px;    overflow: visible;    padding: 0;        width: 100px; margin-left:10px;}

	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 5px;    padding: 10px 5px;    width: 130px;	}
	
	.input_type1{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 15px;    padding: 10px 5px;    width: 130px;	}
    
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
		
    if (!$("#orderid").val().match(/\S/) && !$("#invoiceno").val().match(/\S/) && !$("#p_name").val().match(/\S/) && !$("#todatepicker").val().match(/\S/) && !$("#fromdatepicker").val().match(/\S/) && !$("#bill_to").val().match(/\S/) ) {
        alert(" field is required !");
        return false;
    }
	 
		var datdiff=fromdatepicker-todatepicker;
		if(fromdatepicker<todatepicker){
			alert('From date Should B greater!');
			
			return false;
		}
	}
    </script>


<!--p style="padding: 5px 0 5px 5px; width:40%; float:left; "><a href="<?php //echo base_url();?>index.php/customer_orders/index" style="font-size:16px;">Reset All Filters</a></p-->

<?php 

	$error = array_filter($data);
 
	if (empty($error)){
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;">No Data Found!!!</div>';		
	}else{ 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;"><b>Total Recors : '. $total_count.'</b></div>';
?>  <div style="padding-bottom: 20px; float:right;">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
	<br>
	
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<th align="center">Name</th>
				<th align="center">Email</th> 
				<th align="center">Phone</th> 
				<th align="center">purity</th> 
				<th align="center">Customer Address</th> 
				<th align="center">Clarity</th> 
				<th align="center">Color</th> 
				<th align="center">Path/Sku</th> 
				<th align="center">Images</th> 
				<th align="center">Message</th> 
				<th align="center">Created Date</th>
				
			</tr>
		</thead>  
		<?php //echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img/'; ?> 	
	<?php
	//echo "<pre>"; print_r($data);
	 
			foreach($data as $row){ 
				
				// echo "<pre>";
				
				// print_r($row);
				
					//$options = unserialize($row['options']);
					$newstring = substr($row['img_path'], -3);

					$newstring; 
					
					
					
					//$img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];
					if($newstring=='png'){
					 $img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];
					$temp=1;
					}
					else if ($newstring=='gif'){
					$img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];	
					$temp=2;	
					}
					else if ($newstring=='jpg'){
					$img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];	
					$temp=3;	
					}
					else{
					$img=$row['img_path'];					
					$img1=$row['img_path'];					
					$_catalog = Mage::getModel('catalog/product');
					$_productId = $_catalog->getIdBySku($img);
					$_product = Mage::getModel('catalog/product')->load($_productId);
					
					$img=$_product->getImageUrl();			
					
					}
					
					// if($newstring!='gif' || $newstring!='jpg' || $newstring!='png'){
						
					//echo $img;
					
						
					// }
				
					
				?>
					<tr>
							<td align="center"><?php echo  $row['name'] ;?></td>
							<td align="center"><?php echo  $row['email'] ;?></td>
							<td align="center"><?php echo  $row['phone'] ;?></td>
							<td align="center"><?php echo  $row['gold_purity'] ;?></td>
							<td align="center"><?php echo  $row['addres'] ;?></td>
							<td align="center"><?php echo  $row['diamond_clarity']  ;?></td>   
							<td align="center"><?php echo  $row['gold_color']  ;?></td>
	<td align="center">
	<?php 
	
	$newstring1 = substr($row['img_path'], -3);
	if($newstring1=='png'){
					 $img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];
					//$temp=1;
					echo "N/A";
					}
					else if ($newstring1=='gif'){
					//$img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];	
					//$temp=2;	
					echo "N/A";
					}
					else if ($newstring1=='jpg'){
					//$img= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'customupload_img'.$row['img_path'];	
					//$temp=3;
					echo "N/A";
					}
					else{
						echo  $row['img_path'];
					}
	  ?>
	</td>   
		<td align="center">
		
		
		<a href="<?php echo $img; ?>" target="_blank">
	<img src="<?php  echo $img; ?>" alt="product image" height="50" width="50"></a>
		
		<?php // echo $img; ?>
		
		
		</td>   
							<td align="center"><?php echo  $row['message']  ;?></td>   
							<td align="center"><?php echo  $row['created_at']  ;?></td>   
							
					</tr>
				<?php   
			}
		 
	?>
	</table>
	<div style="float: right; display: table;">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
<?php  } ?> 

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

	
	.input_type{	 background: #eee none repeat scroll 0 0;    border: 0 none;    border-radius: 3px 0 0 3px;      margin-left: 500px;    padding: 10px 5px;    width: 130px;	}
	
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
	$( "#created_at" ).datepicker({ dateFormat: 'yy-mm-dd' ,maxDate: new Date() });	
});
</script>


	<script type="text/javascript">
	 function validateForm() { 
		
		var fromdatepicker=$("#fromdatepicker").val();
		var todatepicker = $("#todatepicker").val();
		var created_at = $("#created_at").val();
		// if(created_at!=''){
			// alert('FROM date Requied!');
			// return false;
		// }
		
		
  var fromdatepicker = jQuery("#todatepicker").val();
  
    if (fromdatepicker == null || fromdatepicker == "") {
        alert("From date be filled out");
        return false;
    }
		
		
	var fromdatepicker = jQuery("#fromdatepicker").val();
  
    if (fromdatepicker == null || fromdatepicker == "") {
        alert("To date be filled out");
        return false;
    }	
		// if(fromdatepicker ==''){
			// alert('FROM date Requied!');
			// return false;
		// }
		
		// if(todatepicker==''){
			// alert('To date Requied!');
			// return false;
		// }
		
    
		// var datdiff=fromdatepicker-todatepicker;
		// if(fromdatepicker<todatepicker){
			// alert('From date Should be greater to date!');
			
			// return false;
		// }
	}
    </script>
<form  name="myForm" id="myForm" action="<?php echo base_url();?>index.php/wishlist_report/index" onsubmit="return validateForm()" chars  method="get" accept-charset='UTF-8'>
    <div class="seach_invoice_form  cf">
	
	</div>
	
	<!--input type="hidden" name="page_count" value=10 /-->
	
	<div style="background-position: left;    margin-top: -75px;    position: absolute;">
	
		<input id="todatepicker" name="todatepicker" class ='input_type' type="text" name='from_date' placeholder="from date" value='<?php echo $_GET['todatepicker']; ?>'>
		
		<input id="fromdatepicker" name="fromdatepicker"   class ='input_type1' type="text" name='to_date' placeholder="to date" value='<?php echo $_GET['fromdatepicker']; ?>'>
		
	
		
		<button  class="button_example"  type="submit">Search</button>
	
	</div>
</form>

<p style="padding: 5px 0 5px 5px; width:40%; float:left; "><a href="<?php echo base_url();?>index.php/wishlist_report/index" style="font-size:16px;"></a></p>

<?php 

	if($results_count== 0){ 
		echo '<div style="color:#d83c3c; float:left; margin-top:5px;">No Data Found!!!</div>';		
	}else{ 
		$csv_url = base_url('index.php/wishlist_report/getCsv?todatepicker='.$_GET['todatepicker'].'&fromdatepicker='.$_GET['fromdatepicker'].'&bill_to='.$_GET['bill_to'].'&p_name='.$_GET['p_name'].'&orderid='.$_GET['orderid'].'&invoice_no='.$_GET['invoice_no'].'&created_at='.$_GET['created_at'].'  ');
		echo '<div style="color:#d83c3c;"><b>Result Counts '. $results_count.'</b></div>';
		
		//echo '<a style="width: 120px; color: #d83c3c; font-size:16px; float: right;position: relative" href="'.$csv_url.'">download Export</a>' ;
?>  
		
		
<div style="padding-bottom: 20px; float:right;">
	<?php  echo $this->pagination->create_links(); ?>
	</div>
	<br>
	
	<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				<th align="center">Product Id</th>
				<th align="center">Product Name</th>
				<th align="center">Sku</th>
				<th align="center">Updated At</th>
				<th align="center">Added At</th>
				<th align="center">Purchased</th>
				<th align="center">User Email</th> 
				<th align="center">Cat Breadcrumb</th> 
						
			</tr>
		</thead>  
			
	<?php
	
	
	 // echo "<pre>";
	 // print_r($search_data);
			foreach($search_data as $row){ 
				
				
						
		$_product = Mage::getModel('catalog/product')->load($row['product_id']); 
	  
   
			$categoryIds 	= 	$_product->getCategoryIds();	
			foreach($categoryIds as $_category) {
				$_categ = Mage::getModel('catalog/category')->load($_category);
				if($_categ->getIsActive()) {
					$cat_array[$_categ->getLevel()] = $_categ->getPath();
				}
			}
			krsort($cat_array);
			reset($cat_array);
			$a = current($cat_array);
			unset($cat_array);
			$a_cat = explode('/',$a);
			
			$category_name = '';
			foreach($a_cat as $value)	{
				if($value!=1 && $value!=2)
				{
					$_category 		= Mage::getModel('catalog/category')->load($value);
					$category_name .= $_category->getName().',';
					
				}
			}
			
		    $category_names = explode(',',$category_name);
   
		if($category_names[0]!=""){
						
					 $cat_0=$category_names[0].'>';	
					}
					if($category_names[1]!=""){
					 
					 $cat_1=$category_names[1].'>';	
						
					}if($category_names[2]!=""){
						
						 $cat_2=$category_names[2].'>';	
					}
					if($category_names[3]!=""){
						 
						 $cat_3=$category_names[3].'>';	
						
					}
				$product_type =  Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(),'candere_product_type');		
						
						
						
				?>
					<tr>
							<td align="center"><?php echo  $row['product_id'] ;?></td>
							<td align="center"><b><?php echo  $row['name'] ;?></b></td>
							<td align="center"><b><?php echo  $row['Sku'] ;?></b></td>
							<td align="center"><b><?php  echo  date('d-M-Y', strtotime($row['updated_at']));?></b></td>
							<td align="center"><b><?php  echo  date('d-M-Y', strtotime($row['added_at']));?></b></td>
							<td align="center"><b><?php echo  $row['purchased'] ;?></b></td>
							<td align="left"><?php echo  $row['email'] ;?></td> 
							<td align="left"><?php echo  $cat_0.$cat_1.$cat_2. $cat_3.''.$product_type; ?></td> 
							
										
							
				     </tr>
				<?php   
			}
		 
	?>
	</table>
	<div style="margin-left:1053px; margin-block-end:60px;">
	<?php  echo $this->pagination->create_links(); ?>
	</div> 
<?php  } ?> 
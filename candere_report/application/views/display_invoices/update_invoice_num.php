

<html>
<head>


<style>
#login-form { width: 300px;}

#login-form h3 { background-color: #282830; border-radius: 5px 5px 0 0; color: #fff;  padding: 20px; text-align: center;}

#login-form input[type="text"] { border-radius: 3px 3px 0 0; padding: 7px 10px;width: 100%; margin: 10 0 10 0;}

.styled-button-1 { background-color: rgba(53,86,129, 0.8);  border: 1px solid #17445e;  box-shadow: 0 1px 0 0 #3985b1 inset; color: #ffffff; cursor: pointer; display: inline-block; height: 33px; padding: 8px 18px; text-decoration: none; width: 82px;}

#login-form label {margin-top:5px;}
.container {  position: absolute; margin: -100px 0 0 -200px; top: 30%; left: 50%;}
</style>
<script>
$(function() {
$( "#invoice_date" ).datepicker({
	//changeMonth: true,
	//changeYear: true,
	dateFormat: 'dd-mm-yy', maxDate: new Date()
	});
});
</script>
</head>


<body> 
<div class="container">
  <div id="login-form">
    <h3>Update Invoice Number</h3>
    <fieldset>
      <form name="update_invoice_frm" id="update_invoice_frm" action="<?php echo base_url('index.php/display_invoices/save_invoice_num')?>" method="post">
		<label><b>Order Id</b></label>
        <input type="text" required name='increment_id' id='increment_id' value="<?php echo $increment_id ?>" readonly><br>
		<label><b>New Invoice Number</b></label>
        <input type="text" required placeholder="New Invoice Number" name='invoice_num' id='invoice_num' value="<?php echo set_value('invoice_num'); ?>"><br>
		
		<label><b>Invoice Date (DD-MM-YYYY)</b></label>
        <input type="text" required placeholder="Invoice Date" name='invoice_date' id='invoice_date' value="<?php echo $invoice_date; ?>"><br>
				
		<label><b>Current Invoice Number</b></label>
		<input type="text" name="previous_invoice_num" value="<?php echo $invoice_num ?>" readonly>
		<input type="hidden" name="id" value="<?php echo $id ?>" readonly>
        <input type="submit" value="Update" class="styled-button-1" style="float: left;margin-top: 10px;">
      </form>
    </fieldset>
  </div>
</div>


</body>
</html>
<!-- ALTER TABLE `candere_invoice` ADD `previous_invoice_num` VARCHAR(100) NOT NULL AFTER `created_by`; -->


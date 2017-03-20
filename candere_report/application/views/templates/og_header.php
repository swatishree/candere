<html>
<head>
<title>Welcome to CodeIgniter</title> 
	<link rel="stylesheet" href='<?php echo $this->config->base_url() ;?>themes/css/styles.css' type="text/css" media="screen, projection" />
	<link rel="stylesheet" href='<?php echo $this->config->base_url() ;?>themes/css/jquery-ui.css' type="text/css" media="screen, projection" />
	<link rel='stylesheet' type='text/css' href="<?php echo base_url();?>themes/css/erp.css" media='screen' charset='utf-8' />
	<script type='text/javascript' src='<?php echo base_url() ;?>themes/js/jquery-1.9.0.js'></script>    
	<script type='text/javascript' src='<?php echo base_url() ;?>themes/js/jquery-ui.min.js'></script>    
	<script type='text/javascript' src='<?php echo base_url() ;?>themes/js/jquery.validate.js'></script>  
	<script type='text/javascript' src='<?php echo base_url() ;?>themes/js/jquery-ui-timepicker-addon.js'></script>  
</head>
<body>
	<div class="head">
		<?php echo anchor('exportorders','Export Order Items'); ?> | 
		<?php echo anchor('krizda','Export All Products'); ?> | 
		<?php echo anchor('bluedartshippingprint','Bluedart Shipping Prints'); ?> | 
		<?php echo anchor('gold_coin_update_price','Update Gold Prices'); ?> |
		<?php echo anchor('price_computes','Export Products  with Metal and Sizing options'); ?> 
	</div>
	<div class="body">
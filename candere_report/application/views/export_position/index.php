<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page Popup</title>
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
</head>
<style>

.popHeading{
	margin-bottom:20px;
	font-size:24px;
	font-weight:normal;
	line-height:31px;
	text-transform:uppercase;
	letter-spacing:2px;
	color:#343339;
	margin-bottom:28px;
	padding-left:200px;
}
.popHeading span{
	color:#df6061;
}
.popInputText{
	font-size:13px;
	font-weight:normal;
	padding-top:8px;
	padding-bottom:16px;
}
.popTandC{
	font-size:13px;
	font-weight:normal;
	display:inline-block;
	margin-top:25px;
	margin-bottom:15px;	
}
.popSubC{
	font-size:13px;
	font-weight:normal;
	display:inline-block;
	line-height:19px;
}
.popSignup{
	font-size:20px;
	font-weight:normal;
	width:100%;
	height:36px;
	background-color:#fe8081;
	border:none;
	color:#fff;
	text-transform:uppercase;
	cursor:pointer;
}
.popSignup:focus{
	border:none;
	outline: none;
}
.popFooter{
	font-size:14px;
	line-height:18px;
	font-weight:normal;
	text-align:left;
	padding-left:5px;
}
.popHomeEmail{
	width:100%;
	display:block;
	padding:7px 10px;
	box-sizing:border-box;
	-moz-box-sizing:border-box;
}
.popCheckBox{
	vertical-align:middle;
}

</style>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  
<body>
<div >
	<div class="holder">
		<form name="frm" id="frm" method="post" >
		<br><br>
			<div class="popHeading">Product Position</div>		
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_position/position/" style="margin-left:200px;">Product Postion</a></b></span> 
			
		</form>
	</div>
</div>
</body>
</html>
 
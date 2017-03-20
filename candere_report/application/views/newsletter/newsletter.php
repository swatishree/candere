<html>
<head>
<title>Newsletter</title>
</head>
<body>

<br>

<div class="messages"> 
	<?php
		
		if($this->session->flashdata('message_arr')) {
			$message_arr = $this->session->flashdata('message_arr') ;
			
			foreach($message_arr as $key=>$value){
				echo '<span style="color:red;">'.$value.'</span>';
				echo '<br/>';
			}
		} 
	?>
	
</div>


<br>
<div class="basic-grey">
<!--<h2><a href="<?php //echo base_url('index.php/newsletter/export') ?>">Export Subscribers</a></h2>-->
</div>

<!--
<div class="line basic-grey">
			
	<form action="<?php echo base_url('index.php') ?>/newsletter/submit" enctype="multipart/form-data" accept-charset="utf-8" method="post" class="basic-grey" >
	<h1>Upload a CSV file with header <u>subscriber_email</u></h1>  		
		<label>
			<span>*Upload File :</span>
				<input type="file" name="file" >
		</label>	<br>
			 
		<label> 
			<span>&nbsp;</span> 
			<input type="submit" name="submit" class="button" value="Upload the files!"> <br><br>
		</label>	
	</form>
</div>	
<br>
-->

<?php echo form_open('newsletter/email_send',array('method' => 'post', 'class' => 'basic-grey')); ?>

    <h1>Send Emails (Fields marked as * are Required Fields)</h1>
    <label>
        <span>*Sender Name :</span>
			<?php echo form_input(array('name' => 'sender_name','id' => 'sender_name', 'class' => 'required','type'=>'text' , 'value' => set_value('name'), 'placeholder' => 'Your Full Name')); ?> 
		<br>
		<?php echo form_error('sender_name'); ?>
    </label>
	
	<label>
        <span>*Sender Email :</span>
		
		<?php echo form_input(array('name' => 'sender_email','id' => 'sender_email', 'class' => 'required','type'=>'text' , 'value' => set_value('sender_email'), 'placeholder' => 'Your Email')); ?> 
		<?php echo form_error('sender_email'); ?>
    </label>
	
	
	<label>
        <span>*Subject :</span>
		<?php echo form_input(array('name' => 'subject','id' => 'subject', 'class' => 'required','type'=>'text' , 'value' => set_value('subject'), 'placeholder' => 'Email Subject')); ?> 	
       
		<?php echo form_error('subject'); ?>
    </label>
    
    <label>
        <span>*Reciever Emails :
			<p>(Comma seperated emails in case of multiple email Id's)</p>
		</span>
		<?php echo form_textarea(array('name' => 'email','id' => 'email', 'class' => 'required','type'=>'text' , 'value' => set_value('email'), 'placeholder' => 'Comma seperated Reciever Emails',"rows"=>10 , "cols"=>100)); ?>
	 
		<?php echo form_error('email'); ?>
		
    </label>
    
    <label>
        <span>*Message :</span>
		<?php echo form_textarea(array('name' => 'message','id' => 'message', 'class' => 'required','type'=>'text' , 'value' => set_value('message'), 'placeholder' => 'Your Message',"rows"=>100 , "cols"=>100)); ?>	 
		<?php echo form_error('message'); ?>
    </label> 
     
     <label>
        <span>&nbsp;</span> 
        <input type="submit" name="submit" class="button" value="Send" /> 
    </label>    
<?php echo form_close() ?>


<style>
/* Basic Grey */
.basic-grey {
    margin-left:auto;
    margin-right:auto;
    max-width: 800px;
    background: #F7F7F7;
    padding: 25px 15px 25px 10px;
    font: 12px Georgia, "Times New Roman", Times, serif;
    color: #888;
    text-shadow: 1px 1px 1px #FFF;
    border:1px solid #E4E4E4;
}
.basic-grey h1 {
    font-size: 25px;
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom:1px solid #E4E4E4;
    margin: -10px -15px 30px -10px;;
    color: #888;
}
.basic-grey h1>span {
    display: block;
    font-size: 11px;
}
.basic-grey label {
    display: block;
    margin: 0px; 
	clear: both;
}
.basic-grey label p {
    text-align: right;
}
.basic-grey label>span {
    float: left;
    width: 25%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    color: #888;
}
.basic-grey input[type="text"], .basic-grey textarea, .basic-grey select {
    border: 1px solid #DADADA;
    color: #888;
    xheight: 30px;
    margin-bottom: 16px;
    margin-right: 6px;
    margin-top: 2px;
    outline: 0 none;
    padding: 3px 3px 3px 5px;
    width: 70%;
    font-size: 12px;
    line-height:15px;
    box-shadow: inset 0px 1px 4px #ECECEC;
    -moz-box-shadow: inset 0px 1px 4px #ECECEC;
    -webkit-box-shadow: inset 0px 1px 4px #ECECEC;
}
.basic-grey textarea{
    padding: 5px 3px 3px 5px;
}
.basic-grey select {
    background: #FFF url('down-arrow.png') no-repeat right;
    background: #FFF url('down-arrow.png') no-repeat right);
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
    height: 35px;
    line-height: 25px;
} 
.basic-grey .button {
    background: #E27575;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #FFF;
    box-shadow: 1px 1px 5px #B6B6B6;
    border-radius: 3px;
    text-shadow: 1px 1px 1px #9E3F3F;
    cursor: pointer;
}
.basic-grey .button:hover {
    background: #CF7A7A
}
.messages{
	text-align: center;
}
</style>
</body>
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd"
    >
<html lang="en">
<head>
    <title>Father's Day Contest</title>
	   	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<style type="text/css">
@font-face {
    font-family: Baroque Script;
    src: url(fonts/BaroqueScript.TTF);
}
    #wrapper {
        width: 700px;
		margin: 0 auto;
		
		
    }
	
	.small1{
		font-size: 41px;
		color: #000;
		font-family: Baroque Script;
		margin-bottom: 3px;
		font-style: italic;
		
		text-align: -webkit-center;
		clear: both;
		font-weight: bold;
		margin: auto;
    }
	
	.small2 {
        
        color:#000;
		width: 408px;
		margin-left: 135px;
        margin-bottom:3px;
		margin: auto;
		text-decoration: underline;
    }
	
	.small3 {
        
        color:#000;
		width: 408px;
		margin-left: 135px;
        font-family: Calibri;
		margin: auto;
		font-size: 14px;
    }
	
    legend {
        color:#0481b1;
        font-size:16px;
        padding:0 10px;
        background:#fff;
        -moz-border-radius:4px;
        box-shadow: 0 1px 5px rgba(4, 129, 177, 0.5);
        padding:5px 10px;
        text-transform:uppercase;
        font-family:Helvetica, sans-serif;
        font-weight:bold;
    }
    fieldset {
        border-radius:4px;
        background: #fff; 
        background: -moz-linear-gradient(#fff, #f9fdff);
        background: -o-linear-gradient(#fff, #f9fdff);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fff), to(#f9fdff)); /
        background: -webkit-linear-gradient(#fff, #f9fdff);
        padding:20px;
		width:517px;
		margin-left: 56px;  
		xborder-color:rgba(4, 129, 177, 0.4);
		border:none;

    }
    input,
    textarea {
        color: #373737;
        background: #fff;
        border: 1px solid #fffff;
        color: #aaa;
        font-size: 14px;
        line-height: 1.2em;
        margin-bottom:15px;

        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        border-radius:4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset, 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    input[type="text"],
    input[type="phone"]{
        padding: 8px 6px;
        height: 40px;
        width:280px;
    }
    input[type="text"]:focus,
    input[type="phone"]:focus {
        background:#f5fcfe;
        text-indent: 0;
        z-index: 1;
        color: #373737;
        -webkit-transition-duration: 400ms;
        -webkit-transition-property: width, background;
        -webkit-transition-timing-function: ease;
        -moz-transition-duration: 400ms;
        -moz-transition-property: width, background;
        -moz-transition-timing-function: ease;
        -o-transition-duration: 400ms;
        -o-transition-property: width, background;
        -o-transition-timing-function: ease;
        width: 380px;
        
        border-color:#ccc;
        box-shadow:0 0 5px rgba(4, 129, 177, 0.5);
        opacity:0.6;
    }
    input[type="submit"]{
        background: #222;
        border: none;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.3);
        text-transform:uppercase;
        color: #eee;
        cursor: pointer;
        font-size: 15px;
        margin: 5px 0;
        padding: 5px 22px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-border-radius:4px;
        -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        -moz-box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
    }
    textarea {
        padding:3px;
        width:91%;
        height:100px;
    }
    textarea:focus {
        background:#ebf8fd;
        text-indent: 0;
        z-index: 1;
        color: #373737;
        opacity:0.6;
        box-shadow:0 0 5px rgba(4, 129, 177, 0.5);
        border-color:#ccc;
    }
    .small {
        line-height:14px;
        color:#999898;
        margin-bottom:3px;
		font-family: Calibri; 
		color: #000;
    }
	
	 .black_overlay{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: 50%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
		
    }
</style>
<style type="text/css">
        .ui-dialog .ui-dialog-content
        {
            position: relative;
            border: 0;
            padding: .5em 1em;
            background: none;
            overflow: auto;
            zoom: 1;
            background-color: #ffd;
            border: solid 1px #ea7;
        }

        .ui-dialog .ui-dialog-titlebar
        {
            display:none;
        }

        .ui-widget-content
        {
            border:none;
        }

		.footer {
			border-top: 0px solid #D0D0D0;
		}
    </style>
<script>


$(document).ready(function(){   

    $("#submit").click(function()
    {
		var x =$("#email").val();
		
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if($("#name").val()==''){
			
			alert('please enter the name');
			
			return false;
		}
		
		if(($("#phone").val().length)!='10'){
			
			alert('please enter the valid Mobile Number');
			
			return false;
		}
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
		}
		if($("#message").val()==''){
			
			alert('please enter the message');
			
			return false;
		}
		
     $.ajax({
         type: "POST",
         url: "https://www.candere.com/candere_report/index.php/valentines",    
         data: {name: $("#name").val(),phone: $("#phone").val(),email: $("#email").val(),message: $("#message").val()},
         success: 
              function(data){
              
			$( "#dialog" ).dialog().fadeOut(4000).html('Thanks for participating! <br> Happy Fathers Day </br>');
			
              }
			  
          });// you have missed this bracket
     return false;
 });
 
 });

</script>

<body style="background-image: url(http://canderemail.com/newsletters/valentines/BG.jpg);">

    <div id="wrapper">
	<div class="small1">
              Father's Day Contest
            </div>
		<div class="small2">
               <h3>Tell us, the moments in your life for which you want to thank your father!</h3>
        </div>
		<div class="small3">
               <h3>Best Message will win the Yatra vouchers worth INR 5000 every day
			  </h3>
        </div>
		
		
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
		
		<br>
            <fieldset style="background-image: url(http://canderemail.com/newsletters/valentines/message-bg.jpg);">
              
                <div class="small">
                    <input type="text" name="name" id="name" placeholder="Name"/>
                </div>
                
                <div>
                    <input type="phone" name="phone" id="phone" placeholder="phone" />
                </div>
                <div class="small">
                    <input type="text" name="email" id="email" placeholder="Email" />
                </div>
                <div class="small">
                    <div class="small">Share your message. </div>
                    <textarea name="message" id="message" placeholder="Message"></textarea>
                </div>    
                <input type="submit" name="submit" id="submit" value="Send"/>				
				<br>
				<br>
				<div>
                    <div class="small">Terms & Conditions.</div>
                </div>
				
				<div>
                    <ul>
					
					<li class="small"> 
					  Message can be added/dedicated only once by an individual.
					</li>
					<li class="small"> 
					  Message sent will be eligible only when the email id and phone no. is entered.
					</li>
					
					</ul>
					
                </div>
				
            </fieldset>    
        </form>
    </div>
	<p id="dialog" style="text-align:center;padding:50px">
 
</p>
	
</body>
</html>

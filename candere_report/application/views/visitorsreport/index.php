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
	
	h1{font-size: 16px;}
	table{border:1px solid;font-size: 14px;}
	table tr td,table tr th{border:1px solid;}
	table tr:nth-child(even) {background: #EEE9E9}
	table tr:nth-child(odd) {background: #FFF} 
</style> 



		
<table class="seach_invoice_table" width="100%" cellpadding="5" cellspacing="0">
	<thead>
			<tr>
				
				<th align="center">Visitor Id</th>
				<th align="center">First Visit At</th>
				<th align="center">Last Visit At</th>
				<th align="center">Visit Time</th>
				<th align="center">url</th>
				<th align="center">Referer URl</th>
				<th align="center">Customer Id</th>
				<th align="center">Login_at</th>
				<th align="center">Logout At</th>
				<th align="center">Product Id</th>
				<th align="center">Product Added</th>
				<th align="center">Product Name</th>
				<th align="center">IP</th>
				
				<th align="center">City</th>
				<th align="center">Region</th>
				<th align="center">Country Code</th>
				<th align="center">Latitude</th>
				<th align="center">Longitude</th>
				<th align="center">Device type</th>
						
			</tr>
		</thead>  
			
	<?php
	 
			foreach($search_data as $row){ 
				
		$ip=$row['remote_ip'];
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		$str=explode(',',$details->loc);
		//$hostname = gethostbyaddr($details->hostname);

		
		
		// function isMobile() {
			
			// return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $row['http_user_agent']);
		// }
		
		// if(isMobile()==true){
		  // $device ='Mobile';
		// }else{
			
			 // $device ='PC';
			
		// }
				?>
					<tr>    
							
							<td align="center"><b><?php echo  $row['visitor_id'] ;?></td>
							<td align="center"><b><?php echo  $row['first_visit_at'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['last_visit_at'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['visit_time'] ; ?></b></td>
							<td align="center"><b><?php echo  $row['url'] ;?></td>
							<td align="center"><b><?php echo  $row['referer'] ;?></td>
							<td align="center"><b><?php echo  $row['customer_id'] ;?></td>							
							<td align="center"><b><?php echo  $row['login_at']; ?></b></td>
							<td align="center"><b><?php echo  $row['logout_at']; ?></b></td>
							<td align="center"><b><?php echo  $row['product_id']; ?></b></td>
							<td align="center"><b><?php echo  $row['added_at']; ?></b></td>
							<td align="center"><b><?php echo  $row['name']; ?></b></td>
							<td align="center"><b><?php echo  $row['remote_ip']; ?></b></td>
							
							<td align="center"><b><?php echo  $details->city; ?></b></td>
							<td align="center"><b><?php echo  $details->region; ?></b></td>
							<td align="center"><b><?php echo  $details->country; ?></b></td>
							<td align="center"><b><?php echo  $str[0]; ?></b></td>
							<td align="center"><b><?php echo  $str[1]; ?></b></td>
							<td align="center"><b><?php echo  $device; ?></b></td>
					</tr>
				<?php   
			}
		 
	?>
	</table>	
 
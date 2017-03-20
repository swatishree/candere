<?php set_time_limit(0); ?>
<?php $this->load->library('session'); ?>
<script>
jQuery(function() {
jQuery( "#date_from" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'
	});
jQuery( "#date_to" ).datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'
	});
});
</script>
<br> 


<style>
	.search_term, .hasDatepicker{height: 28px; width: 130px;}
	.btn_sub {  width: 100px; height: 30px;
</style>


<?php
	$html = '';
	$html .= '<table border="1" cellpadding="5" cellspacing="0" style="margin:0 auto; text-align: center;">';
	$html .= '<tr>
				<th>No of Visitors</th><th>Campaign Name</th>
			</tr>';	
?>			

<?php 
	function in_array_r($item , $array){
		return preg_match('/"'.$item.'"/i' , json_encode($array));
	}
	
	
	function msort($array, $key, $sort_flags = SORT_REGULAR) {
		if (is_array($array) && count($array) > 0) {
			if (!empty($key)) {
				$mapping = array();
				foreach ($array as $k => $v) {
					$sort_key = '';
					if (!is_array($key)) {
						$sort_key = $v[$key];
					} else {
						// @TODO This should be fixed, now it will be sorted as string
						foreach ($key as $key_key) {
							$sort_key .= $v[$key_key];
						}
						$sort_flags = SORT_STRING;
					}
					$mapping[$k] = $sort_key;
				}
				asort($mapping, $sort_flags);
				$sorted = array();
				foreach ($mapping as $k => $v) {
					$sorted[] = $array[$k];
				}
				return $sorted;
			}
		}
		return $array;
	}
	

	if(isset($_POST) && !empty($_POST)){
		
		$date_from 		= $_POST['date_from'];
		$date_to 		= $_POST['date_to'];
		
		$mysql_date_from = strtotime(date('Y-m-d', strtotime($date_from)));
		$mysql_date_to = strtotime(date('Y-m-d', strtotime($date_to)));
			 
		if($mysql_date_from > $mysql_date_to){
			echo '<p style="color:red;text-align:center;">From date should be less than date to</p>';
		}
	
		$this->session->set_userdata(array(
				'date_from'     => $date_from,
				'date_to'       => $date_to,
		));
		
		$session_date_from   	= $this->session->userdata('date_from');
		$session_date_to  		= $this->session->userdata('date_to');
	}?>
	
<div style="margin:0 auto; text-align: center;">
	<form name="cart_form" id="cart_form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
		<input type="text" name="date_from" id="date_from" value="<?php echo $session_date_from ?>" placeholder="Date From"/>
		&nbsp;&nbsp;&nbsp;
		<input type="text" name="date_to" id="date_to" value="<?php echo $session_date_to ?>" placeholder="Date To"/>
		<br><br>
		<input type="submit" name="submit" value="Search" class="btn_sub">
		<br>
	</form>
</div>
	
<?php		

		if($date_from != '' && $date_to != '') {
					
			//$sql = "select distinct a.http_referer as http_referer from log_visitor_info a inner join log_visitor b on a.visitor_id =  b.visitor_id where b.last_url_id !=0 and Date(b.first_visit_at) between '$date_from' AND '$date_to' and a.http_referer REGEXP 'utm_campaign'";
			
			$sql = "select distinct a.http_referer as http_referer from log_visitor_info a inner join log_visitor b on a.visitor_id =  b.visitor_id where DATE(b.first_visit_at) between '$date_from' AND '$date_to' and a.http_referer REGEXP 'utm_campaign'";
					
			$vis_results 		= $this->db->query($sql);
			$vis_result 		= $vis_results->result_array();
				
			$unique_arr = array();
			
			foreach($vis_result as $row) {
									
				$http_referer = $row['http_referer'];
				
				$url = parse_url($http_referer); 
				
				$utm_campaign_data = explode('utm_campaign=', $url['query']);
											
				if(strpos($utm_campaign_data[1],'&') !== false) {
				
					$utm_campaign_res 	= explode('&', $utm_campaign_data[1]);
					$utm_campaign 		= $utm_campaign_res[0];
					
				}else {
					$utm_campaign = $utm_campaign_data[1];
				}
							
				if(!in_array_r($utm_campaign, $unique_arr)){
			
					$new_array = array("utm_campaign" => $utm_campaign);
					
					array_push($unique_arr, $new_array);	
				}
			}
		}
		
			
			if($unique_arr) {
			
			$unique_arr = msort($unique_arr, array('utm_campaign'));
			
				foreach($unique_arr as $val) {
					$utm_campaign_name = $val['utm_campaign'];
					
					if($utm_campaign_name != '') {
					
						//$sql = "select count(distinct a.visitor_id) as count from log_visitor_info a inner join log_visitor b on a.visitor_id =  b.visitor_id where b.last_url_id !=0 and Date(b.first_visit_at) between '$date_from' AND '$date_to' and a.http_referer REGEXP '$utm_campaign_name'";
						
						$sql = "select count(distinct a.visitor_id) as count from log_visitor_info a inner join log_visitor b on a.visitor_id = b.visitor_id where b.last_url_id !=0 and DATE(b.first_visit_at) between '$date_from' AND '$date_to' and a.http_referer LIKE '%$utm_campaign_name%'";
					
						$results 			= $this->db->query($sql);
						$result 			= array_shift($results->result_array());
						
						$total_vis_count 	= $result['count'];
																
						$html .= "<tr>
									<td>$total_vis_count</td> <td>$utm_campaign_name</td>
								</tr>";
					}
				}
				//unset($unique_arr);
			}
				
	$html .= '</table>';

	if($unique_arr) echo $html; 
?>		

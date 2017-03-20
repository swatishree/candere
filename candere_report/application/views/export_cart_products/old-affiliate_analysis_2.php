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
				<th>Visitors</th>  <th>Name of Affiliate</th> <th>Campaign</th><th>Source</th>
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
	}
	 
		if($date_from != '' && $date_to != '') {
			
			$sql = "SELECT distinct sales_flat_quote.affiliate_id, sales_flat_quote.affiliate_medium, sales_flat_quote.affiliate_source  FROM  sales_flat_quote sales_flat_quote
			WHERE sales_flat_quote.reserved_order_id IS NULL AND Date(sales_flat_quote.updated_at) between '$date_from' AND '$date_to' AND sales_flat_quote.affiliate_id IS NOT NULL GROUP by sales_flat_quote.affiliate_id";
	 
			$results 	= $this->db->query($sql);
			$arr_1 	= $results->result_array();
			
			
			$sql = "SELECT distinct customer_queries.affiliate_id, customer_queries.affiliate_medium, customer_queries.affiliate_source from customer_queries customer_queries where affiliate_id IS NOT NULL AND Date(customer_queries.created_at)  between '$date_from' AND '$date_to' GROUP by customer_queries.affiliate_id";
					
			$service_results 	= $this->db->query($sql);
			$arr_2 	= $service_results->result_array();	
			
			
			$sql = "select distinct newsletter_subscriber.affiliate_id, newsletter_subscriber.affiliate_medium, newsletter_subscriber.affiliate_source from newsletter_subscriber  newsletter_subscriber where Date(newsletter_subscriber.subscription_date) between '$date_from' AND '$date_to' and newsletter_subscriber.subscriber_status = 1 GROUP BY newsletter_subscriber.affiliate_id ";
			
			$sub_results 	= $this->db->query($sql);
			$arr_3 	= $sub_results->result_array();
			
			$merged_arr = array_merge($arr_1,$arr_2,$arr_3);	
		}	
				
				
		$unique_arr = array();
		
		if($merged_arr) {
			
			foreach($merged_arr as $row) {
		
				$affiliate_id 		=  trim($row['affiliate_id']);
				$affiliate_medium 	=  trim($row['affiliate_medium']);
				$affiliate_source 	=  trim($row['affiliate_source']);
							
				if(!in_array_r($affiliate_id , $unique_arr)){
			
					$new_array = array("affiliate_id" => $affiliate_id, "affiliate_medium" =>$affiliate_medium, 'affiliate_source'=>$affiliate_source);
					
					array_push($unique_arr, $new_array);		
				}
			}
		}
		
			
		if($unique_arr) {
		
		$unique_arr = msort($unique_arr, array('affiliate_id'));
		
			foreach(array_filter($unique_arr) as $key=>$value) {
		
				$affiliate_id 		= $value['affiliate_id'];
				$affiliate_medium 	= $value['affiliate_medium'];
				$affiliate_source 	= $value['affiliate_source'];	
								
				
				if($affiliate_id) {
					$sql = "select count(a.visitor_id) as count from log_visitor_info a inner join log_visitor b on a.visitor_id =  b.visitor_id where a.http_referer REGEXP '$affiliate_id' AND b.last_url_id !=0 and Date(b.first_visit_at) between '$date_from' AND '$date_to'";
				
					$vis_results 		= $this->db->query($sql);
					$vis_result 		= array_shift($vis_results->result_array());		
					$total_vis_count 	= $vis_result['count'];
					
					$html .= "<tr>
						<td>$total_vis_count</td> <td>$affiliate_medium </td> <td>$affiliate_id</td><td>$affiliate_source</td>
					</tr>";
				}
											
			}
		}
				
	$html .= '</table>';
?>  
	

<div style="margin:0 auto; text-align: center;">
	<form name="cart_form" id="cart_form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">

		<input type="text" name="date_from" id="date_from" value="<?php echo $session_date_from ?>" placeholder="Date From"/>
		&nbsp;&nbsp;&nbsp;
		<input type="text" name="date_to" id="date_to" value="<?php echo $session_date_to ?>" placeholder="Date To"/>

		<br><br>
		<input type="submit" name="submit" value="submit" class="btn_sub">
		<br>
	</form>
</div>

<?php if($unique_arr) { echo $html; } ?>
		

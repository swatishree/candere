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
				<th>Visitors</th>  <th>Utm Params</th>
			</tr>';
?>	


<?php 

	function in_array_r($item , $array){
		return preg_match('/"'.$item.'"/i' , json_encode($array));
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
		
		$unique_array[] = array('utm_param'=>'utm_source=LV-6&utm_medium=email&utm_campaign=LV-birthstone_14_sep_2015');
		$unique_array[] = array('utm_param'=>'utm_source=LV-9&utm_medium=email&utm_campaign=LV-birthstone_14_sep_2015');
		$unique_array[] = array('utm_param'=>'utm_source=LV-4&utm_medium=email&utm_campaign=LV-birthstone_14_sep_2015');
		$unique_array[] = array('utm_param'=>'utm_source=LV-5&utm_medium=email&utm_campaign=LV-birthstone_14_sep_2015');
		$unique_array[] = array('utm_param'=>'utm_source=km&utm_medium=cpv&utm_campaign=KM-gods_love_10_sep_2015');
		$unique_array[] = array('utm_param'=>'utm_source=km&utm_medium=cpv&utm_campaign=KM-ganesha_10_sep_2015');
		

		
		foreach($unique_array as $row) {
			
			$utm_param = $row['utm_param'];
			
			$sql = "select count(a.visitor_id) as count from log_visitor_info a inner join log_visitor b on a.visitor_id =  b.visitor_id where a.http_referer REGEXP '$utm_param' AND b.last_url_id !=0 and Date(b.first_visit_at) between '$date_from' AND '$date_to'";
	
			$vis_results 		= $this->db->query($sql);
			$vis_result 		= array_shift($vis_results->result_array());		
			$total_vis_count 	= $vis_result['count'];
			
			
			$html .= "<tr>
					<td>$total_vis_count</td> <td>$utm_param </td>
				</tr>";
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

<?php echo $html; ?>
		

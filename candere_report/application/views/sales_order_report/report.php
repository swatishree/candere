<?php 
$today_curr_mnth 			= date('Y-m-d');
$first_day_current_mnth 	= date('Y-m-01');
$last_day_this_month  		= date('Y-m-t');
$first_day_previous_mnth 	= date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y")));
$last_day_previous_mnth 	= date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y")));


/******** Today's total count ***************/
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) = '$today_curr_mnth')");
$total_orders_today = array_shift($sql->result_array()); 
$total_count_today 	= isset($total_orders_today['count']) ? $total_orders_today['count'] : 0;


/******** Today's total order value ***************/
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) = '$today_curr_mnth')");
$total_paid_data 	= array_shift($sql->result_array()); 
$total_paid_today 	= isset($total_paid_data['base_grand_total']) ? $total_paid_data['base_grand_total'] : 0;


/******** This month total count ***************/
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN
            ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_current_mnth'    AND '$last_day_this_month')");
$total_orders_month 	= array_shift($sql->result_array()); 
$total_count_orders_month = isset($total_orders_month['count']) ? $total_orders_month['count'] : 0;



/******** This month total order value ***************/
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN
            ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_current_mnth'    AND '$last_day_this_month')");			
$total_value_this_month = array_shift($sql->result_array()); 
$total_order_value_this_month = isset($total_value_this_month['base_grand_total']) ? $total_value_this_month['base_grand_total'] : 0;



/******** Last month total count ***************/
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN
            ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_previous_mnth'    AND '$last_day_previous_mnth')");			
$total_orders_last_month = array_shift($sql->result_array()); 
$total_count_last_month = isset($total_orders_last_month['count']) ? $total_orders_last_month['count'] : 0;



/******** Last month total order value ***************/		
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM sales_flat_order_payment sales_flat_order_payment
    INNER JOIN
        sales_flat_order sales_flat_order
    ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE ( (sales_flat_order.base_total_paid > 0)
       AND  (sales_flat_order_payment.emi_amount = 0) AND (sales_flat_order.state NOT IN
            ('canceled', 'closed')) ) AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_previous_mnth'    AND '$last_day_previous_mnth')");	
			
$total_value_last_month = array_shift($sql->result_array()); 
$total_order_value_last_month = isset($total_value_last_month['base_grand_total']) ? $total_value_last_month['base_grand_total'] : 0;





/******** Cancelled orders count today ************** Done */
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) = '$today_curr_mnth')");   
$total_cancelled_today 			= array_shift($sql->result_array()); 
$total_cancelled_count_today 	= isset($total_cancelled_today['count']) ? $total_cancelled_today['count'] : 0;


/******** Today's Cancelled orders total value ************** Done */
$sql = $this->db->query("SELECT sum(sales_flat_creditmemo.base_grand_total) as base_total_refunded
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) = '$today_curr_mnth')");
$total_total_refunded 	= array_shift($sql->result_array());
$today_total_refunded 	= isset($total_total_refunded['base_total_refunded']) ? $total_total_refunded['base_total_refunded'] : 0;




/******** This month total cancelled count ************** Done */
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) between '$first_day_current_mnth'  AND '$last_day_this_month')");
$total_orders_cancel 	= array_shift($sql->result_array()); 
$total_orders_cancel_cur_mnth = isset($total_orders_cancel['count']) ? $total_orders_cancel['count'] : 0;


/******** This month total cancelled value ************** Done*/
$sql = $this->db->query("SELECT sum(sales_flat_creditmemo.base_grand_total) as base_total_refunded
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) between '$first_day_current_mnth' AND '$last_day_this_month')");
$total_refunded_this_mnth	= array_shift($sql->result_array()); 
$total_value_cancel_cur_mnth = isset($total_refunded_this_mnth['base_total_refunded']) ? $total_refunded_this_mnth['base_total_refunded'] : 0;


/******** Last month total cancelled count *************** Done */
$sql = $this->db->query("SELECT count(distinct(sales_flat_order.entity_id)) as count
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) between '$first_day_previous_mnth'  AND '$last_day_previous_mnth')");
$last_month_cancel_data = array_shift($sql->result_array()); 
$last_month_cancel_count = isset($last_month_cancel_data['count']) ? $last_month_cancel_data['count'] : 0;


/******** Cancelled orders Last month value *************** Done */
$sql = $this->db->query("SELECT sum(sales_flat_creditmemo.base_grand_total) as base_total_refunded
  FROM    sales_flat_creditmemo sales_flat_creditmemo
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id)
 WHERE     (sales_flat_creditmemo.base_grand_total = sales_flat_order.base_grand_total)
       AND (Date(sales_flat_creditmemo.created_at) between '$first_day_previous_mnth'  AND '$last_day_previous_mnth')");
$total_refunded_last_month	= array_shift($sql->result_array()); 
$last_month_total_refunded 	= isset($total_refunded_last_month['base_total_refunded']) ? $total_refunded_last_month['base_total_refunded'] : 0;





/******** Today's EMI order count ****************/
$sql = $this->db->query("SELECT COUNT(DISTINCT sales_flat_order.entity_id) AS count
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (      (   sales_flat_order_payment.emi_amount > '0' )
                  AND (sales_flat_order.base_total_paid > 0)
             AND (Date(sales_flat_order.created_at) = '$today_curr_mnth')
        AND (sales_flat_order.state NOT IN ('canceled', 'closed'))  )");
$todays_emi_orders	= array_shift($sql->result_array()); 
$todays_emi_count 	= isset($todays_emi_orders['count']) ? $todays_emi_orders['count'] : 0;


/******** Today's EMI order value ****************/
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (  ( sales_flat_order_payment.emi_amount > '0' )
                AND (sales_flat_order.base_total_paid > 0)
            AND (Date(sales_flat_order.created_at) = '$today_curr_mnth')
        AND (sales_flat_order.state NOT IN ('canceled', 'closed'))  )");	   
$todays_month_emi_values	= array_shift($sql->result_array()); 
$todays_month_emi_value 	= isset($todays_month_emi_values['base_grand_total']) ? $todays_month_emi_values['base_grand_total'] : 0;



/******** This Month EMI order count ****************/
$sql = $this->db->query("SELECT COUNT(DISTINCT sales_flat_order.entity_id) AS count
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (      (   sales_flat_order_payment.emi_amount > '0' )
                  AND (sales_flat_order.base_total_paid > 0)
             AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_current_mnth' AND '$last_day_this_month')
        AND (sales_flat_order.state NOT IN ('canceled', 'closed'))  )");	
$this_month_emi_orders	= array_shift($sql->result_array()); 
$this_month_emi_count 	= isset($this_month_emi_orders['count']) ? $this_month_emi_orders['count'] : 0;


/******** This Month EMI order value ****************/
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (  ( sales_flat_order_payment.emi_amount > '0' )
                AND (sales_flat_order.base_total_paid > 0)
            AND (Date(sales_flat_order.created_at) between '$first_day_current_mnth' AND '$last_day_this_month')
        AND (sales_flat_order.state NOT IN  ('canceled', 'closed'))  )");
$this_month_emi_values	= array_shift($sql->result_array()); 
$this_month_emi_value 	= isset($this_month_emi_values['base_grand_total']) ? $this_month_emi_values['base_grand_total'] : 0;




/******** Last Month EMI order count ****************/
$sql = $this->db->query("SELECT COUNT(DISTINCT sales_flat_order.entity_id) AS count
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (      (   sales_flat_order_payment.emi_amount > '0' )
                  AND (sales_flat_order.base_total_paid > 0)
             AND (Date(sales_flat_order.created_at) BETWEEN '$first_day_previous_mnth' AND '$last_day_previous_mnth')
        AND (sales_flat_order.state NOT IN ('canceled', 'closed'))  )");
$last_month_emi_orders	= array_shift($sql->result_array()); 
$last_month_emi_count 	= isset($last_month_emi_orders['count']) ? $last_month_emi_orders['count'] : 0;




/******** Last Month EMI order value ****************/
$sql = $this->db->query("SELECT sum(sales_flat_order.base_grand_total) as base_grand_total
  FROM    sales_flat_order_payment sales_flat_order_payment
       INNER JOIN
          sales_flat_order sales_flat_order
       ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
 WHERE (  ( sales_flat_order_payment.emi_amount > '0' )
                AND (sales_flat_order.base_total_paid > 0)
            AND (Date(sales_flat_order.created_at) between '$first_day_previous_mnth' AND '$last_day_previous_mnth')
        AND (sales_flat_order.state NOT IN ('canceled', 'closed'))  )");
$last_month_emi_value	= array_shift($sql->result_array()); 
$last_month_emi_value 	= isset($last_month_emi_value['base_grand_total']) ? $last_month_emi_value['base_grand_total'] : 0;

//echo $this->db->last_query(); exit;					
					
//echo '<pre>'; print_r($total_orders_today); exit;


?>

<div class="report_container">

<p class="report_label"><b>Sales Report</b></p>

<table style="font-size:20px;" border="1" id="example" cellspacing=0 cellpadding=0 width="1000" >
	
	<tr>
		<th rowspan="2">&nbsp;</th>
		<th colspan="2">Order</th>
		<th colspan="2">EMI Orders</th>
		<th colspan="2">Refund Orders</th>
	</tr>
	
	<tr>
		<th align="center">Order Count</th>
		<th align="center">Order Value</th>
		<th align="center">Order Count</th>
		<th align="center">Order Value</th>
		<th align="center">Order Count</th>
		<th align="center">Order Value</th>
	</tr>
	
	<tr>
		<th>Today</th>
		<td align="center"><?php echo $total_count_today ?></td>
		<td align="center"><?php echo $total_paid_today ?></td>
		<td align="center"><?php echo $todays_emi_count ?></td>
		<td align="center"><?php echo $todays_month_emi_value ?></td>
		<td align="center"><?php echo $total_cancelled_count_today ?></td>
		<td align="center"><?php echo $today_total_refunded ?></td>
	</tr>
	
	<tr>
		<th>This Month</th>
		<td align="center"><?php echo $total_count_orders_month ?></td>
		<td align="center"><?php echo $total_order_value_this_month ?></td>
		<td align="center"><?php echo $this_month_emi_count ?></td>
		<td align="center"><?php echo $this_month_emi_value ?></td>
		<td align="center"><?php echo $total_orders_cancel_cur_mnth ?></td>
		<td align="center"><?php echo $total_value_cancel_cur_mnth ?></td>
	</tr>
	
	<tr>
		<th>Last Month</th>
		<td align="center"><?php echo $total_count_last_month ?></td>
		<td align="center"><?php echo $total_order_value_last_month ?></td>
		<td align="center"><?php echo $last_month_emi_count ?></td>
		<td align="center"><?php echo $last_month_emi_value ?></td>
		<td align="center"><?php echo $last_month_cancel_count ?></td>
		<td align="center"><?php echo $last_month_total_refunded ?></td>
	</tr>
</table>

</div>

<style>
.report_container{margin:3% 6%; font-size:25px;}
.report_container .report_label {padding: 15px;}
.report_container tr { line-height: 25px; }
.report_container tr th{ font-weight: bold; }
</style>
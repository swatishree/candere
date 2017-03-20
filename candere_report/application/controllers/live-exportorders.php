<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exportorders extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		
		$message_arr = array(''); 
	  
	 
		$this->load->view('templates/header'); 
        $this->load->view("exportorders/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function exportorderaffiliate()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$sql = "SELECT sales_flat_order.increment_id AS order_id,
				   sales_flat_order.base_grand_total,
				   sales_flat_order.base_total_paid,
				   sales_flat_order.grand_total,
				   sales_flat_order.total_paid,
				   sales_flat_order.affiliate_id,
				   sales_flat_order.created_at,
				   sales_flat_order_payment.method AS payment_method,
				   sales_order_status.label as order_status
			  FROM    (   sales_flat_order sales_flat_order
					   INNER JOIN
						  sales_order_status sales_order_status
					   ON (sales_flat_order.status = sales_order_status.status))
				   INNER JOIN
					 sales_flat_order_payment sales_flat_order_payment
				   ON (sales_flat_order_payment.parent_id = sales_flat_order.entity_id)
			ORDER BY sales_flat_order.entity_id DESC";
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
				
		//array_unshift($result);
		 
		array_to_csv($result,'sales_orders_with_affiliates'.date('d-M-y').'.csv');
	}
	 
	
	public function customer_address_with_order_export()
	{  
		$this->db->cache_delete_all();
		
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->fn_customer_address_with_order_export_query();
		 
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 
		//array_to_csv($sql,'customer_address_with_order_export_'.date('d-M-y').'.csv'); 
		
		query_to_csv($sql,true,'customer_address_with_order_export_'.date('dMy').'.csv');  
		 
	} 
	
	public function customer_address_with_order_export_without_product()
	{  
		$this->db->cache_delete_all();
		
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->fn_customer_address_with_order_export_without_product_query();
		 
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 
		//array_to_csv($sql,'customer_address_with_order_export_'.date('d-M-y').'.csv'); 
		
		query_to_csv($sql,true,'customer_address_with_order_export_without_product_query'.date('dMy').'.csv');  
		 
	} 
	
	
	public function export()
	{  
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunction();
				
		foreach($sql as $row) {
			
			$product_options = unserialize($row->product_options);
			$additional_options = $product_options['additional_options'];
			$last_element = end($additional_options);
			
			$increment_id 	= $row->increment_id;
			$name 			= $row->name;
			$sku 			= $row->sku;
			$row_total 		= $row->row_total;
			$status 		= $row->status;
			$expected_delivery_date = $last_element['value'] ;
			
			$array[] = array('increment_id'=>$increment_id, 'name'=>$name, 'sku'=>$sku, 'row_total'=>$row_total, 'status'=>$status, 'expected_delivery_date'=>$expected_delivery_date); 
		}
		 
		
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 
		//array_to_csv($sql,'export_orders_items_'.date('d-M-y').'.csv'); 
		array_to_csv($array,'export_orders_items_'.date('d-M-y').'.csv'); 
		 
	} 
	  
	
	public function myqueryfunction(){	
		 
		$sql =	"SELECT DISTINCT sales_flat_order.increment_id,
                sales_flat_order_item.name,
                sales_flat_order_item.sku,
                sales_flat_order_item.row_total,
                sales_flat_order.grand_total,
                sales_order_status.label AS status,
                sales_flat_order_item.product_options
  FROM    (   sales_flat_order_item sales_flat_order_item
           INNER JOIN
              sales_flat_order sales_flat_order
           ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_order_status sales_order_status
       ON (sales_order_status.status = sales_flat_order.status)"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result();
		 
		$result[-1]['increment_id'] = 'Increment ID';
		$result[-1]['name'] = 'Name';
		$result[-1]['sku'] = 'Sku';
		$result[-1]['row_total'] = 'Row Total';
		$result[-1]['grand_total'] = 'Grand Total';
		$result[-1]['status'] = 'Status'; 
		$result[-1]['expected_delivery_date'] = 'expected_delivery_date'; 
		 
		rsort($result); 
		return $result ;
	}
	
	
	
	public function export_old()
	{  
		$message_arr = array('');
		//$this->load->library('export'); 
		$this->load->helper('csv');
		$sql = $this->myqueryfunction();
		
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 
		array_to_csv($sql,'export_orders_items_'.date('d-M-y').'.csv'); 
		 
	} 
	  
	
	public function myqueryfunction_old(){	
		 
		$sql =	"SELECT sales_flat_order.increment_id,
       sales_flat_order_item.name,
       sales_flat_order_item.sku,
       sales_flat_order_item.row_total,
       sales_flat_order.grand_total,
       sales_order_status_label.label as status
  FROM    (   sales_flat_order sales_flat_order
           INNER JOIN
              sales_order_status_label sales_order_status_label
           ON (sales_flat_order.status = sales_order_status_label.status))
       INNER JOIN
          sales_flat_order_item sales_flat_order_item
       ON (sales_flat_order.entity_id = sales_flat_order_item.order_id)"; 

		$results = $this->db->query($sql);
		 
		$result = $results->result_array();
		 
		$result[-1]['increment_id'] = 'Increment ID';
		$result[-1]['name'] = 'Name';
		$result[-1]['sku'] = 'Sku';
		$result[-1]['row_total'] = 'Row Total';
		$result[-1]['grand_total'] = 'Grand Total';
		$result[-1]['status'] = 'Status'; 
		 
		rsort($result); 
		return $result ;
	}
	
	public function fn_customer_address_with_order_export_query(){	
		 $this->db->cache_delete_all();
		
		$sql =	"SELECT sales_flat_order.increment_id AS order_id,
       sales_flat_order_grid.created_at AS order_date,
       sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order.base_grand_total,
       sales_flat_order.grand_total,
       sales_flat_order_address.street AS street_address,
       sales_flat_order_address.region,
       sales_flat_order_address.city,
       sales_flat_order_address.telephone,
       sales_flat_order_address.postcode,
       directory_country.iso3_code AS country,
       sales_flat_order_item.sku AS product_sku,
       concat('https://www.candere.com/', catalog_product_flat_1.url_path)
          AS url,
       sales_order_status.label AS order_status,
       sales_flat_order.coupon_code as coupon_code1,
       salesrule.coupon_identifier AS coupon_type_1,
       salesrule.simple_action AS simple_action_1,
       salesrule.discount_amount AS discount_amount_1,
       sales_flat_order.coupon_code2,
       salesrule_1.coupon_identifier AS coupon_type_2,
       salesrule_1.simple_action AS simple_action_2,
       salesrule_1.discount_amount AS discount_amount_2,
       sales_flat_order.coupon_code3,
       salesrule_2.coupon_identifier AS coupon_type_3,
       salesrule_2.discount_amount AS simple_action_3,
       salesrule_2.simple_action AS discount_amount_3,
       sales_flat_order.coupon_code4,
       salesrule_3.coupon_identifier AS coupon_type_4,
       salesrule_3.simple_action AS simple_action_4,
       salesrule_3.discount_amount AS discount_amount_4,
       sales_flat_order.coupon_code5,
       salesrule_4.coupon_identifier AS coupon_type_5,
       salesrule_4.simple_action AS simple_action_4,
       salesrule_4.discount_amount AS discount_amount_5
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   (   (   (   sales_flat_order_grid sales_flat_order_grid
                                                                   INNER JOIN
                                                                      sales_order_status sales_order_status
                                                                   ON (sales_flat_order_grid.status =
                                                                          sales_order_status.status))
                                                               INNER JOIN
                                                                  sales_flat_order sales_flat_order
                                                               ON (sales_flat_order_grid.entity_id =
                                                                      sales_flat_order.entity_id))
                                                           INNER JOIN
                                                              sales_flat_order_address sales_flat_order_address
                                                           ON (sales_flat_order_address.parent_id =
                                                                  sales_flat_order.entity_id))
                                                       INNER JOIN
                                                          directory_country directory_country
                                                       ON (sales_flat_order_address.country_id =
                                                              directory_country.country_id))
                                                   INNER JOIN
                                                      sales_flat_order_item sales_flat_order_item
                                                   ON (sales_flat_order_item.order_id =
                                                          sales_flat_order.entity_id))
                                               INNER JOIN
                                                  catalog_product_flat_1 catalog_product_flat_1
                                               ON (sales_flat_order_item.product_id =
                                                      catalog_product_flat_1.entity_id))
                                           LEFT OUTER JOIN
                                              salesrule_coupon salesrule_coupon
                                           ON (sales_flat_order.coupon_code =
                                                  salesrule_coupon.code))
                                       LEFT OUTER JOIN
                                          salesrule salesrule
                                       ON (salesrule_coupon.rule_id =
                                              salesrule.rule_id))
                                   LEFT OUTER JOIN
                                      salesrule_coupon salesrule_coupon_1
                                   ON (sales_flat_order.coupon_code2 =
                                          salesrule_coupon_1.code))
                               LEFT OUTER JOIN
                                  salesrule salesrule_1
                               ON (salesrule_coupon_1.rule_id =
                                      salesrule_1.rule_id))
                           LEFT OUTER JOIN
                              salesrule_coupon salesrule_coupon_2
                           ON (sales_flat_order.coupon_code3 =
                                  salesrule_coupon_2.code))
                       LEFT OUTER JOIN
                          salesrule salesrule_2
                       ON (salesrule_coupon_2.rule_id = salesrule_2.rule_id))
                   LEFT OUTER JOIN
                      salesrule_coupon salesrule_coupon_3
                   ON (sales_flat_order.coupon_code4 =
                          salesrule_coupon_3.code))
               LEFT OUTER JOIN
                  salesrule salesrule_3
               ON (salesrule_coupon_3.rule_id = salesrule_3.rule_id))
           LEFT OUTER JOIN
              salesrule_coupon salesrule_coupon_4
           ON (sales_flat_order.coupon_code5 = salesrule_coupon_4.code))
       LEFT OUTER JOIN
          salesrule salesrule_4
       ON (salesrule_coupon_4.rule_id = salesrule_4.rule_id)
 WHERE sales_flat_order_address.address_type = 'billing'
ORDER BY order_id DESC"; 

		$results = $this->db->query($sql);
		  
	 
		return $results ;
	}
	
	public function fn_customer_address_with_order_export_without_product_query(){
		$sql="SELECT sales_flat_order.increment_id AS order_id,
       sales_flat_order_grid.created_at AS order_date,
       sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order.base_grand_total,
       sales_flat_order.grand_total,
       sales_flat_order_address.street AS street_address,
       sales_flat_order_address.region,
       sales_flat_order_address.city,
       sales_flat_order_address.telephone,
       sales_flat_order_address.postcode,
       directory_country.iso3_code AS country,
       sales_order_status.label AS order_status,
       sales_flat_order.coupon_code as coupon_code1,
       salesrule.coupon_identifier AS coupon_type_1,
       salesrule.simple_action AS simple_action_1,
       salesrule.discount_amount AS discount_amount_1,
       sales_flat_order.coupon_code2,
       salesrule_1.coupon_identifier AS coupon_type_2,
       salesrule_1.simple_action AS simple_action_2,
       salesrule_1.discount_amount AS discount_amount_2,
       sales_flat_order.coupon_code3,
       salesrule_2.coupon_identifier AS coupon_type_3,
       salesrule_2.discount_amount AS simple_action_3,
       salesrule_2.simple_action AS discount_amount_3,
       sales_flat_order.coupon_code4,
       salesrule_3.coupon_identifier AS coupon_type_4,
       salesrule_3.simple_action AS simple_action_4,
       salesrule_3.discount_amount AS discount_amount_4,
       sales_flat_order.coupon_code5,
       salesrule_4.coupon_identifier AS coupon_type_5,
       salesrule_4.simple_action AS simple_action_4,
       salesrule_4.discount_amount AS discount_amount_5
  FROM    (   (   (   (   (   (   (   (   (   (   (   (   (      sales_flat_order_grid sales_flat_order_grid
                                                                   INNER JOIN
                                                                      sales_order_status sales_order_status
                                                                   ON (sales_flat_order_grid.status =
                                                                          sales_order_status.status))
                                                               INNER JOIN
                                                                  sales_flat_order sales_flat_order
                                                               ON (sales_flat_order_grid.entity_id =
                                                                      sales_flat_order.entity_id))
                                                           INNER JOIN
                                                              sales_flat_order_address sales_flat_order_address
                                                           ON (sales_flat_order_address.parent_id =
                                                                  sales_flat_order.entity_id))
                                                       INNER JOIN
                                                          directory_country directory_country
                                                       ON (sales_flat_order_address.country_id =
                                                              directory_country.country_id))
                                           LEFT OUTER JOIN
                                              salesrule_coupon salesrule_coupon
                                           ON (sales_flat_order.coupon_code =
                                                  salesrule_coupon.code))
                                       LEFT OUTER JOIN
                                          salesrule salesrule
                                       ON (salesrule_coupon.rule_id =
                                              salesrule.rule_id))
                                   LEFT OUTER JOIN
                                      salesrule_coupon salesrule_coupon_1
                                   ON (sales_flat_order.coupon_code2 =
                                          salesrule_coupon_1.code))
                               LEFT OUTER JOIN
                                  salesrule salesrule_1
                               ON (salesrule_coupon_1.rule_id =
                                      salesrule_1.rule_id))
                           LEFT OUTER JOIN
                              salesrule_coupon salesrule_coupon_2
                           ON (sales_flat_order.coupon_code3 =
                                  salesrule_coupon_2.code))
                       LEFT OUTER JOIN
                          salesrule salesrule_2
                       ON (salesrule_coupon_2.rule_id = salesrule_2.rule_id))
                   LEFT OUTER JOIN
                      salesrule_coupon salesrule_coupon_3
                   ON (sales_flat_order.coupon_code4 =
                          salesrule_coupon_3.code))
               LEFT OUTER JOIN
                  salesrule salesrule_3
               ON (salesrule_coupon_3.rule_id = salesrule_3.rule_id))
           LEFT OUTER JOIN
              salesrule_coupon salesrule_coupon_4
           ON (sales_flat_order.coupon_code5 = salesrule_coupon_4.code))
       LEFT OUTER JOIN
          salesrule salesrule_4
       ON (salesrule_coupon_4.rule_id = salesrule_4.rule_id)
 WHERE sales_flat_order_address.address_type = 'billing' 
ORDER BY order_id DESC";

$results = $this->db->query($sql);
		  
	 
		return $results ;
	}
	
	public function get_orders_customers_data() {
		
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		
		$this->load->helper('csv');
		$this->db->cache_delete_all();
		$this->load->dbutil();
		
		$base_total = $this->input->get('price');
		
		$having = '';
		if($base_total == 100001) {
			$having = " having SUM(round(sales_flat_order.base_grand_total)) >= $base_total ";
		} else if($base_total == 50000) {
			$having = " having SUM(round(sales_flat_order.base_grand_total)) < $base_total ";
		} else if($base_total == 100000) {
			$having = " having SUM(round(sales_flat_order.base_grand_total)) between 50000 AND $base_total ";
		}
		
		$sql =	"select CONCAT_WS(' ',sales_flat_order.customer_firstname, sales_flat_order.customer_lastname) AS customer_name,
			   sales_flat_order.customer_email,
			   sales_flat_order_address.telephone,
			   SUM(round(sales_flat_order.base_grand_total)) AS grand_total
		  FROM    sales_flat_order_address sales_flat_order_address
			   INNER JOIN
				  sales_flat_order sales_flat_order
			   ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id)
		 WHERE (    sales_flat_order_address.address_type = 'billing'
				AND sales_flat_order.state IN ('complete', 'processing'))
		GROUP BY sales_flat_order.customer_id
		$having
		ORDER BY sales_flat_order.entity_id DESC, sales_flat_order.customer_id ASC"; 
		$results = $this->db->query($sql);
		
		query_to_csv($results,true,'orders_with_customers_data'.date('d-M-y').'.csv');
	}
	
	
	
	public function get_abandoned_mail_data() {
		
		header('Content-Type: text/html; charset=utf-8');
		header('Content-Transfer-Encoding: binary');
		
		$this->load->helper('csv');
		$this->db->cache_delete_all();
		$this->load->dbutil();
		
		$sql =	"SELECT 
       sales_flat_quote_item.sku,
       sales_flat_quote_item.name, 
	   CONCAT_WS(' ',sales_flat_quote.customer_firstname, sales_flat_quote.customer_lastname) AS customer_name, 
       sales_flat_quote.customer_email,
       sales_flat_quote_address.telephone,sales_flat_quote.affiliate_id
  FROM    (   sales_flat_quote_item sales_flat_quote_item
           INNER JOIN
              sales_flat_quote sales_flat_quote
           ON (sales_flat_quote_item.quote_id = sales_flat_quote.entity_id))
       INNER JOIN
          sales_flat_quote_address sales_flat_quote_address
       ON (sales_flat_quote_address.quote_id = sales_flat_quote.entity_id)
 WHERE     (sales_flat_quote.abandoned_mail_sent = 1)
       AND (sales_flat_quote_address.address_type = 'billing')"; 
				$results = $this->db->query($sql);
				
		query_to_csv($results,true,'export_abandoned_mail_sent_data'.date('d-M-y').'.csv');
	
	}
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
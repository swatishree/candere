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
				   sales_order_status_label.label AS status,
				   sales_flat_order.created_at,
				   sales_flat_order_payment.method AS payment_method
			  FROM    (   sales_flat_order sales_flat_order
					   INNER JOIN
						  sales_order_status_label sales_order_status_label
					   ON (sales_flat_order.status = sales_order_status_label.status))
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
	
	public function export()
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
	  
	
	public function myqueryfunction(){	
		 
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
		
		$sql =	"SELECT sales_flat_order_address.firstname,
       sales_flat_order_address.lastname,
       sales_flat_order.increment_id,
       sales_flat_order.grand_total,
       sales_flat_order_address.region,
       sales_flat_order_address.city,
       sales_flat_order_address.telephone,
       sales_flat_order_address.postcode,
       sales_order_status_label.label AS order_status,
       directory_country.iso3_code AS country,
       sales_flat_order_grid.created_at
  FROM    (   (   (   sales_flat_order_grid sales_flat_order_grid
                   INNER JOIN
                      sales_order_status_label sales_order_status_label
                   ON (sales_flat_order_grid.status =
                          sales_order_status_label.status))
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
       ON (sales_flat_order_address.country_id = directory_country.country_id)
 WHERE (sales_flat_order_address.address_type = 'billing')"; 

		$results = $this->db->query($sql);
		  
	 
		return $results ;
	}
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
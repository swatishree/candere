<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sales_Order_Report extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
	 
		$this->load->view('templates/header'); 
        $this->load->view("sales_order_report/index");
		$this->load->view('templates/footer');
	}
	
	public function export_report()
	{ 
		$this->db->cache_delete_all();
				
		$order_date_from 	= $this->input->post('order_date_from');
		$order_date_to 		= $this->input->post('order_date_to');
		$order_status 		= $this->input->post('order_status');
		
		$order_date_from_timestamp = strtotime($order_date_from);
		$date_from = date('Y-m-d', $order_date_from_timestamp);
		
		$order_date_to_timestamp = strtotime($order_date_to);
		$date_to = date('Y-m-d', $order_date_to_timestamp);
		
		
		$this->load->helper('csv');
		$sql = "SELECT sales_flat_order.increment_id AS order_id,
       sales_flat_order.status,
       sales_flat_order.base_grand_total,
       sales_flat_order.base_total_paid,
       sales_flat_order.grand_total,
       sales_flat_order.total_paid,
       DATE_ADD(sales_flat_order.created_at, INTERVAL '05:30' HOUR_MINUTE)
          AS order_date,
       sales_flat_order_payment.method AS payment_method,
       sales_order_status.label AS order_status,
       sales_flat_order_item.name as product_name
  FROM    (   (   sales_flat_order sales_flat_order
               INNER JOIN
                  sales_order_status sales_order_status
               ON (sales_flat_order.status = sales_order_status.status))
           INNER JOIN
              sales_flat_order_payment sales_flat_order_payment
           ON (sales_flat_order_payment.parent_id =
                  sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_order_item sales_flat_order_item
       ON (sales_flat_order_item.order_id = sales_flat_order.entity_id)
 WHERE (    Date(sales_flat_order.created_at) BETWEEN '$date_from' AND '$date_to'
        AND sales_flat_order.status = '$order_status')
ORDER BY sales_flat_order.entity_id DESC";
			
			
		$results 	= $this->db->query($sql);
		$result 	= $results->result();
		
		$data['RowsSelected']= $result;
						 
		//array_to_csv($result,'sales_order_report_'.date('d-M-y'));
		
		
		$this->load->view('templates/header'); 
        $this->load->view("sales_order_report/index", $data);
		$this->load->view('templates/footer');
	}
	
	public function report()
	{ 
		$this->db->cache_delete_all();
	 
		$this->load->view('templates/header'); 
        $this->load->view("sales_order_report/report");
		$this->load->view('templates/footer');
	}
	
}	
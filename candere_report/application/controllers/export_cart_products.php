<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export_cart_products extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("export_cart_products/index");
		$this->load->view('templates/footer');
	}
	
	public function affiliate_analysis()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("export_cart_products/affiliate_analysis");
		$this->load->view('templates/footer');
	}
	
	public function affiliate_analysis_2()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("export_cart_products/affiliate_analysis_2");
		$this->load->view('templates/footer');
	}
	
	public function affiliate_analysis_3()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("export_cart_products/affiliate_analysis_3");
		$this->load->view('templates/footer');
	}
	
	public function custom_report()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("export_cart_products/custom_report");
		$this->load->view('templates/footer');
	}
	
	public function export_cart_products_data()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$sql = "SELECT sales_flat_quote_item.product_id,
       sales_flat_quote_item.sku,
       sales_flat_quote_item.name,
       sales_flat_quote_item.weight,
       sales_flat_quote_item.qty,
       sales_flat_quote_item.price,
       sales_flat_quote_item.base_price,
       sales_flat_quote_item.discount_amount,
       sales_flat_quote_item.product_type,
       sales_flat_quote_item.created_at,
       sales_flat_quote_item.updated_at,
       sales_flat_quote.customer_id,
       sales_flat_quote.customer_firstname,
       sales_flat_quote.customer_lastname,
       sales_flat_quote.customer_email,
       sales_flat_quote.customer_mobile,
       sales_flat_quote.items_qty,
       sales_flat_quote.items_count,
       sales_flat_quote.entity_id,
       sales_flat_quote.reserved_order_id,
       sales_flat_quote.affiliate_id
  FROM    sales_flat_quote_item sales_flat_quote_item
       INNER JOIN
          sales_flat_quote sales_flat_quote
       ON (sales_flat_quote_item.quote_id = sales_flat_quote.entity_id)
 WHERE sales_flat_quote.reserved_order_id IS NULL order by sales_flat_quote_item.updated_at DESC";
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
				
		array_to_csv($result,'cart_products_'.date('d-M-y'));
	}
	
	
	public function export_service_enquiry()
	{ 
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		$sql = "SELECT customer_queries.name,
			   customer_queries.email,
			   customer_queries.contact_no,
			   customer_queries.flag,
			   customer_queries.product_name,
			   customer_queries.created_at,
			   customer_queries.affiliate_id
		  FROM customer_queries customer_queries order by customer_queries.created_at DESC";
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		
		array_to_csv($result,'service_enquiry_products_'.date('d-M-y'));
	}
		
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
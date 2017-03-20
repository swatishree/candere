<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Imp_reports extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		set_time_limit(0);
		$this->db->cache_delete_all();
	}
	 
	public function index()
	{ 
		$this->db->cache_delete_all();
		$this->load->view('templates/header'); 
        $this->load->view("imp_reports/index");
		$this->load->view('templates/footer');
	}
	
	public function export_shipment()
	{ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT DISTINCT
       sales_flat_order.increment_id,
       sales_flat_order_item.name,
       sales_flat_order_item.sku,
       sales_flat_order_item.row_total,
       sales_flat_order.grand_total,
       sales_order_status.label AS status,
       sales_flat_shipment_grid.created_at AS shipment_created_date,
       sales_flat_shipment_grid.order_created_at AS shipment_updated_date,
       sales_flat_order.created_at as order_date
  FROM    (   (   sales_flat_order sales_flat_order
               INNER JOIN
                  sales_flat_shipment_grid sales_flat_shipment_grid
               ON (sales_flat_order.increment_id =
                      sales_flat_shipment_grid.order_increment_id))
           INNER JOIN
              sales_flat_order_item sales_flat_order_item
           ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_order_status sales_order_status
       ON (sales_order_status.status = sales_flat_order.status)";
 
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		array_to_csv($result,'orders_shipment_details_'.date('d-M-y'));
	}
	
	public function export_full_refund_credit_note()
	{ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT sales_flat_order.entity_id,
       sales_flat_order.base_grand_total,
       sales_flat_creditmemo.grand_total,
       sales_flat_order.increment_id,
       sales_flat_order.customer_firstname,
       sales_flat_order.customer_lastname,
       sales_flat_order.customer_email,
       sales_flat_order.customer_id,
       sales_flat_order.created_at,
       sales_flat_order.updated_at,
       sales_flat_order_item.sku
  FROM    (   sales_flat_creditmemo sales_flat_creditmemo
           INNER JOIN
              sales_flat_order sales_flat_order
           ON (sales_flat_creditmemo.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_order_item sales_flat_order_item
       ON (sales_flat_order_item.order_id = sales_flat_order.entity_id)
 WHERE sales_flat_order.base_grand_total = sales_flat_creditmemo.grand_total";
 
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		array_to_csv($result,'orders_full_refund_credit_note'.date('d-M-y'));
	}
	
	public function export_category_with_url()
	{ 
		set_time_limit(0);
		$this->db->cache_delete_all();
		$this->load->helper('csv');
		
		$sql = "SELECT catalog_category_entity.entity_id AS category_id,
       catalog_category_entity_varchar.value AS category_url,
       catalog_category_entity_varchar_1.value AS category_name,
       catalog_category_entity_varchar_2.value AS parent_category_name,
       catalog_category_entity_varchar_2.store_id
  FROM    (   (   (   catalog_category_entity catalog_category_entity
                   INNER JOIN
                      catalog_category_entity catalog_category_entity_1
                   ON (catalog_category_entity.parent_id =
                          catalog_category_entity_1.entity_id))
               INNER JOIN
                  catalog_category_entity_varchar catalog_category_entity_varchar
               ON (catalog_category_entity_varchar.entity_id =
                      catalog_category_entity.entity_id))
           INNER JOIN
              catalog_category_entity_varchar catalog_category_entity_varchar_1
           ON (catalog_category_entity_varchar_1.entity_id =
                  catalog_category_entity.entity_id))
       INNER JOIN
          catalog_category_entity_varchar catalog_category_entity_varchar_2
       ON (catalog_category_entity_1.entity_id =
              catalog_category_entity_varchar_2.entity_id)
 WHERE     (catalog_category_entity_varchar.attribute_id = 57)
       AND (catalog_category_entity_varchar.store_id = 0)
       AND (catalog_category_entity_varchar_1.attribute_id = 41)
       AND (catalog_category_entity_varchar_2.attribute_id = 41)
       AND (catalog_category_entity_varchar_2.store_id = 0)";
 
		$results 	= $this->db->query($sql);
		$result 	= $results->result_array();
		 
		array_to_csv($result,'export_category_with_url'.date('d-M-y'));
	}
	
	
	
		
}


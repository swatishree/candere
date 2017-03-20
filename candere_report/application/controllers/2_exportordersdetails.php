<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exportordersdetails extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}
	 
	public function index()
	{
		
		if($_GET){
		 
			$config['page_query_string'] = true;
			
		}else{
		 
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount = $this->db->count_all('sales_flat_order');
				
		$config['base_url'] 	= base_url()."index.php/exportordersdetails/index";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 50;
		$config['uri_segment'] 	= 3;
		$config['full_tag_open'] = "<div class=\"pagination\">\n<ul>\n";
		$config['full_tag_close'] = "\n</ul>\n</div>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a><strong>';
		$config['cur_tag_close'] = '</strong></a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['use_page_numbers'] = true;
		
		$limit = $config['per_page'];
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
				
				//echo sizeof($_GET['order_status']); die;
				//echo $_GET['order_status']
				
		$array_order=$_GET['order_status'];
		
		 //print_r($_GET['order_status']);
				
				
		if(sizeof($_GET['order_status'])>2){ 
			
			
			$inner_track_value=',AFST.track_number,AFST.title';
			
			$inner_track_join='LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
			
		
			
		}
		
		$order_status 	= implode("','",$_GET['order_status']); 
		 
		$mysql_to  = $_GET['fromdatepicker']; 
		
		$mysql_from= $_GET['todatepicker'];
		
		if($order_status){
			
			$condition="where  sales_flat_order.status in ('$order_status') And (sales_flat_order.created_at between '$mysql_from 00:00:00'  AND '$mysql_to 23:59:59')"; 
			
		 }else{
			$condition='';
		 }
		
		$data = array('');
		
		$sql = "select sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name' 
		,sales_order_status.label AS status,sales_flat_order.created_at as 'Created_Date',sales_flat_order.coupon_code,		sales_flat_order.coupon_code2,sales_flat_order.coupon_code3,sales_flat_order.coupon_code4,sales_flat_order.coupon_code5,SFOI.qty_ordered,sales_flat_order.base_shipping_amount,SFOI.base_discount_amount,SFOI.sku as Sku,FROM_UNIXTIME(SFOI.additional_data) as Expected_delivery_date,CONCAT(sales_flat_order.customer_firstname ,' ', sales_flat_order.customer_lastname) as 'Bill_To',SFOP.method,AFST.track_number,AFST.title,SFOI.base_row_total,SFOI.base_price,
		sales_flat_order.base_grand_total,sales_flat_order.grand_total,sales_flat_order.base_total_paid from sales_flat_order
		
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		 
		INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id)
		INNER JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)
		INNER JOIN sales_order_status sales_order_status
        ON (sales_order_status.status = sales_flat_order.status)
	    $condition
	    order by sales_flat_order.increment_id desc limit $start, $limit";
		
		$count_sql_query = "select sales_flat_order.increment_id from sales_flat_order
		
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		 
		INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id)
		INNER JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)
		INNER JOIN sales_order_status sales_order_status
        ON (sales_order_status.status = sales_flat_order.status)
	    $condition
	    order by sales_flat_order.increment_id desc";
		
		if($this->input->get()) {	
			
			$limit 				= $limit ;
						
			$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;	
			
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/exportordersdetails/index/pageno?$get_data";
			
			$search_array = array();
			
			//echo $order_status; die; 
		 // if($order_status=='complete_shippment_confirmed' || $order_status=='complete_order_shipped' ||$order_status== 'complete' || $order_status=='complete_reverse_pickup_qc'||$order_status=='reverse_pickup'|| $order_status=='closed_refund_credited'|| $order_status=='closed'){ 
			 
			//$inner= 'LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
			//$element=',AFST.track_number,AFST.title'; 
		 // }else{ 
		 
			// $inner='';
			// $element='';
		 // }
		 
		 
		foreach($array_order as $value){
			
			if($value=='complete_shippment_confirmed' || $value=='complete_order_shipped' ||$value== 'complete' || $value=='complete_reverse_pickup_qc'||$value=='reverse_pickup'|| $value=='closed_refund_credited'|| $value=='closed'){
				
			$inner_track_value=',AFST.track_number,AFST.title';
			
			$inner_track_join='LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
				
			}
			
		}
		
		$sql = "select sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name' 
		,sales_order_status.label AS status,sales_flat_order.created_at as 'Created_Date',sales_flat_order.coupon_code,		sales_flat_order.coupon_code2,sales_flat_order.coupon_code3,sales_flat_order.coupon_code4,sales_flat_order.coupon_code5,SFOI.qty_ordered,sales_flat_order.base_shipping_amount,SFOI.base_discount_amount,SFOI.sku as Sku,FROM_UNIXTIME(SFOI.additional_data) as Expected_delivery_date,CONCAT(sales_flat_order.customer_firstname ,' ', sales_flat_order.customer_lastname) as 'Bill_To', SFOI.base_price,SFOI.base_row_total, SFOP.method $element $inner_track_value,
		sales_flat_order.base_grand_total,sales_flat_order.grand_total,sales_flat_order.base_total_paid from sales_flat_order
		$inner
		$inner_track_join
		
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		 
		INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id)	
		
		INNER JOIN sales_order_status sales_order_status
		
        ON (sales_order_status.status = sales_flat_order.status)
	    $condition
	    order by sales_flat_order.increment_id asc limit $start, $limit";  
		
		$count_sql_query = "select sales_flat_order.increment_id $element $inner_track_value from sales_flat_order
		$inner
		$inner_track_join
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		 
		INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id)	
		
		INNER JOIN sales_order_status sales_order_status
		
        ON (sales_order_status.status = sales_flat_order.status)
	    $condition
	    order by sales_flat_order.increment_id";
			
			$data['limit'] 		= $limit;
			$data['start'] 		= $start;
					
		}
		 
		$results = $this->db->query($sql);  
		$count_sql_query_result = $this->db->query($count_sql_query); 
		
		$recordsCount = $count_sql_query_result->num_rows(); 
				
		if(count($results->result_array())>0){ 
			$data['search_data']= $results->result_array();
		}	
		
		
		$config['total_rows'] 	= $recordsCount;
		
		$this->pagination->initialize($config);
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['results_count'] = $recordsCount;
		$this->load->view('templates/header'); 
        $this->load->view("exportordersdetails/index",$data);
		$this->load->view('templates/footer');
		
	} 
	
	
	//*************************************** last updated by Bharat @231115*******************************
	
	public function export()
	{ 
		$message_arr = array('');
		$this->load->helper('csv');
		$order_status=$_GET['order_status'];
	//	echo $order_status 	= implode("','",$_GET['order_status']); die;
		if($this->input->get()) {	
			
			$todatepicker 		= $this->input->get('todatepicker');
			$fromdatepicker 	= $this->input->get('fromdatepicker');
			$order_status		= $_GET['order_status']; 
			 
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
		}
		
		
		
		$sql = $this->getCsv($todatepicker,$fromdatepicker,$order_status);
		
		
		
		foreach($sql->result_object as $row) {
			
			//****************************** get payment label query************************************
			
			$var='payment/'.$row->method.'/title';
		    $sql="SELECT value FROM  `core_config_data` WHERE  `path` LIKE  '$var' LIMIT 0 , 1"; 
		    $results = $this->db->query($sql);		
			$result = $results->result();
			
			
			$product_options = unserialize($row->product_options);
			$additional_options = $product_options['additional_options'];
			$last_element = end($additional_options);
			
			$increment_id 		= $row->Order_Id; 
			$name 				= $row->Product_Name;
			$sku 				= $row->Sku;
			$total_qty_ordered 	= $row->qty_ordered;
			$item_price 	    = $row->base_price;
			$grand_total		= $row->grand_total;
			$base_row_total		= $row->base_row_total;
			$base_total_paid 	= $row->base_total_paid; 
			$discount_amount	= $row->base_discount_amount; 
			$shipping_amount	= $row->base_shipping_amount;			
			$Bill_To 			= $row->Bill_To; 			
			$coupon_code 		= $row->coupon_code;
			$coupon_code2 		= $row->coupon_code2;
			$coupon_code3 		= $row->coupon_code3;
			$coupon_code4 		= $row->coupon_code4;
			$coupon_code5 		= $row->coupon_code5;			
			$Created_Date		= $row->Created_Date; 			
			$method				= $result[0]->value;
			$track_number		= $row->track_number;
			$carrier				= $row->title;
			$status 			= $row->status;
		    $expected_delivery_date = $row->Expected_delivery_date ;
			
			$dispatch_date=date('M d,Y', strtotime('-3 day', strtotime($expected_delivery_date)));
			
			$array[] = array(
				'Created Date'=>$Created_Date,
				'Order Id'=>$increment_id,
				'Customer Name'=>$Bill_To, 
				'Product Name'=>$name,
				'sku'=>$sku,
				'Total Qty Ordered'=>$total_qty_ordered,
				'Coupon Code'=>($coupon_code)? $coupon_code:'N/A',
				'Coupon Code2'=>($coupon_code2)? $coupon_code2:'N/A',
				'Coupon Code3'=>($coupon_code3)?$coupon_code3:'N/A',
				'Coupon Code4'=>($coupon_code4)?$coupon_code4:'N/A',
				'Coupon Code5'=>($coupon_code5)?$coupon_code5:'N/A',
				'Product Price'=>$item_price,
				'Subtota'=>$base_row_total,		
				'Shipping Amount'=>$shipping_amount,
				'Discount Amount'=>$discount_amount,
				'Grand Total'=>$grand_total,
				'Base Total Paid'=>$base_total_paid,
				'Payment Method'=>$method,
				'Dispatch date'=>$dispatch_date,
				'Carrier'=>$carrier,
				'Track Number'=>($track_number)?$track_number:'N/A',
				'Expected Delivery Date'=>$expected_delivery_date,
				'Status'=>$status ); 
		}
		
		 $this->load->dbutil();
		 header('Content-Type: text/html; charset=utf-8');
		 header('Content-Transfer-Encoding: binary');
		 array_to_csv($array,'export_orders_items_'.date('d-M-y').'.csv'); 
		 
	} 
	  
	
	public function getCsv($todatepicker,$fromdatepicker,$order_status){	
			
			$order_status1 	= explode(',',$order_status); 
			$order_status 	= implode("','",$order_status1);
			
			
			
			// if(count($order_status1)>2){ 
			
			// $inner_track_value=',AFST.track_number,AFST.title';
			
			// $inner_track_join='LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
			
		
			
		// }
			
		  // if($order_status=='complete_shippment_confirmed' || $order_status=='complete_order_shipped'||$order_status== 'complete'|| $order_status=='complete_reverse_pickup_qc'||$order_status=='reverse_pickup'||$order_status=='closed_refund_credited'|| $order_status=='closed'){
			 
			// $inner= 'LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
			// $element=',AFST.track_number,AFST.title';
			 
		 // }else{
			 
			// $inner='';
			// $element='';
		 // }
		 
		  
		foreach($order_status1 as $value){
			
			if($value=='complete_shippment_confirmed' || $value=='complete_order_shipped' ||$value== 'complete' || $value=='complete_reverse_pickup_qc'||$value=='reverse_pickup'|| $value=='closed_refund_credited'|| $value=='closed'){
				
			$inner_track_value=',AFST.track_number,AFST.title';
			
			$inner_track_join='LEFT JOIN sales_flat_shipment_track as AFST ON (AFST.order_id=sales_flat_order.entity_id)';
				
			}
			
		}
		 
		 
		 
			
	   $sql = "select sales_flat_order.increment_id as 'Order_Id',SFOI.name as 'Product_Name' 
		$element
		$inner_track_value
		,sales_order_status.label AS status,SFOI.qty_ordered,sales_flat_order.base_shipping_amount,DATE_FORMAT(sales_flat_order.created_at,'%D ,%M %Y') as 'Created_Date',sales_flat_order.coupon_code,	SFOI.base_row_total,SFOI.base_price,	sales_flat_order.coupon_code2,sales_flat_order.coupon_code3,sales_flat_order.coupon_code4,sales_flat_order.coupon_code5, SFOI.base_discount_amount,SFOI.sku as Sku,FROM_UNIXTIME(SFOI.additional_data) as Expected_delivery_date,CONCAT(sales_flat_order.customer_firstname ,' ', sales_flat_order.customer_lastname) as 'Bill_To',SFOP.method,
		sales_flat_order.base_grand_total,sales_flat_order.grand_total,sales_flat_order.base_total_paid from sales_flat_order
		$inner
		$inner_track_join
		INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id)
		 
		INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id)
		
		INNER JOIN sales_order_status sales_order_status
        ON (sales_order_status.status = sales_flat_order.status)		
	    where  sales_flat_order.status in ('$order_status') And (sales_flat_order.created_at between '$todatepicker 00:00:00' AND '$fromdatepicker 23:59:59') 
	    "; 
		$results = $this->db->query($sql); 			
		$result = $results->result();  

		
		rsort($results); 
		return $results ;
	}
	
	
	
	
	
	
}

// select DISTINCT(sales_flat_order.increment_id) as 'Order_Id',SFOI.name as 'Product_Name' ,sales_order_status.label AS status,sales_flat_order.created_at as 'Created_Date',sales_flat_order.coupon_code,AFST.track_number,AFST.title, sales_flat_order.coupon_code2,sales_flat_order.coupon_code3,sales_flat_order.coupon_code4,sales_flat_order.coupon_code5,SFOI.qty_ordered,sales_flat_order.base_shipping_amount,SFOI.base_discount_amount,SFOI.sku as Sku,FROM_UNIXTIME(SFOI.additional_data) as Expected_delivery_date,CONCAT(sales_flat_order.customer_firstname ,' ', sales_flat_order.customer_lastname) as 'Bill_To', SFOI.base_price,SFOI.base_row_total, SFOP.method , sales_flat_order.base_grand_total,sales_flat_order.grand_total,sales_flat_order.base_total_paid from sales_flat_order INNER JOIN sales_flat_order_item as SFOI ON (SFOI.order_id=sales_flat_order.entity_id) 
// INNER JOIN sales_flat_order_payment as SFOP ON (SFOP.parent_id=sales_flat_order.entity_id) 

// INNER JOIN sales_flat_shipment_track as AFST ON (AFST.parent_id=(select entity_id from sales_flat_shipment where entity_id=AFST.entity_id))

// INNER JOIN sales_order_status sales_order_status ON (sales_order_status.status = sales_flat_order.status) where sales_flat_order.status in ('canceled','complete_order_shipped') And (sales_flat_order.created_at between '2015-08-01 00:00:00' AND '2015-09-30 23:59:59') order by sales_flat_order.increment_id desc

/* End of file main.php */
/* Location: ./application/controllers/main.php */
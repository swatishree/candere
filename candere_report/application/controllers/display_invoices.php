<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Display_invoices extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->library("pagination");
		$this->load->database();
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		
		if($_GET){
		 
			$config['page_query_string'] = true;
			
		}else{
		 
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount = $this->db->count_all('candere_invoice');
				
		$config['base_url'] 	= base_url()."index.php/display_invoices/index";
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
		//$config['page_query_string'] = true;
			
		
		$limit = $config['per_page'];
		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
		
		$data = array('');
		
		$sql = "SELECT candere_invoice.id, sales_flat_order.entity_id,candere_invoice.invoice_no, candere_invoice.previous_invoice_num, candere_invoice.invoice_date, sales_flat_order.created_at, sales_flat_order.base_grand_total, sales_flat_order.grand_total, sales_flat_order.increment_id, sales_flat_order.customer_firstname, sales_flat_order.customer_lastname, catalog_product_entity_varchar.value AS name, sales_order_status.label AS status, sales_flat_order_address.address_type, sales_flat_order_address.firstname, sales_flat_order_address.lastname, concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) AS bill_to  FROM ( ( ( candere_invoice candere_invoice INNER JOIN catalog_product_entity_varchar catalog_product_entity_varchar ON (candere_invoice.product_id = catalog_product_entity_varchar.entity_id))  INNER JOIN sales_flat_order sales_flat_order ON (candere_invoice.order_id = sales_flat_order.entity_id))  INNER JOIN sales_order_status sales_order_status ON (sales_flat_order.status = sales_order_status.status))  INNER JOIN sales_flat_order_address sales_flat_order_address ON  (sales_flat_order_address.parent_id = sales_flat_order.entity_id)  where sales_flat_order_address.address_type = 'billing' and catalog_product_entity_varchar.attribute_id = 71 order by candere_invoice.id desc, candere_invoice.invoice_date desc limit $start, $limit";
		
		$count_sql_query = "SELECT candere_invoice.id, sales_flat_order.entity_id,candere_invoice.invoice_no, candere_invoice.previous_invoice_num, candere_invoice.invoice_date, sales_flat_order.base_grand_total, sales_flat_order.grand_total, sales_flat_order.increment_id, sales_flat_order.customer_firstname, sales_flat_order.customer_lastname, catalog_product_entity_varchar.value AS name, sales_order_status.label AS status, sales_flat_order_address.address_type, sales_flat_order_address.firstname, sales_flat_order_address.lastname, concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) AS bill_to  FROM ( ( ( candere_invoice candere_invoice INNER JOIN catalog_product_entity_varchar catalog_product_entity_varchar ON (candere_invoice.product_id = catalog_product_entity_varchar.entity_id))  INNER JOIN sales_flat_order sales_flat_order ON (candere_invoice.order_id = sales_flat_order.entity_id))  INNER JOIN sales_order_status sales_order_status ON (sales_flat_order.status = sales_order_status.status))  INNER JOIN sales_flat_order_address sales_flat_order_address ON  (sales_flat_order_address.parent_id = sales_flat_order.entity_id)  where sales_flat_order_address.address_type = 'billing' and catalog_product_entity_varchar.attribute_id = 71 order by candere_invoice.id desc, candere_invoice.invoice_date desc";
		
		if($this->input->get()) {	
			
			$limit 				= $limit ;
					
			$invoiceno 			= $this->input->get('invoice_no'); 
			$orderid 			= $this->input->get('orderid'); 
			$p_name 			= $this->input->get('p_name' );
			$todatepicker 		= strtotime($this->input->get('todatepicker'));
			$fromdatepicker 	= strtotime($this->input->get('fromdatepicker'));
			$bill_to 			= $this->input->get('bill_to');
			$created_at 	=    ($this->input->get('created_at'));
			
			$start = ($this->input->get('per_page') ) ? $this->input->get('per_page') : 0;	
			
			//$start = ($start !== 0) ? (int)$start : 1;
			//$start = (($start - 1) * $limit); 	
			
			
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/display_invoices/index/pageno?$get_data";
			
			$search_array = array();
			
			$search_array['attribute_id'] = 'catalog_product_entity_varchar.attribute_id = 71';
		
			$search_array['address_type'] = 'sales_flat_order_address.address_type = "billing"';
			
			if(!empty($invoiceno)){
				$search_array['invoice_no'] = 'candere_invoice.invoice_no = '.$invoiceno; 
			}
			
			if(!empty($orderid)){
				$search_array['orderid'] = 'sales_flat_order.increment_id = '.$orderid; 
			}
			
			if(!empty($p_name)){
				$search_array['p_name'] = "catalog_product_entity_varchar.value LIKE '%".$p_name."%'"  ; 
			}  
			
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($created_at)){					
				//$to_date = $created_at; 
				$search_array['created_at']  = "sales_flat_order.created_at LIKE '%".$created_at."%'"  ;				
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
			
			if(!empty($todatepicker) || !empty($fromdatepicker)){
				$search_array['date']  = "candere_invoice.invoice_date between '$from_date' and '$to_date'";
			}
			if(!empty($bill_to)){
				$search_array['bill_to'] = "concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) LIKE '%".$bill_to."%'"  ; 
			}		
				
					
			$condition = implode(' AND ',$search_array); 
			
			
			
			$sql = "SELECT candere_invoice.id, sales_flat_order.entity_id,candere_invoice.invoice_no, candere_invoice.previous_invoice_num, candere_invoice.invoice_date, sales_flat_order.created_at, sales_flat_order.base_grand_total, sales_flat_order.grand_total, sales_flat_order.increment_id, sales_flat_order.customer_firstname, sales_flat_order.customer_lastname, catalog_product_entity_varchar.value AS name, sales_order_status.label AS status, sales_flat_order_address.address_type, sales_flat_order_address.firstname, sales_flat_order_address.lastname, concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) AS bill_to  FROM ( ( ( candere_invoice candere_invoice INNER JOIN catalog_product_entity_varchar catalog_product_entity_varchar ON (candere_invoice.product_id = catalog_product_entity_varchar.entity_id))  INNER JOIN sales_flat_order sales_flat_order ON (candere_invoice.order_id = sales_flat_order.entity_id))  INNER JOIN sales_order_status sales_order_status ON (sales_flat_order.status = sales_order_status.status))  INNER JOIN sales_flat_order_address sales_flat_order_address ON  (sales_flat_order_address.parent_id = sales_flat_order.entity_id)  where  $condition limit $start, $limit";
			
			$count_sql_query = "SELECT candere_invoice.id, sales_flat_order.entity_id,candere_invoice.invoice_no, candere_invoice.previous_invoice_num, candere_invoice.invoice_date, sales_flat_order.base_grand_total, sales_flat_order.grand_total, sales_flat_order.increment_id, sales_flat_order.customer_firstname, sales_flat_order.customer_lastname, catalog_product_entity_varchar.value AS name, sales_order_status.label AS status, sales_flat_order_address.address_type, sales_flat_order_address.firstname, sales_flat_order_address.lastname, concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) AS bill_to  FROM ( ( ( candere_invoice candere_invoice INNER JOIN catalog_product_entity_varchar catalog_product_entity_varchar ON (candere_invoice.product_id = catalog_product_entity_varchar.entity_id))  INNER JOIN sales_flat_order sales_flat_order ON (candere_invoice.order_id = sales_flat_order.entity_id))  INNER JOIN sales_order_status sales_order_status ON (sales_flat_order.status = sales_order_status.status))  INNER JOIN sales_flat_order_address sales_flat_order_address ON  (sales_flat_order_address.parent_id = sales_flat_order.entity_id)  where  $condition";
			
			$data['limit'] 		= $limit;
			$data['start'] 		= $start;
					
		}
		 
		$results = $this->db->query($sql);  
		$count_sql_query_result = $this->db->query($count_sql_query);  
		
		$recordsCount = $count_sql_query_result->num_rows();
				
		if(count($results->result_array())>0){ 
			$data['search_data']= $results->result_array();
		}else{  
			$data['search_data']= array('noData'=>'emptydta');
		}	
		
		
		$config['total_rows'] 	= $recordsCount;
		
		$this->pagination->initialize($config);
						
		
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['results_count'] = $recordsCount;
		$this->load->view('templates/header'); 
        $this->load->view("display_invoices/index",$data);
		$this->load->view('templates/footer');
		
		
	} 
	 
	
	public function update_invoice_num()
	{
		$data['increment_id'] 	= $this->input->get('increment_id');
		$data['invoice_num'] 	= $this->input->get('invoice_num');
		$data['id'] 			= $this->input->get('id');
		
		$query = $this->db->select("invoice_date")
              ->from('candere_invoice')
              ->where('id', $data['id'])
              ->get();
		$result = $query->row();
		
		$data['invoice_date'] 	=  date('d-m-Y',$result->invoice_date);
		
		$this->load->view('templates/header'); 
        $this->load->view("display_invoices/update_invoice_num",$data);
		$this->load->view('templates/footer');
	}
	
	public function delete_invoice()
	{
		$data['id'] 			= $this->input->get('id');
		
		$this->db->delete('candere_invoice', $data);
		
		redirect('display_invoices');
		
	}
	
	public function save_invoice_num()
	{
		$increment_id 		  = $this->input->post('increment_id'); 
		$invoice_num 		  = $this->input->post('invoice_num');
		$previous_invoice_num = $this->input->post('previous_invoice_num');
		$candere_invoice_id	  = $this->input->post('id');
			
		//$invoice_date 	= strtotime($this->input->post('invoice_date'));
		//$this->input->post('invoice_date'); echo "<br>";
		
		//echo date("d-m-Y", strtotime($invoice_date)); echo "<br>";
		$invoice_date 		= strtotime(date("d-m-Y", strtotime($this->input->post('invoice_date'))));		
								
		$query = $this->db->select('entity_id')
				  ->from('sales_flat_order')
				  ->where('increment_id', $increment_id)
				  ->get();
		$sales_flat_data = $query->row();	
		
		
		if(isset($sales_flat_data->entity_id)) { 
			$query = $this->db->select("id, invoice_no, previous_invoice_num")
              ->from('candere_invoice')
              ->where('id', $candere_invoice_id)
              ->get();
			$invoice_data = array_shift($query->result());
									
			$id 			= $invoice_data->id;
			$invoice_no 	= $invoice_data->invoice_no;
			$old_invoice_no = $invoice_data->previous_invoice_num;
				
			$previous_invoice_no = $old_invoice_no;
			$previous_invoice_no .= $previous_invoice_num. ', ';
						
			if(isset($id) && $invoice_no!="" && $invoice_num!="") {
				
				
				$this->db->query("update candere_invoice set invoice_no=$invoice_num, previous_invoice_num = '$previous_invoice_no', invoice_date= '$invoice_date' where id=$id");
			}
		}
		
		redirect('display_invoices');
	}
	
	// last update by @bharat for searching #092615

	 
	//************************************************** Last Updated by Bharat 10112015 *****************************
	public function getCsv(){
		
		if($_GET){ 
			$config['page_query_string'] = true;
		}else{
			$page_query_straing=$config['page_query_string'] = false;
		}
		
		$recordsCount = $this->db->count_all('candere_invoice');
				
		$config['base_url'] 	= base_url()."index.php/display_invoices/index";
		$config['total_rows'] 	= $recordsCount;
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
		//$config['page_query_string'] = true;
		
		$data = array('');
		
		if($this->input->get()) {	
			
			$invoiceno 			= $this->input->get('invoice_no'); 
			$orderid 			= $this->input->get('orderid'); 
			$p_name 			= $this->input->get('p_name' );
			$todatepicker 		= strtotime($this->input->get('todatepicker'));
			$fromdatepicker 	= strtotime($this->input->get('fromdatepicker'));
			$created_at 	=    ($this->input->get('created_at'));
			$bill_to 			= $this->input->get('bill_to');
						
			$get_data = http_build_query($_GET);
			
			$config['base_url'] 	= base_url()."index.php/display_invoices/index/pageno?$get_data";
			
			$search_array = array();
			
			$search_array['attribute_id'] = 'catalog_product_entity_varchar.attribute_id = 71';
		
			$search_array['address_type'] = 'sales_flat_order_address.address_type = "billing"';
			
			if(!empty($invoiceno)){
				$search_array['invoice_no'] = 'candere_invoice.invoice_no = '.$invoiceno; 
			}
			
			if(!empty($orderid)){
				$search_array['orderid'] = 'sales_flat_order.increment_id = '.$orderid; 
			}
			
			if(!empty($p_name)){
				$search_array['p_name'] = "catalog_product_entity_varchar.value LIKE '%".$p_name."%'"  ; 
			}  
			
			if(!empty($todatepicker)){
				$from_date = $todatepicker;
			}
			
			if(!empty($fromdatepicker)){					
				$to_date = $fromdatepicker; 							
			}
			if(!empty($created_at)){
				$search_array['created_at']  = "sales_flat_order.created_at LIKE '%".$created_at."%'"  ;				
			}
			
			if(!empty($todatepicker) || !empty($fromdatepicker)){
				$search_array['date']  = "candere_invoice.invoice_date between '$from_date' and '$to_date'";
			}
			if(!empty($bill_to)){
				$search_array['bill_to'] = "concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) LIKE '%".$bill_to."%'"  ; 
			}		
				
					
			$condition = implode(' AND ',$search_array); 
			
			$sql = "SELECT sales_flat_order.increment_id as OrderId, candere_invoice.invoice_no as InvoiceNumber,sales_flat_order.created_at as 'Order Date(m/d/y)',from_unixtime(candere_invoice.invoice_date) as 'InvoiceDate in (mm/dd/yy)', candere_invoice.previous_invoice_num as previousInvoiceNo, catalog_product_entity_varchar.value AS ProductName, (sales_flat_order.base_grand_total) as GrandTotalBaseCurrency, sales_flat_order.grand_total as GrandTotalOrderCurrency,   concat(sales_flat_order_address.firstname, ' ', sales_flat_order_address.lastname) AS bill_to, sales_order_status.label AS Status FROM ( ( ( candere_invoice candere_invoice INNER JOIN catalog_product_entity_varchar catalog_product_entity_varchar ON (candere_invoice.product_id = catalog_product_entity_varchar.entity_id)) INNER JOIN sales_flat_order sales_flat_order ON (candere_invoice.order_id = sales_flat_order.entity_id)) 
			INNER JOIN sales_order_status sales_order_status ON (sales_flat_order.status = sales_order_status.status)) 
			
			INNER JOIN sales_flat_order_address sales_flat_order_address ON (sales_flat_order_address.parent_id = sales_flat_order.entity_id) where  $condition";
			
			
		}
		 
		$results = $this->db->query($sql);  
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		$delimiter = ",";
        $newline = "\r\n";
		$data = $this->dbutil->csv_from_result($results, $delimiter, $newline);
	   	force_download('InvoiceReport--'.date('d-m-Y H-i').".csv", $data);
		
	} 
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
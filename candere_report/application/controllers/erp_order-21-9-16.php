<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Erp_Order extends Auth_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		 $config['upload_path']   = './uploads/'; 
         $config['allowed_types'] = 'gif|jpg|jpeg|png'; 
         $config['max_size']      = 10000; 
         $config['max_width']     = 1200; 
         $config['max_height']    = 1200;  
        $this->load->library('upload', $config);
		$this->load->helper(array('form','url','date','html'));
		$this->load->library('table');
		$this->db->cache_delete_all();
		set_time_limit(0);
		$this->load->model('erpmodel');
		$this->load->library("pagination");
		
		
		
		$this->load->database();
		$this->output->nocache();
		$this->output->nocache();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
         $this->output->set_header("Pragma: no-cache"); 
	}
	
	function addQuotes($string) {
		return '"'. implode('","', explode(',', $string)) .'"';
	}
		
	public function index()
	{
		$array_pending 		= array('pending','confirm');
		$allow_status 		= $this->session->userdata('order_status');
		
		$recordsCount		= $this->erpmodel->tab_orders_count($array_pending,$allow_status);
		
		$config['base_url'] 	= base_url()."index.php/erp_order/to_do_list";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status = $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			$search .= " and c.order_id LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " and c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
				
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.expected_delivery_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
				
		$data['selectdata'] 	= $this->erpmodel->order_details($array_pending='', $allow_status, $search, $sort, $dir, $limit, $start);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/to_do_list',$data);	
		$this->load->view('templates/footer');
	}
	
	 public function imageupload() { 
        
			$erp_order_id = $this->input->post("erp_order_id");
         if (!$this->upload->do_upload('myimage')) {
			 
			 
		 $error = array('error' => $this->upload->display_errors()); 
		 print_r($error);
		exit ;
        $this->load->view('templates/header');
		$this->load->view('erp_order/to_do_list',$error);	
		$this->load->view('templates/footer');
         
		 }
			
         else {
			 
			  $imagedata = array('upload_data' => $this->upload->data()); 
		 $imagepath = array(
               'product_image' => base_url() .'uploads/'. $imagedata['upload_data']['file_name']
              );
		 
        
        $this->db->where('erp_order_id', $erp_order_id);
        $this->db->update('erp_order_details',$imagepath);
			 
		$array_pending 		= array('pending','confirm');
		$allow_status 		= $this->session->userdata('order_status');
		
		$recordsCount		= $this->erpmodel->tab_orders_count($array_pending,$allow_status);
		
		$config['base_url'] 	= base_url()."index.php/erp_order/to_do_list";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			//$search .= " AND c.sku LIKE '$search_order_id'";
			$search .= " AND c.order_id LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " AND c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
				
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
            
		$data['selectdata'] 	= $this->erpmodel->order_details($array_pending='', $allow_status, $search, $sort, $dir, $limit, $start);
		                          
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/to_do_list',$data);	
		$this->load->view('templates/footer');
         
		 } 
      }
	  
	  
	  public function showimage() { 
        
		$erp_order_id  = $this->input->post("erp_order_id");
		$order_item_id = $this->input->post("order_item_id");
		$product_id    = $this->input->post("product_id");
		
             if($this->input->post("metal")=='Yellow Gold')
			 {
				 $metal = '60' ;
			 }
			 if($this->input->post("metal")=='White Gold')
			 {
				 $metal = '59' ;
			 }
			 if($this->input->post("metal")=='Rose Gold')
			 {
				 $metal = '61' ;
			 }
			 if($this->input->post("metal")=='Platinum')
			 {
				 $metal = '58' ;
			 }
		$_images = Mage::getModel('catalog/product')->load($product_id)->getMediaGalleryImages();
					$imagearray = array();
					
					foreach($_images as $_image)	{
          
                if($_image->getMetal()==$metal)	{					
						 array_push($imagearray,$_image->getUrl());
				}
					}
		 
        // echo '<pre>' ;
		// print_r($imagearray);
        // echo '</pre>' ;
       // exit ;
		 $data['myimage'] = $imagearray ;
        $this->load->view('templates/header');
		$this->load->view('erp_order/to_do_list',$data);	
		$this->load->view('templates/footer');
         
		 }
	  
	  public function exportdata()
	  {
		 
        $erp_order_id = $this->input->post("erp_order_id");
        $order_id = $this->input->post("order_id");
		 $this->load->dbutil();

        $this->load->helper('file');

        $this->load->helper('download');

        $delimiter = ",";

        $newline = "\r\n";

        $filename = $order_id.".csv";

        $query = "SELECT 
		erp_order.order_id, 
		erp_order.product_id, 
		erp_order.customer_id, 
		erp_order.customer_name, 
		erp_order.customer_lastname, 
		erp_order.customer_email, 
		erp_order.contact_number, 
		erp_order.buyer_address, 
		erp_order.shipping_country, 
		erp_order.sku, 
		erp_order.sku_custom, 
		erp_order.product_name, 
		erp_order.expected_delivery_date, 
		erp_order.dispatch_date, 
		erp_order.quantity, 
		erp_order.order_currency_code, 
		erp_order.order_placed_date, 
		erp_order.order_status, 
		erp_order.mktplace_name, 
		erp_order.mktplace_order_id, 
		erp_order.mktplace_sub_order_id, 
		erp_order.estimated_date, 
		erp_order.estimated_order_sent_date, 
		erp_order_details.product_type, 
		erp_order_details.metal, 
		erp_order_details.purity, 
		erp_order_details.height, 
		erp_order_details.width, 
		erp_order_details.design_identifier, 
		erp_order_details.top_thickness, 
		erp_order_details.top_height, 
		erp_order_details.bottom_thickness, 
		erp_order_details.metal_weight, 
		erp_order_details.total_weight, 
		erp_order_details.no_of_stones, 
		erp_order_details.product_image, 
		erp_order_details.product_url, 
		erp_order_details.chain_thickness, 
		erp_order_details.chain_length, 
		erp_order_details.bracelet_length, 
		erp_order_details.bangle_size, 
		erp_order_details.kada_size, 
		erp_order_details.ring_size, 
		erp_order_details.engrave_message, 
		erp_order_details.expected_date_append, 
		erp_order_details.diamond_1_status, 
		erp_order_details.diamond_2_status, 
		erp_order_details.diamond_3_status, 
		erp_order_details.diamond_4_status, 
		erp_order_details.diamond_5_status, 
		erp_order_details.diamond_6_status, 
		erp_order_details.diamond_7_status,
		
		erp_order_details.diamond_1_stones, 
		erp_order_details.diamond_2_stones, 
		erp_order_details.diamond_3_stones, 
		erp_order_details.diamond_4_stones, 
		erp_order_details.diamond_5_stones, 
		erp_order_details.diamond_6_stones, 
		erp_order_details.diamond_7_stones, 
		
		erp_order_details.diamond_1_weight, 
		erp_order_details.diamond_2_weight, 
		erp_order_details.diamond_3_weight, 
		erp_order_details.diamond_4_weight, 
		erp_order_details.diamond_5_weight, 
		erp_order_details.diamond_6_weight, 
		erp_order_details.diamond_7_weight,
		
		erp_order_details.diamond_1_clarity, 
		erp_order_details.diamond_2_clarity, 
		erp_order_details.diamond_3_clarity, 
		erp_order_details.diamond_4_clarity, 
		erp_order_details.diamond_5_clarity, 
		erp_order_details.diamond_6_clarity, 
		erp_order_details.diamond_7_clarity, 
		
		erp_order_details.diamond_1_shape, 
		erp_order_details.diamond_2_shape, 
		erp_order_details.diamond_3_shape, 
		erp_order_details.diamond_4_shape, 
		erp_order_details.diamond_5_shape, 
		erp_order_details.diamond_6_shape, 
		erp_order_details.diamond_7_shape,
		
		erp_order_details.diamond_1_color, 
		erp_order_details.diamond_2_color, 
		erp_order_details.diamond_3_color, 
		erp_order_details.diamond_4_color, 
		erp_order_details.diamond_5_color, 
		erp_order_details.diamond_6_color, 
		erp_order_details.diamond_7_color, 
		
		erp_order_details.diamond_1_setting_type, 
		erp_order_details.diamond_2_setting_type, 
		erp_order_details.diamond_3_setting_type, 
		erp_order_details.diamond_4_setting_type, 
		erp_order_details.diamond_5_setting_type, 
		erp_order_details.diamond_6_setting_type, 
		erp_order_details.diamond_7_setting_type,
		
		erp_order_details.gem_1_status,
		erp_order_details.gem_2_status,
		erp_order_details.gem_3_status,
		erp_order_details.gem_4_status,
		erp_order_details.gem_5_status,
		
		erp_order_details.gemstone_1_stone,
		erp_order_details.gemstone_2_stone,
		erp_order_details.gemstone_3_stone,
		erp_order_details.gemstone_4_stone,
		erp_order_details.gemstone_5_stone,
		
		erp_order_details.gemstone_1_type,
		erp_order_details.gemstone_2_type,
		erp_order_details.gemstone_3_type,
		erp_order_details.gemstone_4_type,
		erp_order_details.gemstone_5_type,
		
		erp_order_details.gemstone_1_color,
		erp_order_details.gemstone_2_color,
		erp_order_details.gemstone_3_color,
		erp_order_details.gemstone_4_color,
		erp_order_details.gemstone_5_color,
		
		erp_order_details.gemstone_1_shape,
		erp_order_details.gemstone_2_shape,
		erp_order_details.gemstone_3_shape,
		erp_order_details.gemstone_4_shape,
		erp_order_details.gemstone_5_shape,
		
		erp_order_details.gemstone_1_setting_type,
		erp_order_details.gemstone_2_setting_type,
		erp_order_details.gemstone_3_setting_type,
		erp_order_details.gemstone_4_setting_type,
		erp_order_details.gemstone_5_setting_type,
		
		erp_order_details.gemstone_1_weight,
		erp_order_details.gemstone_2_weight,
		erp_order_details.gemstone_3_weight,
		erp_order_details.gemstone_4_weight,
		erp_order_details.gemstone_5_weight
		

        		
		
		FROM erp_order, erp_order_details WHERE erp_order.id= erp_order_details.erp_order_id and erp_order.id = $erp_order_id ";

        $result = $this->db->query($query);

        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);

        force_download($filename, $data);

	  }
	
	public function to_do_list()
	{
		$array_pending 		= array('pending','confirm');
		$allow_status 		= $this->session->userdata('order_status');
		//print_r($allow_status);
		$recordsCount		= $this->erpmodel->tab_orders_count($array_pending,$allow_status);
		
		$config['base_url'] 	= base_url()."index.php/erp_order/to_do_list";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			//$search .= " AND c.sku LIKE '$search_order_id'";
			$search .= " AND c.order_id LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " AND c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
				
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
		
		
		/* if(!isset($sort_type[0]) || empty($sort_type[0]) || $sort_type[0]==''){
			$sort = 'c.expected_delivery_date';
		} else {
			$sort = 'c.'.$sort_type[0];
		}
		if(!isset($sort_type[1]) || empty($sort_type[1]) || $sort_type[1]==''){
			$dir = 'asc';
		} else {
			$dir = $sort_type[1];
		} */
		
		$data['selectdata'] 	= $this->erpmodel->order_details($array_pending, $allow_status, $search, $sort ,$dir , $limit, $start);
		
		//echo '<pre>'; print_r($data['selectdata']); echo '</pre>'; exit;
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/to_do_list',$data);	
		$this->load->view('templates/footer');
	}
	
		public function product_updates()
	{
		$array_cancelled 	= array('cancelled');
		$recordsCount = $this->erpmodel->non_finished_count();
		
		$config['base_url'] 	= base_url()."index.php/erp_order/product_updates";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		
		//$start = ($start !== 0) ? (int)$start : 1;
				
		$search	= '';
		$search_order_id 	= $this->input->post('search_order_id');
		//$search_by 			= $this->input->post('search_by');
		
		// if($search_by == 1) {
			// $search .= " erp_order_id NOT IN (SELECT order_product_id FROM trnfinishedproduct) ";
		// } else if($search_by == 2){
			// $search .= " erp_order_id IN (SELECT order_product_id FROM trnfinishedproduct)";
		// } else {
			// $search .= " erp_order_id NOT IN (SELECT order_product_id FROM trnfinishedproduct)";
		// }
		
		if($search_order_id != '') {
			$search .= " and c.order_id like '$search_order_id' ";
		} 
			
		$data['prod_updates'] 	= $this->erpmodel->getNonFinishedProducts($array_cancelled,$search, $limit, $start);
			//echo '<pre>'; print_r($data['prod_updates']); echo '</pre>'; exit;	
		$this->load->view('templates/header');
		$this->load->view('erp_order/product_updates',$data);	
		$this->load->view('templates/footer');
	}
	
	public function processing_orders()
	{
		$array_processing 	= array('processing');
		$allow_status 		= $this->session->userdata('order_status');
		 // echo '<pre>' ;
		 // print_r($allow_status);
		 // echo '</pre>' ;
		 // exit ;
		
		$recordsCount		= $this->erpmodel->tab_orders_count($array_processing,$allow_status);
		
		$config['base_url'] 	= base_url()."index.php/erp_order/processing_orders";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
			
		$proc_status 	= '';
		$comp_status 	= '';
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
		 $search .= " AND c.order_id LIKE '$search_order_id'";
			
			//$search .= " AND c.sku LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " and c.status IN ($status_codes)";
		} 
						
		$sort_type 	= $this->input->post('order_dispatch_date');
		
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
				
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
							
		$data['processdata'] 	= $this->erpmodel->order_details($array_processing, $allow_status, $search, $sort, $dir, $limit, $start);
		//$data['processdata'] 	= $this->erpmodel->order_details($array_processing, $allow_status, $search,  $limit, $start);
		// echo '<pre>' ;
		// print_r($data);
		// echo '</pre>' ;
		// exit ;
		$this->load->view('templates/header');
		$this->load->view('erp_order/processing_orders',$data);	
		$this->load->view('templates/footer');
	}
	
	public function archieved_orders()
	{
		$array_complete 	= array('shipped');
		$allow_status 		= $this->session->userdata('order_status');
		
		$recordsCount		= $this->erpmodel->tab_orders_count($array_complete,$allow_status='');
		
		$config['base_url'] 	= base_url()."index.php/erp_order/archieved_orders";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			$search .= " AND c.order_id LIKE '$search_order_id'";
			//$search .= " AND c.sku LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " and c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
		
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
		
		$data['completedata'] 	= $this->erpmodel->order_details($array_complete, $allow_status='', $search, $sort, $dir,  $limit, $start);
		//$data['completedata'] 	= $this->erpmodel->order_details($array_complete, $allow_status='', $search,   $limit, $start);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/archieved_orders',$data);	
		$this->load->view('templates/footer');
	}
	
	
	public function cancelled_orders()
	{
		$array_cancelled 	= array('cancelled');
		$allow_status 		= $this->session->userdata('order_status');
		
		 $recordsCount		= $this->erpmodel->tab_orders_count($array_cancelled,$allow_status='');
		
		$config['base_url'] 	= base_url()."index.php/erp_order/cancelled_orders";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			$search .= " AND c.order_id LIKE '$search_order_id'";
			//$search .= " AND c.sku LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " and c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
		
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
		
		$data['completedata'] 	= $this->erpmodel->order_details($array_cancelled, $allow_status='', $search, $sort, $dir,  $limit, $start);
		//$data['completedata'] 	= $this->erpmodel->order_details($array_cancelled, $allow_status='', $search,  $limit, $start);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/cancelled_orders',$data);	
		$this->load->view('templates/footer');
	}
	
	public function completed_orders()
	{
		
		
		$array_complete 	= array('complete');
		$allow_status 		= $this->session->userdata('order_status');
		// echo 'hello' ;
		// echo '<pre>' ;
		// print_r($allow_status);
		// echo '</pre>' ;
		$recordsCount		= $this->erpmodel->tab_orders_count($array_complete,$allow_status='');
		
		$config['base_url'] 	= base_url()."index.php/erp_order/completed_orders";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 10; 
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
		$config['page_query_string'] = false;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit);
		//$start = ($start !== 0) ? (int)$start : 1;
		
		$search_order_id 	= $this->input->post('search_order_id');
		$search_status 		= $this->input->post('search_status_id');
		
		foreach($search_status as $rj) {
			$status_code .= $rj.',';
		}
		$status_code = rtrim(trim($status_code),',');
		$status_codes = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		if($search_order_id != '') {
			$search .= " AND c.order_id LIKE '$search_order_id'";
			//$search .= " AND c.sku LIKE '$search_order_id'";
		}
		if($status_codes != '') {
			$search .= " and c.status IN ($status_codes)";
		}
		
		$sort_type 	= $this->input->post('order_dispatch_date');
		if(isset($_COOKIE['sort_dir'])){
			$dir 	= $_COOKIE['sort_dir'];
		} else {
			$dir 	= 'asc';
		}
		
		if(!isset($sort_type) || empty($sort_type)  || $sort_type==''){
			$sort = 'c.dispatch_date';
		} else {
			$sort = 'c.'.$sort_type;
		}
		
		$data['completedata1'] 	= $this->erpmodel->order_details($array_complete, $allow_status='', $search, $sort, $dir,  $limit, $start);
		//$data['completedata1'] 	= $this->erpmodel->order_details1($array_complete, $allow_status='', $search,  $limit, $start);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/completed_orders',$data);	
		$this->load->view('templates/footer');
	}
	

	
	public function order_save()
	{
		$_username 	= @$this->session->userdata('_username');
				
		$row_data['order_id'] 			= $this->input->post('order_id');
		$row_data['order_item_id'] 			= $this->input->post('order_item_id');
		$row_data['order_product_id'] 	= $this->input->post('order_product_id');
		
		if($this->input->post('order_status_id')!=''){
			$row_data['order_status_id'] 	= $this->input->post('order_status_id');
		} else {
			$row_data['order_status_id'] 	= $this->input->post('order_status_id_hidden');
		}
		$row_data['vendor_id'] 			= $this->input->post('vendor_id');
		$row_data['notes'] 				= $this->input->post('notes');
		$row_data['greeting_card_id'] 	= $this->input->post('greeting_card_id');
		$row_data['personal_message'] 	= $this->input->post('personal_message');
		$row_data['website_id'] 		= 1;
		$row_data['updated_by'] 		= $_username;
		$row_data['updated_date'] 		= date('Y-m-d H:i:s');
				
		$lastinsertedid = $this->erpmodel->AddNewRow('trnorderprocessing', $row_data);
		
		if($lastinsertedid) {
			if($this->input->post('order_product_id')) {
				$key['id']		= $this->input->post('order_product_id');
				$rj['status'] 	= $this->input->post('order_status_id');
				$update_id		= $this->erpmodel->UpdateRow('erp_order', $rj, $key);
				echo 'success';
			}
		}
	}
	
	
	public function set_next_state()
	{
		// print_r($this->input->post());
		// echo 'hello' ;
		// exit ;
		$_username 	= @$this->session->userdata('_username');
		
		 $update_status = $this->input->post('order_status_id_1') + 1;
		//echo 'hello' ;
		//exit ;
		
		$row_data['order_id'] 			= $this->input->post('order_id');
		$row_data['order_item_id'] 			= $this->input->post('order_item_id');
		$row_data['order_product_id'] 	= $this->input->post('order_product_id');
		$row_data['order_status_id'] 	= $update_status;
		$row_data['vendor_id'] 			= $this->input->post('vendor_id');
		$row_data['notes'] 				= $this->input->post('notes');
		$row_data['greeting_card_id'] 	= $this->input->post('greeting_card_id');
		$row_data['personal_message'] 	= $this->input->post('personal_message');
		$row_data['website_id'] 		= 1;
		$row_data['updated_by'] 		= $_username;
		$row_data['updated_date'] 		= date('Y-m-d H:i:s');
				
		$lastinsertedid = $this->erpmodel->AddNewRow('trnorderprocessing', $row_data);
		
		if($lastinsertedid) {
			if($this->input->post('order_product_id')) {
				$key['id']		= $this->input->post('order_product_id');
				$rj['status'] 	= $update_status;
				$update_id		= $this->erpmodel->UpdateRow('erp_order', $rj, $key);
				echo 'success';
			}
		}
	}
	
	public function addfinishedproductdetails()
	{ 
		$erp_order_id = $this->input->get('erp_order_id');
		$erp_product_id = $this->input->get('order_product_id');
 
		$data['selectdata'] = $this->erpmodel->get_order_details($erp_order_id,$erp_product_id);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/add_finished_product_details',$data);	
		$this->load->view('templates/footer');		
	}
	
	
	
	public function saveproductdetails()
	{
		
		 //echo '<pre>'; print_r($this->input->post()); exit;
		$row_data['erp_order_id'] 		= $this->input->post('order_product_id');
	 
		$row_data['diamond_1_status'] 		= $this->input->post('diamond_1_status');
		$row_data['diamond_1_stones'] 		= $this->input->post('diamond_1_stones');
		$row_data['diamond_1_weight'] 		= $this->input->post('diamond_1_weight');
		$row_data['diamond_1_size'] 		= $this->input->post('diamond_1_size');
		$row_data['diamond_1_shape'] 		= $this->input->post('diamond_1_shape');
		$row_data['diamond_1_setting_type'] = $this->input->post('diamond_1_setting_type');
		 
		$row_data['diamond_2_status'] 		= $this->input->post('diamond_2_status');
		$row_data['diamond_2_stones'] 		= $this->input->post('diamond_2_stones');
		$row_data['diamond_2_weight'] 		= $this->input->post('diamond_2_weight');
		$row_data['diamond_2_size'] 		= $this->input->post('diamond_2_size');
		$row_data['diamond_2_shape'] 		= $this->input->post('diamond_2_shape');
		$row_data['diamond_2_setting_type'] = $this->input->post('diamond_2_setting_type');
		 
		$row_data['diamond_3_status'] 		= $this->input->post('diamond_3_status');
		$row_data['diamond_3_stones'] 		= $this->input->post('diamond_3_stones');
		$row_data['diamond_3_weight'] 		= $this->input->post('diamond_3_weight');
		$row_data['diamond_3_size'] 		= $this->input->post('diamond_3_size');
		$row_data['diamond_3_shape'] 		= $this->input->post('diamond_3_shape');
		$row_data['diamond_3_setting_type'] = $this->input->post('diamond_3_setting_type');
		 
		$row_data['diamond_4_status'] 		= $this->input->post('diamond_4_status');
		$row_data['diamond_4_stones'] 		= $this->input->post('diamond_4_stones');
		$row_data['diamond_4_weight'] 		= $this->input->post('diamond_4_weight');
		$row_data['diamond_4_size'] 		= $this->input->post('diamond_4_size');
		$row_data['diamond_4_shape'] 		= $this->input->post('diamond_4_shape');
		$row_data['diamond_4_setting_type'] = $this->input->post('diamond_4_setting_type');
		 
		$row_data['diamond_5_status'] 		= $this->input->post('diamond_5_status');
		$row_data['diamond_5_stones'] 		= $this->input->post('diamond_5_stones');
		$row_data['diamond_5_weight'] 		= $this->input->post('diamond_5_weight');
		$row_data['diamond_5_size'] 		= $this->input->post('diamond_5_size');
		$row_data['diamond_5_shape'] 		= $this->input->post('diamond_5_shape');
		$row_data['diamond_5_setting_type'] = $this->input->post('diamond_5_setting_type');
		 
		$row_data['diamond_6_status'] 		= $this->input->post('diamond_6_status');
		$row_data['diamond_6_stones'] 		= $this->input->post('diamond_6_stones');
		$row_data['diamond_6_weight'] 		= $this->input->post('diamond_6_weight');
		$row_data['diamond_6_size'] 		= $this->input->post('diamond_6_size');
		$row_data['diamond_6_shape'] 		= $this->input->post('diamond_6_shape');
		$row_data['diamond_6_setting_type'] = $this->input->post('diamond_6_setting_type');
		
		 
		$row_data['diamond_7_status'] 		= $this->input->post('diamond_7_status');
		$row_data['diamond_7_stones'] 		= $this->input->post('diamond_7_stones');
		$row_data['diamond_7_weight'] 		= $this->input->post('diamond_7_weight');
		$row_data['diamond_7_size'] 		= $this->input->post('diamond_7_size');
		$row_data['diamond_7_shape'] 		= $this->input->post('diamond_7_shape');
		$row_data['diamond_7_setting_type'] = $this->input->post('diamond_7_setting_type');
		 
		
		$row_data['diamond_8_status'] 		= $this->input->post('diamond_8_status');
		$row_data['diamond_8_stones'] 		= $this->input->post('diamond_8_stones');
		$row_data['diamond_8_weight'] 		= $this->input->post('diamond_8_weight');
		$row_data['diamond_8_size'] 		= $this->input->post('diamond_8_size');
		$row_data['diamond_8_shape'] 		= $this->input->post('diamond_8_shape');
		
		$row_data['diamond_8_setting_type'] = $this->input->post('diamond_8_setting_type');
		 
		
		$row_data['diamond_9_status'] 		= $this->input->post('diamond_9_status');
		$row_data['diamond_9_stones'] 		= $this->input->post('diamond_9_stones');
		$row_data['diamond_9_weight'] 		= $this->input->post('diamond_9_weight');
		$row_data['diamond_9_size'] 		= $this->input->post('diamond_9_size');
		$row_data['diamond_9_shape'] 		= $this->input->post('diamond_9_shape');
		$row_data['diamond_9_setting_type'] = $this->input->post('diamond_9_setting_type');
		 
		
		$row_data['diamond_10_status'] 		= $this->input->post('diamond_10_status');
		$row_data['diamond_10_stones'] 		= $this->input->post('diamond_10_stones');
		$row_data['diamond_10_weight'] 		= $this->input->post('diamond_10_weight');
		$row_data['diamond_10_size'] 		= $this->input->post('diamond_10_size');
		$row_data['diamond_10_shape'] 		= $this->input->post('diamond_10_shape');
		$row_data['diamond_10_setting_type'] = $this->input->post('diamond_10_setting_type');
		 
		
		$row_data['gem_1_status'] 		    = $this->input->post('gem_1_status');
		$row_data['gemstone_1_type'] 		= $this->input->post('gemstone_1_type');
		$row_data['gemstone_1_stone'] 		= $this->input->post('gemstone_1_stone');
		$row_data['gemstone_1_weight'] 		= $this->input->post('gemstone_1_weight');
		$row_data['gemstone_1_color'] 		= $this->input->post('gemstone_1_color');
		$row_data['gemstone_1_shape'] 		= $this->input->post('gemstone_1_shape');
		$row_data['gemstone_1_setting_type']= $this->input->post('gemstone_1_setting_type');
		
		$row_data['gem_2_status'] 		    = $this->input->post('gem_2_status');
		$row_data['gemstone_2_type'] 		= $this->input->post('gemstone_2_type');
		$row_data['gemstone_2_stone'] 		= $this->input->post('gemstone_2_stone');
		$row_data['gemstone_2_weight'] 		= $this->input->post('gemstone_2_weight');
		$row_data['gemstone_2_color'] 		= $this->input->post('gemstone_2_color');
		$row_data['gemstone_2_shape'] 		= $this->input->post('gemstone_2_shape');
		$row_data['gemstone_2_setting_type']= $this->input->post('gemstone_2_setting_type');
		
		$row_data['gem_3_status'] 		    = $this->input->post('gem_3_status');
		$row_data['gemstone_3_type'] 		= $this->input->post('gemstone_3_type');
		$row_data['gemstone_3_stone'] 		= $this->input->post('gemstone_3_stone');
		$row_data['gemstone_3_weight'] 		= $this->input->post('gemstone_3_weight');
		$row_data['gemstone_3_color'] 		= $this->input->post('gemstone_3_color');
		$row_data['gemstone_3_shape'] 		= $this->input->post('gemstone_3_shape');
		$row_data['gemstone_3_setting_type']= $this->input->post('gemstone_3_setting_type');
		
		$row_data['gem_4_status'] 		    = $this->input->post('gem_4_status');
		$row_data['gemstone_4_type'] 		= $this->input->post('gemstone_4_type');
		$row_data['gemstone_4_stone'] 		= $this->input->post('gemstone_4_stone');
		$row_data['gemstone_4_weight'] 		= $this->input->post('gemstone_4_weight');
		$row_data['gemstone_4_color'] 		= $this->input->post('gemstone_4_color');
		$row_data['gemstone_4_shape'] 		= $this->input->post('gemstone_4_shape');
		$row_data['gemstone_4_setting_type']= $this->input->post('gemstone_4_setting_type');
		
		$row_data['gem_5_status'] 		    = $this->input->post('gem_5_status');
		$row_data['gemstone_5_type'] 		= $this->input->post('gemstone_5_type');
		$row_data['gemstone_5_stone'] 		= $this->input->post('gemstone_5_stone');
		$row_data['gemstone_5_weight'] 		= $this->input->post('gemstone_5_weight');
		$row_data['gemstone_5_color'] 		= $this->input->post('gemstone_5_color');
		$row_data['gemstone_5_shape'] 		= $this->input->post('gemstone_5_shape');
		$row_data['gemstone_5_setting_type']= $this->input->post('gemstone_5_setting_type');
		
		$row_data['gem_6_status'] 		    = $this->input->post('gem_6_status');
		$row_data['gemstone_6_type'] 		= $this->input->post('gemstone_6_type');
		$row_data['gemstone_6_stone'] 		= $this->input->post('gemstone_6_stone');
		$row_data['gemstone_6_weight'] 		= $this->input->post('gemstone_6_weight');
		$row_data['gemstone_6_color'] 		= $this->input->post('gemstone_6_color');
		$row_data['gemstone_6_shape'] 		= $this->input->post('gemstone_6_shape');
		$row_data['gemstone_6_setting_type']= $this->input->post('gemstone_6_setting_type');
		
		$row_data['gem_7_status'] 		    = $this->input->post('gem_7_status');
		$row_data['gemstone_7_type'] 		= $this->input->post('gemstone_7_type');
		$row_data['gemstone_7_stone'] 		= $this->input->post('gemstone_7_stone');
		$row_data['gemstone_7_weight'] 		= $this->input->post('gemstone_7_weight');
		$row_data['gemstone_7_color'] 		= $this->input->post('gemstone_7_color');
		$row_data['gemstone_7_shape'] 		= $this->input->post('gemstone_7_shape');
		$row_data['gemstone_7_setting_type']= $this->input->post('gemstone_7_setting_type');
		
		$row_data['gem_8_status'] 		    = $this->input->post('gem_8_status');
		$row_data['gemstone_8_type'] 		= $this->input->post('gemstone_8_type');
		$row_data['gemstone_8_stone'] 		= $this->input->post('gemstone_8_stone');
		$row_data['gemstone_8_weight'] 		= $this->input->post('gemstone_8_weight');
		$row_data['gemstone_8_color'] 		= $this->input->post('gemstone_8_color');
		$row_data['gemstone_8_shape'] 		= $this->input->post('gemstone_8_shape');
		$row_data['gemstone_8_setting_type']= $this->input->post('gemstone_8_setting_type');
		
		$row_data['gem_9_status'] 		    = $this->input->post('gem_9_status');
		$row_data['gemstone_9_type'] 		= $this->input->post('gemstone_9_type');
		$row_data['gemstone_9_stone'] 		= $this->input->post('gemstone_9_stone');
		$row_data['gemstone_9_weight'] 		= $this->input->post('gemstone_9_weight');
		$row_data['gemstone_9_color'] 		= $this->input->post('gemstone_9_color');
		$row_data['gemstone_9_shape'] 		= $this->input->post('gemstone_9_shape');
		$row_data['gemstone_9_setting_type']= $this->input->post('gemstone_9_setting_type');
		
        
		// echo '<pre>' ;
		// print_r($row_data) ;
		// echo '</pre>' ;
		   // exit ;
		  $query = $this->db->select("id")
              ->from('erp_order_details') 
              ->where('erp_order_id', $this->input->post('order_product_id'))  
              ->get();
			  
		$order_data = $query->row();
						
		if(isset($order_data->id)) {
			$key['id']= $order_data->id; 
			 $this->erpmodel->UpdateRow('erp_order_details', $row_data,$key); 
		}
		
		
		
		//$last_insert_id = $this->erpmodel->AddNewRow('finished_product_log', $row_data); 
		//exit ;
		redirect('erp_order/product_updates');
	}
		
	
	public function sales_flat_data()
	{
		$recordsCount = $this->erpmodel->record_count('sales_flat_order');
		
		// pagination code
		$this->load->library("pagination");
		$config['base_url'] = base_url()."index.php/erp_order/sales_flat_data";
		
		$config['total_rows'] 	= 1000;
		$config['per_page'] 	= 20; 
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
		$config['page_query_string'] = FALSE;
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				
		$data['selectdata'] = $this->erpmodel->sales_details($limit, $start);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/sales_flat_data',$data);	
		$this->load->view('templates/footer');
	}
	
	public function update_dispatch_date()
	{
		$controller 						= $this->input->post('controller');
		$originalDate 						= $this->input->post('updated_dispatch_date');
		$row_data['dispatch_date'] 			= date("Y-m-d", strtotime($originalDate));
		
		$query = $this->db->select("id")
              ->from('erp_order') 
              ->where('order_id', $this->input->post('order_id'))
              ->where('product_id', $this->input->post('product_id'))  
              ->get();
		$order_data = $query->row();
		
		if(isset($order_data->id)) {
			$key['id']= $order_data->id; 
			$this->erpmodel->UpdateRow('erp_order', $row_data, $key);
		}
		redirect("erp_order/$controller");
	}	
	
	public function cancel_order()
	{
		$_username 	= @$this->session->userdata('_username');
		
		$query = $this->db->select("id")
              ->from('erp_order') 
              ->where('order_id', $this->input->post('order_id'))
              ->where('product_id', $this->input->post('product_id'))  
              ->get();
		$order_data = $query->row();
		
		if(isset($order_data->id)) {
			$row_data['status']			= $this->input->post('order_status_id');
			$key['id']					= $order_data->id; 
			$this->erpmodel->UpdateRow('erp_order', $row_data, $key);
			
			$data['order_id']			= $this->input->post('order_id');
			$data['order_product_id']	= $this->input->post('order_product_id');
			$data['order_status_id'] 	= $this->input->post('order_status_id');
			$data['vendor_id'] 			= $this->input->post('vendor_id');
			$data['notes']				= $this->input->post('notes');
			$data['greeting_card_id']	= $this->input->post('greeting_card_id');
			$data['personal_message']	= $this->input->post('personal_message');
			$data['website_id']			= $this->input->post('website_id');
			$data['updated_by']			= $_username;
			$data['updated_date']		= date('Y-m-d H:i:s');
						
			$this->erpmodel->AddNewRow('trnorderprocessing', $data);
		}
		
		echo 'success';
	}
	
	public function update_price()
	{
		$query = $this->db->select("id")
              ->from('erp_order') 
              ->where('order_id', $this->input->post('order_id'))
              ->where('product_id', $this->input->post('product_id'))  
              ->get();
		$order_data = $query->row();
		
		if(isset($order_data->id)) {
			$row_data['updated_price']	= $this->input->post('updated_price');
			$key['id']					= $order_data->id; 
			$this->erpmodel->UpdateRow('erp_order', $row_data, $key);
		}
		
		$redirect = $this->input->post('controller');
		redirect("erp_order/$redirect");
	}
	
	public function get_product_name()
	{
		$sku 		= $this->input->post('sku');
		//$product_id = Mage::getModel("catalog/product")->getIdBySku($sku);
		
		$query = $this->db->query("select product_id from pricing_table_metal_options where sku ='$sku' ");
		$product_data 	= $query->row();
		$product_id 	= $product_data->product_id;
				
		$_product 	= Mage::getModel('catalog/product')->load($product_id);	
		
		if($_product->getName()) {
			echo $_product->getName();
		} else {
			echo 'error';
		}
		
	}
	
	public function create_marketplace_order()
	{
		$helper = Mage::helper('sendordertoerp/data');
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red;">','</span>');
		
		$this->form_validation->set_rules('marketplace', 'Marketplace', 'trim|xss_clean|required');
		$this->form_validation->set_rules('flipkart_sku', 'SKU', 'trim|xss_clean|required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('order_id', 'Order Id', 'trim|xss_clean|required');
		$this->form_validation->set_rules('order_product_id', 'Order Product Id', 'trim|xss_clean|required');
		$this->form_validation->set_rules('metal', 'Metal', 'trim|xss_clean|required');
		$this->form_validation->set_rules('purity', 'Purity', 'trim|xss_clean|required');
		$this->form_validation->set_rules('size', 'Size', 'trim|xss_clean|required');
		$this->form_validation->set_rules('metal_weight_approx', 'Metal Weight', 'trim|xss_clean|required');
		$this->form_validation->set_rules('total_weight_approx', 'Total Weight', 'trim|xss_clean|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|xss_clean|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|xss_clean|required');
		$this->form_validation->set_rules('order_placed_date', 'Order Placed Date', 'trim|xss_clean|required');
		$this->form_validation->set_rules('dispatch_date', 'Dispatch Date', 'trim|xss_clean|required');
		$this->form_validation->set_rules('buyer_address', 'Buyer Address', 'trim|xss_clean|required');
		$this->form_validation->set_rules('shipping_country', 'Shipping Country', 'trim|xss_clean|required');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|xss_clean');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('erp_order/create_marketplace_order');	
			$this->load->view('templates/footer');
		}
		else
		{
			$_username 	= @$this->session->userdata('_username');
			
			$query = $this->db->get_where('erp_order', array('order_id' => $this->input->post('order_id')));
			$count = $query->num_rows();
			
			if($count == 0) {
				$flipkart_sku 	= $this->input->post('flipkart_sku');
				$flipkart_sku2 	= explode('_', $flipkart_sku);
				$sku 			= ($flipkart_sku2[0]) ? trim($flipkart_sku2[0]) : '';
				//$purity 		= ($flipkart_sku2[1]) ? trim($flipkart_sku2[1]) : '';
				//$ring_size	= ($flipkart_sku2[2]) ? trim($flipkart_sku2[2]) : '';
				
				$ring_size 	= $this->input->post('size');
				$metal 		= $this->input->post('metal');
				$purity 	= $this->input->post('purity');
				
				$query = $this->db->query("select product_id from pricing_table_metal_options where sku= '$sku'");
				$res 		= $query->row();
				$product_id	= $res->product_id;
								
				$query = $this->db->query("select metal_id from metal_options_enabled where product_id = '$product_id' and  isdefault=1");
				$res 		= $query->row();
				$metal_id	= $res->metal_id;
				
				$query = $this->db->query("select sku from pricing_table_metal_options where product_id='$product_id' and isdefault=1 and metal_id='$metal_id'");
				$res 		= $query->row();
				$new_sku	= $res->sku;
				
				
				$product_id = Mage::getModel("catalog/product")->getIdBySku($new_sku);
				$_product 	= Mage::getModel('catalog/product')->load($product_id);
				
				//echo '<pre>'; print_r($_product->getData()); exit;
				
				if(isset($metal)){
					$img_metal = strtolower(str_replace(' ','_',$metal.'_default'));
				}
				
				$product_image = Mage::helper('catalog/image')->init($_product, $img_metal)->resize(150); 
					
				$default_metal_weight   = $_product->getDefault_metal_weight(); 
				$default_total_weight 	= $_product->getTotal_weight();
				$product_url 			= $_product->getUrlPath();
				$height 				= $_product->getHeight();
				$width 					= $_product->getWidth();
				$top_thickness 			= $_product->getTopThickness();
				$top_height 			= $_product->getTopHeight();
				$bottom_thickness 		= $_product->getBottomThickness();
				$expected_delivery_days	= $_product->getExpectedDeliveryDays();
				$design_identifier		= $_product->getDesignIdentifier();
				
				$height 			= isset($height ) ? $height : '';
				$width 				= isset($width) ? $width : '';
				$top_thickness 		= isset($top_thickness) ? $top_thickness : '';
				$top_height 		= isset($top_height) ? $top_height : '';
				$bottom_thickness 	= isset($bottom_thickness) ? $bottom_thickness : '';
				$design_identifier 	= isset($design_identifier) ? $design_identifier : '';
				
				$product_type = Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getCandere_product_type(), 'candere_product_type'); 
							
				$default_bracelets_length = trim(str_replace('inches','',Mage::helper('function')->get_attribute_name_and_value_frontend($_product->getBracelets_length(),'bracelets_length')));
				
				$metal_weight_approx = $this->input->post('metal_weight_approx');
				$metal_weight 	= isset($metal_weight_approx) ? $metal_weight_approx : $default_metal_weight;	

				$total_weight_approx = $this->input->post('total_weight_approx');
				$total_weight 	= isset($total_weight_approx) ? $total_weight_approx : $default_total_weight;

				$no_of_stones = $_product->getResource()->getAttribute('no_of_stones')->getFrontend()->getValue($_product);	
				$no_of_stones = isset($no_of_stones) ? $no_of_stones : 0;
				
				$diamond_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_status');
								
				$collection_details_diamond_status = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_status->getId())->getFirstItem();
					
				$diamond_1_status = $collection_details_diamond_status->getDiamond_1();
				$diamond_2_status = $collection_details_diamond_status->getDiamond_2();
				$diamond_3_status = $collection_details_diamond_status->getDiamond_3();
				$diamond_4_status = $collection_details_diamond_status->getDiamond_4();
				$diamond_5_status = $collection_details_diamond_status->getDiamond_5();
				$diamond_6_status = $collection_details_diamond_status->getDiamond_6();
				$diamond_7_status = $collection_details_diamond_status->getDiamond_7();
			
				if ($diamond_1_status == 1 || $diamond_2_status == 1 || $diamond_3_status == 1 || $diamond_4_status == 1 || $diamond_5_status == 1 || $diamond_6_status == 1 || $diamond_7_status == 1) {
					$diamond_one_total_no_of_stones = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_one_total_no_of_stones');
				
					$collection_details_stones = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_one_total_no_of_stones->getId())->getFirstItem();
											
					$diamond_1_stones = $collection_details_stones->getDiamond_1();
					$diamond_2_stones = $collection_details_stones->getDiamond_2();
					$diamond_3_stones = $collection_details_stones->getDiamond_3();
					$diamond_4_stones = $collection_details_stones->getDiamond_4();
					$diamond_5_stones = $collection_details_stones->getDiamond_5();
					$diamond_6_stones = $collection_details_stones->getDiamond_6();
					$diamond_7_stones = $collection_details_stones->getDiamond_7();
					
					$diamond_one_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'diamond_one_total_weight');

					$collection_details_weight = Mage::getModel('diamonddetails/diamonddetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $diamond_one_total_weight->getId())->getFirstItem();
					
					$diamond_1_weight = $collection_details_weight->getDiamond_1();
					$diamond_2_weight = $collection_details_weight->getDiamond_2();
					$diamond_3_weight = $collection_details_weight->getDiamond_3();
					$diamond_4_weight = $collection_details_weight->getDiamond_4();
					$diamond_5_weight = $collection_details_weight->getDiamond_5();
					$diamond_6_weight = $collection_details_weight->getDiamond_6();
					$diamond_7_weight = $collection_details_weight->getDiamond_7();
					
					$diamond_details_clarity = $helper->getDiamondDetails('diamond_one_clarity', $product_id);
					
					$diamond_1_clarity = $diamond_details_clarity['diamond_1_code'];
					$diamond_2_clarity = $diamond_details_clarity['diamond_2_code'];
					$diamond_3_clarity = $diamond_details_clarity['diamond_3_code'];
					$diamond_4_clarity = $diamond_details_clarity['diamond_4_code'];
					$diamond_5_clarity = $diamond_details_clarity['diamond_5_code'];
					$diamond_6_clarity = $diamond_details_clarity['diamond_6_code'];
					$diamond_7_clarity = $diamond_details_clarity['diamond_7_code'];
					
					$diamond_details_shape = $helper->getDiamondDetails('diamond_one_shape', $product_id);
					
					$diamond_1_shape = $diamond_details_shape['diamond_1_code'];
					$diamond_2_shape = $diamond_details_shape['diamond_2_code'];
					$diamond_3_shape = $diamond_details_shape['diamond_3_code'];
					$diamond_4_shape = $diamond_details_shape['diamond_4_code'];
					$diamond_5_shape = $diamond_details_shape['diamond_5_code'];
					$diamond_6_shape = $diamond_details_shape['diamond_6_code'];
					$diamond_7_shape = $diamond_details_shape['diamond_7_code'];
					
					$diamond_details_color = $helper->getDiamondDetails('diamond_one_color', $product_id);
					
					$diamond_1_color = $diamond_details_color['diamond_1_code'];
					$diamond_2_color = $diamond_details_color['diamond_2_code'];
					$diamond_3_color = $diamond_details_color['diamond_3_code'];
					$diamond_4_color = $diamond_details_color['diamond_4_code'];
					$diamond_5_color = $diamond_details_color['diamond_5_code'];
					$diamond_6_color = $diamond_details_color['diamond_6_code'];
					$diamond_7_color = $diamond_details_color['diamond_7_code'];
					
					$diamond_details_type = $helper->getDiamondDetails('diamond_one_setting_type', $product_id);
					
					$diamond_1_setting_type = $diamond_details_type['diamond_1_code'];
					$diamond_2_setting_type = $diamond_details_type['diamond_2_code'];
					$diamond_3_setting_type = $diamond_details_type['diamond_3_code'];
					$diamond_4_setting_type = $diamond_details_type['diamond_4_code'];
					$diamond_5_setting_type = $diamond_details_type['diamond_5_code'];
					$diamond_6_setting_type = $diamond_details_type['diamond_6_code'];
					$diamond_7_setting_type = $diamond_details_type['diamond_7_code'];
				}
			 
				$gemstone_status = Mage::getModel('eav/config')->getAttribute('catalog_product','gemstone_status');
				
				$collection_details_gemstone_status = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_status->getId())->getFirstItem();
					
				$gem_1_status = $collection_details_gemstone_status->getGemstone_1();
				$gem_2_status = $collection_details_gemstone_status->getGemstone_2();
				$gem_3_status = $collection_details_gemstone_status->getGemstone_3();
				$gem_4_status = $collection_details_gemstone_status->getGemstone_4();
				$gem_5_status = $collection_details_gemstone_status->getGemstone_5();
			
				if ($gem_1_status == 1 || $gem_2_status == 1 || $gem_3_status == 1 || $gem_4_status == 1 || $gem_5_status == 1) {
							
					$gemstone_total_stone = $helper->getGemstoneDetails('gemstone_total_stone', $product_id);
					
					$gemstone_1_stone = $gemstone_total_stone['gemstone_1_code'];
					$gemstone_2_stone = $gemstone_total_stone['gemstone_2_code'];
					$gemstone_3_stone = $gemstone_total_stone['gemstone_3_code'];
					$gemstone_4_stone = $gemstone_total_stone['gemstone_4_code'];
					$gemstone_5_stone = $gemstone_total_stone['gemstone_5_code'];
					
					$gemstone_type = $helper->getGemstoneDetails('gemstone', $product_id);
					
					$gemstone_1_type = $gemstone_type['gemstone_1_code'];
					$gemstone_2_type = $gemstone_type['gemstone_2_code'];
					$gemstone_3_type = $gemstone_type['gemstone_3_code'];
					$gemstone_4_type = $gemstone_type['gemstone_4_code'];
					$gemstone_5_type = $gemstone_type['gemstone_5_code'];
					
					$gemstone_color = $helper->getGemstoneDetails('gemstone_color', $product_id);
					
					$gemstone_1_color = $gemstone_color['gemstone_1_code'];
					$gemstone_2_color = $gemstone_color['gemstone_2_code'];
					$gemstone_3_color = $gemstone_color['gemstone_3_code'];
					$gemstone_4_color = $gemstone_color['gemstone_4_code'];
					$gemstone_5_color = $gemstone_color['gemstone_5_code'];
					
					$gemstone_shape = $helper->getGemstoneDetails('gemstone_shape', $product_id);
					
					$gemstone_1_shape = $gemstone_shape['gemstone_1_code'];
					$gemstone_2_shape = $gemstone_shape['gemstone_2_code'];
					$gemstone_3_shape = $gemstone_shape['gemstone_3_code'];
					$gemstone_4_shape = $gemstone_shape['gemstone_4_code'];
					$gemstone_5_shape = $gemstone_shape['gemstone_5_code'];
					
					$gemstone_setting_type = $helper->getGemstoneDetails('gemstone_setting_type', $product_id);
					
					$gemstone_1_setting_type = $gemstone_setting_type['gemstone_1_code'];
					$gemstone_2_setting_type = $gemstone_setting_type['gemstone_2_code'];
					$gemstone_3_setting_type = $gemstone_setting_type['gemstone_3_code'];
					$gemstone_4_setting_type = $gemstone_setting_type['gemstone_4_code'];
					$gemstone_5_setting_type = $gemstone_setting_type['gemstone_5_code'];
					
					$gemstone_total_weight = Mage::getModel('eav/config')->getAttribute('catalog_product', 'gemstone_total_weight');
				
					$collection_details_weight = Mage::getModel('diamonddetails/gemstonedetails')->getCollection()->addFieldToFilter('product_id', $product_id)->addFieldToFilter('store_id', 0)->addFieldToFilter('attribute_id', $gemstone_total_weight->getId())->getFirstItem();
											
					$gemstone_1_weight = $collection_details_weight->getGemstone_1();
					$gemstone_2_weight = $collection_details_weight->getGemstone_2();
					$gemstone_3_weight = $collection_details_weight->getGemstone_3();
					$gemstone_4_weight = $collection_details_weight->getGemstone_4();
					$gemstone_5_weight = $collection_details_weight->getGemstone_5();
				}
			
					$diamond_1_status = isset($diamond_1_status) ? $diamond_1_status : '';
					$diamond_2_status = isset($diamond_2_status) ? $diamond_2_status : '';
					$diamond_3_status = isset($diamond_3_status) ? $diamond_3_status : '';
					$diamond_4_status = isset($diamond_4_status) ? $diamond_4_status : '';
					$diamond_5_status = isset($diamond_5_status) ? $diamond_5_status : '';
					$diamond_6_status = isset($diamond_6_status) ? $diamond_6_status : '';
					$diamond_7_status = isset($diamond_7_status) ? $diamond_7_status : '';
					$diamond_1_stones = isset($diamond_1_stones) ? $diamond_1_stones : '';
					$diamond_2_stones = isset($diamond_2_stones) ? $diamond_2_stones : '';
					$diamond_3_stones = isset($diamond_3_stones) ? $diamond_3_stones : '';
					$diamond_4_stones = isset($diamond_4_stones) ? $diamond_4_stones : '';
					$diamond_5_stones = isset($diamond_5_stones) ? $diamond_5_stones : '';
					$diamond_6_stones = isset($diamond_6_stones) ? $diamond_6_stones : '';
					$diamond_7_stones = isset($diamond_7_stones) ? $diamond_7_stones : '';
					$diamond_1_weight = isset($diamond_1_weight) ? $diamond_1_weight : '';
					$diamond_2_weight = isset($diamond_2_weight) ? $diamond_2_weight : '';
					$diamond_3_weight = isset($diamond_3_weight) ? $diamond_3_weight : '';
					$diamond_4_weight = isset($diamond_4_weight) ? $diamond_4_weight : '';
					$diamond_5_weight = isset($diamond_5_weight) ? $diamond_5_weight : '';
					$diamond_6_weight = isset($diamond_6_weight) ? $diamond_6_weight : '';
					$diamond_7_weight = isset($diamond_7_weight) ? $diamond_7_weight : '';
					$diamond_1_clarity = isset($diamond_1_clarity) ? $diamond_1_clarity : '';
					$diamond_2_clarity = isset($diamond_2_clarity) ? $diamond_2_clarity : '';
					$diamond_3_clarity = isset($diamond_3_clarity) ? $diamond_3_clarity : '';
					$diamond_4_clarity = isset($diamond_4_clarity) ? $diamond_4_clarity : '';
					$diamond_5_clarity = isset($diamond_5_clarity) ? $diamond_5_clarity : '';
					$diamond_6_clarity = isset($diamond_6_clarity) ? $diamond_6_clarity : '';
					$diamond_7_clarity = isset($diamond_7_clarity) ? $diamond_7_clarity : '';
					$diamond_1_shape = isset($diamond_1_shape) ? $diamond_1_shape : '';
					$diamond_2_shape = isset($diamond_2_shape) ? $diamond_2_shape : '';
					$diamond_3_shape = isset($diamond_3_shape) ? $diamond_3_shape : '';
					$diamond_4_shape = isset($diamond_4_shape) ? $diamond_4_shape : '';
					$diamond_5_shape = isset($diamond_5_shape) ? $diamond_5_shape : '';
					$diamond_6_shape = isset($diamond_6_shape) ? $diamond_6_shape : '';
					$diamond_7_shape = isset($diamond_7_shape) ? $diamond_7_shape : '';
					$diamond_1_color = isset($diamond_1_color) ? $diamond_1_color : '';
					$diamond_2_color = isset($diamond_2_color) ? $diamond_2_color : '';
					$diamond_3_color = isset($diamond_3_color) ? $diamond_3_color : '';
					$diamond_4_color = isset($diamond_4_color) ? $diamond_4_color : '';
					$diamond_5_color = isset($diamond_5_color) ? $diamond_5_color : '';
					$diamond_6_color = isset($diamond_6_color) ? $diamond_6_color : '';
					$diamond_7_color = isset($diamond_7_color) ? $diamond_7_color : '';
					$diamond_1_setting_type = isset($diamond_1_setting_type) ? $diamond_1_setting_type : '';
					$diamond_2_setting_type = isset($diamond_2_setting_type) ? $diamond_2_setting_type : '';
					$diamond_3_setting_type = isset($diamond_3_setting_type) ? $diamond_3_setting_type : '';
					$diamond_4_setting_type = isset($diamond_4_setting_type) ? $diamond_4_setting_type : '';
					$diamond_5_setting_type = isset($diamond_5_setting_type) ? $diamond_5_setting_type : '';
					$diamond_6_setting_type = isset($diamond_6_setting_type) ? $diamond_6_setting_type : '';
					$diamond_7_setting_type = isset($diamond_7_setting_type) ? $diamond_7_setting_type : '';
					$gem_1_status = isset($gem_1_status) ? $gem_1_status : '';
					$gem_2_status = isset($gem_2_status) ? $gem_2_status : '';
					$gem_3_status = isset($gem_3_status) ? $gem_3_status : '';
					$gem_4_status = isset($gem_4_status) ? $gem_4_status : '';
					$gem_5_status = isset($gem_5_status) ? $gem_5_status : '';
					$gemstone_1_stone = isset($gemstone_1_stone) ? $gemstone_1_stone : '';
					$gemstone_2_stone = isset($gemstone_2_stone) ? $gemstone_2_stone : '';
					$gemstone_3_stone = isset($gemstone_3_stone) ? $gemstone_3_stone : '';
					$gemstone_4_stone = isset($gemstone_4_stone) ? $gemstone_4_stone : '';
					$gemstone_5_stone = isset($gemstone_5_stone) ? $gemstone_5_stone : '';
					$gemstone_1_type = isset($gemstone_1_type) ? $gemstone_1_type : '';
					$gemstone_2_type = isset($gemstone_2_type) ? $gemstone_2_type : '';
					$gemstone_3_type = isset($gemstone_3_type) ? $gemstone_3_type : '';
					$gemstone_4_type = isset($gemstone_4_type) ? $gemstone_4_type : '';
					$gemstone_5_type = isset($gemstone_5_type) ? $gemstone_5_type : '';
					$gemstone_1_color = isset($gemstone_1_color) ? $gemstone_1_color : '';
					$gemstone_2_color = isset($gemstone_2_color) ? $gemstone_2_color : '';
					$gemstone_3_color = isset($gemstone_3_color) ? $gemstone_3_color : '';
					$gemstone_4_color = isset($gemstone_4_color) ? $gemstone_4_color : '';
					$gemstone_5_color = isset($gemstone_5_color) ? $gemstone_5_color : '';
					$gemstone_1_shape = isset($gemstone_1_shape) ? $gemstone_1_shape : '';
					$gemstone_2_shape = isset($gemstone_2_shape) ? $gemstone_2_shape : '';
					$gemstone_3_shape = isset($gemstone_3_shape) ? $gemstone_3_shape : '';
					$gemstone_4_shape = isset($gemstone_4_shape) ? $gemstone_4_shape : '';
					$gemstone_5_shape = isset($gemstone_5_shape) ? $gemstone_5_shape : '';
					$gemstone_1_weight= isset($gemstone_1_weight) ? $gemstone_1_weight : '';
					$gemstone_2_weight= isset($gemstone_2_weight) ? $gemstone_2_weight : '';
					$gemstone_3_weight= isset($gemstone_3_weight) ? $gemstone_3_weight : '';
					$gemstone_4_weight= isset($gemstone_4_weight) ? $gemstone_4_weight : '';
					$gemstone_5_weight= isset($gemstone_5_weight) ? $gemstone_5_weight : '';
					$gemstone_1_setting_type = isset($gemstone_1_setting_type) ? $gemstone_1_setting_type : '';
					$gemstone_2_setting_type = isset($gemstone_2_setting_type) ? $gemstone_2_setting_type : '';
					$gemstone_3_setting_type = isset($gemstone_3_setting_type) ? $gemstone_3_setting_type : '';
					$gemstone_4_setting_type = isset($gemstone_4_setting_type)? $gemstone_4_setting_type : '';
					$gemstone_5_setting_type = isset($gemstone_5_setting_type) ? $gemstone_5_setting_type : '';
		
					$erp_data['order_id'] 			= $this->input->post('order_id');
					$erp_data['product_id'] 		= $product_id;
				 	$erp_data['marketplace_item_id']= $this->input->post('order_product_id');
					$erp_data['customer_name'] 		= $this->input->post('customer_name');
					$erp_data['contact_number'] 	= $this->input->post('contact_number');
					$erp_data['buyer_address'] 		= $this->input->post('buyer_address');
					$erp_data['sku'] 				= $sku;
					$erp_data['product_name'] 		= $this->input->post('product_name');
					$erp_data['quantity'] 			= $this->input->post('quantity');
					$erp_data['unit_price'] 		= $this->input->post('price');
					$originalDate				 	= $this->input->post('order_placed_date');
					$erp_data['order_placed_date'] 	= date("Y-m-d", strtotime($originalDate));
					$erp_data['expected_delivery_date'] = date('Y-m-d', strtotime($originalDate. " + $expected_delivery_days days"));
					$erp_data['shipping_country'] 	= $this->input->post('shipping_country');
					$erp_data['status'] 			= 3;
					$erp_data['marketplace'] 		= $this->input->post('marketplace');
					$erp_data['executed_by'] 		= $_username;
					$erp_data['execution_datetime'] = date('Y-m-d H:i:s');
					$dispatch_date				 	= $this->input->post('dispatch_date');
					$erp_data['dispatch_date'] 		= date("Y-m-d", strtotime($dispatch_date));
					
					$last_insert_id = $this->erpmodel->AddNewRow('erp_order', $erp_data);
			
					if($last_insert_id) {
						$detail_data['erp_order_id'] 		= $last_insert_id;
						$detail_data['product_type'] 		= $product_type;
						$detail_data['metal'] 				= $metal;
						$detail_data['purity'] 				= $purity;
						$detail_data['height'] 				= $height;
						$detail_data['width'] 				= $width;
						$detail_data['design_identifier'] 	= $design_identifier;
						$detail_data['top_thickness'] 		= $top_thickness;
						$detail_data['top_height'] 			= $top_height;
						$detail_data['bottom_thickness'] 	= $bottom_thickness;
						$detail_data['metal_weight'] 		= $metal_weight;
						$detail_data['total_weight'] 		= $total_weight;
						$detail_data['no_of_stones'] 		= $no_of_stones;
						$detail_data['product_image'] 		= htmlentities($product_image);
						$detail_data['product_url'] 		= $product_url;
						$detail_data['ring_size'] 			= $ring_size;
						$detail_data['diamond_1_status']  	= $diamond_1_status;
						$detail_data['diamond_2_status']   	= $diamond_2_status;
						$detail_data['diamond_3_status']   	= $diamond_3_status;
						$detail_data['diamond_4_status']   	= $diamond_4_status;
						$detail_data['diamond_5_status']   	= $diamond_5_status;
						$detail_data['diamond_6_status']   	= $diamond_6_status;
						$detail_data['diamond_7_status']   	= $diamond_7_status;
						$detail_data['diamond_1_stones']   	= $diamond_1_stones;
						$detail_data['diamond_2_stones']   	= $diamond_2_stones;
						$detail_data['diamond_3_stones']  	= $diamond_3_stones;
						$detail_data['diamond_4_stones']   	= $diamond_4_stones;
						$detail_data['diamond_5_stones']	= $diamond_5_stones;
						$detail_data['diamond_6_stones']	= $diamond_6_stones;
						$detail_data['diamond_7_stones']	= $diamond_7_stones;
						$detail_data['diamond_1_weight']	= $diamond_1_weight;
						$detail_data['diamond_2_weight']	= $diamond_2_weight;
						$detail_data['diamond_3_weight']	= $diamond_3_weight;
						$detail_data['diamond_4_weight']	= $diamond_4_weight;
						$detail_data['diamond_5_weight']	= $diamond_5_weight;
						$detail_data['diamond_6_weight']	= $diamond_6_weight;
						$detail_data['diamond_7_weight']	= $diamond_7_weight;
						$detail_data['diamond_1_clarity']	= $diamond_1_clarity;
						$detail_data['diamond_2_clarity']	= $diamond_2_clarity;
						$detail_data['diamond_3_clarity']	= $diamond_3_clarity;
						$detail_data['diamond_4_clarity']	= $diamond_4_clarity;
						$detail_data['diamond_5_clarity']	= $diamond_5_clarity;
						$detail_data['diamond_6_clarity']	= $diamond_6_clarity;
						$detail_data['diamond_7_clarity']	= $diamond_7_clarity;
						$detail_data['diamond_1_shape']		= $diamond_1_shape;
						$detail_data['diamond_2_shape']		= $diamond_2_shape;
						$detail_data['diamond_3_shape']		= $diamond_3_shape;
						$detail_data['diamond_4_shape']		= $diamond_4_shape;
						$detail_data['diamond_5_shape']		= $diamond_5_shape;
						$detail_data['diamond_6_shape']		= $diamond_6_shape;
						$detail_data['diamond_7_shape']		= $diamond_7_shape;
						$detail_data['diamond_1_color']		= $diamond_1_color;
						$detail_data['diamond_2_color']		= $diamond_2_color;
						$detail_data['diamond_3_color']		= $diamond_3_color;
						$detail_data['diamond_4_color']		= $diamond_4_color;
						$detail_data['diamond_5_color']		= $diamond_5_color;
						$detail_data['diamond_6_color']		= $diamond_6_color;
						$detail_data['diamond_7_color']		= $diamond_7_color;
						$detail_data['diamond_1_setting_type']= $diamond_1_setting_type;
						$detail_data['diamond_2_setting_type']= $diamond_2_setting_type;
						$detail_data['diamond_3_setting_type']= $diamond_3_setting_type;
						$detail_data['diamond_4_setting_type']= $diamond_4_setting_type;
						$detail_data['diamond_5_setting_type']= $diamond_5_setting_type;
						$detail_data['diamond_6_setting_type']= $diamond_6_setting_type;
						$detail_data['diamond_7_setting_type']= $diamond_7_setting_type;
						$detail_data['gem_1_status']		= $gem_1_status; 
						$detail_data['gem_2_status']		= $gem_2_status; 
						$detail_data['gem_3_status']		= $gem_3_status; 
						$detail_data['gem_4_status']		= $gem_4_status; 
						$detail_data['gem_5_status']		= $gem_5_status; 
						$detail_data['gemstone_1_stone']	= $gemstone_1_stone;
						$detail_data['gemstone_2_stone']	= $gemstone_2_stone;
						$detail_data['gemstone_3_stone']	= $gemstone_3_stone;
						$detail_data['gemstone_4_stone']	= $gemstone_4_stone;
						$detail_data['gemstone_5_stone']	= $gemstone_5_stone;
						$detail_data['gemstone_1_type']		= $gemstone_1_type;
						$detail_data['gemstone_2_type']		= $gemstone_2_type;
						$detail_data['gemstone_3_type']		= $gemstone_3_type;
						$detail_data['gemstone_4_type']		= $gemstone_4_type;
						$detail_data['gemstone_5_type']		= $gemstone_5_type;
						$detail_data['gemstone_1_color']	= $gemstone_1_color;
						$detail_data['gemstone_2_color']	= $gemstone_2_color;
						$detail_data['gemstone_3_color']	= $gemstone_3_color;
						$detail_data['gemstone_4_color']	= $gemstone_4_color;
						$detail_data['gemstone_5_color']	= $gemstone_5_color;
						$detail_data['gemstone_1_shape']	= $gemstone_1_shape;
						$detail_data['gemstone_2_shape']	= $gemstone_2_shape;
						$detail_data['gemstone_3_shape']	= $gemstone_3_shape;
						$detail_data['gemstone_4_shape']	= $gemstone_4_shape;
						$detail_data['gemstone_5_shape']	= $gemstone_5_shape;
						$detail_data['gemstone_1_setting_type']= $gemstone_1_setting_type;
						$detail_data['gemstone_2_setting_type']= $gemstone_2_setting_type;
						$detail_data['gemstone_3_setting_type']= $gemstone_3_setting_type;
						$detail_data['gemstone_4_setting_type']= $gemstone_4_setting_type;
						$detail_data['gemstone_5_setting_type']= $gemstone_5_setting_type;
						$detail_data['gemstone_1_weight']	= $gemstone_1_weight;
						$detail_data['gemstone_2_weight']	= $gemstone_2_weight;
						$detail_data['gemstone_3_weight']	= $gemstone_3_weight;
						$detail_data['gemstone_4_weight']	= $gemstone_4_weight;
						$detail_data['gemstone_5_weight']	= $gemstone_5_weight;
						
						$detail_id = $this->erpmodel->AddNewRow('erp_order_details', $detail_data);
												
						$trn_data['order_id'] 			= $this->input->post('order_id');
						$trn_data['order_product_id'] 	= $last_insert_id;
						$trn_data['order_status_id'] 	= 3;
						$trn_data['notes'] 				= $this->input->post('notes');
						$trn_data['website_id'] 		= 1;
						$trn_data['updated_by'] 		= $_username;
						$trn_data['updated_date'] 		= date('Y-m-d H:i:s');
						
						$trn_id = $this->erpmodel->AddNewRow('trnorderprocessing', $trn_data);
					} else {
						$display['message'] = 'Error occured. Try again!';
					}
			
					if($detail_id && $trn_id) {
						redirect('erp_order/to_do_list');
					} 
				} 
				else {
					$display['message'] = 'Order Already exists!';
					$this->load->view('templates/header');
					$this->load->view('erp_order/create_marketplace_order',$display);
					$this->load->view('templates/footer');
				}
		}
	}
	
	public function add_finished()
	{
		 
		 
		 $erp_order_id 	= $this->input->get('erp_order_id');
		  $erp_product_id = $this->input->get('order_product_id');
		
	// $erp_item_id = $this->input->get('order_item_id');
         
		$data['selectdata'] = $this->erpmodel->get_order_details($erp_order_id,$erp_product_id);
		
// echo '<pre>' ;
// print_r($data);		
// echo '</pre>' ;	
// exit ;	
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/add_finished',$data);
		$this->load->view('templates/footer');
	}
		
	
}
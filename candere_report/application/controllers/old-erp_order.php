<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Erp_Order extends Auth_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		$this->db->cache_delete_all();
		set_time_limit(0);
		$this->load->model('erpmodel');
	}
	
	public function index()
	{
		$data['selectdata'] = $this->erpmodel->order_details();
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/index',$data);	
		$this->load->view('templates/footer');		
	}
	
	
	public function order_save()
	{
		$_username 	= @$this->session->userdata('_username');
		//echo '<pre>'; print_r($this->input->post()); exit;
				
		$row_data['OrderID'] 		= $this->input->post('OrderID');
		$row_data['OrderProductID'] = $this->input->post('OrderProductID');
		$row_data['OrderStatusID'] 	= $this->input->post('OrderStatusID');
		$row_data['vendorID'] 		= $this->input->post('VendorID');
		$row_data['notes'] 			= $this->input->post('notes');
		$row_data['GreetingCardId'] = $this->input->post('GreetingCardId');
		$row_data['WebsiteID'] 		= 11;
		$row_data['updatedby'] 		= $_username;
		$row_data['updatedDate'] 	= date('Y-m-d H:i:s');
				
		$lastinsertedid = $this->erpmodel->AddNewRow('trnOrderProcessing', $row_data);
					
		$data['msg']="Order updated successfully";
		
		redirect('erp_order');
					
	}
	
	public function addfinishedproductdetails()
	{ 
		$erp_order_id = $this->input->get('erp_order_id');
		$erp_product_id = $this->input->get('erp_product_id');
 
		$data['selectdata'] = $this->erpmodel->get_order_details($erp_order_id,$erp_product_id);
		
		$this->load->view('templates/header');
		$this->load->view('erp_order/add_finished_product_details',$data);	
		$this->load->view('templates/footer');		
	}
	
	public function saveproductdetails()
	{
		
		$row_data['order_id'] 				= $this->input->post('order_id');
		$row_data['order_product_id'] 		= $this->input->post('order_product_id');
		 
		$row_data['metal_id'] 				= $this->input->post('metal_id');
		$row_data['metal_purity_id'] 		= $this->input->post('metal_purity_id');
		$row_data['metal_weight'] 			= $this->input->post('metal_weight');
		$row_data['total_diamond_count'] 	= $this->input->post('total_diamond_count');
		$row_data['total_gemstone_count'] 	= $this->input->post('total_gemstone_count');
		$row_data['diamond_1_count'] 		= $this->input->post('diamond_1_count');
		$row_data['diamond_1_weight'] 		= $this->input->post('diamond_1_weight');
		$row_data['diamond_1_clarity'] 		= $this->input->post('diamond_1_clarity');
		$row_data['diamond_1_color'] 		= $this->input->post('diamond_1_color');
		$row_data['diamond_2_count'] 		= $this->input->post('diamond_2_count');
		$row_data['diamond_2_weight'] 		= $this->input->post('diamond_2_weight');
		$row_data['diamond_2_clarity'] 		= $this->input->post('diamond_2_clarity');
		$row_data['diamond_2_color'] 		= $this->input->post('diamond_2_color');
		$row_data['diamond_3_count'] 		= $this->input->post('diamond_3_count');
		$row_data['diamond_3_weight'] 		= $this->input->post('diamond_3_weight');
		$row_data['diamond_3_clarity'] 		= $this->input->post('diamond_3_clarity');
		$row_data['diamond_3_color'] 		= $this->input->post('diamond_3_color');
		$row_data['diamond_4_count'] 		= $this->input->post('diamond_4_count');
		$row_data['diamond_4_weight'] 		= $this->input->post('diamond_4_weight');
		$row_data['diamond_4_clarity'] 		= $this->input->post('diamond_4_clarity');
		$row_data['diamond_4_color'] 		= $this->input->post('diamond_4_color');
		$row_data['diamond_5_count'] 		= $this->input->post('diamond_5_count');
		$row_data['diamond_5_weight'] 		= $this->input->post('diamond_5_weight');
		$row_data['diamond_5_clarity'] 		= $this->input->post('diamond_5_clarity');
		$row_data['diamond_5_color'] 		= $this->input->post('diamond_5_color');
		$row_data['diamond_6_count'] 		= $this->input->post('diamond_6_count');
		$row_data['diamond_6_weight'] 		= $this->input->post('diamond_6_weight');
		$row_data['diamond_6_clarity'] 		= $this->input->post('diamond_6_clarity');
		$row_data['diamond_6_color'] 		= $this->input->post('diamond_6_color');
		$row_data['diamond_7_count'] 		= $this->input->post('diamond_7_count');
		$row_data['diamond_7_weight'] 		= $this->input->post('diamond_7_weight');
		$row_data['diamond_7_clarity'] 		= $this->input->post('diamond_7_clarity');
		$row_data['diamond_7_color'] 		= $this->input->post('diamond_7_color');
		$row_data['gemstone_1_name'] 		= $this->input->post('gemstone_1_name');
		$row_data['gemstone_1_color'] 		= $this->input->post('gemstone_1_color');
		$row_data['gemstone_1_count'] 		= $this->input->post('gemstone_1_count');
		$row_data['gemstone_1_weight'] 		= $this->input->post('gemstone_1_weight');
		$row_data['gemstone_2_name'] 		= $this->input->post('gemstone_2_name');
		$row_data['gemstone_2_color'] 		= $this->input->post('gemstone_2_color');
		$row_data['gemstone_2_count'] 		= $this->input->post('gemstone_2_count');
		$row_data['gemstone_2_weight'] 		= $this->input->post('gemstone_2_weight');
		$row_data['gemstone_3_name'] 		= $this->input->post('gemstone_3_name');
		$row_data['gemstone_3_color'] 		= $this->input->post('gemstone_3_color');
		$row_data['gemstone_3_count'] 		= $this->input->post('gemstone_3_count');
		$row_data['gemstone_3_weight'] 		= $this->input->post('gemstone_3_weight');
		$row_data['gemstone_4_name'] 		= $this->input->post('gemstone_4_name');
		$row_data['gemstone_4_color'] 		= $this->input->post('gemstone_4_color');
		$row_data['gemstone_4_count'] 		= $this->input->post('gemstone_4_count');
		$row_data['gemstone_4_weight'] 		= $this->input->post('gemstone_4_weight');
		$row_data['gemstone_5_name'] 		= $this->input->post('gemstone_5_name');
		$row_data['gemstone_5_color'] 		= $this->input->post('gemstone_5_color');
		$row_data['gemstone_5_count'] 		= $this->input->post('gemstone_5_count');
		$row_data['gemstone_5_weight'] 		= $this->input->post('gemstone_5_weight');
 
		$query = $this->db->select("id")
              ->from('trnfinishedproduct') 
              ->where('order_id', $this->input->post('order_id'))
              ->where('order_product_id', $this->input->post('order_product_id'))  
              ->get();
		$order_data = $query->row();
		
		if(isset($order_data->id)){  
			$key['id']= $order_data->id; 
			$this->erpmodel->UpdateRow('trnfinishedproduct', $row_data,$key); 
		}else{ 
			$this->erpmodel->AddNewRow('trnfinishedproduct', $row_data); 
		}
		redirect('erp_order');
	}
		
}
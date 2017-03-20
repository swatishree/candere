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
		$config['page_query_string'] = false;
		
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				
		$start = ($start !== 0) ? (int)$start : 1;
		$start = (($start - 1) * $limit); 
						
		$message_arr = array('');
		
		$message_arr['limit'] = $limit;
		$message_arr['start'] = $start;
		
		$this->load->view('templates/header'); 
        $this->load->view("display_invoices/index",$message_arr);
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
		
		$data['invoice_date'] 	=  date('j/m/Y',$result->invoice_date);
		
		$this->load->view('templates/header'); 
        $this->load->view("display_invoices/update_invoice_num",$data);
		$this->load->view('templates/footer');
	}
	
	public function save_invoice_num()
	{
		$increment_id 		  = $this->input->post('increment_id');
		$invoice_num 		  = $this->input->post('invoice_num');
		$previous_invoice_num = $this->input->post('previous_invoice_num');
		$candere_invoice_id	  = $this->input->post('id');
						
		//$invoice_date 		= strtotime($this->input->post('invoice_date'));
		
		$invoice_date 		= strtotime(date("d-m-Y", strtotime($this->input->post('invoice_date'))));
		
		if($invoice_date == 0){
			$invoice_date = time();	
		}
		
		
		$query = $this->db->select("entity_id")
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
	
	public function delete_invoice()
	{
		$data['id'] 			= $this->input->get('id');
		
		$this->db->delete('candere_invoice', $data);
		
		redirect('display_invoices');
		
	}

 
	 
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
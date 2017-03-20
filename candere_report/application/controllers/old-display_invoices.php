<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Display_invoices extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->db->cache_delete_all();
		$this->load->library("pagination");
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		
		$recordsCount = $this->db->count_all('candere_invoice');
		
		$config['base_url'] 	= base_url()."index.php/display_invoices/index";
		$config['total_rows'] 	= $recordsCount;
		$config['per_page'] 	= 30;
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
	 
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
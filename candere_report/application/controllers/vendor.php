<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends Auth_Controller {

	var $dbtable="mstVendor";
	
	public function __construct()
    {		
		parent::__construct();
		// Your own constructor code
		$this->load->helper(array('form', 'url', 'date','html'));
		$this->load->library('table');
		$this->load->library('session');
		$this->load->model('ErpModel', '', TRUE);		

    }

	public function index()
	{
		$RecordsCount=$this->ErpModel->CountRecords($this->dbtable);
		
		// pagination code
		$this->load->library('pagination');
		$config['base_url'] = base_url()."/vendor/index";
		
		$config['total_rows'] = $RecordsCount;
		$config['per_page'] = 10; 
		$config['uri_segment'] = 3;
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
		$this->pagination->initialize($config);
		
		$limit = $config['per_page'];		
		$start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$orderby = "vendor_id ASC";

		$data['RowsSelected']=$this->ErpModel->GetSelectedRows($this->dbtable,$limit, $start,'', $orderby,'');
				
		$this->load->view('templates/header');
		$this->load->view('vendor/vendor_list',$data);
		$this->load->view('templates/footer');	
	}
	
	public function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline" style="color:red">', '</span>');
				
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{	
			$this->load->view('templates/header');
			$this->load->view('vendor/vendor_new');
			$this->load->view('templates/footer');	
		}
		else
		{
			$row_data['vendor_name'] 	= $this->input->post('vendor_name');
			$row_data['active'] 		= $this->input->post('active');
			$row_data['created_by'] 		= '';
			$row_data['created_date'] 	= date('Y-m-d H:i:s');
			$row_data['modified_by'] 	= '';
			$row_data['modified_date'] 	= date('Y-m-d H:i:s');
			
			
			$lastinsertedid = $this->ErpModel->AddNewRow($this->dbtable, $row_data);
						
			$data['msg']="Vendor created successfully";
					
			$this->load->view('templates/header');			
			$this->load->view('vendor/vendor_new',$data);
			$this->load->view('templates/footer');	
		}
	}
	
	public function view($id='')
	{
		$key['vendor_id'] = $id;
		
		$data['RowInfo']=$this->ErpModel->GetInfoRow($this->dbtable,$key);
		if(sizeof($data['RowInfo']) == 0)
		{
			show_404();exit;
		}
		
		
		$this->load->view('templates/header');
		$this->load->view('vendor/vendor_view',$data);
		$this->load->view('templates/footer');	
	}
	
	public function vendor_update($id='')
	{
		if(empty($id))
		{
			show_404();
		}
		$key['vendor_id'] = $id;
		
		$data['RowInfo'] = $this->ErpModel->GetInfoRow($this->dbtable,$key);
			
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span>');
		
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|xss_clean');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('vendor/vendor_update',$data);
			$this->load->view('templates/footer');	
		}
		else
		{			
			$row_data['vendor_name'] 	= $this->input->post('vendor_name');
			$row_data['active']			= $this->input->post('active'); 
			$row_data['modified_by'] 	= '';
			$row_data['modified_date'] 	= date('Y-m-d H:i:s');
	
			$key['vendor_id'] = $id;
									
			$this->ErpModel->UpdateRow($this->dbtable, $row_data, $key);
									
			$data['msg']="Vendor details updated successfully";
				
			$this->load->view('templates/header');			
			$this->load->view('vendor/vendor_update',$data);
			$this->load->view('templates/footer');		
		}		
	}
	
	public function delete($id='')
	{
		if(empty($id))
		{
			show_404();exit;
		}
		$key['vendor_id'] = $id;

		$data['RowInfo']=$this->ErpModel->DeleteRow($this->dbtable,$key);
		
		$data['msg']="Vendor details deleted successfully";
				
		redirect('vendor');
	}

}


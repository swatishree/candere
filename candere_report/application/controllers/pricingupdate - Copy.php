<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pricingupdate extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('pricingupdate_model');
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		 
		$data = array();
		$this->load->library('upload'); 
		$this->load->library('form_validation');
		$this->load->library('session');
		 
		$data['message'] = '';
		
		if (isset($_POST['submit']))
        { 
			 
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = 'csv|xls|xlsx';
 
            $this->upload->initialize($config);
			$messages  = '';
            foreach($_FILES as $field => $file)
            {
                // No problems with the file
                if($file['error'] == 0)
                {
                    // So lets upload
                    if ($this->upload->do_upload($field))
                    {
                        $upload_data = $this->upload->data();  
						
						$db_data = array(
							'filename' => $upload_data['file_name'],
							'created_at' => date('Y-m-d 00:00:00',time()),
							'updated_at' => date('Y-m-d 00:00:00',time()),
						); 
						
						$this->db->insert('pricingupdate',$db_data); 
						
						$this->insertpricing($upload_data); 
						
						$data['message'] = 'File Uploaded successfully';
                    }
                    else
                    {
                        $errors = $this->upload->display_errors(); 
						$data['message'] = 'Error while file Uploading';
                    }
                }
            }
			 
        }
		 
		$this->load->view('templates/header'); 
        $this->load->view("pricingupdate/index",$data);
		$this->load->view('templates/footer');
	}
	
	public function insertpricing($upload_data){	 
		$full_path = $upload_data['full_path'] ;
		
		$this->db->query("TRUNCATE priceupdate");
		
		$sql = "LOAD DATA INFILE '{$full_path}'
			INTO TABLE priceupdate 
			FIELDS TERMINATED BY ','
			ESCAPED BY '\\'
			ENCLOSED BY '\"'
			LINES TERMINATED BY '\r\n'
			(sku,18k,14k,9k,metal)"; 
			
		$sql =	"LOAD DATA INFILE '{$full_path}' INTO TABLE priceupdate FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (sku,18k,14k,9k,metal)";

		$this->db->query($sql); 
		
		   
		echo '<pre>';
			print_r($sql);
			print_r($full_path);
		echo '</pre>';
		
	}	

	public function view($slug)
	{
		$data['news'] = $this->news_model->get_news($slug);
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
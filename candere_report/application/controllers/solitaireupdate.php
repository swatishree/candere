<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Solitaireupdate extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->model('solitaireupdate_model');
	}

	public function index()
	{
		//$data['content'] = $this->news_model->get_news(); 
		 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
                $this->load->view("solitaireupdate/index",$message_arr);
		$this->load->view('templates/footer');
	}
	       
        public function submit()
	{ 
		$message_arr = array('');
		$this->load->library('upload'); 
		$this->load->library('form_validation');
		$this->load->library('session');
		  
		if (isset($_POST['submit']))
		{ 

			$config['upload_path'] = "./uploads/solitaire";
			$config['allowed_types'] = '*';

			//$config['overwrite'] = TRUE;
			//$this->load->library('upload', $config);
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
						
						$message_arr = $this->insertsolitaire($upload_data);  
						$this->session->set_flashdata('message_arr', $message_arr);
						$data['message'] = 'File Uploaded successfully';
					}
					else
					{
						$error = $this->upload->display_errors();  
						$data['message'] = 'Error while file Uploading';
						//$message_arr[] = 'Error while file Uploading';
						$this->session->set_flashdata('message_arr', $data);						
					}
				}
			}

		} 
		
		$this->load->helper('url');
		redirect('/solitaireupdate/index');
	}
	
	
	public function insertsolitaire($upload_data){	 
		$full_path = $upload_data['full_path'] ;
		
               
		$this->db->query("TRUNCATE solitaires");  
		 
		$sql =	"LOAD DATA LOCAL INFILE '{$full_path}' INTO TABLE solitaires FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (id,report_no,packet_no,shape,dna,weight,color,clarity,cut,polish,symmetry,fls,lab,measurements,depth_percent,table_percent,disc_percent,rap,cost_price,rate_cts,net_value,comment_1,comment_2,crown_angle,crown_height,pav_angle,pav_height,key_to_symbols,girdle,culet,star_length,lower_half,girdle_percent)"; 

		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA Imported : '.$this->db->affected_rows() .'</b><br/>';
		  
		/****************************************************/
		
		$sql =	"UPDATE solitaires SET polish='Excellent' where polish='EX'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET polish='Very Good' where polish='VG'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET polish='Good' where polish='GD'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET polish='Fair' where polish='FR'";
		$this->db->query($sql);  

		/****************************************************/	

		$sql =	"UPDATE solitaires SET symmetry='Excellent' where symmetry='EX'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET symmetry='Very Good' where symmetry='VG'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET symmetry='Good' where symmetry='GD'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET symmetry='Fair' where symmetry='FR'";
		$this->db->query($sql);  

		/****************************************************/

		$sql =	"UPDATE solitaires SET cut='Excellent' where cut='EX'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET cut='Very Good' where cut='VG'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET cut='Good' where cut='GD'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET cut='Fair' where cut='FR'";
		$this->db->query($sql);  	
		
		$sql =	"UPDATE solitaires SET cut='Ideal' where cut='ID'";
		$this->db->query($sql);
		
		/****************************************************/
		
		
		$sql =	"UPDATE solitaires SET fls='None' where fls='NON'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET fls='Strong' where fls='STG'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET fls='Faint' where fls='FNT'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET fls='Medium' where fls='MED'";
		$this->db->query($sql);  	
		
		$sql =	"UPDATE solitaires SET fls='Very Strong' where fls='VST'";
		$this->db->query($sql);
		
		/****************************************************/
		
		$sql =	"UPDATE solitaires SET girdle='Medium' where girdle='MED'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Strongly Thick' where girdle='MED TO STK'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET girdle='Thin / Thick' where girdle='THN TO THK'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET girdle='Thick / Very Thick' where girdle='THK TO VTK'";
		$this->db->query($sql);  	
		
		$sql =	"UPDATE solitaires SET girdle='Thick / Thick' where girdle='STK TO THK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Slightly / Thick' where girdle='STK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Thick' where girdle='THK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Very Thick' where girdle='MED TO VTK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Thick' where girdle='MED TO THK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Thin / Slightly Thick' where girdle='THN TO STK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Thin / Medium' where girdle='THN TO MED'";
		$this->db->query($sql);  
		
		$sql =	"UPDATE solitaires SET girdle='Very Thick' where girdle='VTK'";
		$this->db->query($sql);  
 		
		$sql =	"UPDATE solitaires SET girdle='Slightly Thick / Very Thick' where girdle='STK TO VTK'";
		$this->db->query($sql);   
		  
		$sql =	"UPDATE solitaires SET girdle='Thin / Very Thick' where girdle='THN TO VTK'";
		$this->db->query($sql);  	
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Slightly Thick' where girdle='MED TO SL THK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Extremely Thin / Thick' where girdle='ETN TO THK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Extremely Thick' where girdle='MED TO ETK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Very Thick / Extremely Thick' where girdle='VTK TO ETK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Very Thin / Very Thick' where girdle='VTN TO VTK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Thin / Extremely Thick' where girdle='THN TO ETK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Extremely Thick' where girdle='ETK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Slightly Thick / Extremely Thick' where girdle='STK TO ETK'";
		$this->db->query($sql);
		
		
		$sql =	"UPDATE solitaires SET girdle='Thick / Extremely Thick' where girdle='THK TO ETK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Very Thin / Thick' where girdle='VTN TO THK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Very Thin' where girdle='VTN'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Medium / Slightly Thick' where girdle='Very Thick / Slightly Thick'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Extremely Thick / Very Thick' where girdle='ETN TO VTK'";
		$this->db->query($sql);
		
		$sql =	"UPDATE solitaires SET girdle='Very Thin / Medium' where girdle='VTN TO MED'";
		$this->db->query($sql);
		
		/****************************************************/
		
	 
		$sql =	"Update solitaires set selling_price = (convert(REPLACE(cost_price, ',', ''), unsigned) * 1.09 )";
		$this->db->query($sql);
		
		/****************************************************/
		
		$sql =	"UPDATE solitaires SET shape='CUSHION' where shape='CUSHION BRILLIANT'";
		$this->db->query($sql);
		
		
		
		/****************************************************/
		
		$sql =	"Delete from solitaires where shape='SHAPE' or shape='shape'";
		$this->db->query($sql);
		
		
		
		/****************************************************/
		
		$sql =	"Delete from solitaires where shape='' or report_no = ''";
		$this->db->query($sql);
		
		
		/****************************************************/
		  
		$this->db->trans_complete(); 	
		 
		return $message_arr;
		
		//redirect( 'pricingupdate/index' );	
	}	

	public function view($slug)
	{
		$data['news'] = $this->news_model->get_news($slug);
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
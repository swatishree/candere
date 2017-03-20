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
		 
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("pricingupdate/index",$message_arr);
		$this->load->view('templates/footer');
	}
	
	public function export_to_csv()
	{
		$sql =	"SELECT pricing_table_metal_options.id,pricing_table_metal_options.sku,
				   pricing_table_metal_options.product_id,
				   pricing_table_metal_options.price,
				   eav_attribute_option_value.value,
				   pricing_table_metal_options.purity
			  FROM    pricing_table_metal_options pricing_table_metal_options
				   INNER JOIN
					  eav_attribute_option_value eav_attribute_option_value
				   ON (pricing_table_metal_options.purity =
						  eav_attribute_option_value.option_id) where eav_attribute_option_value.value !='Metal Purity' order by purity,product_id desc"; 
			 
		$results = $this->db->query($sql); 
		$result = $results->result_array();
		$export_array = array(); 
		
		//22k 18k 14k 9k 
		
		if($result){
			foreach($result as $rslt){
				$export_array[strtolower($rslt['sku'])]['sku'] = $rslt['sku'];  
				 
				$export_array[strtolower($rslt['sku'])][strtolower($rslt['value'])] = $rslt['price']; 
				 
			}
		}
		
		$this->load->helper('csv');
		 
		$this->load->dbutil(); 
		 
		array_to_csv($export_array,'export_product_pricing_csv'.date('dMy').'.csv');  
		
		unset($export_array);
	}
	
	public function submit()
	{ 
		set_time_limit(0);
		$message_arr = array('');
		$this->load->library('upload'); 
		$this->load->library('form_validation');
		$this->load->library('session');
		  
		if (isset($_POST['submit']))
        { 
			 
            $password 		= trim($_POST['password']); 
  
			$price_update_password 	= trim(Mage::getStoreConfig('systemfieldsgroupsectioncode/systemfieldsgroupcode/price_update_password'));
 
			 
			if($password != $price_update_password){
				$message_arr[] = 'You are not authorised for this action';	
				$this->session->set_flashdata('message_arr', $message_arr);
				redirect('/pricingupdate/index');
			}	 
			
			$config['upload_path'] = "./uploads/";
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
						
						$db_data = array(
							'filename' => $upload_data['file_name'] 
						); 
						
						$this->db->insert('pricingupdate',$db_data); 
						
						$message_arr = $this->insertpricing($upload_data);  
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
		redirect('/pricingupdate/index');
	}
	
	
	public function insertpricing($upload_data){	 
		
		set_time_limit(0);
		
		$full_path = $upload_data['full_path'] ;
		
		$this->db->query("TRUNCATE priceupdate");  
		 
		$sql =	"LOAD DATA LOCAL INFILE '{$full_path}' INTO TABLE priceupdate FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (sku,22k,18k,14k,9k,metal,siij_price,sigh_price,vsgh_price,vvsef_price)"; 

		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA Imported : '.$this->db->affected_rows() .'</b><br/>';
		 
	 
		$this->db->trans_start(); 
		
		$sql =	"update priceupdate a, pricing_table_metal_options b set a.product_id=b.product_id WHERE a.sku=b.sku";
		$this->db->query($sql);  
			
		$sql =	"update pricing_table_metal_options a,  priceupdate b set price=22k where b.product_id=a.product_id and purity=589";
		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA purity=22k : '.$this->db->affected_rows() .' Updates</b><br/>';

		$sql =	"update pricing_table_metal_options a,  priceupdate b set price=18k where b.product_id=a.product_id and purity=50";
		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA purity=18k : '.$this->db->affected_rows() .' Updates</b><br/>';
		 
		$sql =	"update pricing_table_metal_options a,  priceupdate b set price=14k where b.product_id=a.product_id and purity=49";
		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA purity=14k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set price=9k where b.product_id=a.product_id and purity=51";
		$this->db->query($sql); 
		
		$message_arr[] = '<b>DATA purity=9k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		/********************************************************************************************/
		/***************22k***************/
		 
		$sql =	"update pricing_table_metal_options a,  priceupdate b set siij_price=siij_price_22 where b.product_id=a.product_id and purity=589";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA siij_price purity=22k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set sigh_price=sigh_price_22 where b.product_id=a.product_id and purity=589";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA sigh_price purity=22k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vsgh_price=vsgh_price_22 where b.product_id=a.product_id and purity=589";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vsgh_price purity=22k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vvsef_price=vvsef_price_22 where b.product_id=a.product_id and purity=589";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vvsef_price purity=22k : '.$this->db->affected_rows() .' Updates</b><br/>';
		 
		 
		 /***************18k***************/
		 
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set siij_price=siij_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA siij_price purity=18k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set sigh_price=sigh_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA sigh_price purity=18k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vsgh_price=vsgh_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vsgh_price purity=18k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vvsef_price=vvsef_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vvsef_price purity=18k : '.$this->db->affected_rows() .' Updates</b><br/>';
		 
		 
		  /***************14k***************/
		 
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set siij_price=siij_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA siij_price purity=9k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set sigh_price=sigh_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA sigh_price purity=9k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vsgh_price=vsgh_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vsgh_price purity=9k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		$sql =	"update pricing_table_metal_options a,  priceupdate b set vvsef_price=vvsef_price_22 where b.product_id=a.product_id and purity=49";
		$this->db->query($sql);  
		$message_arr[] = '<b>DATA vvsef_price purity=9k : '.$this->db->affected_rows() .' Updates</b><br/>';
		
		/********************************************************************************************/
		 
		$sql =	"update  `catalog_product_entity_decimal` a,  pricing_table_metal_options b,  `metal_options_enabled` c set a.value = b.price  where a.entity_id = b.product_id and b.isdefault=1 and b.metal_id= c.metal_id and b.product_id = c.product_id and c.isdefault=1 and a.attribute_id = 75 ";
		$this->db->query($sql); 
		
		$message_arr[] = '<b>Setting Default Price : '.$this->db->affected_rows() .' Updates</b><br/>';
		
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
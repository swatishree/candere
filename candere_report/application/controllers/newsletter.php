<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();  
		
		$this->load->library('email'); 
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('session');				
	}
	
	public function index()
	{
		$message_arr = array('');
		
		$this->db->cache_delete_all();  
		$this->load->view('templates/header');
		$this->load->view('newsletter/newsletter');
		$this->load->view('templates/footer');
	}

	public function email_send()
	{	
		$this->db->cache_delete_all();
		$this->form_validation->set_rules('sender_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('sender_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		
		if($this->form_validation->run() == FALSE){
			$message_arr[] = 'Please Enter all the required fields'; 
		}else{
			$sender_name 	= $this->input->post('sender_name');
			$sender_email 	= $this->input->post('sender_email');
			$email 			= $this->input->post('email');
			$message		= $this->input->post('message');
			$subject		= $this->input->post('subject');
			
			$email_list = explode(",",$email);
			
			 $config = array( 
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			$this->load->library('email', $config);
			
			$config = array(
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			foreach($email_list as $key => $emails)
			{
				$this->email->initialize($config);
				$this->email->from($sender_email, $sender_name);
				$this->email->to($emails);
				$this->email->subject($subject);
				$this->email->message($message);
				if($this->email->send())
				{   
					$message_arr[] = 'Email Sent to '.$emails; 
					$this->session->set_flashdata('message_arr', $message_arr);
				}
			   else
			   { 
					$message_arr[] = 'Unable to send email to '.$emails; 
					$this->session->set_flashdata('message_arr', $message_arr);
			   }
			}
		} 
		
		$this->session->set_flashdata('message_arr', $message_arr);
		redirect('/newsletter/index');
	}
	
	public function export()
	{
		$message_arr = array('');
		$this->load->helper('csv');
		
		$sql = $this->db->query("SELECT if(a.customer_id=0,'Guest','Customer') as customer, a.subscriber_email, a.subscription_date, b.value as first_name, c.value as last_name, d.value as city, e.value as country, f.value as state, g.value as postcode,
		if(h.value=1,'Male','Female') as gender
		FROM newsletter_subscriber a 
			Left JOIN customer_entity_varchar b 
			on (a.customer_id = b.entity_id and b.attribute_id = 5)
			Left Join customer_entity_varchar c
			on (a.customer_id = c.entity_id and c.attribute_id = 7)
			Left Join customer_address_entity_varchar d
			on (a.customer_id = d.entity_id and d.attribute_id = 26)
			Left Join customer_address_entity_varchar e
			on (a.customer_id = e.entity_id and e.attribute_id = 27)
			Left Join customer_address_entity_varchar f
			on (a.customer_id = f.entity_id and f.attribute_id = 28)
			Left Join customer_address_entity_varchar g
			on (a.customer_id = g.entity_id and g.attribute_id = 30)
			Left Join customer_entity_int h
			on (a.customer_id = h.entity_id and h.attribute_id = 18)");
		
		$result = $sql->result_array();
		
		//echo '<pre>'; print_r($result); exit;
		
		array_unshift($result, array(
										'customer' => 'customer',
										'subscriber_email' => 'subscriber_email',
										'subscription_date' => 'subscription_date',
										'first_name' => 'first_name',
										'last_name' => 'last_name',
										'city' => 'city',
										'country' => 'country',
										'state' => 'state',
										'postcode' => 'postcode',
										'gender' => 'gender'
									));
		
		$this->load->dbutil();
		
		array_to_csv($result,'newsletter_subscribers'.date('d-M-y').'.csv');
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
			if (!file_exists('csvtemp')) {
				mkdir('csvtemp', 0777, true);
			}
            $config['upload_path'] = "./csvtemp/";
			$config['allowed_types'] = '*';
			 
            $this->upload->initialize($config);
			$messages  = '';
			$file_flage = false;
			
            foreach($_FILES as $field => $file)
            {
                if($file['error'] == 0)
                {
                    if ($this->upload->do_upload($field))
                    {
						$upload_data = $this->upload->data();  
						
						$db_data = array(
							'filename' => $upload_data['file_name'] 
						); 
						
						$filename = $upload_data['file_path'].$upload_data['file_name']; 
						
						if (($handle = fopen($filename, "r")) !== FALSE) {
							
							if(($csvheader = fgetcsv($handle, 1000, ",")) !== FALSE) {
							
								$num = count($csvheader);
								
								if( ($csvheader[0]!='') && ($num==1) && (!empty($csvheader[0])) && ($csvheader[0]=='subscriber_email'))
								{	
									$file_flage = true;
								}
								else 
								{
									$file_flage = false;
								}
							}
						}
						
						fclose($handle);
						
						if($file_flage)
						{
							$message_arr = $this->updatenewsletter($upload_data);  
							$data['message'] = 'File Uploaded successfully';
							$this->session->set_flashdata('message_arr', $message_arr);
						}
						else 
						{
							$error = $this->upload->display_errors();
							$data['message'] = 'Error while file Uploading';
							$this->session->set_flashdata('message_arr', $data);						
						}
                    }
                } 
				unlink($filename);
            }
        } 
		
		$this->load->helper('url');
		redirect('/newsletter/');
	
	}
	
	public function updatenewsletter($upload_data)
	{	
		set_time_limit(0);
		
		$newsletter_update 		= Mage::getSingleton('core/resource')->getTableName('newsletter_update');
		$newsletter_subscriber 	= Mage::getSingleton('core/resource')->getTableName('newsletter_subscriber');
		$customer_entity 		= Mage::getSingleton('core/resource')->getTableName('customer_entity');

		$full_path = $upload_data['full_path'] ;
		
		//$this->db->query("TRUNCATE $newsletter_update"); 
		 
		$sql =	"LOAD DATA LOCAL INFILE '{$full_path}' INTO TABLE $newsletter_update FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (subscriber_email)";
		$this->db->query($sql);
		
		$message_arr[] = '<b>DATA Imported : '.$this->db->affected_rows() .'</b><br/>';
		
		$dup_remov_sql = $this->db->query("DELETE FROM $newsletter_update WHERE id IN 
						(SELECT * FROM 
							(SELECT id FROM $newsletter_update
								GROUP BY subscriber_email HAVING (COUNT(*) > 1)
							) AS A
						)");
		
		$this->db->trans_start();
		
		
		$sub_email = $this->db->query("select a.subscriber_email from $newsletter_update a where a.subscriber_email NOT IN (select b.email from $customer_entity b)");
		$sub_email_data = $sub_email->result_array();
		
		
		if($sub_email_data) 
		{	
			foreach($sub_email_data as $row)
			{
				$subscriber_email = trim($row['subscriber_email']);
				
				$exist_email = $this->db->query("select subscriber_email from $newsletter_subscriber where subscriber_email = '$subscriber_email' ");
				$exist_email_data = $exist_email->result_array();
				
				$update_date = date("Y-m-d H:i:s");
				
				if(empty($exist_email_data)) 
				{
					$data = array(
								'store_id'					=> 1,
								'change_status_at'			=> $update_date,
								'customer_id'				=> 0,
								'subscriber_email'			=> $subscriber_email,
								'subscriber_status'			=> 1,
								'subscriber_confirm_code'	=> null,
								'subscription_date'			=> $update_date
							);
							
					$chk_exist = $this->db->query("select subscriber_email from $newsletter_subscriber where subscriber_email= '$subscriber_email' ");
										
					$chk_exist_data = $chk_exist->result_array();
					
					if(empty($chk_exist_data))
					{
						$insert_id = $this->db->insert($newsletter_subscriber, $data);
					}
				}
			}
			$message_arr[] = '<b>Total '.$count.' Users Added </b><br/>';
		}
		
		
		$news_email = $this->db->query("select a.subscriber_email, b.entity_id from $newsletter_update a inner join $customer_entity b on a.subscriber_email = b.email");
		$news_email_data = $news_email->result_array();
		
		
		if(!empty($news_email_data) )
		{
			foreach($news_email_data as $row)
			{
				$subscriber_email 		= $row['subscriber_email'];
				$entity_id 				= $row['entity_id'];
				
				$data = array(
							   'store_id' 					=> 1,
							   'change_status_at' 			=> date('Y-m-d H:i:s'),
							   'customer_id' 				=> $entity_id,
							   'subscriber_email' 			=> $subscriber_email,
							   'subscriber_status' 			=> 1,
							   'subscriber_confirm_code' 	=> null,
							   'subscription_date'			=> date('Y-m-d H:i:s')
							);
					
				$exist_email = $this->db->query("select subscriber_email from $newsletter_subscriber where subscriber_email = '$subscriber_email' ");			
				$exist_email_data = $exist_email->result_array();
				
				if(empty($exist_email_data))
				{
					$this->db->insert($newsletter_subscriber,$data); 
				}			
			}
		}	
		
		
		$this->db->trans_complete();
		
		return $message_arr;
	}
} 
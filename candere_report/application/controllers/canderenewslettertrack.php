<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Canderenewslettertrack extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
	}
	 
	public function index()
	{  /*
		$message_arr = array(''); 
		
		$this->load->view('templates/header'); 
        $this->load->view("canderenewslettertrack/index",$message_arr);
		$this->load->view('templates/footer');
		*/
		if(isset($_GET['email_id'])){	
			$sql =	"INSERT INTO  `newsletter_report` (`id` , `email_id` ) VALUES ( NULL , '".trim($_GET['email_id'])."');";
		
			$this->db->query($sql); 
		}
		$im=imagecreatetruecolor(1,1);
		 $white=imagecolorallocate($im,255,255,255);
		 imagefilledrectangle($im,0,0,1,1,$white);
		 header("content-type: image/jpeg");
		 imagejpeg($im);
	} 
	  
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
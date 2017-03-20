<?php
header( 'Content-Type: text/html; charset=utf-8' );
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Valentines_data extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct(); 
		
		$this->load->database();
	}
	 
	public function index()
	{
		
		$sql = "select email,message,phone,usename,created_date from fb_vc order by fb_id desc";
		$results = $this->db->query($sql); 
		if(count($results->result_array())>0){ 
			
			$data['data']= $results->result_array();
		}
				
		$this->load->view('templates/header'); 
        $this->load->view("valentines_data/index",$data);
		$this->load->view('templates/footer');
		
	} 
	
	
	
	
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
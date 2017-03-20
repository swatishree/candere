<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Valentines extends CI_Controller  {
	
	public function __construct()
	{
		parent::__construct();  
		
		$this->load->library('email'); 
		$this->load->helper('url');
		$this->load->library('session');				
	}

	public function index()
	{   
	
	
		$name=$this->input->post('name'); 
		$phone=$this->input->post('phone');
		$email=$this->input->post('email'); 
		$message=$this->input->post('message'); 
		if($_POST){
		$this->db->set('usename', $name); 
		$this->db->set('phone', $phone);
		$this->db->set('email', $email);
		$this->db->set('message', $message);
		$this->db->set('created_date', now());
		$this->db->insert('fb_vc'); 
		
		
		$this->db->cache_delete_all();
		
			
			
			$mgs.='<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-color: #C5C5C5;">';
			$mgs.='<tr>
			<td align="center"> 
				<table width="500" border="0" cellpadding="0" cellspacing="0" align="center">
				<tbody><tr>';
			$mgs.='<tr>
			<td align="center" valign="middle" style="padding:7px;" > 
				<p align=center style="text-align:center"><span style="color:#666666;font-size:20px;">Your entry has been recorded.</span></p>
			</td> 
		</tr>';
		
		$mgs.='<tr>
	    <td align="center" valign="middle" style="padding:7px;">
			<span style="font-size:34px; color:#820202;">Like our facebook page</span>
		</td>
		
		</tr>';
		
	
	$mgs.='<tr>
		<td align="center" valign="middle" style="padding:7px;">
			<strong><span style="font-size:25px;font-family:"Verdana","sans-serif";color:#820202;">
			<a href="https://www.facebook.com/canderejewellery" target="_blank"><img src="http://canderemail.com/newsletters/super_slash_october_fest_cont/facebook.jpg" alt="facebook" width="27" height="26" border="0"/></a>
			
			</span></strong>
		</td>
		</tr>';
	
	$mgs.='<tr>
		<td align="center" valign="middle" style="padding:7px;">
			<b><span style="font-size:34px;
			color:#820202;">
			To stay updated on results of the contest. 
			 </span></b>
		</td>
	</tr>';
	
	$mgs.='<tr>
		<td align="center" valign="middle" style="padding:7px;">
			<b><span style="font-size:34px;
			color:#820202;">
			Thanks for participating Happy Valentine’s Day. </span></b>
		</td>
		</tr>';
		
		$mgs.='</tbody>
				</table>
			</td>
		</tr>
	</table>';
			    			
				
			 $config = array( 
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			$this->load->library('email', $config);
			
			$config = array(
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);


				$this->email->initialize($config);
				$this->email->from('store-news@candere.com', 'Candere');
				$this->email->to($email);
				$this->email->subject("Candere Valentine's Contest");
				$this->email->message($mgs);
				$this->email->send();
			
			

if($_POST!=""){

		$name=$this->input->post('name'); 
		$phone=$this->input->post('phone');
		$email=$this->input->post('email'); 
		$message=$this->input->post('message');

$internal_mgs = <<<DEMO
			Name   : {$name}
			phone   : {$phone}
			Email  : {$email}
			Message  : {$message}
DEMO;


			
			 $config = array( 
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
			
			$this->load->library('email', $config);
			
			$config = array(
				'mailtype'  => 'html',
				'charset'   => 'utf-8'
			);
				$this->email->initialize($config);
				$this->email->from('store-news@candere.com', 'Candere');
				$this->email->to('canderej@gmail.com');
				$this->email->subject('Contest customer info');
				$this->email->message($internal_mgs);
				$this->email->send();
			
	
}

	
		
		
		}
		$this->load->view('templates/header'); 
        $this->load->view("valentines/index");
		$this->load->view('templates/footer');
		
		
	}

	 
	 
	 
	 
}

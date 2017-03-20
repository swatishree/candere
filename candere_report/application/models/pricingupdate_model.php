<?php
class Pricingupdate_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function insert($pricingupdate){	
		$this->db->insert('pricingupdate', $pricingupdate);	
	}	 
}
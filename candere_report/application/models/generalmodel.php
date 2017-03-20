<?php
class GeneralModel extends CI_Model {

    var $loc_settings;

	function __construct()
    {
        parent::__construct();
		$this->loc_settings['usertable'] = "user_signup";		
		$this->loc_settings['userfield'] = "username";		
		$this->loc_settings['passfield'] = "password";		
		$this->loc_settings['emailfield'] = "email";	
		
		$this->load->database();	
	}
		
	function UserLogin($email, $password)
	{		
		$this->db->where($this->loc_settings['emailfield'], $email);
		$this->db->where($this->loc_settings['passfield'], $password);

		$this->db->where('status', 'A');
	
		$query = $this->db->get($this->loc_settings['usertable']);
		#return $this->db->count_all_results();	
		//echo $this->db->last_query(); exit;
		return $query->result();
	}
	
		
}	

?>
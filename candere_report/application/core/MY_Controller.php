<?php
class Auth_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $logged_in_session = $this->session->userdata('logged_in');
		if(!$logged_in_session)
		{
			redirect(base_url());			
		}
    }
}

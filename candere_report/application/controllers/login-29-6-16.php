<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Login extends CI_Controller{
    
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'date','html'));
		$this->load->library('session');
		$this->load->model('GeneralModel','', TRUE);
		$this->load->model('erpmodel','', TRUE);
		$this->output->nocache();
	}

	function index_old()
	{  
		$this->load->view('login_form'); 
	}
	
	public function index()
	{
		$logged_in_session 	= $this->session->userdata('logged_in'); 
		
		if(empty($logged_in_session))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

			$this->form_validation->set_rules('email', 'Email id', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('templates/header');
				$this->load->view('login_form', array('login_failed' => false));
				$this->load->view('templates/footer');
			}
			else
			{	
				$email 		= 	trim($this->input->post('email'));
				$password 	= 	MD5($this->input->post('password'));
				$query 		= 	$this->GeneralModel->UserLogin($email,$password);
				$count 		= 	sizeof($query);
				
				if($count == 1)
				{	
					date_default_timezone_set("Asia/Kolkata");
					$data = array('last_logged_in'=>date("Y-m-d h:i:s"));
					$this->db->where('email',$email);
					$this->db->update('user_signup',$data);
					
					$query	= 	$this->GeneralModel->UserLogin($email,$password);
									
					$user_data = array(
							'_username'  	=> $query[0]->username,
							'_email'  		=> $query[0]->email,
							'_admin'  		=> $query[0]->admin,
							'last_logged_in'=> $query[0]->last_logged_in,
							'logged_in' 	=> TRUE,
							'order_status' 	=> $query[0]->order_status,
							'_allow_cancel' => $query[0]->allow_cancel,
							);	
										
					$this->session->set_userdata($user_data);		

					$this->_login_success();
				}
				else
				{
					$this->load->view('templates/header');
					$this->load->view('login_form', array('login_failed' => true));
					$this->load->view('templates/footer');
				}
			}
		}
		else
		{
			$this->_login_success();
		}
	}
	
	function logout()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->session->sess_destroy();
		redirect(base_url(''));			
	}
	
	private function _login_success()
	{
		$logged_in_session = $this->session->userdata('logged_in');
		
		if($logged_in_session == '1'){
			redirect(base_url('index.php').'/erp_order/to_do_list');	
		}else{
			$this->session->sess_destroy();
			echo "Unknown error occured, please re-login again";
		}
	}	

	public function register()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('isadmin', 'Admin', 'trim|required|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header');
			$this->load->view('register/index');
			$this->load->view('templates/footer');
		}
		else 
		{
			$username 	= $this->input->post('username');
			$password	= $this->input->post('password');
			$email 		= $this->input->post('email');
			$isadmin 	= $this->input->post('isadmin');
			$all_status = $this->input->post('order_status');
						
			foreach($all_status as $key=>$value) {
				$order_status .= $value.',';
			}
			
			$query = $this->db->get_where('user_signup', array('email' => $email));
			
			$count = $query->num_rows();
			if($count==0)
			{
				$data = array(
								'username' 	=> $username,
								'password' 	=> MD5($password),
								'email' 	=> $email,
								'admin' 	=> $isadmin,
								'order_status' 	=> rtrim($order_status,','),
								'status' 	=> 'A',
								'last_logged_in'=> date("Y-m-d h:i:s")
							);
				$this->db->insert('user_signup', $data);
				$display['message'] = 'Registered Successfully!';
				
				$this->load->view('templates/header');
				$this->load->view('register/index',$display);
				$this->load->view('templates/footer');
			}
			else
			{
				$display['message'] = 'Registration Failed!';
				$this->load->view('templates/header');
				$this->load->view('register/index',$display);
				$this->load->view('templates/footer');
			}
		}
	} 
	 
}
?>
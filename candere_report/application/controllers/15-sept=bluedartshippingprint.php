<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bluedartshippingprint extends CI_Controller { 
	function __construct(){
        parent::__construct(); 
		//$this->check_isvalidated();
		$this->db->cache_delete_all();
		$this->load->helper('url');
		$this->load->helper('number');		
    }
	
	 
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        } 
    }
	
	public function index() 
	{ 
		  
		$data = array('');  
		 		 
		$this->load->view('templates/header'); 
		 
		$sql =	"SELECT sales_flat_order_grid.entity_id AS order_id,
       sales_flat_order_grid.status,
       sales_flat_order_grid.customer_id,
       sales_flat_order_grid.total_paid,
       sales_flat_order_grid.grand_total,
       sales_flat_order_grid.increment_id AS order_increment_id,
       sales_flat_order_grid.created_at AS order_created_date,
       sales_flat_invoice_grid.state AS invoice_state,
       sales_flat_invoice_grid.created_at AS invoice_created_date,
       sales_flat_invoice_grid.increment_id AS invoice_increment_id,
       sales_flat_order_grid.shipping_name,
       sales_flat_order_grid.billing_name,
       sales_flat_order_item.name,
       sales_flat_order_item.product_id,
       sales_flat_order.state
  FROM    (   (   sales_flat_order_grid sales_flat_order_grid
               INNER JOIN
                  sales_flat_order sales_flat_order
               ON (sales_flat_order_grid.entity_id =
                      sales_flat_order.entity_id))
           INNER JOIN
              sales_flat_order_item sales_flat_order_item
           ON (sales_flat_order_item.order_id = sales_flat_order.entity_id))
       INNER JOIN
          sales_flat_invoice_grid sales_flat_invoice_grid
       ON     (sales_flat_invoice_grid.order_id =
                  sales_flat_order_item.order_id)
          AND (sales_flat_order_grid.entity_id =
                  sales_flat_invoice_grid.order_id)
 WHERE (sales_flat_order_grid.status NOT IN
          ('closed', 'complete', 'pending_payment', 'complete_shippment_confirmed', 'pending')) AND (sales_flat_order.state NOT IN
          ('canceled', 'closed', 'new', 'pending_payment'))
ORDER BY sales_flat_invoice_grid.order_id DESC"; 

		$results = $this->db->query($sql); 
		
		$data["results"] = $results->result_array();   
		 
        $this->load->view("bluedartshippingprint/index",$data);
		$this->load->view('templates/footer');
	}
	
	public function create_batch() 
	{ 
		  
		$data = array('');   
		 
		$batch_id 	 = $this->input->post('batch_id');  
		 
		$sql =	"SELECT Max(batch_id) as batch_id FROM bluedart_orders";  
		$results = $this->db->query($sql); 
		if($results->num_rows() != 0){  	  
			$row = $results->row_array();  
			$inc_batch_id = $row['batch_id'];	
			if($inc_batch_id == 0){
				$inc_batch_id = 1001;
			}else{
				$inc_batch_id = $inc_batch_id + 1;
			} 
		}else{
			$inc_batch_id = 1001;
		} 
			
			
		if($batch_id){
			foreach($batch_id as $o_id=>$order){
				 foreach($order as $product_id => $id){
				  
					$data = array(  
					   'batch_id' => $inc_batch_id 
					); 
					 
					$this->db->where('order_id', $o_id); 
					$this->db->where('product_id', $product_id); 
					$this->db->update('bluedart_orders', $data);  
					 
				}
			}			
		}
		 
        redirect('bluedartshippingprint/index'); 
	}
	 
	public function form() 
	{ 
		$order_id 	 = $this->input->get('order_id');  
		$product_id	 = $this->input->get('product_id');  
		$data  = array();
		
		$query = $this->db->get_where('bluedart_orders', array('order_id' => $order_id,'product_id' =>$product_id)); 
		 
		if($query->num_rows() > 0){ 
			$row = $query->row_array();
			$data['awb']  			= $row['awb'] ;
			$data['order_id']  		= $row['order_id'] ;
			$data['bluedart_pin']  	= $row['bluedart_pin'] ; 
			$data['product_price']	= $row['product_price'] ;  
			$data['invoice_no']  	= $row['invoice_no'] ;   
		}
		
		$query = $this->db->get_where('sales_flat_order_grid', array('entity_id' => $order_id));	   
		 
		if($query->num_rows() > 0){  
			$row = $query->row_array(); 
			$data['increment_id']  	= $row['increment_id'] ; 
		}
		 
		$this->bar_code($data['increment_id'],'150') ;
		$this->bar_code($data['awb'],'250') ; 
		
		$this->load->view('templates/header'); 
		$this->load->view("bluedartshippingprint/print",$data);
		$this->load->view('templates/footer');
	}
	 
	 
	 
	 
	public function bar_code($code,$width) 
	{ 
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		
		$barcodeOptions = array('text' => $barCodeNo, 'width'=> $width); 
		$rendererOptions = array('width'=> $width); 


		$img = Zend_Barcode::draw('code39', 'image', array('text' => $code),$barcodeOptions, $rendererOptions); 
		imagejpeg($img, 'uploads/barcode/'.$code.'.jpg');
	}
	
	public function update() 
	{ 
		$bluedart_pin 	 = $this->input->post('bluedart_pin');
		$order_id		 = $this->input->post('order_id');  
		$product_id		 = $this->input->post('product_id');  
		$price			 = $this->input->post('price');  
		  
		$query = $this->db->get_where('bluedart_orders', array('order_id' => $order_id,'product_id'=>$product_id));
		
		if($query->num_rows() == 0){ 
			 
		}else{ 
			$data = array(  
			   'bluedart_pin' => $bluedart_pin,
			   'product_price' => $price
			); 
			$this->db->where('order_id', $order_id); 
			$this->db->where('product_id', $product_id); 
			$this->db->update('bluedart_orders', $data); 
		}
		 
	}
	public function assignawb() 
	{ 
		$increment_id 	 = $this->input->post('increment_id');
		$order_id		 = $this->input->post('order_id');  
		$invoice_no		 = $this->input->post('invoice_no');  
		$post_code		 = $this->input->post('post_code');  
		$product_id		 = $this->input->post('product_id');  
		$awb			 = '';
		$bluedart_pin	 = '';
		$bluedart_pin_id = 0 ;  
		
		$query = $this->db->get_where('bluedart_orders', array('order_id' => $order_id,'product_id' => $product_id)); 
			
		if($query->num_rows() == 0){ 
		
			$sql =	"SELECT id,awb_no FROM bluedart_awb where is_used = '0' LIMIT 1"; 

			$results = $this->db->query($sql); 
			if($results->num_rows() != 0){  
				$row = $results->row_array();  
				$awb = $row['awb_no'] ; 
				$bluedart_pin_id = $row['id'] ; 
			}

			
			$sql =	"SELECT code FROM bluedart_pins where pin_code = $post_code LIMIT 1";  
			$results = $this->db->query($sql); 
			if($results->num_rows() != 0){  	  
				$row = $results->row_array();  
				$bluedart_pin = $row['code'] ; 
			} 
			
			$sql = "SELECT sales_flat_order_grid.customer_id,
       sales_flat_order_grid.shipping_name,
       sales_flat_order_grid.billing_name,
       sales_flat_order_grid.entity_id,
       sales_flat_order_item.name,
       sales_flat_order_item.product_id
  FROM    sales_flat_order_grid sales_flat_order_grid
       INNER JOIN
          sales_flat_order_item sales_flat_order_item
       ON (sales_flat_order_grid.entity_id = sales_flat_order_item.order_id)
 WHERE     (sales_flat_order_grid.entity_id = $order_id)
       AND (sales_flat_order_item.product_id = $product_id)";
			
			
			$results = $this->db->query($sql); 
			if($results->num_rows() != 0){   
				$row = $results->row_array();  
				$customer_id 	= $row['customer_id'];
				$customer_name 	= $row['shipping_name'];
				$product_name 	= $row['name']; 
				$product_id 	= $row['product_id']; 
			}
			
			$random_no = rand ( 2500 , 3500 ) ;
			
			$data = array(
			   'order_id' => $order_id ,
			   'awb' => $awb,
			   'invoice_no' => $invoice_no,
			   'customer_id' => $customer_id,
			   'customer_name' => $customer_name,
			   'product_name' => $product_name,
			   'product_id' => $product_id,
			   'product_price' => $random_no,
			   'bluedart_pin' => $bluedart_pin
			   
			); 
			$this->db->insert('bluedart_orders', $data); 
			 
			$sql =	"update bluedart_awb set is_used = '1' where id = $bluedart_pin_id LIMIT 1"; 

			$results = $this->db->query($sql);  
			 	
		}else{ 
			 $row = $query->row_array(); 
			 $awb = $row['awb'];
			 $bluedart_pin = $row['bluedart_pin'];	
		}
		  
		$data_return['awb'] 			= $awb ;
		$data_return['bluedart_pin'] 	= $bluedart_pin ;
		
		$this->bar_code($increment_id,'150') ;
		$this->bar_code($awb,'250') ; 
		
		
		echo json_encode($data_return);
	}
	
	public function exportmanifest() 
	{ 
		$data = array('');  
		
		$batch_id 	 = $this->input->get('batch_id'); 
		 		 
		$this->load->view('templates/header'); 
		 
		$sql =	"SELECT * from bluedart_orders where batch_id = $batch_id order by id asc"; 

		$results = $this->db->query($sql); 
		
		$data["results"] = $results->result_array();   
		$data["batch_id"] = $batch_id;   
		
		if(!empty($data["results"])){
			foreach($data["results"] as $value){
				$this->bar_code($value['awb'],'250') ;  
			}
		}	
		 
        $this->load->view("bluedartshippingprint/manifestprint",$data);
		$this->load->view('templates/footer');
	}
	
	public function emailexportsoftdata() 
	{ 
		$data = array('');  
		
		$batch_id 	 = $this->input->get('batch_id'); 
	 
		$sql =	"SELECT * from bluedart_orders where batch_id = $batch_id order by id asc"; 

		$results = $this->db->query($sql); 
		
		$results = $results->result_array();   	
		$data[0][0] = 'Airwaybill';
		$data[0][1] = 'Type';
		$data[0][2] = 'Reference Number';
		$data[0][3] = 'Sender / Store name';
		$data[0][4] = 'Attention';
		$data[0][5] = 'Address1';
		$data[0][6] = 'Address2';
		$data[0][7] = 'Address3';
		$data[0][8] = 'Pincode';
		$data[0][9] = 'Tel Number';
		$data[0][10] = 'Mobile Number';
		$data[0][11] = 'Prod/SKU code';
		$data[0][12] = 'Contents';
		$data[0][13] = 'Weight';
		$data[0][14] = 'Declared Value';
		$data[0][15] = 'Collectable Value';
		$data[0][16] = 'Vendor Code';
		$data[0][18] = 'Shipper Name';
		$data[0][19] = 'Return Address1';
		$data[0][20] = 'Return Address2';
		$data[0][21] = 'Return Address3';
		$data[0][22] = 'Return Pin';
		$data[0][23] = 'Length ( Cms )';
		$data[0][24] = 'Breadth ( Cms )';
		$data[0][25] = 'Height ( Cms )';
		$data[0][26] = 'Pieces';
		$data[0][27] = 'Area_customer_code';
		foreach($results as $key=>$rslt){
			$_order = Mage::getModel('sales/order')->load($rslt['order_id']);
			  
			$_shippingAddress = $_order->getShippingAddress();
			$first_name = $_shippingAddress->getFirstname() ;
			$last_name  = $_shippingAddress->getLastname() ;  
			$region 	= $_shippingAddress->getRegion() ;
			$city		= $_shippingAddress->getCity() ;
			$post_code	= $_shippingAddress->getPostcode();
			$telephone	= $_shippingAddress->getTelephone() ; 
			
			$data[($key + 1)][0] = $rslt['awb'];
			$data[($key + 1)][1] = 'NONCOD';
			$data[($key + 1)][2] = $_order->getIncrement_id();
			$data[($key + 1)][3] = 'Enovate Lifestyles P. Ltd';
			$data[($key + 1)][4] = $rslt['customer_name'];
			$data[($key + 1)][5] = $_shippingAddress->getStreet(1);
			$data[($key + 1)][6] = $_shippingAddress->getStreet(2);
			$data[($key + 1)][7] = $city.', '.$region;
			$data[($key + 1)][8] = $post_code;
			$data[($key + 1)][9] = $telephone;
			$data[($key + 1)][10] = $telephone;
			$data[($key + 1)][11] = 'NA';
			$data[($key + 1)][12] = 'Precious Jewellery';
			$data[($key + 1)][13] = '0.5';
			$data[($key + 1)][14] = '0';
			$data[($key + 1)][15] = '0';
			$data[($key + 1)][16] = '347314';
			$data[($key + 1)][18] = 'Enovate Lifestyles Private Limited';
			$data[($key + 1)][19] = '501-502, Om Shakti Samrat CHS Ltd.';
			$data[($key + 1)][20] = 'Plot No. 21,Shakti Nivas,Ramchandra Lane extn,Near Greater Bombay Co-op Bank,Kanchpada';
			$data[($key + 1)][21] = 'Mumbai, Maharashtra';
			$data[($key + 1)][22] = '400064';
			$data[($key + 1)][23] = '18';
			$data[($key + 1)][24] = '15';
			$data[($key + 1)][25] = '7.5';
			$data[($key + 1)][26] = 1;
			$data[($key + 1)][27] = $rslt['product_price']; 
		}
		 
		$this->load->helper('csv'); 
		
		$this->load->dbutil();
		$this->load->library('email');
		
		
		$strPath = 'uploads/bluedart_csv/';
		
		
		$_filename = 'bluedart_softcopy_'.date('d-M-Y').'_'.time().'.csv';
		
		$filename = fput_array_to_csv($data,$strPath,$_filename);

		$this->email->from('shashank.sharma@candere.com', 'Shashank Sharma');
		
	//$this->email->to('shashank.sharma@candere.com', 'Shashank Sharma'); 
		
		//$this->email->cc('ashish.bajaj@candere.com', 'Ashish Bajaj'); 
		$this->email->to('rupesh.jain@candere.com', 'Sandeep Shetane'); 
		
		$this->email->subject('BlueDart Soft Copy');
		
		$this->email->message('PFA');   
		
		$this->email->attach($strPath.$filename); // want to attach the csv file here 
		
		$this->email->send();
		 
		redirect(site_url('bluedartshippingprint/exportmanifest?batch_id='.$batch_id), 'refresh'); 
		 
	} 
	
	public function exportsoftdata() 
	{ 
		$data = array('');  
		
		$batch_id 	 = $this->input->get('batch_id'); 
		 
		$sql =	"SELECT * from bluedart_orders where batch_id = $batch_id order by id asc"; 

		$results = $this->db->query($sql); 
		
		$results = $results->result_array();   	
		$data[0][0] = 'Airwaybill';
		$data[0][1] = 'Type';
		$data[0][2] = 'Reference Number';
		$data[0][3] = 'Sender / Store name';
		$data[0][4] = 'Attention';
		$data[0][5] = 'Address1';
		$data[0][6] = 'Address2';
		$data[0][7] = 'Address3';
		$data[0][8] = 'Pincode';
		$data[0][9] = 'Tel Number';
		$data[0][10] = 'Mobile Number';
		$data[0][11] = 'Prod/SKU code';
		$data[0][12] = 'Contents';
		$data[0][13] = 'Weight';
		$data[0][14] = 'Declared Value';
		$data[0][15] = 'Collectable Value';
		$data[0][16] = 'Vendor Code';
		$data[0][18] = 'Shipper Name';
		$data[0][19] = 'Return Address1';
		$data[0][20] = 'Return Address2';
		$data[0][21] = 'Return Address3';
		$data[0][22] = 'Return Pin';
		$data[0][23] = 'Length ( Cms )';
		$data[0][24] = 'Breadth ( Cms )';
		$data[0][25] = 'Height ( Cms )';
		$data[0][26] = 'Pieces';
		$data[0][27] = 'Area_customer_code';
		foreach($results as $key=>$rslt){
			$_order = Mage::getModel('sales/order')->load($rslt['order_id']);
			  
			$_shippingAddress = $_order->getShippingAddress();
			$first_name = $_shippingAddress->getFirstname() ;
			$last_name  = $_shippingAddress->getLastname() ;  
			$region 	= $_shippingAddress->getRegion() ;
			$city		= $_shippingAddress->getCity() ;
			$post_code	= $_shippingAddress->getPostcode();
			$telephone	= $_shippingAddress->getTelephone() ; 
			
			$data[($key + 1)][0] = $rslt['awb'];
			$data[($key + 1)][1] = 'NONCOD';
			$data[($key + 1)][2] = $_order->getIncrement_id();
			$data[($key + 1)][3] = 'Enovate Lifestyles P. Ltd';
			$data[($key + 1)][4] = $rslt['customer_name'];
			$data[($key + 1)][5] = $_shippingAddress->getStreet(1);
			$data[($key + 1)][6] = $_shippingAddress->getStreet(2);
			$data[($key + 1)][7] = $city.', '.$region;
			$data[($key + 1)][8] = $post_code;
			$data[($key + 1)][9] = $telephone;
			$data[($key + 1)][10] = $telephone;
			$data[($key + 1)][11] = 'NA';
			$data[($key + 1)][12] = 'Precious Jewellery';
			$data[($key + 1)][13] = '0.5';
			$data[($key + 1)][14] = $rslt['product_price'];
			$data[($key + 1)][15] = '0';
			$data[($key + 1)][16] = '347314';
			$data[($key + 1)][18] = 'Enovate Lifestyles Private Limited';
			$data[($key + 1)][19] = '501-502, Om Shakti Samrat CHS Ltd.';
			$data[($key + 1)][20] = 'Plot No. 21,Shakti Nivas,Ramchandra Lane extn,Near Greater Bombay Co-op Bank,Kanchpada';
			$data[($key + 1)][21] = 'Mumbai, Maharashtra';
			$data[($key + 1)][22] = '400064';
			$data[($key + 1)][23] = '18';
			$data[($key + 1)][24] = '15';
			$data[($key + 1)][25] = '7.5';
			$data[($key + 1)][26] = 1;
			$data[($key + 1)][27] = 'BOM347314';
		}
		 
		$this->load->helper('csv'); 
		$this->load->dbutil(); 
		array_to_csv($data,'bluedart_softcopy_'.date('d-M-Y').'.csv'); 		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
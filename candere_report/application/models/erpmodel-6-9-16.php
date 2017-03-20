<?php
class ERPModel extends CI_Model 
{
	function __construct()
    {
        parent::__construct();
		$this->load->database();
	}
	
	function addQuotes($string) {
		return '"'. implode('","', explode(',', $string)) .'"';
	}
	
	public function record_count($table) {
        return $this->db->count_all($table);
    }
	
	public function sales_details($limit, $start)
	{
		$query 		= $this->db->query("select entity_id, state, status, increment_id from sales_flat_order limit $start, $limit");
		$sales_data = $query->result();
		return $sales_data;
	}
	
	public function getDiamondClarity($clarity_id)
	{
		$query 		= $this->db->query("select clarity_name from diamond_clarity where clarity_id='$clarity_id'");
		$clarity_code = $query->row();
		return $clarity_code->clarity_name;
	}
	
	public function getDiamondColor($color_id)
	{
		$query 		= $this->db->query("select color_value from diamond_color where color_id='$color_id'");
		$color_code = $query->row();
		//echo $this->db->last_query();
		return $color_code->color_value;
	}
	
	public function tab_orders_count($status_code, $allow_status)
	{
		$status_code = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
		
		if($allow_status != '') {
		 $where = "and cd.order_status_id IN ($allow_status)";
		
		} else {
			$where = "";
		}
		
	     $q = "SELECT c.order_id AS order_id,   cd.id,   cd.order_status_id,   mststatus.status_name,   mststatus.state  FROM    (   (   (   (SELECT MAX(id) AS max_id,  trnorderprocessing.order_status_id,  trnorderprocessing.order_product_id     FROM trnorderprocessing trnorderprocessing   GROUP BY trnorderprocessing.order_product_id) c_max   CROSS JOIN  erp_order c   ON (c_max.order_product_id = c.id))   INNER JOIN      erp_order_details b   ON (c.id = b.erp_order_id))   CROSS JOIN      trnorderprocessing cd   ON (cd.id = c_max.max_id))   INNER JOIN   mststatus mststatus   ON (cd.order_status_id = mststatus.status_id) WHERE ( mststatus.state IN ($status_code) $where)";
		 // echo '<br/>' ;
		 // echo '<br/>' ;
		 // echo '<br/>' ;
		
		 $query 		= $this->db->query($q);
		
		$order_data = $query->result();
	//echo count($order_data);
		 // exit ;
		return count($order_data);
	}
	
		public function non_finished_count()
	{
		$query = $this->db->query("SELECT c.id,  c.order_id,  c.sku
		FROM    (   (   (   (SELECT MAX(id) AS max_id,
                              trnorderprocessing.order_product_id
                         FROM trnorderprocessing trnorderprocessing
                       GROUP BY trnorderprocessing.order_product_id) c_max
                   CROSS JOIN
                      erp_order c
                   ON (c_max.order_product_id = c.id))
               INNER JOIN
                  erp_order_details ed
               ON (c.id = ed.erp_order_id))
           CROSS JOIN
              trnorderprocessing cd
           ON (cd.id = c_max.max_id))
       INNER JOIN
          mststatus mststatus
       ON (cd.order_status_id = mststatus.status_id)
 WHERE erp_order_id NOT IN (SELECT order_product_id FROM trnfinishedproduct)");
			 
		$unfinished_data = $query->result();
		return count($unfinished_data);
	}
	
	
	function order_details($status_code, $allow_status, $search, $sort, $dir, $limit, $start)
	{
		
		
		
		//echo 'hello123' ;
		if($status_code!=''){
			$status_code = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
			$status_in = "mststatus.state IN ($status_code)";
		} else {
			$status_in = "1";
		}
		
		if($allow_status != '') {
		 $where = "AND cd.order_status_id IN ($allow_status)";
		} else {
			$where = "";
		}
				
		/* if($limit!=0 && $start!=0) {
			$and = "limit $start, $limit";
		} else if(($limit==0 && $start==0) || ($limit=='' && $start=='')){
			$and = "";
		} */
			 
		//echo '<br/>' ;
		  $q = "SELECT c.order_id AS order_id, c.mktplace_name , c.order_item_id , c.mktplace_order_id , c.mktplace_sub_order_id , cd.id, cd.order_status_id, c.product_id, c.agent_name, c.customer_name, c.customer_lastname, c.customer_email, c.shipping_country, c.sku, c.sku_custom , c.product_name, c.quantity, c.unit_price, c.updated_price, c.shipping_amount, c.total_due, c.expected_delivery_date, c.dispatch_date, c.discount_amount, cd.vendor_id, cd.notes, cd.order_product_id, cd.greeting_card_id, cd.personal_message, cd.website_id, cd.updated_date, cd.updated_by, b.product_type, b.engrave_message,b.description, b.expected_date_append , b.metal, b.purity, b.height, b.width, b.design_identifier, b.top_thickness, b.top_height, b.bottom_thickness, b.metal_weight, b.total_weight, b.no_of_stones, b.product_image, b.product_url, b.chain_thickness, b.chain_length, b.bracelet_length, b.bangle_size, b.kada_size, b.ring_size, b.diamond_1_status, b.diamond_2_status, b.diamond_3_status, b.diamond_4_status, b.diamond_5_status, b.diamond_6_status, b.diamond_7_status, b.diamond_1_stones, b.diamond_2_stones, b.diamond_3_stones, b.diamond_4_stones, b.diamond_5_stones, b.diamond_6_stones, b.diamond_7_stones, b.diamond_1_weight, b.diamond_2_weight, b.diamond_3_weight, b.diamond_4_weight, b.diamond_5_weight, b.diamond_6_weight, b.diamond_7_weight, b.diamond_1_clarity, b.diamond_2_clarity, b.diamond_3_clarity, b.diamond_4_clarity, b.diamond_5_clarity, b.diamond_6_clarity, b.diamond_7_clarity, b.diamond_1_shape, b.diamond_2_shape, b.diamond_3_shape, b.diamond_4_shape, b.diamond_5_shape, b.diamond_6_shape, b.diamond_7_shape, b.diamond_1_color, b.diamond_2_color, b.diamond_3_color, b.diamond_4_color, b.diamond_5_color, b.diamond_6_color, b.diamond_7_color, b.diamond_1_setting_type, b.diamond_2_setting_type, b.diamond_3_setting_type, b.diamond_4_setting_type, b.diamond_5_setting_type, b.diamond_6_setting_type, b.diamond_7_setting_type, b.gem_1_status, b.gem_2_status, b.gem_3_status, b.gem_4_status, b.gem_5_status, b.gemstone_1_stone, b.gemstone_2_stone, b.gemstone_3_stone, b.gemstone_4_stone, b.gemstone_5_stone, b.gemstone_1_type, b.gemstone_2_type, b.gemstone_3_type, b.gemstone_4_type, b.gemstone_5_type, b.gemstone_1_color, b.gemstone_2_color, b.gemstone_3_color, b.gemstone_4_color, b.gemstone_5_color, b.gemstone_1_shape, b.gemstone_2_shape, b.gemstone_3_shape, b.gemstone_4_shape, b.gemstone_5_shape, b.gemstone_1_setting_type, b.gemstone_2_setting_type, b.gemstone_3_setting_type, b.gemstone_4_setting_type, b.gemstone_5_setting_type, b.gemstone_1_weight, b.gemstone_2_weight, b.gemstone_3_weight, b.gemstone_4_weight, b.gemstone_5_weight, c.buyer_address, c.order_placed_date, b.erp_order_id, c.customer_id, mststatus.status_name, mststatus.state
  FROM    (   (   (   (SELECT MAX(id) AS max_id,
                              trnorderprocessing.order_status_id,
                              trnorderprocessing.order_product_id
                         FROM trnorderprocessing trnorderprocessing
                       GROUP BY trnorderprocessing.order_product_id) c_max
                   CROSS JOIN
                      erp_order c
                   ON (c_max.order_product_id = c.id))
               INNER JOIN
                  erp_order_details b
               ON (c.id = b.erp_order_id))
           CROSS JOIN
              trnorderprocessing cd
           ON (cd.id = c_max.max_id))
       INNER JOIN
          mststatus mststatus
       ON (cd.order_status_id = mststatus.status_id)
 WHERE $status_in $search $where order by $sort $dir 
limit $start, $limit
 ";
 
 //mststatus.state IN ($status_code)
 //WHERE 1
		
		 $query 		= $this->db->query($q);
		$order_data = $query->result();
		
		 $this->db->last_query();
		// $session_data = $this->session->all_userdata();

// echo '<pre>';
// print_r($session_data);
// echo '</pre>' ;
//echo count($order_data);
		return $order_data;
	}
	
		function order_details1($status_code, $allow_status, $search, $limit, $start)
	{
		
		
		
		//echo 'hello123' ;
		if($status_code!=''){
			$status_code = is_array($status_code) ? $this->addQuotes(implode(",",$status_code)) : $status_code;
			$status_in = "mststatus.state IN ($status_code)";
		} else {
			$status_in = "1";
		}
		
		if($allow_status != '') {
		 $where = "AND cd.order_status_id IN ($allow_status)";
		} else {
			$where = "";
		}
				
		/* if($limit!=0 && $start!=0) {
			$and = "limit $start, $limit";
		} else if(($limit==0 && $start==0) || ($limit=='' && $start=='')){
			$and = "";
		} */
			 
		 $q = "SELECT c.order_id AS order_id, c.mktplace_name , c.order_item_id , c.mktplace_order_id , c.mktplace_sub_order_id , cd.id, cd.order_status_id, c.product_id, c.agent_name, c.customer_name, c.customer_lastname, c.customer_email, c.shipping_country, c.sku, c.sku_custom , c.product_name, c.quantity, c.unit_price, c.updated_price, c.shipping_amount, c.total_due, c.expected_delivery_date, c.dispatch_date, c.discount_amount, cd.vendor_id, cd.notes, cd.order_product_id, cd.greeting_card_id, cd.personal_message, cd.website_id, cd.updated_date, cd.updated_by, b.product_type, b.engrave_message,b.description, b.expected_date_append , b.metal, b.purity, b.height, b.width, b.design_identifier, b.top_thickness, b.top_height, b.bottom_thickness, b.metal_weight, b.total_weight, b.no_of_stones, b.product_image, b.product_url, b.chain_thickness, b.chain_length, b.bracelet_length, b.bangle_size, b.kada_size, b.ring_size, b.diamond_1_status, b.diamond_2_status, b.diamond_3_status, b.diamond_4_status, b.diamond_5_status, b.diamond_6_status, b.diamond_7_status, b.diamond_1_stones, b.diamond_2_stones, b.diamond_3_stones, b.diamond_4_stones, b.diamond_5_stones, b.diamond_6_stones, b.diamond_7_stones, b.diamond_1_weight, b.diamond_2_weight, b.diamond_3_weight, b.diamond_4_weight, b.diamond_5_weight, b.diamond_6_weight, b.diamond_7_weight, b.diamond_1_clarity, b.diamond_2_clarity, b.diamond_3_clarity, b.diamond_4_clarity, b.diamond_5_clarity, b.diamond_6_clarity, b.diamond_7_clarity, b.diamond_1_shape, b.diamond_2_shape, b.diamond_3_shape, b.diamond_4_shape, b.diamond_5_shape, b.diamond_6_shape, b.diamond_7_shape, b.diamond_1_color, b.diamond_2_color, b.diamond_3_color, b.diamond_4_color, b.diamond_5_color, b.diamond_6_color, b.diamond_7_color, b.diamond_1_setting_type, b.diamond_2_setting_type, b.diamond_3_setting_type, b.diamond_4_setting_type, b.diamond_5_setting_type, b.diamond_6_setting_type, b.diamond_7_setting_type, b.gem_1_status, b.gem_2_status, b.gem_3_status, b.gem_4_status, b.gem_5_status, b.gemstone_1_stone, b.gemstone_2_stone, b.gemstone_3_stone, b.gemstone_4_stone, b.gemstone_5_stone, b.gemstone_1_type, b.gemstone_2_type, b.gemstone_3_type, b.gemstone_4_type, b.gemstone_5_type, b.gemstone_1_color, b.gemstone_2_color, b.gemstone_3_color, b.gemstone_4_color, b.gemstone_5_color, b.gemstone_1_shape, b.gemstone_2_shape, b.gemstone_3_shape, b.gemstone_4_shape, b.gemstone_5_shape, b.gemstone_1_setting_type, b.gemstone_2_setting_type, b.gemstone_3_setting_type, b.gemstone_4_setting_type, b.gemstone_5_setting_type, b.gemstone_1_weight, b.gemstone_2_weight, b.gemstone_3_weight, b.gemstone_4_weight, b.gemstone_5_weight, c.buyer_address, c.order_placed_date, b.erp_order_id, c.customer_id, mststatus.status_name, mststatus.state
  FROM    (   (   (   (SELECT MAX(id) AS max_id,
                              trnorderprocessing.order_status_id,
                              trnorderprocessing.order_product_id
                         FROM trnorderprocessing trnorderprocessing
                       GROUP BY trnorderprocessing.order_product_id) c_max
                   CROSS JOIN
                      erp_order c
                   ON (c_max.order_product_id = c.id))
               INNER JOIN
                  erp_order_details b
               ON (c.id = b.erp_order_id))
           CROSS JOIN
              trnorderprocessing cd
           ON (cd.id = c_max.max_id))
       INNER JOIN
          mststatus mststatus
       ON (cd.order_status_id = mststatus.status_id)
 WHERE $status_in $where $search 
limit $start, $limit
 ";
 
 //mststatus.state IN ($status_code)
 //WHERE 1
		
		 $query 		= $this->db->query($q);
		$order_data = $query->result();
		
		 $this->db->last_query();
		// $session_data = $this->session->all_userdata();

// echo '<pre>';
// print_r($session_data);
// echo '</pre>' ;
		return $order_data;
	}
	
	function getStatusName($status_id)
	{
		$query = $this->db->query('SELECT status_name FROM mststatus where status_id='.$status_id.'');
		$status_data = $query->row();
        return $status_data->status_name;
	}
	
	function getAllStatus()
    {
		
		
		if($this->session->userdata('_username')=='sales')
		{ $status_id ='(1,2)' ;}
	if($this->session->userdata('_username')=='manufacturing')
		{ $status_id ='(4,5,6)' ;}

	if($this->session->userdata('_username')=='cad')
		{ $status_id ='(3)' ;}

	if($this->session->userdata('_username')=='procurement')
		{ $status_id ='(7,8,13,14,15,16)' ;}

	if($this->session->userdata('_username')=='marketplace')
		{ $status_id ='(1,2,12,9,10,17)' ;}

	if($this->session->userdata('_username')=='logisitic')
		{ $status_id ='(9,17)' ;}	
	
	if($this->session->userdata('_username')=='Rupesh Jain')
		{ $status_id ='(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17)' ;}
	
        $query = $this->db->query("SELECT status_id, status_name FROM mststatus where status_id IN $status_id");
        
		return $query->result();
    }
	
	function getProcessingStatus($allow_status)
    {
        $query = $this->db->query('SELECT status_id, status_name FROM mststatus where status_id IN ('.$allow_status.') and cancelled!=1 order by sequence ASC');
        return $query->result();
    }
	
	function status_per_user($allow_status)
    {
        $query = $this->db->query('SELECT status_id, status_name FROM mststatus where status_id IN ('.$allow_status.')  order by sequence ASC');
        return $query->result();
    }
	
	function getAllVendors()
    {
        $query = $this->db->query('SELECT vendor_id, vendor_name FROM mstvendor where active=1  order by vendor_id ASC');
        return $query->result();
    }
	
	function getAllGreetings()
    {
        $query = $this->db->query('SELECT greeting_card_id, greeting_card_name FROM mstgreetingcard order by greeting_card_id ASC');
        return $query->result();
    }
	
	function getOrderData($order_id)
    {
        $query = $this->db->query("SELECT id, order_id, order_status_id, vendor_id, notes, greeting_card_id, personal_message, website_id FROM trnorderprocessing where order_id='$order_id' order by id DESC");
        return $query->result();
    }
	
	function getOrderNotes($order_id, $order_product_id)
    {
        $query = $this->db->query("SELECT id, order_id, order_status_id, notes, updated_by, updated_date FROM trnorderprocessing where order_id='$order_id' AND order_product_id='$order_product_id' order by id DESC");
        return $query->result();
    }
	
	function getVendor($VendorID)
	{
		$this->db->select('vendor_name');
		$this->db->where('vendor_id', $VendorID);
		$q 		= $this->db->get('mstvendor');
		$data 	= $q->result_array();
		return ($data[0]['vendor_name']); 
	}
	
	function getGreeting($greeting_card_id)
	{
		$this->db->select('greeting_card_name');
		$this->db->where('greeting_card_id', $greeting_card_id);
		$q 		= $this->db->get('mstgreetingcard');
		$data 	= $q->result_array();
		return ($data[0]['greeting_card_name']); 
	}
	
	function AddNewRow($table, $data)
    {
        $this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
    function UpdateRow($table, $data, $key)
    {
        
$this->db->update($table, $data, $key);
		return $this->db->affected_rows();
    }
	
	function Rowcount($table, $key)
    {	
		$query = $this->db->where($key); 
        $query = $this->db->get($table);
        return $query->result();
    }

	function DeleteRow($table, $key)
    {
		$this->db->delete($table, $key); 
		if ($this->db->affected_rows() > 0)
            return TRUE;
        return FALSE;	
    }
	
	function Delete_Errormsg($mytable,$key)
	{
		$this->db->where($key); 
		$query = $this->db->get($mytable);
		return $query->result();
	}
	
    function CountRecords($table, $key ='', $search = '')
    {
		if($search)
		{
			if(!empty($key))
			{
				$query = $this->db->or_like($key); 
			}
		}
		else
		{
			if(!empty($key))
			{
				$query = $this->db->where($key); 
			}		
		}
		$this->db->from($table);
		#echo $this->db->last_query();
		return $this->db->count_all_results();
    }
	
    function CountNotCentralRecords($table, $key ='', $search = '')
    {
		if($search)
		{
			if(!empty($key))
			{
				$query = $this->db->or_like($key); 
			}
		}
		else
		{
			if(!empty($key))
			{
				$query = $this->db->where($key); 
			}		
		}
		$query = $this->db->where("central != '1'"); 
		$this->db->from($table);
		
		return $this->db->count_all_results();
    }
	
    function GetInfoRow($table, $key)
    {
		if(!empty($key))
		{
			$query = $this->db->where($key); 
		}
        $query = $this->db->get($table);
        return $query->result();
    }
	
	function GetSelectedRows($table, $limit, $start, $columns = '', $orderby ='', $key='',$search = '')
	{
		if(!empty($columns))
		{
			$this->db->select($columns);		
		}
		
		if($search)
		{
			if(!empty($key))
			{
				$query = $this->db->or_like($key); 
			}
		}
		else
		{
			if(!empty($key))
			{
				$query = $this->db->where($key); 
			}		
		}
		
		if(!empty($orderby))
		{
			$this->db->order_by("$orderby");
		}
		$this->db->limit($limit, $start);
		$query = $this->db->get($table);
		return $query->result();			
	}
	
	function get_order_details($get_order_id,$erp_product_id)
    { 
		 $query = $this->db->select("erp_order.id,erp_order.order_id,erp_order.order_item_id, erp_order.sku, erp_order.quantity, erp_order.unit_price, erp_order.buyer_address, erp_order.shipping_country, erp_order.order_status, erp_order.status, erp_order.order_placed_date, erp_order_details.product_image, erp_order.product_name, erp_order_details.erp_order_id, erp_order.expected_delivery_date, erp_order.shipping_amount, erp_order.discount_amount,erp_order.quantity,erp_order_details.product_url,erp_order_details.product_type,erp_order_details.metal,erp_order_details.purity,erp_order_details.height,erp_order_details.width,erp_order_details.top_thickness,erp_order_details.top_height,erp_order_details.bottom_thickness,erp_order_details.metal_weight,erp_order_details.total_weight,erp_order_details.no_of_stones,erp_order_details.chain_thickness,erp_order_details.chain_length,erp_order_details.bracelet_length,erp_order_details.bangle_size,erp_order_details.kada_size,erp_order_details.ring_size, erp_order_details.bangle_size, 
		erp_order_details.diamond_1_status, erp_order_details.diamond_2_status,
		erp_order_details.diamond_3_status, erp_order_details.diamond_4_status,
		erp_order_details.diamond_5_status, erp_order_details.diamond_6_status,
		erp_order_details.diamond_7_status,erp_order_details.diamond_8_status,
		erp_order_details.diamond_9_status,erp_order_details.diamond_10_status,
		
		erp_order_details.diamond_1_stones, erp_order_details.diamond_2_stones,	
		erp_order_details.diamond_3_stones,	erp_order_details.diamond_4_stones,	
		erp_order_details.diamond_5_stones,	erp_order_details.diamond_6_stones,	
		erp_order_details.diamond_7_stones,erp_order_details.diamond_8_stones,
		erp_order_details.diamond_9_stones,erp_order_details.diamond_10_stones,		
		
		erp_order_details.diamond_1_weight,	erp_order_details.diamond_2_weight,	
		erp_order_details.diamond_3_weight,	erp_order_details.diamond_4_weight,	
		erp_order_details.diamond_5_weight,	erp_order_details.diamond_6_weight,	
		erp_order_details.diamond_7_weight,	erp_order_details.diamond_8_weight, 
		erp_order_details.diamond_9_weight,erp_order_details.diamond_10_weight,
		
		erp_order_details.diamond_1_clarity,	erp_order_details.diamond_2_clarity,	
		erp_order_details.diamond_3_clarity,	erp_order_details.diamond_4_clarity,	
		erp_order_details.diamond_5_clarity,	erp_order_details.diamond_6_clarity,	
		erp_order_details.diamond_7_clarity,	
		
		erp_order_details.diamond_1_shape,	erp_order_details.diamond_2_shape,	
		erp_order_details.diamond_3_shape,	erp_order_details.diamond_4_shape,	
		erp_order_details.diamond_5_shape,	erp_order_details.diamond_6_shape,	
		erp_order_details.diamond_7_shape,	erp_order_details.diamond_8_shape,	
		erp_order_details.diamond_9_shape,	erp_order_details.diamond_10_shape,	
		 
		
		erp_order_details.diamond_1_color,	erp_order_details.diamond_2_color,	
		erp_order_details.diamond_3_color,	erp_order_details.diamond_4_color,	
		erp_order_details.diamond_5_color,	erp_order_details.diamond_6_color,	
		erp_order_details.diamond_7_color, 
		
		erp_order_details.diamond_1_setting_type,	erp_order_details.diamond_2_setting_type,	
		erp_order_details.diamond_3_setting_type,	erp_order_details.diamond_4_setting_type,	
		erp_order_details.diamond_5_setting_type,	erp_order_details.diamond_6_setting_type,	
		erp_order_details.diamond_7_setting_type, erp_order_details.diamond_8_setting_type,
		erp_order_details.diamond_9_setting_type, erp_order_details.diamond_10_setting_type,
		
		erp_order_details.diamond_1_size,	erp_order_details.diamond_2_size,	
		erp_order_details.diamond_3_size,	erp_order_details.diamond_4_size,	
		erp_order_details.diamond_5_size,	erp_order_details.diamond_6_size,	
		erp_order_details.diamond_7_size, erp_order_details.diamond_8_size,
		erp_order_details.diamond_9_size, erp_order_details.diamond_10_size,
		
		
		erp_order_details.gem_1_status, erp_order_details.gem_2_status, erp_order_details.gem_3_status, 
		erp_order_details.gem_4_status, erp_order_details.gem_5_status, erp_order_details.gem_6_status,
		erp_order_details.gem_7_status, erp_order_details.gem_8_status, erp_order_details.gem_9_status,
		
		erp_order_details.gemstone_1_stone,	erp_order_details.gemstone_2_stone,	erp_order_details.gemstone_3_stone,	erp_order_details.gemstone_4_stone,	erp_order_details.gemstone_5_stone, erp_order_details.gemstone_6_stone,
		erp_order_details.gemstone_7_stone, erp_order_details.gemstone_8_stone, erp_order_details.gemstone_9_stone,

		erp_order_details.gemstone_1_type,	erp_order_details.gemstone_2_type,	erp_order_details.gemstone_3_type,	erp_order_details.gemstone_4_type,	erp_order_details.gemstone_5_type, erp_order_details.gemstone_6_type,
        erp_order_details.gemstone_7_type, erp_order_details.gemstone_8_type, erp_order_details.gemstone_9_type,		
		
		erp_order_details.gemstone_1_color,	erp_order_details.gemstone_2_color,	erp_order_details.gemstone_3_color,	erp_order_details.gemstone_4_color,	erp_order_details.gemstone_5_color,	erp_order_details.gemstone_6_color,
		erp_order_details.gemstone_7_color, erp_order_details.gemstone_8_color, erp_order_details.gemstone_9_color,
		
		erp_order_details.gemstone_1_shape,	erp_order_details.gemstone_2_shape,	erp_order_details.gemstone_3_shape,	erp_order_details.gemstone_4_shape,	erp_order_details.gemstone_5_shape, erp_order_details.gemstone_6_shape,
        erp_order_details.gemstone_7_shape, erp_order_details.gemstone_8_shape, erp_order_details.gemstone_9_shape,		
		
		erp_order_details.gemstone_1_setting_type,	erp_order_details.gemstone_2_setting_type,	erp_order_details.gemstone_3_setting_type,	erp_order_details.gemstone_4_setting_type,	erp_order_details.gemstone_5_setting_type, erp_order_details.gemstone_6_setting_type,
        erp_order_details.gemstone_7_setting_type, erp_order_details.gemstone_8_setting_type, erp_order_details.gemstone_9_setting_type,		
		
		erp_order_details.gemstone_1_weight,	erp_order_details.gemstone_2_weight,	erp_order_details.gemstone_3_weight,	erp_order_details.gemstone_4_weight,	erp_order_details.gemstone_5_weight , erp_order_details.gemstone_6_weight ,
		erp_order_details.gemstone_7_weight, erp_order_details.gemstone_8_weight, erp_order_details.gemstone_9_weight
		")
              ->from('erp_order')
              ->join('erp_order_details', 'erp_order.id = erp_order_details.erp_order_id', 'inner')
              ->where('erp_order.order_id', $get_order_id)
              ->where('erp_order_details.erp_order_id', $erp_product_id)
			  ->group_by('erp_order.order_id')
			  ->order_by('erp_order.order_id','desc')
              ->get();
		$order_data = $query->row();
		
		//echo $this->db->last_query();exit;
		 	
		return $order_data;
    }
	
	
	public function getNonFinishedProducts($search, $limit, $start)
	{
		 $query = $this->db->query("SELECT c.id,  c.order_id,  c.sku,  c.quantity,   c.unit_price,   ed.product_image,   c.product_name,  c.quantity, ed.erp_order_id, cd.order_status_id,  mststatus.status_name
		FROM    (   (   (   (SELECT MAX(id) AS max_id,
                              trnorderprocessing.order_product_id
                         FROM trnorderprocessing trnorderprocessing
                       GROUP BY trnorderprocessing.order_product_id) c_max
                   CROSS JOIN
                      erp_order c
                   ON (c_max.order_product_id = c.id))
               INNER JOIN
                  erp_order_details ed
               ON (c.id = ed.erp_order_id))
           CROSS JOIN
              trnorderprocessing cd
           ON (cd.id = c_max.max_id))
       INNER JOIN
          mststatus mststatus
       ON (cd.order_status_id = mststatus.status_id)
 WHERE $search limit $start, $limit");
 
		// $this->db->last_query();	
		$unfinished_data = $query->result();
		return $unfinished_data;
	}
	

	
	
			
}
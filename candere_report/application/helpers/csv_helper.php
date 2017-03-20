<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	// ------------------------------------------------------------------------
	 
	/**
	* CSV Helpers
	* Inspiration from PHP Cookbook by David Sklar and Adam Trachtenberg
	*
	* @author Jérôme Jaglale
	* @link http://maestric.com/en/doc/php/codeigniter_csv
	*/
	 
	// ------------------------------------------------------------------------
	 
	 
	//-------------------------------------------
	/*
	Documentation:
	==============
	1. Array to csv file
	array_to_csv($ArrayVariable,'file.csv')
	2. Query to csv file
	echo query_to_csv($query,'stalls.csv');
	$query = $this->db->get('stall_contact');
	$this->load->helper('csv');
	3. Query to download file
	$query = $this->db->get('stall_contact');
	$this->load->helper('csv');
	query_to_csv($query,TRUE,'bookings.csv');
	*/
	if( ! function_exists('array_to_csv'))
	{
		function array_to_csv($array, $download = "")
		{
			header('Content-Type: text/html; charset=utf-8');
			if ($download != "")
			{
				header('Content-Type: application/csv');
				header('Content-type: text/html; charset=utf-8');
				header('Content-Disposition: attachement; filename="' . $download . '".csv');
			}
		 
			ob_start();
			$f = fopen('php://output', 'w') or show_error("Can't open php://output");
			$n = 0;
			
			$flag = false;
			
			foreach ($array as $line)
			{
				if(!$flag) { 
				   // display field/column names as first row 
				   fputcsv($f, array_keys($line), ',', '"');
				   $flag = true; 
				} 
				
				$n++;
				if ( ! fputcsv($f, $line))
				{
					show_error("Can't write line $n: $line");
				}
			}
			fclose($f) or show_error("Can't close php://output");
			$str = ob_get_contents();
			ob_end_clean();
		 
			if ($download == "")
			{
				return $str;
			}
			else
			{
				echo $str;
			}
		}
		
		
		function fput_array_to_csv($array, $location = "", $filename = "")
		{  
			$fp = fopen($location.$filename, 'w');

			foreach ($array as $fields) {
				fputcsv($fp, $fields);
			}

			fclose($fp);
			
			return $filename ;
		}
		
	}
 
// ------------------------------------------------------------------------
 
	/**
	* Query to CSV
	*
	* download == "" -> return CSV string
	* download == "toto.csv" -> download file toto.csv
	*/
	if ( ! function_exists('query_to_csv'))
	{
		function query_to_csv($query, $headers = TRUE, $download = "")
		{
			if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
			{
				show_error('invalid query');
			}
			 
			$array = array();
			if ($headers == true)
			{
				$line = array();
				foreach ($query->list_fields() as $name)
				{
					$line[] = $name;
				}
				$array[] = $line;
			}
			
			foreach ($query->result_array() as $key=>$row)
			{				 
				$line = array();
				/*if ($key == 0)
				{
					foreach ($row as $key=>$item)
					{
						$line[] =  $key;
					} 
				}else{	*/ 
					foreach ($row as $item)
					{
						$line[] = $item;
					}
				/*}*/
				$array[] = $line;
			}
			 
			echo array_to_csv($array, $download);
		}
	}
 
	/* End of file csv_helper.php */
	/* Location: ./system/helpers/csv_helper.php */
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exportimage extends CI_Controller  {
	
	
	 
	public function index()
	{
		
		$postValue = $this->input->post();
		if(!empty($postValue)){
		$a=implode(',',$postValue['sku']);
		
		$pro_sku=explode(',',$a);
		$i=0;
		$zip = new ZipArchive;
		$files=array();
		$zipname = 'file.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach($pro_sku as $val){
			$sku=trim($val);	
			$product_id = Mage::getModel("catalog/product")->getIdBySku($sku); 
			
			$_product = Mage::getModel('catalog/product')->load($product_id);
			$gallery = $_product->getMediaGalleryImages();
			
				foreach($gallery as $files){
					 
					$zip->addFile($files->getPath());
				}
			}
		
		
			$zip->close();
			
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$zipname);
			header('Content-Length: ' . filesize($zipname));
			
			readfile($zipname);
			
			unlink($zipname);
		}
		
		
 
	    		
		$this->load->view('templates/header'); 
        $this->load->view("exportimage/index",$data);
		$this->load->view('templates/footer');
		
	} 
	
	
	//*************************************** last updated by Bharat @010716*******************************
	
	
	
	
	
	
	
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */

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
			
			$media_dir = Mage::getBaseDir('media');
			foreach($pro_sku as $val){
				
				$sql='SELECT  distinct metal_id,product_id FROM `pricing_table_metal_options` WHERE `sku`="'.$val.'"';
				$metal_id = $this->db->query($sql)->row()->metal_id;
				$product_id = $this->db->query($sql)->row()->product_id;
				
				 
				$sql_img="SELECT value FROM `catalog_product_entity_media_gallery` WHERE `entity_id` =".$product_id;
				$sql_img = 'select catalog_product_entity_media_gallery.value from catalog_product_entity_media_gallery join catalog_product_entity_media_gallery_value on (catalog_product_entity_media_gallery.value_id = catalog_product_entity_media_gallery_value.value_id) where catalog_product_entity_media_gallery.attribute_id = 88 and catalog_product_entity_media_gallery.entity_id = '.$product_id .' and catalog_product_entity_media_gallery_value.metal = '.$metal_id .' and  catalog_product_entity_media_gallery_value.store_id  = 0';
			
				$results_img = $this->db->query($sql_img);
				$results_row_img =$results_img->result();
				 
				foreach($results_row_img as $key=>$file_img){		
					
					$path = $media_dir.'/catalog/product'.$file_img->value;
					
					$zip->addFile($path);
				}
				 
			
				$zip->close();
				
				header('Content-Type: application/zip');
				header('Content-disposition: attachment; filename='.$zipname);
				header('Content-Length: ' . filesize($zipname));
				
				readfile($zipname);
				
				unlink($zipname);
			}
		} 
	    		
		$this->load->view('templates/header'); 
        $this->load->view("exportimage/index",$data);
		$this->load->view('templates/footer');
		
	} 
	 
}

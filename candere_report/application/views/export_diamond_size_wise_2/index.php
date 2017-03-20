<br><br>
<style>
.messages span a{font-size:15px;}
</style>
<div class="messages" style="width:1400px; margin: 0 auto;">

<h1 style="color:red;">Rings Export</h1><br>
<?php		
		$sql =	"SELECT count(pricing_table_metal_options.sku) as total_count
  FROM       (   (      (   (   pricing_table_metal_options pricing_table_metal_options
                                   INNER JOIN
                                      eav_attribute_option_value eav_attribute_option_value
                                   ON (pricing_table_metal_options.metal_id =
                                          eav_attribute_option_value.option_id))
                               INNER JOIN
                                  eav_attribute_option_value eav_attribute_option_value_1
                               ON (pricing_table_metal_options.purity =
                                      eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_int catalog_product_entity_int
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_int.entity_id))
               INNER JOIN
                  eav_attribute_option_value eav_attribute_option_value_2
               ON (catalog_product_entity_int.value =
                      eav_attribute_option_value_2.option_id))
       INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_1
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_1.entity_id)
	INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_2
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_2.entity_id)		  
 WHERE     (   (catalog_product_entity_int_2.attribute_id = 277)
       AND (catalog_product_entity_int_2.value = 0) AND ( catalog_product_entity_int_1.attribute_id = 96
                 AND catalog_product_entity_int_1.value = 1)
            AND (    (    (    (    (    pricing_table_metal_options.status =
                                            1
                                     )
                                AND catalog_product_entity_int.attribute_id =
                                       272)
                           AND catalog_product_entity_int.value IN (583))
                      )
                ))
ORDER BY pricing_table_metal_options.sku DESC";

		$results = $this->db->query($sql);
		$result = array_shift($results->result());
		$total_ring_count = $result->total_count;
		$limit_array = range(0,$total_ring_count+500,500);
		unset($limit_array[count($limit_array)-1]);
		
		foreach($limit_array as $res) {
			$limit = 'limit '. $res .',500';
			$limit_range = $res+1 .' to '. ($res+500);	
		?>	
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=rings&diamond_selection=SIIJ&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings - SI IJ - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=rings&diamond_selection=SIGH&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings - SI GH - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=rings&diamond_selection=VSGH&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings - VS GH - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=rings&diamond_selection=VVSEF&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings - VVS EF - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 
						
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=rings&diamond_selection=ALL&limit=<?php echo $limit ?>&limit_range=<?php echo $limit_range; ?>">Export Rings - ALL - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; <br><br>  	
		<?php
		}	
		unset($limit_array);
		unset($limit_range,$limit);
	?>

<br>
 
 
<h1 style="color:red;">Bands Export</h1><br> 
 <?php
$sql =	"SELECT COUNT(pricing_table_metal_options.sku) AS total_count
  FROM    (   (   (   (   pricing_table_metal_options pricing_table_metal_options
                       INNER JOIN
                          eav_attribute_option_value eav_attribute_option_value_1
                       ON (pricing_table_metal_options.purity =
                              eav_attribute_option_value_1.option_id))
                   INNER JOIN
                      catalog_product_entity_int catalog_product_entity_int
                   ON (pricing_table_metal_options.product_id =
                          catalog_product_entity_int.entity_id))
               INNER JOIN
                  eav_attribute_option_value eav_attribute_option_value_2
               ON (catalog_product_entity_int.value =
                      eav_attribute_option_value_2.option_id))
           INNER JOIN
              eav_attribute_option_value eav_attribute_option_value
           ON (pricing_table_metal_options.metal_id =
                  eav_attribute_option_value.option_id))
       INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_1
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_1.entity_id)
	INNER JOIN
          catalog_product_entity_int catalog_product_entity_int_2
       ON (pricing_table_metal_options.product_id =
              catalog_product_entity_int_2.entity_id)		  
 WHERE (    (catalog_product_entity_int_2.attribute_id = 277)
       AND (catalog_product_entity_int_2.value = 0) AND ( catalog_product_entity_int_1.attribute_id = 96
             AND catalog_product_entity_int_1.value = 1)
        AND (    (    pricing_table_metal_options.status = 1
                  AND catalog_product_entity_int.attribute_id = 272)
             AND catalog_product_entity_int.value IN (587)))"; 

		$results = $this->db->query($sql);
		$result = array_shift($results->result());
		$total_band_count = $result->total_count;
		$limit_array = range(0,$total_band_count+500,500);
		
		unset($limit_array[count($limit_array)-1]);
		
		foreach($limit_array as $res) {
			$limit = 'limit '. $res .',500';
			$limit_range = $res+1 .' to '. ($res+500);	
		?>	
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bands&diamond_selection=SIIJ&limit=<?php echo $limit; ?>&limit_range=<?php echo $limit_range; ?>">Export Bands - SI IJ - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bands&diamond_selection=SIGH&limit=<?php echo $limit; ?>&limit_range=<?php echo $limit_range; ?>">Export Bands - SI GH - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bands&diamond_selection=VSGH&limit=<?php echo $limit; ?>&limit_range=<?php echo $limit_range; ?>">Export Bands - VS GH - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bands&diamond_selection=VVSEF&limit=<?php echo $limit; ?>&limit_range=<?php echo $limit_range; ?>">Export Bands - VVS EF - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;
			
			<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bands&diamond_selection=ALL&limit=<?php echo $limit; ?>&limit_range=<?php echo $limit_range; ?>">Export Bands - ALL - <?php echo $limit_range ?></a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;
		<?php
		}
		?>
<br><br><br>

<h1 style="color:red;">Bangles Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bangles&diamond_selection=SIIJ">Export Bangles - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bangles&diamond_selection=SIGH">Export Bangles - SI GH</a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bangles&diamond_selection=VSGH">Export Bangles - VS GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bangles&diamond_selection=VVSEF">Export Bangles - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;  


<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=bangles&diamond_selection=ALL">Export Bangles - ALL </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;<br><br>




<h1 style="color:red;">Kada Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=kada&diamond_selection=SIIJ">Export Kada - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=kada&diamond_selection=SIGH">Export Kada - SI GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=kada&diamond_selection=VSGH">Export Kada - VS GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=kada&diamond_selection=VVSEF">Export Kada - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export?product_label=kada&diamond_selection=ALL">Export Kada - ALL </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; <br> <br>




<h1 style="color:red;">Braceletes Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_chains_bracelets?product_label=bracelets&diamond_selection=SIIJ">Export Bracelets - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_chains_bracelets?product_label=bracelets&diamond_selection=SIGH">Export Bracelets - SI GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_chains_bracelets?product_label=bracelets&diamond_selection=VSGH">Export Bracelets - VS GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_chains_bracelets?product_label=bracelets&diamond_selection=VVSEF">Export Bracelets - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_chains_bracelets?product_label=bracelets&diamond_selection=ALL">Export Bracelets - ALL </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;<br>  <br>



<h1 style="color:red;">Earrings Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=earrings&diamond_selection=SIIJ">Export Earrings - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=earrings&diamond_selection=SIGH">Export Earrings - SI GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=earrings&diamond_selection=VSGH">Export Earrings - VS GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=earrings&diamond_selection=VVSEF">Export Earrings - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp; 

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=earrings&diamond_selection=ALL">Export Earrings - ALL </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;<br>  <br>




<h1 style="color:red;">Pendants Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=pendants&diamond_selection=SIIJ">Export Pendants- SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=pendants&diamond_selection=SIGH">Export Pendants - SI GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=pendants&diamond_selection=VSGH">Export Pendants - VS GH </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=pendants&diamond_selection=VVSEF">Export Pendants - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=pendants&diamond_selection=ALL">Export Pendants - ALL </a></b></span>
<br> <br> <br> 



<h1 style="color:red;">Nose Pins Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=nose_pins&diamond_selection=SIIJ">Export Nose Pins - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=nose_pins&diamond_selection=SIGH">Export Nose Pins - SI GH </a></b></span>&nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=nose_pins&diamond_selection=VSGH">Export Nose Pins - VS GH </a></b></span>&nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=nose_pins&diamond_selection=VVSEF">Export Nose Pins - VVS EF </a></b></span> &nbsp;&nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=nose_pins&diamond_selection=ALL">Export Nose Pins - ALL </a></b></span>
<br> <br> <br> 



<h1 style="color:red;">Necklaces Export</h1><br>

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=necklaces&diamond_selection=SIIJ">Export necklaces - SI IJ </a></b></span> &nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=necklaces&diamond_selection=SIGH">Export necklaces - SI GH </a></b></span> &nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=necklaces&diamond_selection=VSGH">Export necklaces - VS GH </a></b></span>  &nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=necklaces&diamond_selection=VVSEF">Export necklaces - VVS EF </a></b></span>  &nbsp;&nbsp;&nbsp;

<span><b><a href="<?php echo $this->config->base_url(); ?>/index.php/export_diamond_size_wise_2/export_products_without_dropdown?product_label=necklaces&diamond_selection=ALL">Export necklaces - ALL </a></b></span>
<br> <br> <br>  

</div>
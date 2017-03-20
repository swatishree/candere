<?php
echo "jesni"; exit;

if(isset($_POST['search_keyword']))
{
	$search_keyword = $dbConnection->real_escape_string($_POST['search_keyword']);
	
	$sqlCountries="SELECT countries_id,countries_name FROM tbl_countries WHERE countries_name LIKE '%$search_keyword%'";
    $resCountries=$dbConnection->query($sqlCountries);
    if($resCountries === false) {
        trigger_error('Error: ' . $dbConnection->error, E_USER_ERROR);
    }else{
        $rows_returned = $resCountries->num_rows;
    }
	$bold_search_keyword = '<strong>'.$search_keyword.'</strong>';
	if($rows_returned > 0){
		while($rowCountries = $resCountries->fetch_assoc()) {		
			echo '<div class="show" align="left"><span class="country_name">'.str_ireplace($search_keyword,$bold_search_keyword,$rowCountries['countries_name']).'</span></div>'; 	
		}
	}else{
		echo '<div class="show" align="left">No matching records.</div>'; 	
	}
}	
?>
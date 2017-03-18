<?php
// product type filter
require_once '../../../app/Mage.php';
umask(0);
Mage::app('default');

$is_live  = 1;
if($is_live == 1)
{
	$link = mysql_connect('localhost', 'candere_candere', 'candereindia#1235');
	mysql_select_db('candere_candere', $link);
}
else if($is_live == 0)
{
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('new_candere', $link);
}
error_reporting(0);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Most Clicked Product</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="report.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="chart.php"><i class="fa fa-bar-chart-o fa-fw"></i> Charts</a>
                        </li>
						<li>
                            <a href="most_clicked.php"><i class="fa fa-bar-chart-o fa-fw"></i> Most Clicked</a>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="customers_wallet_amount.php"><i class="fa fa-dashboard fa-fw"></i> MyWallet</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Most Clicked Product</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class=" panel-default">
                         <!--<div class="panel-heading">
                            Reports
                        </div>-->
                       
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row">
				<div class="form-group" style="width:300px;">
				<form name="frm" id="frm" method="post">
					<select class="form-control" name="product_type" id="product_type" onchange="this.form.submit();">
						<option value="test" <?php if($_POST['product_type'] == 'test') { echo 'selected="selected"';} ?>>Select Product Type</option>
						<option value="Rings" <?php if($_POST['product_type'] == 'Rings') { echo 'selected="selected"';} ?>>Rings</option>
						<option value="Bands" <?php if($_POST['product_type'] == 'Bands') { echo 'selected="selected"';} ?>>Bands</option>
						<option value="Chains" <?php if($_POST['product_type'] == 'Chains') { echo 'selected="selected"';} ?>>Chains</option>
						<option value="Pendants" <?php if($_POST['product_type'] == 'Pendants') { echo 'selected="selected"';} ?>>Pendants</option>
						<option value="Earrings" <?php if($_POST['product_type'] == 'Earrings') { echo 'selected="selected"';} ?>>Earrings</option>
						<option value="Bangles" <?php if($_POST['product_type'] == 'Bangles') { echo 'selected="selected"';} ?>>Bangles</option>
						<option value="Coins" <?php if($_POST['product_type'] == 'Coins') { echo 'selected="selected"';} ?>>Coins</option>						
						<option value="Kada" <?php if($_POST['product_type'] == 'Kada') { echo 'selected="selected"';} ?>>Kada</option>
						<option value="Necklaces" <?php if($_POST['product_type'] == 'Necklaces') { echo 'selected="selected"';} ?>>Necklaces</option>
						<option value="Nose Pins" <?php if($_POST['product_type'] == 'Nose Pins') { echo 'selected="selected"';} ?>>Nose Pins</option>
						<option value="Bracelets" <?php if($_POST['product_type'] == 'Bracelets') { echo 'selected="selected"';} ?>>Bracelets</option>
						<option value="Kurta Buttons" <?php if($_POST['product_type'] == 'Kurta Buttons') { echo 'selected="selected"';} ?>>Kurta Buttons</option>
					</select>
				</form>
				</div>
                <div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           &nbsp;
                        </div>
						<?php					
							
							$whr_str = '';
							
							if(isset($_POST) && $_POST['product_type'] != 'test')
							{
								$whr_str = 'WHERE product_type="'.$_POST['product_type'].'"';
							}
						
							$sel_clicked = "select * from  product_most_clicked $whr_str group by product_id order by most_clicked desc ";		
							$res_clicked = mysql_query($sel_clicked);
							
						?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SKU</th>
                                            <th>Product Type</th>
                                            <th>Most Clicked</th>
											<th>Type</th>
											<th>Category</th>
											<th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										$j = 1;
										
										while($row_clicked= mysql_fetch_assoc($res_clicked))
										{
										
											
											$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$row_clicked['sku']);

											$pathArray = array();
											$collection1 = $product->getCategoryCollection()
												->setStoreId(Mage::app()->getStore()->getId())
												->addAttributeToSelect('path')
												->addAttributeToSelect('is_active');


											foreach($collection1 as $cat1){            
												$pathIds = explode('/', $cat1->getPath());            
												$collection = Mage::getModel('catalog/category')->getCollection()
													->setStoreId(Mage::app()->getStore()->getId())
													->addAttributeToSelect('name')
													->addAttributeToSelect('is_active')
													->addFieldToFilter('entity_id', array('in' => $pathIds));

												$pahtByName = '';
												foreach($collection as $cat){                
													$pahtByName .= '/' . $cat->getName();
												}

												$pathArray[] = $pahtByName;

											}
											
											
											
											/*if($row_clicked['categories'] != '')
												$subcategory_explode = explode(',', $row_clicked['categories']);
											else
												$subcategory_explode = '';
											
											
											$category = Mage::getModel('catalog/category');
											$subcategories = $category->getChildrenCategories();
											if (count($subcategories) > 0)
											{
												$category = $category->getName();
												foreach($subcategories as $subcategory){
													$subcategory = $subcategory->getName();
												}
											}
											
											
											if(count($subcategory_explode) >0)
											{
												$children = Mage::getModel('catalog/category')->load($subcategory_explode[0])->getChildrenCategories();
												foreach ($children as $category):
													$category = Mage::getModel('catalog/category')->load($category->getId());
													$category_path = $category->getName();
												endforeach;
											}
											echo "--exp--".count($subcategory_explode); 
											
											if(count($subcategory_explode) > 0):
												$category = Mage::getModel('catalog/category')->load($subcategory_explode[0]);
												$subcategories = $category->getChildrenCategories();												
												
												if (count($subcategories) > 0){
													 $category = $category->getName();
													foreach($subcategories as $subcategory){
														$subcategory = $subcategory->getName();
													}
												}
												if($category != '' && $subcategory != '')
													$category_path = $category." ->  ".$subcategory;
												else if($category != '' && $subcategory == '')
													$category_path = $category;
												else if($category == '' && $subcategory != '')
													$category_path = $subcategory;
												echo "--cat path--".$category_path;exit;
											endif;*/
											if($row_clicked['clicked_date'] != '0000-00-00' && $row_clicked['clicked_date'] != '1970-01-01')
												$clicked_date = date('d-m-Y',strtotime($row_clicked['clicked_date']));
											else
												$clicked_date = '';
											
											$pathArray_count = count($pathArray) - 1;
											
									?>
                                        <tr>
                                            <td><?php echo $j; ?></td>
                                            <td><?php echo $row_clicked['sku']; ?></td>
                                            <td><?php echo $row_clicked['product_type']; ?></td>
                                            <td><?php echo $row_clicked['most_clicked']; ?></td>
											<td><?php echo $row_clicked['type']; ?></td>
											<td><?php echo $pathArray[$pathArray_count]; ?></td>
											<td><?php echo $clicked_date; ?></td>
                                        </tr>
										<?php 
										$j++;
										} ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
            </div>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>

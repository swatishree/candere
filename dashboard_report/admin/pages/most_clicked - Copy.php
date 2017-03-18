<?php
// product type filter
require_once '../../../app/Mage.php';
umask(0);
Mage::app('default');

$is_live  = 0;
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
                        <!--<li>
                            <a href="report.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="chart.php"><i class="fa fa-bar-chart-o fa-fw"></i> Charts</a>
                        </li>-->
						<li>
                            <a href="most_clicked.php"><i class="fa fa-bar-chart-o fa-fw"></i> Most Clicked</a>
                            <!-- /.nav-second-level -->
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
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           &nbsp;
                        </div>
						<?php
						
							$sel_clicked = "select * from  product_most_clicked group by product_id order by most_clicked desc ";		
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
											
											// Load product
											//$productId = 2; // YOUR PRODUCT ID
											//$product = Mage::getModel('catalog/product')->load($row_clicked['product_id']);
											
											/*$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$row_clicked['sku']);

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

											}*/

											
											
											/*
											solution 1
											$path = $category->getPath();
											$ids = explode('/', $path);
											if (isset($ids[2])){
												$topParent = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($ids[2]);
											}
											else{
												$topParent = null;//it means you are in one catalog root.
											}
											
											echo "--top partent---".$topParent; */
											/*****************************/ 
											$categoryIds = $product->getCategoryIds();
											 
											$categories = Mage::getModel('catalog/category')
																->getCollection()
																->addAttributeToSelect("*")
																->addAttributeToFilter('entity_id', $categoryIds);
											 
											foreach ($categories as $category) {
												$category_path = $category->getName() . '<br>';
											}
											/*****************************/
											
											
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
											
									?>
                                        <tr>
                                            <td><?php echo $j; ?></td>
                                            <td><?php echo $row_clicked['sku']; ?></td>
                                            <td><?php echo $row_clicked['product_type']; ?></td>
                                            <td><?php echo $row_clicked['most_clicked']; ?></td>
											<td><?php echo $row_clicked['type']; ?></td>
											<td><?php echo $category_path; ?></td>
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

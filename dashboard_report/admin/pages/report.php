<?php

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

    <title>OMS Dashboard</title>

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
                            <!-- /.nav-second-level -->
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
                    <h1 class="page-header">Reports</h1>
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
			<script>
			/*	function chk_link(obj)
				{
					if(obj == 'Sales')
					{
						$('#div_sales').show();
						$('#div_cad').hide();
						$('#div_procurement').hide();
						$('#div_logistic').hide();
						$('#div_manufacturing').hide();
						$('#div_market').hide();
						$('#div_account').hide();
					}
					else if(obj == 'CAD')
					{
						$('#div_sales').hide();
						$('#div_cad').show();
						$('#div_procurement').hide();
						$('#div_logistic').hide();
						$('#div_manufacturing').hide();
						$('#div_market').hide();
						$('#div_account').hide();
					}
					else if(obj == 'Procurement')
					{
						$('#div_sales').hide();
						$('#div_cad').hide();
						$('#div_procurement').show();
						$('#div_logistic').hide();
						$('#div_manufacturing').hide();
						$('#div_market').hide();
						$('#div_account').hide();
					}
					else if(obj == 'Logistic')
					{
						$('#div_sales').hide();
						$('#div_cad').hide();
						$('#div_procurement').hide();
						$('#div_logistic').show();
						$('#div_manufacturing').hide();
						$('#div_market').hide();
						$('#div_account').hide();
					}
					else if(obj == 'Manufacturing')
					{
						$('#div_sales').hide();
						$('#div_cad').hide();
						$('#div_procurement').hide();
						$('#div_logistic').hide();
						$('#div_manufacturing').show();
						$('#div_market').hide();
						$('#div_account').hide();
					}
					else if(obj == 'Market')
					{
						$('#div_sales').hide();
						$('#div_cad').hide();
						$('#div_procurement').hide();
						$('#div_logistic').hide();
						$('#div_manufacturing').hide();
						$('#div_market').show();
						$('#div_account').hide();
					}
					else if(obj == 'Account')
					{
						$('#div_sales').hide();
						$('#div_cad').hide();
						$('#div_procurement').hide();
						$('#div_logistic').hide();
						$('#div_manufacturing').hide();
						$('#div_market').hide();
						$('#div_account').show();
					}
				} */
			</script>
            <div class="row">
				<!-- <div class="form-group" style="width:300px;">
					<select class="form-control" name="dept" id="dept" onchange="return chk_link(this.value);">
						<option value="Sales">Sales</option>
						<option value="CAD">CAD</option>
						<option value="Procurement">Procurement</option>
						<option value="Logistic">Logistic</option>
						<option value="Manufacturing">Manufacturing</option>
						<option value="Market">Market Place</option>
						<option value="Account">Account</option>
					</select>
				</div> -->
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_sales" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Sales
                        </div>
						<?php
			
							$sel_sales = "select * from erp_order where status in (1,2)";		
							$res_sales = mysql_query($sel_sales);
							
							$sel_cad = "select * from erp_order where status in (3,4,5,6,7,8)";		
							$res_cad = mysql_query($sel_cad);
							
							$sel_procurement = "select * from erp_order where status in (18,19,20,21,22)";		
							$res_procurement = mysql_query($sel_procurement);
							
							$sel_logistic = "select * from erp_order where status in (23)";		
							$res_logistic = mysql_query($sel_logistic);
							
							
							$sel_manufacturing = "select * from erp_order where status in (9,10,11,12,13,14,15,16,17)";		
							$res_manufacturing = mysql_query($sel_manufacturing);
							
							$sel_market_place = "select * from erp_order where status in (1,2)";		
							$res_market_place = mysql_query($sel_market_place);
							
							$sel_account = "select * from erp_order where status in (20)";		
							$res_account = mysql_query($sel_account);
						
						?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
											$j = 1;
											while($row_sales= mysql_fetch_assoc($res_sales))
											{
												
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_sales['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 1 ||  $row_order['order_status_id'] == 2):	
												
												$sel_sales_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_sales_status = mysql_query($sel_sales_status);
												$row_sales_status = mysql_fetch_assoc($res_sales_status);
												
												if($j%4 == 1)
													$apply_class = 'success';
												else if($j%4 == 2)
													$apply_class = 'info';
												else if($j%4 == 3)
													$apply_class = 'warning';
												else if($j%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $j; ?></td>
													<td><?php echo $row_sales['order_id']; ?></td>
													<td><?php echo $row_sales['sku']; ?></td>
													<td><?php echo $row_sales_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_sales['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_sales['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_sales['expected_delivery_date'])); ?></td>
												</tr>
											<?php 
												$j++;
												endif;
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
                <!-- /.col-lg-6 -->
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_cad" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            CAD
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
									
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$i = 1;
									while($row_cad = mysql_fetch_assoc($res_cad))
									{
										$sel_order = "select * from trnorderprocessing where order_id = '".$row_cad['order_id']."'  order by id desc limit 0,1";		
										$res_order = mysql_query($sel_order);
										$row_order = mysql_fetch_assoc($res_order); 
										if($row_order['order_status_id'] == 3 ||  $row_order['order_status_id'] == 4 || $row_order['order_status_id'] == 5 ||  $row_order['order_status_id'] == 6 || $row_order['order_status_id'] == 7 ||  $row_order['order_status_id'] == 8):
										
										$sel_cad_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
										$res_cad_status = mysql_query($sel_cad_status);
										$row_cad_status = mysql_fetch_assoc($res_cad_status);
										
										if($i%4 == 1)
											$apply_class = 'success';
										else if($i%4 == 2)
											$apply_class = 'info';
										else if($i%4 == 3)
											$apply_class = 'warning';
										else if($i%4 == 0)
											$apply_class = 'danger';
									?>
                                        <tr class="<?php echo $apply_class; ?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row_cad['order_id']; ?></td>
                                            <td><?php echo $row_cad['sku']; ?></td>
                                            <td><?php echo $row_cad_status['status_name']; ?></td>
											<td><?php echo date('d/m/Y', strtotime($row_cad['order_placed_date'])); ?></td>
											<td><?php echo date('d/m/Y', strtotime($row_cad['dispatch_date'])); ?></td>
											<td><?php echo date('d/m/Y', strtotime($row_cad['expected_delivery_date'])); ?></td>
                                        </tr>
									<?php $i++;
										endif;
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
                <!-- /.col-lg-6 -->
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_procurement" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Procurement
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
							
							
                                        <?php
											$k = 1;
											while($row_procurement = mysql_fetch_assoc($res_procurement))
											{
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_procurement['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 18 ||  $row_order['order_status_id'] == 19 || $row_order['order_status_id'] == 20 ||  $row_order['order_status_id'] == 21 || $row_order['order_status_id'] == 22):
												
												$sel_procurement_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_procurement_status = mysql_query($sel_procurement_status);
												$row_procurement_status = mysql_fetch_assoc($res_procurement_status);
												
												if($k%4 == 1)
													$apply_class = 'success';
												else if($k%4 == 2)
													$apply_class = 'info';
												else if($k%4 == 3)
													$apply_class = 'warning';
												else if($k%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $k; ?></td>
													<td><?php echo $row_procurement['order_id']; ?></td>
													<td><?php echo $row_procurement['sku']; ?></td>
													<td><?php echo $row_procurement_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_procurement['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_procurement['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_procurement['expected_delivery_date'])); ?></td>
												</tr>
											<?php $k++;
												endif;											
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
                <!-- /.col-lg-6 -->
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_logistic" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Logistic
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$l = 1;
											while($row_logistic = mysql_fetch_assoc($res_logistic))
											{
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_logistic['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 23):
												
												$sel_logistic_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_logistic_status = mysql_query($sel_logistic_status);
												$row_logistic_status = mysql_fetch_assoc($res_logistic_status);
												
												if($l%4 == 1)
													$apply_class = 'success';
												else if($l%4 == 2)
													$apply_class = 'info';
												else if($l%4 == 3)
													$apply_class = 'warning';
												else if($l%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $l; ?></td>
													<td><?php echo $row_logistic['order_id']; ?></td>
													<td><?php echo $row_logistic['sku']; ?></td>
													<td><?php echo $row_logistic_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_logistic['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_logistic['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_logistic['expected_delivery_date'])); ?></td>
												</tr>
											<?php  $l++;
												endif;											
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
                <!-- /.col-lg-6 --> 
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_manufacturing" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manufacturing
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$m = 1;
											while($row_manufacturing = mysql_fetch_assoc($res_manufacturing))
											{	
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_manufacturing['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 9 ||  $row_order['order_status_id'] == 10 || $row_order['order_status_id'] == 11 ||  $row_order['order_status_id'] == 12 || $row_order['order_status_id'] == 13 ||  $row_order['order_status_id'] == 14 || $row_order['order_status_id'] == 15 ||  $row_order['order_status_id'] == 16 || $row_order['order_status_id'] == 17):
												
												$sel_manufacturing_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_manufacturing_status = mysql_query($sel_manufacturing_status);
												$row_manufacturing_status = mysql_fetch_assoc($res_manufacturing_status);
												
												if($m%4 == 1)
													$apply_class = 'success';
												else if($m%4 == 2)
													$apply_class = 'info';
												else if($m%4 == 3)
													$apply_class = 'warning';
												else if($m%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $m; ?></td>
													<td><?php echo $row_manufacturing['order_id']; ?></td>
													<td><?php echo $row_manufacturing['sku']; ?></td>
													<td><?php echo $row_manufacturing_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_manufacturing['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_manufacturing['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_manufacturing['expected_delivery_date'])); ?></td>
												</tr>
											<?php  $m++;
												endif;											
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
                <!-- /.col-lg-6 -->
				
				<!-- /.col-lg-6 -->
                <div class="col-lg-6" id="div_market" style="display:show;"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Market Place
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$n = 1;
											while($row_market_place = mysql_fetch_assoc($res_market_place))
											{
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_market_place['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 1 ||  $row_order['order_status_id'] == 2):
												
												$sel_market_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_market_status = mysql_query($sel_market_status);
												$row_market_status = mysql_fetch_assoc($res_market_status);
												
												if($n%4 == 1)
													$apply_class = 'success';
												else if($n%4 == 2)
													$apply_class = 'info';
												else if($n%4 == 3)
													$apply_class = 'warning';
												else if($n%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $n; ?></td>
													<td><?php echo $row_market_place['order_id']; ?></td>
													<td><?php echo $row_market_place['sku']; ?></td>
													<td><?php echo $row_market_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_market_place['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_market_place['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_market_place['expected_delivery_date'])); ?></td>
												</tr>
											<?php  $n++;
												endif;											
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
                <div class="col-lg-6" id="div_account" style="display:show;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Account
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id</th>
                                            <th>SKU</th>
                                            <th>Status</th>
											<th>Order Date</th>
											<th>Dispatch Date</th>
											<th>Exp Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$o = 1;
											while($row_account = mysql_fetch_assoc($res_account))
											{
												
												$sel_order = "select * from trnorderprocessing where order_id = '".$row_account['order_id']."'  order by id desc limit 0,1";		
												$res_order = mysql_query($sel_order);
												$row_order = mysql_fetch_assoc($res_order);
												if($row_order['order_status_id'] == 20):
												
												$sel_account_status = "select * from mststatus where sequence = '".$row_order['order_status_id']."'";		
												$res_account_status = mysql_query($sel_account_status);
												$row_account_status = mysql_fetch_assoc($res_account_status);
												
												if($o%4 == 1)
													$apply_class = 'success';
												else if($o%4 == 2)
													$apply_class = 'info';
												else if($o%4 == 3)
													$apply_class = 'warning';
												else if($o%4 == 0)
													$apply_class = 'danger';
											?>
												<tr class="<?php echo $apply_class; ?>">
													<td><?php echo $o; ?></td>
													<td><?php echo $row_account['order_id']; ?></td>
													<td><?php echo $row_account['sku']; ?></td>
													<td><?php echo $row_account_status['status_name']; ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_account['order_placed_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_account['dispatch_date'])); ?></td>
													<td><?php echo date('d/m/Y', strtotime($row_account['expected_delivery_date'])); ?></td>
												</tr>
											<?php  $o++;
												endif;											
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
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
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

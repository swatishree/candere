<?php

require_once '../../../app/Mage.php';
umask(0);
Mage::app('default');

$is_live  = 1;
if($is_live == 1)
{
	$link = mysql_connect('localhost', 'candere_new', '');
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

    <title>Chart</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php
	
	$sel_order_confirmation_pending =	 "select * from trnorderprocessing where order_status_id = 1";		
	$res_order_confirmation_pending =	 mysql_query($sel_order_confirmation_pending);
	$num_order_confirmation_pending	=	 mysql_num_rows($res_order_confirmation_pending);
    
	$sel_sent_4_manufacturing	 = 	"select * from trnorderprocessing where order_status_id = 9";
	$res_sent_4_manufacturing	 = 	 mysql_query($sel_sent_4_manufacturing);
	$num_sent_4_manufacturing	 =	 mysql_num_rows($res_sent_4_manufacturing);
	
	$sel_quality_check = 	"select * from trnorderprocessing where order_status_id = 17";		
	$res_quality_check = 	mysql_query($sel_quality_check);
	$num_quality_check =	mysql_num_rows($res_quality_check);
	
	$sel_packaging =	 "select * from trnorderprocessing where order_status_id = 21";		
	$res_packaging =	 mysql_query($sel_packaging);
	$num_packaging =	 mysql_num_rows($res_packaging);

?>
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
                    <h1 class="page-header">Pie Chart</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <!-- /.col-lg-12 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Product Status
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

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

    <!-- Flot Charts JavaScript -->
    <script src="../vendor/flot/excanvas.min.js"></script>
    <script src="../vendor/flot/jquery.flot.js"></script>
    <script src="../vendor/flot/jquery.flot.pie.js"></script>
    <script src="../vendor/flot/jquery.flot.resize.js"></script>
    <script src="../vendor/flot/jquery.flot.time.js"></script>
    <script src="../vendor/flot-tooltip/jquery.flot.tooltip.min.js"></script>
    <script src="../data/flot-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

	<script>
		//Flot Pie Chart
		$(function() {

			var data = [{
				label: "Order Confirmation Pending",
				data: <?php echo $num_order_confirmation_pending; ?>
			}, {
				label: "Sent for manufacturing",
				data: <?php echo $num_sent_4_manufacturing; ?>
			}, {
				label: "Quality check",
				data: <?php echo $num_quality_check; ?>
			}, {
				label: "Packaging",
				data: <?php echo $num_packaging; ?>
			}];

			var plotObj = $.plot($("#flot-pie-chart"), data, {
				series: {
					pie: {
						show: true
					}
				},
				grid: {
					hoverable: true
				},
				tooltip: true,
				tooltipOpts: {
					content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
					shifts: {
						x: 20,
						y: 0
					},
					defaultTheme: false
				}
			});

		});
	</script>
</body>

</html>

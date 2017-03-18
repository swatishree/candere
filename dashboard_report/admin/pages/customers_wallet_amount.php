<?php
	require '../../../app/Mage.php';
    umask(0);
    Mage::app();
    set_time_limit(0);
	
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
	
	$err_msg = '';
	$succ_msg = '';
	if(isset($_POST['sbmt']))
	{
		$orderIncrementId = $_POST['wallet_amount_added'];
		$order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId); // sales_flat_order
		//echo "sql==".$order->getSelect();
		$order_id		 = $order->getId(); 
		
		if($order_id > 0)
		{
			$shippingAddress = $order->getShippingAddress();
			
			$order_id		 = $order->getId();
			$order_no 		 = $orderIncrementId;
			$customer_id 	 = $shippingAddress->getCustomerId();
			if($customer_id == '')
				$customer_id 		 = $order->getCustomerId();
			$total_refunded  = $order->getTotalRefunded();
			$updated_at 	 = $order->getUpdated_at();
			
			$read = Mage::getSingleton('core/resource')->getConnection('core_read');
			
			$sql_read = 'select count(*) as cnt from my_wallet where order_no="'.$order_no.'"';
			$res_read =  $read->fetchAll($sql_read);			
			$cnt_read = $res_read[0]['cnt'];
			
			if($cnt_read > 0)
			{
				$err_msg = 'Order nos amount is already added in wallet';
			}
			else
			{
				$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
				$sql = "INSERT INTO `my_wallet` (`order_id`,`order_no`,`customer_id`,`refundable_amount`,`reason`,`refunded_date`,`payment_status`) VALUES ('".$order_id."','".$order_no."','".$customer_id."','".$total_refunded."','Balance Amount','".$updated_at."','success')";
				if($connection->query($sql))
					$succ_msg = 'Amount added successfully';
				else
					$err_msg = 'Error while adding amount in wallet.';
			}
		}
		else
		{
			$err_msg = 'Invalid order no.';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MyWallet</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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
<script type="text/javascript">

	function check_validation()
	{ 
		var wallet_amount_added = document.getElementById('wallet_amount_added').value;
		document.getElementById('div_error').value = '';
		if(wallet_amount_added == '')
		{
			document.getElementById('div_error').innerHTML = 'Please enter wallet amount';
			return false;
		}
		else
		{
			return true;
		}
	}
	
//]]>
</script>
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
                    <h1 class="page-header">MyWallet</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form name="frm_wallet" id="frm_wallet" action="<?php //echo $checkout_link; ?>" method="post" role="form"> 
                                        <div class="form-group">
											<span id="div_success" style="color:green"><?php if($succ_msg != '') echo $succ_msg; else echo $succ_msg; ?></span><br>
                                            <label>Enter Order no. to add remaining amount in Wallet</label>
											<input type="text" name="wallet_amount_added" id="wallet_amount_added" value="" class="form-control">
                                           <span id="div_error" style="color:<?php if($err_msg != '') echo "red"; else echo "red"; ?>"><?php if($err_msg != '') echo $err_msg; else echo $err_msg; ?></span>
                                        </div>
                                        <button type="submit" class="btn btn-default" name="sbmt" id="sbmt" onclick="return check_validation();">Submit Button</button>
                                        <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
					 <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
											<td>#</td>
                                            <th>Order No</th>
                                            <th>Refundable Amount (Rs)</th>
                                            <th>Used Amount (Rs)</th>
											<th>Added Amount (Rs)</th>
											<th>Date</th>
											<th>Customer Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
										$j = 1;
										$sql = 'select * from my_wallet where payment_status = "success" order by refunded_date desc';
										$res =  mysql_query($sql);
										while($row= mysql_fetch_assoc($res))
										{											
											$customerData   = Mage::getModel('customer/customer')->load($row['customer_id'])->getData();
											$email 			= $customerData['email'];
									?>
                                        <tr>
                                            <td><?php echo $j; ?></td>
                                            <td><?php echo $row['order_no']; ?></td>
                                            <td><?php echo $row['refundable_amount']; ?></td>
                                            <td><?php echo $row['is_used']; ?></td>
											<td><?php echo $row['added_amount']; ?></td>
											<td><?php echo date('d/m/Y',strtotime($row['refunded_date'])); ?></td>
											<td><?php echo $email; ?></td>
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
                <!-- /.col-lg-12 -->
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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

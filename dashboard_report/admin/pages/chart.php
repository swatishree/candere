<?php

require_once '../../../app/Mage.php';
umask(0);
Mage::app('default');
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
	$con = mysql_connect("localhost", "root", "");  
    $selectdb = mysql_select_db("candere_new",$con);  
	$OrderConfirmationPending =	 "select * from trnorderprocessing where order_status_id = 1";		
	$resultOrderConfirmationPending =	 mysql_query($OrderConfirmationPending);
	$numOrderConfirmationPending	=	 mysql_num_rows($resultOrderConfirmationPending);

    $OrderConfirmed =    "select * from trnorderprocessing where order_status_id = 2";      
    $resOrderConfirmed =    mysql_query($OrderConfirmed);
    $numOrderConfirmed =    mysql_num_rows($resOrderConfirmed);

	$OrderSentForProcessing	 = 	"select * from trnorderprocessing where order_status_id = 3";
	$resOrderSentForProcessing	 = 	 mysql_query($OrderSentForProcessing);
	$numOrderSentForProcessing	 =	 mysql_num_rows($resOrderSentForProcessing);
	
	$LiquidMouldSent = 	"select * from trnorderprocessing where order_status_id = 4";		
	$resLiquidMouldSent = 	mysql_query($LiquidMouldSent);
	$numLiquidMouldSent =	mysql_num_rows($resLiquidMouldSent);
	
	$LiquidMouldReceived =	 "select * from trnorderprocessing where order_status_id = 5";		
	$resLiquidMouldReceived =	 mysql_query($LiquidMouldReceived);
	$numLiquidMouldReceived =	 mysql_num_rows($resLiquidMouldReceived);

    $MouldReady =    "select * from trnorderprocessing where order_status_id = 6";      
    $resMouldReady =    mysql_query($MouldReady);
    $numMouldReady =    mysql_num_rows($resMouldReady);

    $RptWaxPcReceived =    "select * from trnorderprocessing where order_status_id = 7";      
    $resRptWaxPcReceived =    mysql_query($RptWaxPcReceived);
    $numRptWaxPcReceived =    mysql_num_rows($resRptWaxPcReceived);

    $RPTWaxPcSent    =  "select * from trnorderprocessing where order_status_id = 8";
    $resRPTWaxPcSent    =   mysql_query($RPTWaxPcSent);
    $numRPTWaxPcSent    =   mysql_num_rows($resRPTWaxPcSent);
    
    $SentFormanufacturing =    "select * from trnorderprocessing where order_status_id = 9";      
    $resSentFormanufacturing =    mysql_query($SentFormanufacturing);
    $numSentFormanufacturing =    mysql_num_rows($resSentFormanufacturing);
    
    $Castingsent =     "select * from trnorderprocessing where order_status_id = 10";     
    $resCastingsent =     mysql_query($Castingsent);
    $numCastingsent =     mysql_num_rows($resCastingsent);

    $CastingReceived =    "select * from trnorderprocessing where order_status_id = 11";      
    $resCastingReceived =    mysql_query($CastingReceived);
    $numCastingReceived =    mysql_num_rows($resCastingReceived);

    $DiamondGemstoneRequestSent =    "select * from trnorderprocessing where order_status_id = 12";      
    $resDiamondGemstoneRequestSent =    mysql_query($DiamondGemstoneRequestSent);
    $numDiamondGemstoneRequestSent =    mysql_num_rows($resDiamondGemstoneRequestSent);

    $DiamondGemstoneReceived =     "select * from trnorderprocessing where order_status_id = 13";     
    $resDiamondGemstoneReceived =     mysql_query($DiamondGemstoneReceived);
    $numDiamondGemstoneReceived =     mysql_num_rows($resDiamondGemstoneReceived);

    $ProductRequestSent    =  "select * from trnorderprocessing where order_status_id =14";
    $resProductRequestSent    =   mysql_query($ProductRequestSent);
    $numProductRequestSent    =   mysql_num_rows($resProductRequestSent);
    
    $Setting =    "select * from trnorderprocessing where order_status_id = 15";      
    $resSetting =    mysql_query($Setting);
    $numSetting =    mysql_num_rows($resSetting);
    
    $Filing =    "select * from trnorderprocessing where order_status_id = 16";      
    $resFiling =    mysql_query($Filing);
    $numFiling =    mysql_num_rows($resFiling);

    $QualityCheck =    "select * from trnorderprocessing where order_status_id = 17";      
    $resQualityCheck =    mysql_query($QualityCheck);
    $numQualityCheck =    mysql_num_rows($resQualityCheck);

    $FinalProductReceived    =  "select * from trnorderprocessing where order_status_id = 18";
    $resFinalProductReceived    =   mysql_query($FinalProductReceived);
    $numFinalProductReceived    =   mysql_num_rows($resFinalProductReceived);
    
    $Certification =    "select * from trnorderprocessing where order_status_id = 19";      
    $resCertification =    mysql_query($Certification);
    $numCertification =    mysql_num_rows($resCertification);

    $Invoicing    =  "select * from trnorderprocessing where order_status_id = 20";
    $resInvoicing    =   mysql_query($Invoicing);
    $numInvoicing    =   mysql_num_rows($resInvoicing);
    
    $Packaging =     "select * from trnorderprocessing where order_status_id = 21";     
    $resPackaging =     mysql_query($Packaging);
    $numPackaging =     mysql_num_rows($resPackaging);

    $ReadyToShip =    "select * from trnorderprocessing where order_status_id = 22";      
    $resReadyToShip =    mysql_query($ReadyToShip);
    $numReadyToShip =    mysql_num_rows($resReadyToShip);

    $ProductShipped =    "select * from trnorderprocessing where order_status_id = 23";      
    $resProductShipped =    mysql_query($ProductShipped);
    $numProductShipped =    mysql_num_rows($resProductShipped);
    
    $ProductDelivered =    "select * from trnorderprocessing where order_status_id = 24";      
    $resProductDelivered =    mysql_query($ProductDelivered);
    $numProductDelivered =    mysql_num_rows($resProductDelivered);
    
    $Cancelled =     "select * from trnorderprocessing where order_status_id = 25";     
    $resCancelled =     mysql_query($Cancelled);
    $numCancelled =     mysql_num_rows($resCancelled);

    $Polishing =    "select * from trnorderprocessing where order_status_id = 26";      
    $resPolishing =    mysql_query($Polishing);
    $numPolishing =    mysql_num_rows($resPolishing);
    
    $Rhodium =     "select * from trnorderprocessing where order_status_id = 27";     
    $resRhodium =     mysql_query($Rhodium);
    $numRhodium =     mysql_num_rows($resRhodium);
?>
<script type="text/javascript">
var numOrderConfirmationPending = "<?= $numOrderConfirmationPending ?>";
var numOrderConfirmed = "<?= $numOrderConfirmed ?>";
var numOrderSentForProcessing = "<?= $numOrderSentForProcessing ?>";
var numLiquidMouldSent = "<?= $numLiquidMouldSent ?>";
var numLiquidMouldReceived = "<?= $numLiquidMouldReceived ?>";
var numMouldReady = "<?= $numMouldReady ?>";
var numRptWaxPcReceived = "<?= $numRptWaxPcReceived ?>";
var numnumRPTWaxPcSent = "<?= $numnumRPTWaxPcSent ?>";
var numSentFormanufacturing = "<?= $numSentFormanufacturing ?>";
var numCastingsent = "<?= $numCastingsent ?>";
var numCastingReceived = "<?= $numCastingReceived ?>";
var numDiamondGemstoneRequestSent = "<?= $numDiamondGemstoneRequestSent ?>";
var numDiamondGemstoneReceived = "<?= $numDiamondGemstoneReceived ?>";
var numProductRequestSent = "<?= $numProductRequestSent ?>";
var numSetting = "<?= $numSetting ?>";
var numFiling = "<?= $numFiling ?>";
var numQualityCheck = "<?= $numQualityCheck ?>";
var numFinalProductReceived = "<?= $numFinalProductReceived ?>";
var numCertification = "<?= $numCertification ?>";
var numInvoicing = "<?= $numInvoicing ?>";
var numPackaging = "<?= $numPackaging ?>";
var numReadyToShip = "<?= $numReadyToShip ?>";
var numProductShipped = "<?= $numProductShipped ?>";
var numProductDelivered = "<?= $numProductDelivered ?>";
var numCancelled = "<?= $numCancelled ?>";
var numPolishing = "<?= $numPolishing ?>";
var numRhodium = "<?= $numRhodium ?>";

</script>   
<body>
		
    <div id="wrapper">

        <div>
            <div class="row">
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Pie Chart</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <!-- /.col-lg-12 -->
                <div class="col-lg-6">
                    <div>
                        <!-- <div class="panel-heading">
                            Product Status
                        </div> -->
                        
                        <!-- /.panel-heading -->
                        <div class="padding panel-body {" style="margin: -4px -363px 41px -175px;">
                           <div class="flot-chart" style="margin: 0 0 0 350px;">
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


</body>

</html>

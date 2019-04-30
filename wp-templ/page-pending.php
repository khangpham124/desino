<?php /* Template Name: Pengding */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php");
if(!$_COOKIE['order_des']) {    
    header('Location:'.APP_URL);
    die();
}
setcookie('incart','', time() + 86400, "/");
setcookie('order_cookies','', time() + 86400, "/");
setcookie('order_des','', time() + 86400, "/");
?>
<!-- <meta http-equiv="REFRESH" content="5; url=<?php echo APP_URL; ?>"> -->
</head>
<body id="store" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
        <h2 class="h3_page">Thank you! Your payment order is invalid.</h2>
        <p>Please feel free to contact us by email order.desino@gmail.com, if you require any further information.</p>
        
	</div>
      
<!-- container -->
<!--Footer-->
<?php include(TEMPLATEPATH."/libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
	

</body>
</html>	
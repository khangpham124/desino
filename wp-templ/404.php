<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
?>
<meta http-equiv="REFRESH" content="3; url=<?php echo APP_URL; ?>">
</head>

<body id="top">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(TEMPLATEPATH."/libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent">
		<p class="txt404">Sorry ! Page not found</p>
    </div>
	

	
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
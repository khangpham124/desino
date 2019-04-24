<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."libs/header.php"); 
?>
<meta http-equiv="REFRESH" content="3; url=<?php echo esc_url( home_url( '/' ) )?>">
</head>

<body id="top">
<?php include(APP_PATH."libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(APP_PATH."libs/sidebar.php"); ?>
	<div id="mainContent" class="pc">
		<p class="txt404">Sorry ! Page not found</p>
    </div>
	

	
</div>
<!-- container -->


<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
<script>
	$(function() {
 	var h = $( window ).height();
    var h_elm = $('#wrapper').height();
    var pad = ( h - h_elm ) / 2;
    $('#wrapper').css('padding-top',pad + 'px');
	$(window).resize(function(){	
	var h = $( window ).height();
    var h_elm = $('#wrapper').height();
    var pad = ( h - h_elm ) / 2;
    $('#wrapper').css('padding-top',pad + 'px');
	});
	});
</script>


</body>
</html>	
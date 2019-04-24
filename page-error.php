<?php /* Template Name: Account */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."admin/wp-load.php"); 
include(APP_PATH."libs/header.php"); 
?>
</head>

<body id="men" class="subPage">
<?php include(APP_PATH."libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(APP_PATH."libs/sidebar.php"); ?>
	<div id="mainContent">
	<section class="maxW maxW--small">
    <?php if(!$_COOKIE['username']) {  ?>
        <div class="flexBox">
            <div class="leftAcc">
                <h3 class="h3_page">Login</h3>
                
            </div>
            <div class="rightAcc">
                <h3 class="h3_page">Sign up</h3>
            </div>
        </div>

	<?php } else { ?>
        <h3 class="h3_page">Account Information</h3>
    <?php } ?>
    </section>

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

<script type="text/javascript">
$(function(){
	$('.lstProdMen li').biggerlink();
});
</script>
</body>
</html>	
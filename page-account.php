<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
$action = $_GET['action'];
?>
</head>

<?php 
if($action=='signup') {
    $reg_fullname = $_POST['fullname'];
    $reg_mobile = $_POST['mobile'];
    $reg_mail = $_POST['mail'];
    $reg_url = $_POST['url'];
    $reg_pass = md5($_POST['password']);
    $order_post = array(
        'post_title'    => $reg_mail,
        'post_status'   => 'publish',
        'post_type' => 'customer'
        );
    $pid = wp_insert_post($order_post);
    add_post_meta($pid, 'fullname', $reg_fullname);
    add_post_meta($pid, 'mobile', $reg_mobile);
    add_post_meta($pid, 'password', $reg_pass);

    
    $_SESSION['fullname'] = $reg_fullname;
    $_SESSION['phone'] = $reg_phone;
    $_SESSION['mail'] = $reg_mail;
    $_SESSION['idcustomer'] = $pid;
    $_SESSION['login'] = $reg_mail;
    header("Location: ".$reg_url);
}

if($action=='login') {
    $reg_mail = $_POST['mail'];
    $reg_pass = md5($_POST['password']);
    $reg_url = $_POST['url'];
    
    $arr_user = array();
	$wp_query = new WP_Query();
	$param = array (
	's' => $reg_mail,	
	'posts_per_page' => '-1',
	'post_type' => 'customer',
    'post_status' => 'publish',
	);
	$wp_query->query($param);
	$numb_result = count($wp_query->query($param));
	if($numb_result > 0) {
		while($wp_query->have_posts()) :$wp_query->the_post();
			$username = $post->post_title;
			$fullname = get_field('fullname');
            $pass_real = get_field('password');

			if($pass_real==$reg_pass) {
                $_SESSION['fullname'] = $reg_fullname;
                $_SESSION['phone'] = $reg_phone;
                $_SESSION['mail'] = $reg_mail;
                $_SESSION['idcustomer'] = $post->ID;
                $_SESSION['login'] = $reg_mail;
				header('Location:'.$reg_url);
			}
			else {
				header('Location:'.APP_URL.'error');
			}
		endwhile;
	} else {
		header('Location:'.APP_URL.'error');
	}
}
?>

<body id="men" class="subPage">
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
	<section class="maxW maxW--small">
    <?php if(!$_COOKIE['username']) {  ?>
        <div class="flexBox">
            
        </div>

	<?php } else { ?>
        <h3 class="h3_page">Account Information</h3>
    <?php } ?>
    </section>

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

<script type="text/javascript">
$(function(){
	$('.lstProdMen li').biggerlink();
});
</script>
</body>
</html>	
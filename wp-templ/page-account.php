<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_SESSION['login']) {    
    header('Location:'.APP_URL);
}
include(TEMPLATEPATH."/libs/header.php"); 
$action = $_GET['action'];
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>checkform/exvalidation.css" media="all">
</head>

<?php 
if($action=='signup') {
    $reg_fullname = $_POST['fullname'];
    $reg_mobile = $_POST['mobile'];
    $reg_mail = $_POST['mail'];
    $reg_url = $_POST['url'];
    $reg_pass = md5($_POST['password']);

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
        $_SESSION['err_mess'] = 'Account already exists';
        header('Location:'.APP_URL.'error');
        
    } else {
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
        unset($_SESSION['err_mess']);
        header("Location: ".$reg_url);
    }
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
            $mobile = get_field('mobile');
            $address = get_field('address');

			if($pass_real==$reg_pass) {
                $_SESSION['fullname'] = $fullname;
                $_SESSION['mobile'] = $mobile;
                $_SESSION['mail'] = $reg_mail;
                $_SESSION['address'] = $address;
                $_SESSION['idcustomer'] = $post->ID;
                $_SESSION['login'] = $reg_mail;
				header('Location:'.$reg_url);
			}
			else {
                $_SESSION['err_mess'] = 'Login Fail';
				header('Location:'.APP_URL.'error');
			}
		endwhile;
	} else {
		header('Location:'.APP_URL.'error');
	}
}
?>

<body id="account" class="subPage">
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
            <h3 class="h3_page">Account Information</h3>
            <ul class="tabItem tabItem--4 flexBox flexBox--center flexBox--wrap">
                <li><a href="javascript:void(0)"  data-id="tab1">Personal Information</a></li>
                <li><a href="javascript:void(0)"  data-id="tab2">My Order</a></li>
                <li><a href="javascript:void(0)"  data-id="tab3">My Wishlist</a></li>
                <li><a href="javascript:void(0)"  data-id="tab4">My Design (Coming soon)</a></li>
            </ul>
            <div class="tabContent">
                <div class="tabBox" id="tab1">
                <form action="<?php echo APP_URL; ?>ajax/editCustomer.php" class="formChk" method="post" id="formAccount" autocomplete="off">
                    <p class="inputForm">
                        <label>Full name</label>
                        <input type="text" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" id="fullname_acc" class="inputText">
                    </p>
                    <p class="inputForm">
                        <label>Phone</label>
                        <input type="text" name="mobile" value="<?php echo $_SESSION['mobile']; ?>" id="mobile_acc"  class="inputText">
                    </p>
                    <p class="inputForm">
                        <label>E-mail</label>
                        <input type="mail" readonly name="mail" value="<?php echo $_SESSION['mail']; ?>" id="mail_acc" class="inputText">
                    </p>
                    <p class="inputForm">
                        <label>Address</label>
                        <input type="mail" name="address" value="<?php echo get_field('address',$_SESSION['idcustomer']); ?>" id="address_acc" class="inputText">
                    </p>
                    <input type="hidden" name="url" value="<?php echo $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" >
                    <input type="submit" name="submit" class="btnPage" value="Update">
                </form>  

                <form action="<?php echo APP_URL; ?>ajax/editCustomer.php" class="formChk" method="post" id="formChange" autocomplete="off">  
                    <h4 class="h4_page">CHANGE PASSWORD</h4>
                    <p class="inputForm">
                        <label>Old Password<span>(*)</span></label>
                        <input type="password" name="old_password" value="" autocomplete="off" id="old_password" class="inputText">
                    </p>
                    <p class="messErr"><?php echo $_COOKIE['err_change']; ?></p>
                    <p class="inputForm">
                        <label>New Password</label>
                        <input type="password" name="password" value="" autocomplete="off" id="pass_acc" class="inputText">
                    </p>
                    <input type="hidden" name="url" value="<?php echo $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" >
                    <input type="submit" name="submit" class="btnPage" value="CHANGE">
                </form>      
                        
                </div>
                <div class="tabBox" id="tab2">
                    <table class="tblAccount">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Date</td>
                                <td>Price</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $wp_query = new WP_Query();
                            $param = array (
                            'posts_per_page' => '-1',
                            'post_type' => 'getorder',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'meta_query' => array(
                                array(
                                'key' => 'idcustomer',
                                'value' => $_SESSION['idcustomer'],
                                'compare' => '='
                                ))
                            );
                            $wp_query->query($param);
                            if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
                            ?>
                            <tr>
                                <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></td>
                                <td><?php the_time('d/m/Y'); ?></td>
                                <td><?php echo number_format(get_field('cf_total')); ?> VND</td>
                                <td><?php echo get_field('cf_order_status'); ?></td>
                            </tr>
                            <?php endwhile;endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tabBox" id="tab3">
                <div class="boxCart">
					<ul class="lstCart">
					<?php
                        $arr_ids = array();
                        $arr_colors = array();
                        $wish = get_field('wishlist',$_SESSION['idcustomer']);
                        $c_wish = count($wish);
                        for($i=0;$i<$c_wish;$i++) {
                            $arr_ids[]= $wish[$i]['id'];
                            $arr_colors[]= $wish[$i]['color'];
                        }

                        $i=0;
                        // var_dump($arr_ids);
                        $wp_query = new WP_Query();
                        $param = array(
                        'post_type' => 'product',
                        'orderby' => 'post__in', 
                        'post__in'=> $arr_ids
                        );
            
                        $wp_query->query($param);
                        if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();

                        $getImg = get_field('image_product');
                        $key_img = $arr_colors[$i] - 1;
                        $thumb = $getImg[$key_img]['slide'][0]['img'];

                        $img_label = wp_get_attachment_image_src($thumb,'full');

                        $promo = get_field('special-offer');
                        if($promo!=0) {
                            $price_real = get_field('price');
                            $price_dis = ($price_real * $promo) / 100;
                            $price = $price_real - $price_dis;
                        } else {
                            $price = get_field('price');
                        }
                        $i++;
					?>
						<li class="flexBox flexBox--nosp">
							<p class="thumb"><img src="<?php echo thumbCrop($img_label[0],140,140); ?>" class="" alt="<?php echo $post->post_title; ?>"></p>	
							<div class="info">
								<p class="name"><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></p>
								<table>
									<tr>
										<th>PRICE</th>
										<td><?php if($promo!=0) { ?><em><?php echo $price_real; ?>€</em><?php } ?><?php echo number_format($price); ?> VND</td>
									</tr>
								</table>
								<a href="javascript:void(0)" class="btnRemove removeList btnPage" data-id="<?php echo $post->ID; ?>">REMOVE</a>
							</div>
						</li>
						<?php endwhile;endif; ?>
					</ul>
				</div>      
                </div>
                <div class="tabBox" id="tab4"></div>
            </div>    

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
<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exvalidation.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>checkform/exchecker-ja.js"></script>
<script>
$(function(){
    $('#old_password').removeClass('chkrequired errPosRight err');
	  $("#formAccount").exValidation({
	    rules: {
            old_password: "chkrequired",
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
      });
    

    $('input[type=password][name=password]').keyup(function() {
        if (this.value != '') {
            $('#old_password').addClass('chkrequired errPosRight err');
        } else {
            $('#old_password').removeClass('chkrequired errPosRight err');
        }
    });
});
</script>

<script type="text/javascript">
$(function(){
	$('#tab1').show();
    $('.tabItem li:nth-child(1)').addClass('active');
    $('.tabItem li').click(function() {
        $('.tabItem li').removeClass('active');
        $(this).toggleClass('active');
        var tabId = $(this).find('a').attr('data-id');
        $('.tabBox').fadeOut(200);
        $('#'+tabId).fadeIn(200);
    });
});
</script>

</body>
</html>	
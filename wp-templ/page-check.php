<?php /* Template Name: Check */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_SESSION['login']) {    
    header('Location:'.APP_URL);
}
include(TEMPLATEPATH."/libs/header.php"); 
$order = $_POST['orderNo'];
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>checkform/exvalidation.css" media="all">
</head>
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
        <form action="" class="formChk" method="post" id="formCheckOrder">
            <h3 class="h3_checkout">ORDER ID</h3>				
            <p class="inputForm">
                <label>Your Order ID<span>(*)</span></label>
                <input type="text" name="orderNo" value="" id="orderid_chk" class="inputText">
            </p>
            <button class="btnPage">CHECK</button>
        </form>
        <?php
        if($order) {
        $wp_query = new WP_Query();
        $param = array (
        's' => $order,	
        'posts_per_page' => '1',
        'post_type' => 'getorder',
        'post_status' => 'publish',
        );
        $wp_query->query($param);
        if($wp_query->have_posts()) { ?>
        <?php while($wp_query->have_posts()) : $wp_query->the_post();?>
            <h3 class="h3_page">Order Detail</h3>
            <table class="tblAccount">
                <tr>
                    <th>Order ID</th>
                    <td><?php the_title(); ?></td>
                </tr>
                <tr>
                    <th>Date of order</th>
                    <td><?php the_time('d/m/Y'); ?></td>
                </tr>
                <tr>
                    <th>Shipping Info</th>
                    <td>
                        <?php the_field('cf_fullname'); ?><br>
                        <?php the_field('cf_address'); ?><br>
                        <?php the_field('cf_phone'); ?><br>
                        <?php the_field('cf_mail'); ?><br>
                    </td>
                </tr>

                <tr>
                    <th>Products</th>
                    <td>
                        <?php 
                        $l_Order = get_field('order_list');
                        $arr_ids = array();
                        $arr_qty = array();
                        
                        $numb_order = count($l_Order);
                        
                        for($i=0;$i<=$numb_order;$i++) {
                            $arr_ids[] = $l_Order[$i]['cf_id'];
                            $arr_qty[] = $l_Order[$i]['cf_quantity'];
                        }
                        ?>
                        <ul class="lstCart">
                            <?php
                            $i=0;
                                    $param = array (
                                        'posts_per_page' => '-1',
                                        'post_type' => 'product', 
                                        'post_status' => 'publish',
                                        'order' => 'DESC',
                                        'post__in'=> $arr_ids
                                        );
                                        $posts_array = get_posts( $param );
                                        foreach ($posts_array as $pro ) {
                                    $thumb = get_post_thumbnail_id($pro->ID);
                                    $img_label = wp_get_attachment_image_src($thumb,'full');
                                    $promo = get_field('special-offer',$pro->ID);
                                    if($promo!=0) {
                                        $price_real = get_field('price',$pro->ID);
                                        $price_dis = ($price_real * $promo) / 100;
                                        $price = $price_real - $price_dis;
                                    } else {
                                        $price = get_field('price',$pro->ID);
                                    }
                            ?>
                                <li class="flexBox flexBox--nosp">
                                    <p class="thumb"><img src="<?php echo thumbCrop($img_label[0],140,140); ?>" class="" alt="<?php echo $pro->post_title; ?>"></p>	
                                    <div class="info">
                                        <p class="name"><a href="<?php the_permalink(); ?>"><?php echo $pro->post_title; ?></a></p>
                                        <table>
                                            <tr>
                                                <th>QTY</th>
                                                <td class="qtyNumb"><?php echo $arr_qty[$i]; ?></td>
                                            </tr>
                                            <tr>
                                                <th>PRICE</th>
                                                <td><?php if($promo!=0) { ?><em><?php echo $price_real; ?></em><?php } ?><?php echo number_format($price); ?> VND</td>
                                            </tr>
                                            <tr>
                                                <th class="totalCost">SUB TOTAL</th>
                                                <td class="totalCost"><?php echo number_format($price * $arr_qty[$i]); ?> VND</td>
                                            </tr>
                                        </table>
                                    </div>
                                </li>
                                <?php $i++; } ?>
                            </ul>
                    </td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td><?php echo number_format(get_field('cf_total')); ?> VND</td>
                </tr>

                <tr>
                    <th>Payment status</th>
                    <td>
                        Transaction Number:<?php the_field('transaction_number'); ?><br>
                        Paid via <?php the_field('method'); ?><br>
                    </td>
                </tr>

                <tr>
                    <th>Order status</th>
                    <td><?php echo get_field('cf_order_status'); ?></td>
                </tr>
            </table>
        <?php endwhile; } else { ?>
            Order is not exists !
        <?php } } ?>

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
	  $("#formAccount").exValidation({
	    rules: {
            old_password: "chkrequired",
	    },
	    stepValidation: true,
	    scrollToErr: true,
	    errHoverHide: true
      });
    $('#old_password').removeClass('chkrequired errPosRight err');

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
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if(!$_SESSION['login']) {    
    header('Location:'.APP_URL);
}
include(TEMPLATEPATH."/libs/header.php"); 
$action = $_GET['action'];
?>
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
                        
                        for($i=0;$i<$numb_order;$i++) {
                            $arr_ids[] = $l_Order[$i]['cf_id'];
                            $arr_qty[] = $l_Order[$i]['cf_quantity'];
                        }
                        // var_dump($arr_ids);
                        ?>
                        <ul class="lstCart">
                            <?php
                                    $i=0;
                                    $wp_query = new WP_Query();
                                    $param=array(
                                    'post_type' => 'product',
                                    'posts_per_page' => '-1',
                                    'post__in'=> $arr_ids
                                    );
                                    $wp_query->query($param);
                                    if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
                                    $thumb = get_post_thumbnail_id($post->ID);
                                    $img_label = wp_get_attachment_image_src($thumb,'full');
                                    $promo = get_field('special-offer');
                                    if($promo!=0) {
                                        $price_real = get_field('price');
                                        $price_dis = ($price_real * $promo) / 100;
                                        $price = $price_real - $price_dis;
                                    } else {
                                        $price = get_field('price');
                                    }
                            ?>
                                <li class="flexBox flexBox--nosp">
                                    <p class="thumb"><img src="<?php echo thumbCrop($img_label[0],140,140); ?>" class="" alt="<?php echo $post->post_title; ?>"></p>	
                                    <div class="info">
                                        <p class="name"><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></p>
                                        <table>
                                            <tr>
                                                <th>QTY</th>
                                                <td class="qtyNumb"><?php echo $arr_qty[$i]; ?></td>
                                            </tr>
                                            <tr>
                                                <th>PRICE</th>
                                                <td><?php if($promo!=0) { ?><em><?php echo $price_real; ?>€</em><?php } ?><?php echo number_format($price); ?> VND</td>
                                            </tr>
                                            <tr>
                                                <th class="totalCost">SUB TOTAL</th>
                                                <td class="totalCost"><?php echo number_format($price * $arr_qty[$i]); ?> VND</td>
                                            </tr>
                                        </table>
                                    </div>
                                </li>
                                <?php
                                $i++;
                                endwhile;endif; ?>
                            </ul>
                    </td>
                </tr>
                <?php wp_reset_query(); ?>
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
</body>
</html>	
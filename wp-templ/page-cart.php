<?php /* Template Name: Cart */ ?>
<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."admin/wp-load.php"); 
include(TEMPLATEPATH."/libs/header.php"); 
?>
</head>

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
	<h3 class="h3_page">Your Cart</h3>
	<div class="">
			<?php 
			if(!$_COOKIE['order_des']) {
			?>
				<h3 class="h3_checkout">Your cart is empty</h3>
			<?php 	
			} else {
				$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_COOKIE['order_des'].'.json';
				$curr_cart  = json_decode(file_get_contents($f_isset));
			?>
			<div class="">
				<div class="boxCart">
					<h3 class="h3_checkout">IN YOUR CART (<span class="numbCart"></span>)</h3>
					<ul class="lstCart">
					<?php
						foreach($curr_cart as $mydata)
						{
							$full_id = $mydata->id;
							$arr_ids = array();
							if(!in_array($full_id,$arr_ids)) {
								$arr_ids[] = $full_id;
							}
							$wp_query = new WP_Query();
							$param=array(
							'post_type' => 'product',
							'posts_per_page' => '-1',
							'post__in'=> $arr_ids
							);
							$wp_query->query($param);
							if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();

							
							$color_search = array();
							$getImg = get_field('image_product');
							for($i=0;$i<=count($getImg);$i++) {
								$color_search[] = $getImg[$i]['color'];
							}
							$k = array_search('#'.$mydata->color,$color_search);
							$key_img = $k;
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
					?>
						<li class="flexBox flexBox--nosp">
							<p class="thumb"><img src="<?php echo thumbCrop($img_label[0],140,140); ?>" class="" alt="<?php echo $post->post_title; ?>"></p>	
							<div class="info">
								<p class="name"><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></p>
								<table>
									<tr>
										<th>QTY</th>
										<td class="qtyNumb"><?php echo $mydata->quantity; ?></td>
									</tr>
									<tr>
										<th>PRICE</th>
										<td><?php if($promo!=0) { ?><em><?php echo $price_real; ?>€</em><?php } ?><?php echo number_format($price); ?> VND</td>
									</tr>
									<tr>
										<th class="totalCost">SUB TOTAL</th>
										<td class="totalCost"><?php echo number_format($price * $mydata->quantity); ?> VND</td>
									</tr>
								</table>
								<a href="javascript:void(0)" class="btnRemove removeItem btnPage" data-id="<?php echo $post->ID; ?>" data-quan="<?php echo $mydata->quantity; ?>">REMOVE</a>
							</div>
						</li>
						<?php endwhile;endif; ?>
						<?php } ?>
					</ul>
				</div>

				<div class="boxTotal">
					<h3 class="h3_checkout">GRAND TOTAL</h3>
					<table class="tblCheckout">
						<?php
							$f_isset = $_SERVER['DOCUMENT_ROOT'].'/ajax/tmp/'.$_COOKIE['order_des'].'.json';
							$curr_cart  = json_decode(file_get_contents($f_isset));
							$arr_price = array();
							foreach($curr_cart as $mydata)
							{
								if(get_field('special-offer',$mydata->id)!=0) {
									$price_real = get_field('price',$mydata->id);
									$promo = get_field('special-offer',$mydata->id);
									$price_dis = ($price_real * $promo) / 100;
									$price_no = $price_real - $price_dis;
								}else{
									$price_no = get_field('price',$mydata->id);
								}
								$count_price = ($mydata->quantity * $price_no);
								$arr_price[] = $count_price;
						?>
						<tr>
							<th><?php echo $mydata->name; ?></th>
							<td><?php echo number_format($price_no); ?>VND x <?php echo $mydata->quantity; ?></td>
							<td><?php echo number_format($price_no * $mydata->quantity); ?>VND</td>
						</tr>
							<?php } ?>
						<tr class="totalCost">
							<th  colspan="2">TOTAL</th>
							<td><?php echo number_format(array_sum($arr_price)); 
							$_SESSION["total"] = array_sum($arr_price);
							
							?>VND</td>
						</tr>
					</table>
				</div>
				<div class="boxBtn">
						<a href="<?php echo APP_URL; ?>" class="btnPage"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;CONTINUE SHOPPING</a>
						<a href="<?php echo APP_URL; ?>checkout/" class="btnPage">CHECKOUT <i class="fa fa-credit-card" aria-hidden="true"></i></a>
					</div>
			</div>
			<?php } ?>
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

<script type="text/javascript">
$(function(){
	$('.lstProdMen li').biggerlink();
});
</script>
</body>
</html>	
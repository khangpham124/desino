<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php"); 
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
		<p class="mainPic">
		<?php 
			$wp_query = new WP_Query();
			$param = array (
			'posts_per_page' => '1',
			'post_status' => 'publish',
			'order' => 'DESC',
			'paged' => $paged,
			'tax_query' => array(
			array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => 'special-offer'
			)
			)
			);
			$wp_query->query($param);
			if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
			$img_src = wp_get_attachment_image_src(get_field('banner'),'full');
		?>	
		<img src="<?php echo $img_src[0]; ?>" class="imgMax" alt="" >
		<?php endwhile; endif; ?>
		</p>
        
		
			<ul class="lstProdMen clearfix matchHeight">
				<?php 
					$wp_query = new WP_Query();
					$param=array(
					'post_type'=>'product',
					'posts_per_page' => '-1',
					'meta_query' => array(
					array(
					'key' => 'special-offer',
					'value' => '',
					'compare' => '!='
					))
					);
					$wp_query->query($param);
					if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
					$img = get_post_thumbnail_id($post->ID);
					$thumb_url = wp_get_attachment_image_src($img,'full');
					$best_seller = get_field('best_seller');
					
					$rows = get_field('image_product' ); // get all the rows
					$first_row = $rows[0]; // get the first row
					$first_image = $first_row['slide' ]; // get the sub field value
					$first_image_inner = $first_image[0]['img' ]; // get the sub field value 
					$thumb_sp = wp_get_attachment_image_src($first_image_inner,'thumbPro' );//get Url image
				?>
				<li>
					<?php
						if($best_seller != '') {
					?>
					<span class="iconBest">BEST<br>SELLER</span>
					<?php } ?>
					<div class="wrap">
					<p class="thumb pc"><img src="<?php echo $thumb_url[0]; ?>" alt="" ></p>
					<p class="thumb sp"><img src="<?php echo $thumb_sp[0]; ?>" alt="" ></p>
					 <div class="info">
					   <a href="<?php the_permalink(); ?>">
					   <p class="name"><?php the_title(); ?></p>
					   <p class="price  <?php if(get_field('special-offer')!='') { ?>lowPrice<?php } ?>"><?php echo number_format(get_field('price')) ?> VND</p>
					   <?php if(get_field('special-offer')!='') { ?>
					    <p class="priceDown"><?php 
						$pr = get_field('price');
						$per = get_field('special-offer');
						$pr_down = ( $pr * $per ) / 100;
						$pre_final = $pr - $pr_down;
						echo number_format($pre_final) ?> VND</p>
					   <?php } ?>
					  </a>
					 </div> 
					</a> 
					</div>
				</li>
				<?php endwhile; endif; ?>
			</ul>
		
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
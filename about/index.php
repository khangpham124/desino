<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH_WP."/wp-load.php"); 
include(APP_PATH."libs/header.php"); 
?>
</head>

<body id="about" class="subPage">
<?php include(APP_PATH."libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(APP_PATH."libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(APP_PATH."libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
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
			'terms' => 'about'
			)
			)
			);
			$wp_query->query($param);
			if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
			$mainImg = wp_get_attachment_image_src(get_field('main_image'),'full');
			$img = get_post_thumbnail_id($post->ID);
			$thumb_url = wp_get_attachment_image_src($img,'full');
	?>		
	<div class="mainAbout">
		<img src="<?php echo $mainImg[0]; ?>" class="imgMax" alt="" >
		 
	</div>
	
	<div class="imgAbout pc">
			<p class="img"><img src="<?php echo $thumb_url[0]; ?>" alt="" ></p>
			<?php if($lang_web=='en') { ?>
            <p class="txtLinkto"><a href="<?php echo APP_URL; ?>store-locator/">Store Locator</a></p>
			<?php } else { ?>
			 <p class="txtLinkto"><a href="<?php echo APP_URL; ?>store-locator/">Danh sách cửa hàng</a></p>
			<?php } ?>
	</div>
	
		<div class="overAbout">
			<?php if($lang_web=='en') { ?>
			<?php the_content(); ?>
			<?php } else { ?>
			<?php echo get_field('vietnamese_content'); ?>
			<?php } ?>
		</div>
		
		<div class="imgAbout sp">
			<p class="img"><img src="<?php echo $thumb_url[0]; ?>" alt="" ></p>
           <?php if($lang_web=='en') { ?>
            <p class="txtLinkto"><a href="<?php echo APP_URL; ?>store-locator/">Store Locator</a></p>
			<?php } else { ?>
			 <p class="txtLinkto"><a href="<?php echo APP_URL; ?>store-locator/">Danh sách cửa hàng</a></p>
			<?php } ?>
		</div>
	</div>
  <?php endwhile; endif; ?>
    
<!-- container -->

<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->
</body>
</html>	
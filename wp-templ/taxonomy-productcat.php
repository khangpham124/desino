<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
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
		<p class="mainPic">
		<?php
			$category = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
			$term_id=$category->term_id;
			$term_slug = $category->slug;
			$img = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'productBanner');
			$img_full = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'full');
			?>
			<img src="<?php echo $img_full[0]; ?>" class="imgMax" alt="" ></p>
        
		<?php 
			$args=array(
			'child_of' => 0,
			'orderby' =>'ID',
			'hide_empty' => 1,
			'taxonomy' => 'brandcat',
			'number' => '0',
			'pad_counts' => false
			);
			$categories = get_categories($args);
			foreach ( $categories as $category ) {
			$slug = $category->slug;
		?>
			<ul class="lstProdMen clearfix matchHeight">
				<?php 
					$wp_query = new WP_Query();
					$param=array(
					'post_type'=>'product',
					'posts_per_page' => '-1',
					'tax_query' => array(
						'relation' => 'AND',
							array(
							'taxonomy' => 'productcat',
							'field' => 'slug',
							'terms' => $term_slug
							),
							array(
							'taxonomy' => 'brandcat',
							'field' => 'slug',
							'terms' => $slug
							)
						)
					);
					$wp_query->query($param);
					if($wp_query->have_posts()):while($wp_query->have_posts()) : $wp_query->the_post();
					$img = get_post_thumbnail_id($post->ID);
					$thumb_url = wp_get_attachment_image_src($img,'full');
					$best_seller = get_field('best_seller');
					
					$rows = get_field('image_product'); // get all the rows
					$first_row = $rows[0]; // get the first row
					$first_image = $first_row['slide']; // get the sub field value
					$first_image_inner = $first_image[0]['img']; // get the sub field value 
					$thumb_sp = wp_get_attachment_image_src($first_image_inner,'full' );//get Url image
				?>
				<li>
					<?php
						if($best_seller != '') {
					?>
					<span class="iconBest">BEST<br>SELLER</span>
					<?php } ?>
					<div class="wrap">
					<p class="thumb pc"><img src="<?php echo $thumb_url[0]; ?>" alt="<?php the_title() ?>" ></p>
					<p class="thumb sp"><img src="<?php echo $thumb_sp[0]; ?>" alt="<?php the_title() ?>" ></p>
					 <div class="info">
					   <a href="<?php the_permalink(); ?>">
					   <p class="name"><?php the_title(); ?></p>
					   <p class="price"><?php echo number_format(get_field('price')) ?> VND</p>
					  </a>
					 </div> 
					</a> 
					</div>
				</li>
				<?php endwhile; endif; ?>
			</ul>
			<?php } ?>
		
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
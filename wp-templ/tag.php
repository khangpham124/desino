<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."libs/header.php"); 
?>
</head>

<body id="blog" class="subPage">
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
		<ul class="lstBlog_list">
			<?php 
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts($query_string . '&orderby=post_date&order=desc&posts_per_page=5&paged=' . $paged); 
				if(have_posts()):while(have_posts()) : the_post();
				$img = get_post_thumbnail_id($post->ID);
				$thumb = wp_get_attachment_image_src($img,'thumbBlog');
			?>
			<li class="clearfix wow fadeInUp" data-wow-delay="0.2s">
					<img src="<?php echo thumbCrop($thumb[0],800,533); ?>" alt="<?php the_title(); ?>" >
					<div class="contBlog">
						<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
						<p class="date"><i class="fa fa-calendar" aria-hidden="true"></i><?php the_time('d.m.Y'); ?></p>
						<div class="desc"><?php the_excerpt(); ?></div>
					</div>
			</li>
			<?php endwhile; endif; ?>
		</ul>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
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


</body>
</html>	
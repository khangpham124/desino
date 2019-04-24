<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
?>
</head>

<body id="recruit" class="subPage">
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
		<ul class="clearfix lsrRec">
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts($query_string . '&orderby=post_date&order=desc&posts_per_page=10&paged=' . $paged); 
				if(have_posts()):while(have_posts()) : the_post();
			 ?>
			 	<li>
					<div class="wrap">
					<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
					<p class="date"><?php the_time('d.m.Y'); ?></p>
					<div class="desc"><?php the_excerpt(); ?></div>
					</div>
				</li>
			 <?php endwhile; endif; ?>
		</ul>	
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
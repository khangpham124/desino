<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(APP_PATH."admin/wp-load.php"); 
include(APP_PATH."libs/header.php"); 
?>
</head>

<body id="store" class="subPage">
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
		
		<div id="gmap-menu" style="with:300px;height:450px;"></div>
		<div id="controls"></div>
	</div>
      
<!-- container -->

<!--Footer-->
<?php include(APP_PATH."libs/footer.php"); ?>
<!--/Footer-->
<!--===================================================-->
</div>
<!--/wrapper-->
<!--===================================================-->


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV7fW4OF5FqFFlLakpTOvf1Kuq_qHXcqY"></script> 
<script src="<?php echo APP_URL; ?>common/js/maplace.js"></script>
<script>
var LocsA = [
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
			'terms' => 'store-locate'
			)
			)
			);
			$wp_query->query($param);
			if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
			while(has_sub_field('store_locator')):
			$image = wp_get_attachment_image_src(get_sub_field('image_store'),'thumbStore');
	?>		
    {
        lat: <?php echo get_sub_field('lat'); ?>,
        lon: <?php echo get_sub_field('long'); ?>,
        title: '<em><strong><?php echo get_sub_field('name_store'); ?></strong><br><?php if($lang_web=='en') { echo get_sub_field('address');} else {echo get_sub_field('address_vn');} ?></em><img src="<?php echo $image[0]; ?>" >',
        html: '<h3><?php echo get_sub_field('name_store'); ?></h3>',
        // icon: 'http://teddycoder.com/projects/desino_new/img/store/pin.png',
        // animation: google.maps.Animation.DROP
    },
	<?php endwhile;?>
    <?php endwhile; endif; ?>
];

	new Maplace({
    locations: LocsA,
    map_div: '#gmap-menu',
    controls_type: 'list',
    controls_on_map: false
}).Load()
</script>
	

</body>
</html>	
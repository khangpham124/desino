<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/slick.css" media="all">
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/magnific-popup.css">
</head>

<body id="collection_detail" class="subPage">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(TEMPLATEPATH."/libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="clearfix">
	
	<p class="nameCollect"><?php the_title() ?></p>
    <div class="descCollect"><?php echo $post->post_content; ?></div>
	
	<div class="grid">
		<div class="grid-sizer"></div>
		<?php
		if(get_field('image_collection')): 
		while(has_sub_field('image_collection')):
		$image = wp_get_attachment_image_src(get_sub_field('img'),'thumbCollection');
		?>
  		<div class="grid-item"><a href="<?php echo $image[0]; ?>" title="<?php echo get_sub_field('caption');  ?>" rel="lightbox-cats"><img src="<?php echo $image[0]; ?>" alt="<?php echo get_sub_field('caption');  ?>" ></a></div>
		<?php endwhile; endif; ?>
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
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/imagesloaded.pkgd.js"></script>
<script>
	var $grid = $('.grid').masonry({
	  itemSelector: '.grid-item',
	  percentPosition: true,
	  columnWidth: '.grid-sizer'
	});
	// layout Masonry after each image loads
	$grid.imagesLoaded().progress( function() {
	  $grid.masonry();
	});  

</script>


<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/jquery.magnific-popup.js"></script>
<script>

	    $(function() {

	    	$('.grid').magnificPopup({

			  	delegate: 'a',

				type: 'image',

				tLoading: 'Loading image #%curr%...',

				mainClass: 'mfp-img-mobile',

				gallery: {
					enabled: true,
					navigateByImgClick: true,

					preload: [0,1]

				},

                zoom: {
				enabled: true, // By default it's false, so don't forget to enable it
			 	duration: 300, // duration of the effect, in milliseconds

                    easing: 'ease-in-out', // CSS transition easing function 


                    opener: function(openerElement) {
return openerElement.is('img') ? openerElement : openerElement.find('img');

                    }

                },

				image: {

					tError: '<a href="%url%">cannot load image</a>.',

					titleSrc: 'title'

				}

			});

	    });

    </script>



</body>
</html>	
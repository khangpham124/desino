<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/slick.css" media="all">
</head>

<body id="collection" class="subPage">
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
	<ul class="clearfix lstCollect">
		<?php 
			$wp_query = new WP_Query();
			$param = array (
			'posts_per_page' => '15',
			'post_type' => 'collection',
			'post_status' => 'publish',
			'order' => 'DESC',
			'paged' => $paged,
			);
			$wp_query->query($param);
			if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
			$rows = get_field('image_collection' ); // get all the rows
			$first_row = $rows[0]; // get the first row
			$first_image = $first_row['img' ]; // get the sub field value 
			$thumb=wp_get_attachment_image_src($first_image,'thumbCollection' );//get Url image
		?>
		<li>
			<a href="<?php the_permalink(); ?>">
			<div class="wrap">
			<img src="<?php echo $thumb[0]; ?>" alt="<?php the_title() ?>" >
               <div class="contBlog">
                    <p class="title"><?php the_title(); ?></p>
					<p><i class="fa fa-plus-square-o" aria-hidden="true"></i></p>
			</div>	
			</div>
			</a>
		</li>
		<?php  endwhile; endif; ?>
	</ul>
	
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	
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
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/slick.js"></script>
<script>
		$(function(){
			$('.slider-for1').slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: true,
			  dots: false,
			  asNavFor: '.slider-nav1'
			});
			$('.slider-nav1').slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  asNavFor: '.slider-for1',
			  dots: false,
			  focusOnSelect: true
			});
			
			
			$('.slider-for2').slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: true,
			  dots: false,
			  asNavFor: '.slider-nav2'
			});
			$('.slider-nav2').slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  asNavFor: '.slider-for2',
			  dots: false,
			  focusOnSelect: true
			});
			
			$('.slider-for3').slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: true,
			  dots: false,
			  asNavFor: '.slider-nav3'
			});
			$('.slider-nav3').slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  asNavFor: '.slider-for3',
			  dots: false,
			  focusOnSelect: true
			});
			
		});
</script>

			
<script>			
$(function(){
	$('.leftProd').find(".showColor:first").css('opacity','1');
	$('.colorProd span').each(function(){
		$(this).click(function(){
			$('.colorProd span').removeClass('active');	
			$(this).toggleClass('active');
			var id = $(this).attr("id");
			//alert(id);
			$('.leftProd .showColor').css('opacity','0');
            $('.leftProd .showColor').css('z-index','-1');
			$('#boxfor_' + id).css('opacity','1');
            $('#boxfor_' + id).css('z-index','900');
		});	
	});
});			
</script>
 
<script>	    
    $('#featureList').slick({
  dots: false,
  infinite: true,
  speed: 300,
    autoplay: true,
  autoplaySpeed: 3000,    
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
   
  ]
});
</script>

<script>
/* $(function() {
	if($(window).width() > 1024) {
	 var h = $( window ).height();
		var h_elm = $('#wrapper').height();
		var pad = ( h - h_elm ) / 2;
		$('#wrapper').css('padding-top',pad + 'px');
	}
	
	$(window).resize(function(){	
		if($(window).width() > 1024) {
	 var h = $( window ).height();
		var h_elm = $('#wrapper').height();
		var pad = ( h - h_elm ) / 2;
		$('#wrapper').css('padding-top',pad + 'px');
	}
	});
}); */
</script>


</body>
</html>	
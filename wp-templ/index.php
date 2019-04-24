<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
include(TEMPLATEPATH."/libs/header.php"); 
?>
<link href="<?php echo APP_URL; ?>common/js/scroll-page/jquery.fullPage.css" rel="stylesheet">
</head>

<body id="top">
<?php include(TEMPLATEPATH."/libs/pageload.php"); ?>
<!--===================================================-->
<div id="wrapper">
<!--===================================================-->
<!--Header-->
<?php include(TEMPLATEPATH."/libs/header2.php"); ?>
<!--/Header-->

<div id="container" class="clearfix">
	<?php include(TEMPLATEPATH."/libs/sidebar.php"); ?>
	<div id="mainContent" class="pc">
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
			'terms' => 'video-home-page'
			)
			)
			);
			$wp_query->query($param);
			if($wp_query->have_posts()): while($wp_query->have_posts()) :$wp_query->the_post();
			$video = get_field('link_youtube');
			$img_src = wp_get_attachment_image_src(get_field('banner'),'full');
			if($video != '') {
		?>
        <iframe id="desinoVideo" width="100%" height="500" src="https://www.youtube.com/embed/<?php echo get_id_youtube($video); ?>?controls=0&showinfo=0&rel=0&autoplay=1&loop=1&playlist=rkqehuUTQ_4&enablejsapi=1" volume="0" frameborder="0" allowfullscreen></iframe>
		<?php } else { ?>
			<img src="<?php echo thumbCrop($img_src[0],836,500); ?>" alt="" class="imgMax" >
		<?php } ?>
		<?php endwhile; endif; ?>
    </div>
	
	<div id="fullpage" class="sp">
		<div class="section " id="section0">
			<div class="section_inner">
				<div class="thumb">
				<?php
					$category = get_term_by('name', 'women', 'productcat');
					$term_id=$category->term_id;
					$img = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'productBanner');
					$img_full = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'full');
					?>
				<a href="<?php echo APP_URL; ?>women">
                    <img src="<?php echo thumbCrop($img_full[0],800,800); ?>" class="imgMax" alt="" >
                 
                    <div class="txt">
                        <?php if($lang_web=='en') { ?>
						<p class="title">For<br><span>Women</span></p>
                        <?php } else { ?>
                        <p class="title">Thiết kế<br><span>Nữ</span></p>
                        <?php } ?>
					</div> 
                </a>
				</div>	 
				
			</div>	
		</div>
		
		<div class="section " id="section1">
			<div class="section_inner">
				<div class="thumb">
				<?php
					$category = get_term_by('name', 'men', 'productcat');
					$term_id=$category->term_id;
					$img = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'productBanner');
					$img_full = wp_get_attachment_image_src( get_field( 'banner', 'productcat_'.$term_id.''),'full');
					?>
				<a href="<?php echo APP_URL; ?>men">
                    <img src="<?php echo thumbCrop($img_full[0],800,800); ?>" class="imgMax" alt="" >
                   
					<div class="txt">
						<?php if($lang_web=='en') { ?>
                        <p class="title">For<br><span>Men</span></p>
                  	    <?php } else { ?>
                        <p class="title">Thiết kế<br><span>Nam</span></p>
                        <?php } ?>
				    </div>
                    </a>
				</div>
			</div>	
		</div>
		
		<div class="section " id="section2">
			<div class="section_inner">
				<div class="thumb">
                <a href="<?php echo APP_URL; ?>collection">    
                 <img src='img/intro/collect.png' alt="">
                    <div class="txt">
                        <?php if($lang_web=='en') { ?>
						<p class="title">our<br><span>Collection</span></p>
                        <?php } else { ?>
                        <p class="title">Bộ<br><span>Sưu tập</span></p>
                        <?php } ?>
				</div>
                </a>
				</div>
			</div>	
		</div>
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
<script>
	$(function() {
 	var h = $( window ).height();
    var h_elm = $('#wrapper').height();
    var pad = ( h - h_elm ) / 2;
    $('#wrapper').css('padding-top',pad + 'px');
	$(window).resize(function(){	
	var h = $( window ).height();
    var h_elm = $('#wrapper').height();
    var pad = ( h - h_elm ) / 2;
    $('#wrapper').css('padding-top',pad + 'px');
	});
	});
</script>


<script src="<?php echo APP_URL; ?>common/js/scroll-page/jquery.fullPage.js"></script>
	
    <script type="text/javascript">
		$(document).ready(function() {
			
				$('#fullpage').fullpage({
					'verticalCentered': false,
					'slideSelector': '.horizontal-scrolling',
					'css3': true,
					'navigation': false,
					'scrollOverflow': true,
					'scrollOverflowOptions': {
						click: false
					},
					'scrollOverflowReset': true,
					'offsetSections': true,
					'afterLoad': function(anchorLink, index){
						 
					},
	
					'onLeave': function(index, nextIndex, direction){
						if (index == 3 && direction == 'down'){
							$('.section').eq(index -1).removeClass('moveDown').addClass('moveUp');
						}
						else if(index == 3 && direction == 'up'){
							$('.section').eq(index -1).removeClass('moveUp').addClass('moveDown');
						}
					}
				});
			
		});
	</script>

</body>
</html>	
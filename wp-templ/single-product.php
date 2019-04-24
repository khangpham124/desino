<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
$titlepage = $post->post_title.' | desino | Premium Leather Handbags and Accessories';
include(TEMPLATEPATH."/libs/header.php"); 
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/slick.css" media="all">
</head>

<body id="detail_page" class="subPage">
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
		<div class="clearfix wrapDetail">
        <div class="leftProd clearfix">
		<?php 
			$s = 0;
			$count  = count(get_field('image_product'));
			while(has_sub_field('image_product')):
			$s++;
		?>
		<div id="boxfor_color<?php echo $s; ?>" class="showColor clearfix <?php if($s==1) { ?>active<?php } ?>">
			<div class="slider slider-for<?php echo $s; ?>">
				<?php 
					$i= 0;
					while(has_sub_field('slide')):
					$count2  = count(get_sub_field('slide'));
						$image = wp_get_attachment_image_src(get_sub_field('img'),'full');
						$i++;
				?>
				<div>
				<img id="zoom_<?php echo $s ?>_<?php echo $i;?>" src='<?php echo $image[0]; ?>' data-zoom-image="<?php echo $image[0]; ?>"/>
				</div>
				<?php endwhile; ?>
			</div>
			<div class="navSlide">
				<div class="slider slider-nav<?php echo $s; ?>">
					<?php 
					while(has_sub_field('slide')):
					$image = wp_get_attachment_image_src(get_sub_field('img'),'full');
					?>
					<div><img src="<?php echo $image[0]; ?>" alt="" ></div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
		
		<p class="colorProd">
			<?php
			$u = 0;
			while(has_sub_field('image_product')):
			$u++;
			?>
			<span id="color<?php echo $u; ?>" data-numb="<?php echo $u ?>" data-color="<?php echo get_sub_field('color'); ?>" style="background:<?php echo get_sub_field('color'); ?>"></span>
			<?php endwhile; ?>
		</p>
	</div>
    <div class="rightProd">
        <h1><?php the_title(); ?></h1>
		<p class="priceProd"><?php echo number_format(get_field('price')) ?> VND</p>
		<h2><strong>Origin :</strong> <?php echo get_field('origin'); ?></h2>
		<?php $avai = get_field('available'); 
		if($avai == 'yes') {
		?>
		<p><strong>Availability:</strong> Available in store</p>
		<?php } ?>
		<?php if($lang_web=='en') { ?>
		<div class="descProduct"><?php echo get_field('eng_content'); ?></div>
		<?php } else { ?>
		<div class="descProduct"><?php echo $post->post_content; ?></div>
		<?php } ?>

		<?php if ($_SESSION['login']) { ?>
		<div class="priceCols">
			<div class="numbers-row clearfix">
				<div class='inc button cal' rel='+' ><i class="fa fa-plus" aria-hidden="true"></i></div>
				<div class='dec button cal' id='dec'><i class="fa fa-minus" aria-hidden="true"></i></div>
				<input type="text" class="quantity input_cal" readonly  value="1"> 
			</div>
		</div>
		<div class="priceCols priceCols--bot flexBox flexBox--between">
			<?php
			$cl_arr = Array();
			while(has_sub_field('image_product')):
				$cl_arr[] = get_sub_field('color');
			endwhile;	
			?>
			<a href="javascript:void(0)" class="btnPage addToCard" data-id="<?php echo $post->ID; ?>" data-title="<?php the_title(); ?>" data-color="<?php echo $cl_arr[0]; ?>">ADD TO CART</a>
			<a href="javascript:void(0)" class="btnPage addToWish" data-id="<?php echo $post->ID; ?>" data-title="<?php the_title(); ?>" data-color="1"><i class="fa fa-heart-o" aria-hidden="true"></i> WISHLIST</a>
		</div>
		<?php } ?>
		
		<div class="boxShare">
			<?php if($lang_web=='en') { ?>
			<p class="txtShare">SHARE</p>
			<?php } else { ?>
			<p class="txtShare">CHIA SẺ</p>
			<?php } ?>
			<ul class="listShare clearfix">
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="https://twitter.com/home?status=<?php echo $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</div>
	</div>
	<?php 
		$posts_01 = get_field('inspiration');
		if( $posts_01 !=='' ) {
	?>
	<h4 class="h4_feature">Inspiration</h4>
	<?php foreach( $posts_01 as $post01) {
	$img = get_post_thumbnail_id($post01->ID);
	$thumb_url = wp_get_attachment_image_src($img,'full');
	?>
	<p class="imgBlog_shop"><img src="<?php echo $thumb_url[0] ?>" alt="" ></p>
	<p class="titleBlog_shop"><?php echo $post01->post_title; ?></p>
	<div class="mainBlogShop"><?php echo $post01->post_content; ?></div>
	<?php } ?>
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

<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/slick.js"></script>
<script>
		$(function(){
			<?php for($i=1;$i<=$count;$i++) { ?>
			$('.slider-for<?php echo $i; ?>').slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: true,
			  dots: false,
			  asNavFor: '.slider-nav<?php echo $i; ?>'
			});
			$('.slider-nav<?php echo $i; ?>').slick({
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  asNavFor: '.slider-for<?php echo $i; ?>',
			  dots: false,
			  focusOnSelect: true
			});
			<?php } ?>
		});
</script>


<script>
$(document).ready(function () {
	$( ".colorProd span").click(function(){
		var id_span = $(this).attr('id');
		var span_color = $(this).attr('data-color');
		var numb_color = $(this).attr('data-numb');
		var leng = id_span.length;
		var id_box = id_span.substr(leng - 1);
		$('.leftProd .showColor').removeClass('active');
		$('#boxfor_color'+ id_box).addClass('active');	
		$('.addToCard').attr('data-color',span_color);
		$('.addToWish').attr('data-color',numb_color);
	});	
});
</script>

</body>
</html>	
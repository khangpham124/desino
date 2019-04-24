<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
$titlepage = $post->post_title.' | desino | Premium Leather Handbags and Accessories';
$content = $post->post_content;
$text= strip_tags($content, '<br>');
if(mb_strlen($text)>140) { 
$desPage= mb_substr($text,0,150).'...'; 
} else {echo $text;}
$img = get_post_thumbnail_id($post->ID);
$thumb_share = wp_get_attachment_image_src($img,'thumbBlog');
$thumb_share_fb = $thumb_share[0];
include(TEMPLATEPATH."/libs/header.php"); 
?>
<link rel="stylesheet" href="<?php echo APP_URL; ?>common/css/slick.css" media="all">
</head>

<body id="blog" class="subPage">
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
	<div class="leftBlog">
			<p class="dateBlog"><?php the_time('d.m.Y'); ?></p>
			<?php if($lang_web=='en') { ?>
			<h2 class="titleBlog"><?php echo get_field('title_eng'); ?></h2>
			<div class="contentBlog">
				<?php echo get_field('content_eng'); ?>
			</div>
			<?php } else { ?>
			<h2 class="titleBlog"><?php the_title(); ?></h2>
			<div class="contentBlog">
				<?php echo $post->post_content; ?>
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
			
			<div class="tagBox">
			<p class="txtShare">TAGS</p><span class="txtTag">
			<?php $t= wp_get_post_tags($post->ID);
			 foreach ($t as $tag) {
			?> 
			<a href="<?php echo APP_URL; ?>tag/?tag=<?php echo $tag->slug; ?>">#<?php echo $tag->name; ?></a>
			<?php } ?>
			</span>
			</div>
			
		</div>
		<div class="rightBlog pc">
			<?php if($lang_web=='en') { ?>
			<h3 class="h3_side">OTHER POST</h3>
			<?php } else { ?>
			<h3 class="h3_side">BÀI VIẾT KHÁC</h3>
			<?php } ?>
			<ul class="lstSide">
				<?php 
					$randPosts = new WP_Query();
					$randPosts->query('showposts=6&post_type=blog&orderby=rand');
					while($randPosts->have_posts()) : $randPosts->the_post();
					$img = get_post_thumbnail_id($post->ID);
					$thumb = wp_get_attachment_image_src($img,'thumbBlog');	
				?>
				<li class="clearfix">
					<img src="<?php echo thumbCrop($thumb[0],800,533); ?>" alt="<?php echo $post->post_title; ?>" >
					<div class="contBlog">
						<p class="title"><a href="<?php echo APP_URL; ?>blog/<?php echo $post->post_name; ?>">
						<?php if($lang_web=='en') { ?>
							<?php echo get_field('title_eng'); ?>
						<?php } else { ?>
							<?php echo $post->post_title; ?>
						<?php } ?>
						</a></p>
						<p class="date"><?php the_time('d.m.Y'); ?></p>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
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

<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/slick.js"></script>

<script>

$('.lstSide').slick({
  dots: false,
  infinite: true,
  speed: 600,
  autoplay: true,
  autoplaySpeed: 4000,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {

      breakpoint: 1024,

      settings: {

        slidesToShow: 1,

        slidesToScroll: 1,

        infinite: true,

        dots: false

      }

    },

    {

      breakpoint: 600,
	  settings: {
		slidesToShow: 1,
slidesToScroll: 1

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


</body>
</html>	
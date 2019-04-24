<!--Google Tag Manager-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50815984-9', 'auto');
  ga('send', 'pageview');

</script>

<!--End Google Tag Manager-->

<div class="sp">
	<header id="header" class="">
		<p class="menuCircle">
			<span></span>
		</p>
		<h1 id="logo"><a href="<?php echo APP_URL; ?>"><img src="<?php echo APP_URL; ?>common/img/header/logo.svg" alt="<?php echo $txtH1 ?>" ></a></h1>
		
	</header>
	
	<div class="layer-dark"></div>
	
	<div class="menuOver">
        <?php 
            $posts_sp = get_posts(array(
            'numberposts' => -1,
            'post_type' => 'recruit',
            ));
            $rec_count_sp = count($posts_sp);
        ?>
		<ul class="sideMenu">
            <?php if($lang_web=='en') { ?>
                <li><a href="javascript:void(0)">SHOP WOMEN</a>
                    <ul>
                        <li><a href="<?php echo get_term_link('women','productcat');?>">ALL</a></li>
                        <li><a href="<?php echo get_term_link('women-bag','productcat');?>">BAG</a></li>
                        <li><a href="<?php echo get_term_link('women-accessories','productcat');?>">ACCESSORIES</a></li>
                    </ul>    
                </li>
                <li><a href="<?php echo APP_URL; ?>men">SHOP MEN</a>
                    <ul>
                        <li><a href="<?php echo get_term_link('men','productcat');?>">ALL</a></li>
                        <li><a href="<?php echo get_term_link('men-bag','productcat');?>">BAG</a></li>
                        <li><a href="<?php echo get_term_link('men-accessories','productcat');?>">ACCESSORIES</a></li>
                    </ul>    
                </li>
                <li><a href="<?php echo APP_URL; ?>collection/">OUR COLLECTION</a></li>
                <li><a href="<?php echo APP_URL; ?>special-offer/">SPECIAL OFFER</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>design/">BE A DESIGNER</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>blog/">BLOG</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>store-locator/">STORE LOCATOR</a></li>
                <li><a href="<?php echo APP_URL; ?>about">ABOUT US</a></li>
                <?php if($rec_count_sp > 0 ) { ?>    
                    <li><a href="<?php echo APP_URL; ?>recruit">RECRUIT</a></li>
                <?php } ?>

                <?php if ($_SESSION['login']) { ?>
                    <!-- <li><a class="btnShopping pc callPopup" href="javascript:void(0)"><i class="fa fa-user-circle-o" aria-hidden="true"></i>LOGIN|SIGN UP</a></li> -->
                    <li><a class="btnShopping" href="<?php echo APP_URL; ?>account">MY ACCOUNT</a></li>
                    <!-- <li><a class="btnShopping pc" href="<?php echo APP_URL; ?>logout.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i>SIGN OUT</a></li> -->
                    <li><a class="btnShopping" href="<?php echo APP_URL; ?>cart/">YOUR CART &nbsp;(<span class="numbCart">0</span>)</a> </li>
                <?php } ?>

                <?php if ($_SESSION['login']) { ?>
                <li><a class="btnShopping" href="<?php echo APP_URL; ?>logout.php">LOGOUT</a></li>
                <?php } else { ?>
                    <li><a class="btnShopping callPopup" href="javascript:void(0)">LOGIN|SIGN UP</a></li>
                <?php } ?>
                
            
            <?php } else { ?>
                <li><a href="javascript:void(0)">THIẾT KẾ NỮ</a>
				<ul>
                    <li><a href="<?php echo get_term_link('women','productcat');?>">TẤT CẢ</a></li>
					<li><a href="<?php echo get_term_link('women-bag','productcat');?>">TÚI XÁCH</a></li>
					<li><a href="<?php echo get_term_link('women-accessories','productcat');?>">PHỤ KIỆN</a></li>
				</ul>    
                </li>
                <li><a href="javascript:void(0)">THIẾT KẾ NAM</a>
                    <ul>
                        <li><a href="<?php echo get_term_link('men','productcat');?>">TẤT CẢ</a></li>
                        <li><a href="<?php echo get_term_link('men-bag','productcat');?>">TÚI XÁCH</a></li>
                        <li><a href="<?php echo get_term_link('men-accessories','productcat');?>">PHỤ KIỆN</a></li>
                    </ul>    
                </li>
                <li><a href="<?php echo APP_URL; ?>collection/">BỘ SƯU TẬP</a></li>
                <li><a href="<?php echo APP_URL; ?>special-offer/">KHUYẾN MÃI</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>design/">BE A DESIGNER</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>blog/">BLOG</a></li>

                <li class="mt_15"><a href="<?php echo APP_URL; ?>store-locator/">CỬA HÀNG</a></li>
                <li><a href="<?php echo APP_URL; ?>about/">GIỚI THIỆU</a></li>
                <?php if($rec_count_sp > 0 ) { ?>    
                    <li><a href="<?php echo APP_URL; ?>recruit/">TUYỂN DỤNG</a></li>
                <?php } ?>

                <?php if ($_SESSION['login']) { ?>
                    <!-- <li><a class="btnShopping pc callPopup" href="javascript:void(0)"><i class="fa fa-user-circle-o" aria-hidden="true"></i>ĐĂNG NHẬP|ĐĂNG KÝ</a></li> -->
                    <li><a class="btnShopping" href="<?php echo APP_URL; ?>account">TÀI KHOẢN</a></li>
                    <!-- <li><a class="btnShopping pc" href="<?php echo APP_URL; ?>logout.php"><i class="fa fa-user-circle-o" aria-hidden="true"></i>THOÁT</a></li> -->
                    <li><a class="btnShopping" href="<?php echo APP_URL; ?>cart/">GIỎ HÀNG (<span class="numbCart">0</span>)</a> </li>
                <?php } ?>

                <?php if ($_SESSION['login']) { ?>
                    <li><a class="btnShopping" href="<?php echo APP_URL; ?>logout.php">THOÁT</a></li>
                    <?php } else { ?>
                    <li><a class="btnShopping callPopup" href="javascript:void(0)"></i>ĐĂNG NHẬP|ĐĂNG KÝ</a></li>
                <?php	} ?>

            <?php } ?>
            
            <li class="mt_15">
            <a href="" data-lang="en" class="btnLang <?php if($lang_web=='en') { ?>active<?php } ?>">EN</a>&nbsp;|&nbsp;
            <a href="" data-lang="vn" class="btnLang <?php if($lang_web=='vn') { ?>active<?php } ?>">VIET</a></li>
		
		</ul>
		
		<ul class="socialList clearfix">
				<li><a href="https://www.facebook.com/DesinoLeatherGoods/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a href="https://www.instagram.com/desino_leather_goods/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
				<li><a href=""><i class="fa fa-skype" aria-hidden="true"></i></a></li>
        </ul>
	</div>
</div>

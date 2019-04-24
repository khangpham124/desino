<?php 
    $posts_with_actu = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'recruit',
    ));
    $rec_count = count($posts_with_actu);
?>
<aside id="sidebar" class="pc">
	<div id="innerSide">
		<p id="logo"><a href="<?php echo APP_URL; ?>"><img src="<?php echo APP_URL; ?>common/img/header/logo.png" alt="" ></a></p>
		<?php if($lang_web=='en') { ?>
			<ul class="lstSidebar">
			<li><a href="javascript:void(0)">SHOP WOMEN</a>
				<ul>
					<li><a href="<?php echo APP_URL; ?>women">ALL</a></li>
					<li><a href="<?php echo APP_URL; ?>women/women-bag/">BAG</a></li>
					<li><a href="<?php echo APP_URL; ?>women/women-accessories/">ACCESSORIES</a></li>
				</ul>    
			</li>
			<li><a href="javascript:void(0)">SHOP MEN</a>
				<ul>
					<li><a href="<?php echo APP_URL; ?>men">ALL</a></li>
					<li><a href="<?php echo APP_URL; ?>men/men-bag/">BAG</a></li>
					<li><a href="<?php echo APP_URL; ?>men/men-accessories/">ACCESSORIES</a></li>
				</ul>    
			</li>
			<li><a href="<?php echo APP_URL; ?>collection">OUR COLLECTION</a></li>
			<li><a href="<?php echo APP_URL; ?>special-offer">SPECIAL OFFER</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>be-a-designer/">BE A DESIGNER</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>blog">BLOG</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>store-locator">STORE LOCATOR</a></li>
			<li><a href="<?php echo APP_URL; ?>about">ABOUT US</a></li>
                <?php if($rec_count > 0 ) { ?>    
                <li><a href="<?php echo APP_URL; ?>recruit">RECRUIT</a></li>
                <?php } ?>
			</ul>
			
			<?php if ( is_user_logged_in() ) { ?>
			<ul class="lstSidebar">
			<li><a class="btnShopping pc" href="<?php echo APP_URL; ?>account/"><i class="fa fa-shopping-bag" aria-hidden="true"></i>LOGIN|SIGN UP</a></li>
			<li><a class="btnShopping pc" href="<?php echo APP_URL; ?>cart/"><i class="fa fa-shopping-bag" aria-hidden="true"></i>YOUR CART(<span class="numbCart">0</span>)</a> </li>
			</ul>
			<?php } ?>

		<?php } else { ?>
						<ul class="lstSidebar">
			<li><a href="javascript:void(0)">THIẾT KẾ NỮ</a>
				<ul>
					<li><a href="<?php echo APP_URL; ?>women">TẤT CẢ</a></li>
					<li><a href="<?php echo APP_URL; ?>women/women-bag/">TÚI XÁCH</a></li>
					<li><a href="<?php echo APP_URL; ?>women/women-accessories/">PHỤ KIỆN</a></li>
				</ul>    
			</li>
			<li><a href="javascript:void(0)">THIẾT KẾ NAM</a>
				<ul>
					<li><a href="<?php echo get_term_link('men','productcat');?>">TẤT CẢ</a></li>
					<li><a href="<?php echo APP_URL; ?>men/men-bag/">TÚI XÁCH</a></li>
					<li><a href="<?php echo APP_URL; ?>men/men-accessories/">PHỤ KIỆN</a></li>
				</ul>    
			</li>
			<li><a href="<?php echo APP_URL; ?>collection">BỘ SƯU TẬP</a></li>
			<li><a href="<?php echo APP_URL; ?>special-offer">KHUYẾN MÃI</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>be-a-designer/">BE A DESIGNER</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>blog">BLOG</a></li>
			</ul>
			
			<ul class="lstSidebar">
			<li><a href="<?php echo APP_URL; ?>store-locator">CỬA HÀNG</a></li>
			<li><a href="<?php echo APP_URL; ?>about">GIỚI THIỆU</a></li>
            <?php if($rec_count > 0 ) { ?>    
			<li><a href="<?php echo APP_URL; ?>recruit">TUYỂN DỤNG</a></li>
			<?php } ?>
			</ul>
        

		<?php } ?>
		
		<ul class="lstSidebar">
		<li>
		<a href="javascript:void(0)" data-lang="en" class="btnLang <?php if($lang_web=='en') { ?>active<?php } ?>">EN</a>&nbsp;|&nbsp;
		<a href="javascript:void(0)" data-lang="vn" class="btnLang <?php if($lang_web=='vn') { ?>active<?php } ?>">VIET</a></li>
		</ul> 
		
	</div>   
</aside>
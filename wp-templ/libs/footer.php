<p id="pageTop"><a href="#wrapper"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></a></p>

<footer id="footer">
    <div class="footerInner clearfix">
		<ul class="socialList clearfix">
			<li><a href="https://www.facebook.com/DesinoLeatherGoods/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<li><a href="https://www.instagram.com/desino_leather_goods/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			<li><a href=""><i class="fa fa-skype" aria-hidden="true"></i></a></li>
		</ul>
		<p id="copyright">copyright &copy; 2019</p>
		
	</div> 
</footer>

<div class="overlay"></div>
<div class="popUp" id="formLogin">
	<h3 class="taC"><img src="<?php echo APP_URL; ?>common/img/header/logo.svg" alt="<?php echo $txtH1 ?>" ></h3>
	<div class="showForm">
		<form action="<?php echo APP_URL; ?>account?action=login" class="formChk" method="post" id="formLogin">
			<p class="inputForm">
				<label>Email<span>(*)</span></label>
				<input type="email" name="mail" value="" class="inputText">
			</p>
			<p class="inputForm">
				<label>Password<span>(*)</span></label>
				<input type="password" name="password" value="" class="inputText">
			</p>
			<div class="flexBox flexBox--between">
				<label class="checkStyle">
						Keep me logged in
						<input type="checkbox" name="check01[]" value="keep" id="keep">
						<span class="checkmark"></span>
				</label>
				<a href="" class="link">Forgotten your password?</a>
			</div>
			<p class="taC"><input type="submit" class="btnPage" value="LOG IN"></p>
			<input type="hidden" name="url" value="<?php echo $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" >
			<span>Not a member? <a href="javascript:void(0)" class="link" id="callSign">Sign Up Now</a></span>
		</form>	
	</div>
</div>

<!-- <div class="popUp" id="formsignUp">
<h3 class="taC"><img src="<?php echo APP_URL; ?>common/img/header/logo.svg" alt="<?php echo $txtH1 ?>" ></h3>
	<div class="showForm">
		<form action="<?php echo APP_URL; ?>account?action=signup" class="formChk" method="post" id="formSignUp">
			<p class="inputForm">
				<label>Full name<span>(*)</span></label>
				<input type="text" name="fullname" value="" id="fullname" class="inputText">
			</p>
			<p class="inputForm">
				<label>Phone<span>(*)</span></label>
				<input type="text" name="mobile" value="" id="mobile"  class="inputText">
			</p>
			<p class="inputForm">
				<label>E-mail<span>(*)</span></label>
				<input type="mail" name="mail" value="" id="mail" class="inputText">
			</p>
			<p class="inputForm">
				<label>Password<span>(*)</span></label>
				<input type="password" name="password" value="" id="pass" class="inputText">
			</p>
			<p class="inputForm">
				<label>Re-Password<span>(*)</span></label>
				<input type="password" name="prepass" value="" id="repass" class="inputText">
			</p>
			<p class="taC"><input type="submit" class="btnPage" value="SIGN UP"></p>
			<input type="hidden" name="url" value="<?php echo $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" >
			<span>Already a member? <a href="javascript:void(0)" class="link" id="callLog">Sign In</a></span>
		</form>	
	</div>
</div> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/smoothscroll.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/common.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/biggerlink.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/matchHeight.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/pageload.js"></script>
<script type="text/javascript" src="<?php echo APP_URL; ?>common/js/addCart.js"></script>
<script>
$(".btnSearch").click(function(){
	var elm = $('.formSearch');
	var inpt = $('.inputSeach');
	if (elm.hasClass("active")) {
		elm.animate({opacity: "0"},100);
		elm.removeClass('active');
		inpt.prop('disabled', true);
	} else {
		elm.animate({opacity: "1"},200);
		elm.addClass('active');
		inpt.prop('disabled', false);
	}
});
</script>

<script>
    $( ".lstSidebar li" ).each(function() {
        $(this).click(function(){
            $(this).find('ul').slideToggle(200);
        });    
   });     
</script>


<script src="<?php echo APP_URL; ?>common/js/jquery.sticky.js"></script>
<script>
  $(document).ready(function(){
    $("#sidebar").sticky({topSpacing:0});
	$("#socialList").sticky({bottomSpacing:0});
  });
</script>

<script type="text/javascript">
 $('.socialList').addClass('social_fix');
$(window).scroll(function(){
	var sT = $(window).scrollTop();
	var vW = $(window).width();
	if(vW > 767) {
		if(sT >= 70) {
			$("#sidebar").css('margin-top','50px');
		} else {
			$("#sidebar").css('margin-top','0px');
		}
	} else {
	}
    
   
    var footerHeight = $("#footer").outerHeight();
    var w_height = $(window).height();
    var fS = ($(document).height() - footerHeight) - 600 ;    
 });     
</script>

<script type="text/javascript">
$(function(){
	$('.matchHeight li').matchHeight();

	$('.callPopup').click(function() {
        $('.overlay').fadeIn(200);
        $('.popUp').fadeIn(200);
    });

    $('.overlay').click(function() {
        $(this).fadeOut(200);
        $('.popUp').fadeOut(200);
		$('#formsignUp').css("z-index","500");
		$('#formsignUp').css("opacity","0");
		$('#formLogin').css("z-index","600");
    });

	$('#callSign').click(function() {
		$('#formLogin').css("margin-top","-25px");
		setTimeout(function() { 
			$('#formLogin').css("opacity","0");
			$('#formLogin').css("z-index","500");
			$('#formsignUp').css("opacity","1");
			$('#formsignUp').css("margin-top","0");
			$('#formsignUp').css("z-index","600");
		}, 300);
	});

	$('#callLog').click(function() {
		$('#formsignUp').css("margin-top","-25px");
		setTimeout(function() { 
			$('#formsignUp').css("opacity","0");
			$('#formsignUp').css("z-index","500");
			$('#formLogin').css("opacity","1");
			$('#formLogin').css("margin-top","0");
			$('#formLogin').css("z-index","600");
		}, 300);
	});
});
</script>

<script>
	$(function(){
		$(".btnLang").click(function(){  
			var lang = $(this).attr('data-lang');
			createCookie('lang_web' ,lang , 24);
			location.reload();
		});	
	});
</script>	



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



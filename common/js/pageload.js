
/* LOADER */
var t;
var timer_is_on = 0;

function timedCount() {
    $('.page-loader').toggleClass('anim');
    t = setTimeout(function(){timedCount()}, 1000);
}

if (!timer_is_on) {
    timer_is_on = 1;
    timedCount();
}
/* END LOADER */
$(window).load(function(){
	$('.page-loader-square').fadeOut(400);
	$('.page-loader-inner').addClass('transition');
	setTimeout(function() {
		$('.page-loader-inner').addClass('anim');
	}, 200);
	setTimeout(function() {
		$('.page-loader').fadeOut(400);
        
            
	}, 400);

	setTimeout(function() {
		$('.home-square-bottom').removeClass('show');
		$('.home-square-right').removeClass('show');
		$('.home-square-top').removeClass('show');
		$('.home-square-left').removeClass('show');
		$('.home-title').addClass('show');
	}, 900);
	setTimeout(function() {
		$('.home-description').addClass('show');
	}, 1000);	
	setTimeout(function() {
		$('.home-mac-wrapper').addClass('show');
	}, 1050);
	setTimeout(function() {
		$('.home-info .button-type-1').addClass('show-block');
	}, 1100);	
	setTimeout(function() {
		$('.home-iphone-wrapper').addClass('show');
	}, 1200);
	// setTimeout(function() {
	// 	macScreen();
	// }, 2200);	
});

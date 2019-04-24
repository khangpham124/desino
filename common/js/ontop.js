$(function()
{
$(window).scroll(function(){
	if($(this).scrollTop() >= 700)
	{
		$('#bttop').fadeIn();
		$('.listNumb').fadeIn();
	}else{
		$('#bttop').fadeOut();
		$('.listNumb').fadeOut();
	}
});
    
$('#bttop').click(function(){$('body,html').animate({scrollTop:0},800);});

$('.btn_up').click(function(){$('body,html').animate({scrollTop:0},800);});

});
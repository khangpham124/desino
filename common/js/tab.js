/* begin tabarea */
$(function(){
	$(".tabarea").each(function(){
		$(this).find(".tablist").addClass("clearfix");
		$(this).find(".tabcontent").addClass("clearfix");
		
		$(this).find(".tablist").find("li:first").find("active");
		$(this).find(".tablist").find("li:last").find("last");
		$(this).find(".tabcontent").find(".tabshow:first").show();
		$(this).find(".tablist").find("li:first").addClass('active');
		
		var itemclick = $(this).find(".tablist").find("li");
		var size = itemclick.size();
		var tabShow = $(this).find(".tabcontent").find(".tabshow");
		var str = tabShow.attr("id").substr(0,7);
		
		for(i=0; i<size; i++){
			itemclick.eq(i).click(function(){
				itemclick.removeClass("active");
				$(this).addClass("active");
				var idNum = $(this).attr("id").substr(3);
				var strnew = str + idNum;
				tabShow.hide();
				tabShow.each(function(){
					if($(this).attr("id") == strnew){
						$(this).fadeIn(200);
					}
				});
			});
		}
	});
});
/* end tabarea */
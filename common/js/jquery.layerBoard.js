/*
 * ===================================================================
 *	jquery.layerBoard.js
 *	@auther:kiyoty
 *	@URI:http://www.idea-clippin.com
 *	@create:2012/12/30
 * 	@License:MIT License(X11 Licenseã€X License)
 * ===================================================================
 *	
 * -------------------------------------------------------------------
 *	opition
 * -------------------------------------------------------------------
 * delayTime		//è¡¨ç¤ºã¾ã§ã®å¾…ã¡æ™‚é–“
 * fadeTime			//è¡¨ç¤ºã®ãƒ•ã‚§ãƒ¼ãƒ‰æ™‚é–“
 * alpha				//ãƒ¬ã‚¤ãƒ¤ãƒ¼ã®é€æ˜Žåº¦
 * limitMin			//ä½•åˆ†çµŒéŽå¾Œã«å†åº¦è¡¨ç¤ºã™ã‚‹ã‹
 * easing				//ã‚¤ãƒ¼ã‚¸ãƒ³ã‚°
 * limitCookie	//cookieä¿å­˜æœŸé–“
 *	
 * -------------------------------------------------------------------
 *	Example
 *	$('#layer_board_area').layerBoard({alpha:0.5});
 * -------------------------------------------------------------------
*/

(function($) {
	
  $.fn.layerBoard = function(option) {
  	
		var elements = this;
		
		elements.each(function(){
			
			option = $.extend({
				delayTime: 200,						//è¡¨ç¤ºã¾ã§ã®å¾…ã¡æ™‚é–“
				fadeTime : 500,						//è¡¨ç¤ºã®ãƒ•ã‚§ãƒ¼ãƒ‰æ™‚é–“
				alpha : 0.5,							//ãƒ¬ã‚¤ãƒ¤ãƒ¼ã®é€æ˜Žåº¦
				
				limitMin : 1,							//ä½•åˆ†çµŒéŽå¾Œã«å†åº¦è¡¨ç¤ºã™ã‚‹ã‹
				
				easing: 'linear',					//ã‚¤ãƒ¼ã‚¸ãƒ³ã‚°
				
				limitCookie : 1	 					//cookieä¿å­˜æœŸé–“
			}, option);
							
				
			var limitSec = option.limitMin * 60; //ç§’æ•°ã«å¤‰æ›
						
						
			if ($.cookie('layerBoardTime') == null) {
				
				/*----------------------------------------
					cookieãŒãªã„å ´åˆ
				 ----------------------------------------*/
				LayerBoardFunc ();
				
				//cookieã«ç¾åœ¨ã®æ™‚é–“ã‚’ã‚»ãƒƒãƒˆ
				var start = new Date();
				$.cookie('layerBoardTime', start.getTime(), { expires: option.limitCookie,path: '/' });
				
				
			} else {
				
				/*----------------------------------------
					cookieãŒã‚ã‚‹å ´åˆ
				 ----------------------------------------*/
				
				//ç¾åœ¨ã®ãƒŸãƒªç§’ã‚’å–å¾—ã—ã€ç§’æ•°ã«å¤‰æ›
				var now = new Date();
				secDiff = now.getTime() - $.cookie('layerBoardTime');
				secTime = Math.floor( secDiff / 1000);
				
				
				//æŒ‡å®šæ™‚é–“ã‚’çµŒéŽã—ã¦ã„ãŸå ´åˆã¯ã€LayerBoardã‚’è¡¨ç¤º
				//cookieã‚’å‰Šé™¤å¾Œã€å†åº¦cookieã«ç¾åœ¨ã®ãƒŸãƒªç§’ã‚’ã‚»ãƒƒãƒˆ
				if (secTime >= limitSec) {
					
					LayerBoardFunc ();
					
					$.cookie('layerBoardTime', null, { expires:-1,path: '/' });
					
					var start = new Date();
					$.cookie('layerBoardTime', start.getTime(), { expires:option.limitCookie,path: '/' });
					
				}
				
			}
			
			
			/*----------------------------------------
				è¡¨ç¤ºå‡¦ç†
			 ----------------------------------------*/
			function LayerBoardFunc () {
				
				
				$('.layer_board_bg', elements).show().animate({opacity: 0},0).delay(option.delayTime).animate({opacity: option.alpha},option.fadeTime,function(){
					$('.layer_board', elements).fadeIn(option.fadeTime);																																					
				})
					
			}
			
			
			/*----------------------------------------
				éžè¡¨ç¤ºå‡¦ç†
			 ----------------------------------------*/
			$('.layer_board_bg', elements).click(function() {
				
				$('.layer_board', elements).fadeOut(option.fadeTime);
				$(this).fadeOut(option.fadeTime);
				
				
			});
			
			
			//closeãƒœã‚¿ãƒ³ã®å ´åˆ
			$('.btn_close', elements).click(function() {
				
				$('.layer_board', elements).fadeOut(option.fadeTime);
				$('.layer_board_bg', elements).fadeOut(option.fadeTime);
				
				
			});

			
			
			/*----------------------------------------
				ãƒœã‚¿ãƒ³ã«ã‚ˆã‚‹è¡¨ç¤ºå‡¦ç†
			 ----------------------------------------*/
			$('.layer_board_btn').click(function() {
				
				$('.layer_board_bg', elements).show().animate({opacity: 0},0).delay(option.delayTime).animate({opacity: option.alpha},option.fadeTime,function(){
					$('.layer_board', elements).fadeIn(option.fadeTime);																																					
				});
				
			});
	
		});
		
		return this;		
		
	};
	
})( jQuery );


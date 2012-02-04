
/**
* Name: PiroBox Extended v.1.2.3
* Date: October 2011
* Autor: Diego Valobra (http://www.pirolab.it),(http://www.diegovalobra.com)
* Version: 1.2.3
* Licence: CC-BY-SA http://creativecommons.org/licenses/by-sa/3/it/
**/
(function($) {
	var flag_scroll = null;
	$.pirobox_ext = function(opt) {
		opt = jQuery.extend({
		piro_speed : 700,
		zoom_mode : true,
		move_mode : 'mousemove',
		bg_alpha : 0.5,
		piro_scroll : true,
		share: true,
		padding:null,
		image_ratio:0.90, //var image ratio = 1.203; /*::::: ORIGINAL SIZE :::::*/
		animation: 'sinc'
				}, opt);
		flag_scroll = opt.piro_scroll;
	$.fn.piroFadeIn = function(speed, callback) {
		$(this).fadeIn(speed, function() {
		if(jQuery.browser.msie)
			$(this).get(0).style.removeAttribute('filter');
		if(callback != undefined)
			callback();
		});
	};
	$.fn.piroFadeOut = function(speed, callback) {
		$(this).fadeOut(speed, function() {
		if(jQuery.browser.msie)
			$(this).get(0).style.removeAttribute('filter');
		if(callback != undefined)
			callback();
		});
	};
	var my_gall_obj = $('*[class*="pirobox"]');
	var map = new Object();
		for (var i=0; i<my_gall_obj.length; i++) {
			var it=$(my_gall_obj[i]);
			map['.'+ it.attr('class').match(/^pirobox_gall\w*/)]=0;
		}
	var gall_settings = new Array();
	for (var key in map) {
		gall_settings.push(key);
	}
	for (var i=0; i<gall_settings.length; i++) {
		$(gall_settings[i]+':first').attr('my_id','first');
		$(gall_settings[i]+':last').attr('my_id','last');
	}
	var piro_gallery = $(my_gall_obj);
	$('*[class*="pirobox_gall"]').each(function(rev){
		this.rev = rev+0});
	if($('*[class*="pirobox"]').length == 1){ 
	$('*[class*="pirobox"]').each(function(){
		$(this).addClass('single_fix');
		});
	}
	var	piro_capt_cont = '<div class="piro_caption"></div>';
	var struct =(
		'<div class="piro_overlay"></div>'+
		'<table class="piro_html"  cellpadding="0" cellspacing="0">'+
		'<tr>'+
		'<td class="h_t_l"></td>'+
		'<td class="h_t_c"></td>'+
		'<td class="h_t_r"></td>'+
		'</tr>'+
		'<tr>'+
		'<td class="h_c_l"></td>'+
		'<td class="h_c_c">'+
		'<div class="piro_loader" title="close"><span></span></div>'+
		'<div class="resize">'+
		'<div class="nav_big">'+
		'<a href="#next" class="piro_next" title="next"></a>'+
		'<a href="#prev" class="piro_prev" title="previous"></a>'+
		'</div>'+
		'<div class="div_reg"></div>'+
		'</div>'+
		'</td>'+
		'<td class="h_c_r"></td>'+
		'</tr>'+
		'<tr>'+
		'<td class="h_mb_l"></td>'+
		'<td class="h_mb_c">'+
		'<div class="nav_container">'+
		'<div class="nav_container_hide">'+
		'<a href="#next" class="piro_next" title="next"></a>'+
		'<div class="piro_next_fake"></div>'+
		'<div class="piro_close" title="close"></div>'+
		'<a href="#prev" class="piro_prev" title="previous"></a>'+
		'<div class="piro_prev_fake"></div>'+
		'<a href="" target="_blank" class="piro_twitter" title="share on twitter"></a>'+
		'<a href="" target="_blank" class="piro_facebook" title="share on facebook"></a>'+
		'<a href="#ZoomIn" class="piro_zoomIn" title="ZoomIn"></a>'+
		'<a href="#ZoomOut" class="piro_zoomOut" title="ZoomOut"></a>'+
		'</div>'+
		'</div>'+
		'</td>'+
		'<td class="h_mb_r"></td>'+
		'</tr>'+
		'<tr>'+
		'<td class="h_b_l"></td>'+
		'<td class="h_b_c"></td>'+
		'<td class="h_b_r"></td>'+
		'</tr>'+
		'</table>'
		);
	$('body').append(struct);
	var wrapper = $('.piro_html'),
		zoomIn = $('.piro_zoomIn'),
		zoomOut = $('.piro_zoomOut'),
		twitter = $('.piro_twitter'),
		facebook = $('.piro_facebook'),
		piro_next = $('.piro_next'),
		piro_prev = $('.piro_prev'),
		piro_next_big = $('.nav_big .piro_next'),
		piro_prev_big = $('.nav_big .piro_prev'),
		piro_next_fake = $('.piro_next_fake'),
		piro_prev_fake = $('.piro_prev_fake'),
		piro_close = $('.piro_close'),
		piro_bg = $('.piro_overlay'),
		piro_nav = $('.nav_container'),
		piro_nav_in = $('.nav_container_hide'),
		div_reg = $('.div_reg'),
		piro_loader = $('.piro_loader'),
		resize = $('.resize'),
		y = $(window).height(),
		x = $(window).width(),
		rz_img = opt.image_ratio, 
		position = -50;
		opt.padding = $('.piro_html .h_t_l').width();
		$('.piro_html .h_mb_c,.nav_container').animate({height:0},0)
	wrapper.css({left:  ((x/2)-(wrapper.width()/2))+ 'px',top: (y/2)-(wrapper.height()/2)});
	$(wrapper).add(piro_bg).hide();
	$('.nav_big').hide();
	
	piro_bg.css({'opacity':opt.bg_alpha});	
	$(piro_prev).add(piro_next).bind('click',function(c) {
		$('.piro_html .h_mb_c, .nav_container').animate({height:0},0);
		$('.nav_big').hide();
		$('.div_reg').children().fadeOut(200);
		zoomOut.css('visibility','hidden');
		$('.piro_caption').remove();
		c.preventDefault();
		var obj_count = parseInt($('*[class*="pirobox_gall"]').filter('.item').attr('rev'));
		var start = $(this).is('.piro_prev') ? $('*[class*="pirobox_gall"]').eq(obj_count - 1) : $('*[class*="pirobox_gall"]').eq(obj_count + 1);
		start.click();
	});
	$('html').bind('keyup', function (c) {
		 if(c.keyCode == 27) {
			c.preventDefault();
			if($(piro_close).is(':visible')){close_all();}
		}
	});
	$('html').bind('keyup' ,function(e) {
		 if ($('.item').attr('my_id')=='first'){
		}else if ($('.item').attr('media') == 'single'){
			piro_nav.show();
		}else if(e.keyCode == 37){
		e.preventDefault();
			if($(piro_close).is(':visible')){piro_prev_big.click();}
		 }
	});
	$('html').bind('keyup' ,function(z) {
		if ($('.item').attr('my_id')=='last'){
		}else if ($('.item').attr('media') == 'single'){
			piro_nav.show();
		}else if(z.keyCode == 39){
		z.preventDefault();
			if($(piro_close).is(':visible')){piro_next_big.click();}
		}
	});
	$(window).resize(function(){
		if(flag_scroll == false){
			var new_y = $(window).height(),
				new_x = $(window).width(),
				new_h = wrapper.outerHeight(true),
				new_w = wrapper.outerWidth(true);
				wrapper.css({
					left:  ((new_x/2)-(new_w/2))+ 'px',
					top: ((new_y-new_h)/2)-opt.padding
				});	
		}else if (flag_scroll == true){
			var new_y = $(window).height(),
				new_x = $(window).width(),
				new_h = wrapper.outerHeight(true),
				new_w = wrapper.outerWidth(true);
			wrapper.css({
				left:  ((new_x/2)-((new_w)/2)+opt.padding/2),
				top: parseInt($(document).scrollTop())+(new_y-new_h)/2 + (position/2)
			});		
		}	
			$('.piro_caption').remove();  
			
		});	
		$(window).scroll(function(){
			if(flag_scroll == false){
			return;
			}else if (flag_scroll == true){
			var new_y = $(window).height(),
				new_x = $(window).width(),
				new_h = wrapper.height(),
				new_w = wrapper.outerWidth(true);
			wrapper.css({
				//left:  ((x/2)-((imgW+40)/2)),
				left:  ((new_x/2)-((new_w)/2)),
				top: parseInt($(document).scrollTop())+(new_y-new_h)/2 + (position/2)
			});		
			}
		});
	$(piro_gallery).each(function(){
	  function nav_position(){
		piro_nav_in.each(function(){
				var nav_children = $(this).children(':visible').not('.piro_caption');
				var nav_children_not = $(this).children().not('.piro_caption').not(':visible');
				var increase = 0;
				$(nav_children).each(function(){
					increase += $(this).width()+6;
					$(this).css({'visibility':'visible'});
					$(this).css({'right':increase,'margin-right':'-20px'});
					zoomIn.css('margin-right','-30px');
					var zoom_pos = zoomIn.position();
					zoomOut.css({'right':increase,'visibility':'hidden','margin-right':'-30px'});
					$(nav_children_not).css('visibility','hidden');
					});
				});
	  		}
				
		var descr = $(this).attr('title'),
			params = $(this).attr('media').split('-'),
			p_link = $(this).attr('href');
		$(this).unbind(); 
		$(this).bind('click', function(e) {
			//zoomIn.add(zoomOut).hide();
			piro_bg.css({'opacity':opt.bg_alpha});	
			e.preventDefault();
			piro_next.add(piro_prev).hide();
			piro_next_fake.add(piro_prev_fake).hide();
			$(piro_gallery).filter('.item').removeClass('item');
			$(this).addClass('item');
			open_all();
				if(opt.share == true){
					twitter.add(facebook).show();
				}else{
					twitter.add(facebook).remove();
				}
				if($(this).attr('my_id')=='first'){
					piro_prev.add(piro_next_fake).hide();
					piro_next.add(piro_prev_fake).show();
				}else{
					piro_next.add(piro_prev).show();
					piro_next_fake.add(piro_prev_fake).hide();
				}
				
				if($(this).attr('my_id')=='last'){
					piro_prev.add(piro_next_fake).show();
					piro_next.add(piro_prev_fake).hide();	
				}
				if($(this).is('.pirobox') || $(this).is('.single_fix')){
					piro_next.add(piro_prev).hide();
					$('.nav_big,.nav_big .piro_next,.nav_big .piro_prev').css('height',0).hide();
					piro_next_fake.add(piro_prev_fake).hide();
				}
				if($(this).attr('my_id')=='last' && $(this).attr('my_id')=='first'){
					piro_next.add(piro_prev).hide();
					piro_next_fake.add(piro_prev_fake).hide();
					$('.nav_big .piro_next,.nav_big .piro_prev').css('height',0).hide();
		  	}	
		});
		function open_all(){
			$.fn.hasAttr = function(name) {  
			   return this.attr(name) !== undefined;
			};
			wrapper.add(piro_bg).add(div_reg).add(piro_loader).show();
			function animate_html(){
				piro_nav_in.add('.piro_caption').hide();
				$('.piro_zoomOut,.piro_zoomIn').css('visibility','hidden').hide();
				$('.nav_big .piro_next,.nav_big .piro_prev').css('height',0);
				  if(descr == "" || descr === undefined || descr === false ){
					  $('.piro_caption').hide();
				  }else{
					 $(piro_capt_cont).appendTo(piro_nav_in); 
				  }
				if(params[1] == 'full'){
				params[2] = $(window).height()-opt.padding*4;	
				params[1] = $(window).width()-opt.padding*3;
				}
//				if(params[0] == 'inline'){
//				params[2] = $(p_link).outerHeight();	
//				params[1] = $(p_link).outerWidth();
//				}
				var y = $(window).height();
				var x = $(window).width();
				if(parseFloat(params[2])+70>y){
					var top = 0;
					flag_scroll = false;
					}else if(params[1] == 'full'){
					flag_scroll = opt.piro_scroll;
					var top =  (parseInt($(document).scrollTop())+(y-params[2])/2+ position);
					}else{
					var top =  (parseInt($(document).scrollTop())+(y-params[2])/2+ position);
					flag_scroll = opt.piro_scroll;
					}
				piro_close.hide();
				resize.animate({
					'height':+ (params[2])
					},opt.piro_speed);
				div_reg.animate({
					'height':+ (params[2])
					},opt.piro_speed);
				wrapper.animate({
					'height':+ (params[2])+(opt.padding*2),
					'top': top
					},opt.piro_speed ,function(){
					resize.animate({
						'width':+ (params [1])
						},opt.piro_speed);
					div_reg.animate({
						'width':+ (params [1])
						},opt.piro_speed).hide();
					wrapper.animate({
						width:+ (params[1]) +(opt.padding*2),
						left:  ((x/2)-((params[1])/2+opt.padding))
						},opt.piro_speed ,function(){						
						$('.nav_big').hide();
						$('.piro_caption').html('<p>'+descr+'</p>').hide();
						$('.piro_html .h_mb_c,.nav_container').animate({height:46},300);
						piro_nav_in.show();
						piro_loader.hide();
						piro_close.show();
						div_reg.fadeIn(400);
						$('.piro_caption').fadeIn(100,function(){
						if($('.piro_caption p').height()> 28){
							$('.piro_caption p').css({'background':'url(css_pirobox/style_12/caption_up_down.png) top right no-repeat','padding-right':'18px'});
							var piro_nav_length = piro_nav_in.children(':visible').not('.piro_caption').length;
								$('.piro_caption').css('width',params[1]-(45*piro_nav_length));	
							
							$('.piro_caption').live('mouseenter',function(){
							$(this).stop().animate({'height':$(this).children('p').outerHeight(true)},400);
							});
							$('.piro_caption').live('mouseleave',function(){
								$(this).animate({'height':28},200);
							});										
						}else{
							$('.piro_caption p,.piro_caption').removeAttr('style')
						}
					})
					nav_position();
				});
			});
			}
			function animate_image (){
				flag_scroll = opt.piro_scroll;
				piro_nav_in.hide();
				$('.nav_big .piro_next,.nav_big .piro_prev').css('height',0);
					if(descr == "" || descr === undefined || descr === false ){
						$('.piro_caption').hide();
					}else{
						$(piro_capt_cont).appendTo(piro_nav_in);
					}
						var img = new Image();
						img.onerror = function (){
							$('.piro_caption').remove();
							twitter.add(facebook).hide();
							img.src = "js/error.jpg";
							img.width = '368';
							img.height = '129';
						};
						img.onload = function() {
							var this_h = img.height;
							var this_w = img.width;
							var y = $(window).height();
							var x = $(window).width();
							var	imgH = img.height;
							var	imgW = img.width;
							if(imgH+100 > y || imgW+100 > x){
								var _x = (imgW + opt.padding*2)/x;
								var _y = (imgH + opt.padding*2)/y;
								if ( _y > _x ){
									imgW = Math.round(img.width* (rz_img/_y));
									imgH = Math.round(img.height* (rz_img/_y));
								}else{
									imgW = Math.round(img.width * (rz_img/_x));
									imgH = Math.round(img.height * (rz_img/_x));
								}
								if(opt.zoom_mode == true){
								$('.piro_zoomIn').css('visibility','visible').show();
								$('.piro_zoomOut').css('visibility','hidden').hide();
								}
							}else{
								imgH = img.height;
								imgW = img.width;
								$('.piro_zoomOut,.piro_zoomIn').css('visibility','hidden').hide();
								}
							var y = $(window).height();
							var x = $(window).width();
							$(img).height(imgH).width(imgW);
							$(img).addClass('immagine');
							resize.animate({
								'height': imgH,
								},opt.piro_speed);
							div_reg.animate({
								'height': imgH
								},opt.piro_speed);
							wrapper.animate({
								'height' : (imgH+opt.padding*2),
								'top' : parseInt($(document).scrollTop())+(y-imgH)/2 + position
								},opt.piro_speed, function(){
									resize.animate({
									'width': imgW},opt.piro_speed);
								div_reg.animate({
									'width': imgW},opt.piro_speed);
								wrapper.animate({
									'width' : (imgW+opt.padding*2), 
									'left' :  ((x/2)-((imgW/2)+opt.padding))
								},opt.piro_speed,function(){
									facebook.attr('href','http://www.facebook.com/sharer.php?u='+img.src)
									twitter.attr('href','http://twitter.com/share?url='+img.src)
									piro_loader.hide();		
									var cap_w = resize.width();
									$('.nav_big,.nav_container').show();
									$('.piro_caption').html('<p>'+descr+'</p>').hide();
									$('.nav_big,.nav_big .piro_next,.nav_big .piro_prev').css({'height':imgH});
									$('.nav_big').css({'width':imgW});
									$('.div_reg img').remove();
									div_reg.html('').append(img).hide();
									$(div_reg).fadeIn(300,function(){
										$('.piro_html .h_mb_c,.nav_container').animate({height:46},300);
										piro_nav_in.show();					
									$(window).scroll(function(){
										if($('.piro_zoomOut').is(':visible')){
											div_reg.unbind('mousemove');
											$(img).css({'width':  imgW , 'height': imgH, top:0, left:0 },0,function(){
												$('.immagine').css('cursor', 'auto');
												$(img).draggable({disabled:true});
												zoomOut.css('visibility','hidden');
												zoomIn.css('visibility','visible');
											});										
										}
										});
									$('.immagine').add(zoomOut).bind('click',function(h){
										h.preventDefault();
										$('.nav_big').show();
											div_reg.unbind('mousemove');
											$(img).draggable({disabled:true});
											zoomOut.css('visibility','hidden');
											$('.immagine').css({'cursor':'auto','visibility':'visible'});
											zoomIn.css({'visibility':'visible'/*,'left':position2.left*/});
											$(img).animate({'width':  imgW , 'height': imgH, top:0, left:0 },600)
										});
									zoomIn.bind('click',function(w){
										w.preventDefault();
										$(this).css('visibility','hidden');
										zoomOut.css({'visibility':'visible'/*,'left':position.left*/}).show();
										$(img).draggable({disabled:false});
										$(img).animate({'width':  this_w , 'height': this_h , top:-(this_h-imgH)/2, left:-(this_w-imgW)/2 },600,function(){
											if(opt.move_mode == 'drag'){
												$('.nav_big').hide();
												var imgPos = div_reg.offset(),
													x1 = (imgPos.left + imgW) - this_w,
													y1 = (imgPos.top + imgH) - this_h,
													x2 = imgPos.left,
													y2 = imgPos.top;
												$(img).draggable({containment: [x1,y1,x2,y2],scrollSpeed: 400});
												$('.immagine').css('cursor', 'move');
										 	}else if(opt.move_mode == 'mousemove'){
												$(img).draggable({disabled:true});
												$('.immagine').css('cursor', 'crosshair');
												$('.nav_big').hide();
												var	div_reg_w = div_reg.width(),
													div_reg_h = div_reg.height(),
													perc_x= (this_w-div_reg_w)/div_reg_w,
													perc_y=(this_h-div_reg_h)/div_reg_h,
													last_x= 0,
													last_y= 0;
													div_reg.bind('mousemove',function(e){
														var pos_x = e.pageX-div_reg.offset().left; 
														var pos_y = e.pageY-div_reg.offset().top;
														if (Math.abs(last_x-pos_x)<=1 && Math.abs(last_y-pos_y)<=1) return;
														last_x = pos_x;
														last_y = pos_y;
														$(img).css({ left : -(perc_x*pos_x),top:-(perc_y*pos_y)});
													});
												}
										  });
									 });
									piro_close.show();
									$('.piro_caption').show(0,function(){
											var piro_nav_length = piro_nav_in.children(':visible').not('.piro_caption').length;
											if($('.piro_caption p').height()> 28 || $('.piro_caption p').width()>imgW-(43*piro_nav_length) ){
												$('.piro_caption p').css({
													'background':'url(css_pirobox/style_10/caption_up_down.png) top right no-repeat',
													'padding-right':'18px'
													});
												//var piro_nav_length = piro_nav_in.children(':visible').not('.piro_caption').length;
												$('.piro_caption').css('width',imgW-(43*piro_nav_length));	
												$('.piro_caption').live('mouseenter',function(){
												$(this).stop().animate({'height':$(this).children('p').outerHeight(true)},400);
												});
												$('.piro_caption').live('mouseleave',function(){
													$(this).animate({'height':28},200);
												});										
											}else{
												$('.piro_caption p,.piro_caption').removeAttr('style')
											}
											$(this).fadeTo(200,1)
										});
									nav_position();
								});	
							});	
							});	
						};
						img.src = p_link;
						piro_loader.click(function(){
						close_all();
					});
				
				}

			switch (params[0]) {
				case 'iframe':
					div_reg.html('').css('overflow','hidden');
					resize.css('overflow','hidden');
					animate_html();
					div_reg.piroFadeIn(300,function(){
						div_reg.append(
						'<iframe id="my_frame" class="my_frame" src="'+p_link+'" frameborder="0" allowtransparency="true" scrolling="auto" align="top"></iframe>'
						);
						$('.my_frame').css({'height':+ (params[2]) +'px','width':+ (params [1])+'px'});
						twitter.add(facebook).hide().css('visibility','hidden');
					});
				break;
				case 'content':
					div_reg.html('').css('overflow','auto');
					resize.css('overflow','auto');
					$('.my_frame').remove();
					animate_html();
					div_reg.piroFadeIn(300,function(){
						div_reg.load(p_link);
						twitter.add(facebook).hide().css('visibility','hidden');;
					});
				break;
				case 'inline':
					div_reg.html('').css('overflow','auto');
					resize.css('overflow','auto');
					$('.my_frame').remove();
					animate_html();
					div_reg.piroFadeIn(300,function(){
						$(p_link).clone(true).appendTo(div_reg).addClass('clone');
						$('.clone').css('margin-top','0').piroFadeIn(300);
						twitter.add(facebook).hide().css('visibility','hidden');
					});
				break;
				case 'flash':
				$('.my_frame').remove();
				div_reg.html('').css('overflow','hidden');
				animate_html();
					var flash_cont =(
					'<object  width="'+params[1]+'" height="'+params[2]+'">'+
					'<param name="movie" value="'+ p_link +'" />'+
					'<param name="wmode" value="transparent" />'+
					'<param name="allowFullScreen" value="true" />'+
					'<param name="allowscriptaccess" value="always" />'+
					'<param name="menu" value="false" />'+
					'<embed src="'+ p_link +'" type="application/x-shockwave-flash" allowscriptaccess="always" menu="false" wmode="transparent" allowfullscreen="true" width="'+params[1]+'" height="'+params[2]+'">'+
					'</embed>'+
					'</object>');
					div_reg.piroFadeIn(300,function(){
					$(flash_cont).appendTo(div_reg);
					twitter.add(facebook).hide().css('visibility','hidden');
					});
				break;
				case 'gallery':
					div_reg.css('overflow','hidden');
					resize.css('overflow','hidden');
					$('.my_frame').remove();
					animate_image();
				break;
				case 'single':
					$('.my_frame').remove();
					div_reg.html('').css('overflow','hidden');
					resize.css('overflow','hidden');
					animate_image();
				break;
			} 	
		}
	});
	
	function close_all (){
		if($('.piro_close').is(':visible')){}
				$('.my_frame').add('.piro_caption').remove();
				wrapper.add(div_reg).add(resize).stop();
				var ie_sucks = wrapper;
				if ( $.browser.msie ) {
					ie_sucks = div_reg.add(piro_bg);
					$('.div_reg img').remove();
				}else{
					ie_sucks = wrapper.add(piro_bg);
				}
				ie_sucks.piroFadeOut(200,function(){
					div_reg.html('');
					piro_loader.hide();
					piro_nav_in.hide();
					$('.piro_html .h_mb_c,.nav_container').animate({height:0},0);
					piro_bg.add(wrapper).hide().css('visibility','visible');
					
				});
			
		}
		piro_close.add(piro_loader).add(piro_bg).bind('click',function(y){y.preventDefault(); close_all();});	
	}
})(jQuery);
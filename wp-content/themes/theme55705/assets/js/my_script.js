(function($){

	$(document).ready(function(){

		$('#menu-primary>#menu-primary-items>li>a').each(function(){
	        var $this = $(this),
	            txt = $this.text();
				if (txt === "facebook") {
					$this.html('<div class="txt_menu"><span><i class="fa fa-facebook-square"></i></span></div><div class="txt_menu"><span><i class="fa fa-facebook-square"></i></span></div>');
				} else {
					$this.html('<div class="txt_menu"><span>'+ txt +'</span></div><div class="txt_menu"><span>'+ txt +'</span></div>');
				}
		        //$this.html('<div class="txt_menu"><span>'+ txt +'</span></div><div class="txt_menu"><span>'+ txt +'</span></div>');
		});

		//$('.cherry-navigation-arrow').each(function(){
			$('.cherry-navigation-arrow').find('.menu-item-has-children').each(function(){
				_this = $(this),
				_this.find(".txt_menu").append('<div class="arrow_mov"></div>');
			});
		//});


		$('.post.type-post').each(function(){
			_this = $(this);
			_this.find('.entry-thumbnail').insertAfter(_this.find('.entry-header'));
		});

		$(window).resize(
		   function(){

		    	//$('.static-footer-sidebar5').width($(window).width());
				//$('.static-footer-sidebar5').css({width: $(window).width(), "margin-left": ($(window).width()/-2), 'left':'50%'});

		   }

		).trigger('resize');


	});


})(jQuery);

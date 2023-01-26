
( function() {

})();

jQuery(document).ready(function($) {
	var body = $('body');

	jQuery(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if (scroll >= 25) {
			body.addClass("scrolled");
		} else {
			body.removeClass("scrolled");
		}

	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
	       body.addClass("near-bottom");
	   } else {
			body.removeClass("near-bottom");
	   }

	});

});



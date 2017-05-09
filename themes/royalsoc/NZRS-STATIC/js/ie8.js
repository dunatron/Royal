

(function($) {
	
	$(document).ready(function(){

		// ref - http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
		$('[placeholder]').focus(function() {
		  var input = $(this);
		  if (input.val() === input.attr('placeholder')) {
		    input.val('');
		    input.removeClass('placeholder');
		  }
		}).blur(function() {
		  var input = $(this);
		  if (input.val() === '' || input.val() == input.attr('placeholder')) {
		    input.addClass('placeholder');
		    input.val(input.attr('placeholder'));
		  }
		}).blur();

		// alert('ie8 v1');
		// depreciated
		$('.hamburger').on('click', function(event) {
			event.preventDefault();
			/* Act on the event */
			alert('hamburger clicked');
			$('.filling').addClass('filling-animate'); // working
			// $('.filling').addClass('collapse-menu');
			// $(".nav-wrapper").addClass('burger-fade');
		});

		// alert('ie8 v2');

	});

	// $('.hamburger').click(function(){
	// 	alert('hamburger clicked');
	// 	$('.filling').addClass('filling-animate');
	// 	$('.filling').addClass('collapse-menu');
	// 	$('.nav-wrapper').addClass('burger-fade');
	// });




	// $('.hamburger-close').click(function(){
	// 	$('.nav-wrapper').removeClass('burger-fade');
	// 	$('.filling').removeClass('filling-animate');
	// 	$('.filling').removeClass('collapse-menu');
	// });

})(jQuery_1_12_4);
$( document ).ready(function() {
	$('.bxslider').bxSlider({
	  nextSelector: '#slider-next',
	  prevSelector: '#slider-prev',
	  nextText: '',
	  prevText: '',
	  onSliderLoad: function(currentIndex) {
      $(".slider-title").html($('.bxslider li').eq(currentIndex).attr("title"));
      $(".slider-text").html($('.bxslider li').eq(currentIndex).attr("alt"));
      },
	  onSlideBefore: function($slideElement, oldIndex, newIndex) {
	    $(".slider-title").html($slideElement.attr("title"));
	    $(".slider-text").html($slideElement.attr("alt"));
	  }
	});

});
$( document ).ready(function() {
	



	function ajaxPopulateSlider(filter){
	$('#custom-slide-id .top-slide.tablet-slide').empty();
	$('.sliderloader').show();
	$('#custom-slide-id .bottom-slide.tablet-slide').empty();



	$.ajax({
			url: "/microsite/SliderContent",
			data: "atype="+filter,
			method: "POST"
		})
		.done(function(response){
			$('#custom-slide-id .top-slide.tablet-slide').empty();
			$('#custom-slide-id .bottom-slide.tablet-slide').empty();
			$('.sliderloader').hide();
        	var htmlSlideItemArray = response.split('</li>');
			var topSlideCount = 0;
			var botSlideCount = 0;
			var htmlSlideObject = '';
			var slideSizeCount = 0;
			//var topbot = '';
			for(var i=0;i<htmlSlideItemArray.length;i++) {
					//alert(htmlSlideItemArray[i]);
					htmlSlideObject = $.parseHTML(htmlSlideItemArray[i]);

					if(topSlideCount<=botSlideCount){
						//slideSizeCount = 0;
						//topbot='top';
						
						$(".hidden-slide-sort").append(htmlSlideObject);

						if($(".hidden-slide-sort").find('.project-image').hasClass('no-image')){
							slideSizeCount = 1;
							
						}
						else{
							slideSizeCount = 2;

						}
						$(".hidden-slide-sort").find('.project-item').remove();

						$('#custom-slide-id .top-slide.tablet-slide').append(htmlSlideObject);
						topSlideCount = topSlideCount+slideSizeCount;
						
						
						
					}
					else{
						//slideSizeCount = 0;
						//topbot='bot';
						$(".hidden-slide-sort").append(htmlSlideObject);
						if($(".hidden-slide-sort").find('.project-image').hasClass('no-image')){
							slideSizeCount = 1;
							
						}
						else{
							slideSizeCount = 2;

						}
						$(".hidden-slide-sort").find('.project-item').remove();
						$('#custom-slide-id .bottom-slide.tablet-slide').append(htmlSlideObject);
						botSlideCount = botSlideCount+slideSizeCount;
						
					}
				}
			setItemWidth();
		});
	}

	function getSlideWidth(){
		var width = 0;
		if ($(window).width()>=768){
			width = $('.custom-slide-container').width();
			return (parseInt(width/3))+parseInt((width/3));
		}
		else{
			width = $('.custom-slide-container').width();
			return parseInt(width);
		}
		
	}





	var totalScrollWidthTop = 0;
	var totalScrollWidthBot = 0;
	function setItemWidth(){
		var widthcount = 0;
		totalScrollWidthTop = 0;
		totalScrollWidthBot = 0;
		$('.button-next').addClass('button-next-remove');
		$('.button-prev').addClass('button-prev-remove');
		var width = parseInt(getSlideWidth());

		
		$('.top-slide').find('.project-item').each(function(){
			if($(this).find('.project-image').hasClass('no-image')){
				$(this).find('.project-image').addClass('hide');
				$(this).find('.project-text').removeClass('sml-col-6');
				width=width/2;
			}
			$(this).css('width',width);
			$(this).css('left',widthcount);
			widthcount = widthcount + width;
			width = parseInt(getSlideWidth());
			totalScrollWidthTop = totalScrollWidthTop + parseInt($(this).css('width').replace('px',''));
		});
		widthcount = 0;

		$('.bottom-slide').find('.project-item').each(function(){

			if($(this).find('.project-image').hasClass('no-image')){
				$(this).find('.project-image').addClass('hide');
				$(this).find('.project-text').removeClass('sml-col-6');
				width=width/2;
			}
			$(this).css('width',width);
			$(this).css('left',widthcount);
			widthcount = widthcount + width;
			width = parseInt(getSlideWidth());
			totalScrollWidthBot = totalScrollWidthBot + parseInt($(this).css('width').replace('px',''));
		});


		//Check if enough items to enable scroll buttons
		if(totalScrollWidthTop > $('.custom-slide-container').width()){
			$('.button-next').removeClass('button-next-remove');
		}
		else if(totalScrollWidthBot > $('.custom-slide-container').width()){
			$('.button-next').removeClass('button-next-remove');
		}
		else{
			
			$('.button-next').addClass('button-next-remove');
		}

		
	}

 	ajaxPopulateSlider($('#micrositetag').val());

	//setSliderHTML();
	setItemWidth();
	var windowWidth = $(window).width();

	$(window).resize(function (){
		if ($(window).width() != windowWidth)
		{
			setItemWidth();
		}
	});

	var animationStatus = true;
	var leftValue = 0;
	var leftValueNew = 0;
	var firstItemStatus = 'good';

	var result = 'good';
	var slideItemLeft = 0;
	var slideItemWidth = 0;

	var lastItemStatusTop = 'good';
	var lastItemStatusBot = 'good';

	function checkFirstSlide(slideElement,width){
		result= 'good';
		slideItemLeft = slideElement.css('left').replace('px','');
		slideItemWidth = slideElement.width();
		if(slideItemWidth == width){
			if(slideItemLeft == -width/2){
				result = 'bad';
			}
		}
		else if(slideItemWidth == width/2){
			if(slideItemLeft == -width/2){
				result = 'bad';
			}
		}

		return result;
	}

	function checkLastSlide(slideElement,width){
		result = 'good';
		slideItemLeft = slideElement.css('left').replace('px','');

		//alert(slideItemLeft);
		slideItemWidth = slideElement.width();
		if(slideItemWidth == width){
			if(slideItemLeft <= width){
				result = 'bad';
			}
		}
		else if(slideItemWidth == width/2) {
			 if(slideItemLeft <= width+width/2){
				result = 'bad';
			}
		}
		return result;
	}

	function prevPageSlide(){
		

		if(animationStatus == true){

			//Tablet functions
			$('.top-slide').find('.project-item').each(function(i,item){
				animationStatus = false;
				//var check = checkPosition('prev');
				var width = getSlideWidth();
				$('.button-prev').addClass('button-prev-remove');
				$('.button-next').removeClass('button-next-remove');

				// if (check > 1){
					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)+width/2;
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});				  	
				// }
				// else{
					
				// 	animationStatus = true;
				// }

				if(i == 0){
					firstItemStatus = checkFirstSlide($(this),width);
				}

			});

			$('.bottom-slide').find('.project-item').each(function(i,item){

				animationStatus = false;
				//var check = checkPosition('prev');
				var width = getSlideWidth();
				$('.button-prev').addClass('button-prev-remove');
				$('.button-next').removeClass('button-next-remove');

				// if (check > 1){
					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)+width/2;

					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				// }
				// else{
				
				// 	animationStatus = true;
				// }
				if(i == 0){
					firstItemStatus = checkFirstSlide($(this),width);
				}

				$(this).addClass('scrolled');
			});
		}

		if(firstItemStatus == 'bad'){
			$('.button-prev').addClass('button-prev-remove');
		}
	}

	function nextPageSlide(){
		firstItemStatus = 'good';
		if(animationStatus == true){
			var arrTopLength = 0;
			$('.top-slide').find('.project-item').each(function(i,item){
				arrTopLength = i;
			});
			
			//Tablet functions
			$('.top-slide').find('.project-item').each(function(i,item){
				animationStatus = false;
				//var check = checkPosition('next');
				var width = getSlideWidth();
				$('.button-next').addClass('button-next-remove');
				$('.button-prev').removeClass('button-prev-remove');
				 // if (check >= 0){
					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)-width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});

				if(i == arrTopLength){
					lastItemStatusTop = checkLastSlide($(this),width);
				}
				$(this).addClass('scrolled');
			});

			var arrBotLength = 0;
			$('.bottom-slide').find('.project-item').each(function(i,item){
				arrBotLength =i;
			});

			$('.bottom-slide').find('.project-item').each(function(i,item){
				animationStatus = false;
				var width = getSlideWidth();
				$('.button-next').addClass('button-next-remove');
				$('.button-prev').removeClass('button-prev-remove');
					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)-width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-next').removeClass('button-next-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				if(i == arrBotLength){

					lastItemStatusBot = checkLastSlide($(this),width);
				}
				$(this).addClass('scrolled');
			});
			
		}
		if(lastItemStatusTop == 'bad' && lastItemStatusBot == 'bad'){
			$('.button-next').addClass('button-next-remove');
		}
	}
	$('.button-next').click(function(){
		nextPageSlide();
	});

	$('.button-prev').click(function(){
		prevPageSlide();
	});

	var myElement = document.getElementById('custom-slide-id');
    var mc = new Hammer(myElement);
    mc.on("swipeleft", function() {
    	nextPageSlide();
    });
    mc.on("swiperight", function() {
    	prevPageSlide();
    });
});
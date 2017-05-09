

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


	if($('.homepage').length){

		$('.communities-trigger').click(function(){
			$(this).removeClass('desktop-land-trigger');
			$('.communities-background').removeClass('desktop-land-expand');
			if($(this).hasClass('communities-trigger-active')){
				$(this).removeClass('communities-trigger-active');
			}
			else{
				$(this).addClass('communities-trigger-active');
			}
			if($('.communities-background').hasClass('communities-background-active')){
				$('.communities-background').removeClass('communities-background-active');
			}
			else{
				$('.communities-background').addClass('communities-background-active');
			}
		});



		$('.filter').click(function(e){
			e.preventDefault();
			$('.filter').removeClass('filter-active');
			$(this).addClass('filter-active');
		});

		function panelImageResize(){
			$('.panel-img').width($('.panel-img-container').width()+10);
		}
		panelImageResize();



		function hoverHomepagePanelStates(){
			if ($(window).width()>=768){
				
				$( ".panel-img-container" ).hover(function(){
					$('.backdrop-slide').removeClass('backdrop-slide-active');
					$(this).find('.backdrop-slide').addClass('backdrop-slide-active');
				});
			}
			else{
			$('.panel-text').click(function(e){
				if($(this).parent().hasClass('backdrop-slide-active')){
					}
					else{
						e.preventDefault();
					}
				});

				$('.panel-img-container').click(function(){
					$('.backdrop-slide').removeClass('backdrop-slide-active');

					$(this).find('.backdrop-slide').addClass('backdrop-slide-active');
				});
			}
		}
		hoverHomepagePanelStates();


		//var filter = '';
		
		//displayHomepagePanels(filter);
		
		
		function displayHomepagePanels(filter){
			
			if (filter === 'research' || filter === 'researchers'){
				$('.stuteach').removeClass('panel-active');
				$('.curious').removeClass('panel-active');
				$('.research').addClass('panel-active');
				
			}
			else if(filter === 'stuteach' || filter === 'teachersandstudents'){
				$('.research').removeClass('panel-active');
				$('.curious').removeClass('panel-active');
				$('.stuteach').addClass('panel-active');
				
			}
			else{
				$('.research').removeClass('panel-active');
				$('.stuteach').removeClass('panel-active');
				$('.curious').addClass('panel-active');

			}
		}

		function ajaxPopulateHomepageSlider(filter){
			displayHomepagePanels(filter);
			//$('#custom-slide-id .mobile-slide').empty();
			$('#custom-slide-id .top-slide.tablet-slide').empty();
			$('.sliderloader').show();
			$('#custom-slide-id .bottom-slide.tablet-slide').empty();

			var boxIDs = new Array();

			$(".panel-container.panel-active .panel-item").each(function(){
				boxIDs.push($(this).attr('panel-page-id'));
			});


	    	$.ajax({
					url: "/homefunction/SliderContent",
					data: "atype="+filter+"&boxids="+JSON.stringify(boxIDs),
					method: "POST"
					//async: false
				})
				.done(function(response){
					$('#custom-slide-id .top-slide.tablet-slide').empty();
					$('#custom-slide-id .bottom-slide.tablet-slide').empty();
					$('.sliderloader').hide();
					//$('#custom-slide-id .mobile-slide').html(response);

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
						//	slideSizeCount = 0;
						//	topbot='top';
							
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
					


	            	//setSliderHTML();
					setItemWidth();
					if(filter == 'researchers' || filter == 'research')
					{
						$('.filter-buttons .filter-research').addClass('filter-active');
					}
					else if(filter == 'teachersandstudents' || filter == 'stuteach')
					{
						$('.filter-buttons .filter-stuteach').addClass('filter-active');
					}
					else
					{
						$('.filter-buttons .filter-curious').addClass('filter-active');
					}
				});
		}


		$('.filter-research').click(function(){
			var filter = 'research';
			ajaxPopulateHomepageSlider(filter);
			$('#audiencetype').val('researchers');
			setAudienceCookie('researchers');
		});
		$('.filter-stuteach').click(function(){
			var filter = 'stuteach';
			ajaxPopulateHomepageSlider(filter);
			$('#audiencetype').val('teachersandstudents');
			setAudienceCookie('teachersandstudents');
		});
		$('.filter-curious').click(function(){
			var filter = 'curious';
			ajaxPopulateHomepageSlider(filter);
			$('#audiencetype').val('all');
			setAudienceCookie('all');
		}); 

		function setAudienceCookie(atype)
		{
			$.ajax({
				url: "/homefunction/SetAudienceCookie",
				method: "POST",
				data: "royalsocietyaudience="+atype
			});
		}
		ajaxPopulateHomepageSlider($('#audiencetype').val());




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

		//setSliderHTML();
		setItemWidth();
		var windowWidth = $(window).width();

		$(window).resize(function (){
			if ($(window).width() != windowWidth)
			{
				setItemWidth();
				panelImageResize();
				hoverHomepagePanelStates();
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

					var width = getSlideWidth();
					$('.button-prev').addClass('button-prev-remove');
					$('.button-next').removeClass('button-next-remove');

					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)+width/2;
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});				  	

					if(i == 0){
						firstItemStatus = checkFirstSlide($(this),width);
					}

				});

				$('.bottom-slide').find('.project-item').each(function(i,item){

					animationStatus = false;
					var width = getSlideWidth();
					$('.button-prev').addClass('button-prev-remove');
					$('.button-next').removeClass('button-next-remove');

					leftValue = $(this).css('left').replace('px','');
					leftValueNew = parseInt(leftValue)+width/2;

					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});

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

	    // listen to events...
	    mc.on("swipeleft", function() {
	    		nextPageSlide();

	       
	    });
	    mc.on("swiperight", function() {

	    		prevPageSlide();

	    });


	}

	else if($('.microsite').length){

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

 
	}

	var ship = $('#Form_BookForm_Shipping');
	var qtyCheck = $('#Form_BookForm_QtyCheck');
	var unitPrice = $('#Form_BookForm_UnitPrice').val();
	var varShipCostNZ = $('#Form_BookForm_ShipNZ').val();
	var varShipCostAUS = $('#Form_BookForm_ShipAUS').val();
	var varShipCostINTER = $('#Form_BookForm_shipINTER').val();
	var shipCost = 0;
	var totalCost = 0;
	function updateVals(){
		console.log('changed'+varShipCostNZ+' '+varShipCostAUS+' '+varShipCostINTER+' ');

		if(qtyCheck.prop('checked') ){
			shipCost = 'TBC';
			totalCost = 'TBC';
			$('#orderFormUnitShipping').text(shipCost);
			$('#orderFormUnitTotal').text(totalCost);
			$('.qty-label').removeClass('hide');
		}
		else{
			if(ship.val() == 'NZ'){
				shipCost = varShipCostNZ;
			}
			else if(ship.val() == 'AU'){
				shipCost = varShipCostAUS;
			}
			else{
				shipCost = varShipCostINTER;
			}
			totalCost = parseInt(shipCost)+parseInt(unitPrice);
			console.log(shipCost+' '+unitPrice);
			$('.qty-label').addClass('hide');
			$('#orderFormUnitShipping').text('$'+shipCost);
			$('#orderFormUnitTotal').text('$'+totalCost.toFixed(2));
		}
		
		
		

		

	}



    $(ship).on('change',function(){
       updateVals();
    });
    $(qtyCheck).on('change',function(){
       updateVals();
    });
    updateVals();

	






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
$( document ).ready(function() {


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

	//var filter = '';
	
	//displayHomepagePanels(filter);
	ajaxPopulateHomepageSlider($('#audiencetype').val());
	
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
		$('#custom-slide-id .mobile-slide').empty();
		$('#custom-slide-id .top-slide.tablet-slide').html('loading...');
		
		$('#custom-slide-id .bottom-slide.tablet-slide').empty();

		var boxIDs = new Array();

		$(".panel-container.panel-active .panel-item").each(function(){
			boxIDs.push($(this).attr('panel-page-id'));
		});


    	$.ajax({
				url: "/home/SliderContent",
				data: "atype="+filter+"&boxids="+JSON.stringify(boxIDs),
				method: "POST"
				//async: false
			})
			.done(function(response){
				$('#custom-slide-id .top-slide.tablet-slide').empty();
				$('#custom-slide-id .bottom-slide.tablet-slide').empty();
				$('#custom-slide-id .mobile-slide').html(response);
            	setSliderHTML();
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
			url: "/home/SetAudienceCookie",
			method: "POST",
			data: "royalsocietyaudience="+atype
		});
	}

	function setSliderHTML(){
		var htmlArray = [];
		var htmlArrayTop = [];
		var htmlArrayBot = [];
		var i = 0;
		var count = 0;
		if ($(window).width()>=768){
			htmlArray = [];
			$('.mobile-slide').find('.project-item').each(function(){
				htmlArray.push('<li class="project-item">'+$(this).html()+'</li>');
			});
			count = htmlArray.length;
			for(i = 0; i<count;i+=4){
				$('.top-slide').append(htmlArray[i]);
				$('.top-slide').append(htmlArray[i+1]);
			}

			for(i = 2; i<count;i+=4){
				$('.bottom-slide').append(htmlArray[i]);
				$('.bottom-slide').append(htmlArray[i+1]);
			}
			$('.mobile-slide').find('.project-item').each(function(){
				$(this).remove();
			});

		}
		else{
			htmlArrayTop = [];
			htmlArrayBot = [];
			count = 0;
			$('.top-slide').find('.project-item').each(function(){
				htmlArrayTop.push('<li class="project-item">'+$(this).html()+'</li>');
			});
			$('.bottom-slide').find('.project-item').each(function(){
				htmlArrayBot.push('<li class="project-item">'+$(this).html()+'</li>');
			});

			count = htmlArrayTop.length;

			for(i=0;i<count;i+=2){
				$('.mobile-slide').append(htmlArrayTop[i]);
				$('.mobile-slide').append(htmlArrayTop[i+1]);
				$('.mobile-slide').append(htmlArrayBot[i]);
				$('.mobile-slide').append(htmlArrayBot[i+1]);
			}

			$('.top-slide').find('.project-item').each(function(){
				$(this).remove();
			});
			$('.bottom-slide').find('.project-item').each(function(){
				$(this).remove();
			});


		}
	}


	function getSlideWidth(){
		var width = $('.custom-slide-container').width();
		if ($(window).width()>=768){
			return (parseInt(width/3))+parseInt((width/3));
		}
		else{
			return parseInt(width);
		}
		
	}
	function setItemWidth(){
		var widthcount = 0;
		var width = parseInt(getSlideWidth());
		if ($(window).width()>=768){
			$('.top-slide').find('.project-item').each(function(){
				$(this).css('width',width);
				$(this).css('left',widthcount);
				widthcount = widthcount + width;
			});
			widthcount = 0;
			$('.bottom-slide').find('.project-item').each(function(){
				$(this).css('width',width);
				$(this).css('left',widthcount);
				widthcount = widthcount + width;
			});
		}
		else{
			$('.mobile-slide').find('.project-item').each(function(){
				$(this).css('width',width);
				$(this).css('top',widthcount);
				widthcount = widthcount + 190;
			});
		}


		
		
	}

	setSliderHTML();
	setItemWidth();
	var windowWidth = $(window).width();

	$(window).resize(function (){
		if ($(window).width() != windowWidth)
		{
			setSliderHTML();
			setItemWidth();
		}
	});


	function checkPosition(button){
		var check = 0;
		var passfail = 0;
		//if tablet
		if ($(window).width()>=768){
			if (button === 'next'){
				$('.top-slide').find('.project-item').each(function(){

					if(parseInt($(this).css('left').replace('px',''))>=0){
						//if less or = to 0 fail
						passfail = 1;
					}
					else{
						//else pass
						passfail = 0;
					}
					check = check+passfail;
				});


			}
			else if ( button === 'prev'){
				var width = getSlideWidth();
				//alert(width);
				$('.top-slide').find('.project-item').each(function(){

					if(parseInt($(this).css('left').replace('px',''))>=width){
						//if greater than or = to 400 fail
						passfail = 0;
					}
					else{
						//else pass
						passfail = 1;
					}
					check = check+passfail;
				});

			}
		}
		//if mobile
		else{
			if (button === 'next'){
				$('.mobile-slide').find('.project-item').each(function(){
					if(parseInt($(this).css('top').replace('px',''))<=190){
						//if greater than or = to 400 fail
						passfail = 0;
					}
					else{
						//else pass
						passfail = 1;
					}
					check = check+passfail;
				});
			}
			else if ( button === 'prev'){
				$('.mobile-slide').find('.project-item').each(function(){
					if(parseInt($(this).css('top').replace('px',''))<=0){
						//if greater than or = to 400 fail
						passfail = 1;
					}
					else{
						//else pass
						passfail = 0;
					}
					check = check+passfail;
				});
			}
		}

		//alert(check);
		return check;

	}
	var animationStatus = true;
	function prevPageSlide(){

		if(animationStatus == true){
			$('.mobile-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('prev');
				if (check >= 2){
					
					var topValue = $(this).css('top').replace('px','');
					var topValueNew = parseInt(topValue)+190;
					//$(this).css('top',topValueNew+'px');
					$('.button-next').removeClass('button-next-remove');

					$( $(this) ).animate({
					    	top: topValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				  	
				}
				else{
					$('.button-prev').addClass('button-prev-remove');
					animationStatus = true;
				}
			});
		


			//Tablet functions
			$('.top-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('prev');
				var width = getSlideWidth();
				//alert(check);
				

				if (check > 1){
					var leftValue = $(this).css('left').replace('px','');
					// $(this).css('left',leftValue+400);
					var leftValueNew = parseInt(leftValue)+width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-next').removeClass('button-next-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				}
				else{
					$('.button-prev').addClass('button-prev-remove');
					animationStatus = true;
				}
				$(this).addClass('scrolled');


			});

			$('.bottom-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('prev');
				var width = getSlideWidth();
				//alert(check);
				//alert(check);

				if (check > 1){
					var leftValue = $(this).css('left').replace('px','');
					// $(this).css('left',leftValue+400);
					var leftValueNew = parseInt(leftValue)+width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-next').removeClass('button-next-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				}
				else{
					$('.button-prev').addClass('button-prev-remove');
					animationStatus = true;
				}
				$(this).addClass('scrolled');
			});
		}
	}

	function nextPageSlide(){
		if(animationStatus == true){
			$('.mobile-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('next');
				
				if (check >= 1){
					var topValue = $(this).css('top').replace('px','');
					var topValueNew = parseInt(topValue)-190;
					//$(this).css('top',topValueNew+'px');
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	top: topValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				}
				else{
					$('.button-next').addClass('button-next-remove');
					animationStatus = true;
					
				}
			});


			//Tablet functions
			$('.top-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('next');
				var width = getSlideWidth();

				 if (check > 1){
					var leftValue = $(this).css('left').replace('px','');
					var leftValueNew = parseInt(leftValue)-width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				}
				else{
					$('.button-next').addClass('button-next-remove');
					animationStatus = true;
				}
				$(this).addClass('scrolled');
			});

			$('.bottom-slide').find('.project-item').each(function(){
				animationStatus = false;
				var check = checkPosition('next');
				var width = getSlideWidth();

				 if (check > 1){
					var leftValue = $(this).css('left').replace('px','');
					var leftValueNew = parseInt(leftValue)-width/2;
					//$(this).css('left',leftValueNew+'px');
					$('.button-prev').removeClass('button-prev-remove');
					$( $(this) ).animate({
					    	left: leftValueNew+'px',
					  	}, 250, function() {
					    animationStatus = true;
				  	});
				}
				else{
					$('.button-next').addClass('button-next-remove');
					animationStatus = true;
				}
				$(this).addClass('scrolled');
			});
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
});

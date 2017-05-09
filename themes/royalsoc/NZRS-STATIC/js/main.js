$( document ).ready(function() {



	$('.hamburger').click(function(){
		$('.filling').addClass('filling-animate');
		$('.filling').addClass('collapse-menu');
		$('.nav-wrapper').addClass('burger-fade');
	});

	$('.hamburger-close').click(function(){
		$('.nav-wrapper').removeClass('burger-fade');
		$('.filling').removeClass('filling-animate');
		$('.filling').removeClass('collapse-menu');
	});


	//search nav
	$('.search').click(function(){
		$('.search-wrapper').addClass('search-fade');
	});

	$('.close-button').click(function(){
		$('.search-wrapper').removeClass('search-fade');

	});

	$('.filter-trigger').click(function(){
		if($(this).hasClass('filter-trigger-active')){
			$(this).removeClass('filter-trigger-active');
			$('.filter-wrap').removeClass('filter-wrap-active');
			$('.container').css('min-height','auto');
			$('.results-container').css('opacity','1');
		}
		else{
			$(this).addClass('filter-trigger-active');
			$('.filter-wrap').addClass('filter-wrap-active');
			$('.container').css('min-height',$('.filter-wrap').height());
			$('.results-container').css('opacity','0.35');
		}

	});


	$('.file-button').click(function(){
		$(this).prop('readonly', false);
		$(this).parent().find('.uploadtrig').click();
		$(this).prop('readonly', true);
	});

	$('.uploadtrig').on("change", function(){ 
		uploadFile($(this));
	});

	function uploadFile(upload){
		var fullpath = upload.val();
		var filepath = fullpath.split('\\').reverse();

		$(upload).parent().find('.file-button').val(filepath[0]);
		if($(upload).parent().find('.file-button').val()===''){
			$(upload).parent().find('.file-button').val('Upload a file...');
		}

	}
	//nav menu - INCOMPLETE
	$('.inactive').click(function(event){


		if($(this).css('display')==='block'){

		}
		else{
			if($(this).hasClass('active')){

			}
			else{
				event.preventDefault();

			//reset states
			$('.children').removeClass('children-active');
			$('.parent').find('.arrow-container').removeClass('arrow-rotate-nav');
			$('.parent').find('.inactive').removeClass('active');

			//set states per parent on click
			$(this).parent().find('.children').addClass('children-active');
			$(this).parent().find('.arrow-container').addClass('arrow-rotate-nav');
			$(this).addClass('active');

			
			}
		}

	});


	$('#member-sort').on('change', function(){
		var Grade = $(this).val();
		$('.content-wrapper #list-title span').html(Grade+'s')
		$('.container .member-list-container').html('Loading...');
		$.ajax({
			url: "/members/People",
			data: "Grade="+Grade,
			method: "POST"
		})
		.done(function(response){
			$('.container .member-list-container').html(response);
			memberModal();
		});
	});

	function memberModal(){
		$('.member-click').click(function(){
			var memberID = $(this).attr('id');

			$.ajax({
				url: "/members/Person",
				data: "ID="+memberID,
				method: "POST",
				async: false
			})
			.done(function(response){
				$('#memberModal .modal-body').html(response);
			});
			$('memberModal').modal('show');
		});
	}
	memberModal();


	$('.event-create').find('a').click(function(){
		$('#eventModal').modal('show');

	});

	
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

	var filter = '';
	displayHomepagePanels(filter);
	function displayHomepagePanels(filter){

		if (filter === 'research'){
			$('.stuteach').removeClass('panel-active');
			$('.curious').removeClass('panel-active');
			$('.research').addClass('panel-active');
		}
		else if(filter === 'stuteach'){
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


		//remove this IF to commence working on ajax
		if (1===200){
			var url = window.location.href;
	        $.ajax({
	            type:"POST",
	            url: url + '/generateSlideItems',
	            //Send clicked filter value
	            data: {Value:filter},
	            success: function (arrayOfSliders) {
	            	//Set count of total sliders returned
	            	var sliderCount = arrayOfSliders.length;
	            	//for each slider returned, append to mobile container
	            	for(var i=0;i<sliderCount;i++){
	            		$('.mobile-slide').append(arrayOfSliders[i]);
	            	}
	            	//populates desktop slider container
	            	setSliderHTML();
	            	//resizes each slide depending on device screen size
					setItemWidth();

	            },
	            complete: function(){

	            }
	        });
    	}

	}


	$('.filter-research').click(function(){
		var filter = 'research';
		ajaxPopulateHomepageSlider(filter);
	});
	$('.filter-stuteach').click(function(){
		var filter = 'stuteach';
		ajaxPopulateHomepageSlider(filter);

	});
	$('.filter-curious').click(function(){
		var filter = 'curious';
		ajaxPopulateHomepageSlider(filter);

	}); 


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


	/*slider here below*/

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



	//Gestures
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
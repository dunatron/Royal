$( document ).ready(function() {


	//sharebottombanner alignment
	function adjustShareBanner(){
		$('.bottom-share').find('.right-share').css('background-position','left '+$('.right-share').find('.rstitle').outerWidth()+'px center');
		if ($(window).width()>=768){
			$('.bottom-share').find('.left-share').css('max-width',$('.container').width()-$('.right-share').width());
		}
		else{
			$('.bottom-share').find('.left-share').css('max-width',$('.container').width());
			$('.left-share').find('.lstitle').css('max-width',$('.container').width()-40);
			$('.bottom-share').find('.left-share').css('height',$('.left-share').find('.lstext').outerHeight()+$('.left-share').find('.lstitle').outerHeight());
			//alert($('.left-share').find('.lstext').width()+$('.left-share').find('.lstitle').width());
		}
	}
	var windowWidth = $(window).width();

	$(window).resize(function (){
		if ($(window).width() != windowWidth)
		{
			adjustShareBanner();
		}
	});
	adjustShareBanner();

	if($('.bad-amount').length)
	{
		$('#donateModal').modal({
			show: 'true'
		});

		$('#Form_DonateForm_action_doSubmitDonateForm').on('click', function(){
			$('.bad-amount').remove();
		});
	}


// background-position:right 24px center;

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
		$('#surname-filter').val('');
		$('#surname-filter').attr('disabled','disabled');
		$('.content-wrapper .list-title span').html(Grade+'s');
		$('.container .member-list-container').html('<img src="/mysite/icons/royalloader.gif" />');
		$.ajax({
			url: "/members/People",
			data: "Grade="+Grade,
			method: "POST"
		})
		.done(function(response){
			$('.container .member-list-container').html(response);
			$('#surname-filter').removeAttr('disabled');
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

	$('#SuccessModal').modal({
        show: 'true'
    });

	


	


});
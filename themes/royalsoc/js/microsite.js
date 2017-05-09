$( document ).ready(function() {
	$('.bxslider').bxSlider({
	  nextSelector: '#slider-next',
	  prevSelector: '#slider-prev',
	  nextText: '',
	  prevText: '',
	  onSliderLoad: function(currentIndex) {
      	$(".slider-title").html($('.bxslider li').eq(1).attr("title"));
       $(".slider-text").html($('.bxslider li').eq(1).attr("alt"));
      },
	  onSlideBefore: function($slideElement, oldIndex, newIndex) {
	    $(".slider-title").html($slideElement.attr("title"));
	    $(".slider-text").html($slideElement.attr("alt"));
	  }
	});
	absoluteWidgets();

	var windowWidth = $(window).width();

	$(window).resize(function (){
		if ($(window).width() != windowWidth)
		{
			absoluteWidgets();
		}
	});


	function absoluteWidgets(){
		if ($(window).width()>=1170){
			var widgetHeights = 0;
			var containHeight = 0;
			var leftTop = 0;
			var leftLeft = 0;
			var rightTop = 0;
			var RightLeft = 0;
			var highestGadgetColumn = 0;
			var relatedHeight = 0;
			$('.widget-container').each(function(){
				if($(this).hasClass('first-widget')){
					$(this).css('top','0px');
					$(this).css('left',leftLeft-15+'px');
					$(this).css('position','absolute');
					$(this).css('padding-left','15px');

					RightLeft = $(this).width();
					leftTop = $(this).outerHeight();
					//$(this).css('padding-left','15px');

					
				}
				else if(RightLeft > 1){
					$(this).css('top',rightTop+'px');
					$(this).css('left',RightLeft+30+'px');
					$(this).css('position','absolute');
					$(this).css('padding-right','15px');

					rightTop = rightTop+$(this).outerHeight();
					RightLeft = 0;
					
					//$(this).css('padding-right','15px');
				}
				else{
					$(this).css('top',leftTop+'px');
					$(this).css('left',leftLeft-15+'px');
					$(this).css('position','absolute');
					$(this).css('padding-left','15px');


					RightLeft = $(this).width();
					leftTop = leftTop+$(this).outerHeight();
					//$(this).css('padding-left','15px');
				}
				widgetHeights = widgetHeights + $(this).outerHeight();

				//console.log($(this).prev().outerHeight());


			});
			containHeight = widgetHeights + $('.activity-blocks').outerHeight() + $('.footer').outerHeight();
			//alert('Widgets:  ' + containHeight + '   Widgets: ' +widgetHeights+ '  Blocks: ' + $('.activity-blocks').outerHeight()+ '  Foot: '+ $('.footer').outerHeight());

			if(leftTop > rightTop){
				highestGadgetColumn = leftTop;
			}
			else{
				highestGadgetColumn = rightTop;
			}

			$('.activity-blocks').css('top',highestGadgetColumn+'px');
			$('.activity-blocks').css('position','absolute');
			$('.activity-blocks').css('width',$('.container').width());
			if($('.activity-blocks').length){
				relatedHeight = $('.activity-blocks').outerHeight();
			}
			$('.footer').css('top',highestGadgetColumn+relatedHeight+'px');
			$('.footer').css('position','absolute');
			//$('.footer').css('width',$('.container').width());


			$('.container').height(leftTop+$('.activity-blocks').outerHeight()+$('.footer').outerHeight()+'px');
		}
		else{
			$('.widget-container').each(function(){
				$(this).css('position','static');
				$('.activity-blocks').css('position','static');
				$('.activity-blocks').css('width',$('.container').width());
				$('.footer').css('position','static');
				$(this).css('padding-left','0px');
				$(this).css('padding-right','0px');

			});
		}

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
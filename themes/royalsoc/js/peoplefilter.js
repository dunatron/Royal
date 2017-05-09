$(function(){

	$("#surname-filter").on('keyup',function(){
		var search = $(this).val().toLowerCase();
		if(search == '')
		{
			$(".member-container").each(function(){

					$(this).show();

			});
		}
		else
		{
			$(".member-container").each(function(){
				var surname = $(this).attr('data-surname').toLowerCase();
				if(surname.startsWith(search))
				{
					$(this).show();
				}
				else
				{
					$(this).hide();
				}
			});
		}
	});

});
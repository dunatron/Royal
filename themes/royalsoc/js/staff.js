	function staffModal(){
		$('.staff-click').click(function(){
			var staffID = $(this).attr('id');

			$.ajax({
				url: "/staffpage/Person",
				data: "ID="+staffID,
				method: "POST",
				async: false
			})
			.done(function(response){
				$('#staffModal .modal-body').html(response);
			});
			$('staffModal').modal('show');
		});
	}
	staffModal();
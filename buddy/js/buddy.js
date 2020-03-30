$(
	$('#sendB').click(function(evt) {
		let mymsg = $('#composeTextArea').val();
		$.post('newmessage.php', 
			{ message: mymsg,
				asemail: $('#mailCheck').prop('checked')
			  // sender: $('#mynetid')
		  }).done(function(rslt) {
			  console.log(rslt);
	  		$('#message_div').prepend('<p><b>'+$('#me').text() 
				+':</b>&nbsp'+mymsg+'</p>');
			$('#composeTextArea').val('');
		}).fail(function (a,b,c) {
			$('#composeTextArea').val('');
		});
		
	})
);

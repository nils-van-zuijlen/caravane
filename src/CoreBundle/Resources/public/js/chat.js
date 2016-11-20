$(function() {
	var loading = false, intervalID/*, volume = 0*/;
	afficheConversation();

	$('#btn-send').on('click', function(e) {
		e.preventDefault();
		var message = $('#message').val();
		if (message.length < 1) {
			$('.panel-footer form').addClass('has-warning');
			$('#msg-error')
				.html('Message trop court')
				.show('fast')
				.delay(3000)
				.hide('fast');
			return;
		}
		$.post('send', { 'message': message }, afficheConversation);
		$('#message').val('');
		$('.panel-footer form').removeClass('has-warning has-error has-success');
		$('#message').focus();
	});

	function afficheConversation() {
		if (loading)
			$('#loading-icon')
				.animate({right: '-=200'}, 2500, 'linear')
				.animate({right: '+=200'}, 2500, 'linear');

		$('#message-list').load('get');
	}

	$('#btn-loading').on('click', function(e) {
		if (loading) {
			loading = false;
			clearInterval(intervalID);
			$('#loading-icon')
				.removeClass('glyphicon-refresh')
				.stop(true,false)
				.attr('style', '')
				.addClass('glyphicon-ban-circle');
		} else {
			loading = true;
			intervalID = setInterval(afficheConversation, 5000);
			$('#loading-icon')
				.removeClass('glyphicon-ban-circle')
				.stop(true,false)
				.attr('style', '')
				.addClass('glyphicon-refresh');
			afficheConversation();
		}
	});

	/*
		$('#chat-notification').get().volume = volume = 0;

		$('#btn-sound').on('click', function(e) {
			if (volume == 0) {
				$('#chat-notification').get().volume = volume = 0.5;
				$('#sound-icon')
					.removeClass('glyphicon-volume-off glyphicon-volume-up')
					.addClass('glyphicon-volume-down');
			} else if (volume == 0.5) {
				$('#chat-notification').get().volume = volume = 1;
				$('#sound-icon')
					.removeClass('glyphicon-volume-off glyphicon-volume-down')
					.addClass('glyphicon-volume-up');
			} else {
				$('#chat-notification').get().volume = volume = 0;
				$('#sound-icon')
					.removeClass('glyphicon-volume-up glyphicon-volume-down')
					.addClass('glyphicon-volume-off');
			}
		})
	*/

	loading = true;
	intervalID = setInterval(afficheConversation, 5000);
});

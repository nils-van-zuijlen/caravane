window.chat.loading = false;
window.chat.intervalID = null;
//window.chat.volume = 0;

window.chat.afficheConversation = function() {
	if (window.chat.loading !== false) {
		window.chat.loading += 45;
		$('#chat-loading-icon')
			.animate({transform: 'rotate('+window.chat.loading+'deg)'}, 'slow', 'linear');
	}

	$('#chat-message-list').load(window.chat.getUrl);
}

$(function() {
	$('#chat-btn-send').on('click', function(e) {
		e.preventDefault();
		var message = $('#chat-message').val();
		if (message.length < 1) {
			$('#chat-form').addClass('has-warning');
			$('#chat-msg-error')
				.html(window.chat.errMsg)
				.show('fast')
				.delay(3000)
				.hide('fast');
			return;
		}
		$.post(window.chat.sendUrl, { 'message': message }, window.chat.afficheConversation);
		$('#chat-message').val('');
		$('#chat-form').removeClass('has-warning has-error has-success');
		$('#chat-message').focus();
	});

	$('#chat-btn-loading').on('click', function(e) {
		if (window.chat.loading) {
			window.chat.loading = false;
			clearInterval(window.chat.intervalID);
			$('#chat-loading-icon')
				.removeClass('glyphicon-refresh')
				.stop(true,false)
				.attr('style', '')
				.addClass('glyphicon-ban-circle');
		} else {
			window.chat.loading = 0;
			window.chat.intervalID = setInterval(window.chat.afficheConversation, 5000);
			$('#chat-loading-icon')
				.removeClass('glyphicon-ban-circle')
				.stop(true,false)
				.attr('style', '')
				.addClass('glyphicon-refresh');
			window.chat.afficheConversation();
		}
	});

	/*
		$('#chat-notification').get().volume = volume = 0;

		$('#chat-btn-sound').on('click', function(e) {
			if (window.chat.volume == 0) {
				$('#chat-notification').get().volume = window.chat.volume = 0.5;
				$('#chat-sound-icon')
					.removeClass('glyphicon-volume-off glyphicon-volume-up')
					.addClass('glyphicon-volume-down');
			} else if (volume == 0.5) {
				$('#chat-notification').get().volume = window.chat.volume = 1;
				$('#chat-sound-icon')
					.removeClass('glyphicon-volume-off glyphicon-volume-down')
					.addClass('glyphicon-volume-up');
			} else {
				$('#chat-notification').get().volume = window.chat.volume = 0;
				$('#chat-sound-icon')
					.removeClass('glyphicon-volume-up glyphicon-volume-down')
					.addClass('glyphicon-volume-off');
			}
		})
	*/

	window.chat.loading = 0;
	window.chat.intervalID = setInterval(window.chat.afficheConversation, 5000);
});

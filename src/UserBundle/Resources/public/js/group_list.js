$(function() {
	$('#group_list>a').on('click', function(e) {
		e.preventDefault();
		$('#group_show_zone').load($(this).attr('href'));
		$('#group_list>a.active').removeClass('active');
		$(this).addClass('active');
	});
});
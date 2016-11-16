jQuery(document).ready(function( $ ) {
	// Newsletter signup form interaction
	$('.newsletter-signup .email').focus(function() {
		$(this).siblings('.hidden-start').show();
	});

	$(document).mouseup(function(e) {
		var container = $(".newsletter-signup");
		if (!container.is(e.target) && container.has(e.target).length === 0)
			container.find('.hidden-start').hide();
	});
});

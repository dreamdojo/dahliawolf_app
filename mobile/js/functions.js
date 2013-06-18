$(document).ready(function() {
	$('body').addClass('mobile');
	mobile_events();
});

/*(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);*/

function mobile_events() {
	// Session type append
	var session_type = $.QueryString['session_type'];
	// Append to a hrefs and form actions
	if (session_type) {
		$('a[href], form[action]').each(function() {
			var attr = this.action ? 'action' : 'href';
			var attr_value = this.action ? this.action : this.href;
			
			// If doesn't already have the query param
			if (attr_value.indexOf('session_type=') < 0) {
				// Check for hash
				var hash_index = attr_value.indexOf('#');
				var hash = '';
				if (hash_index > -1) {
					hash = '#' + attr_value.split('#')[1];
					attr_value = attr_value.split('#')[0];
				}
				
				// Set value
				$(this).attr(attr, attr_value + (attr_value.indexOf('?') > -1 ? '&' : '?') + 'session_type=' + session_type + hash);
			}
		});
	}
	
	// Hover -> touch
	$('.cart-summary, .heading-categories').on('click', function(event) {
		$(this).toggleClass('hover');
	});
}
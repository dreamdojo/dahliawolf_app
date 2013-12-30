/* lazyload.js (c) Lorenzo Giuliani
 * MIT License (http://www.opensource.org/licenses/mit-license.html)
 *
 * jQuery version by Gavin Grubb
 * (includes a fix for splice(), as the first image in array (index 0) was never getting removed)
 * (ALSO I would suggest using a loading animation gif image (ALA www.ajaxload.info) in place of blank.gif)
 *
 * expects a list of:
 * `<img src="blank.gif" data-src="my_image.png" width="600" height="400" class="lazy">`
 */

!function(window){
	
	function loadImage($el, $fn) {
		jQuery($el).hide().attr('src', jQuery($el).attr('data-src')).addClass('loaded').fadeIn(400);
		$fn ? $fn() : null;
	}
	
	function elementInViewport($el) {
		var $rect = $el.getBoundingClientRect();
		return (
			($rect.top >= 0 || ($rect.bottom >= 0 && $rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)))
			&& $rect.left >= 0
			&& $rect.top <= (window.innerHeight || document.documentElement.clientHeight)
		);
	}
	
	jQuery(document).ready(function() {
		var throttled = _.throttle(processScroll, 100);
		
		throttled();
		$(window).scroll(throttled);
	});
	
	function processScroll() {
		$images = $('img.lazy:not(.loaded)');
		
		$images.each(function(i) {
			if (elementInViewport(this)) {
				loadImage(this, function () {
					//$images.splice(i, 1);
					//$(this).addClass('loaded');
				});
			}
		});
	}
	
}(this);

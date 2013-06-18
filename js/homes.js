// JavaScript Document

var homeWrecker = new Object();
homeWrecker.index = 0;
homeWrecker.numberOfSlides = 0;
homeWrecker.fadeSpeed = 400;
homeWrecker.changeSpeed = 3000;
homeWrecker.howtoScrollSpeed = 400;

homeWrecker.showBox = function(box){
	$('.box-section').fadeOut(100); 
	$('#'+box).fadeIn(100);
}

homeWrecker.showHowTo = function(){
	$('body', 'html', window).animate({scrollTop : $('#how-it-works-section').offset().top}, homeWrecker.howtoScrollSpeed, function(){
		if($('body', 'html', window).scrollTop() < ($('#how-it-works-section').offset().top-100) ){
			document.location = '#how-it-works-section';
		}
	});
}

homeWrecker.startSlideShow = function(){
	$(homeWrecker.slides[homeWrecker.index]).fadeOut(homeWrecker.fadeSpeed);
	homeWrecker.index++;
	if(homeWrecker.index >= homeWrecker.numberOfSlides){
		homeWrecker.index = 0;
	}
	$(homeWrecker.slides[homeWrecker.index]).fadeIn(homeWrecker.fadeSpeed);
	setTimeout(homeWrecker.startSlideShow, homeWrecker.changeSpeed);
}

homeWrecker.initSlideShow = function(fade, change){
	homeWrecker.fadeSpeed = fade;
	homeWrecker.changeSpeed = change;
	homeWrecker.slides = $('.slide');
	homeWrecker.numberOfSlides = homeWrecker.slides.length;
	homeWrecker.startSlideShow();
}

homeWrecker.init = function(fade, change){
	homeWrecker.initSlideShow(fade, change);
}

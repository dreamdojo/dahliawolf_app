
scroller = new Object();
scroller.trigger = 20;// what percent you have to scroll down before it loads more images
scroller.increment = 5;
scroller.offset = 500;
scroller.maximum = 80;

//methods
scroller.bind = bind;
scroller.Init = scrollInit;
scroller.setHeight = setHeight;
scroller.checkBottom = scrollBottom;
	
function bind(){
	$(window).scroll(function(){
		percent = ($(window).scrollTop()/(scroller.height+scroller.offset))*100;
		if(scrollBottom($(window))){
			if(scroller.trigger <= scroller.maximum){
				scroller.trigger += scroller.increment;
			}
			theFeed.run();
			scroller.setHeight();
		}
	});
}

function scrollInit(frame, cols){
	this.fName = frame;
	this.cols = cols;
	this.height = ($('.'+this.fName).length/this.cols) * $('.'+this.fName).height();
	this.bind();
}

function setHeight(){
	this.height = ($('.'+this.fName).length/this.cols) * $('.'+this.fName).height();
}

function scrollBottom (em){ 
  return (scroller.height<(-($(document).height() - em.scrollTop() - em.height()))); 
};
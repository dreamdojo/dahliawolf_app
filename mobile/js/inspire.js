// ****************************** INSPECTAH
function inspectImage(obj) {
	this.src = obj.find('img').attr('src');
	this.id = obj.data('id');
	this.view = $('#inspectahPost');
	this.view.fadeIn(100, function(){
		inspirePage.view.addClass('hidden');
	});
	this.view.append('<img id="theInspected" src="'+this.src+'">');
	this.buttonsShowing = true;
	this.postButton = $('#postImage');
	$('#postImage').data('id', this.id);
	$('#closeInspection').on('click', $.proxy(this.closeInspector, this));
	$('#theInspected').on('click', $.proxy(this.toggleButtons, this));
}

inspectImage.prototype.toggleButtons = function() {
	if(this.buttonsShowing){
		$('.butt').addClass('hidden');
		this.buttonsShowing = false;
	}else{
		$('.butt').removeClass('hidden');
		this.buttonsShowing = true;
	}
}

inspectImage.prototype.closeInspector = function(){
	$this = this;
	inspirePage.view.removeClass('hidden');
	this.view.fadeOut(200, function(){
		$('#theInspected').remove();
		$('#theInspected').unbind('click');
	});
}


//************************************* MENU OBJECT

function inspireMenu() {
	this.isOpen = false;
	this.mainView = $('#inspireMenu');
	this.topMenu = $('#topInspireMenu');
}

inspireMenu.prototype.showMe = function(){
	this.mainView.fadeIn(200);
	this.topMenu.fadeIn(200);
}

//********************************** INSPIRATION PAGE OBJECT

function inspire() {
	this.view = $('#inspirePage');
	this.postContainer = $('#postContainer');
	this.closeButton = $('#closeInspirePage')
	this.inspireMenu = new inspireMenu();
	this.speed = 400;
	this.isOpen = false;
	this.isAvailable = true;
	this.offset = 0;
	this.gridMode = true;
	this.isPostingAvailable = true;
	$('#gridToggle').on('click',  $.proxy(this.toggleDisplayMode, this) );
	$(this.closeButton).on('click', $.proxy(this.destroy, this) );
}

inspire.prototype.toggleLoadingBar = function(){
	theBar = $('#loading-bar');
	if( !theBar.is(':visible') ){
		theBar.fadeIn(200);
	}else{
		theBar.fadeOut(200);
	}
}

inspire.prototype.launchInspector = function() {
	this.inspecter = new inspectImage( $(this) );
	$this = this.inspecter;
	this.inspecter.postButton.bind('tap', function(){
		$this.closeInspector();
		inspirePage.postImage( parseInt( $(this).data('id') ) );
	});
}

inspire.prototype.toggleDisplayMode = function(){
	if(this.gridMode){
		$.each($('.gridzy'), function(index, post){
			$(post).removeClass('gridzy').addClass('artzy');
		});
		this.gridMode = false
	}else{
		$.each($('.artzy'), function(index, post){
			$(post).removeClass('artzy').addClass('gridzy');
		});
		this.gridMode = true;
	}
}

inspire.prototype.showMe = function() {//Load page 
	if(!this.isOpen){
		$this = this;
		this.loadImages();
		this.view.show();
		$(document).unbind('touchmove');
		this.view.animate({top:0+'%'}, this.speed, function(){
			$('#view-port').hide();
			$this.inspireMenu.showMe();
			$this.startScrollControl();
			$this.isOpen = true;
		});
	}
}

inspire.prototype.destroy = function() {//Close page
	$this = this;
	$(window).unbind('scroll');
	$this.view.css('height', 100+'%').css('position', 'fixed');
	$('#view-port').show();
	$(document).bind('touchmove', function(e) {// rebind anti swipe measures
		e.preventDefault();
	});
	if(!this.isAvailable && this.ajaxReq){// cancel pending ajax request for more images
		$this.toggleLoadingBar();
		this.ajaxReq.abort();
		this.isAvailable = true;
	}
	this.view.animate({top:100+'%'}, function(){
		$.each($('.posty'), function(index, post){
			$(post).remove();
		});
		$this.view.hide();
		$this.view.remove('.gridzy');
		$this.isOpen = false;
		$this = null;
	});
}

inspire.prototype.loadImages = function() {//Request Images
	if(this.isAvailable){
		$this = this;
		this.isAvailable = false;
		this.toggleLoadingBar();
		url = "/includes/php/ajax_getFeed.php?offset="+this.offset;
		this.ajaxReq = $.ajax({url:url, context: document.body}).done(function(data){
			$this.view.css('height', 'auto').css('position', 'static');
			$this.displayImages(data);
			$this.toggleLoadingBar();
			$this.offset += data['data'].length;
			$this.isAvailable = true;
		}).fail(function(data){
			$this.isAvailable = true;
			$this.toggleLoadingBar();
		});
	}
}
//onClick="inspirePage.launchInspector(this.src);"
inspire.prototype.displayImages = function(data) {
	$this = this;
	$.each(data['data'], function(index, post) {
		str = '<div id="post-'+post.id+'" data-id="'+post.id+'" class="'+($this.gridMode ? 'gridzy' : 'artzy')+' posty"><img src="'+post.source+post.imageURL+'" ></div>';
		$this.view.append(str);
		$('#post-'+post.id).bind('singletap', $this.launchInspector );
		$('#post-'+post.id).bind('doubletap', function(){
			inspirePage.postImage( post.id );
		});
	});
	inspirePage.view.append('<div class="clear"></div>');
}

inspire.prototype.postImage = function(id) {//Post Image
	$this = this;
	if(User.id) {
		if(id && id > 0 && this.isPostingAvailable && User.id){
			this.isPostingAvailable = false;
			$('#post-'+id).unbind('doubletap');
			$('#post-'+id).append('<div class="postedOverlay"></div>');
			$.post('/action/post_feed_image.php', { id: id, description: 'Posted from Dahliawolf mobile' } ).done(function(data){
				$('#post-'+id).find('.postedOverlay').bind('tap', function(){
					goHere('postdetails.php?posting_id='+data.posting_id, false);
				});
				$('#post-'+id).append('<div onClick="goHere(\'postdetails.php?posting_id='+data.posting_id+'\', false);" class="post-post">POSTED<br><span>View Post</span></div>');
				$this.isPostingAvailable = true;
			});
		}
	} else {
		_userLogin.toggleWindow();
	}
}

inspire.prototype.startScrollControl = function() {//bind the scroller
	$(window).scroll(function(){
		if( ( inspirePage.view.height() - $(window).scrollTop() ) < ( $(document).height() + 200 ) ) {
		  inspirePage.loadImages();
	   }
	});
}

inspire.takePicture = function() {

}

$(function(){inspirePage = new inspire();});
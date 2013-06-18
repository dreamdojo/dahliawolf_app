twerkin = new Object();
twerkin.triggerPercent = 20;
twerkin.defaultSpeed = 100;
twerkin.speed = 100;
twerkin.show = 0;
twerkin.available = true;
twerkin.grabbed = false;

twerkin.count = 1;
twerkin.blackedOut = false;
twerkin.glorifyfadeSpeed = 200;
twerkin.description = "";

//METHODS
twerkin.init = t_init;
twerkin.getPercentMoved = getPercentMoved;
twerkin.animateMainImage = animateMainImage;
twerkin.bind = bind;
twerkin.loadNew = loadNew;
twerkin.getNewImage = getNewImage;
twerkin.finishMove = finishMove;
twerkin.resetImagePositions = resetImagePositions;
twerkin.clearLights = clearLights;
twerkin.addFrame = appendFrame;
twerkin.lightUp = turnonLight;
twerkin.resetSpeed = resetSpeed;
twerkin.checkforWhammy = checkforWhammy;
twerkin.doVotePop = doVotePop;
twerkin.voteForImage = voteForImage;
twerkin.glorify = glorify;//shows image fullscreen
twerkin.glorifyClose = gcloseMe;
twerkin.glorifyCloseWithVote = glorifyCloseWithVote;
twerkin.bindGlorify = bindGlorify;
twerkin.getCurrentImage = getCurrentImage;

//********** MethodS *********
twerkin.toggleGlorifyFullScreen = function() {
	if( $('#voteOptions').is(':visible') ){
		$('#voteOptions').animate({top:'-'+60+'px'}, 200, function(){
			$(this).hide();
		});
		$('#popup-button-box').animate({bottom:'-'+65+'px'}, 200, function(){
			$(this).hide();
		});
	}else{
		$('#voteOptions').show().animate({top:0+'px'}, 200);
		$('#popup-button-box').show().animate({bottom:5+'px'}, 200);
	}
}

function getCurrentImage(){
	return $('#swipe-me-'+twerkin.current);
}

function bindGlorify(){
	console.log('bindid');
	$('#theGlory').bind('moveend', function(e){
		if(e.distX > 0 && e.distX > 50){
			glorifyCloseWithVote('yes');
		}else if(e.distX < 0 && e.distX < -50){
			glorifyCloseWithVote('no');
		}
	}).bind('tap', twerkin.toggleGlorifyFullScreen);
}

function glorifyCloseWithVote(vote){
	twerkin.glorifyClose();
	setTimeout(function(){
		twerkin.speed = 300;
		if(vote == 'yes'){
			twerkin.doVotePop('hot');
			twerkin.finishMove('yes');
		}else{
			twerkin.doVotePop('not');
			twerkin.finishMove('no');
		}
	},twerkin.glorifyfadeSpeed)
}

function glorify(){
	overlay = $('#blackOut');
	overlay.empty();
	if(!twerkin.blackedOut){
		str = '<img src="'+$('#image-'+twerkin.current).attr('src')+'" id="theGlory" class="theAppended">';
		str += '<div id="voteOptions"><div id="voteOptionDone"></div><div onClick=\'goHere("postdetails.php?posting_id='+twerkin.current+'")\' id="voteOptionDetail"></div></div>';
		str += '<div id="popup-button-box" class="popup-button-box"><div id="nay-butt" class="popup-button leaveit"><p>LEAVE IT</p></div><div id="yay-butt" class="popup-button loveit"><p>LOVE IT</p></div></div>';
		
		overlay.append(str);
		overlay.fadeIn(twerkin.glorifyfadeSpeed, function(){
			twerkin.blackedOut = true;
			twerkin.bindGlorify();
			$('#voteOptionDone').bind('click', twerkin.glorify);
			$('#yay-butt').bind('click', function(){
				twerkin.glorifyCloseWithVote('yes');
			});
			$('#nay-butt').bind('click', function(){
				twerkin.glorifyCloseWithVote('no');
			});
		});
	}else{
		twerkin.glorifyClose();
	}
}

function gcloseMe(){
	$('#theGlory').unbind('moveend').unbind('tap');
	overlay.fadeOut(twerkin.glorifyfadeSpeed, function(){
		overlay.empty();
		twerkin.blackedOut = false;
	});
}

function voteForImage(decision, id){
	if(User.name){
		if(decision){
			$.post('/action/like.php?posting_id='+id);
		}else{
			$.post('/action/dislike.php?posting_id='+id);
		}
	}else{
		document.location = 'login.php';
	}
}

function doVotePop(vote){
	if(vote == 'hot'){
		theBub = $('#vote-hot-' + twerkin.current);
		theUnBub = $('#vote-not-' + twerkin.current);
	}else if(vote == 'not'){
		theBub = $('#vote-not-'+twerkin.current);
		theUnBub = $('#vote-hot-' + twerkin.current);
	}
	theBub.show();
	theUnBub.hide();
}
function checkforWhammy(){
	if(this.count % 50 == 0){
		$('#wammy-box').show();
	}
}
function clearLights(){
	$('#vote-hot-' + twerkin.current).hide();
	$('#vote-not-' + twerkin.current).hide();
}
function turnonLight(ch){
	if(ch == 'yes'){
		$('#vote-sect-no').css('background-image', 'url(images/vote-light-no-off.png)');
		$('#vote-sect-yes').css('background-image', 'url(images/vote-light-yes-on.png)');
	}else if(ch == 'no'){
		$('#vote-sect-yes').css('background-image', 'url(images/vote-light-yes-off.png)');
		$('#vote-sect-no').css('background-image', 'url(images/vote-light-no-on.png)');
	}
}

function getNewImage(id){
	url = this.getMoreUrl+'?id='+id
	url += '&viewer_user_id='+User.id;
	twerkin.available = false;
	$.ajax({url: url}).done(function(data){
		$('#swipe-me-'+data.current.next_posting_id).addClass('active').removeClass('next');
		twerkin.checkforWhammy();
		twerkin.available = true;
		twerkin.addFrame(data.previous.posting_id, data.previous.image_url, data.previous.likes, data.previous.avatar, data.previous.username, data.previous.width, data.previous.height);	
		twerkin.current = id;
		twerkin.description = data.current.description;
		twerkin.prev = data.previous.posting_id;
		twerkin.bind();
		$('.stack').unbind('click');
		$('.stack').bind('click', twerkin.glorify);
		twerkin.count++;
	});
}
function appendFrame(id, src, likes, avatard, boosername, w, h){
	str = '<div class="outside-frame optimize-me next" id="swipe-me-'+id+'">';
    str += '<div id="vote-not-'+id+'" class="vote-pop vote-not"></div>';
	str += '<div id="vote-hot-'+id+'"class="vote-pop vote-hot"></div>';
	str += '<div class="inside-frame">';
	str += '<img id="image-'+id+'" class="'+( (w > h) ? 'tall' : 'wide')+' stack" src="'+src+'" />';
    str += '</div>';
    str += '<div class="post-deets">';
    str += '<div class="postUserAvatarFrame" onClick=\'goHere("profile.php?username='+boosername+'")\'>';
    str += '<img src="'+avatard+'" />';
    str += '</div>';
    str += '<div class="postUserDeets">';
    str += '<div class="postUserName" onClick=\'goHere("profile.php?username='+boosername+'")\'>'+boosername+'</div>';
    str += '</div>';
    str += '<div class="postFollowUser">FOLLOW</div>';
    str += ' </div>';
	$('#screen-frame').prepend(str);
}

function loadNew(){	
}
function resetSpeed(){
	this.speed = this.defaultSpeed;
}
function resetImagePositions(){
	$('#swipe-me-'+this.current).animate({top: 0}, this.speed);
	$('#swipe-me-'+this.current).animate({left: 0}, this.speed, function(){
		twerkin.clearLights();
	});
}

function finishMove(dir){// commpletes animation and process's vote
	theImage = twerkin.getCurrentImage();
	
	if(twerkin.available){
		theImage.removeClass('active').addClass('old');
		twerkin.available = false;
		if(dir == 'no'){
			theImage.animate({left: this.hideLeft}, this.speed, function(){
				twerkin.clearLights();
				$('.old').remove();
			});
			twerkin.voteForImage(false, twerkin.current);
			twerkin.getNewImage(twerkin.prev);
		}else{
			theImage.animate({left: this.hideRight}, this.speed, function(){
				twerkin.clearLights();
				$('.old').remove();
			});
			twerkin.voteForImage(true, twerkin.current);
			twerkin.getNewImage(twerkin.prev);
		}
		this.resetSpeed();
		$('#theGlory').unbind('moveend').unbind('tap');
	}
}


function animateMainImage(h, v){
	theImage = twerkin.getCurrentImage();

	console.log();
	hOffset = ($(window).innerWidth() * .05) + 1; //higher number makes image go right
	vOffset = (53 + parseFloat( $('#screen-frame').css('margin-top') ) );//higher number makes images go up
	//vOffset = 68;
	newHor = ((theImage.offset().left + h)-hOffset);
	newVert = ((theImage.offset().top + v)-vOffset);
	
	theImage.css({ left: newHor });
	theImage.css({ top: newVert });
}
function getPercentMoved(pos){
	return ((pos/$(window).width())*100)
}
function t_init(script, current, prev){
	this.current = current;
	this.prev = prev; //set next image
	this.getMoreUrl = script;
	this.screenSize = $(window).width();
	this.hideRight = $(window).width();
	this.hideLeft = -$(window).width();
	this.bind();
	
	//Bind front end
	$('.stack').on('click', twerkin.glorify);
}

function bind(){
	$('#swipe-me-'+twerkin.current).on('movestart', function(e) {
	  if ((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
		e.preventDefault();
	  }
	});
	
	$('#swipe-me-'+twerkin.current).bind('move', function(e) {
		
		twerkin.animateMainImage(e.deltaX, e.deltaY);
		
		if($('#swipe-me-'+twerkin.current).offset().left <= 0){
			twerkin.doVotePop('not');
		}else{
			twerkin.doVotePop('hot');
		}
	}).bind('moveend', function(e) {
		resetImg = true;
		if(twerkin.getPercentMoved($('#swipe-me-'+twerkin.current).offset().left) <= (-twerkin.triggerPercent) && twerkin.available){
				twerkin.finishMove('no');			
				resetImg = false;
		}else if(twerkin.getPercentMoved($('#swipe-me-'+twerkin.current).offset().left) >= twerkin.triggerPercent && twerkin.available){
				twerkin.finishMove('yes');
				resetImg = false;
		}else if((twerkin.getPercentMoved($('#swipe-me-'+twerkin.current).offset().left) < twerkin.triggerPercent) && (twerkin.getPercentMoved($('#swipe-me-'+twerkin.current).offset().left) > (-twerkin.triggerPercent))){
			twerkin.resetImagePositions();
		}
	});
}
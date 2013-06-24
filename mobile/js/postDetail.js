/*
 dongalized by:
 _______  _______  _______  _______  _______  _______  _______          
(  ____ \(  ____ \(  ___  )(  ____ \(  ____ \(  ____ )(  ____ \|\     /|
| (    \/| (    \/| (   ) || (    \/| (    \/| (    )|| (    \/( \   / )
| |      | (__    | |   | || (__    | (__    | (____)|| (__     \ (_) / 
| | ____ |  __)   | |   | ||  __)   |  __)   |     __)|  __)     \   /  
| | \_  )| (      | |   | || (      | (      | (\ (   | (         ) (   
| (___) || (____/\| (___) || )      | )      | ) \ \__| (____/\   | |   
(_______)(_______/(_______)|/       |/       |/   \__/(_______/   \_/   
                                                                        
																		*/


function postDetail(post){
	this.data = post;
	this.data.total_likes = parseInt(this.data.total_likes);
	this.totalComments = this.data.comments.length;
	this.titleView = new Array();
	this.View = new Array();
	this.isSectionOpen = false;
	this.currentSection = null;
	this.menuHeight = 40;
	this.bindFrontEnd();
	//this.adjustFrameSize();
}

postDetail.prototype.bindFrontEnd = function() {
	this.View['comment'] = $('#postComments');
	this.titleView['comment'] = $('#title-COMMENT');
	this.View['share'] = $('#postShare');
	this.titleView['share'] = $('#title-SHARE');
	this.viewPort = $('#view-port');
	this.homePage = $('#postHomePage');
	this.fullDetailView = $('#fullDetails');
	this.fullDetailViewMenu = $('#doneAndLove');
	this.postFrame = $('#postFrame');
	this.postImage = $('#thePostImage');
	this.addCommentBar = $('#addCommentBox');
	this.postHeightFrame = $('#postDetails');
	this.toggleLoveButton = $('#toggleLove');
	this.loveCount = $('#totalLikes');
	this.commentCount = $('#totalComment');
	this.deetLoveButton = $('#deetLove');
	this.commentBox = $('#postComment');
	this.commentForm = $('#commentForm');
	
	$('#commentForm').submit( function(){
		$('#sendCommentButton').click();
		return false;
	});
	$('#sendCommentButton').bind('click', $.proxy(this.postComment, this));
	$('#deetLove').bind('tap', $.proxy(this.togglePostLove, this));
	$('#toggleLove').bind('tap', $.proxy(this.togglePostLove, this));
	$('#doComments').bind('tap',{section : 'comment'} , $.proxy(this.launchSection, this));
	$('#doShare').on('tap',{section : 'share'} , $.proxy(this.launchSection, this));
	$('.popTitleClose').on('tap',  $.proxy(this.closeSection, this) );
	$('#thePostImage').on('tap', $.proxy(this.launchFullScreen, this) );
	$('#deetDone').on('click', $.proxy(this.exitFullScreen, this) );
	$('#postDetails').on('tap', $.proxy(this.adjustFrameSize, this) );
	$('#postComment').on('focus', this.onInputFocus);
}

postDetail.prototype.onInputFocus = function(e) {
	if(!User.id){
		e.preventDefault();
		_userLogin.toggleWindow();
	}
}

postDetail.prototype.adjustFrameSize = function() {
	newHt = $(window).innerHeight() - 155;
	this.postHeightFrame.height(newHt);
}

postDetail.prototype.launchFullScreen = function() {
	$this = this;
	img = $('#thePostImage');
	this.ogOffset = img.offset();
	this.ogWidth = img.width();
	offset = img.offset();
	
	img.css({'position' : 'fixed', 'top' : offset.top, 'left':offset.left, 'width': 94+'%'});
	img.animate({width:100+'%', top:0, left:0}, 400, function(){
		$('.header').addClass('hidden');
		$this.fullDetailViewMenu.show().animate({'top':0},200, 'swing');
		$this.postImage.unbind('tap').bind('tap', $.proxy($this.toggleFullScreenMenu, $this) );
	}); 
}

postDetail.prototype.toggleFullScreenMenu = function() {
	$this = this;
	if( this.fullDetailViewMenu.is(':visible') ){
		this.fullDetailViewMenu.animate({'top':'-'+this.menuHeight}, 200, function(){
			$this.fullDetailViewMenu.hide();
		});
	} else {
		this.fullDetailViewMenu.show().animate({'top':0}, 200)
	}
}

postDetail.prototype.exitFullScreen = function() {
	$this = this;
	
	this.postImage.unbind('tap').on('tap', $.proxy(this.launchFullScreen, this) );
	$('.header').removeClass('hidden');
	this.fullDetailViewMenu.animate({top:'-'+this.menuHeight}, 200, function(){
		$this.fullDetailViewMenu.hide();
	});
	this.postImage.animate({width:this.ogWidth+'px', 'top':this.ogOffset.top, 'left':this.ogOffset.left}, 400, 'linear',function(){
		$this.postImage.css('position', 'static').on('tap', $.proxy($this.launchFullScreen, $this) );
	});
}

postDetail.prototype.launchSection = function(e){
	$this = this;
	section = e.data.section;
	mainView = $this.View[section];
	titleView = $this.titleView[section];
	mainView.show().animate({top:(40/$(window).innerHeight()*100)+'%'}, 600, function(){
		$this.homePage.addClass('hidden');
		$this.glorifyImage();
		setTimeout(function(){
			mainView.animate({top:40+'%'}, 300, function(){
				if(section == 'comment'){
					mainView.css('height', 60+'%');
					$this.addCommentBar.show().animate({'left':0+'%'}, 300);
				}
				$this.isSectionOpen = true;
				$this.currentSection = section;
			});
		}, 100);
	});
	titleView.show().animate({top: 0}, 600);
}

postDetail.prototype.closeSection = function() {
	$this = this;
	if(this.isSectionOpen) {
		mainView = $this.View[this.currentSection];
		titleView = $this.titleView[this.currentSection];
		
		if(this.currentSection == 'comment'){
			mainView.css('height', 100+'%');
			$this.addCommentBar.css('left', '-'+100+'%').hide();
		}
		
		mainView.animate({top: 0+'%'}, 200, function(){
			$this.unglorifyImage();
			$this.homePage.removeClass('hidden');
			setTimeout(function(){
				titleView.animate({top: '-'+40+'px'}, 400, function(){
					titleView.hide();
				});
				mainView.animate({top: 100+'%'}, 400, function(){
					mainView.hide();
				});
				$this.isSectionOpen = false;
				$this.currentSection = null;
			},150);
		});
	}
}

postDetail.prototype.togglePostLove = function() {
	if(User.id){
		$this = this;
		if( this.toggleLoveButton.data('liked') ){ //unlike process
			$.post('/action/unlike?posting_id='+this.data.posting_id).done(function(){
				$this.toggleLoveButton.find('#likeTitle').removeClass('loved').addClass('unloved');
				$this.deetLoveButton.removeClass('deetLoved').addClass('deetUnLoved');
				$this.toggleLoveButton.data('liked', false);
				$this.data.total_likes--;
				$this.loveCount.empty().html($this.data.total_likes);
			});
		}else{// like process
			$.post('/action/like?posting_id='+this.data.posting_id).done(function(){
				$this.toggleLoveButton.find('#likeTitle').addClass('loved').removeClass('unloved');
				$this.deetLoveButton.removeClass('deetUnLoved').addClass('deetLoved');
				$this.toggleLoveButton.data('liked', true);
				$this.data.total_likes++;
				$this.loveCount.empty().html($this.data.total_likes);
			});
		}
	}else{
		this.exitFullScreen();
		_userLogin.toggleWindow();
	}
}

postDetail.prototype.postComment = function(){
	$this = this;
	comment = this.commentBox.val();
	if(comment && comment != '' && User.id){
		$.post('/action/comment.php', {posting_id: this.data.posting_id, comment: comment, ajax : true}, function(data){
			data = $.parseJSON(data);
			str = '<div id="comment-'+data.data.comment_id+'" class="postComment" style=" display:none;"><div class="commentAvatarFrame">';
      		str += '<img src="http://www.dahliawolf.com/avatar.php?user_id='+User.id+'"></div>';
            str += '<div class="commentData"><span>'+User.name+': </span>'+comment+'</div></div>';
			$this.View['comment'].prepend(str);
			$this.commentBox.val('');
			$('#comment-'+data.data.comment_id).slideDown(300);
			$this.totalComments++;
			$this.commentCount.html($this.totalComments);
			return false;
		});
	}else{
		console.log('fail');
		return false;
	}
}

postDetail.prototype.glorifyImage = function() {
	this.fullDetailView.show();
}
postDetail.prototype.unglorifyImage = function() {
	this.fullDetailView.hide();
}

postDetail.prototype.toggleFriend = function(){
	
}
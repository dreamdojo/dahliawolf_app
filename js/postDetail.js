/*
 rousted by:
 _______  _______  _______  _______  _______  _______  _______          
(  ____ \(  ____ \(  ___  )(  ____ \(  ____ \(  ____ )(  ____ \|\     /|
| (    \/| (    \/| (   ) || (    \/| (    \/| (    )|| (    \/( \   / )
| |      | (__    | |   | || (__    | (__    | (____)|| (__     \ (_) / 
| | ____ |  __)   | |   | ||  __)   |  __)   |     __)|  __)     \   /  
| | \_  )| (      | |   | || (      | (      | (\ (   | (         ) (   
| (___) || (____/\| (___) || )      | )      | ) \ \__| (____/\   | |   
(_______)(_______/(_______)|/       |/       |/   \__/(_______/   \_/   
                                                                        
																		*/
                                                                        
function postDetail(data){
	this.data = data;
	//console.log(this.data);
	this.data.total_likes = parseInt(this.data.total_likes);
	this.bindFrontend();
	window.history.replaceState( {} , 'Post Detail', '/post/'+data.posting_id );
}

postDetail.prototype.bindFrontend = function() {
	this.loveCount = $('#loveCount');
	this.followStatus = $('#followStatus');
	this.followButton = $('#postDetailFollowButton');
	this.smallFollowCount = $('#detailFollowingCount');
	this.loveButton = $('#postDetailLoveButton');
	this.commentData = $('#postUserCommentBox');
	this.commentContainer = $('#commentContainer');
	
	this.followerCount = parseInt( this.smallFollowCount.html() );
	
	$('#postDetailFollowButton').on('click', $.proxy(this.toggleFollow, this));
	$('#postDetailLoveButton').on('click', $.proxy(this.toggleLove, this));
	$('#shareFacebook').on('click', $.proxy(this.sendFacebook, this));
	$('#postCommentButton').on('click', $.proxy(this.publishComment, this));
    $('.shareButton').on('click', this.recordShare);
}

postDetail.prototype.publishComment = function() {
	comment = this.commentData.val().trim();
	$this = this;
	if(comment && comment != '' && comment != ' ') {
		if(theUser.id){
			this.commentData.val('');
			$.post('/action/comment.php', {ajax : true, comment : comment, posting_id : this.data.posting_id}).done(function(data){
				data = $.parseJSON(data);
				data = data.data;
				str = '<div id="newComment-'+data.comment_id+'" class="postDetailCommentBox hidden"><div class="postCommentAvatarFrame"><img src="'+userConfig.avatar+'"></div>';
                str += '<div class="postCommentComment"><p class="name">'+theUser.username+'</p><p>'+comment+'</p></div></div>';
				$this.commentContainer.prepend(str);
				$('#newComment-'+data.comment_id).slideDown(400);
			});
		} else {
			new_loginscreen();
		}
	}
}

postDetail.prototype.recordShare = function() {
    var platform = $(this).data('platform');
    var str = '/api/1-0/sharing.json?function=add_share&posting_id='+thePostDetail.data.posting_id+'&type=posting&network='+platform+'&posting_owner_user_id='+thePostDetail.data.user_id+'&sharing_user_id='+dahliawolf.userId+'&use_hmac_check=0';

    sendToAnal({name:'Shared Post on '+platform, id : thePostDetail.data.posting_id});
    $.getJSON(str, function(data) {
       //holla.log(data);
    });
}

postDetail.prototype.sendFacebook = function() {
	facebookFeed(this.data.image_url, 'http://www.dahliawolf.com/post/'+this.data.posting_id, 'OMGeeezy this is the bombsteezy');
}

postDetail.prototype.toggleFollow = function() {
	if(theUser.id) {
		isFollowing = this.followButton.data('isfollowing');
		
		if( isFollowing ) {
			this.followerCount--;
			this.followButton.data('isfollowing', false);
			this.followButton.addClass('notFollowing').removeClass('isFollowing');
			$.post('/action/unfollow.php', {user_id : this.data.user_id});
			this.followStatus.html('FOLLOW');
		} else {
			this.followerCount++
			this.followButton.data('isfollowing', true);
			this.followButton.removeClass('notFollowing').addClass('isFollowing');
			$.post('/action/follow.php', {user_id : this.data.user_id});
			this.followStatus.html('UNFOLLOW');
		}
		this.smallFollowCount.html(this.followerCount);
	} else {
		new_loginscreen();
	}
}

postDetail.prototype.toggleLove = function() {
	if(theUser.id){
		if( parseInt(this.data.is_liked) ) {
			this.loveButton.addClass('pd-unLoved').removeClass('pd-Loved');
			this.data.is_liked = 0;
			this.data.total_likes--;
            $('#totalVotesNeed').html( Number( $('#totalVotesNeed').html() ) + 1 );
			$.post('/action/unlike?posting_id='+this.data.posting_id).done(function(){
				
			});
		} else {
			this.loveButton.removeClass('pd-unLoved').addClass('pd-Loved');
			this.data.is_liked = 1;
			this.data.total_likes++;
            $('#totalVotesNeed').html( Number( $('#totalVotesNeed').html() ) - 1 );
			$.post('/action/like?posting_id='+this.data.posting_id).done(function(){
			
			});
		}
		this.loveCount.html(this.data.total_likes);
	} else {
		new_loginscreen();
	}
}
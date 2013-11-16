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
	this.data.total_likes = parseInt(this.data.total_likes);
	this.bindFrontend();
	window.history.replaceState( {} , 'Post Detail', '/post/'+data.posting_id );
    this.tagMode = false;

    this.getTags();
}

postDetail.prototype = {
    get isSelfPost() {return (dahliawolf.userId == this.data.user_id)}
}

postDetail.prototype.bindFrontend = function() {
	this.loveCount = $('#loveCount');
	this.followStatus = $('#followStatus');
	this.followButton = $('#postDetailFollowButton');
	this.smallFollowCount = $('#detailFollowingCount');
	this.loveButton = $('#postDetailLoveButton');
	this.commentData = $('#postUserCommentBox');
	this.commentContainer = $('#commentContainer');
    this.$image = $('#postDetailImage');
    this.$tag = $('<div class="postTag"></div>')
	
	this.followerCount = parseInt( this.smallFollowCount.html() );
	
	$('#postDetailFollowButton').on('click', $.proxy(this.toggleFollow, this));
	$('#postDetailLoveButton').on('click', $.proxy(this.toggleLove, this));
	$('#postCommentButton').on('click', $.proxy(this.publishComment, this));
    $('.shareButton').on('click', this.recordShare);

    if(this.isSelfPost) {
        $('<div id="activateToggle">NOTE</div>').appendTo(this.$image).on('click', this.toggleTagMode);
    }

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
                str += '<div class="postCommentComment"><p class="name"><a href="/'+theUser.id+'">'+theUser.username+'</a></p><p>'+comment+'</p></div></div>';
				$this.commentContainer.prepend(str);
				$('#newComment-'+data.comment_id).slideDown(400);
			});
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

postDetail.prototype.toggleTagMode = function(e) {
    e.preventDefault();
    e.stopPropagation();
    if(!thePostDetail.tagMode) {
        thePostDetail.tagMode = true;
        thePostDetail.$image.addClass('activated').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var offset_t = $(this).offset().top - $(window).scrollTop();
            var offset_l = $(this).offset().left - $(window).scrollLeft();

            var left = Math.round( (e.clientX - offset_l) );
            var top = Math.round( (e.clientY - offset_t) );

            new thePostDetail.createNewTag(left, top );
        });
    } else {
        thePostDetail.deActivateTagMode();
    }
}

postDetail.prototype.deActivateTagMode = function() {
    thePostDetail.tagMode = false;
    thePostDetail.$image.removeClass('activated').unbind('click');
}

postDetail.prototype.getTags = function() {
    var that = this;

    dahliawolf.post.getTags(this.data.posting_id, function(data) {
        var css = '-'+55+'px';
        $.each(data.data.get_tags, function(x, tag) {
            var $tag = that.$tag.clone().css({left : Number(tag.x), top: Number(tag.y)}).appendTo(that.$image).hover(function() {//HOVER OVER TAG
                $noteImg.css('background-position', css);
                $tag.addClass('active');
            }, function() {
                $noteImg.css('background-position', 0);
                $tag.removeClass('active');
            }).on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });

            var $note = $('<ul class="note"></ul>').hover(function() {//HOVER OVER NOTE
                $noteImg.css('background-position', css);
                $tag.addClass('active');
            }, function() {
                $noteImg.css('background-position', 0);
                $tag.removeClass('active');
            });

            if(that.isSelfPost) {
                var $delTag = $('<img src="/images/deleteTag.png">').on('click', function() {
                    dahliawolf.post.delTag(tag.posting_tag_id, that.data.posting_id);
                    $tag.remove();
                    $note.slideUp(200, function() {
                       $(this).remove();
                    });
                });
                var $noteImg = $('<li class="tagImg"></li>').append($delTag).appendTo($note);
            } else {
                var $noteImg = $('<li class="tagImg"></li>').appendTo($note);
            }
            var $message = $('<li class="userTag">'+(tag.message ? tag.message : '')+'</li>').appendTo($note);
            $note.appendTo($('#tagsSection'));
        });
    })
}

postDetail.prototype.createNewTag = function(x, y) {
    var that = this;
    var css = '-'+55+'px';
    var $tag = thePostDetail.$tag.clone().addClass('active').css({left : x, top: y}).appendTo(thePostDetail.$image).on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    var $note = $('<ul class="note"></ul>').css('display', 'none');
    var $noteImg = $('<li class="tagImg"></li>').css('background-position', css).appendTo($note);
    var $input = $('<li class="inputWrap"><textarea placeholder="describe tag"></textarea></li>').appendTo($note);
    $note.prependTo($('#tagsSection')).slideDown(200).find('textarea').focus().on('keydown', function(e) {
        if(e.keyCode == 13) {
            $(this).blur();
        }
    }).on('blur', function() {
        $(this).unbind('blur, focus');
        $noteImg.css('background-position', 0);
        $note.hover(function() {
            if( !$input.is(':focus') ) {
                $tag.addClass('active');
                $noteImg.css('background-position', css);
            }
        }, function() {
            if( !$input.is(':focus') ) {
                $noteImg.css('background-position', 0);
                $tag.removeClass('active');
            }
        });
        $tag.removeClass('active').hover(function() {
            $(this).addClass('active');
            $noteImg.css('background-position', css);
        }, function() {
            $(this).removeClass('active');
            $noteImg.css('background-position', 0);
        });
        dahliawolf.post.addTag(thePostDetail.data.posting_id, x, y, $input.find('textarea').val(), function(data) {
            var $delTag = $('<img src="/images/deleteTag.png">').on('click', function() {
                dahliawolf.post.delTag(data.data.add_tag.posting_tag_id, thePostDetail.data.posting_id);
                $tag.remove();
                $note.slideUp(200, function() {
                    $(this).remove();
                });
            }).appendTo($noteImg);
        });
    });
    if(thePostDetail.tagMode == true) {
        thePostDetail.deActivateTagMode();
    }
}



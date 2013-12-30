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
function postDetailGrid(id, parentContainer, profile, feedType) {
    this.offset = 0;
	this.limit = 12;
	this.posterId = id;
	this.refillAvailable = true;
	this.htText = 'style="min-height:100%; width:auto;"';
	this.finished = false;
    this.profile = profile;
    this.feedType = feedType;
	
	this.postContainer = $('#userPostGrid');
	this.contentContainer = parentContainer;
	this.titleContainer = $('#postGridTitle');
	
	this.init();
}

postDetailGrid.prototype.setFaves = function(posts) {
    var $this = this;
    $.each(posts, function(x, post) {
        var $post = $('<div class="userGridPostFrame"></div>').hover(function() {
            $(this).find('.option').fadeIn(50);
            $(this).find('.shareBall').fadeIn(50);
        }, function() {
            $(this).find('.option').fadeOut(50);
            $(this).find('.shareBall').fadeOut(50);
        });
        var str = '';
        str += '<div class="popGridLove option '+( parseInt(post.posting_data.is_liked) ? 'popGridisLoved' : 'popGridnotLoved')+'" data-id="'+post.posting_data.posting_id+'" data-isLoved="'+parseInt(post.posting_data.is_liked)+'">'+( parseInt(post.posting_data.is_liked) ? 'LOVED' : 'LOVE')+'</div>';
        str += '<a href="/post-details?posting_id='+post.posting_data.posting_id+'" class="image color-'+x % 5+'" rel="modal">';
        str += '<img src = "'+post.posting_data.image_url+'&width=300" class="lazy zoom-in" data-src="'+post.posting_data.image_url+'&width=300" '+(parseInt(post.posting_data.width) >= parseInt(post.posting_data.height) ? $this.htText : '')+'>';
        str += '</a>';
        str += '<img class="profFeat" src="/public_html/images/featProf.png">';
        $post.append(new shareBall(post.posting_data));
        $this.postContainer.append( $post.append(str) );
    });
}

postDetailGrid.prototype.showLoader = function() {
	this.postContainer.append('<div id="theGridLoader"><img src="/public_html/images/loading-feed.gif"></div>');
}

postDetailGrid.prototype.destroyLoader = function() {
	$('#theGridLoader').remove();
}

postDetailGrid.prototype.resetGrid = function() {
    this.offset = 0;
    this.postContainer.empty();
    this.getPosts();
}


postDetailGrid.prototype.bindScroller = function() {
	var $this = this;

    if(this.profile) {
        this.contentContainer.bind('scroll', function() {
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                $this.getPosts();
            }
        });
    } else {
        this.contentContainer.bind('scroll', function() {
            var obj = document.getElementById('modal-content');

            if(obj.scrollTop >= (obj.scrollHeight - obj.offsetHeight - 200)){
                $this.getPosts();
            }
        });
    }
}

postDetailGrid.prototype.init = function() {
	this.getPosts();
	this.bindScroller();
	if(!this.profile) {
        this.setTitle();
    }
}

postDetailGrid.prototype.setTitle = function() {
	//this.titleContainer.html('More posts by <a href="/'+thePostDetail.data.username+'">'+thePostDetail.data.username+'</a>');
}

postDetailGrid.prototype.toggleLove = function(e) {
	var loved = $(this).data('isloved');
	var id = $(this).data('id');
	if(theUser.id) {	
		if(id && id > 0) {
			if(loved){
				$(this).addClass('popGridnotLoved').removeClass('popGridisLoved').html('LOVE');
				$(this).data('isloved', 0);
                dahliawolf.post.love(id);
			} else {
				$(this).removeClass('popGridnotLoved').addClass('popGridisLoved').html('LOVED');
				$(this).data('isloved', 1);
                dahliawolf.post.love(id);
			}
		}
	} else {
		new_loginscreen();
	}
}

postDetailGrid.prototype.resetBindings = function() {
	$('.popGridLove').unbind('click');
	$('.popGridLove').bind('click', this.toggleLove);
}

postDetailGrid.prototype.getPosts = function() {
    var $this = this;
	if(this.refillAvailable && !this.finished && (this.offset % this.limit) == 0){
		this.refillAvailable = false;
        dahliaLoader.show();
        if(this.feedType !== 'loves') {
            dahliawolf.post.get_by_user({user_id : this.posterId, viewer_user_id:dahliawolf.userId, filter : this.feedType, offset : this.offset, limit: this.limit}, function(data) {
                dahliaLoader.hide();
                $.each(data.data.get_by_user.posts, function(index, post){
                    var $post = $('<div class="userGridPostFrame" style="background-image: url(\''+post.image_url+'&width=300\'); background-size:'+(Number(post.height) > Number(post.width) ? '100% auto' : 'auto 100%')+';"></div>').hover(function() {
                        $(this).find('.option').fadeIn(50);
                        $(this).find('.shareBall').fadeIn(50);
                    }, function() {
                        $(this).find('.option').fadeOut(50);
                        $(this).find('.shareBall').fadeOut(50);
                    });
                    var $linkLayer = $('<a class="linkLayer" href="/post-details?posting_id='+post.posting_id+'" rel="modal"></a>').appendTo($post);
                    var str = '';
                    str += '<div class="popGridLove option '+( parseInt(post.is_liked) ? 'popGridisLoved' : 'popGridnotLoved')+'" data-id="'+post.posting_id+'" data-isLoved="'+parseInt(post.is_liked)+'">'+(parseInt(post.is_liked) ? 'LOVED' : 'LOVE')+'</div>';
                    if(post.user_id == theUser.id) {
                        $('<div data-id="'+post.posting_id+'" class="delButton option">X</div>').appendTo($post).on('click', $this.delPost);
                    }
                    $post.append(new shareBall(post));
                    $this.postContainer.append( $post.append(str));
                });
                $this.resetBindings();
                if(data.data.get_by_user.posts.length == 0){
                    $this.finished = true;
                }
                $this.offset += data.data.get_by_user.posts.length;
                $this.refillAvailable = true;
            });
        } else {
            dahliawolf.post.get({user_id : this.posterId, viewer_user_id:dahliawolf.userId, filter : this.feedType, offset : this.offset, limit: this.limit}, function(data) {

                dahliaLoader.hide();
                $.each(data.data.get_all.posts, function(index, post){
                    var $post = $('<div class="userGridPostFrame" style="background-image: url(\''+post.image_url+'&width=300\'); background-size:'+(Number(post.height) > Number(post.width) ? '100% auto' : 'auto 100%')+';"></div>').hover(function() {
                        $(this).find('.option').fadeIn(50);
                        $(this).find('.shareBall').fadeIn(50);
                    }, function() {
                        $(this).find('.option').fadeOut(50);
                        $(this).find('.shareBall').fadeOut(50);
                    });
                    var $linkLayer = $('<a class="linkLayer" href="/post-details?posting_id='+post.posting_id+'" rel="modal"></a>').appendTo($post);
                    var str = '';
                    str += '<div class="popGridLove option '+( parseInt(post.is_liked) ? 'popGridisLoved' : 'popGridnotLoved')+'" data-id="'+post.posting_id+'" data-isLoved="'+parseInt(post.is_liked)+'">'+(parseInt(post.is_liked) ? 'LOVED' : 'LOVE')+'</div>';
                    if(post.user_id == theUser.id) {
                        $('<div data-id="'+post.posting_id+'" class="delButton option">X</div>').appendTo($post).on('click', $this.delPost);
                    }
                    $post.append(new shareBall(post));
                    $this.postContainer.append( $post.append(str));
                });
                $this.resetBindings();
                if(data.data.get_all.posts.length == 0){
                    $this.finished = true;
                }
                $this.offset += data.data.get_all.posts.length;
                $this.refillAvailable = true;
            });
        }

	}
}

postDetailGrid.prototype.delPost = function() {
    var $this = $(this);
    var id = $this.data('id');
    var c = confirm('Are you sure you want to delete this post?');
    if(c) {
        $.ajax('/api/1-0/posting.json?use_hmac_check=0&function=delete_post&posting_id='+id);
        $this.parent().hide(200);
    }
}
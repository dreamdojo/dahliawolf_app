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
function postDetailGrid(id) {
	this.offset = 0;
	this.limit = 12;
	this.posterId = id;
	this.refillAvailable = true;
	this.htText = 'style="min-height:100%; max-width: 100%; width:auto;"';
	this.finished = false;
	
	this.postContainer = $('#userPostGrid');
	this.contentContainer = $('#modal-content');
	
	this.init();
}


postDetailGrid.prototype.showLoader = function() {
	this.postContainer.append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
}

postDetailGrid.prototype.destroyLoader = function() {
	$('#theGridLoader').remove();
}


postDetailGrid.prototype.bindScroller = function() {
	$this = this;
	obj = obj = document.getElementById('modal-content');
	this.contentContainer.bind('scroll', function() {
		if(obj.scrollTop >= (obj.scrollHeight - obj.offsetHeight - 300)){
			$this.getPosts();
		}
	});
}

postDetailGrid.prototype.init = function() {
	this.getPosts();
	this.bindScroller();
}

postDetailGrid.prototype.toggleLove = function() {
	loved = $(this).data('isloved');
	id = $(this).data('id');
	if(theUser.id) {	
		if(id && id > 0) {
			if(loved){
				$(this).addClass('popGridnotLoved').removeClass('popGridisLoved');
				$(this).data('isloved', 0);
				$.post('/action/unlike?posting_id='+id)
			} else {
				$(this).removeClass('popGridnotLoved').addClass('popGridisLoved');
				$(this).data('isloved', 1);
				$.post('/action/like?posting_id='+id)
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
	$this = this;
	if(this.refillAvailable && !this.finished && (this.offset % this.limit) == 0){
		this.refillAvailable = false;
		this.showLoader();
		$.post('/action/getPostsByUser', {post_user_id : thePostDetail.data.user_id, offset : this.offset, limit: this.limit}).done(function(data) {
			$this.destroyLoader();
			$.each(data.data, function(index, post){
				str = '<div class="userGridPostFrame">';
				str += '<div class="popGridLove '+( parseInt(post.is_liked) ? 'popGridisLoved' : 'popGridnotLoved')+'" data-id="'+post.posting_id+'" data-isLoved="'+parseInt(post.is_liked)+'"></div>';
				str += '<a href="/post-details?posting_id='+post.posting_id+'" class="image color-'+index % 5+'" rel="modal">';
				str += '<img src = "'+post.image_url+'" class="lazy zoom-in" data-src="'+post.image_url+'" '+(post.width >= post.height ? $this.htText : '')+'>';
				str += '</a></div>';
				
				$this.postContainer.append(str);
			});
			$this.resetBindings();
			if(data.data.length == 0){
				$this.finished = true;
			}
			$this.offset += data.data.length;
			$this.refillAvailable = true;
		});
	}
}
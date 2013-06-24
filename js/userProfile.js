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
function userProfile(posts, data) {
	this.posts = posts;
	this.data = data;
	this.data.is_followed = parseInt(this.data.is_followed);
	this.animationIndex = 7;
	this.bindFrontEnd();
	
	if(this.posts.length >= 6) {
        setTimeout($.proxy(this.doUserPostBarMagic, this), 10000);
    }

}

userProfile.prototype.doUserPostBarMagic = function() {
	if(this.animationIndex >= (this.posts.length-1)) {
		this.animationIndex = 0;
	}
	$this = this;
	this.animationIndex++;
	$.each( $('#userPostGallery img'), function(index, element){
		$(element).css('left' , $(element).position().left);
	});
	$('.titlePostImage').css('position', 'absolute');
	$.each( $('#userPostGallery img'), function(index, element){
		$(element).animate({left: ( $(element).position().left - $('.titlePostImage').eq(0).width() )}, 700, function() {
			if(index == ($('.titlePostImage').length - 1) ) {
				$('.titlePostImage').eq(0).remove();
				$('.titlePostImage').css('position', 'static');
				$('#userPostGallery img').last().fadeIn(300);
				$('#userPostGallery').append('<img class="titlePostImage" style="display:none;" src="'+$this.posts[$this.animationIndex].image_url+'">');
				setTimeout($.proxy($this.doUserPostBarMagic, $this), 10000);
			}
		});
	});
}

userProfile.prototype.bindFrontEnd = function() {
	this.followButton = $('.followersLink');
	this.followerCount = $('#followersCount');
	this.followStatus = $('#followingStatus');
	
	this.followButton.bind('click', $.proxy(this.toggleFollow, this));
}

userProfile.prototype.toggleFollow = function() {
	if(theUser.id){
		if(this.data.is_followed) {
			this.data.is_followed = false;
			this.data.followers--;
			this.followStatus.html('Follow');
			$.post('/action/unfollow.php', {user_id : this.data.user_id});
		} else {
			this.data.is_followed = true;
			this.data.followers++;
			this.followStatus.html('Unfollow');
			$.post('/action/follow.php', {user_id : this.data.user_id});
		}
		this.followerCount.html(this.data.followers);
	} else {
		new_loginscreen();
	}
}
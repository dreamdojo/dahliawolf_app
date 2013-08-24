function userList(user, action) {
    this.limit = 20;
    this.offset = 0;
    this.users = [];
    this.isReloadAvailable = true;
    this.$bucket = $('#userListCol');
    this.urls = {'/account/following.php' : 'get_top_following', '/account/followers.php' : 'get_top_followers', '/wolf-pack.php' : 'get_top_following'};
    this.action = action;

    if(user) {
        this.user = user;
    } else {
        alert('user not set');
    }

    this.bindScroll();
}

userList.prototype.bindScroll = function() {
    var _this = this;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200 && _this.isReloadAvailable ) {
            _this.isReloadAvailable = false;
            _this.getUsers();
        }
    });
}

userList.prototype.getUsers = function() {
    var _this = this;

    $.getJSON('/api/?api=user&function='+this.urls[this.action]+'&user_id='+(this.action !== '/wolf-pack.php' ? this.user.user_id : '')+'&viewer_user_id='+theUser.id+'&limit='+this.limit+'&offset='+this.offset, function(data) {
        if(data.data.length != _this.limit) {
            $(window).unbind('scroll');
        }
        _this.offset += data.data.length;
        _this.isReloadAvailable = true;
        _this.addUsersToStack(data.data);
    });
}

userList.prototype.addUsersToStack = function(array) {
    var _this = this;
    $.each(array, function(index, user) {
        _this.users.push( new userList.prototype.user(user) );
    });
}

userList.prototype.user = function(data) {
    this.data = data;

    this.addMeToBucket();
}

userList.prototype.user.prototype.addMeToBucket = function() {
    var str = '';
    $.each(this.data.posts, function(x, post) {
        str += '<li><a href="/post-details?posting_id='+post.posting_id+'" rel="modal" class="zoom-in"><img src="'+post.image_url+'&width=125"></a></li>';
    });

    this.$userFrame = $('<div class="userFrame"></div>').appendTo( dahliawolfUserList.$bucket );
    this.$userFrame.append('<div class="avatarFrame avatarShadow"><a href="/'+this.data.username+'"><img src="'+this.data.avatar+'&width=100"></a></div>');
    this.$userFrame.append('<ul class="dataList"><a href="/'+this.data.username+'"><li class="dlUsername">'+this.data.username+'</li></a></ul>');
    this.$userFrame.append('<ul class="postList">'+str+'</ul>');
    this.$followButton = $('<div class="toggleFollow '+(Number(this.data.is_followed) ? 'dahliaHeadUnFollow' : 'dahliaHeadFollow' )+'">'+ (Number(this.data.is_followed) ? 'FOLLOWING' : 'FOLLOW' )+'</div>').appendTo(this.$userFrame.find('.dataList')).on('click', $.proxy(this.toggleFollowers, this) );
}

userList.prototype.user.prototype.toggleFollowers = function() {
    if(Number(this.data.is_followed)) {
        this.$followButton.removeClass('dahliaHeadUnFollow').addClass('dahliaHeadFollow').html('FOLLOW');
        this.data.is_followed = false;
        api.unfollowUser(this.data.user_id);
    } else {
        this.$followButton.removeClass('dahliaHeadFollow').addClass('dahliaHeadUnFollow').html('FOLLOWING');
        this.data.is_followed = true;
        api.followUser(this.data.user_id);
    }
}

function userList(user, action) {
    this.limit = 6;
    this.offset = 0;
    this.index = 0;
    this.users = [];
    this.isReloadAvailable = true;
    this.$bucket = $('#userListCol');
    this.urls = {'/account/following.php' : 'get_top_following', '/account/followers.php' : 'get_top_followers', '/wolf-pack.php' : 'get_top_following'};
    this.action = action;

    if(user) {
        this.user = user;
    } else {
        //alert('user not set');
    }

    this.bindScroll();
}

userList.prototype = {
    get isWolfpack()    {return this.action === '/wolf-pack.php' }
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

    dahliaLoader.show();
    dahliawolf.member.getTopFollowing(_this.limit, _this.offset, function(data) {
        console.log(data);
        dahliaLoader.hide();
        try {
            if(!data.data.get_top_following) {
                $(window).unbind('scroll');
            }
            _this.offset += data.data.get_top_following.length;
            _this.isReloadAvailable = true;
            _this.addUsersToStack(data.data.get_top_following);
        } catch(e) {
            //no users
        }
    });
}

userList.prototype.addUsersToStack = function(array) {
    var _this = this;
    $.each(array, function(index, user) {
        _this.index++;
        _this.users.push( new userList.prototype.user(user, _this.index) );
    });
}

userList.prototype.user = function(data, rank) {
    this.data = data;
    this.rank = rank;

    this.addMeToBucket();
}

userList.prototype.user.prototype.addMeToBucket = function() {
    var str = '';
    if(this.data.posts) {
        $.each(this.data.posts, function(x, post) {
            str += '<li><a href="/post-details?posting_id='+post.posting_id+'" rel="modal" class="zoom-in"><img src="'+post.image_url+'&width=125"></a></li>';
        });
    }

    this.$userFrame = $('<div class="userFrame"></div>').appendTo( dahliawolfUserList.$bucket );
    this.$userFrame.append( new dahliawolf.$hoverAvatar(this.data) );
    this.$userFrame.append('<ul class="dataList"><li class="dlUsername"><a href="/'+this.data.username+'">'+this.data.username+'</a>'+( this.data.membership_level === 'VIP' ? '<div class="memberStats"><a href="/help/vip"><img src="/images/vip.png"></a></div>' : '')+'</li><li>'+this.data.points+' pts</li></ul>');
    this.$userFrame.append('<ul class="postList">'+str+'</ul>');
    if(dahliawolfUserList.isWolfpack) this.$userFrame.append('<div class="rankBox">'+this.rank+'</div>');
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

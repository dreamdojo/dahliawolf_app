function userList(data) {
    var that = this;
    this.limit = 6;
    this.offset = 0;
    this.index = 0;
    this.isAvailable = true;
    this.$bucket = $('#userListCol');
    this.userData = data.user ? data.user : null;
    this.api = data.api;
    this.apiCall = new Array();
    this.apiCall['get_top_users'] = function(callback){dahliawolf.member.getTopUsers((that.isUserSet ? that.userData.user_id : ''), that.limit, that.offset, callback)};
    this.apiCall['get_top_followers'] = function(callback){dahliawolf.member.getTopFollowers((that.isUserSet ? that.userData.user_id : ''), that.limit, that.offset, callback)};
    this.apiCall['get_top_following'] = function(callback){dahliawolf.member.getTopFollowing((that.isUserSet ? that.userData.user_id : ''), that.limit, that.offset, callback)};

    this.bindScroll();
    this.getUsers();
}

userList.prototype = {
    get isUserSet() {return (this.userData ? true : false);}
}

userList.prototype.bindScroll = function() {
    var that = this;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
            that.getUsers();
        }
    });
}

userList.prototype.getUsers = function() {
    var that = this;

    if(this.isAvailable) {
        dahliawolf.loader.show();
        this.isAvailable = false;
        this.apiCall[this.api](function(data) {
            console.log(data);
            that.isAvailable = true;
            dahliawolf.loader.hide();
            if(data.data[that.api].users && data.data[that.api].users.length) {
                $.each(data.data[that.api].users, function(x, uzer) {
                    that.$bucket.append(new that.user(uzer, x));
                });
                that.offset += data.data[that.api].users.length;
            } else {
                $(window).unbind('scroll');
            }
        });
    }
}


userList.prototype.user = function(data, rank) {
    this.data = data;
    this.rank = rank;

    return this.addMeToBucket();
}

userList.prototype.user.prototype.addMeToBucket = function() {
    var str = '';
    if(this.data.posts) {
        $.each(this.data.posts, function(x, post) {
            str += '<li><a href="/post-details?posting_id='+post.posting_id+'" rel="modal" class="zoom-in"><img src="'+post.image_url+'&width=125"></a></li>';
        });
    }

    var $userFrame = $('<div class="userFrame"></div>');
    $userFrame.append( new dahliawolf.$hoverAvatar(this.data) );
    $userFrame.append('<ul class="dataList"><li class="dlUsername"><a href="/'+this.data.username+'">'+this.data.username+'</a>'+( this.data.membership_level === 'VIP' ? '<div class="memberStats"><a href="/help/vip"><img src="/images/vip.png"></a></div>' : '')+'</li><li>'+this.data.points+' pts</li></ul>');
    $userFrame.append('<ul class="postList">'+str+'</ul>');
    if(dahliawolfUserList.isWolfpack) this.$userFrame.append('<div class="rankBox">'+this.rank+'</div>');
    //var $followButton = $('<div class="toggleFollow '+(Number(this.data.is_followed) ? 'dahliaHeadUnFollow' : 'dahliaHeadFollow' )+'">'+ (Number(this.data.is_followed) ? 'FOLLOWING' : 'FOLLOW' )+'</div>').appendTo($userFrame.find('.dataList')).on('click', $.proxy(this.toggleFollowers, this) );

    return $userFrame;
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

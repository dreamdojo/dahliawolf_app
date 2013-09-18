function User(userData) {
    if(userData) {
        this.data = userData;
    } else {
        this.data = {};
    }
    this.member = new Member();
    this.post = new Post();
    this.post = new Post();
    this.share = new Share();
    this.shop = new Shop();
    this.loader = new this.Loader();
}

User.prototype = {
    get userId()    {return this.data.user_id;},
    get username()  {return this.data.username;},
    get location()  {return this.data.location;},
    get shopUrl()    {return '/'+this.data.username+'/shop/';},
    get avatar()    {return this.data.avatar;},
    get $avatar()    {return $('<img src="'+this.data.avatar+'">');},
    get firstName() {return this.data.first_name;},
    get lastName()  {return this.data.last_name;},
    get fullName()  {return this.data.first_name + ' '+this.data.last_name;},
    get followers() {return this.data.followers;},
    get increaseFollowers() { return ++this.data.followers;},
    get decreaseFollowers() { return --this.data.followers;},
    get isLoggedIn() {return (this.data.user_id && this.data.user_id > 0 ? true : false);},
    get whoareyou() {return 'A hot bitch with a fat ASS!!';},
    get hi() {return 'hello!';},
    get areYouLoggedIntoTwitter() {return this.data.twitterToken;},
    get areYouLoggedIntoTumblr() {return this.data.tumblrToken;},

    getAttribute : function(attr) {return (this.data[attr] ? this.data[attr] : 'Invalid');},

    set twitterToken(token) {this.data.twitterToken = token;},
    set tumblrToken(token) {this.data.tumblrToken = token;}
};

User.prototype.Loader = function(){
    this.$view = $('#loadingView');
    this.speed = 200;
}

User.prototype.Loader.prototype.show = function() {
    var $view = $('#loadingView');

    $view.show();
    $view.animate({'bottom': 0}, this.speed, function() {
        setTimeout(function() {
            $view.find('img').addClass('spinnerz').on('webkitTransitionEnd', function() {
                if($(this).hasClass('spinnerz')) {
                    $(this).removeClass('spinnerz');
                } else {
                    $(this).addClass('spinnerz')
                }
            });
        }, 100);
    });
}

User.prototype.Loader.prototype.hide = function() {
    var $view = $('#loadingView');

    $view.animate({'bottom': '-'+100+'px'}, this.speed, function() {
        $view.hide();
        $view.find('img').removeClass('spinnerz').unbind();
    });
}

User.prototype.setFriends = function(data) {
    this.friends = data;
}

User.prototype.isFacebookFriend = function(id) {
    var retVal = false;
    if(this.friends.length) {
        $.each(this.friends, function(index, friend) {
            if(friend.fb_uid == id) {
                retVal = friend;
                return;
            }
        });
    } else {
        holla.log('no friends set');
    }
    return retVal;
}

User.prototype.isFriend = function(id) {
    return true;
}

User.prototype.logIntoTwitter = function() {
    window.open(
        "/redirect.php",
        'Log into Twitter',
        'width=500, height=500'
    );
}

User.prototype.logIntoTumblr = function(callback) {
    var loginWindow = window.open(
        "/lib/TumblrOAuth/connect.php",
        'Log into Tumblr',
        'width=500, height=700'
    );
}

User.prototype.logIntoFacebook = function(callback) {
    FB.login(function(response) {
        if (response.authResponse) {
            if(typeof callback == 'function') {
                callback();
            }
        } else {
            // User cancelled login or did not fully authorize
        }
    }, {scope: 'email'});
}

//***************************************************************************** User uploading system
User.prototype.uploadAvatar = function(_this, file) {
    this.coordTop = $(_this).offset().top;
    this.coordLeft = $(_this).offset().left;
    this.file = file;
    $('.avatarChangeButton').hide();

    if( window.FormData !== undefined ) {
        this.preview();
    } else {
        this.doUploadAvatar();
    }
}

User.prototype.uploadAvatar.prototype.preview = function() {
    var reader = new FileReader();

    reader.readAsDataURL(this.file);
    reader.onload = $.proxy(this.drawPreview, this);
}

User.prototype.uploadAvatar.prototype.drawPreview = function(event) {
    this.$previewImg = $('<div class="avatarFrame avatarShadow" style="background-image: url(\''+event.target.result+'\');"></div>');
    this.$view = $('<div id="avatarUploadSystem"></div>').css('left' , this.coordLeft+40).css('top' , this.coordTop-10);
    this.$swapButton = $('<div class="swapButton">Accept</div>');
    this.$changeButton = $('<div class="swapButton">Change</div>');
    this.$cancelButton = $('<div class="swapButton">Cancel</div>');
    this.$uploadStatus = $('<div id="percUpload"></div>').appendTo(this.$view);

    this.$previewImg.appendTo(this.$view);
    this.$swapButton.appendTo(this.$view).on('click', $.proxy(this.doUploadAvatar, this) );
    this.$changeButton.appendTo(this.$view).on('click', $.proxy(this.changeAvatar, this) );
    this.$cancelButton.appendTo(this.$view).on('click', $.proxy(this.closeShop, this) );
    this.$view.appendTo($('body')).fadeIn(200);
}

User.prototype.uploadAvatar.prototype.doUploadAvatar = function() {
    var URL = '/action/settings.php?ajax=true';
    var that = this;

    var MyForm = new FormData();

    MyForm.append("avatar", this.file);
    MyForm.append("avatarAjax", true);

    var oReq = new XMLHttpRequest();

    oReq.upload.onprogress = function(e) {
        that.$uploadStatus.html( Math.ceil( (e.loaded/e.total)*100 )+'%');
    }

    oReq.onreadystatechange = function() {
        if(this.readyState == 4) {
            var $avatars = $('.theUsersAvatar');
            that.newAvatar = $.parseJSON(this.responseText).data.avatar;

            that.$view.animate({left: that.coordLeft - 121}, 200, function() {
                $.each($avatars, function(index, avatar) {
                    var $avatar = $(avatar);

                    if($avatar.find('img').length) {
                        $avatar.find('img').attr('src', that.newAvatar+'&width=150&time='+new Date().getTime());
                    } else {
                        $('.theUsersAvatar').css('background-image', 'url('+that.newAvatar+'&width=150)');
                    }
                });
                setTimeout(function() {
                    $('.avatarChangeButton').show();
                    that.closeShop();
                }, 100);
            });
        }
    }
    oReq.open("POST", URL);
    oReq.send(MyForm);
}

User.prototype.uploadAvatar.prototype.changeAvatar = function() {
    alert('coming soon');
}

User.prototype.uploadAvatar.prototype.updateAvatar = function(file) {
    this.file = file;
    //this.$previewImg.css('background-image', 'url('')');
}

User.prototype.uploadAvatar.prototype.closeShop = function() {
    this.$view.fadeOut(200, function() {
        $(this).empty().remove();
    });
}


//************************************************************************************ API

function Api() {
    this.baseUrl = '/api/1-0/';
    this.baseCommerceUrl = "/api/commerce/";
    this.commerceApi = false;
}

Api.prototype.callApi = function(data) {
    that = this;
    data.use_hmac_check = 0;
    data.function = this.apiFunction;

    if(dahliawolf.isLoggedIn) {
        var url = (this.commerceApi ? this.baseCommerceUrl : this.baseUrl)+this.apiApi;
        _gaq.push(['_trackEvent', this.apiApi, this.apiFunction]);
        $.getJSON(url, data, function(data) {
            if(typeof that.callback === 'function') {
                that.callback(data);
            }
        });
    } else {
        console.log('not logged in');
    }
}
//************************************************************************************ MEMBER
Member.prototype = new Api();
Member.prototype.constructor = Member;

function Member() {
    this.apiApi = 'user.json';
}

Member.prototype.follow = function(id, callback) {
    this.apiFunction = 'follow';
    this.callback = callback;
    this.callApi({user_follow_id : id, user_id : dahliawolf.userId});
    return this;
}

Member.prototype.unfollow = function(id, callback) {
    this.apiFunction = 'unfollow';
    this.callback = callback;
    this.callApi({user_follow_id : id, user_id : dahliawolf.userId});
    return this;
}
//************************************************************************************ POST
function Post() {
    this.apiApi = 'posting.json'
}
Post.prototype = new Api();
Post.prototype.constructor = Post;

Post.prototype.love = function(id, callback) {
    this.apiFunction = 'add_like';
    this.callApi({user_id: dahliawolf.userId, posting_id : id, like_type_id:1});
    return this;
}

Post.prototype.unlove = function(id, callback) {
    this.apiFunction = 'delete_like';
    this.posting_id = id;
    this.callApi({user_id: dahliawolf.userId, posting_id : id, like_type_id:1});
    return this;
}

Post.prototype.delete = function(id, callback) {
    this.apiFunction = 'delete';
    this.callApi();
    return this;
}
Post.prototype.promote = function(id, callback) {
    this.apiFunction = 'promote';
    this.callback = callback;
    this.callApi({posting_id : id, user_id : dahliawolf.userId});
    return this;
}
Post.prototype.getLovers = function(id, limit, offset, callback) {
    this.apiFunction = 'get_lovers';
    this.callback = callback;
    this.callApi({ posting_id : id, viewer_user_id : dahliawolf.userId, offset : offset, limit : limit});

    return this;
}

Post.prototype.shareOnTumbler = function(URL) {
    if(dahliawolf.areYouLoggedIntoTumblr) {
        $.getJSON('/lib/TumblrOAuth/sharePost.php',{url:URL}, function(data) {
           console.log(data);
        });
    } else {
        dahliawolf.logIntoTumblr(function() {
            console.log('holla');
        });
    }
}

Post.prototype.shareOnTwitter = function(URL) {
    if(dahliawolf.areYouLoggedIntoTwitter) {
        $.getJSON('/action/sharePostOnTwitter.php',{url:URL}, function(data) {
            console.log(data);
        });
    } else {
        dahliawolf.logIntoTwitter(function() {
            holla.log('poopsy');
        });
    }
}

Post.prototype.shareOnFacebook = function(URL) {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            holla.log(response);
            $.post('https://graph.facebook.com/me/photos?access_token="'+response.authResponse.accessToken,{source:URL}, function(data) {
                holla.log(data);
            });
        } else if (response.status === 'not_authorized') {
            dahliawolf.logIntoFacebook();
        } else {
            dahliawolf.logIntoFacebook();
        }
    });
}
//****************************************************************************************** Product
function Shop() {
    this.apiApi = 'product.json';
    this.commerceApi = true;
}
Shop.prototype = new Api();
Shop.prototype.constructor = Shop;

Shop.prototype.getProducts = function(callback) {
    this.apiFunction = 'get_products';
    this.callback = callback;
    this.callApi({viewer_user_id : dahliawolf.userId, id_shop:3, id_lang:1});
    ///api/commerce/product.json?function=get_products'+(theUser.id ? '&viewer_user_id='+theUser.id : '')+'&use_hmac_check=0&id_shop=3&id_lang=1
}

//**************************************************************************************** SHARING

function Share() {
    this.apiApi = 'sharing.json';
}

Share.prototype = new Api();
Share.prototype.constructor = Share;

Share.prototype.add = function(id, net, type, posting_owner, callback) {
    this.callback = callback;
    this.apiFunction = 'add_share';
    if(type === 'posting') {
        this.callApi({posting_id : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner });
    } else {
        this.callApi({id_product : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner });
    }
}

Share.prototype.get = function(id, type, callback) {
    this.callback = callback;
    this.apiFunction = 'get_shares';
    this.callApi({posting_id : id, user_id : dahliawolf.userId, type : type});
}


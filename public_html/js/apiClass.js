function User(userData) {
    console.log('Hello, Welcome to Dahlia/Wolf');
    if(userData) {
        this.data = userData;
    } else {
        this.data = {};
    }
    this.member = new Member();
    this.post = new Post();
    this.share = new Share();
    this.shop = new Shop();
    this.cart = new Cart();
    this.search = new Search();
    this.activity = new Activity();
    this.message = new Message();
    this.loader = new this.Loader();
    this.social = new Social();
    this.bank = new Bank();
    this.userStack = [];
    this.redirect = null;
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
    get areYouLoggedIntoFacebook() {return this.data.facebookToken;},

    getAttribute : function(attr) {return (this.data[attr] ? this.data[attr] : 'Invalid');},

    set twitterToken(token) {this.data.twitterToken = token;},
    set tumblrToken(token) {this.data.tumblrToken = token;}
};

User.prototype.login = function(e) {
    var formData = $(this).serialize();
    var prevUrl = document.URL;
    $.post('/action/login', formData, function(data) {
        var result = $.parseJSON(data);

        if(result[0] == 'success') {
            if(dahliawolf.redirect) {
                document.location = '/inspire';
            } else {
                dahliawolf.data = result[2];
                $('#userMenuFrame').load('/blocks/userMenu.php');
                $('.loginDept').empty();
                $('#phoPop').remove();
            }
            _gaq.push(['_trackEvent', 'Login', 'Success']);
        } else {
            e.data.$errorBox.html('*'+result[0]);
            _gaq.push(['_trackEvent', 'Login', result[0]]);
            _gaq.push(['_trackEvent', 'Errors', result[0]]);
        }
    });
    return false;
}

User.prototype.register = function(e) {
    var formData = $(this).serialize();
    $.post('/action/signup', formData, function(data) {
        var result = $.parseJSON(data);

        if(result[0] == 'success') {
            _gaq.push(['_trackEvent', 'Register', 'Success']);
            location.reload();
        } else {
            e.data.$errorBox.html('*'+result[0]);
            _gaq.push(['_trackEvent', 'Register', result[0]]);
            _gaq.push(['_trackEvent', 'Errors', result[0]]);
        }
    });
    return false;
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
        //
    }
    return retVal;
}

User.prototype.isFriend = function(id) {
    return true;
}

User.prototype.logIntoTwitter = function(callback) {
    globalCallback = callback;
    var win = window.open(
        "/redirect.php",
        'Log into Twitter',
        'width=500, height=500'
    );
}

User.prototype.logIntoTumblr = function(callback) {
    globalCallback = callback;
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

User.prototype.phoPop = function(url, title, callback) {
    var $phoPop;

    if(url) {
        if( $('#phoPop').length ) {
            $phoPop = $('#phoPop');
            $phoPop.empty();
        } else {
            $phoPop = $('<div id="phoPop"></div>');
        }
        window.history.pushState({}, '', url);
        _gaq.push(['_trackPageview']);
        window.onpopstate = function(event) {
            $phoPop.remove();
        }
        url += '?ajax=true';
        $('body').prepend($phoPop);
        $phoPop.load(url, callback);
    } else {
        holla.log('No URL');
    }
}

//****************************************************************** $VIEWS

User.prototype.$post = function(data) {
    this.data = data;

    var $post = $('<div class="post gridMode"></div>');
    var $image = $('<div class="innerwrap"><a href="/post-details?posting_id='+this.id+'" class="image color-4" rel="modal"><img src="'+this.image+'width=300"></a></div>');

    return $post;
}

User.prototype.$post.prototype = {
    get id() {return this.data.posting_id;},
    get image() {return this.data.image_url}
}
//*********************************************** PRODUCT
User.prototype.$product = function(data) {
    this.data = data;
    var $prodInfo = $('<ul class="prodInfo"></ul>');
    var $product = $('<div class="shop-item '+this.status+'" id="item-'+this.id+'"></div>');
    var prodDeets = $('<ul class="prodDeets"><li>'+this.name+'</li><li>'+this.price+'</li></ul>').appendTo($product);
    var $imageFrame = $('<ul class="imageFrame"></ul>');
    var $productShot = $('<li class="productShot"></li>').css('background-image', 'url("'+this.productShot+'")').appendTo($imageFrame);
    var $avatar = $('<li class="avatar" style="background-image: url('+data.avatar+'&width=85);"></li>').appendTo($prodInfo);
    $('<li class="prodname">'+data.product_name+'</li>').appendTo($prodInfo);
    $('<li class="username">Inspiration by <a href="/'+data.username+'">'+data.username+'</a></li>').appendTo($prodInfo);
    $imageFrame.appendTo($product).wrap('<a href="/shop/'+data.id_product+'" rel="product"></a>');

    $product.append($prodInfo);

    return $product;
}

User.prototype.$product.prototype = {
    get id() {return this.data.id_product;},
    get status() {return this.data.status;},
    get isActive() {return Number(this.data.active);},
    get inspirationImage() {return this.data.inspiration_image_url;},
    get productShot() {return 'http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_file_id+'&width=300';},
    get bloggerShot() {return 'http://content.dahliawolf.com/shop/product/image.php?file_id='+this.data.product_images[1].product_file_id+'&width=300';},
    get name() {return this.data.product_name;},
    get avatar() {return this.data.avatar;},
    get username() {return this.data.username;},
    get isOnSale() {return Number(this.data.on_sale);},
    get presalePrice() {return Math.floor(this.data.sale_price).toFixed(2);},
    get price() {return Math.floor(this.data.price).toFixed(2);}
}

User.prototype.$sponsor = function(d) {
    var data = d;
    holla.log(d);
    var DAYS_LEFT = getDaysLeft(data.commission_from_date);
    var $sponsorItem = $('<div class="sponsorItem"></div>');

    var $prodInfo = $('<div class="prodInfo"></div>');
    $('<ul class="userDeets"><a href="/'+data.username+'"><li class="avatar" style="background-image: url(\''+data.avatar+'&width=50\')"></li></a><li class="prodTitle">'+data.product_name+'</li><li class="inspHead">Inspiration by <a href="/'+data.username+'">'+data.username+'</a></li></ul>').appendTo($prodInfo);
    $('<ul class="prodPrice current"><li>$50.00</li><li>50% OFF</li></ul><ul class="prodPrice closed"><li>$50.00</li><li>50% OFF</li></ul>').appendTo($prodInfo);
    $sponsorItem.append($prodInfo);

    var $itemImage = $('<div class="imgFrame"><a href="/sponsor/'+data.id_product+'"><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+data.product_images[0].product_file_id+'&width=500"></a></div>').appendTo($sponsorItem);
    var $sponsorDeets = $('<div class="sponsorDetails"></div>');
    var $toGoal = $('<ul><li>'+(Number(data.total_sales)/100)*100+'%</li><li>to goal</li></ul>').appendTo($sponsorDeets);
    var $left = $('<ul><li>'+DAYS_LEFT+'</li><li>'+(DAYS_LEFT  == 1 ? 'day' : 'days')+' left</li></ul>').appendTo($sponsorDeets);
    //var $spots = $('<ul><li>9</li><li>sponsors spot left at 50% off</li></ul>').appendTo($sponsorDeets);
    var $goal = $('<ul><li>9</li><li>sponsors spots left at 50% off</li></ul>').appendTo($sponsorDeets);
    var $status = $('<div class="statuses">' +
        '<ul class="status closed"><li>50% OFF</li><li>sold out</li></ul>' +
        '<ul class="status current"><li>30% OFF</li><li>22 spots left</li></ul>' +
        '<ul class="status pending"><li>20% OFF</li><li>22 spots left</li></ul>' +
        '</div>').appendTo($sponsorDeets);
    var $butt = $('<a href="/sponsor/'+data.id_product+'"><div class="greenbutton">SPONSOR NOW</div></a>').appendTo($sponsorDeets);


    $sponsorItem.append($sponsorDeets);
    return $sponsorItem;
}

//*********************************************** USER
User.prototype.$user = function(data) {

}

//************************************************ Avatar
User.prototype.$hoverAvatar = function(data) {
    var $avatar = $('<ul class="postDetailAvatarFrame avatarShutters" style="background-image: url(\''+data.avatar+'&width=85\')">');
    $('<li id="postDetailFollowButton">'+(Number(data.is_followed) ? 'Unfollow' : 'Follow')+'</li>').on('click', function() {
        if(Number(data.is_followed)) {
            data.is_followed = 0;
            dahliawolf.member.unfollow(data.user_id);
            $(this).html('Follow');
        } else {
            $(this).html('Unfollow');
            data.is_followed = 1;
            dahliawolf.member.follow(data.user_id);
        }
    }).appendTo($avatar);
    $('<li><a href="@'+data.username+'" rel="message">Message</a></li>').on('click', function() {

    }).appendTo($avatar);
    $('<li><a href="/'+data.username+'">Profile</a></li>').appendTo($avatar);

    return $avatar;
}

/******************************************* SPINNING LOADER **********/
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

//************************************** User uploading system
User.prototype.uploadAvatar = function(_this, file) {
    if(window.FileReader !== undefined) {
        this.coordTop = $(_this).offset().top;
        this.coordLeft = $(_this).offset().left;
        this.file = file;
        $('.avatarChangeButton').hide();
        this.preview();
        this.doUploadAvatar();
    } else {
        $('#avatarForm').submit();
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
//*********************************************************************************** DAHLIA HEADS

User.prototype.dahliaHead = function($data) {
    var id = $data.data('id');
    if(dahliawolf.userStack[id]) {
        dahliawolf.displayHead($data, dahliawolf.userStack[id]);
    } else {
        dahliawolf.member.get($data.data(), function(data) {
            data = data.data.get_user;
            dahliawolf.displayHead($data, data);
        });
    }
}

User.prototype.displayHead = function($data, data) {
    dahliawolf.userStack[data.user_id] = data;
    var $dahliaHead = $('<ul class="dahliaHeadAva avatarShutters"></ul>');
    $('<div class="shutterAvatar"></div>').css('background-image', 'url("'+data.avatar+'&width=85")').appendTo($dahliaHead);
    $('<li style="border-bottom: #c2c2c2 thin solid">'+(Number(data.is_followed) ? 'Following' : 'Follow')+'</li>').appendTo($dahliaHead).on('click', function(e) {
        e.preventDefault();
        if(Number(data.is_followed)) {
            data.is_followed = 0;
            $(this).html('Follow');
            dahliawolf.member.unfollow(data.user_id);
        } else {
            dahliawolf.member.follow(data.user_id);
            data.is_followed = 1;
            $(this).html('Following');
        }
    });
    $('<li>Message</li>').appendTo($dahliaHead).on('click', function(e) {
        e.preventDefault();
        dahliaMessenger.newMessage(data.username);
    });
    $('<li>Profile</li>').appendTo($dahliaHead);
    $data.append($dahliaHead).on('mouseleave', function() {
        setTimeout(function() {
            $dahliaHead.fadeOut(200, function() {
                $(this).remove();
            });
        }, 200);
    });
    $('<div class="headPadding"></div>').appendTo($data);
    $dahliaHead.fadeIn(100);
}


//************************************************************************************ API

function Api() {
    this.baseUrl = '/api/1-0/';
    this.baseCommerceUrl = "/api/commerce/";
    this.commerceApi = false;
    this.loginRequired = false;
    this.analArray = [];
}

Api.prototype.callApi = function(data, callback) {
    var that = this;
    data.use_hmac_check = 0;
    data['function'] = this.apiFunction;
    var url = (this.commerceApi ? this.baseCommerceUrl : this.baseUrl)+this.apiApi;

    if(this.loginRequired && dahliawolf.isLoggedIn) {
        $.getJSON(url, data, function(data) {
            if(typeof callback === 'function') {
                callback(data);
                callback = null;
            }
        });
    } else if(this.loginRequired && !dahliawolf.isLoggedIn) {
        new_loginscreen();
    }
    else {
        $.getJSON(url, data, function(data) {
            if(typeof callback === 'function') {
                callback(data);
                callback = null;
            }
        });
    }
    if(this.analArray) {
        _gaq.push(this.analArray);
    }
}
//************************************************************************************ MEMBER
Member.prototype = new Api();
Member.prototype.constructor = Member;

function Member() {
    this.apiApi = 'user.json';
}

Member.prototype.get = function(data, callback) {
    this.apiFunction = 'get_user';
    this.loginRequired = false;
    this.analArray = ['_trackEvent','Dahliahead', 'Dahlia head appeared'];
    this.callback = callback;
    this.callApi({user_id:data.id, username:data.username, viewer_user_id:dahliawolf.userId}, callback);
    return this;
}

Member.prototype.follow = function(id, callback) {
    this.apiFunction = 'follow';
    this.loginRequired = true;
    this.analArray = ['_trackEvent','Social', 'User Followed Another Member'];
    this.callback = callback;
    this.callApi({user_follow_id : id, user_id : dahliawolf.userId}, callback);
    return this;
}

Member.prototype.unfollow = function(id, callback) {
    this.apiFunction = 'unfollow';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Social', 'User Unfollowed Another Member'];
    this.callback = callback;
    this.callApi({user_follow_id : id, user_id : dahliawolf.userId}, callback);
    return this;
}

Member.prototype.getTopFollowing = function(userId, lim, off, callback) {
    this.apiFunction = 'get_top_following';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi({user_id:userId, viewer_user_id:dahliawolf.userId, limit:lim, offset:off}, callback);
    return this;
}

Member.prototype.getTopFollowers = function(userId, lim, off, callback) {
    this.apiFunction = 'get_top_followers';
    this.loginRequired = false;
    this.callApi({user_id:userId, viewer_user_id:dahliawolf.userId, limit:lim, offset:off}, callback);
    return this;
}

Member.prototype.getTopUsers = function(userId, lim, off, callback) {
    this.apiFunction = 'get_top_users';
    this.loginRequired = false;
    this.callApi({user_id:userId, viewer_user_id:dahliawolf.userId, limit:lim, offset:off}, callback);
    return this;
}
//************************************************************************************ POST
function Post() {
    this.apiApi = 'posting.json'
}
Post.prototype = new Api();
Post.prototype.constructor = Post;

Post.prototype.get = function(config, callback) {
    this.apiFunction = 'get_all';
    this.loginRequired = false;
    this.analArray = ['_trackEvent', 'System', 'Got posts for feed'];
    this.loginRequired = false;
    this.callApi(config, callback);
    return this;
}

Post.prototype.getDetails = function(id, callback) {
    this.apiFunction = 'get_posting';
    this.loginRequired = false;
    this.callApi({posting_id:id, viewer_user_id:dahliawolf.userId}, callback);
    return this;
}

Post.prototype.getDetails = function(id, callback) {
    this.apiFunction = 'get_posting';
    this.loginRequired = false;
    this.callApi({posting_id:id, user_id:dahliawolf.userId}, callback);
    return this;
}

Post.prototype.get_by_user = function(config, callback) {
    this.apiFunction = 'get_by_user';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi(config, callback);
    return this;
}

Post.prototype.love = function(id, callback) {
    this.apiFunction = 'add_like';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User loved a post'];
    this.callback = callback;
    this.callApi({user_id: dahliawolf.userId, posting_id : id, like_type_id:1}, callback);
    return this;
}

Post.prototype.unlove = function(id, callback) {
    this.apiFunction = 'delete_like';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User unloved a post'];
    this.callApi({user_id: dahliawolf.userId, posting_id : id, like_type_id:1}, callback);
    return this;
}

Post.prototype.dislike = function(id, callback) {
    this.apiFunction = 'add_post_dislike';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'Added dislike'];
    this.callApi({user_id: dahliawolf.userId, posting_id : id}, callback);
    return this;
}

Post.prototype.repost = function(_posting_id, callback) {
    this.apiFunction = 'repost';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'Reposted post'];
    this.callApi({posting_id:_posting_id, repost_user_id:dahliawolf.userId}, callback);
    return this;
}

Post.prototype.deleteMe = function(id, callback) {
    this.apiFunction = 'delete';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'Post deleted'];
    this.callApi();
    return this;
}

Post.prototype.promote = function(id, callback) {
    this.apiFunction = 'promote';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User promoted a post'];
    this.callback = callback;
    this.callApi({posting_id : id, user_id : dahliawolf.userId}, callback);
    return this;
}

Post.prototype.addToFaves = function(id, callback) {
    this.apiFunction = 'fave';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User added a post to faves'];
    this.callback = callback;
    this.callApi({posting_id: id, user_id : dahliawolf.userId}, callback);
    return this;
}

Post.prototype.delFromFaves = function(id, callback) {
    this.apiFunction = 'remove_fave';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User removed a post from faves'];
    this.callback = callback;
    this.callApi({posting_id: id, user_id:dahliawolf.userId }, callback);
    return this;
}

Post.prototype.getLovers = function(id, limit, offset, callback) {
    this.apiFunction = 'get_lovers';
    this.loginRequired = false;
    this.analArray = ['_trackEvent', 'Post', 'User is viewing post lovers'];
    this.callback = callback;
    this.callApi({ posting_id : id, viewer_user_id : dahliawolf.userId, offset : offset, limit : limit}, callback);

    return this;
}

Post.prototype.shareOnTumbler = function(URL, id) {
    if(dahliawolf.areYouLoggedIntoTumblr) {
        _gaq.push(['_trackEvent', 'Social', 'Pushed to Tumblr API']);
        $.getJSON('/lib/TumblrOAuth/sharePost.php',{url:URL}, function(data) {

        });
    } else {
        dahliawolf.logIntoTumblr(function() {
            dahliawolf.post.shareOnTumbler(URL, id);
        });
    }
}

Post.prototype.shareOnTwitter = function(URL, id) {
    if(dahliawolf.areYouLoggedIntoTwitter) {
        _gaq.push(['_trackEvent', 'Social', 'Pushed to Twitter API']);
        $.getJSON('/action/sharePostOnTwitter.php',{url:URL}, function(data) {

        });
    } else {
        dahliawolf.logIntoTwitter(function() {
            dahliawolf.post.shareOnTwitter(URL, id);
        });
    }
}

Post.prototype.shareOnFacebook = function(URL, id) {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            var params = {message : 'Create your own fashion on #DAHLIAWOLF #HellsYA www.dahliawolf.com/post/'+id, url : URL, access_token : response.authResponse.accessToken, upload_file : true, filename : 'Blop'};
            _gaq.push(['_trackEvent', 'Social', 'Pushed to Facebook API']);
            FB.api('/me/photos', 'post', params, function(response) {
                if (!response || response.error) {
                    //
                }
            });
        } else if (response.status === 'not_authorized') {
            dahliawolf.logIntoFacebook(function() {
                dahliawolf.post.shareOnFacebook(URL, id);
            });
        } else {
            dahliawolf.logIntoFacebook(function() {
                dahliawolf.post.shareOnFacebook(URL, id);
            });
        }
    });
}

Post.prototype.addTag = function(id, p_x, p_y, note, callback) {
    this.apiFunction = 'add_tag';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User added a tag to post'];
    this.callback = callback;
    this.callApi({user_id: dahliawolf.userId, posting_id: id, x:p_x, y:p_y, message: note });
    return this;
}

Post.prototype.editTag = function(id, note, callback) {
    this.apiFunction = 'edit_tag';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User edited a tag to post'];
    this.callback = callback;
    this.callApi({user_id: dahliawolf.userId, posting_tag_id:id, message: note }, callback);
    return this;
}

Post.prototype.delTag = function(id, post_id, callback) {
    this.apiFunction = 'remove_tag';
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Post', 'User removed a tag from post'];
    this.callback = callback;
    this.callApi({user_id: dahliawolf.userId, posting_tag_id:id, posting_id:post_id}, callback);
    return this;
}

Post.prototype.getTags = function(id, callback) {
    this.apiFunction = 'get_tags';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi({user_id: dahliawolf.userId, posting_id: id}, callback);
    return this;
}

Post.prototype.addComment = function(id, com, callback) {
    this.apiFunction = 'add_comment';
    this.loginRequired = true;
    this.callback = callback
    this.analArray = ['_trackEvent', 'Post', 'Comment added'];
    this.callApi({user_id:dahliawolf.userId, posting_id:id, comment:com}, callback);
    return this;
}

Post.prototype.getComments = function(id, callback) {
    this.apiFunction = 'get_comments';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi({posting_id:id}, callback);
}

//****************************************************************************************** SEARCH
function Search() {
    this.apiApi = 'search.json';
}
Search.prototype = new Api();
Search.prototype.constructor = Search;

Search.prototype.searchAll = function(call, callback) {
    this.apiFunction = 'search_all';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi(call, callback);
    return this;
}

//****************************************************************************************** Product
function Shop() {
    this.apiApi = 'product.json';
    this.commerceApi = true;
}
Shop.prototype = new Api();
Shop.prototype.constructor = Shop;

Shop.prototype.getProduct = function(id, callback) {
    this.apiFunction = 'get_product_details';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi({id_product:id, id_shop:3, id_lang:1}, callback);
    return this;
}

Shop.prototype.getProducts = function(callback) {
    this.apiFunction = 'get_products';
    this.loginRequired = false;
    this.callback = callback;
    this.callApi({viewer_user_id : dahliawolf.userId, id_shop:3, id_lang:1}, callback);
    ///api/commerce/product.json?function=get_products'+(theUser.id ? '&viewer_user_id='+theUser.id : '')+'&use_hmac_check=0&id_shop=3&id_lang=1
}

Shop.prototype.addProductToCart = function(callback) {
    if( $('[name="id_product_attribute"]:checked').length ) {
        _gaq.push(['_trackEvent', 'Cart', 'Item added to cart']);
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
            dahliawolf.cart.update();
            if(typeof callback == 'function') {
                callback();
            }
        });
    } else {
        _gaq.push(['_trackEvent', 'Cart', 'Size needed']);
        alert('Please select a size');
    }
    return false;
}

//************************************************************************************* CART

function Cart() {
    var that = this;

    $(function() {
        that.$totalCount = $('.cartCount');
        that.$cart = $('#dahliaCart');
        that.$cartContainer = $('#shoppingCart');
        that.$bezier = $('<div class="cart_bezier"></div>');
        that.$checkoutButton = $('<a href="/shop/cart"><li class="cta">Edit bag/ Check out</li></a>');
    });
}

Cart.prototype = {
    get getTotalProducts() {
        var that = this;
        return function() {
        var retVal = 0;
        $.each(that.data.products, function(x, prod) {
            retVal += Number(prod.quantity);
        });
        return retVal;
    }},
    get getStoreCredits() {return this.data.available_store_credits.total_credits;},
    get getCartTotal() {return this.data.cart.totals.grand_total;}
}

Cart.prototype.set = function(data) {
    this.data = data;

    return this;
}

Cart.prototype.$setTotal = function() {
    this.$totalCount.html(this.getTotalProducts);
    return this;
}

Cart.prototype.update = function(callback) {
    var that = this;

    $.getJSON('/action/shop/loadCart', function(data) {
        that.set(data);
        that.$setTotal();
        if(data.products.length == 1) {
            that.$totalCount.addClass('fullCart').removeClass('emptyCart');
            that.$cart = $('<ul id="dahliaCart"></ul>').appendTo(that.$cartContainer);
        }
        that.$cart.empty().append(that.$bezier.clone());
        $.each(data.products, function(x, item) {
            that.$cart.append(that.$getItem(item));
        });
        that.$cart.append(that.$checkoutButton.clone());
        that.$cart.fadeIn(300, function() {
            setTimeout(function() {
                that.$cart.fadeOut(200);
            }, 2000);
        });
        if(typeof callback == 'function') {
            callback();
        }
    });
}

Cart.prototype.$getItem = function(data) {
    return $('<ul><li><img src="http://content.dahliawolf.com/shop/product/image.php?file_id='+data.product_info.product_file_id+'&width=80"></li>' +
        '<li style="line-height: 20px;">Enchanting Velvet Pants</li><li>$'+(Number(data.product_info.on_sale) ? data.product_info.sale_price : data.product_info.price )+'</li>' +
        '<li>'+data.attributes+'</li><li>Quantity '+data.quantity+'</li></ul>');
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
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'Social', 'User is sharing a post', net];
    if(type === 'posting') {
        this.callApi({posting_id : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner }, callback);
    } else {
        this.callApi({id_product : id, sharing_user_id : dahliawolf.userId, network : net, type : type, posting_owner_user_id : posting_owner }, callback);
    }
}

Share.prototype.get = function(id, type, callback) {
    this.callback = callback;
    this.apiFunction = 'get_shares';
    this.loginRequired = true;
    this.callApi({posting_id : id, user_id : dahliawolf.userId, type : type}, callback);
    return this;
}

//******************************************************************************************* ACTIVITY

function Activity() {
    this.apiApi = 'activity_log.json';
}

Activity.prototype = new Api();
Activity.prototype.constructor = Activity;

Activity.prototype.getNew = function(callback) {
    this.apiFunction = "get_grouped_log_count";
    this.callback = callback;
    this.loginRequired = true;
    this.analArray = ['_trackEvent', 'System', 'Checking New'];
    this.callApi({user_id:dahliawolf.userId}, callback);
    return this;
}

Activity.prototype.getCategory = function(t, callback) {
    this.apiFunction = 'get_by_type';
    this.loginRequired = true;
    this.callback = callback;
    this.callApi({type:t, user_id:dahliawolf.userId, viewer_user_id:dahliawolf.userId}, callback);
    return this;
}


//********************************************************************************************** Message

function Message() {
    this.apiApi = 'message.json';
}

Message.prototype = new Api();
Message.prototype.constructor = Message;

Message.prototype.send = function(to, message, callback) {
    this.apiFunction = 'send_message';
    this.loginRequired = true;
    this.callback = callback;
    this.analArray = ['_trackEvent', 'Message', 'Direct message sent'];
    this.callApi({to_user_name:to, from_user_id:dahliawolf.userId, header:'Personal message from '+dahliawolf.username, body:message}, callback);
    return this;
}

//************************************************************************************************** SOCIAL NETWORKS

function Social() {
    this.apiApi = 'social_network';
}

Social.prototype = new Api();
Social.prototype.constructor = Social;

Social.prototype.setToken = function(network, toke, callback) {
    this.apiFunction = 'save_link';
    this.loginRequired = true;
    this.callback = callback;
    this.analArray = ['_trackEvent', 'Social', 'Saved token'];
    this.callApi({user_id:dahliawolf.userId, social_network_id:network, token:toke}, callback);
    return this;
}

Social.prototype.getToken = function(network, toke, callback) {
    this.apiFunction = 'save_link';
    this.loginRequired = true;
    this.callback = callback;
    this.analArray = ['_trackEvent', 'Social', 'Saved token'];
    this.callApi({user_id:dahliawolf.userId, social_network_id:network, token:toke}, callback);
    return this;
}
Social.prototype.unsetPlatform = function(platform_id, callback) {
    if(platform_id) {
        $.post('/action/unsetPlatform', {platform:platform_id}, callback);
    }
}

//*************************************************************************************************** IMAGE BANK

function Bank() {
    this.apiApi = 'image_bank.json';
}

Bank.prototype = new Api();
Bank.prototype.constructor = Bank;

Bank.prototype.get = function(off, lim, callback) {
    this.apiFunction = 'get_feed';
    this.loginRequired = false;
    this.callback = callback;
    this.analArray = ['_trackEvent', 'System', 'Loaded Imgs from Bank'];
    this.callApi({offset:off, limit:lim}, callback);
    return this;
}

Bank.prototype.post = function(repo_id, obj_id, callback) {
    this.apiFunction = 'post_image';
    this.loginRequired = true;
    this.callback = callback;
    this.analArray = ['_trackEvent', 'Inspire', 'Posted image from bank'];
    this.callApi({user_id:dahliawolf.userId, repo_image_id:repo_id, object_id:obj_id}, callback);
    return this;
}
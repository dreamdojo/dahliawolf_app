function voteFeed(config) {
    this.feedMode = config.mode;
    this.filter = (config.filter ? config.filter : null);
    this.search = (config.search ? config.search : null);
    this.offset = 0;
    this.limit = {'spine': 16, 'grid':15};
    this.postArray = new Array();
    this.posts = new Object();
    this.$bucket = $('#voteBucket');
    this.$spineButton = $('#selectSpine');
    this.$gridButton = $('#selectGrid');
    this.isApiAvailable = true;

    this.prepBucket();
    this.getPostsFromApi();
    this.bindScroll();
    this.bindButtons();
}

voteFeed.prototype = {
    get url() {
        var config = {limit: this.limit[this.feedMode], offset: this.offset};
        if(dahliawolf.isLoggedIn) {
            config.viewer_user_id = dahliawolf.userId;
        }
        if(this.isOrderSet) {
            config.order_by = this.getOrder;
            config.like_day_threshold = this.like_day_threshold;
        }
        if(this.isFilterSet) {
            config.filter_by = this.getFilter;
            config.follower_user_id = dahliawolf.userId;
        }
        return config;
    },
    get isGridMode() {return this.feedMode === 'grid'},
    get isSpineMode() {return this.feedMode === 'spine'},
    get theFeedMode() {return this.feedMode;},
    get randomWidth() {return Math.random() * (450 - 260) + 260;},
    get isOrderSet() {return (this.order ? true : false);},
    get getOrder() {return this.order;},
    get isFilterSet() {return (this.filter ? true : false);},
    get getFilter() {return this.filter;},

    set setFeedMode(mode) {this.feedMode = mode;},
    set setOrder(order) {this.order = order;},
    set setFilter(filter) {this.filter = filter;}
}

voteFeed.prototype.bindButtons = function() {
    var that = this;

    $('#filterNewest').on('click', function(e) {
        $('.sort-option').removeClass('filter-select');
        $(this).addClass('filter-select');
        e.preventDefault();
        that.setFilter = null;
        that.setOrder = null;
        that.like_day_threshold = null;
        that.resetFeed();
        that.getPostsFromApi();
    });

    $('#filterTrending').on('click', function(e) {
        $('.sort-option').removeClass('filter-select');
        $(this).addClass('filter-select');
        e.preventDefault();
        if(!that.isOrderSet && that.getOrder !== 'hot') {
            that.setFilter = null;
            that.setOrder = 'total_likes';
            that.like_day_threshold = 7;
            that.resetFeed();
            that.getPostsFromApi();
        }
    });

    $('#filterFollowing').on('click', function(e) {
        $('.sort-option').removeClass('filter-select');
        $(this).addClass('filter-select');
        e.preventDefault();
        if(!that.isFilterSet && that.getFilter !== 'following') {
            that.setOrder = null;
            that.like_day_threshold = null;
            that.setFilter = 'following';
            that.resetFeed();
            that.getPostsFromApi();
        }
    });

    this.$gridButton.on('click', function(e) {
        e.preventDefault();
        if(!that.isGridMode) {
            that.setFeedMode = 'grid';
            that.refillBucket();
        }
    });
    this.$spineButton.on('click', function(e) {
        e.preventDefault();
        if(!that.isSpineMode) {
            that.setFeedMode = 'spine';
            that.refillBucket();
        }
    });

}

voteFeed.prototype.resetFeed = function() {
    this.postArray = [];
    this.posts = {};
    this.$bucket.empty();
    this.offset = 0;
    this.prepBucket();
}

voteFeed.prototype.addPostData = function(post) {
    if(post) {
        this.postArray.push(post.posting_id);
        this.posts[Number(post.posting_id)] = post;
    }
}


voteFeed.prototype.getPostData = function(posting_id) {
    if(posting_id) {
        return this.posts[posting_id];
    }
}
voteFeed.prototype.get$Post = function(id, index) {
    var that = this;
    var post = this.getPostData(id);
    var postDims = {0:[330, 496], 1:[300, 450], 2:[390, 390], 3:[360, 540], 4:[420, 633], 5:[450, 645], 6:[300, 450], 7:[334, 334], 8:[390, 519], 9:[360, 450], 10:[450, 450], 11:[420, 560], 12:[300, 533], 13:[334, 346], 14:[390, 390], 15:[365, 548]};

    var $post = $('<div class="post '+(this.isSpineMode ? 'spineMode' : 'gridMode')+'"></div>');
    $post.append(new shareBall(post));
    $post.append(new voteDot(post, function() {
        that.updateLoveStats(post, $heartBG, $heartCount)
    }));

    var $userBar = $('<div class="userBar"><a href="/'+post.username+'" class="dahliaHead" data-id="'+post.user_id+'">'+post.username+'</a></div>');
    var $counts = $('<ul></ul>').appendTo($userBar).on('click', function() {
        $post.find('.voteDot').click();
    });
    var $heartBG = $('<li class="loveHeart" style="background-position: '+(Number(post.is_liked) ? 1 : '-'+21)+'px;"></li>').appendTo($counts);
    var $heartCount = $('<li class="loveCount">'+post.total_likes+'</li>').appendTo($counts);
    $post.append($userBar);

    if(this.isSpineMode) {
        var img_url = post.image_url+'&height='+postDims[index % 16][1];
        var $img = $('<img src="'+img_url+'&height='+postDims[index % 16][1]+'">');
        if(Number(post.width) > Number(post.height)) {
            $img.css('margin-left', '-'+((Number(post.width) - postDims[index % 16][0]) / 2)+'px');
        }
        $img.appendTo($post);
        $img.wrap('<div class="innerwrap" style="width:'+postDims[index % 16][0]+'px; height:'+postDims[index % 16][1]+'px"></div>');
    } else {
        var img_url = post.image_url+'&width=300';
        var $img = $('<img src="'+img_url+'">').appendTo($post);
        $img.wrap('<div class="innerwrap"></div>');
    }
    $img.wrap('<a href="/post-details?posting_id='+post.posting_id+'" class="image color-'+(Math.floor(Math.random() * (6 - 1) + 1))+'" rel="modal"></a>');

    return $post;
}

voteFeed.prototype.updateLoveStats = function(post, $heartBG, $count) {
    $heartBG.css('background-position', (post.is_liked ? 1 : '-'+23)+'px');
    $count.html(post.total_likes);
}

voteFeed.prototype.getPostsFromApi = function() {
    var that = this;

    if(this.isApiAvailable) {
        this.isApiAvailable = false;
        dahliawolf.loader.show();

        dahliawolf.post.get(this.url, function(data){
            holla.log(data);
            var tempArray = new Array();
            that.isApiAvailable = true;
            dahliawolf.loader.hide();
            that.offset += data.data.get_all.posts.length;

            $.each(data.data.get_all.posts, function(index, post) {
                that.addPostData(post);
                tempArray.push(post.posting_id);
            });
            that.addToBucket(tempArray);
        });
    }
}

voteFeed.prototype.addToBucket = function(posts) {
    $.each(posts, $.proxy(this.funnelPosts, this));
}

voteFeed.prototype.refillBucket = function() {
    this.$bucket.empty();
    this.prepBucket();
    $.each(this.postArray, $.proxy(this.funnelPosts, this));
}

voteFeed.prototype.funnelPosts = function(index, post) {
    if(this.isGridMode) {
        $('.GridCol'+index%3).append(this.get$Post(post))
        //this.$bucket.append(this.get$Post(post));
    } else if(this.isSpineMode) {
        var $left = $('.lefty');
        var $right = $('.righty');

        if(index % 2) {
            $right.append(this.get$Post(post, index));
        } else {
            $left.append(this.get$Post(post, index));
        }
    }
}

voteFeed.prototype.getShortestGridCol = function() {
    var left = Math.floor($('.GridCol0').height());
    var middle = Math.floor($('.GridCol1').height());
    var right = Math.floor($('.GridCol2').height());
    var temp = [left, middle, right];
    var index = 0;
    var value = temp[0];

    for (var i = 1; i < temp.length; i++) {
        if (temp[i] < value) {
            value = temp[i];
            index = i;
        }
    }
    return index;
}

voteFeed.prototype.prepBucket = function() {
    if(this.isSpineMode) {
        if(!$('.lefty').length) {
            this.$spineButton.addClass('filter-select');
            this.$gridButton.removeClass('filter-select');
            $('<div class="lefty"></div>').appendTo(this.$bucket);
            $('<div class="righty"></div><div style="clear:left;"></div>').appendTo(this.$bucket);
        }
        if(!this.$bucket.hasClass('spineMode')) {
            this.$bucket.addClass('spineMode');
        }
        if(this.$bucket.hasClass('gridMode')) {
            this.$bucket.removeClass('gridMode');
        }
    } else if(this.isGridMode) {
        if(!$('.leftGrid').length) {
            this.$bucket.append('<div class="gCol GridCol0"></div><div class="gCol GridCol1"></div><div class="gCol GridCol2"></div><div style="clear:left;"></div>');
            this.$spineButton.removeClass('filter-select');
            this.$gridButton.addClass('filter-select');
        }
        if(!this.$bucket.hasClass('gridMode')) {
            this.$bucket.addClass('gridMode');
        }
        if(this.$bucket.hasClass('spineMode')) {
            this.$bucket.removeClass('spineMode');
        }
    }
}

voteFeed.prototype.bindScroll = function() {
    var that = this
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
            that.getPostsFromApi();
        }
    });
}

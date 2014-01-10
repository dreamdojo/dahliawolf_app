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
    this.setOrder = 'total_likes';
    this.like_day_threshold = (config.search ? 0 : 1);

    this.prepBucket();
    this.getPostsFromApi();
    this.bindScroll();
    this.bindButtons();
}

voteFeed.prototype = {
    get url() {
        var config = {offset: this.offset};
        if(!this.search) {
            config.limit = this.limit[this.feedMode];
        } else {
            config.limit = 100;
        }
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
        if(this.search) {
            config.q = this.search;
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
    get isSearchSet() {return this.search ? true : false},
 
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
        _gaq.push(['_trackEvent', 'Feedfilter', 'Changed to Newest']);
    });

    $('#filterTrending').on('click', function(e) {
        $('.sort-option').removeClass('filter-select');
        $(this).addClass('filter-select');
        e.preventDefault();
        that.setFilter = null;
        that.setOrder = 'total_likes';
        that.like_day_threshold = 1;
        that.resetFeed();
        that.getPostsFromApi();
        _gaq.push(['_trackEvent', 'Feedfilter', 'Changed to Trending']);
    });

    $('#filterPopular').on('click', function(e) {
        $('.sort-option').removeClass('filter-select');
        $(this).addClass('filter-select');
        e.preventDefault();
        that.setFilter = null;
        that.setOrder = 'total_likes';
        that.like_day_threshold = 30;
        that.resetFeed();
        that.getPostsFromApi();
        _gaq.push(['_trackEvent', 'Feedfilter', 'Changed to Popular']);
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
            _gaq.push(['_trackEvent', 'Feedfilter', 'Changed to Following']);
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

    var $userBar = $('<div class="userBar"><div class="tpVoteCity"></div><a href="/'+post.username+'" class="dahliaHead" data-id="'+post.user_id+'">'+post.username+'</a></div>');
    var $counts = $('<ul></ul>').appendTo($userBar).on('click', function() {
        $post.find('.voteDot').click();
    });
    var $heartBG = $('<li class="loveHeart" style="background-position: '+(Number(post.is_liked) ? 1 : '-'+21)+'px;"></li>').appendTo($counts);
    var $heartCount = $('<li class="loveCount">'+post.total_likes+'</li>').appendTo($counts);
    $post.append($userBar);

    var video = ( post.image_url.split('.').pop() === 'mp4' );

    if(this.isSpineMode) {
        var img_url = post.image_url+'&height='+postDims[index % 16][1];

        if(video) {
            var $img = $('<img src="'+img_url+'&height='+postDims[index % 16][1]+'">');
            var $img = $('<video autoplay loop muted height="'+postDims[index % 16][1]+'" preload="auto"><source src="'+img_url+'" type="video/mp4" /></video>');
        } else {
            var $img = $('<img src="'+img_url+'&height='+postDims[index % 16][1]+'">');
        }

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

        if(this.isSearchSet) {
            dahliawolf.search.searchAll(this.url, function(data) {
                console.log(data);
                dahliawolf.loader.hide();
                that.isApiAvailable = true;
                if(data.data.search_all.products.data.get_products.data.length || !data.data.search_all.posts.error || data.data.search_all.users.length) {
                    var tempArray = new Array();

                    if(data.data.search_all.products && data.data.search_all.products.data.get_products.data && data.data.search_all.products.data.get_products.data.length) {// LOAD PRODUCTS
                        var $prodBucket = $('<div id="productResults"></div>').css('width', data.data.search_all.products.data.get_products.data.length*330).prependTo(that.$bucket).wrap('<div class="resWrap"></div>');
                        $.each(data.data.search_all.products.data.get_products.data, function(x, prod) {
                            $prodBucket.append(new dahliawolf.$product(prod));
                        });
                        $('<h1>Products</h1>').prependTo(that.$bucket);
                    }

                    if(data.data.search_all.posts.posts && data.data.search_all.posts.posts.length) {
                        $($('.GridCol0')).before('<h1>Posts</h1>');
                        $.each(data.data.search_all.posts.posts, function(x, post) {
                            that.addPostData(post);
                            tempArray.push(post.posting_id);
                        });
                        that.addToBucket(tempArray);
                    }

                    if(data.data.search_all.users && data.data.search_all.users.length) {
                        var $title = $('<h1>Members</h1>').prependTo(that.$bucket);
                        var $membersSection = $('<div id="memberResults"></div>');
                        var rowHt = 165;

                        $($title).after($membersSection);
                        $.each(data.data.search_all.users, function(x, user) {
                            var $userRes = $('<div class="userSearchRes"></div>').append(new dahliawolf.$hoverAvatar(user)).append('<div class="username"><a href="/'+user.username+'">'+user.username+'</a></div>');
                            $membersSection.append($userRes);
                        });
                        if(data.data.search_all.users.length > 5) {
                            var $loadMore = $('<div class="loadMore">SHOW MORE</div>').on('click', function() {
                                if(Number($membersSection.css('max-height').replace(/[^-\d\.]/g, '')) <  rowHt+100) {
                                    $membersSection.css('max-height', (Math.ceil((data.data.search_all.users.length/5)*rowHt)+rowHt) );
                                    $loadMore.html('HIDE');
                                } else {
                                    $membersSection.css('max-height', 185);
                                    $loadMore.html('SHOW MORE');
                                }

                            });
                            $membersSection.after($loadMore);
                        }
                    }
                } else {
                    $('<h1>No results for '+that.search+'</h1>').prependTo(that.$bucket);
                }
                that.unbindScroll();
            });
        } else {
            dahliawolf.post.get(this.url, function(data){
                var tempArray = new Array();
                that.isApiAvailable = true;
                dahliawolf.loader.hide();

                that.offset += data.data.get_all.posts.length;

                if(data.data.get_all && data.data.get_all.posts.length) {
                    $.each(data.data.get_all.posts, function(index, post) {
                        that.addPostData(post);
                        tempArray.push(post.posting_id);
                    });
                    that.addToBucket(tempArray);
                } else {
                    that.unbindScroll();
                }
            });
        }
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
    $(window).unbind('scroll', this.scrollFunct);
    $(window).on('scroll touchmove', this.scrollFunct);
}

voteFeed.prototype.scrollFunct = function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 800) {
        dahliawolfFeed.getPostsFromApi();
    }
}

voteFeed.prototype.unbindScroll = function() {
    $(window).unbind('scroll', this.scrollFunct);
}

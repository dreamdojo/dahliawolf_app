<?
    $pageTitle = "Vote";
    include "head.php";
    include "header.php";
?>
<style>
    #voteBucket{width: 1000px; margin: 0px auto;padding-bottom: 200px;}
    #voteBucket .gridMode{max-width: 300px; overflow: hidden; float: left; margin: 16px 2px;}
    #voteBucket .userBar{bottom: 0;background-color: #c2c2c2;opacity: .9; top: auto;position: absolute; width: 100%; z-index: 1;}
    #voteBucket .spineMode{margin: 10px;}
    .spineMode  .post .innerwrap{position: relative;}
    .spineMode  .post .innerwrap img{position: absolute; min-height: 100%; min-width: 100% !important; width: auto !important;}
    #voteBucket .post{position: relative;}
    #voteBucket .post a{float: left;}
    #voteBucket .post:hover .shareBall{display: block;}
    #voteBucket .post:hover .voteDot{display: block;}
    #voteBucket .post img{width: 100%; min-width: 300px;}
    #voteBucket .lefty{width: 50%; float: left;}
    #voteBucket .righty{width: 50%; float: left;}
    #voteBucket .lefty .post{float: right;}
    #voteBucket .righty .post{float: left;}
    #voteBucket .userBar a{font-size: 14px;color: #fff;line-height: 24px;text-indent: 9px;font-family: futura;font-size: 13px;}
    #voteBucket .innerwrap{max-height: 600px; overflow: hidden;}
    #voteBucket .gCol{float: left; width: 33%; height: 100%;}
    #voteBucket .userBar ul{float: right; height: 100%;margin-right: 3px; cursor: pointer;}
    #voteBucket .userBar li{float: right;}
    #voteBucket .loveCount{font-size: 13px;line-height: 22px;margin-right: 1px; font-family: futura; color: #fff;}
    #voteBucket .loveHeart{background-image: url("/images/hearts_BG.png");background-size: auto 91%;z-index: 1;width: 22px;height: 23px;background-repeat: no-repeat;overflow: hidden;}

    .voteDot{position: absolute;width: 125px;height: 125px;margin-left: -75px;left: 50%;top: 50%;margin-top: -75px;
        border-radius: 75px;text-align: center;line-height: 113px;font-size: 21px; cursor: pointer; display: none; color: #fff;
        transition: all .2s; -webkit-transition: all .2s; opacity: .8;z-index: 1; font-family: futura;}
    .voteDot:hover{opacity: 1;}
    #voteBucket .unloved{background-color: #000;}
    #voteBucket .loved{background-color: #ff2e6e;}
    .voteDot div{line-height: 125px;}
</style>

<?php include "blocks/filter.php"; ?>

<div id="voteBucket"></div>
<?php include "footer.php" ?>

<script>
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
         if(this.isFilterSet) {
             config.order_by = 'total_likes';
             config.like_day_threshold = this.like_day_threshold;
         }
         return config;
     },
     get isGridMode() {return this.feedMode === 'grid'},
     get isSpineMode() {return this.feedMode === 'spine'},
     get theFeedMode() {return this.feedMode;},
     get randomWidth() {return Math.random() * (450 - 260) + 260;},
     get isFilterSet() {return (this.filter ? true : false);},
     get getFilter() {return this.filter;},

     set setFeedMode(mode) {this.feedMode = mode;},
     set setFilter(filter) {this.filter = filter;}
 }

 voteFeed.prototype.bindButtons = function() {
     var that = this;

     $('#filterTrending').on('click', function(e) {
         e.preventDefault();
         if(!that.isFilterSet && that.getFilter !== 'hot') {
             that.setFilter = 'hot';
             that.like_day_threshold = 7;
             that.resetFeed();
             that.getPostsFromApi();
         }
     })

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

 $(function() {
     dahliawolfFeed = new voteFeed({mode:'grid' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
 });
</script>

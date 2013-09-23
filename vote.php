<?
    $pageTitle = "Vote";
    include "head.php";
    include "header.php";
?>
<style>
    #voteBucket{width: 1000px; margin: 0px auto;padding-bottom: 200px;}
    #voteBucket .gridMode{max-width: 300px; overflow: hidden; float: left; margin: 16px 2px;}
    #voteBucket .spineMode{border-width: 20px 20px 25px;border-color: rgb(173, 173, 173); border-style: solid;margin-top: 4px;}
    .spineMode  .post .innerwrap{position: relative;}
    .spineMode  .post .innerwrap img{position: absolute; min-height: 100%; min-width: 100% !important; width: auto !important;}
    #voteBucket .post{position: relative;}
    #voteBucket .post a{float: left;}
    #voteBucket .post:hover .shareBall{display: block;}
    #voteBucket .post:hover .voteDot{display: block;}
    #voteBucket .post img{width: 100%; min-width: 300px;}
    #voteBucket .lefty{width: 50%; float: left;}
    #voteBucket .righty{width: 50%; float: left;}
    #voteBucket .lefty .post{float: right; margin-right: 2px;}
    #voteBucket .righty .post{float: left; margin-left: 2px;}
    #voteBucket .userBar{position: absolute; width: 100%;top: 100%;}
    #voteBucket .innerwrap{max-height: 600px; overflow: hidden;}
    #voteBucket .gCol{float: left; width: 33%; height: 100%;}

    .voteDot{position: absolute;width: 125px;height: 125px;margin-left: -75px;left: 50%;top: 50%;margin-top: -75px;
        border-radius: 75px;text-align: center;line-height: 113px;font-size: 21px; cursor: pointer; display: none; color: #fff;
        transition: all .2s; -webkit-transition: all .2s; opacity: .8;}
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
     this.limit = 16;
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
         var URL = '/action/getFeedGrid.php?limit='+this.limit+'&offset='+this.offset;
         URL += (dahliawolf.isLoggedIn ? '&viewer_user_id='+dahliawolf.userId : '');
         URL += (this.isFilterSet ? '&sort='+this.getFilter : '');
         //URL += SORT;
         return URL;
     },
     get isGridMode() {return this.feedMode === 'grid'},
     get isSpineMode() {return this.feedMode === 'spine'},
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
             that.$bucket.empty();
             that.offset = 0;
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
     $post.append(new voteDot(post));
     if(this.isSpineMode) {
         var img_url = post.image_url+'&height='+postDims[index % 16][1];
         var $img = $('<img src="'+img_url+'&height='+postDims[index % 16][1]+'">');
         if(Number(post.width) > Number(post.height)) {
             $img.css('margin-left', '-'+((Number(post.width) - postDims[index % 16][0]) / 2)+'px');
         }
         $img.appendTo($post);
         $img.wrap('<div class="innerwrap" style="width:'+postDims[index % 16][0]+'px; height:'+postDims[index % 16][1]+'px"></div>');
         $post.append('<div class="userBar"><a href="/'+post.username+'" class="dahliaHead" data-id="'+post.user_id+'">'+post.username+'-'+index+'</a></div>');
     } else {
         var img_url = post.image_url+'&width=400';
         var $img = $('<img src="'+img_url+'">').appendTo($post);
         $img.wrap('<div class="innerwrap"></div>');
         $post.append('<div class="userBar"><a href="/'+post.username+'" class="dahliaHead" data-id="'+post.user_id+'">'+post.username+'-'+index+'</a></div>');
     }
     $img.wrap('<a href="/post-details?posting_id='+post.posting_id+'" class="image color-'+(Math.floor(Math.random() * (6 - 1) + 1))+'" rel="modal"></a>');

     return $post;
 }

 voteFeed.prototype.getPostsFromApi = function() {
     var that = this;

     if(this.isApiAvailable) {
         this.isApiAvailable = false;
         dahliawolf.loader.show();
         $.getJSON(this.url, function(data){
             var tempArray = new Array();
             that.isApiAvailable = true;
             dahliawolf.loader.hide();
             that.offset += data.length;

             $.each(data, function(index, post) {
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
     dahliawolfFeed = new voteFeed({mode:'spine' <? !empty($_GET['sort']) ? ', filter: "'.$_GET['sort'].'"' : '' ?> <? !empty($_GET['q']) ? ', search: "'.$_GET['q'].'"' : '' ?>});
 });
</script>

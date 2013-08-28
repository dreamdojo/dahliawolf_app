<?
    $pageTitle = "Inspire";
    if( !isset($_GET['get_started']) ) {
        include "head.php";
        include "header.php";
    }
?>
<style>
    #bankBucket{width: 100%;max-width: 960px; margin: 0px auto; height: 100%;padding-top: 57px;}
    #bankBucket .postFrame{overflow: hidden; position: relative;}
    #bankBucket .postFrame:hover .option{display: block;}
    #bankBucket .grid{float: left; width: 300px;height: 300px; margin: 10px;}
    #bankBucket .line{width: 80%; margin: 10px auto;overflow: hidden;margin-bottom: 10px;margin-top: 10px; max-width: 500px;}
    #bankBucket .postFrame img{width: 100%;}
    #bankBucket .postButton{position: absolute;right: 10px;background-color: #fff;border-radius: 51px;width: 70px;height: 70px;text-align: center;line-height: 70px;margin-top: 10px;font-size: 18px; cursor: pointer;border: #c2c2c2 thin solid;}
    #bankBucket .postButton:hover{opacity: .7;}
    .option{display: none;}
    #bankOptions{display: block; position: fixed; background-color: #fff;}
    #viewToggle{background-image: url("/images/views.png");background-position: 100%;background-size: 180%;position: absolute;right: -18px;margin-top: 5px;width: 40px;background-repeat: no-repeat;overflow: hidden;}
    .title-roll{background-color: #e4e2e3;padding: 12px;font-size: 22px;width: 100%;max-width: 920px;z-index: 1;font-weight: bold;margin: 0px auto;top: 70px;margin-bottom: 10px;position: relative;text-align: center;}

</style>
<div id="bankOptions" class="drop-shadow" <?= isset($_GET['get_started']) ? 'style="display:none"' : '' ?>>
    <div id="bankCenter">
        <div class="bankSection">
            <img class="fork-img" id="uploadButton" src="/images/select-files.png" style="float: right;" />
            <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="imgUpload.submitImage(this.files[0]);">
        </div>
        <div class="bankSection">
            <div id="dndeezy">
                <p>Drag n Drop File Here</p>
            </div>
        </div>
        <div id="importFromPinterest" class="bankSection cursor">
            <div id="getPinterestName">
                <input type="text" placeholder="Enter Pinterest Name Here" id="thePinterestName" /><div id="goPinterestButton"></div>
            </div>
            <img src="/images/bank-pinterest.png">
            <p>Select Images From Your Pinterest</p>
        </div>
        <div id="importFromInstagram" class="bankSection no-right-border cursor">
            <img src="/images/bank-instagram.png">
            <p>Select Images From Your Instagram</p>
        </div>
    </div>
    <div id="viewToggle"></div>
</div>

<div class="title-roll"><div id="inspireBackButton" class="hidden"></div><span id="postTitleContent">Post from the DAHLIA WOLF IMAGE BANK</span></div>
<div id="bankBucket"></div>

<?php include "footer.php" ?>


<script>
    postBank = new Object();
    postBank.$bucket = $('#bankBucket');
    postBank.posts = [];
    postBank.offset = 0;
    postBank.limit = 12;
    postBank.isRefillAvailable = true;
    postBank.mode = 'grid';

    postBank.init = function() {
        postBank.bindScroll();
        postBank.getImages();
        $('#importFromPinterest').on('click', postBank.getImagesFromPinterest);
        $('#importFromInstagram').on('click', postBank.getImagesFromInstagram);
        $('#getPinterestName input').on('keydown', postBank.setPinterestName);
        postBank.adjustMargins();
        $(window).resize(postBank.adjustMargins);
        $('#viewToggle').on('click', this.toggleMode);
    }

    postBank.clearBank = function() {
        postBank.posts = [];
        postBank.$bucket.empty();
        if(postBank.ajaxCall) {
            postBank.ajaxCall.abort();
        }
    }

    postBank.adjustMargins = function() {
        if(window.innerWidth > 320*3) {
            postBank.$bucket.width(320*3).css('margin', 0+'px auto');
        }else {
            postBank.$bucket.css('margin-left', (window.innerWidth % 320)/2).css('width', 'auto');
        }
    }

    postBank.toggleMode = function() {
        if(postBank.mode == 'grid') {
            postBank.mode = 'line';
            $(this).css('background-position', 0);
            $.each($('#bankBucket .grid'), function(index, post){
                $(post).removeClass('grid').addClass('line');
            });
        } else {
            postBank.mode = 'grid';
            $(this).css('background-position', 100+'%');
            $.each($('#bankBucket .line'), function(index, post){
                $(post).removeClass('line').addClass('grid');
            });
        }
    }

    postBank.bindScroll = function() {
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                postBank.getImages();
            }
        });
    }

    postBank.getImages = function() {
        var _this = this;
        if(postBank.isRefillAvailable) {
            dahliaLoader.show();
            postBank.isRefillAvailable = false;
            api.getBankPosts(this.offset, this.limit, function(data) {
                dahliaLoader.hide();
                postBank.isRefillAvailable = true;
                $.each(data.data, function(index, post) {
                    postBank.posts.push(new bankPost(post));
                });
            });
        }
    }

    postBank.getImagesFromInstagram = function() {
        if(userConfig.instagramToken) {
            postBank.clearBank();
            $(window).unbind('scroll');
            dahliaLoader.show();
            postBank.ajaxCall = $.ajax('https://api.instagram.com/v1/users/self/media/recent?access_token='+userConfig.instagramToken+'&callback=callbackFunction', {dataType:'jsonp'}).done(function(data) {
                postBank.ajaxCall = null;
                dahliaLoader.hide();
                $.each(data.data, function(index, img){
                    postBank.posts.push( new foreignPost(img.images.standard_resolution.url, 'Instagram') );
                });
            });
        } else {
            window.open(
                "https://api.instagram.com/oauth/authorize/?client_id=65e8ae62e2af4d118bf0f8b2227381f1&redirect_uri=http://www.dahliawolf.com/instagramConnect&response_type=token",
                'Log into Instagram',
                'width=500, height=500'
            );
        }
    }

    postBank.getImagesFromPinterest = function() {
        if(userConfig.pinterest_username) {
            postBank.clearBank();
            $(window).unbind('scroll');
            dahliaLoader.show();
            postBank.ajaxCall = $.post('/get_feed_from_pinterest', {pinterest_user : userConfig.pinterest_username }, function(data) {
                postBank.ajaxCall = null;
                dahliaLoader.hide();
                if(data.data) {
                    $.each(data.data, function(index, img){
                        postBank.posts.push( new foreignPost(img.images.standard_resolution.url, 'Pinterest') );
                    });
                } else {
                    alert('no posts found for user');
                }
            });
        } else if( parseInt( $('#getPinterestName').css('left') ) < 0 ) {
            $('#getPinterestName').animate({left:0}, 100);
        }
    }
    postBank.setPinterestName = function(e) {
        if(e.keyCode==13){
            var name = $('#getPinterestName input').val();
            if(name && name !== '') {
                userConfig.pinterest_username = name;
                postBank.getImagesFromPinterest();
            } else {
                alert('Invalid Username');
            }
        }
    }

    //POST SECTION

    $(function() {
        postBank.init();
    });

    function bankPost(data) {
        this.data = data;

        this.$post = $('<div class="postFrame '+postBank.mode+'"></div>');
        this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
        this.$image = $('<img src="'+this.data.source+this.data.imageURL+'">').appendTo(this.$post);
        this.$post.appendTo(postBank.$bucket);

        return this;
    }

    bankPost.prototype.post = function() {
        var description = '';
        this.$button.hide();
        this.$post.find('img').css('opacity', .6);

        if(theUser.id) {
            if(this.data.id) {
                $.post('/action/post_feed_image.php', { id: this.data.id, description: description}, $.proxy(this.addAfterPostMessage, this) )
            }
        } else {
            new_loginscreen();
        }
    }

    bankPost.prototype.addAfterPostMessage = function(data) {
        var str = '<div class="postPostingWrap"><div class="bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>';
        str += '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+theUser.username+'">profile</a><p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')">';
        str += '<img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>';

        this.$post.append(str);
    }

    function foreignPost(url, domain) {
        this.url = url;
        this.domain = domain;

        this.$post = $('<div class="postFrame '+postBank.mode+'"></div>');
        this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
        this.$image = $('<img src="'+this.url+'">').appendTo(this.$post);
        this.$post.appendTo(postBank.$bucket);

        return this;
    }

    foreignPost.prototype.post = function() {
        if(this.url) {
            this.$button.remove();
            this.$post.find('img').css('opacity', .6);
            if(theUser.id) {
                $.post('/action/uploadPost.php', {image_src : this.url, description: 'WOW', domain : this.domain, sourceurl : this.url}, $.proxy(this.addAfterPostMessage, this));
            } else {
                new_loginscreen();
            }
        }
    }

    foreignPost.prototype.addAfterPostMessage = function(data) {
        var data = $.parseJSON(data);
        data = data.data;
        var str = '<div class="postPostingWrap"><div class="bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>';
        str += '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+theUser.username+'">profile</a><p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')">';
        str += '<img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>';

        this.$post.append(str);
    }

</script>
<?
    $pageTitle = "Inspire";
    include "head.php";
    include "header.php";
?>
<style>
    #bankBucket{width: 100%;max-width: 960px; margin: 0px auto; height: 100%;padding-top: 57px;}
    #bankBucket .postFrame{overflow: hidden; position: relative;}
    #bankBucket .postFrame:hover .option{display: block;}
    #bankBucket .grid{float: left; width: 300px;height: 300px; margin: 10px;}
    #bankBucket .postFrame img{width: 100%;}
    #bankBucket .postButton{position: absolute;right: 10px;background-color: #fff;border-radius: 51px;width: 70px;height: 70px;text-align: center;line-height: 70px;margin-top: 10px;font-size: 18px; cursor: pointer;border: #c2c2c2 thin solid;}
    #bankBucket .postButton:hover{opacity: .7;}
    .option{display: none;}
    #bankOptions{display: block; position: fixed; background-color: #fff;}

</style>
<div id="bankOptions" class="drop-shadow">
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
</div>

<div id="bankBucket"></div>

<?php include "footer.php" ?>


<script>
    postBank = new Object();
    postBank.$bucket = $('#bankBucket');
    postBank.posts = [];
    postBank.offset = 0;
    postBank.limit = 12;
    postBank.isRefillAvailable = true;

    postBank.init = function() {
        postBank.bindScroll();
        postBank.getImages();
        $('#importFromPinterest').on('click', postBank.getImagesFromPinterest);
        $('#importFromInstagram').on('click', postBank.getImagesFromInstagram);
        $('#getPinterestName input').on('keydown', postBank.setPinterestName);
    }

    postBank.clearBank = function() {
        postBank.posts = [];
        postBank.$bucket.empty();
        if(postBank.ajaxCall) {
            postBank.ajaxCall.abort();
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
            postBank.isRefillAvailable = false;
            api.getBankPosts(this.offset, this.limit, function(data) {
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
            postBank.ajaxCall = $.ajax('https://api.instagram.com/v1/users/self/media/recent?access_token='+userConfig.instagramToken+'&callback=callbackFunction', {dataType:'jsonp'}).done(function(data) {
                postBank.ajaxCall = null;
                    $.each(data.data, function(index, img){
                    postBank.posts.push( new foreignPost(img.images.standard_resolution.url) );
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
            postBank.ajaxCall = $.post('/get_feed_from_pinterest', {pinterest_user : userConfig.pinterest_username }, function(data) {
                postBank.ajaxCall = null;
                if(data.data) {
                    $.each(data.data, function(index, img){
                        postBank.posts.push( new foreignPost(img.images.standard_resolution.url) );
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

        this.$post = $('<div class="postFrame grid"></div>');
        this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
        this.$image = $('<img src="'+this.data.source+this.data.imageURL+'">').appendTo(this.$post);
        this.$post.appendTo(postBank.$bucket);

        return this;
    }

    bankPost.prototype.post = function() {
        this.$button.remove();
        this.$post.css('opacity', .6);
    }

    bankPost.prototype.addAfterPostMessage = function() {
        this.$post.append('');
    }

    function foreignPost(url) {
        this.url = url;

        this.$post = $('<div class="postFrame grid"></div>');
        this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
        this.$image = $('<img src="'+this.url+'">').appendTo(this.$post);
        this.$post.appendTo(postBank.$bucket);

        return this;
    }

    foreignPost.prototype.post = function() {
        /*$.post('/action/uploadPost.php', {image_src : imageUrl, description: 'pinterest', domain:img_domain, sourceurl : img_attribution_url}).done(function(data){
            data = $.parseJSON(data);*/
        this.$button.remove();
        this.$post.css('opacity', .6);
    }
</script>
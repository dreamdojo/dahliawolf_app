<?
    $pageTitle = "Inspire";
    if( !isset($_GET['get_started']) ) {
        include "head.php";
        include "header.php";
    }
?>
<style>
    #bankOptions{height:60px; width:100%; display:none; overflow:hidden;position: relative;z-index: 100;margin-top: 0px;border-bottom: #b6b6b6 1px solid;}
    #bankCenter{height:60px; max-width: 1100px;width: 100%; margin:0px auto;}
    #bankCenter .bankSection{ width:24%; height:81%; float:left; border-right:#b6b6b6 1px solid;padding-top: 11px; color:rgb(104, 104, 104);}
    #bankCenter .bankSection:hover{background-color:#ebebeb;}
    .no-right-border{border-right:none !important;}
    .bankSection p{font-size: 13px;margin-top: 9px;margin-left: 10px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
    .bankSection img{float: left;margin-left: 10px;margin-right: 10px;}
    #dndeezy{border: #777777 2px dotted;width: 80%;margin-left: 10%;border-radius: 8px;text-align: center;margin-top: -4px;min-height: 80%;}
    #getPinterestName{ position:absolute; left:-100%; height:100%; width:100%;background-color: #fff;top: 0px;}
    #importFromPinterest{ position:relative; overflow:hidden;}
    #thePinterestName{height: 75%;margin-top: 2%;margin-left: 2%;width: 75%;font-size: 14px;text-indent: 3px; float:left;}
    #goPinterestButton{ height:100%; width:20%; float:left; background-image:url(/images/pinterestGo.png); background-size: 86% 80%;background-repeat: no-repeat;background-position: 7%;}

    #bankBucket{width: 100%;max-width: 960px; margin: 0px auto; height: 100%;padding-top: 57px; padding-bottom: 100px;}
    #bankBucket .postFrame{overflow: hidden; position: relative;}
    #bankBucket .postFrame:hover .option{display: block;}
    #bankBucket .grid{float: left; width: 300px;height: 300px; margin: 10px;}
    #bankBucket .line{width: 80%; margin: 10px auto;overflow: hidden;margin-bottom: 10px;margin-top: 10px; max-width: 500px;}
    #bankBucket .postFrame img{width: 100%;}
    #bankBucket .postButton{position: absolute;right: 10px;background-color: #000;width: 70px;height: 30px;text-align: center;line-height: 30px;margin-top: 10px;font-size: 15px;cursor: pointer;border: #c2c2c2 thin solid;font-family: futura;font-weight: bolder;color: #fff;}
    #bankBucket .postButton:hover{opacity: .7;}
    .option{display: none;}
    #bankOptions{display: block; position: fixed; background-color: #fff;}
    #viewToggle{background-image: url("/images/inspireToggle_BG.png");background-position: 0%;position: absolute;right: -11px;width: 45px;background-repeat: no-repeat;overflow: hidden; height: 30px;margin-right: 20px;top: 2px; cursor: pointer;}
    .title-roll{border:#c2c2c2 thin solid; font-size: 22px;width: 97%; max-width: 940px;z-index: 1;font-weight: bold;margin: 0px auto; top: 77px; margin-bottom: 10px;position: relative;text-align: center; height: 35px; background-color: #fff;}
    .xDomainStatus{position: absolute;height: 100%;width: 100%;background-color: #c2c2c2;z-index: 111;top: 0px;left: 0px;}
    .xDomainStatus p{width: 1000px;margin: 0px auto;font-size: 27px;text-align: center;line-height: 60px;}
    #postTitleContent{font-size:15px; line-height: 35px;}
</style>


<div id="bankOptions" class="drop-shadow" <?= isset($_GET['get_started']) ? 'style="display:none"' : '' ?>>
    <div id="bankCenter">
        <div class="bankSection">
            <img class="fork-img" id="uploadButton" src="/images/select-files.png" style="float: right;" />
            <form id="postUploadForm" action="/action/post_image.php" method="post" enctype="multipart/form-data">
                <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="imgUpload.submitImage(this.files[0]);">
                <input type="hidden" name="takeMeBack" value="takemehome">
            </form>
        </div>
        <div class="bankSection">
            <div id="dndeezy" ondrop="drop(event)" ondragover="allowDrop(event)" ondragleave="disallowDrop(event)">
                <p>Drag n Drop File Here</p>
            </div>
        </div>
        <div id="importFromPinterest" class="bankSection cursor">
            <img src="/images/tumblr_logo.png" style="width: 31px;">
            <p>Select Images From Your Tumblr</p>
        </div>
        <div id="importFromInstagram" class="bankSection no-right-border cursor">
            <img src="/images/bank-instagram.png">
            <p>Select Images From Your Instagram</p>
        </div>
    </div>
</div>

<div class="title-roll"><div id="inspireBackButton" class="hidden"></div><span id="postTitleContent"><span class="preHeader">Post from the</span> DAHLIA WOLF IMAGE BANK</span><div id="viewToggle"></div></div>
<div id="bankBucket"></div>

<?php include "footer.php" ?>


<script>
    postBank = new Object();
    postBank.$bucket = $('#bankBucket');
    postBank.$dropBox = $('#dndeezy');
    postBank.$bankOptions = $('#bankOptions');
    postBank.posts = [];
    postBank.offset = 0;
    postBank.limit = 12;
    postBank.isRefillAvailable = true;
    postBank.mode = 'grid';

    postBank.init = function() {
        postBank.bindScroll();
        postBank.getImages();
        $('#importFromPinterest').on('click', postBank.getImagesFromTumblr);
        $('#importFromInstagram').on('click', postBank.getImagesFromInstagram);
        //$('#getPinterestName input').on('keydown', postBank.setPinterestName);
        postBank.adjustMargins();
        $(window).resize(postBank.adjustMargins);
        $('#viewToggle').on('click', this.toggleMode);
    }

    function drag(ev)
    {
        postBank.$draggedItem = $(ev.target).parent();
    }

    function allowDrop(ev) {
        ev.preventDefault();
        $(ev.target).css('border-color', 'blue');
    }
    function disallowDrop(ev) {
        ev.preventDefault();
        $(ev.target).css('border-color', 'black');
    }

    function drop(ev) {
        ev.preventDefault();
        if(postBank.$draggedItem) {
            postBank.$draggedItem.find('.postButton').click();
            postBank.$draggedItem = null;
        } else {
            var url = ev.dataTransfer.getData('URL');
            var domain = url.split('/')[2];

            if(theUser.id && url) {
                postBank.url = url;
                postBank.$bank = $('<div class="xDomainStatus"></div>').appendTo(postBank.$bankOptions);
                postBank.$bankMsg = $('<p>Uploading...</p>').appendTo(postBank.$bank);
                $.post('/action/uploadPost.php', {image_src : url, description: 'WOW', domain : domain, sourceurl : this.url}, postBank.crossBrowserUpload);
            } else {
                new_loginscreen();
            }
        }
    }
    postBank.crossBrowserUpload = function(data) {
        var data = $.parseJSON(data);

        if(!data.error) {
            data = data.data;
            postBank.$bank.css({'background-color': '#ff787d', 'color' : '#fff'});
            postBank.$bankMsg.html('Upload Successful!');
            sendToAnal({name:'Uploaded Image', type:'x-browser'});
            var str = '<div class="postFrame grid" draggable="true" ondragstart="drag(event);"><div class="postButton" style="display: none;">POST</div>';
            str+= '<img src="'+postBank.url+'" style="opacity: 0.6;"><div class="postPostingWrap"><div class="bankPosted">' +
                '<p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>' +
                '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+dahliawolf.username+'">profile</a>' +
                '<p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a>' +
                '<a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#">' +
                '<img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div></div>';
            postBank.$bucket.prepend(str);
        } else {
            postBank.$bank.css('background-color', '#666666');
            postBank.$bankMsg.html('Upload Failed.'+data.error);
            sendToAnal({name:'Error:Uploaded Image', type:'x-browser', error:data.error})
        }

        setTimeout(function() {
            postBank.$bank.fadeOut(200, function() {
                $(this).remove();
            });
        }, 3000);
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
        var lineWidths = [500, 300, 400];

        if(postBank.mode == 'grid') {
            postBank.mode = 'line';
            $(this).css('background-position', '-'+49+'px');
            $.each($('#bankBucket .grid'), function(index, post){
                $(post).removeClass('grid').addClass('line').width(lineWidths[index%3]);
            });
        } else {
            postBank.mode = 'grid';
            $(this).css('background-position', 0+'px');
            $.each($('#bankBucket .line'), function(index, post){
                $(post).removeClass('line').addClass('grid').width(300);
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
            dahliawolf.loader.show()
            postBank.isRefillAvailable = false;
            api.getBankPosts(this.offset, this.limit, function(data) {
                dahliawolf.loader.hide()
                postBank.isRefillAvailable = true;
                $.each(data.data, function(index, post) {
                    postBank.posts.push(new bankPost(post, (postBank.mode == 'line' ? index : '') ));
                });
                postBank.$bucket.append('<div style="clear:left"></div>');
            });
        }
    }

    postBank.getImagesFromInstagram = function() {
        if(userConfig.instagramToken) {
            postBank.clearBank();
            $(window).unbind('scroll');
            dahliawolf.loader.show()
            postBank.ajaxCall = $.ajax('https://api.instagram.com/v1/users/self/media/recent?access_token='+userConfig.instagramToken+'&callback=callbackFunction', {dataType:'jsonp'}).done(function(data) {
                postBank.ajaxCall = null;
                dahliawolf.loader.hide()
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
    postBank.getImagesFromTumblr = function() {
        if(dahliawolf.areYouLoggedIntoTumblr) {
            dahliawolf.loader.show();
            postBank.clearBank();
            $(window).unbind('scroll');
            $.getJSON('/lib/TumblrOAuth/getPosts', function(data) {
                holla.log(data);
                postBank.ajaxCall = null;
                dahliawolf.loader.hide();
                $.each(data.response.posts, function(index, post) {
                    $.each(post.photos, function(index, photo) {
                        postBank.posts.push( new foreignPost(photo.alt_sizes[0].url, 'Tumblr') );
                    });
                });
            });
        } else {
            dahliawolf.logIntoTumblr(postBank.getImagesFromTumblr);
        }
    }

    postBank.getImagesFromPinterest = function() {
        if(userConfig.pinterest_username) {
            postBank.clearBank();
            $(window).unbind('scroll');
            dahliawolf.loader.show();
            postBank.ajaxCall = $.post('/get_feed_from_pinterest', {pinterest_user : userConfig.pinterest_username }, function(data) {
                console.log(data);
                postBank.ajaxCall = null;
                dahliawolf.loader.hide();
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

    function bankPost(data, index) {
        this.data = data;
        var widths = [500, 300, 400];

        this.$post = $('<div class="postFrame '+postBank.mode+'" draggable="true" ondragstart="drag(event);" '+(index != '' ? 'style="width:'+widths[index%widths.length]+'px;"' : '')+'></div>');
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
                $.post('/action/post_feed_image.php', { id: this.data.id, description: description}, $.proxy(this.addAfterPostMessage, this) );
                sendToAnal({name:'Uploaded Image', type:'dahliawolf feed'});
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
        this.$post.append(new shareBall(data));
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
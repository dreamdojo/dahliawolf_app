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
    #bankBucket .postFrame{overflow: hidden; position: relative;background-size: auto 100%;background-position: 50%;background-repeat: no-repeat;}
    #bankBucket .postFrame:hover .postButton{display: block;}
    #bankBucket .grid{float: left; width: 300px;height: 300px; margin: 10px;}
    #bankBucket .line{width: 80%; margin: 10px auto;overflow: hidden;margin-bottom: 10px;margin-top: 10px; max-width: 500px;}
    #bankBucket .postFrame img{width: 100%;}
    #bankBucket .postButton{position: absolute; display:none; right: 50%;top: 50%;background-color: #353535; width: 90px;height: 90px;border-radius: 50px;text-align: center;line-height: 90px;margin-top: -45px;margin-right: -45px;font-size: 15px;cursor: pointer;font-family: futura;font-weight: bolder;color: #fff;}
    #bankBucket .postButton:hover{opacity: .7;}
    #bankBucket h2{text-align: center;width: 80%;margin: 30px auto;}
    #bankBucket .postSource{position: absolute;bottom: 0px;width: 100%;text-align: center;font-size: 12px;height: 25px;line-height: 25px;background-color: #fff;opacity: .7;color: #000;}
    .option{display: none;}
    #bankOptions{display: block; position: fixed; background-color: #fff;}
    #viewToggle{background-image: url("/images/inspireToggle_BG.png");background-position: 0%;position: absolute;right: -11px;width: 45px;background-repeat: no-repeat;overflow: hidden; height: 30px;margin-right: 20px;top: 2px; cursor: pointer;}
    .title-roll{border:#c2c2c2 thin solid; font-size: 22px;width: 97%; max-width: 940px;z-index: 1;font-weight: bold;margin: 0px auto; top: 77px; margin-bottom: 10px;position: relative;text-align: center; height: 35px; background-color: #fff;}
    .xDomainStatus{position: absolute;height: 100%;width: 100%;background-color: #c2c2c2;z-index: 111;top: 0px;left: 0px;}
    .xDomainStatus p{width: 1000px;margin: 0px auto;font-size: 27px;text-align: center;line-height: 60px;}
    #postTitleContent{font-size:15px; line-height: 35px;}

    .postFrame .progressCount{font-size: 20px; color: red;line-height: 150px; text-align: center; width: 100%;}
    .loading{background-size: 70% auto !important;}
</style>


<div id="bankOptions" class="drop-shadow" <?= isset($_GET['get_started']) ? 'style="display:none"' : '' ?>>
    <div id="bankCenter">
        <div class="bankSection">
            <img class="fork-img" id="uploadButton" src="/images/select-files.png" style="float: right;" />
            <form id="postUploadForm" action="/action/post_image.php" method="post" enctype="multipart/form-data">
                <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="new postUpload(this.files[0]);">
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

<div class="title-roll"><div id="inspireBackButton" class="hidden"></div><span id="postTitleContent"><span class="preHeader">DAHLIA\WOLF BANK</span><div id="viewToggle"></div></div>
<div id="bankBucket"></div>

<?php include "footer.php" ?>


<script>
    $('body').on('dragover', function(e){
        e.preventDefault();
        e.stopPropagation();
    });
    $('body').on('dragenter', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('body').on('drop', function(e){
        if(e.originalEvent.dataTransfer.files){
            if(e.originalEvent.dataTransfer.files.length) {
                e.preventDefault();
                e.stopPropagation();
                new postUpload(e.originalEvent.dataTransfer.files[0]);
            }
        } else {
            alert('Drag and Drop not supported in your browser');
        }
    });

    function drag(ev)
    {
        postBank.$draggedItem = $(ev.target).parent();
    }

    function undrag(ev) {
        //postBank.$draggedItem = null;
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
        _gaq.push(['_trackEvent', 'Inspire', 'Drag and dropped something']);
        if(postBank.$draggedItem) {
            _gaq.push(['_trackEvent', 'Inspire', 'Dragged from D/W feed']);
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
                _gaq.push(['_trackEvent', 'Inspire', 'Drag and Drop uploaded their own image']);
            } else {
                new_loginscreen();
            }
        }
    }

    /**************************** UPLOADER *************************/
    function postUpload(file) {
        if(dahliawolf.isLoggedIn) {
            _gaq.push(['_trackEvent', 'Inspire', 'Upload initialized']);
            var that = this;
            this.maxSize = 5000000;
            this.minSize = 1000;
            this.file = file;
            this.action = 'action/post_image.php?ajax=true';

            if(!this.validateFile()) {
                return 0;
            }

            if($('.inspireMsg').length) {
                $('.inspireMsg').remove();
            }

            this.MyForm = new FormData();
            this.MyForm.append("iurl", file);

            this.oReq = new XMLHttpRequest();

            if(postBank) {
                this.oReq.upload.addEventListener("loadstart", function() {
                    _gaq.push(['_trackEvent', 'Inspire', 'Upload Started']);
                    that.$post = $('<div class="postFrame grid loading" style=\'background-image: url("/images/inspireLoader.gif");\'></div>').prependTo(postBank.$bucket);
                    that.$progress = $('<div class="progressCount"></div>').appendTo(that.$post);
                }, false);
                this.oReq.upload.addEventListener("progress", function(e) {
                    that.$progress.html(Math.ceil((e.loaded/e.total)*100)+'%');
                }, false);
                this.oReq.addEventListener("load", function() {
                    that.data = $.parseJSON(this.responseText);
                    if(that.data.success) {
                        _gaq.push(['_trackEvent', 'Inspire', 'Upload completed successfully']);
                        that.$post.css('background-image', 'url("'+that.data.data.new_image_url+'")').removeClass('loading').empty().html(that.$getPost(that.data));
                    } else {
                        _gaq.push(['_trackEvent', 'Inspire', 'Failed back end validation', that.data.errors]);
                        _gaq.push(['_trackEvent', 'Errors', that.data.errors]);
                        that.$post.remove();
                        alert(that.data.errors);
                    }

                }, false);
            }

            this.oReq.open("POST", this.getAction);
            this.oReq.send(this.MyForm);
        } else {
            new_loginscreen();
        }
    }

    postUpload.prototype = {
        get getName() {return this.file.name;},
        get getSize() {return this.file.size;},
        get getExt() {return this.file.name.split('.').pop().toLowerCase(); },
        get getAction() {return this.action;}
    }

    postUpload.prototype.$getPost = function(data) {
        data = data.data;
        var $post = $('<div class="tpVoteCity" style="z-index: 0;"></div><div class="postPostingWrap"><div class="bankPosted">' +
            '<p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>' +
            '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+dahliawolf.username+'">profile</a>' +
            '<p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a>' +
            '<a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#">' +
            '<img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>');
        return $post;
    }

    postUpload.prototype.validateFile = function() {
        if(this.getExt !== 'jpg' && this.getExt !== 'gif' && this.getExt !== 'png' && this.getExt !== 'jpeg' ) {
            alert('.'+ext+' is an invalid File Type');
            _gaq.push(['_trackEvent', 'Inspire', '.'+this.getExt+' is an invalid File Type']);
            _gaq.push(['_trackEvent', 'Errors', '.'+this.getExt+' is an invalid File Type']);
            return false;
        } else if(this.getSize < this.minSize) {
            alert('File is too small');
            _gaq.push(['_trackEvent', 'Inspire', 'File is too small']);
            _gaq.push(['_trackEvent', 'Errors', 'File is too small']);
            return false;
        } else if(this.getSize > this.maxSize) {
            alert('File is too large');
            _gaq.push(['_trackEvent', 'Inspire', 'File is too big']);
            _gaq.push(['_trackEvent', 'Errors', 'File is too big']);
        }
        return true;
    }

    /*********************************** BANK ***********************/

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
        postBank.adjustMargins();
        $(window).resize(postBank.adjustMargins);
        $('#viewToggle').on('click', this.toggleMode);
    }

    postBank.checkSyncedAccounts = function(url) {
        if(dahliawolf.areYouLoggedIntoTwitter){
            dahliawolf.post.shareOnTwitter(url);
        }
    }


    postBank.crossBrowserUpload = function(data) {
        var data = $.parseJSON(data);

        if(!data.error) {
            if($('.inspireMsg').length) {
                $('.inspireMsg').remove();
            }
            data = data.data;
            postBank.$bank.css({'background-color': '#ff787d', 'color' : '#fff'});
            postBank.$bankMsg.html('Upload Successful!');
            var str = '<div class="postFrame grid" draggable="true" ondragstart="drag(event);"><div class="postButton" style="display: none;">POST</div>';
            str+= '<img src="'+postBank.url+'" style="opacity: 0.6;"><div class="postPostingWrap"><div class="bankPosted">' +
                '<p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>' +
                '<div class="bankExplain">Congratulations you have successfully posted a new design inspiration. To see all your posts visit your <a href="/'+dahliawolf.username+'">profile</a>' +
                '<p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a>' +
                '<a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#">' +
                '<img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div></div>';
            postBank.$bucket.prepend(str);
        } else {
            postBank.$bank.css('background-color', '#666666');
            postBank.$bankMsg.html('Upload Failed.'+data.error);
            _gaq.push(['_trackEvent', 'Inspire', 'Error Uploading Image', data.error]);
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

    postBank.unbindScroll = function() {
        $(window).unbind('scroll');
    }

    postBank.getImages = function() {
        var that = this;
        if(postBank.isRefillAvailable) {
            dahliawolf.loader.show()
            postBank.isRefillAvailable = false;
            dahliawolf.bank.get(this.offset, this.limit, function(data) {
                console.log(data);
                dahliawolf.loader.hide()
                postBank.isRefillAvailable = true;
                if(data.data.get_feed.images && data.data.get_feed.images.length) {
                    that.offset += data.data.get_feed.images.length;
                    $.each(data.data.get_feed.images, function(index, post) {
                        postBank.$bucket.append(new bankPost(post, data.data.get_feed.object_id, (postBank.mode == 'line' ? index : '') ));
                    });
                } else if(!$('#bankBucket h2').length) {
                    $('#bankBucket').append('<h2 class="inspireMsg">Choose from one of the options above and start inspiring new fashions.</h2>');
                    postBank.unbindScroll();
                }

                postBank.$bucket.append('<div style="clear:left"></div>');
            });
        }
    }

    postBank.getImagesFromInstagram = function() {
        _gaq.push(['_trackEvent', 'Inspire', 'Loaded images from Instagram']);
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
        _gaq.push(['_trackEvent', 'Inspire', 'Load images from Tumblr']);
        if(dahliawolf.areYouLoggedIntoTumblr) {
            dahliawolf.loader.show();
            $.getJSON('/lib/TumblrOAuth/getPosts', function(data) {
                postBank.ajaxCall = null;
                dahliawolf.loader.hide();
                if(data.response.posts.length) {
                    postBank.clearBank();
                    $(window).unbind('scroll');
                    $.each(data.response.posts, function(index, post) {
                        $.each(post.photos, function(index, photo) {
                            postBank.posts.push( new foreignPost(photo.alt_sizes[0].url, 'Tumblr') );
                        });
                    });
                } else {
                    alert('No Images Found');
                }
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

    function bankPost(data, oi,  index) {
        this.data = data;
        this.data.object_id = oi;
        var widths = [500, 300, 400];
        this.$post = $('<div class="postFrame '+postBank.mode+'" draggable="true" ondragstart="drag(event);" ondragleave="undrag(event)" '+(index != '' ? 'style="width:'+widths[index%widths.length]+'px;"' : '')+'></div>');
        this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
        this.$image = $('<a class="zoombox" data-url="'+this.data.source+this.data.imageURL+'" rel="modal"><img src="'+this.data.source+this.data.imageURL+'"></a>').appendTo(this.$post);
        this.$source = $('<div class="postSource"><a href="'+(this.data.domain ? ('http://'+this.data.domain) : 'http://'+this.data.attribution_url)+'" target="_new">'+(this.data.domain ? this.data.domain : this.data.attribution_url)+'</a></div>').appendTo(this.$post);
        this.$post.appendTo(postBank.$bucket);

        return this;
    }

    bankPost.prototype.post = function() {
        var description = '';
        this.$button.hide();
        this.$post.find('img').css('opacity', .2);
        dahliawolf.bank.post(this.data.id, this.data.object_id, $.proxy(this.addAfterPostMessage, this) );
    }

    bankPost.prototype.addAfterPostMessage = function(data) {
        data = data.data.post_image;

        if(data.posting_id) {
            var str = '<div class="postPostingWrap"><div class="bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>';
            str += '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+theUser.username+'">profile</a><p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')">';
            str += '<img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>';

            this.$post.append(str);
            this.$post.append(new shareBall(data));
            postBank.checkSyncedAccounts('http://www.dahliawolf.com/post/'+data.posting_id);
        } else if(data.error){
            this.$post.append('<div class="inspireError">'+data.error+'</div>');
        }
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
                _gaq.push(['_trackEvent', 'Inspire', 'Posted image from '+this.domain]);
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
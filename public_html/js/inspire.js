/**
 * Created with JetBrains PhpStorm.
 * User: Geoffrey
 * Date: 1/15/14
 * Time: 4:27 PM
 * To change this template use File | Settings | File Templates.
 */
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
        this.action = '/action/post_image.php?ajax=true';

        if(!this.validateFile()) {
            return 0;
        }

        if($('.inspireMsg').length) {
            $('.inspireMsg').remove();
        }

        this.MyForm = new FormData();
        this.MyForm.append("iurl", file);

        this.oReq = new XMLHttpRequest();

        if($('#bankBucket').length) {
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
                    postBank.checkSyncedAccounts('http://www.dahliawolf.com/post/'+that.data.data.posting_id, that.data.data.new_image_url, that.data.data.posting_id);
                } else {
                    _gaq.push(['_trackEvent', 'Inspire', 'Failed back end validation', that.data.errors]);
                    _gaq.push(['_trackEvent', 'Errors', that.data.errors]);
                    that.$post.remove();
                    alert(that.data.errors);
                }

            }, false);
        } else {
            this.oReq.upload.addEventListener("progress", function(e) {
                $('#dropUpdate').html(Math.ceil((e.loaded/e.total)*100)+'%');
            }, false);
            this.oReq.addEventListener("load", function() {
                that.data = $.parseJSON(this.responseText);
                if(that.data.success) {
                    var $verifyPost = $('<ul class="postConfirm"><li class="closer">X</li><li class="title">YOUR IMAGE HAS BEEN POSTED</li><li class="theImage" style="background-image: url('+that.data.data.new_image_url+');"></li></ul>').appendTo($('#theDropPad')).fadeIn(400);
                    setTimeout(function() {
                        $verifyPost.css({'left': ($('#userAvatar').offset().left+200)+'px', top:10+'px', width:10+'px', height:10+'px'});
                    }, 2600);
                    _gaq.push(['_trackEvent', 'Inspire', 'Upload completed successfully']);
                    postBank.checkSyncedAccounts('http://www.dahliawolf.com/post/'+that.data.data.posting_id, that.data.data.new_image_url, that.data.data.posting_id);
                } else {
                    _gaq.push(['_trackEvent', 'Inspire', 'Failed back end validation', that.data.errors]);
                    _gaq.push(['_trackEvent', 'Errors', that.data.errors]);
                    alert(that.data.errors);
                }

                setTimeout(that.resetDropPad, 3000)
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

postUpload.prototype.resetDropPad = function() {
    $('#theDropPad').fadeOut(100, function() {
        $('#dropUpdate').html('DROP IT LIKE ITS HOT');
    });
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
        alert('.'+this.getExt+' is an invalid File Type');
        _gaq.push(['_trackEvent', 'Inspire', '.'+this.getExt+' is an invalid File Type']);
        _gaq.push(['_trackEvent', 'Errors', '.'+this.getExt+' is an invalid File Type']);
        this.resetDropPad();
        return false;
    } else if(this.getSize < this.minSize) {
        alert('File is too small');
        _gaq.push(['_trackEvent', 'Inspire', 'File is too small']);
        _gaq.push(['_trackEvent', 'Errors', 'File is too small']);
        this.resetDropPad();
        return false;
    } else if(this.getSize > this.maxSize) {
        alert('File is too large');
        _gaq.push(['_trackEvent', 'Inspire', 'File is too big']);
        _gaq.push(['_trackEvent', 'Errors', 'File is too big']);
        return false;
        this.resetDropPad();
    }
    return true;
}

/*********************************** BANK ***********************/

postBank = new Object();
postBank.posts = [];
postBank.offset = 0;
postBank.limit = 12;
postBank.isRefillAvailable = true;
postBank.mode = 'grid';

postBank.init = function(feed) {
    postBank.$bucket = $('#bankBucket');
    postBank.$dropBox = $('#dndeezy');
    postBank.$bankOptions = $('#bankOptions');
    postBank.bindScroll();

    postBank.adjustMargins();
    $(window).resize(postBank.adjustMargins);
    $('#viewToggle').on('click', this.toggleMode);
    switch(feed.feedType) {
        case 'dahliawolf' :
            postBank.getImages();
            break;
        case 'tumblr' :
            postBank.getImagesFromTumblr();
            break;
        case 'instagram' :
            postBank.getImagesFromInstagram();
            break;
        case 'website' :
            break;
    }
}

postBank.checkSyncedAccounts = function(url, img_url, id) {
    if(dahliawolf.areYouLoggedIntoTwitter){
        dahliawolf.post.shareOnTwitter(url, id);
    }
    if(dahliawolf.areYouLoggedIntoTumblr) {
        dahliawolf.post.shareOnTumbler(img_url, id);
    }
    if(dahliawolf.areYouLoggedIntoFacebook) {
        dahliawolf.post.shareOnFacebook(img_url, id);
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

function bankPost(data, oi,  index) {
    this.data = data;
    this.data.object_id = oi;
    var widths = [500, 300, 400];
    this.$post = $('<div class="postFrame '+postBank.mode+'" draggable="true" ondragstart="drag(event);" ondragleave="undrag(event)" '+(index != '' ? 'style="width:'+widths[index%widths.length]+'px;"' : '')+'></div>');
    this.$button = $('<div class="postButton">POST</div>').appendTo(this.$post).on('click', $.proxy(this.post, this) );
    this.$image = $('<a class="zoombox" data-url="'+this.data.source+this.data.imageURL+'" rel="modal"><img src="'+this.data.source+this.data.imageURL+'"></a>').appendTo(this.$post);
    this.$source = $('<div class="postSource"><a href="'+(this.data.domain ? ('http://'+this.data.domain) : this.data.attribution_url)+'" target="_new">'+(this.data.domain ? this.data.domain : this.data.attribution_url)+'</a></div>').appendTo(this.$post);
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
        postBank.checkSyncedAccounts('http://www.dahliawolf.com/post/'+data.posting_id, data.new_image_url, data.posting_id);
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
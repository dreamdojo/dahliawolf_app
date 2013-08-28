
<style>
.bank-frame{position:relative;min-height: 200px;}
.bankPosted{position: relative;top: 27%;width: 100%;font-family: futura, Arial, Helvetica, sans-serif; margin-left: 12px;}
.bankInnerPosted{font-size: 40px;margin-bottom: -10px; }
.bankshare{font-size: 20px;margin-top: 30px;}
.bankExplain{position: relative;top: 42%;font-size: 14px;width: 230px;left: 50%;margin-left: -103px;}
.banklink{ font-size: 16px;margin-top: 10px;}
.banklink a{color: #fff;background-color: #ff406d;padding: 4px 32px;margin-top: 0px;}
#thePercentageContainer{position: absolute;height: 100%;top: 0px;background-color: #c2c2c2;left: 0px;width: 100%;}
#thePercentageBar{position: absolute;height: 100%;background-color: #FA9B9B;width: 100%;top: 0px; width: 0%;}
#PercentageCounter{position: absolute; width: 100px; left: 50%; margin-left: -50px;font-size: 27px;line-height: 55px;color: #fff; z-index: 1;}
#PercentageCounter p{margin-bottom: 0px;height: 60px;}
#closeUpload{position: absolute;top: 7px;background-color: #000;color: #fff;right: 10px;font-size: 20px;border: #fff 3px solid;z-index: 10;padding: 8px 15px;border-radius: 42px;z-index: 1; cursor: pointer;}
.uploadPreview-frame img{ width:100%;}
.view-upload-button{float: left;background-color: #ff416d;font-size: 15px;color: #fff;height: 21px;margin-top: -24px;line-height: 20px;padding: 0px 10px;}
.bar-frame{height: 45px;background-color: #fff;float: left;width: 750px;margin-top: 6px;margin-left: 10px;}
.title-roll{background-color: #e4e2e3;padding: 12px;font-size: 22px; position: fixed;width: 975px;z-index: 1; font-weight:bold;}
.gridzy{height: 350px;width: 325px;overflow: hidden;float: left;}
.gridzy .b-roll-img{min-height: 100%;width: 100%;}
.gridzy .tag{height: 60px; margin-left: -55px;position: absolute;top: 35px; left: 95%;}
.first{ margin-top:55px;}
#viewToggle{height: 30px;width: 65px;position: absolute;right: 0px;top: 9px;margin-right: 20px; cursor:pointer;}
.toggleViewGrid{ background-image:url(/images/view_toggle.png); background-size:100% 100%;}
.toggleViewLine{ background-image:url(/images/view_toggle2.png); background-size:100% 100%;}
#inspireBackButton{ position: absolute;left: 20px;height: 30px;width: 70px;margin-top: -3px;background-image: url(/images/inspireBackButton.png);background-size: 100% 100%;background-repeat: no-repeat; cursor:pointer;}
#inspireBackButton:hover{ opacity:.7;}
.bankExplain a{color:#ff406d;}
.postPostingWrap{position: absolute;width: 100%;text-align: center;top: 25%;}
#sparticus{ position: fixed; height: 500px; width: 300px;}
</style>


<form action="action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
<div id="theFork">
    <div class="animated-word">INSPIRE NEW FASHION</div>
</div>

<div id="bank-roll">
</div>

<div id="bank-overlay">
</div>

<div id="post-me">
	<div id="u-clsr" onclick="imgUpload.closeMe()">X</div>
    <div class="uploader-frame">
    	<img id="user-uploaded-img" />
    </div>
    
        <input type="hidden" name="subpin" value="1">       
        <div style="text-align: center;"><textarea name="description" id="comment">#dahliawolf</textarea></div>
        <div style="text-align: center;padding-bottom: 25px; margin-top: 10px;"><input name="submit" type="image" src="/images/postitbtn2.png" onclick="$(this).hide()" id="image-sub"></div>
</div>
</form>
<script>
	
	function new_loginscreen(){
        sendToAnal({name:'Hit login Wall'});
		$('#mask').fadeIn(200, function(){
			$('#sign-up-modal').show();
			$('#mask').bind('click', close_new_loginscreen);
		});
	}
	function close_new_loginscreen(){
		$('#mask').fadeOut(100);
		$('#sign-up-modal').fadeOut(100);
		$('#mask').unbind('click');
	}
	
	$('body').on('dragover', function(e){
		e.preventDefault();
		e.stopPropagation();
	});
	$('body').on('dragenter', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});
	
	$('body').on('drop', function(e){
		if(e.originalEvent.dataTransfer){
			if(e.originalEvent.dataTransfer.files.length) {
				e.preventDefault();
				e.stopPropagation();
				imgUpload.files = e.originalEvent.dataTransfer.files;
				imgUpload.submitImage( e.originalEvent.dataTransfer.files[0]);
			}   
		}
	});
	
	//********** OLD VERSION **************************
    var imgUpload = new Object();
	imgUpload.isOpen = false;
	imgUpload.outlet = $('#post-me');
	imgUpload.theForm = $('#thePinForm')[0];
	imgUpload.uploadButton = $('#uploadButton');
	imgUpload.xfers = new Array();
	imgUpload.isAvailable = true;
	imgUpload.index = 0;
	
	imgUpload.loadImage = iuLoader;
	imgUpload.showMe = uiShow;
	imgUpload.closeMe = uiHide;
	imgUpload.userUpload = userUpload;
	imgUpload.submitImage = submitImage;
	
	imgUpload.uploadButton.bind('click', imgUpload.userUpload);

    imgUpload.checkFile = function(file) {
        var ext = file.name.split('.').pop().toLowerCase();

        if(ext !== 'jpg' && ext !== 'gif' && ext !== 'png' && ext !== 'jpeg' ) {
            alert('Invalid File Type');
            return false;
        } else if(file.size < 1000) {
            alert('File is too small');
            return false;
        } else if(file.size > 5000000);
        return true;
    }
	
	function submitImage(file){
		if( !imgUpload.checkFile(file) ) {
            return 0;
        }

        if(theUser.id && imgUpload.isAvailable){
            sendToAnal({name:'Uploaded an Image'});
            imgUpload.isAvailable = false;

			URL = 'action/post_image.php?ajax=true';
			
			MyForm = new FormData();
			MyForm.append("iurl", file);
			
			imgUpload.oReq = new XMLHttpRequest();
			imgUpload.oReq.upload.reader =  new FileReader();
			
			imgUpload.oReq.upload.file = file;
			
			imgUpload.oReq.upload.showPreview = showPreview; 
			
			imgUpload.oReq.upload.addEventListener("loadstart", transferStart, false);
			imgUpload.oReq.upload.addEventListener("progress", transferUpdate, false);
			imgUpload.oReq.onreadystatechange = transferComplete;
			
			imgUpload.oReq.open("POST", URL);
			imgUpload.oReq.send(MyForm);
			
		}else{
			new_loginscreen();
		}
	}

    imgUpload.closeUpload = function() {
        imgUpload.container.fadeOut(200, function() {
            imgUpload.container.remove();
        });
    }
	
	function transferStart(e){
		//this.showPreview();
		imgUpload.container = $('<div id="thePercentageContainer"></div>').appendTo('#bankOptions');
        imgUpload.container.append('<div id="PercentageCounter"><div>').append('<div id="thePercentageBar"></div>').append('<div id="closeUpload">X</div>');
        $('#closeUpload').bind('click', imgUpload.closeUpload);
	}
	function transferUpdate(e){
		$('#thePercentageBar').animate({'width': ((e.loaded/e.total)*100)+'%'}, 50 );
        $('#PercentageCounter').html( Math.ceil( ((e.loaded/e.total)*100) ) +'%' );
	}
	function transferComplete(){
		if( this.readyState == 4){
            var data = $.parseJSON(this.responseText);
            if(data.success) {
                theBank.refreshPage = true;
                var id = data.data.posting_id;
                $('#thePercentageBar').remove();
                $('#PercentageCounter').html('<a href="/post/'+id+'"><p>POSTED</p><div class="view-upload-button">VIEW POST</div></a>');
                user_points_animation(20);
                if(!theBank.isOpen) {
                    imgUpload.closeUpload();
                }
            } else {
                imgUpload.closeUpload();
                alert(data.errors);
            }
			imgUpload.isAvailable = true;
		}
	}
	
	function userUpload(){
		$('#file').click();
	}
	
	function uiShow(){
		this.outlet.show();
		this.isOpen = true;
	}
	
	function uiHide(){
		this.outlet.hide();
		this.theForm.reset();
		this.isOpen = false;
	}
	
	function showPreview(){
		this.reader.onload = function (e) {
			jQuery('#uploadPreview-'+imgUpload.index).attr('src', e.target.result);
			//stopLoad();
		}
		this.reader.readAsDataURL(this.file);
	}
	
	function iuLoader(input){
		this.showMe();
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				jQuery('#user-uploaded-img').attr('src', e.target.result);
				stopLoad();
			}
			reader.readAsDataURL(input.files[0]);
		} 
	}
	/*
	//POST BOX - This controls the the pop up when you want to post an item
	var postBox = new Object();
	postBox.isOpenArray = new Array();
	postBox.id = null;
	postBox.postModeComment = false;
	
	//METHODS
	postBox.loadMe = loadMe;
	postBox.closeMe = closeBox;
	postBox.getOptionsBox = getOptionsBox;
	postBox.scrollAdjust = scrollAdjust;
	postBox.isOpen = pbOpen;
	postBox.postWithComments = LoadMeWithComments;
	postBox.postWithoutComments = LoadMeWithoutComments;
	
	function pbOpen(id){
		if(postBox.isOpen[id]){
			return true;
		}else{
			return false;
		}
	}
	
	function getOptionsBox(id){
		return $('#post-options-'+id);
	}
	
	function closeBox(id){
		pbTemp = this.getOptionsBox(id);
		pbTemp.slideUp(300);
		postBox.isOpen[id] = false;
	}
	
	function scrollAdjust(){
		theBank.outlet.animate({scrollTop : (theBank.outlet.scrollTop() + 200)}, 300);
	}
	
	function LoadMeWithComments(id){
		postBox.id = id;
		postOptions = postBox.getOptionsBox(id);
		postOptions.load('/post_options.php?id='+id, function(){
			if(thePost.trainingMode){
				theLesson.changeTitle(theLesson.postTitle['step3']);
				theLesson.changeContent(theLesson.postContent['step3']);
			}
			postOptions.slideDown(200, postBox.scrollAdjust);
			postBox.isOpen[id] = true;
		});
	}
	
	function LoadMeWithoutComments(id){
		theBank.postImage(id, "");
	}
	
	function loadMe(img, id){ // OPENS POST DETAILS BOX FOR TAGGING AND POSTING ****************
		if(user_id){
			if(postBox.isOpen(id)){
				postBox.closeMe(id);
				return;
			}
			if(id > 0){
				if(theBank.postModeComment == true){
					postBox.postWithComments(id);
				}else{
					postBox.postWithoutComments(id);
				}
			}
		}else{
			new_loginscreen();
		}
	}
	
	// THE BANK - This controls the post Bank
	var theBank = new Object();
	theBank.scroller = new Object();
	theBank.scroller.percentToRefill = 90;//what percentage the scroller must go down before getting more images
	theBank.index = 0;
	theBank.script = "/includes/php/ajax_getFeed.php?";
	theBank.outlet = $('#bankBucket');
	theBank.bankOptions = $('#bankOptions');
	theBank.pinterestCover = $('#getPinterestName');
	theBank.refilling = false;
	theBank.isOpen = false;
	theBank.refreshPage = false;
	theBank.topDistance = 107;
	theBank.trainingTopDistance = 390;
	theBank.dragndrop = '<div class="title-roll"><div id="inspireBackButton" class="hidden"></div><span id="postTitleContent">Don\'t have images? Post from the DAHLIA WOLF IMAGE BANK</span>';
	theBank.dragndrop += '<div id="viewToggle" class="toggleViewLine"></div></div><div id="theUploadBuffer" class="first"></div>';
	theBank.isAvailable = true;
	theBank.slide = false;
	theBank.gridMode = false;
	
	//METHODS
	theBank.openShop = openShop;
	theBank.fillerUp = fillerUp;
	theBank.initScroller = initScroller;
	theBank.height = 0;
	theBank.postMe = postMe;
	theBank.closeMe = closeBank;
	theBank.showTag = showTag;
	theBank.hideTag = hideTag;
	theBank.postImage = bankPostImage;
	theBank.transformToTrainingMode = _transformToTrainingMode;
	theBank.transformFromTrainingMode = _transformFromTrainingMode;
	theBank.resetTopDistance = _resetTopDistance;
	theBank.toggleMenu = _toggleMenu;
	theBank.finishPost = _finishPost;
	theBank.activateDragndrop = _activateDragndrop;
	theBank.killScroller = killScroller;
	
	theBank.goHome = function() {
		theBank.backButton.addClass('hidden');
		theBank.clearBankImages();
		theBank.fillerUp();
		theBank.setPostTitleContent('Post images from OUR Dahliawolf Image Bank');
	}
	
	theBank.setPostTitleContent = function(str) {
		$('#postTitleContent').html(str);
	}
	
	theBank.sizeBankRoll = function() {
		offzet = theBank.outlet.css('top').replace(/[^-\d\.]/g, '');
		theBank.outlet.height( $(window).innerHeight() - offzet );
	}
	
	theBank.bindResize = function() {
		$(window).bind('resize', theBank.sizeBankRoll);
	}
	theBank.unBindResize = function() {
		$(window).unbind('resize');
	}
	
	theBank.showLoader = function() {
		theBank.outlet.append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
	}
	theBank.destroyLoader = function() {
		$('#theGridLoader').remove();
	}

	
	theBank.killAjaxRequest = function() {
		this.currentAjaxRequest.abort();
		this.destroyLoader()
	}
	
	theBank.clearBankImages = function(){
		$('.bank-frame').each(function(index, element) {
     		$(element).remove();       
        });
	}
	
	theBank.postNonBankImage = function(img, img_domain, img_attribution_url) {
		img = $(img);
		imageUrl = img.data('url');
		if(theUser.id && theUser.id > 0 && imageUrl && imageUrl != '' && img_attribution_url && img_domain ) {
            var img_attribution_url = 'http://'+img_attribution_url;
            $.post('/action/uploadPost.php', {image_src : imageUrl, description: 'pinterest', domain:img_domain, sourceurl : img_attribution_url}).done(function(data){
				data = $.parseJSON(data);
				data = data.data;
				str = '<div class="postPostingWrap"><div class="bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+data.posting_id+'">VIEW POST</a></p></div>';
				str += '<div class="bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+theUser.username+'">';
				str += 'profile</a><p class="bankshare"><a href="#" onclick="sendMessageProduct('+data.posting_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a> <a href="#">';
				str += '<img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>';
				img.after(str);
				img.siblings('img').css('opacity', .6);
				img.remove();
				theBank.refreshPage = true;
			});
		}else{
			new_loginscreen();
		}
	}
	theBank.getImagesFromInstagram = function() {
		if(userConfig.instagramToken) {
			if(theBank.isAvailable) {
				theBank.isAvailable = false;
				if(this.currentAjaxRequest){
					this.killAjaxRequest();
				}
				theBank.showLoader();
				theBank.currentAjaxRequest = $.ajax('https://api.instagram.com/v1/users/self/media/recent?access_token='+userConfig.instagramToken+'&callback=callbackFunction', {dataType:'jsonp'}).done(function(data){
                    theBank.currentAjaxRequest = null;
					theBank.destroyLoader();
					theBank.isAvailable = true;
					theBank.killScroller();
					theBank.clearBankImages();
					theBank.setPostTitleContent('Post images from YOUR Instagram account');
					theBank.backButton.removeClass('hidden');
					$.each(data.data, function(index, img){
						str = '<div class="bank-frame"><img class="b-roll-img" src="'+img.images.standard_resolution.url+'">';
						str += '<img class="tag" src="/images/pi-tag.png" data-url="'+img.images.standard_resolution.url+'" onClick="theBank.postNonBankImage(this, \'Instagram\', \'www.instagram.com\');">';
						str += '</div>';
						theBank.outlet.append(str);
					});
				});
			}
		} else {
            window.open(
                "https://api.instagram.com/oauth/authorize/?client_id=65e8ae62e2af4d118bf0f8b2227381f1&redirect_uri=http://www.dahliawolf.com/instagramConnect&response_type=token",
                'Log into Instagram',
                'width=500, height=500'
            );
		}
	}
	
	theBank.getImagesFromPinterest = function() {
		if(userConfig.pinterest_username && userConfig.pinterest_username != '') {
			if(theBank.isAvailable) {
				if(this.currentAjaxRequest){
					this.killAjaxRequest();
				}
				theBank.isAvailable = false;
				theBank.showLoader();
				theBank.currentAjaxRequest = $.post('/get_feed_from_pinterest', { pinterest_user : userConfig.pinterest_username }).done(function(data){
					theBank.currentAjaxRequest = null;
					theBank.destroyLoader();
					theBank.isAvailable = true;
					theBank.killScroller();
					theBank.clearBankImages();
					theBank.setPostTitleContent('Post images from YOUR Pinterest account');
					theBank.backButton.removeClass('hidden');
					$.each(data.data, function(index, img){
						str = '<div class="bank-frame"><img class="b-roll-img" src="'+img.images.standard_resolution.url+'">';
						str += '<img class="tag" src="/images/pi-tag.png" data-url="'+img.images.standard_resolution.url+'" onClick="theBank.postNonBankImage(this, \'Pinterest\', \'www.pinterest.com\');">';
						str += '</div>';
						theBank.outlet.append(str);
					});
				}).error(function(){
					theBank.currentAjaxRequest = null;
					theBank.isAvailable = true;
					alert('does not exist');
				});
			} 
		} else {
			$(this).find('#getPinterestName').animate({left : 0+'%'}, 200);
		}
	}
	
	theBank.getNameAndGo = function() {
		name = $('#thePinterestName').val().trim();
		if(name && name != '') {
			userConfig.pinterest_username = name;
			theBank.getImagesFromPinterest();
		} else {
			alert('invalid username');
		}
	}
	
	theBank.toggleGridMode = function() {
		if(!theBank.gridMode){
			$('.bank-frame').each(function(index, element) {
				$(element).addClass('gridzy');
			});
			$('#viewToggle').addClass('toggleViewGrid').removeClass('toggleViewLine');
			theBank.gridMode = true;
		}else{
			$('.bank-frame').each(function(index, element) {
				$(element).removeClass('gridzy');
			});
			$('#viewToggle').removeClass('toggleViewGrid').addClass('toggleViewLine');
			theBank.gridMode = false;
		}
	}
	
	theBank.loadSocial = function(){
		alert('This function will be available shortly');
	}
	
	function _activateDragndrop(){
		$('#dndeezy').on('dragenter', function(){
			$(this).css('border-color', '#00bdf3');
		}).on('dragleave', function(){
			$(this).css('border-color', '#c2c2c2');
		});
	}
	
	function _finishPost(old_id, new_id){
		str = '<div class="postPostingWrap"><div class = "bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+new_id+'">VIEW POST</a></p></div>';
		str += '<div class = "bankExplain">Congratulations you have successfully posted new design inspiration. To see all your post visit your <a href="/'+theUser.username+'">profile</a><p class="bankshare"><a href="#" onclick="sendMessageProduct('+new_id+')"><img src="http://www.dahliawolf.com/skin/img/btn/facebook-dahlia-share.png"></a> <a href="#" ><img src="http://www.dahliawolf.com/skin/img/btn/twitter-dahlia-share.png"></a> <a href="#"><img src="http://www.dahliawolf.com/skin/img/btn/pinterest-dahlia-share.png"></a></p></div></div>';
		$('#tag-'+old_id).remove();
		$('#post-image-'+old_id).css('opacity', .3);
		$('#frame-'+old_id).append(str);
		user_points_animation(20);
	}
	
	function _toggleMenu(){
		inspire = $('#section-inspire');
		vote = $('#section-vote');
		shop = $('#section-shop');
		classname = 'color-me-red';
		
		if( !inspire.hasClass(classname) ){
			inspire.addClass(classname);
			if( vote.hasClass(classname) ){
				theBank.rememberSection = 'vote';
				vote.removeClass(classname);
			}else if( vote.hasClass(classname) ){
				theBank.rememberSection = 'shop';
				shop.removeClass(classname);
			}		
		}else{
			inspire.removeClass(classname);
			$('#section-'+theBank.rememberSection).addClass(classname);
		}
	}
	
	function _resetTopDistance(){
		theBank.topDistance = 107;
	}
	
	function _transformToTrainingMode(){
		thePost.setTrainingMode();
		theBank.outlet.animate({top: theBank.trainingTopDistance}, thePost.speeds.dropDown);
	}
	
	function _transformFromTrainingMode(){
		theBank.resetTopDistance();
		theBank.outlet.animate({top: theBank.topDistance}, thePost.speeds.dropDown);
	}
	
	function bankPostImage(id, description){ //************ MAKE CALL TO POST IMAGE
		if(id && id > 0 && theBank.isAvailable){
            theBank.isAvailable = false;
			$.post('/action/post_feed_image.php', { id: id, description: description} ).done(function(data){
				theBank.finishPost(id, data.posting_id);
				theBank.isAvailable = true;
				theBank.height = theBank.height - $('#frame-'+id).height();
				if(theBank.slide){$('#frame-'+id).slideUp(200);}
				theBank.refreshPage = true;
                sendToAnal({name:'Just posted from the Dahliawolf bank', post: data.posting_id});
			});
		}
		return false;
	}
	
	function showTag(id){
		//$('#tag-'+id).css('opacity', 1);
	}
	
	function hideTag(id){
		//$('#tag-'+id).css('opacity', 0);
	}
	
	function closeBank(){
		if(theBank.refreshPage){
			location.reload();
			return;
		}
		theBank.unBindResize();
		thePost.hideOverlay();
		theBank.outlet.fadeOut(200, function(){
			$('#bankOptions').slideUp(100);
			theBank.toggleMenu();
			$('body').css('overflow', 'auto');
			theBank.outlet.empty();
			theBank.isOpen = false;
		});
	}
	
	function postMe(img, id){
		if(id > 0){
			theBank.postBox.load('/upload_popup.php?id='+id+'&theurl='+img, function(){
				//do cool thangs
			});
		}
	}
	
	function initScroller(){
		theBank.outlet.bind('scroll', function(){
			obj = document.getElementById('bank-roll');
			if(obj.scrollTop >= (obj.scrollHeight - obj.offsetHeight - 300)){
				theBank.fillerUp();
			}
		});
		theBank.isOpen = true;
	}
	function killScroller(){
		theBank.outlet.unbind('scroll');
	}
	
	function fillerUp(){  // ************ GETS IMAGE AND APPENDS IT TO BANK FEED
		if(!theBank.refilling){
			theBank.refilling = true;
			URLFILL = theBank.script+'offset=' + theBank.index;
			
			if(this.currentAjaxRequest){
				this.killAjaxRequest();
			}
			theBank.showLoader();
			theBank.currentAjaxRequest = $.ajax({ url: URLFILL, context: document.body }).done(function(data){
				theBank.destroyLoader();
				this.currentAjaxRequest = null;
				for(i = 0; i < data.data.length;i++){
					if(data.data[i].baseurl){
						var src = data.data[i].source + data.data[i].imageURL;
						appendStr = '<div id="frame-'+data.data[i].id+'" class="bank-frame '+(theBank.gridMode ? 'gridzy' : '')+'"><img class="b-roll-img" id="post-image-'+data.data[i].id+'" src="'+src+'" onmouseout="theBank.hideTag('+data.data[i].id+')" onmouseover="theBank.showTag('+data.data[i].id+')"><img id="tag-'+data.data[i].id+'" class="tag" src="/images/pi-tag.png" onclick="postBox.loadMe(\''+src+'\', \''+data.data[i].id+'\')" onmouseover="theBank.showTag('+data.data[i].id+')">';
						appendStr += '<div id="post-options-'+data.data[i].id+'"></div></div>';
						theBank.outlet.append(appendStr);
						theBank.index++;
						theBank.height += parseInt(data.data[i].dimensionsY);
					}
				}// end for loop
				theBank.refilling = false;
			});
		}
	}
	
	function openShop(){
		if(thePost.isOpen){
            theBank.outlet.append(theBank.dragndrop);
            theBank.fillerUp();
            thePost.fork.animate({top: theBank.topDistance}, 200, function(){
				$('#bankOptions').slideDown(100);
				thePost.fork.animate({'top' : 107}, 100, function(){
					thePost.fork.fadeOut(200);
					thePost.fork.animate({top: thePost.hideMe}, 1, function(){
						thePost.fork.show();
						thePost.isOpen = false;
					});
					theBank.sizeBankRoll();
					theBank.bindResize();
					$('#viewToggle').bind('click', theBank.toggleGridMode);
					theBank.outlet.show();
					theBank.initScroller();
					theBank.activateDragndrop();
					theBank.backButton = $('#inspireBackButton');
					$('#inspireBackButton').bind('click', theBank.goHome);
					if(thePost.trainingMode){
						theLesson.changeTitle(theLesson.postTitle['step2']);
						theLesson.changeContent(theLesson.postContent['step2']);
					}
                    sendToAnal({name:'Just Opened the Bank'});
				});
			});
		}
	}
	
	//POST BUTTON - This controls the post button functionality and the drop down menu
	//OBJECTS
	thePost = new Object();
	thePost.speeds = new Object();
	thePost.speeds.dropDown = 200;
	thePost.hideMe = -200;
	thePost.isOpen = false;
	thePost.defaultTopDistance = 297;
	thePost.topDistance = 297;//distance from the top ie. header
	thePost.bounce = 50;
	thePost.index = 0;
	thePost.trainingMode = false;
	thePost.delay = 600;// how long inspiration quote shows during animation
	
	
	//METHODS
	thePost.openMe = openMe;
	thePost.closeMe = closeMe;
	thePost.buttonPushed = buttonPushed;
	thePost.init = postInit;
	thePost.showOverlay = showOverlay;
	thePost.hideOverlay = hideOverlay;
	thePost.setTrainingMode = setTrainingMode;
	thePost.unsetTrainingMode = unsetTrainingMode;
	thePost.resetTopDistance = _resetPostTopDistance;
	thePost.transformToTrainingMode = thePostTransformToTrainingMode;
	thePost.transformFromTrainingMode = thePostTransformFromTrainingMode;
	
	function thePostTransformFromTrainingMode(){
		thePost.unsetTrainingMode();
		thePost.fork.animate({top:thePost.defaultTopDistance}, thePost.speeds.dropDown);
	}
	
	function thePostTransformToTrainingMode(){
		theLesson.changeTitle(theLesson.postTitle['step1']);
		theLesson.changeContent(theLesson.postContent['step1']);
		thePost.setTrainingMode();
		thePost.fork.animate({top: theBank.trainingTopDistance}, thePost.speeds.dropDown);
	}
	
	function _resetPostTopDistance(){
		thePost.topDistance = 107;
	}
	
	function unsetTrainingMode(){
		thePost.topDistance = thePost.defaultTopDistance;
		theBank.resetTopDistance();
		$('#bank-roll').css('top', theBank.topDistance);
		thePost.trainingMode = false;
	}
	
	function setTrainingMode(){
		$('#step1').addClass('faded');
		$('#step2').removeClass('faded');
		thePost.topDistance = theBank.trainingTopDistance;
		$('#bank-roll').css('top', theBank.trainingTopDistance);
		thePost.trainingMode = true;
	}
	
	function buttonPushed(){
			if(theLesson.isOpen){
				thePost.setTrainingMode();
				theLesson.changeTitle(theLesson.postTitle['step1']);
				theLesson.changeContent(theLesson.postContent['step1']);
			}else if(thePost.trainingMode){
				thePost.unsetTrainingMode();
			}
			if(thePost.isOpen && !theBank.isOpen){//Check if the Fork box is visible and hide it
				thePost.closeMe();
			}else if(!thePost.isOpen && !theBank.isOpen){//if its not then show it
				thePost.openMe();
			}
			if(theBank.isOpen){
				theBank.closeMe();
			}
			if(imgUpload.isOpen){
				imgUpload.closeMe();
			}
	}
	
	function showOverlay(){
		thePost.overlay.fadeIn(300);
		//thePost.overlay.bind('click', thePost.buttonPushed);
	}
	
	function hideOverlay(){
		thePost.overlay.fadeOut(100);
		theLesson.resetToHome();
	}
	
	function openMe(){ // OPENS THE FORK BOX AND ANIMATES IT
		if(!thePost.isOpen){
			thePost.fork.animate({top: thePost.topDistance}, thePost.speeds.dropDown, function(){
				thePost.fork.animate({top: (thePost.topDistance-thePost.bounce)}, 200, function(){
					thePost.fork.animate({top: thePost.topDistance}, 200, function(){
						thePost.isOpen = true;
						theBank.toggleMenu();
						thePost.showOverlay();
						$('body').css('overflow', 'hidden');
						setTimeout(function(){
							theBank.openShop();
						}, thePost.delay);
					});
				});
			});
		}
	}
	
	function closeMe(){ // CLOSES FORK BOX AND ANIMATES IT AS WELL
		if(thePost.isOpen){
			thePost.fork.animate({top: '-'+thePost.topDistance}, thePost.speeds.dropDown, function(){
				theBank.toggleMenu();
				$('#step2').addClass('faded');
				$('#step1').removeClass('faded');
				thePost.hideOverlay();
				$('body').css('overflow', 'auto');
				$('#bankOptions').slideUp(100);
				thePost.isOpen = false;
			});
		}
	}
	
	
	function postInit(){
		thePost.fork = $('#theFork');
		thePost.button = $('#tabber');
		thePost.overlay = $('#bank-overlay');
		this.button.bind('click', thePost.buttonPushed);
		$('#openBank').bind('click', theBank.openShop);
		$('#importFromInstagram').on('click', theBank.getImagesFromInstagram);
		$('#importFromPinterest').on('click', theBank.getImagesFromPinterest);
		$('#goPinterestButton').on('click', theBank.getNameAndGo);
		$('#thePinterestName').keypress(function(e) {
			if(e.keyCode == 13) {
				theBank.getNameAndGo();
			}
		});
		if( $(window).innerHeight() < 700 ){
			theBank.gridMode = true;
		}
	}
	$(function(){
		thePost.init();
	});
	*/
</script>
/*
 rousted by:
 _______  _______  _______  _______  _______  _______  _______          
(  ____ \(  ____ \(  ___  )(  ____ \(  ____ \(  ____ )(  ____ \|\     /|
| (    \/| (    \/| (   ) || (    \/| (    \/| (    )|| (    \/( \   / )
| |      | (__    | |   | || (__    | (__    | (____)|| (__     \ (_) / 
| | ____ |  __)   | |   | ||  __)   |  __)   |     __)|  __)     \   /  
| | \_  )| (      | |   | || (      | (      | (\ (   | (         ) (   
| (___) || (____/\| (___) || )      | )      | ) \ \__| (____/\   | |   
(_______)(_______/(_______)|/       |/       |/   \__/(_______/   \_/   
                                                                        
																		*/
function new_loginscreen(){
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

function submitImage(file){
	if(theUser.id && imgUpload.isAvailable){
		imgUpload.isAvailable = false;

		URL = 'action/post_image.php';
		
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

function transferStart(e){
	this.showPreview();
	imgUpload.container = $('#upload-container');
	str = '<div class="upload" id="upload-'+imgUpload.index+'">';
		str+='<div class="uploadPreview-frame"><img id="uploadPreview-'+imgUpload.index+'" src=""></div>';
		str+= '<div class="upload-percent-container">';
			str += '<div class="upload-percent-bar" id="upload-percent-bar-'+imgUpload.index+'"></div>';
		str+= '</div>';
	str+='</div>';
	imgUpload.container.prepend(str);
}
function transferUpdate(e){
	$('#upload-percent-bar-'+imgUpload.index).css('width', ((e.loaded/e.total)*100)+'%' );
}
function transferComplete(){
	if( this.readyState == 4){
		theBank.refreshPage = true;
		$('#upload-percent-bar-'+imgUpload.index).css('width', 100+'%' );
		obj = this.responseText.split('"');
		$('#upload-'+imgUpload.index).append('<a href="/post/'+obj[8]+'"><div class="view-upload-button">VIEW POST</div></a>');
		user_points_animation(20);
		imgUpload.index++;
		imgUpload.isAvailable = true;
		/*if( imgUpload.files[imgUpload.index] ){
			//imgUpload.submitImage(imgUpload.files[imgUpload.index], imgUpload.index);
		}*/
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
theBank.outlet = $('#bank-roll');
theBank.refilling = false;
theBank.isOpen = false;
theBank.refreshPage = false;
theBank.topDistance = 60;
theBank.trainingTopDistance = 314;
theBank.dragndrop = '<div id="d-n-drop"><div class="inpiration-text">Drag and drop inpiration images here<br>or</div>';
theBank.dragndrop += '<img class="fork-img" id="uploadButton" src="/images/select-files.png" />';
theBank.dragndrop += '<input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onchange="imgUpload.submitImage(this.files[0]);"></div>';
theBank.dragndrop += '<div class="postfromanywhere">Post from anywhere on the web: <a href="/pinit">Get the Inspire Button</a></div>';
theBank.dragndrop += '<div id="upload-container"></div>'
theBank.dragndrop += '<img class="inspire-title" src="/images/inspire_title.png">';
theBank.isAvailable = true;
theBank.slide = false;

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

theBank.showLoader = function() {
	theBank.outlet.append('<div id="theGridLoader"><img src="/images/loading-feed.gif"></div>');
}
theBank.destroyLoader = function() {
	theBank.outlet.remove();
}

function _activateDragndrop(){
	$('#d-n-drop').on('dragenter', function(){
		$(this).css('border-color', '#00bdf3');
	}).on('dragleave', function(){
		$(this).css('border-color', '#c2c2c2');
	});;
}

function _finishPost(old_id, new_id){
	str = '<div class = "bankPosted"><p class="bankInnerPosted">POSTED</p><p class="banklink"><a href="/post/'+new_id+'">View Post Now</a></p></div>';
	str += '<div class = "bankExplain">This image is now posted to your profile and no longer available for other members</div>';	
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
	theBank.topDistance = $('.header').height();
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
		});
	}
	return false;
}

function showTag(id){
	$('#tag-'+id).css('opacity', 1);
}

function hideTag(id){
	$('#tag-'+id).css('opacity', 0);
}

function closeBank(){
	if(theBank.refreshPage){
		location.reload();
		return;
	}
	thePost.hideOverlay();
	theBank.outlet.fadeOut(200, function(){
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
		tester = theBank.outlet.scrollTop() / theBank.height * 100;
		if(tester > 70){
			theBank.fillerUp();
		}
	});
	theBank.isOpen = true;
}

function fillerUp(){  // ************ GETS IMAGE AND APPENDS IT TO BANK FEED
	if(!theBank.refilling){
		theBank.refilling = true;
		URLFILL = theBank.script+'offset=' + theBank.index;
		theBank.showLoader();
		
		$.ajax({ url: URLFILL, context: document.body }).done(function(data){
			theBank.destroyLoader();
			for(i = 0; i < data.data.length;i++){
				//console.log(data);
				if(data.data[i].baseurl){
					var src = data.data[i].source + data.data[i].imageURL;
					appendStr = '<div id="frame-'+data.data[i].id+'" class="bank-frame"><img class="b-roll-img" id="post-image-'+data.data[i].id+'" src="'+src+'" onmouseout="theBank.hideTag('+data.data[i].id+')" onmouseover="theBank.showTag('+data.data[i].id+')"><img id="tag-'+data.data[i].id+'" class="tag" src="/images/pi-tag.png" onclick="postBox.loadMe(\''+src+'\', \''+data.data[i].id+'\')" onmouseover="theBank.showTag('+data.data[i].id+')">';
					appendStr += '<div id="post-options-'+data.data[i].id+'"></div></div>';
					theBank.outlet.append(appendStr);
					theBank.index++;
					theBank.height += parseInt(data.data[i].dimensionsY);
					theBank.refilling = false;
				}
			}
		});
	}
}

function openShop(){
	if(thePost.isOpen){
		thePost.fork.animate({top: theBank.topDistance}, 200, function(){
			thePost.fork.animate({'background-color' : '#FFFFFF'}, 300, function(){
				thePost.fork.animate({top: thePost.hideMe}, 1, function(){
					thePost.isOpen = false;
				});
				
				theBank.outlet.append(theBank.dragndrop);
				theBank.outlet.show();
				theBank.fillerUp();
				theBank.initScroller();
				theBank.activateDragndrop();
				if(thePost.trainingMode){
					theLesson.changeTitle(theLesson.postTitle['step2']);
					theLesson.changeContent(theLesson.postContent['step2']);
				}
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
	thePost.topDistance = $('.header').height();
}

function unsetTrainingMode(){
	thePost.topDistance = thePost.defaultTopDistance;
	theBank.resetTopDistance();
	$('#bank-roll').css('top', 60);
	thePost.trainingMode = false;
}

function setTrainingMode(){
	$('#step1').addClass('faded');
	$('#step2').removeClass('faded');
	thePost.topDistance = theBank.trainingTopDistance;
	theBank.topDistance = theBank.trainingTopDistance;
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
	thePost.overlay.bind('click', thePost.buttonPushed);
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
}
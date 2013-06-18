// JavaScript Document

theFeed = new Object();
theFeed.data = new Object();
theFeed.index = 0;
theFeed.imgPrefix = 'http://repository.offlinela.com/';
theFeed.working = false;
theFeed.script;
theFeed.theCup;
theFeed.quantity;
theFeed.source = {'feed': '../includes/php/m-spine-chunk.php', 'bank': '../includes/php/ajax_getFeed.php'};
theFeed.loadBar = $('#loading-bar');

// METHODS
theFeed.loadImages = loadImages;
theFeed.fillCup = fillCup;
theFeed.run = runFeed;
theFeed.prepImageBank = prepImageBank;
theFeed.prepImagePost = prepImagePost;
theFeed.spitImage = spitImage;
theFeed.init = feedInit;

function feedInit(script, div, quantity){
	if(!User.id || User.id < 1){
		document.location = 'login.php?session_type=web';
		return;
	}
	this.script = this.source[script];
	this.theCup = div;
	this.quantity = quantity;
	this.version = script;
	this.run();
}

function loadImages(){
	if(!this.working){
		this.working = true;
		theFeed.loadBar.show();
		url = this.script+'?offset='+this.index;
		if(User.id && User.id > 0 && this.version == 'feed'){
			url += '&user_id='+User.id;
		}
		$.ajax( {url: url} ).done(function(data){
			theFeed.working = false;
			theFeed.loadBar.hide();
			theFeed.data = data.data;
			if(theFeed.version == 'bank'){
				theFeed.prepImageBank();
			}else if(theFeed.version == 'feed'){
				theFeed.prepImagePost();
			}
		});
	}
}

function fillCup(){
}

function prepImageBank(){
	for(x = 0; x < this.data.length; x++){
		this.index++;
		str = '<div class="pb-frame" id="imgFrame-'+this.data[x].id+'">';
		str += '<img id="post-image-'+this.data[x].id+'" src="'+this.imgPrefix+this.data[x].src+'?id='+this.data[x].id+'&theurl='+this.imgPrefix+this.data[x].src+'" onClick="postItem.showMe('+this.data[x].id+')">';
		str += '<div id="post-box-'+this.data[x].id+'" class="post-box">';
		str += '<textarea id="pop-com-'+this.data[x].id+'" class="pop-com" name="description" placeholder="TAG THIS IMAGE, YO" ></textarea>';
		str += '<input type="image" src="images/pi-post-img.png" id="sub-pop-butt" onClick="postItem.postImage('+this.data[x].id+', $(\'#pop-com-'+this.data[x].id+'\').val() )" >';
		str += '</div>';
		this.spitImage(str);
	}
}
function prepImagePost(){
	for(x = 0; x < this.data.length; x++){
		this.index++;
		str = '<div class="pi-frame pi-'+((x % 2) ? 'even' : 'odd')+'" >';
		str += '<img src="'+this.data[x].image_url+'" style="'+((this.data[x].width / this.data[x].height) > .6 ? 'height' : 'width' )+':100%;" onclick=\'document.location = "post-details.php?posting_id='+this.data[x].posting_id+'&session_type=web"; \'>';
		str += '<div class="pi-lb" style="background-image:url(images/heart_bg'+((parseInt(this.data[x].is_liked)) ? '_on' : '')+'.png);" onclick="'+((parseInt(this.data[x].is_liked)) ? 'un': '')+'likePost('+this.data[x].posting_id+', this);">';
		str += '<div class="lb-num">'+this.data[x].total_likes+'</div>';
		str += '</div></div>';
		this.spitImage(str);
	}
}

function spitImage(str){
	this.theCup.append(str);
}

function runFeed(){
	this.loadImages();
}
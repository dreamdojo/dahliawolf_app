var pplFinder = new Object();
pplFinder.isOpen = false;

pplFinder.formatFriend = ppf_formatFriend;
pplFinder.getCurrentWord = ppf_getCurrentWord;
pplFinder.getMatches = ppf_getMatches;
pplFinder.pushFriends = ppf_pushFriends;
pplFinder.showMe = ppf_showMe;
pplFinder.closeMe = ppf_closeMe;
pplFinder.takeControl = ppf_takeControl;
pplFinder.start = ppf_start;

function ppf_start(){
	pplFinder.input = $(this);
	pplFinder.takeControl();
}

function ppf_takeControl(){
	pplFinder.input.bind('keydown', function(e){
		if(e.keyCode == 50){
			friendStack.takeControl();
		}else if(e.keyCode == 13){
			e.preventDefault();
			pplFinder.input.closest('form').submit();
		}
	});
}

function ppf_closeMe(){
	this.pplBox.hide();
	friendStack.index = 0;	
	pplFinder.input.unbind('keydown');
}

function ppf_showMe(){
	pplFinder.isOpen = true;
}

function ppf_formatFriend(index){
	str = '<div id="friend-'+index+'" data-id="'+index+'" class="pplFinderBox">';
		str += '<div class="pplFinderAvatarFrame"><img src="'+friendStack.avatar[index]+'&width=100"></div>';
		str += '<div class="pplFinderName">'+friendStack.username[index]+'</div>';
	str += '</div>';
	return str;
}

function ppf_pushFriends(){
	friendStack.outlet.empty();
	for(x = 0; x < friendStack.username.length; x++){
		friendStack.outlet.append( pplFinder.formatFriend(x) );
	}
	$('.pplFinderBox').bind('click', function(e){
		friendStack.index = e.currentTarget.dataset.id;
		friendStack.useName();
	});
}

function ppf_getMatches(){
	friends = theUser.friends;
	y = 0;
	for(x = 0; x < friends.length; x++){
		searchme = friends[x]['username'].toUpperCase();
		withthis = pplFinder.currentName.toUpperCase();		
		if(searchme.search(withthis) == 0){
			friendStack.addFriend(x, y);
			y++;
		}
	}
}

function ppf_getCurrentWord(key){
	str = pplFinder.input.val().toLowerCase().split(" ");
	str = str[str.length-1].substr(1)+String.fromCharCode(key).toLowerCase();
	pplFinder.currentName = str;
}

var friendStack = new Object();
friendStack.username = [];
friendStack.avatar = [];
friendStack.id = [];
friendStack.index = -1;
friendStack.isOpen = false;

friendStack.addFriend = fs_addFriend;
friendStack.clear = fs_clear;
friendStack.moveDown = fs_moveDown;
friendStack.moveUp = fs_moveUp;
friendStack.useName = fs_useName;
friendStack.closeMe = fs_closeMe;
friendStack.openMe = fs_openMe;
friendStack.takeControl = fs_controlBox;
friendStack.findNewFriends = fs_FindNew;
friendStack.toggleLight = fs_toggleLight;
friendStack.init = fs_init;

function fs_init(){
	if($('#pplContainer').length){ $('#pplContainer').remove();}
	pplFinder.input.after('<div id="pplContainer"></div>');
	friendStack.outlet = $('#pplContainer');
	friendStack.index = -1;
	friendStack.isOpen = false;
}

function fs_toggleLight(id){
	currentBox = $('#friend-'+id);
	if(currentBox.hasClass('pplSelected')){
		currentBox.removeClass('pplSelected');
	}else{
		currentBox.addClass('pplSelected');
	}
}

function fs_FindNew(){
	this.outlet.append('<div class="recommend"><a href="/wolfpack">Life is more fun with friends, follow some people :)</a></div>');
}

function fs_controlBox(){
	friendStack.init();
	pplFinder.input.unbind('keydown').bind('keydown', function(x){
		if(x.keyCode == 40){
			x.preventDefault();
			friendStack.moveDown();	
		}else if(x.keyCode == 38){
			x.preventDefault();
			friendStack.moveUp();	
		}else if(x.keyCode == 13){
			x.preventDefault();
			friendStack.useName();	
		}else if(x.keyCode == 32){
			friendStack.closeMe();
		}
		if(x.keyCode > 60){
			friendStack.clear();
			pplFinder.getCurrentWord(x.keyCode);
			pplFinder.getMatches();
			pplFinder.pushFriends();
			friendStack.openMe();
			if(friendStack.avatar.length < 1){
				friendStack.findNewFriends();
			}
		}
	});
}

function fs_openMe(){
	friendStack.controlBox;
	friendStack.outlet.slideDown(200);
	friendStack.outlet.hover(function(){friendStack.toggleLight(friendStack.index)}, function(){friendStack.toggleLight(friendStack.index)});
	friendStack.isOpen = true;
}

function fs_closeMe(){
	pplFinder.input.unbind('keydown');
	pplFinder.takeControl();
	friendStack.outlet.remove();
	friendStack.index = -1;
	friendStack.isOpen = false
}

function fs_useName(){
	str = pplFinder.input.val().split(" ");
	str = str.slice(0, str.length-1);
	str = str.toString()
	str = str.replace(/,/g, " ");
	str += ' @'+friendStack.username[friendStack.index];
	pplFinder.input.val(str);
	friendStack.closeMe();
}

function fs_moveDown(){
	if(friendStack.index <= friendStack.avatar.length){
		friendStack.index++;
	}
	friendStack.toggleLight(friendStack.index-1);
	friendStack.toggleLight(friendStack.index);
}
function fs_moveUp(){
	if(friendStack.index >= 0){
		friendStack.index--;
	}
	friendStack.toggleLight(friendStack.index+1);
	friendStack.toggleLight(friendStack.index);
}

function fs_clear(){
	friendStack.username = [];
	friendStack.avatar = [];
	friendStack.id = [];
}

function fs_addFriend(x, y){
	if(theUser.friends[x].username != undefined){
		friendStack.username[y] = theUser.friends[x].username;
		friendStack.avatar[y] = theUser.friends[x].avatar;
		friendStack.id[y] = theUser.friends[x].user_id;
	}
}

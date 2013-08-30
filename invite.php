<?php
	$pageTitle = "Activity";
	include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
	include "header.php";
	
	$menu = array(	array('title' => 'FACEBOOK', 'img' => 'menu_fb.png'), 
					array('title' => 'TWITTER', 'img' => 'menu_twitter.png'), 
					//array('title' => 'INSTAGRAM', 'img' => 'menu_google.png'),
					array('title' => 'EMAIL', 'img' => 'menu_custom.png')
				);
	
	$platform = ( !empty($_GET['platform']) ? $_GET['platform'] : 'none' );
?>

<style>
.invite-user-box{width:47%; height:100px; float:left; margin-left:2%; margin-bottom:2%;}
.invite-user-box-avatar-frame{ width: 75px;overflow: hidden;float: left;height: 80px;border-radius: 187px;margin-right: 10px;}
.invite-user-box-avatar-frame img{width:100%;}
.invite-user-info{ color: #acacac;}
.invite-user-button{background-color: #ba4f63; color: #fff; padding: 5px 28px;float: left;font-size: 11px; cursor:pointer;}
.invite-follow-button{padding: 5px 10px;margin: 0px auto;width: 60%;margin-top: 12px;cursor: pointer;}
.following{border: #c2c2c2 thin solid;color: #c2c2c2 !important;}
.follow{border: #c2c2c2 thin solid;color: #c2c2c2 !important;}
.invite-user-name{font-size: 17px;margin-bottom: 3px;}
#followFbFriends{width: 100%;float: left;height: 100%;}
</style>

<div id="theShaft">
	<div id="leftCol">
		<? foreach($menu as $item): ?>
        	<div id="menu-<?= $item['title'] ?>" class="activity-menu cursor highlightable" data-platform="<?= $item['title'] ?>">
            	<div class="activity-menu-icon" style="background-image: url(images/<?= $item['img'] ?>)">
                </div>
                <div class="activity-menu-title">
                	<?= $item['title'] ?>
                </div>
            </div>
		<? endforeach ?>
    </div>
    <div id="mainCol">
    </div>
	<div style="clear:both"></div>
</div>

<?php include "footer.php" ?>
<script>
var partyLine = new Object();
partyLine.getUsers = new Array;
partyLine.sendInvite = new Array;
partyLine.description = "Everything your momma warned you about";
partyLine.twitterUrl = "/action/getTwitterFollowers.php";
partyLine.isTwitterLoggedIn = <?= (TWITTER_IS_LOGGED_IN ? 'true' : 'false') ?>;
partyLine.twitterUsername = null;
partyLine.twitterMessengerBusy = false;

partyLine.users = new Array();// USR CLASS

partyLine.userTank = $('#mainCol');

partyLine.removeUser = function(id){
	$('#user-box-'+id).slideUp(200, function(){
		$(this).remove();
	});
}

partyLine.setTwitterAccount = function(){
	$.ajax('/action/getTwitterUserInfo.php').done(function(data){
		data = JSON.parse(data);
		partyLine.twitterUsername = data.screen_name;
		partyLine.getUsers['TWITTER']();
	});
}

partyLine.init = function(platform){// CLEARS MAIN COLUMN AND CALLS GET USERS
	partyLine.platform = platform;
	partyLine.userTank.empty();
    partyLine.userTank.append('<div id="followFbFriends"></div>');
	partyLine.users = [];
	partyLine.getUsers[platform]();
}

partyLine.user = function(name, id, image, platform){// USER CLASS
	this.name = name;
	this.id = id;
	this.image = image;
	this.platform = platform
}

partyLine.sendInvite['FACEBOOK'] = function(id){
	 FB.ui({
        method: 'send',
		to: id,
        name: 'You\'re Invited <3',
		picture: 'http://www.dahliawolf.com/images/logo_60x60.png',
		description: partyLine.description,
    	link: 'http://www.dahliawolf.com/index.html'
	});
}

partyLine.sendInvite['TWITTER'] = function(id){
	if(!partyLine.twitterMessengerBusy){
		partyLine.twitterMessengerBusy = true;
		$.post('/action/sendTwitterInvite', {'user_name': id}, function(data){
			partyLine.twitterMessengerBusy = false;
		});
	}
}

partyLine.sendInvite['EMAIL'] = function(){
    var emails = $('#emailCollection').val().trim().split(",");
    var mess = $('#personalMessage').val().trim();
    var areEmailsValid = true;

    $.each(emails, function(index, mail) {
        if(!validateEmail(mail.trim())) {
            alert(mail + ' is not a valid email');
            areEmailsValid = false;
        }
    });

    if(areEmailsValid && theUser.id){
        if(emails != '') {
            $.post('/action/sendInviteEmails.php', {emails : emails, message : mess, user_email : userConfig.email_address }, function(data){
                $('#emailCollection').val('');
                $('#personalMessage').val('');
                alert('Invites Sent');
            });
        } else {
            alert('Please enter an email address');
        }
    }
}

partyLine.getUsers['GOOGLE'] = function(){
	alert('Google Invite is not ready yet :)');
}

partyLine.getUsers['EMAIL'] = function(){
	partyLine.userTank.load('/templates/invite-email.php', function() {
        $('#emailSubmitButton').unbind();
        $('#emailSubmitButton').on('click', partyLine.sendInvite['EMAIL']);
    });
}

partyLine.getUsers['FACEBOOK'] = function(){// GET FACEBOOK USER METHODS
	FB.api('/me/friends', function(response) {
        dahliaLoader.show();
        if(response.data) {
            dahliaLoader.hide();
			$.each(response.data,function(index,friend) {
                partyLine.users[index] = new partyLine.user(friend.name, friend.id, 'http://graph.facebook.com/'+friend.id+'/picture?type=large', 'FACEBOOK');
            });
			partyLine.displayUsers();
        } else {
            document.location = "/social-login.php?social_network=facebook";
        }
    });
}

partyLine.getUsers['INSTAGRAM'] = function(){// GET FACEBOOK USER METHODS
	$.ajax('https://api.instagram.com/v1/users/self/followed-by?access_token='+userConfig.instagramToken+'&callback=callbackFunction', {dataType : "jsonp"}).done(function(data){
		$.each(data.data,function(index,friend) {
			partyLine.users[index] = new partyLine.user(friend.full_name, friend.username, friend.profile_picture, 'INSTAGRAM');
		});
		partyLine.displayUsers();
	})
}

partyLine.getUsers['TWITTER'] = function(cursor){
	if(!cursor){cursor = -1;}
	if(partyLine.isTwitterLoggedIn){
		if(partyLine.twitterUsername != null){
			$.post(partyLine.twitterUrl, {'cursor' : cursor, 'screen_name' : partyLine.twitterUsername }).done(function(data){
				obj = JSON.parse(data);
				if(!obj.errors){
					cursor = obj.next_cursor;
					obj = obj['users'];
					$.each(obj,function(index,friend) {
                        partyLine.users[index] = new partyLine.user(friend.name, friend.screen_name, friend.profile_image_url, 'TWITTER');
					});
					partyLine.displayUsers();
					if(cursor != 0){
						partyLine.getUsers['TWITTER'](cursor);
					}
				}else{
					alert(obj.errors[0].message);
				}
			});
		}else{
			partyLine.setTwitterAccount();
		}
	}else{
		document.location = '/redirect.php';
	}
}

partyLine.displayUsers = function(){
	$('#theShaft').css('height', 'auto');
	$.each(partyLine.users,function(index,friend) {
        var user = dahliawolf.isFacebookFriend(friend.id);
        if( user ) {
            holla.log(user);
            str = '<div id="user-box-'+friend.id+'" class="invite-user-box">';
            str+='<div class="invite-user-box-avatar-frame">';
            str += '<img src="'+friend.image+'">';
            str+='</div><div class="invite-user-info">';
            str+='<div class="invite-user-name">'+friend.name+'</div>';
            str+='<div class="invite-follow-button '+(Number(user.is_followed) ? 'following' : 'follow')+'" data-id="'+friend.id+'" data-platform="'+friend.platform+'">FOLLOW</div>';
            str+='</div></div>';
            $('#followFbFriends').append(str);
        } else {
            str = '<div id="user-box-'+friend.id+'" class="invite-user-box">';
            str+='<div class="invite-user-box-avatar-frame">';
            str += '<img src="'+friend.image+'">';
            str+='</div><div class="invite-user-info">';
            str+='<div class="invite-user-name">'+friend.name+'</div>';
            str+='<div class="invite-user-button" data-id="'+friend.id+'" data-platform="'+friend.platform+'">INVITE</div>';
            str+='</div></div>';
            partyLine.userTank.append(str);
        }
	});
	partyLine.userTank.append('<div class="clear"></div>');
	partyLine.bindMessageButtons();
}

partyLine.bindMessageButtons = function(){
	$('.invite-user-button').bind('click', function(){
		partyLine.sendInvite[ $(this).data('platform') ]( $(this).data('id') );
		partyLine.removeUser( $(this).data('id') );
	});
}

$('.activity-menu').bind('click', function(){
	if(theUser.id){
		$('.activity-menu').removeClass('invite-selected');
		$(this).addClass('invite-selected');
		partyLine.init( $(this).data('platform') );
	}else{
		new_loginscreen();
	}
});

$(function(){
	openPlatform = '<?= $platform ?>';
	
	if(openPlatform != 'none'){
		$('#menu-'+openPlatform).click();
	} else {
        setTimeout( function() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    $('#menu-FACEBOOK').click();
                } else if (response.status === 'not_authorized') {
                    // the user is logged in to Facebook,
                    // but has not authenticated your app
                } else {
                    // the user isn't logged in to Facebook.
                }
            });
        }, 1000);
    }
});
</script>
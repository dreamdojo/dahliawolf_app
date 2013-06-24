<?
	$username = !empty($_SESSION['user']) && !empty($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';
?>
<body>
<div id="loadme"></div>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    
    FB.init({
	  appId: '552515884776900',
	  status: false,
	  cookie: true,
	  oauth  : true,    
	  channelUrl : 'http://www.dahliawolf.com/channel.php',
	  xfbml: true
	  });

    FB.Event.subscribe('auth.login', function(response) {
           
    });	
    FB.Event.subscribe('edge.create',
        function(response) {
            $.ajax({
                type: 'POST',
                url:'http://www.dahliawolf.com/facebookshare.php',
                data: ""

            });
      });      

};

  // Load the SDK's source Asynchronously
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));
</script>


<script type="text/javascript">
$(document).ready(function()
{
    $("#ScrollToTop").click(function()
    {
        $(window).scrollTop(0);

        return false;
    });
    function scrollToTopCheck() {
        if ($(window).scrollTop() > 500) $("#ScrollToTop").show();
        else $("#ScrollToTop").hide();
    }
    $(window).scroll(scrollToTopCheck);
    scrollToTopCheck();
    // Fancy Form
    $(".FancyForm input[type=text], .FancyForm input[type=password], .FancyForm textarea").each(function() {
        if ($(this).val()) $(this).addClass("NotEmpty");
    }).change(function() {
        if ($(this).val()) $(this).addClass("NotEmpty");
        else  $(this).removeClass("NotEmpty");
    });
})
</script>
<?php
$menu_vote = false;
$menu_post = false;
$menu_explore = false;
$menu_shop = false;
if($self == "/post-feed.php" || $self == "/post-details.php"){
	$menu_vote = true;
}
if($self == "/post-bank.php"){
	$menu_post = true;
}
if($self == "/index.php" || $self == "/explore.php"){
	$menu_shop = true;
}
?>

<style>
	#feed-nav{
		background: url(<?= DAHLIAWOLF_MOBILE ?>images/butt_feed<?= ($menu_feed ? '_on':'') ?>.jpg) no-repeat center center;
		background-size: auto 100%;
	}
	#post-nav{
		background:url(<?= DAHLIAWOLF_MOBILE ?>images/butt_post<?= ($menu_post ? '_on':'') ?>.jpg) no-repeat center center;
		background-size: auto 100%;
	}
	#explore-nav{
		background:url(<?= DAHLIAWOLF_MOBILE ?>images/butt_explore<?= ($menu_explore ? '_on':'') ?>.jpg) no-repeat center center;
		background-size: auto 100%;
	}
	#shop-nav{
		background:url(<?= DAHLIAWOLF_MOBILE ?>images/butt_shop<?= ($menu_shop ? '_on':'') ?>.jpg) no-repeat center center;
		background-size: auto 100%;
	}
	#alert-box{position: fixed;z-index: 1000;top: 36%;width: 100%;text-align: center; display:none;}
	#alert-box img{width: 60%; opacity:.9;}
	#alert-box .mess{position: absolute;width: 100%;color: #fff;font-size: 1em;top: 71%;z-index: 100;}
	#swipe-back{height:95%; top:5%; position:absolute; width:15%; right:-15%;width: 18%;right: -18%;}
	#showActivity{position: absolute;right: 0px;height: 100%;width: 10%;top: 0px;background-image: url(/mobile/images/posty_avatar.png);background-repeat: no-repeat;background-size: auto 50%;margin-top: 9px;}
	
	#loginPage{ position:fixed; width:100%; height:100%; background-color:#fff; left:0px; bottom:-100%; display:none;z-index: 99999999999; text-align:center;}
	#loginPage input{min-width:0px;width: 100%;background-color: #fff;border-radius: .4em;font-size: 1em;-webkit-appearance:none;} 
	.faceBookLoginPlace{width:80%;margin: 0px auto;padding-top: 10%;}
	.faceBookLoginPlace img{width:100%;}
	#loginErrorCode{ font-size:1em; margin-top:5%; color:red; height:5px;}
	#signUpForm li{padding: 5px 0 !important;}
	#closeLoginPop{ position:absolute; right:1%; top:2px; font-size:2em;}
	#loginForm{margin: 5px 0 !important;}
	#toggleLoginType{position: absolute;right: 7%;bottom: 6%;color: rgb(100, 100, 100);font-size: 1.2em; font-family:Arial, Helvetica, sans-serif;}
</style>

<div id="loginPage">
 	<div id="closeLoginPop">X</div>
    <div id="loginErrorCode"></div>
    <div class="faceBookLoginPlace">
        <a href="/social-login.php?social_network=facebook">
            <img src="/skin/img/signinfacebook.png">
        </a><p id="loginMsg" style="font-size: 17px;color: rgb(100, 100, 100);margin-top: 20px;">or sign up with email:<p />
    </div>
    <form id="signUpForm" method="POST" class="Form FancyForm AuthForm StaticForm hidden" action="action/signup.php" style="margin-top:8px;">
            <ul>
               <li>
                    <input class="input_text" type="text" name="user_username" id="sysForm_user_username" value="" placeholder="USERNAME" />
               </li>
               <li>
                    <input class="input_text" type="text" name="user_email" id="sysForm_user_email" value="" placeholder="EMAIL" />
                </li>
                <li>
                    <input class="input_text" type="password" name="user_password" id="sysForm_user_password" value="" placeholder="PASSWORD" />
                </li>
                <li>
                	<input type="image" src="images/s-up.jpg" id="sysForm_submit"/>
                    
                </li>  
            </ul>
             <input type="hidden" name="r" value="" />
             <input type="hidden" name="jsub" value="1" />
             <? if (!empty($_GET['session_type'])): ?>
                <input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
             <? endif ?>
        </form>
        
        <form id="loginForm" method="POST" class="Form StaticForm login-form" action="action/login.php">
            <fieldset>
                <ul class="fields">
                    <li>
                        <input class="input_text" type="text" name="identity" id="sysForm_identity" value="" placeholder="EMAIL" />
                    </li>
                    <li>
                        <input class="input_text" type="password" name="credential" id="sysForm_credential" value="" placeholder="PASSWORD" />
                    </li>
                </ul>
            </fieldset>
            <div class="non_inputs"></div>
                <input type="image" src="images/login-butt.jpg" id="sysForm_submit">
            <div class="non_inputs">
                <!--<a href="/mobile/signup.php?session_type=<?//= $_GET['session_type'] ?>" id="urlGetInvite" class="colorless">Sign up now!</a>-->
                <!--<a href="/mobile/reset-password.php?session_type=<?// $_GET['session_type'] ?>" id="resetPassword" class="colorless">Forgot your password?</a>-->
            </div>
            <input type="hidden" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
            <input type="hidden" name="r" value="" />
            <input type="hidden" name="sublog" value="1" />
            <? if (!empty($_GET['session_type'])) { ?>
                <input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
            <? } ?>
        </form>
        <div id="toggleLoginType">Register</div>                    
</div>

<a name="top"></a>
<div id="user-dd" class="optimize-me">
    <div id="swipe-back" class="hidden"></div>
    <div style="opacity: .9;float: right;font-size: 30px;text-align: right;margin-top: 20%; font-weight: lighter;margin-right: 40px;"/>
    	<a style="color:gray;" href="<?= DAHLIAWOLF_MOBILE ?>profile.php?username=<?= $_SESSION['user']['username'] ?>&session_type=web"><p style="margin-bottom:20px;">Profile <img style="width: 30px;" src="<?= DAHLIAWOLF_MOBILE ?>images/menu_button_1.png"></p></a>
        <a style="color:gray;" href="<?= DAHLIAWOLF_MOBILE ?>wolf-pack.php?session_type=web"><p style="margin-bottom:20px;">Wolfpack <img style="width: 30px;" src="<?= DAHLIAWOLF_MOBILE ?>images/menu_button_2.png"></p></a>
        <a style="color:gray;" href="<?= DAHLIAWOLF_MOBILE ?>how-it-works.php?session_type=web"><p style="margin-bottom:20px;">How it works <img style="width: 30px;" src="<?= DAHLIAWOLF_MOBILE ?>images/menu_button_3.png"></p></a>
    	<a style="color:gray;" href="<?= DAHLIAWOLF_MOBILE ?>account/settings.php?session_type=web"><p style="margin-bottom:20px;">Settings <img style="width: 30px;" src="<?= DAHLIAWOLF_MOBILE ?>images/menu_button_4.png"></p></a>
    </div></div>

<? require $_SERVER['DOCUMENT_ROOT'] . '/mobile/activity.php' ?>

<style>
#inspirePage{position:fixed; height:100%; width:100%; left:0px; top:100%; display:none;z-index: 1100000000; overflow: scroll !important;padding-top: 90px;
background:url(/mobile/images/image-bank-graphic.png) no-repeat; background-position: 50% 150px;background-size: 90% auto; background-color:white;}
#topInspireMenu{position:fixed; width:100%; height:40px; top:0px; background-color:#fcfcfc; display:none;z-index: 1000;}
#inspireMenu{position:fixed; width:100%; height:60px; left:0px; top:40px; display:none; background-color:#8a8b8d;z-index: 1000;}
.inspireMenu-option{width: 33.333333%; height:100%; float:left; position:relative;}
#inspireDwolfBank{background:url(/mobile/images/menu-icon-dw.png) no-repeat; background-position: 50% 50%;background-size: auto 60%; background-color:#fff;}
#inspireCamera{background:url(/mobile/images/menu-icon-cam.png) no-repeat; background-position: 50% 50%;background-size: auto 60%; background-color:white; position:relative;}
#inspireCameraRoll{background:url(/mobile/images/menu-icon-roll.png) no-repeat; background-position: 50% 50%;background-size: auto 60%; background-color:white;}
.gridzy{float: left;width:48%;height: 200px;overflow: hidden;text-align: center; margin-left:1%; margin-right:1%; margin-top:5px; position:relative;}
.gridzy img{width:100%;}
.artzy{float: left;width: 98%;overflow: hidden;text-align: center;margin-top: 10px;position: relative;}
.artzy img{max-width:100%;}
.scrollable{overflow:scroll !important;}
.unscrollable{overflow:hidden !important;}
#closeInspirePage{position: relative;
height: 60%;
width: 25%;
font-family: helvetica;
text-align: center;
margin-bottom: 1%;
margin-top: 1%;
margin-right: 2%;
float: right;
/*background-image: url(/mobile/images/close_button.png);
background-size: auto 100%;
background-repeat: no-repeat;*/
font-size: 18px;
color: rgb(179, 179, 179);
font-weight: 100;
border: 1px solid rgb(202, 202, 202);
padding: 1%;}
#inspectahPost{position:fixed; width:100%; height:100%; background-color:#000; z-index:10000000002; display:none; left:0px; top:0px;}
#inspectahPost img{width: 96%;margin-top: 1%;margin-left: 2%;}
#inspectahPost .butt{background-color: rgb(70, 70, 70);height: 20px;width: 20%;position: absolute;border: #FFF .4em solid;border-radius: .5em;top: 40px;text-align: center;opacity: .7;padding-top: 5px;color: #fff;}
#closeInspection{left:5%;}
#postImage{right:5%;}
#gridToggle{float:left; height: 76%;margin-top: 1%;width: 10%; margin-right:4%;background:url(/mobile/images/insp-grid.png) no-repeat; background-size:auto 100%;margin-left: 2%;}
.carot{background:url(/mobile/images/carot.png) no-repeat; background-size:100% 100%; position:absolute; top:100%;width: 30%;height: 20px;left: 35%;}
.post-post{position: absolute;color: #303030;top: 30%;text-align: center;width: 100%;font-size: 2.8em;}
.post-post span{font-size: .7em;}
.postedOverlay{position:absolute; width:100%; height:100%; top:0px; left:0px; background-color:#fff; opacity:.6;}

</style>
<div id="inspectahPost">
	<div class="butt" id="closeInspection">DONE</div>
    <div class="butt" id="postImage" data-id="0">POST +</div>
</div>
<div id="inspirePage">
	<div id="topInspireMenu">
        <div id="gridToggle"></div>
    	<div id="closeInspirePage">CLOSE</div>

    </div>
    <div id="inspireMenu" class="drop-shadow">
    	<div id="inspireDwolfBank" class="inspireMenu-option"><div class="carot"></div></div>
        <div id="inspireCamera" class="inspireMenu-option" onClick="$('#file').click();">
        	<form action="../action/post_image.php" id="thePinForm" method="POST" enctype="multipart/form-data">
                 <input type="file" name="iurl" id="file" onChange="$('#thePinForm').submit()">
            </form>
        </div>
    	<div id="inspireCameraRoll" class="inspireMenu-option" onClick="$('#file').click();"></div>
    </div>
</div>

<div id="loading-bar">
	<img src="images/loading3.gif">
</div>
   
<div id="view-port">
<div class="header">
        <? if(IS_LOGGED_IN): ?>
            <div id="main-menu-button">
                <img src="/mobile/images/main_menu_butt.png" />
            </div>
        <? endif ?>
        
       	 <div class="header_logo" onClick="goHere('post-details.php', true);"></div>  
        
        <? if (!IS_LOGGED_IN): ?>
            <div class="login-place">
            	<span>Login</span>
           </div>
        <? else: ?>
        	<div id="showActivity" onClick="theLog.showMe();"></div>
		<? endif ?>     
</div>

<style>
#bottom-nav{background-image:url(/mobile/images/unselected_bg.png); background-repeat:repeat-x; background-size:33.3% 100%;position: fixed;width: 100%;height: 50px;bottom: -5px;text-align: center;z-index: 100000001;text-align: center;color: red;display: inline-block;left: 0%;margin: 0px;border-bottom: #000 5px solid;}
#vote-butt{height:100%; width:33%; float:left;background: url(http://www.dahliawolf.com/mobile/images/bottom-menu-heart-off.png) no-repeat center center; background-size: auto 90%; margin-top: .2em; position:relative;}
.vote-butt-on{background: url(http://www.dahliawolf.com/mobile/images/bottom-menu-heart-on.png) no-repeat center center !important; background-size: auto 100% !important;}
.shop-butt-on{background: url(http://www.dahliawolf.com/mobile/images/bottom-menu-cart-on.png) no-repeat center center !important; background-size: auto 100% !important;}
.post-butt-on{background: url(http://www.dahliawolf.com/mobile/images/bottom-menu-post-on.png) no-repeat center center !important; background-size: auto 100% !important;}
#post-butt{height: 100%; margin-top: .2em; width:33%; float:left; background-image: url(http://www.dahliawolf.com/mobile/images/postbutt_bg.png); background-repeat: no-repeat; background-position:center center; background-size: auto 100%; position:relative;}
#shop-butt{height:100%; width:33%; float:left; background: url(http://www.dahliawolf.com/mobile/images/bottom-menu-cart-off.png) no-repeat center center; background-size: auto 90%; margin-top: .2em; position:relative;}
.info-wrap{padding-top: 6%;}
.pm-logo{float: left;margin-left: 20%;margin-top: -3%;}
.pm-logo img{height:60%;}
.pm-title{float: left; margin-top: 2%;}
#loading-bar{height:10%; background-color:#666; opacity:.8; width:100%; position:fixed; bottom: 0px;z-index: 10000000000; text-align:center; display:none;}
#loading-bar img{height:100%;}
#file{position: absolute;width: 200%;height: 100%;left: 0px;opacity: 0;}
.menu-button-selected{width:34%; height:100%; background: url(http://www.dahliawolf.com/mobile/images/selected_bg.png) no-repeat center center; background-size: 100% 100%;position: absolute;}
</style>


<div id="bottom-nav">
	<? if($self == '/post-bank.php' || $self == '/post-details.php' || $self == '/explore.php'): ?>
    	<? $leftness = array('/post-bank.php' => 0, '/post-details.php' => 33, '/explore.php' => 66); ?>
        <div class="menu-button-selected" style="left:<?= $leftness[$self] ?>%;"></div>
    <? endif ?>
    <div id="post-butt" class="<?= ($menu_post ? 'post-butt-on' : '') ?>" onClick="inspirePage.showMe();"></div>
    <div id="vote-butt" class="<?= ($menu_vote ? 'vote-butt-on' : '') ?>" onClick="goHere('post-details.php', true);"></div>
    <div id="shop-butt" class="<?= ($menu_shop ? 'shop-butt-on' : '') ?>" onClick="goHere('explore.php', true);"></div>
</div>

<div id="alert-box">
	<div class="mess" id="theMess"></div>
	<img src="<?= DAHLIAWOLF_MOBILE ?>images/alert-bg.png"> 
</div>
<script>
$(function(){
	_userLogin = new userLogin();
});

var Menu = new Object;
var User = new Object;
Menu.visible = false;
Menu.percentSeen = 85;
Menu.speed = 100;

<? if(isset($username) && $username != ''): ?>
	User.name = '<?= $username ?>';
	User.id = '<?= $_SESSION['user']['user_id'] ?>';
<? endif ?>


//**************** POST BUTTON ***************
post = new Object();
post.isOpen = false;
post.button = $('#post-butt');
post.menuView = $('#post-menu');
post.speed = 200;
//***************   MENU   *************************
$('#swipe-back').bind('click', menuClose);
$('#swipe-back').bind('movestart', function(e){
	e.stopPropagation();
}).bind('moveend', function(e){
	if(e.distX < -20){
		menuClose();
	}
});
$('#main-menu-button').bind('click', function(){
	if(!Menu.visible && User.name != '' && User.name){
		menuOpen();
		return;
	}else if(Menu.visible && User.name != ''){
		menuClose();
		return;
	}
	else if(User.name == '' || !User.name){
		document.location = '/mobile/login.php?session_type=web';
	}
});
function menuOpen(){
	$('#user-dd').animate({left:0+'%'}, Menu.speed);
	$('.ColumnContainer').animate({left:Menu.percentSeen+'%'}, Menu.speed);
	$('#view-port').css('position', 'absolute').css('overflow', 'hidden');
	$('#view-port').animate({left: Menu.percentSeen+'%'}, Menu.speed);
	$('#middlebutton').animate({left: Menu.percentSeen+'%'}, Menu.speed)
	$('#swipe-back').removeClass('hidden');
	Menu.visible = true;
}
function menuClose(){
	$('#user-dd').animate({left:'-'+Menu.percentSeen+'%'}, Menu.speed);
	$('.ColumnContainer').animate({left:0+'%'}, Menu.speed);
	$('#view-port').css('position', 'static').css('left', 0+'%').css('overflow', 'visible');
	$('#middlebutton').animate({left: 0+'%'}, Menu.speed);
	$('#swipe-back').addClass('hidden');
	Menu.visible = false;
}


function sendUserMessage(msg){
	$('#theMess').empty().html(msg);
	$('#alert-box').fadeIn(600, function(){
		setTimeout(function(){
			$('#alert-box').fadeOut(500);
		}, 2000);
	});
}

</script>
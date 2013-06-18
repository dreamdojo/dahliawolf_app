<!-- <a style="" id="GoToMain" href="http://www.dahliawolf.com/" class="Button WhiteButton Indicator"><strong>Home</strong><span></span></a> -->

<div style="width:930px;margin-left: auto ;
  margin-right: auto ;">
<!--  uncomment to show social login
<div style="margin-bottom:19px; width:310px; float:left;"><a href="https://www.facebook.com/dialog/permissions.request?app_id=552515884776900&display=page&next=http://www.dahliawolf.com/&response_type=code&fbconnect=1&perms=email,offline_access,publish_stream"><img src="img/login/facebookbutton.jpg" width="310" height="67" border="0" /></a></div>
<div style="margin-bottom:19px; float:left; width:310px;"><a href="http://www.dahliawolf.com/oauth/redirect.php"><img src="img/login/twitterbutton.jpg" width="310" height="67" border="0" /></a></div>
<div style="margin-bottom:19px; float:left; width:310px;"><a href="http://www.dahliawolf.com/instagram_connect.php"><img src="img/login/instagrambutton.jpg" width="310" height="67" border="0" /></a></div>
-->
<div style="clear:both"></div>
</div>


<p class="auth_text" style="font-size:24px; font-size: 24px;
padding-top: 100px;
border-bottom: #000 8px solid;
width: 80%;
margin-left: 59px;">Login using your e-mail address.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm">
    <ul>
        <li>
        	<input class="input_text" type="text" name="identity" id="sysForm_identity" value="" />
            <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
        </li>
        <li>
        	<input class="input_text" type="password" name="credential" id="sysForm_credential" value="" />
        	<label for="sysForm_credential">Password</label>
        	<span class="fff"></span>
        </li>  
        <li>
        	<input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1" />
        	<span style="font-size:16px; color:#666"> Remember me</span>
        </li>   
    </ul>
    <div class="non_inputs" style="margin-left: 60px;">
    	<input type="submit" value="Log in" class="Button_input" id="sysForm_submit" style="height: 31px !important;width: 100px;"/>
                <a href="http://www.dahliawolf.com/signup" id="urlGetInvite" class="colorless">Sign up now!</a>
            	<a href="http://www.dahliawolf.com/lost" id="resetPassword" class="colorless">Forgot your password?</a>
    </div>
     <input type="hidden" name="r" value="" />
     <input type="hidden" name="sublog" value="1" />
</form>
</div>
</body>
</html><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
<head>
<title>Login - Dahlia Wolf</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Login - Dahlia Wolf - Dahlia Wolf">
<meta name="keywords" content="Login,Dahlia Wolf,Dahlia Wolf">
<link rel="icon" href="http://www.dahliawolf.com/favicon.ico" type="image/x-icon" />
<meta property="fb:app_id" content="552515884776900"/>
<meta property="og:site_name" content="Dahlia Wolf"/>
<meta property="og:image" content="http://www.dahliawolf.com/img/logo_190x190.jpg"/>
<meta name="viewport" content="width=640, height=960, user-scalable = no"/>
<link rel="apple-touch-icon" href="/icon.png"/>
<link rel="apple-touch-startup-image" href="/load_screen.jpg" />
<meta name="apple-mobile-web-app-capable" content="yes" />  
<link href="http://www.dahliawolf.com/js/jquery-ui/style/style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="http://www.dahliawolf.com/css/jquery/jcarousel/pin-create-img-picker.css" media="screen" rel="stylesheet" type="text/css" />
<link href="http://www.dahliawolf.com/css/face/main_mobile.css" media="screen" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=La+Belle+Aurore' rel='stylesheet' type='text/css'>
<!--[if IE 7]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<!--[if IE 8]> <link href="http://www.dahliawolf.com/css/face/ie.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
<link href="http://www.dahliawolf.com/css/jquery/jquery.fancybox-1.3.4.css" media="screen" rel="stylesheet" type="text/css" />
<link href="http://www.dahliawolf.com/js/jquery-ui/style/tipTip.css" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery-plugins/jquery.url.packed.js"></script>
<script src="http://www.dahliawolf.com/js/m_functions.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/app.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery-ui/jquery-ui.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery-plugins/jquery.caret.1.02.min.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/nav.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery-plugins/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/jquery-plugins/jquery.tipTip.minified.js"></script>
<script type="text/javascript">var base_url = "http://www.dahliawolf.com";</script>
<script type="text/javascript" src="http://www.dahliawolf.com/js/custom.js"></script>
<script src='http://connect.facebook.net/en_US/all.js'></script>
<script src="http://www.dahliawolf.com/js/jquery.form.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>
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
<div id="user-dd">
    <div class="user-dd-menu-title"></div>
    <ul>
    	<a href="http://www.dahliawolf.com/"><li>MY PROFILE</li></a>
        <a href="http://www.dahliawolf.com/mypins"><li>MY POSTS</li></a>
        <a href="http://www.dahliawolf.com/mylikes"><li>MY WILD 4'S</li></a>
        <a href="http://www.dahliawolf.com/invite_friends"><li>MY INVITES</li></a>
        <a href="http://www.dahliawolf.com/settings"><li>MY SETTINGS</li></a>
    </ul>
    <div class="user-dd-menu-title">DAHLIAWOLF</div>
    <ul>
    	<a href="http://www.dahliawolf.com/wolfpack.php"><li>WOLFPACK</li></a>
        <a href="http://www.dahliawolf.com/help"><li>HOW IT WORKS</li></a>
    </ul>
    <div class="user-dd-menu-title">SYSTEM</div>
    <ul>
    	<a href="http://www.dahliawolf.com/log_out"><li>LOGOUT</li></a>
    </ul>
</div>
   
<div class="header">
    <div class="HeaderContainer">
        <div class="HeaderContents">
            <div id="main-menu-button">
            	<img src="http://www.dahliawolf.com/skin/img/mobile/main_menu_butt.png" />
            </div>
            <div class="header_logo">
            	<a href="http://www.dahliawolf.com"><img src="http://www.dahliawolf.com/skin/img/logo.png" ></a>
            </div>       
        </div>
   </div>
</div>

 <div id="middlebutton">
    <div class="marginmiddlebutton"><p>VOTE</p></div>
        	<div class="marginmiddlebutton"><p>POST</p></div>
        <div class="marginmiddlebutton" style="border:none;"><p>SHOP</p></div>
</div>

<script>
var Menu = new Object;
var User = new Object;
Menu.visible = false;
Menu.percentSeen = 88;
User.name = '';
redirect = '';

function doPost(){
	if(redirect == 'show'){
		$('#post-screen').slideDown(200);
	}else{
		document.location = 'http://www.dahliawolf.com';
	}
}

$('#main-menu-button').bind('click', function(){
	if(!Menu.visible && User.name != ''){
		$('#user-dd').animate({left:0+'%'}, 100);
		$('.header').animate({left:Menu.percentSeen+'%'}, 100);
		$('#middlebutton').animate({left:Menu.percentSeen+'%'}, 100);
		$('.ColumnContainer').animate({left:Menu.percentSeen+'%'}, 100);
		Menu.visible = true;
		return;
	}else if(Menu.visible && User.name != ''){
		$('#user-dd').animate({left:'-'+Menu.percentSeen+'%'}, 100);
		$('.header').animate({left:0+'%'}, 100);
		$('#middlebutton').animate({left:0+'%'}, 100);
		$('.ColumnContainer').animate({left:0+'%'}, 100);
		Menu.visible = false;
		return;
	}
	else if(User.name == ''){
		document.location = 'http://www.dahliawolf.com/login';
	}
});
</script>

<body>
    <div id="body-wrap">
    <div id="tooltip-overlay" style="position:fixed; width:100%; height:100%; top:0px; left:0px; background-color:#000; opacity:.72; display:none; z-index:101"></div>
	<a name="top"></a>
    <div id="post-screen" class="blackout">
    	<div class="fbw-wrap">
        	<div class="filter-butt-wrap"><img src="/skin/img/btn/my-comp-butt.png" class="filter-butt" onclick="$('#user-upload-page').show();"></div>
        	<div class="filter-butt-wrap"><img src="/skin/img/btn/pinterest-on.png" class="filter-butt" onclick="refillImages('pinterest');"></div>
        	<div class="filter-butt-wrap"><img src="/skin/img/btn/instagram-on.png" class="filter-butt" onclick="refillImages('instagram')"></div>
        </div>
    </div>
    
    <div id="upload-box"></div>
    <div id="loadPage" class="blackout">"LOADING..."</div>
    <div id="user-upload-page" class="blackout">
    	<div class="fbw-wrap">
        	<form action="http://www.dahliawolf.com/uploadpin.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">
            <input type="hidden" id="thebname" value="Type new board name here">
            <input type="hidden" name="subpin" value="1">
            <input type="file" name="iurl" id="file" accept="image/*;capture=camera" style="display:none" onchange="preview_image(this);">
            
            <div class="filter-butt-wrap"><img src="/skin/img/btn/my-comp-butt.png" class="filter-butt" onclick="$('#file').click();"></div>
                                    <div class="filter-butt-wrap"><img src="/skin/img/btn/pinterest.png" class="filter-butt" id="pintUserFeed"></div>
                                        </div>
         <div class="img-uploader-image">       
            <div id="uploader-img-frame">
            	<img src="/skin/img/default.png" id="uploader-img" />
            </div>
            <textarea name="comment" id="comment">#dahliawolf</textarea>
            <input name="submit" type="image" src="/skin/img/postitbtn2.png" id="uploader-sub">
        </div>
        </form>
    </div>    <div class="ColumnContainer">
        		
	<script type="text/javascript">
	function loginscreen(what){
        $('#mask').fadeIn(500);        
        $('#mask').fadeTo("slow",0.8);
        var winH = $(window).height();
        var winW = $(window).width();
	$("#UnauthCallout").css('top',  winH/2-$("#UnauthCallout").height()/2);
        $("#UnauthCallout").css('left', winW/2-$("#UnauthCallout").width()/2);
		if(what=="login"){
			$("#signinbox").css("display","none")
			$("#loginbox").css("display","block")
		}else if(what=="signup"){
			$("#loginbox").css("display","none")
			$("#signinbox").css("display","block")
		}else{
			$("#loginbox").css("display","none")
			$("#signinbox").css("display","block")
		}
        $("#UnauthCallout").fadeIn(1000); 
	}

         $(document).ready(function(){
		$('#mask').click(function (e) {
			e.preventDefault();
			$('#mask').hide();
			$('#UnauthCallout').hide();
		}); 
		$('#closebtn').click(function (e) {
			e.preventDefault();
			$('#mask').hide();
			$('#UnauthCallout').hide();
		});
		
		 
	
	
    });
	function openlogin(){
		$("#loginbox").css("display","block");
		$("#signinbox").css("display","none");
		}
    </script>
    
    <div id="mask"></div>
    <div id="UnauthCallout" style="display:none; height:550px;width:650px;">
        <div class="Nag">
            <div class="Sheet1 Sheet">
                <div class="login-frame">
                    <div style="float:right;"><a href="#" id="closebtn"><img src="skin/img/closewhite.png" height="32" width="32" /></a></div>
                    <div style="clear:both"></div>
                   <div id="signinbox" style="display:none;">
                       <div style="width:315px; margin:0 auto; margin-top: 25px;">
                            <div style="margin-bottom:9px; margin-top: 2px; ">
                        	<img src="skin/img/signup_title.png" width="288" height="48" />
                            </div>
                            <div style="margin-bottom:20px; margin-top: 35px;"><a href="https://www.facebook.com/dialog/permissions.request?app_id=552515884776900&display=page&next=http://www.dahliawolf.com/&response_type=code&fbconnect=1&perms=email,offline_access,publish_stream"><img src="skin/img/signinfacebook.png" width="304" height="66" /></a>
                            </div>
                            <div style="margin-bottom:20px;"><a href="http://www.dahliawolf.com/instagram_connect.php"><img src="skin/img/signininstagram.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div style="margin-bottom:20px;"><a href="http://www.dahliawolf.com/oauth/redirect.php"><img src="skin/img/signintwitter.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div><a href="http://www.dahliawolf.com/signup.php"><img src="skin/img/signinemail.png" width="304" height="66" /></a></div>
                            <div style="clear:both;"></div>
                            <div style="margin-top: 20px">
                            	<div style="float:left; padding-top:3px; padding-left:75px;">
                            	<img src="skin/img/alreadycreative.png" width="106" height="12" />
                                </div>
                                <div style="float:right; padding-right:70px;">
                                <a href="#" onclick="openlogin();"><img src="skin/img/logintxt.png" width="55" height="14" /></a>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                    </div>
                    <div id="loginbox" style="display:none;" >
                       <div style="width:315px; margin:0 auto; margin-top: 25px;">
                           <div style="padding-left: 7px;">
                                <div style="margin-bottom:9px; margin-top: 2px; margin-left: -100px;">
                                    <img src="skin/img/welcomeback.png" width="489" height="48" />
                                </div>
                     
                           </div>
                           <div style="margin-top: 35px;">
                               <div style="margin-bottom: 20px;"><a href="https://www.facebook.com/dialog/permissions.request?app_id=552515884776900&display=page&next=http://www.dahliawolf.com/&response_type=code&fbconnect=1&perms=email,offline_access,publish_stream"><img src="skin/img/signinfacebook2.png" width="304" height="66" /></a></div>
                               <div style="clear:both;"></div>
                               <div style="margin-bottom: 20px;"><a href="http://www.dahliawolf.com/instagram_connect.php"><img src="skin/img/signininstagram2.png" width="304" height="66"/></a></div>
                               <div style="clear:both;"></div>
                               <div style="margin-bottom: 20px;"><a href="http://www.dahliawolf.com/oauth/redirect.php"><img src="skin/img/signintwitter2.png" width="304" height="66" /></a></div>
                               <div style="clear:both;"></div>
                               <div><a href="http://www.dahliawolf.com/login.php"><img src="skin/img/signinemail2.png" width="304" height="66" /></a></div>
                           
                           </div>
                           
                        </div>
                    </div>        
                            
                </div>

            </div>

        </div>
        <div class="cl"></div>	
        
    </div>
    

            <div id="sysPinsList" class="pinList center">           
                    </div>
        <div class="cl"></div>
        <div id="sysScrollContainerBottom"></div>
    </div>	 


       
<script>
$(document).ready(function() {
    $("i.sysOutLink").each(function(){
        var target = $(this).attr("same-win") ? "_self" : "_blank";
        var link = $(this).attr("skip-protocol") ? "" : "http://";
        link = link + $(this).attr("title");
        if ($(this).attr("away")) {
            link = "http://www.dahliawolf.com/goto/?" + link;
        }

		$(this).replaceWith("<a target=\"" + target + "\" class='" + $(this).attr("class") +"'" +" href=\"" + link + "\">" +$(this).html() + "</a>");
    });
    $(".sysShowAfterLoading").show();
});
</script>
        
<div class="sysNextPageLoading" style="display: none;"><img src="http://www.dahliawolf.com/img/icons/uploading_3.gif" alt="loading" align="top" /><span>loading...</span></div>
<div class="sysNextPageMore" style="text-align: center;display: none;margin-bottom: 50px;"><a class="Button Button12 WhiteButton" href="#" style="font-size: 16px;"><strong>See more</strong><span></span></a></div>
<div class="cl"></div>
<div id="sys-profiler"></div>
<div id="sysMessageDialog" style="display: none;" title="Message"></div>
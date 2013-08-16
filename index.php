<?
/*
ini_set("memcache.compress_threshold",4294967296);
ob_start();
*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
include 'config/mobile-detect.php';
if(isset($_COOKIE["dahliaUser"]) && isset($_COOKIE["token"])){
	$_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
	$_SESSION['token'] = $_COOKIE["token"];
	header( 'Location: spine' );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name = "viewport" content = "width = 1100, initial-scale=.7, maximum-scale=.7">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<title>Dahlia\Wolf - Homepage</title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/homes.js"></script>
<script src="/js/functions.js" type="text/javascript"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34564940-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  <!-- Start of Woopra Code -->
  function woopraReady(tracker) {
      tracker.setDomain('dahliawolf.com');
      tracker.setIdleTimeout(1800000);
      tracker.trackPageview({type:'pageview',url:window.location.pathname+window.location.search,title:document.title});
      return false;
  }
  (function() {
      var wsc = document.createElement('script');
      wsc.src = document.location.protocol+'//static.woopra.com/js/woopra.js';
      wsc.type = 'text/javascript';
      wsc.async = true;
      var ssc = document.getElementsByTagName('script')[0];
      ssc.parentNode.insertBefore(wsc, ssc);
  })();
<!-- End of Woopra Code -->

</script>

</head>

<style>
html{background: #fff;}
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin: 0;padding: 0;}
table{border-collapse:collapse;border-spacing: 0;}
img{border: 0;}
address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}
li{list-style:none;}
q:before,q:after{content:'';}
abbr,acronym {border: 0;font-variant:normal;}
sup{vertical-align:text-top;}
sub{vertical-align:text-bottom;overflow:hidden;}
input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit; resize: none;outline:none;}
legend{color:#000;}
body {font-family:Tahoma,arial,sans-serif;font-size:10px;color:#211922;min-width: 980px; margin-top: 90px;}
table{font-size:inherit;}
pre,code,kbd,samp,tt{font-family:monospace;line-height:100%;}
.zoom-in{cursor: -webkit-zoom-in;cursor: -moz-zoom-in;cursor: zoom-in;}
.zoom-out{cursor: -webkit-zoom-out;cursor: -moz-zoom-out;cursor: zoom-out;}
a{color: #fff;}
a:hover{color: red;}

#slideshow-frame{width: 100%;height: 100%;position: absolute;left: 0px;top: 0px;overflow: hidden;}
.slide{ height:100%; width:100%; position:absolute; left:0px; top:0px;background-size: auto 100%;background-repeat: no-repeat;background-position: center; background-size: cover;}
.slide img{min-width:100%; min-height:100%; }
.theBox{width: 500px;height: 485px;border-radius: 3px;position: absolute;top: 41px;left: 60px;z-index: 1;font-size: 13px;color: #C5C9CC;box-shadow: 0 0 3px #1A1A1A; min-height: 300px; min-width:250px;  max-width:450px; overflow: hidden; font:Arial, Helvetica, sans-serif;}
.theBox .header{position: relative;margin-left: 15%;z-index: 1;margin-top: 7%;}
.box-section{width: 100%;height: 71%; position:absolute;}
.pitch{color: #fff;width: 95%;margin-left: 2.5%;font-size: 1.7em;text-align: center;margin-top: 9%;font-family: Futura, sans-serif;}
.find-out-more{color: rgb(151, 151, 151);border: rgb(126, 126, 126) 1px solid;margin: 0 auto;width: 52%;font-size: .9em;padding: .5em 1.1em;text-align: center;margin-top: 4%;cursor: pointer;margin-bottom: 3%;
font-family: futura, Arial, Helvetica, sans-serif;}
.enter-butt{width: 60%;margin-left: 25%;margin-top: 15%;}
.already-user{text-align: center;margin-top:2%;font-size: .9em; font-family:Arial, Helvetica, sans-serif;}
.already-user-also{text-align: center;padding-top: 7px;font-size: 1em;margin-top: 15%;font-family: Arial, Helvetica, sans-serif;color: rgb(185, 185, 185);}
.strange-clouds{opacity: 0.9;background-color: rgb(44, 44, 44); position:absolute; height:100%; width:100%; top:0px; left:0px;}
.menu-form{list-style: none; -webkit-padding-start: 0px;}
.form-box{ text-align:center;}
.fb-login{width: 232px;margin-top: 8%;}
.menu-form li{font-size: 1.1em;margin-bottom: 2%;}
.menu-form input{width: 225px;height: 25px;border-radius: 0px;text-indent: 5px;font-size: .8em;}
.rememba{text-align: left;margin-left: 24%;font-size: 1.1em; width: 232px;}
#sysForm_submit{left: 50%;margin-left: -45px;margin-top: 5px;position: absolute;}
#register{display:none;}
#login{ display:none;}
.item-box{position: absolute;right: 0px;height: 100px;width: 400px;bottom: 10px;font-size: 1em;text-align: right;margin-right: 40px;margin-bottom: 30px;font-family: futura, sans-serif;font-weight: normal;}
.item-title{font-size: 1.9em;}
.inspired-by{font-size: 1.4em;padding-bottom: 2px;}
.inspira{font-size:1.2em;}
.inspira a{color:white; cursor: pointer;}
.inspira a:hover{color: black;}
.black{color:#000;}
.white{color:#fff;}
#how-it-works-section{position: absolute;top: 95%;width: 100%;height: 100%;font:Arial, Helvetica, sans-serif; background-color:white; left:0px;}
#title{color: #8e8c8d;width: 100%;text-align: center;font-size: 2em;margin-top: 200px;font-family: futura, Arial, Helvetica, sans-serif;}
#title span{font-weight:bold;}
.post-design{text-align: center; position:relative;}
.post-design img{width:70%;margin-top: 10px;position: absolute;left: 200px;top: -14px;}
.video-design{text-align: center; position:relative;margin-top: 80px;}
.video-design img{position: absolute; cursor:pointer;margin-left: -493px;left: 50%;}
#how-it-works-section .fb{text-align:center;}
#how-it-works-section .fb img{padding: 50px 0px 10px 0px;}
.tre-bar img{width:100%;}
.loggle-toggle{cursor:pointer; font-weight:bold; text-align: center;}
.loggle-toggle2{font-weight:bold; text-align: center;}
.signuplater {width: 500px;height: 80px;border-radius: 3px;position: absolute;top: 540px;left: 60px;z-index: 1;background-color: rgb(63, 63, 63);color: #fff;font-size: 13px;color: #C5C9CC;box-shadow: 0 0 3px #1A1A1A;min-height: 50px;min-width: 250px;max-width: 450px;opacity: .9;overflow: hidden;font: Arial, Helvetica, sans-serif;}
.signupemail2 {margin: 10px;font-family: arial;font-size: 10px;font-weight: normal;}
.signupemail2 a {color: rgb(121, 121, 121);text-decoration: none;}
.signupemail2 a:hover {color: #a53247;font-weight: bold;}
.signuplater2 {background: black;font-family: helvetica;font-size: 17px;color: white;padding-top: 5px;font-weight: 100;margin-top: 50px;text-transform: uppercase;padding-bottom: 5px;text-align: right;padding-right: 20px;}
.signuplater2  a{font-size: 40px;color: white;text-decoration:none;cursor:pointer;}
.signuplater2  a:hover{color: #a53247;}
.forgotsy{font-size: 10px;float: right;line-height: 19px;}
.aRow img{width: 100%;}

@media (min-width: 1440px) {
    /*.slide{background-size: 100% auto;}*/
}

</style>

<body>
	<div class="theBox">
    	<img class="header loggle-toggle" src="http://content.dahliawolf.com/home/dahlia-wolf-logo.png" onclick="homeWrecker.showBox('home');" />
        <div class="strange-clouds"></div>
        
        <div class="box-section" id="home">
        	<div class="pitch">YOU POST FASHION IMAGES.</br>WE TURN YOUR IMAGE INTO CLOTHING.</div>
            <div onclick="homeWrecker.showHowTo();" class="find-out-more">SCROLL DOWN TO FIND OUT MORE</div>
                   	<span class="enter-butt"><img class="fb-login loggle-toggle" src="/images/signinfacebook2.png" ></span>
            <div class="already-user"><span class="loggle-toggle" onclick="homeWrecker.showBox('register');">JOIN </span> | <span class="loggle-toggle" onclick="homeWrecker.showBox('login');"> LOGIN</span></div>
        </div>
        <div class="box-section form-box" id="login">
        	<img class="fb-login loggle-toggle" src="/images/signinfacebook2.png" >
            <form id="sysForm_Login" method="POST" class="Form FancyForm AuthForm" action="/mobile/action/login.php">
                <ul class="menu-form">
                    <li>or login with email: </li>
                    <li><input class="input_text" type="text" name="identity" id="sysForm_identity" value="" placeholder="Email"></li>
                    <li><input class="input_text" type="password" name="credential" id="sysForm_credential" value="" placeholder="Password"></li>    
                </ul>
                <div class='rememba'>
                    <input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
                    <span>Remember me</span>
                    <a href="/reset-password-link"><span class="forgotsy">Forgot your password?</span></a>
                 </div>
                 <input type="image" src="http://www.dahliawolf.com/images/login.png" id="sysForm_submit">
                 <input type="hidden" name="r" value="">
                 <input type="hidden" name="sublog" value="1">
            </form>
            <div class="already-user-also">Need an account? <span class="loggle-toggle" onclick="homeWrecker.showBox('register');">REGISTER</div>
        </div>
        <div class="box-section form-box" id="register">
        	<img class="fb-login loggle-toggle" src="/images/facebook-signup.png" >
            <form id="sysForm_Register" method="POST" class="Form FancyForm AuthForm" action="/mobile/action/signup.php">
                <ul class="menu-form">
                    <li>or signup with email: </li>
                    <li><input class="input_text" type="text" name="user_username" id="user_username" value="" max="30" placeholder="Username" /></li>
                    <li><input class="input_text" type="text" name="user_email" id="user_email" value="" placeholder="Email" /></li>
                    <li><input class="input_text" type="password" name="user_password" id="user_password" value="" placeholder="Password" /></li>    
                </ul>
                <div class='rememba'>
                    <input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
                    <span>Remember me</span>
                    <input type="image" style="margin-left: 20px;" src="http://www.dahliawolf.com/images/reg.png" id="sysForm_submit">
                 </div>
                 <input type="hidden" name="r" value="">
                 <input type="hidden" name="sublog" value="1">
                 <input type="hidden" name="jsub" value="1" />
            </form>
            <div class="already-user-also" style="margin-top: 6%;">Already a member? <span class="loggle-toggle" onclick="homeWrecker.showBox('login');">LOGIN</div>          
        </div>
    </div>
</div>

<style>
    #slideshow-frame .slide {display: none}
    #slideshow-frame:first-child  {display: block}
</style>

<div id="slideshow-frame">

    <div class="slide" style="background-image: url(/images/slider/neon-jacket.jpg);">
    <!--<img class="zeImg" src="/images/DAHLIA_NEWSLIDE.jpg" />-->
       <div class="item-box white">
        <div class="item-title">Neon Blazer</div>
           <div class="inspired-by">Inspired by member</div>
           <div class="inspira">fashion4Ever, Los Angeles CA</div>
       </div>
   </div>

    <div class="slide" style="display:none; background-image: url(/images/slider/stuffshelikes_slider.jpg);">
        <div class="item-box white" style="color: #000">
            <div class="item-title" >STUFF SHE LIKES DRESS</div>
            <div class="inspired-by">stuffshelikes</div>
            <div class="inspira"><a href="/stuffshelikes_slider"/>stuffshelikes_slider</a>, Los Angeles, CA</div>
        </div>
    </div>

    <div class="slide" style="display:none; background-image: url(/images/slider/ellemay.jpg);">
        <!--<img class="zeImg" src="/images/slider/artinourblood.jpeg" />-->
        <div class="item-box white" style="color: #000" >
            <div class="item-title">ELLE MAY DRESS</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira"><a href="/ellemay"/>ellemay</a>, Sunshine Coast, Australia</div>
        </div>
    </div>


    <div class="slide" style="display:none; background-image: url(/images/slider/artinourblood.jpeg);">
        <div class="item-box white">
            <div class="item-title">ART IN OUR BLOOD DRESS</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira"><a href="/artinourblood"/>artinourblood</a>, San Jose, CA</div>
        </div>
    </div>

    <div class="slide" style="display:none; background-image: url(/images/slider/rubilove.jpg);">
        <!--<img class="zeImg" src="/images/slider/rubilove.jpg" />-->
        <div class="item-box white" style="color: #000" >
            <div class="item-title">RubiLove Kimono</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira"><a href="/rubilove"/>RubiLove</a>, Panorama City, CA</div>
        </div>
    </div>

    <div class="slide" style="display:none; background-image: url(/images/slider/blazer.jpg);">
    	<!--<img class="zeImg" src="/images/slider/blazer.jpeg" />-->
        <div class="item-box white">
        	<div class="item-title">WHITE NITE BLAZER</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira">Jessica, New York</div>
        </div>
    </div>

    <div class="slide" style="display:none;  background-image: url(/images/slider/modern_native_dress.jpg);">
        <div class="item-box white" style="color: #000">
        	<div class="item-title">MODERN NATIVE DRESS</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira">Parker, Alabama</div>
        </div>
    </div>

    <div class="slide" style="background-image: url(/images/DAHLIA_NEWSLIDE.jpg);">
    	<!--<img class="zeImg" src="/images/DAHLIA_NEWSLIDE.jpg" />-->
        <div class="item-box white">
        	<div class="item-title">Coated in Tropicana Jacket</div>
            <div class="inspired-by">Inspired by member</div>
            <div class="inspira">StunnaLOOK, Los Angeles</div>
        </div>
    </div>
</div>

<div id="how-it-works-section">
    <div class="loggle-toggle2">
    	<div class="aRow">
            <img src="http://www.dahliawolf.com/images/how-dahliawolf-works.jpg" />
        </div>
    	<div class="aRow">
            <a href="http://www.dahliawolf.com/faqs">
                <img src="http://www.dahliawolf.com/images/how-dahliawolf-works-commission.jpg" />
            </a>
        </div>
    	<div class="video-design"><img src="http://www.dahliawolf.com/images/how-it-works-video.png" onclick="$(this).fadeOut(200);" /><iframe src="http://player.vimeo.com/video/67764567?color=ffffff" width="800" height="450" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
        <div><img style="margin-top:100px; margin-bottom: 30px;" src="http://www.dahliawolf.com/images/how-it-works-get-started.png" /></div>
        <div style="cursor:pointer;"><img onClick="document.location='social-login.php?social_network=facebook'" src="/images/facebook-signup.png" ></div>
        <div class="signupemail2"><a href="http://www.dahliawolf.com/signup">SIGN UP THE OLD SCHOOL WAY WITH EMAIL</a></div>
    	<div class="signuplater2"><span style="aligh:right;">Sign up later... <a href="http://www.dahliawolf.com/spine">ENTER</a></span></div>
	</div>
</div>

</body>
</html>
<script>
setTimeout(function(){
    homeWrecker.init(1800/* <- fade speed*/, 3000/* <- time between slides*/);
}, 1000) ;

$(function(){
    $('#sysForm_Register').submit(loginObj.submitNewUser);
    $('#sysForm_Login').submit(loginObj.loginUser);
    $('.fb-login').on('click', function() {
        sendToAnal({name : 'Logging in with Facebook'});
        document.location = 'social-login.php?social_network=facebook';
    });
})

</script>

<?php
/*
$buffer = ob_get_contents();
ob_end_clean();
$memcache_obj = memcache_connect("localhost", 11211);
//memcache_add($memcache_obj, "{$_SERVER['SERVER_NAME']}_{$_SERVER['REQUEST_URI']}" , $buffer, 0);

$memcache = new Memcache();
$memcache->connect('127.0.0.1', 11211);
$memcache->add("{$_SERVER['SERVER_NAME']}_{$_SERVER['REQUEST_URI']}", $buffer, false, 60*60);


echo $buffer;
*/

?>

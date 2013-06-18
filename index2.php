<?
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
<meta name="viewport" content="width =1441, initial-scale = 0">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<title>Dahliawolf</title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/homes.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34564940-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<style>
#slideshow-frame{width: 100%;height: 100%;position: absolute;left: 0px;top: 0px;overflow: hidden;}
.slide{ height:100%; width:100%; position:absolute; left:0px; top:0px; }
.slide img{min-width:100%; min-height:100%; }
.theBox{width: 500px;height: 485px;border-radius: 3px;position: absolute;top: 41px;left: 60px;z-index: 1;color: #fff;font-size: 13px;color: #C5C9CC;box-shadow: 0 0 3px #1A1A1A; min-height: 300px; min-width:250px;  max-width:450px; overflow: hidden; font:Arial, Helvetica, sans-serif;}
.theBox .header{width: 80%;position: relative;margin-left: 10%;z-index: 1;margin-top: 6%;}
.box-section{width: 100%;height: 71%; position:absolute;}
.pitch{color: #fff;width: 70%;margin-left: 15%;font-size: 1.6em;text-align: center;margin-top: 1%; font-family: Geneva, sans-serif;}
.find-out-more{color: #acacac;border: #acacac thin solid;margin: 0 auto;width: 25%;font-size: 1em;padding: .3em 1.1em;text-align: center;margin-top: 5%; cursor:pointer;}
.enter-butt{width: 60%;margin-left: 20%;margin-top: 5%;}
.already-user{text-align: center;margin-top: 3%;font-size: 1em;}
.already-user-also{text-align: center;font-size: 1em;margin-top: 12%;}
.strange-clouds{opacity: 0.9;background-color: rgb(44, 44, 44); position:absolute; height:100%; width:100%; top:0px; left:0px;}
.menu-form{list-style: none; -webkit-padding-start: 0px;}
.form-box{ text-align:center;}
.fb-login{width: 50%;margin-top: 5%;}
.menu-form li{font-size: 1.4em;margin-top: 2%;}
.menu-form input{width: 50%;height: 25px;border-radius: 5px;text-indent: 5px;font-size: .8em;}
.rememba{text-align: left;margin-left: 24%;font-size: 1.1em;}
#sysForm_submit{float: right;margin-right: 24%;margin-top: -24px;}

#register{display:none;}
#login{ display:none;}

.item-box{position: absolute;right: 0px;height: 100px;width: 300px;top: 76%;font-size: 1em; text-align:right;margin-right: 20px; font-family: Geneva, sans-serif;}
.item-title{font-size: 2em;}
.inspired-by{font-size: .8em;padding-bottom: 2px;}
.inspira{font-size:1.4;}
.black{color:#000;}
.white{color:#fff;}


#how-it-works-section{position: absolute;top: 100%;width: 100%;height: 100%;font:Arial, Helvetica, sans-serif;}
#title{color: #8e8c8d;width: 100%;text-align: center;font-size: 2em;margin-top: 65px;}
#title span{font-weight:bold;}
.post-design{text-align: center;}
.post-design img{width:70%;margin-top: 10px;}
#how-it-works-section .fb{text-align:center;}
#how-it-works-section .fb img{padding: 50px;}
.tre-bar img{width:100%;}

.loggle-toggle{cursor:pointer; font-weight:bold;}


</style>

<body>
<div id="slideshow-frame">
	<div class="theBox">
    	<img class="header loggle-toggle" src="http://content.dahliawolf.com/home/dahlia-wolf-logo.png" onclick="homeWrecker.showBox('home');" />
        <div class="strange-clouds"></div>
        
        <div class="box-section" id="home">
        	<div class="pitch">YOU POST FASHION IMAGES WE TURN YOUR IMAGE INTO CLOTHING.</div>
            <div onclick="homeWrecker.showHowTo();" class="find-out-more">FIND OUT MORE</div>
            <a href="/spine"><img class="enter-butt" src="/images/Splash-Enter.jpg" /></a>
            <div class="already-user">Already a user? <span class="loggle-toggle" onclick="homeWrecker.showBox('login');">Login here</div>
        </div>
        <div class="box-section form-box" id="login">
        	<img class="fb-login loggle-toggle" onClick="document.location='social-login.php?social_network=facebook'" src="/images/signinfacebook2.png" >
            <form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="action/login.php">
                <ul class="menu-form">
                    <li>or login with email: </li>
                    <li><input class="input_text" type="text" name="identity" id="sysForm_identity" value="" placeholder="Email"></li>
                    <li><input class="input_text" type="password" name="credential" id="sysForm_credential" value="" placeholder="Password"></li>    
                </ul>
                <div class='rememba'>
                    <input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
                    <span> Remember me</span>
                 </div>
                 <input type="image" src="http://www.dahliawolf.com/images/login.png" id="sysForm_submit">
                 <input type="hidden" name="r" value="">
                 <input type="hidden" name="sublog" value="1">
            </form>
            <div class="already-user-also">Not already a user? <span class="loggle-toggle" onclick="homeWrecker.showBox('register');">Register here</div>
        </div>
        <div class="box-section form-box" id="register">
        	<img class="fb-login loggle-toggle" onClick="document.location='social-login.php?social_network=facebook'" src="/images/facebook-signup.png" >
            <form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/signup.php">
                <ul class="menu-form">
                    <li>or signup with email: </li>
                    <li><input class="input_text" type="text" name="user_username" id="user_username" value="" max="30" placeholder="Username" /></li>
                    <li><input class="input_text" type="text" name="user_email" id="user_email" value="" placeholder="Email" /></li>
                    <li><input class="input_text" type="password" name="user_password" id="user_password" value="" placeholder="Password" /></li>    
                </ul>
                <div class='rememba'>
                    <input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1">
                    <span> Remember me</span>
                 </div>
                 <input type="image" src="http://www.dahliawolf.com/images/reg.png" id="sysForm_submit">
                 <input type="hidden" name="r" value="">
                 <input type="hidden" name="sublog" value="1">
                 <input type="hidden" name="jsub" value="1" />
            </form>
            <div class="already-user-also" style="margin-top: 4%;">Oops I meant to login? <span class="loggle-toggle" onclick="homeWrecker.showBox('login');">Login here</div>      
        </div>
        
    </div>
    
    <div class="slide">
    	<img class="zeImg" src="http://content.dahliawolf.com/home/DW-slide-1.jpg" />
        <div class="item-box black">
        	<div class="item-title">The Prissy Prance</div>
            <div class="inspired-by">Inspired by</div>
            <div class="inspira">Heidi, Los Angeles</div>
        </div>
    </div>
    <div class="slide" style="display:none">
    	<img class="zeImg" src="http://content.dahliawolf.com/home/DW-slide-2.jpg" />
        <div class="item-box black">
        	<div class="item-title">The Prissy Prance</div>
            <div class="inspired-by">Inspired by</div>
            <div class="inspira">Jessica, New York</div>
        </div>
    </div>
    <div class="slide" style="display:none">
    	<img class="zeImg" src="http://content.dahliawolf.com/home/DW-slide-3.jpg" />
        <div class="item-box white">
        	<div class="item-title">The Prissy Prance</div>
            <div class="inspired-by">Inspired by</div>
            <div class="inspira">Parker, Alabama</div>
        </div>
    </div>
</div>

<div id="how-it-works-section">
	<div id="title">When your POST inspires new clothing YOU GET 10% COMMISSION on every sale!</div>
    <div class="post-design"><img src="/images/splash_post_design.png" /></div>
    <div class="tre-bar"><img src="/images/Splash-Page-three.png" /></div>
    <div class="fb loggle-toggle"><img onClick="document.location='social-login.php?social_network=facebook'" src="/images/facebook-signup.png" ></div>
</div>

</body>
</html>
<script>
homeWrecker.init(600/* <- fade speed*/, 4000/* <- time between slides*/);

</script>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	if(IS_LOGGED_IN){
		 header( 'Location: post-details.php?session_type=web' ) ;
	}elseif(isset($_COOKIE["dahliaUser"])){
  		$_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
		$_SESSION['token'] = $_COOKIE["token"];
		header( 'Location: post-details.php?session_type=web' );
	}
	$pageTitle = "Dahliawolf - Home";
?>
<html>
	<head>
		<style>
			#bottom-nav{display:none !important;}
			.section img{width: 98%; margin-left: 1%;position: relative;}
			#theWindow{height: 100%; width:100%; left:0px; top:0px; position:fixed; overflow:scroll; background-color:white;}
			.main-col{width:500%; margin-top: 50px;position: relative;height: 90%;}
			.section{ width:20%; height:100%; float:left; position:relative; overflow:hidden;}
			#facebook-logger{position:relative; height:5%; width:100%; left:0px; background-color:white; top:0px; text-align:center;box-shadow: 0px 0px 2px #000;}
			.fb-butt{height: 45%; margin-top: 7%;}
			.header{ position:fixed !important;}
			#fb-promise{}
			#currFrame{position: absolute;left: 37%;margin-top: 3%; padding:2%;width:100%;}
			.lightbulb{display: block;background-color: #e1e1e1;height: 8px;width:8px;float: left;margin-left: 2%;border-radius: 1em;}
			.on{background-color:#ca8d98 !important;}
			#fb-promise-page{position: fixed;width: 100%;height: 105%;top: 95%; left:0px; background-color:#fff; z-index:100000000000;}	
			.fb-page-content{text-align: center; color:rgb(153, 153, 153); margin-top: 2%;}
			.fb-butt-2{width: 90%;margin-top: 15%;}
			.fbpc-title{font-size: 1.8em;margin-top: 10%;}
			.fb-page-content ul{text-align: left;margin: 0 auto; list-style: initial !important;}
			.fb-page-content li{padding-top: 10%;}
			#close-promise{ position:absolute; right:5%; font-size:2em; color:#000;}
			html{height:100%; background-color:#000;}
			#UnauthCallout{height: 550px; width: 100%; left: -5px;}
			.action-banner{color:rgb(102, 102, 102); height: 35px;font-size: 1.5em;}
			/*.face-wrap{margin-bottom: 10px;width: 100%;}
			.face-wrap img{width: 100%;height: auto;border-radius: .4em;}
			.log-frame{width: 100%; margin:0 auto;}
			#signinbox{text-align: center;padding-top: 8%;}
			#login-wrapper{height:95%;width: 80%; margin:0px auto; padding-top:5%; min-height: 100%;}
			#login-wrapper li{margin: 0;padding: 0% 0;color: #8c7e7e;text-shadow: 0 1px rgba(255,255,255,0.9); border:none; width: 100%;}
			#login-wrapper input{min-width:0px;width: 80%;background-color: #fff;border-radius: .4em;font-size: 1em;-webkit-appearance:none;} 
			#login-wrapper input-webkit-autofill{color: #2a2a2a !important;}
			.non_inputs{margin-top:0px !important}
			.fields{margin:0px !important;}
			.error_block{border: 1px solid #cd0a0a;background: #fbe7e7;color: #cd0a0a;height: 33px;border-radius: .4em;padding-top: 10px;margin-top: 15px;padding-top: 10px;width: 100%;margin: 0px auto; margin-bottom:10px;}
			.StaticForm{margin:0px !important;width: 100%; padding:0px !important;}*/
		</style>
	</head>
    <? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php" ?>
	<body style="background-color: black">
        <div id="theWindow">
            <div id="main-col" class="main-col">
                <div id="page-1" class="section">
                    <img src="images/land1.jpg">
                </div>
                <div id="page-2" class="section">
                    <img src="images/land2.jpg">
                </div>
                 <div id="page-3" class="section">
                    <img src="images/land3.jpg">
                </div>
                 <div id="page-4" class="section">
                    <img src="images/land4.jpg">
                </div>
                <div style="text-align:center;margin-top:3%" id="page-5" class="section"> 
                <span style="text-align:center;width:80%;font-family: helvetica;color:rgb(162, 162, 162);font-weight: 100;font-size: 20px;text-transform: uppercase;" >How it Works video</span>
               <iframe width="80%" height="" src="http://www.youtube.com/embed/f2H4gB0t55o?rel=0" frameborder="0" allowfullscreen></iframe>
                     
                </div>
            </div>
        </div>
        <div id="fb-promise-page">
            <div id="facebook-logger">
                <div id="currFrame">
                    <div class="lightbulb" id="light-1"></div>
                    <div class="lightbulb" id="light-2"></div>
                    <div class="lightbulb" id="light-3"></div>
                    <div class="lightbulb" id="light-4"></div>
                    <div class="lightbulb" id="light-5"></div>
                </div>
               <!-- <a href="/social-login.php?social_network=facebook">
                    <img class="fb-butt" src="http://www.dahliawolf.com/mobile/images/signinfacebook-mobile.png">
                </a>
                <div id="fb-promise"><p>We'll never post anything to Facebook without your permission<span style="margin-left: 6px;"><img src="http://www.dahliawolf.com/mobile/images/facebook-info.png"></span></p></div>-->
            </div>
            <div class="fb-page-content">
            	<div id="close-promise">X</div>
                <!--<a href="/social-login.php?social_network=facebook">
                    <img class="fb-butt-2" src="http://www.dahliawolf.com/mobile/images/signinfacebook-mobile.png">
                </a><div id="login-wrapper">   



<script>
function switcharoo(){
	if($('#loginbox').is(':visible')){
		$('#loginbox').hide();
		$('#signinbox').show();
	}else{
		$('#signinbox').hide();
		$('#loginbox').show();
	}
}
</script>
               <div class="fbpc-title">
                	YOUR PRIVACY IS SAFE
                </div>
                <ul>
                	<li>We will NEVER post anything to Facebook without your permission</li>
                    <li>Your information will be used strictly to create your account and WILL NOT be shared with anyone</li>
                    <li>Your location will never be shared</li>
                </ul> -->
                
            </div>
        </div>
        <? include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>
	</body>
</html>
<script>
var thePromise = new Object();
thePromise.isOpen = false;
thePromise.view = $('#fb-promise-page');
thePromise.toggleSpeed = 300;
thePromise.fbFloaterSize = 5;

thePromise.toggle = fbToggle;

function fbToggle(){
	if(!thePromise.isOpen){
		thePromise.view.animate({top:'-'+thePromise.fbFloaterSize+'%'}, thePromise.toggleSpeed);
		thePromise.isOpen = true;
	}else{
		thePromise.view.animate({top: (100-thePromise.fbFloaterSize)+'%'}, thePromise.toggleSpeed);
		thePromise.isOpen = false;
	}
}

$('#fb-promise, #close-promise').bind('click', function(){
	thePromise.toggle();
});

// HOME WRECKER *******************
var homeWrecker = new Object($(window).width());
homeWrecker.width = $(window).width();
homeWrecker.frame = 1;
homeWrecker.scrollControl = $('#theWindow');
homeWrecker.speedControl = 200;

homeWrecker.setScrollLoc = setScroll;
homeWrecker.init = scrollInit;
homeWrecker.getFrame = getFrame;
homeWrecker.turnOn;
homeWrecker.doLights = doLights;
homeWrecker.goLeft = goLeft;
homeWrecker.goRight = goRight;

$('#theWindow').on('movestart', function(e){
	//
}).bind('move', function(){
	//
}).bind('moveend', function(e){
	if(e.distX > 0 ){
		homeWrecker.goLeft();
	}else{
		homeWrecker.goRight();
	}
});

function goLeft(){
	homeWrecker.scrollControl.animate({scrollLeft: (homeWrecker.scrollControl.scrollLeft() - homeWrecker.width)}, homeWrecker.speedControl);
}
function goRight(){
	homeWrecker.scrollControl.animate({scrollLeft: (homeWrecker.scrollControl.scrollLeft() + homeWrecker.width)}, homeWrecker.speedControl);
}

function doLights(){
	for(x = 1; x < 6; x++){
		$('#light-'+x).removeClass('on');	
	}
	$('#light-'+homeWrecker.frame).addClass('on');
}

function getFrame(){
	homeWrecker.frame = Math.floor(this.scrollLoc/this.width)+1;
}

function setScroll(num){
	this.scrollLoc = num;
}

function scrollInit(){
	$('#theWindow').scroll(function() {
		homeWrecker.setScrollLoc($('#theWindow').scrollLeft());
		homeWrecker.getFrame();
		homeWrecker.doLights();
    });
}

homeWrecker.init();

</script>

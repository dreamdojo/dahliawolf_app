<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";  
	$pageTitle = "Dahliawolf - How it works";
?>
<style>
	.section img{width: 98%; margin-left: 1%;position: relative;}
	#theWindow{height: 100%; width:100%; left:0px; top:0px; position:fixed; overflow:scroll;}
	.main-col{width:400%; margin-top: 50px;position: relative;height: 93%;}
	.section{ width:25%; height:100%; float:left; position:relative; overflow:hidden;}
	#facebook-logger{position:relative; height:19%; width:100%; left:0px; background-color:#FFF; top:0px; text-align:center;box-shadow: 0px 0px 5em #000;}
	.fb-butt{height: 40%; margin-top: 7%;}
	#fb-promise{color: #acacac;font-size: .8em;margin-top: 1%;}
	#currFrame{ position:absolute;margin-top: 100%;width: 100%;margin-left: 41%;}
	.lightbulb{display: block;background-color: #e1e1e1;height: 13px;width:13px;float: left;margin-left: 2%;border-radius: 1em;}
	.on{background-color:#ca8d98 !important;}
	#fb-promise-page{position: fixed;width: 100%;height: 125%;top: 76%; left:0px; background-color:#fff; z-index:100000000000;}	
	.fb-page-content{text-align: center; color:rgb(153, 153, 153); margin-top: 2%;}
	.fb-butt-2{width: 70%;margin-top: 7%;}
	.fbpc-title{font-size: 1.8em;margin-top: 10%;}
	.fb-page-content ul{width: 80%;text-align: left;margin: 0 auto; list-style: initial !important;}
	.fb-page-content li{padding-top: 10%;}
	#close-promise{ position:absolute; right:5%; font-size:2em; color:#000;}
</style>
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
        </div>
    </div>
    <div id="currFrame">
        <div class="lightbulb" id="light-1"></div>
        <div class="lightbulb" id="light-2"></div>
        <div class="lightbulb" id="light-3"></div>
        <div class="lightbulb" id="light-4"></div>
    </div>
<script>
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
	for(x = 1; x < $('.lightbulb').length+1; x++){
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

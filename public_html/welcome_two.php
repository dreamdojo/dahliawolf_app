<?php
	$pageTitle = "Explore";
include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
include "header.php";

//require 'includes/php/classes/Spine.php';
$Spine = new Spine(array('bare' => 1));
	
?>
<style>
#feedback-tab{
	display:none;
}
.main-col{
	width:1000px;
	margin:0px auto;
	margin-top: 100px;
	text-align: center;
}
.wtb-action{
	font-size: 38px;
	padding: 5px;
}
.wtb-descr{
	font-size:16px;
	padding-bottom: 15px;
}
.the-dot{
	background-image:url('images/thedot.png');
	width:66px;
	height: 66px;
	margin:0px auto;
}
.the-dot div{
	color:#fff;
	font-size: 42px;
	padding-top: 5px;
}
.spine{
	padding-left:100px !important;
}
.image{
	background-color:#d7d7d7;
}
#the-bar{
	text-align: center;
	background-color: white;
	width: 1000px;
	height: 67px;
	z-index:1000;
}
.wtb-title-box{
	height: 204px;
}
.votes{
	display:none;
}
.next-butt a{
	width: 100px;
	margin-top: 17px;
}
</style>

<div class="header">
 <div class="HeaderContents">
    <img src="/public_html/images/logo.png">
 </div>
</div>
<div class="main-col">
     <div class="wtb-title-box">
        <img src="images/wel_stat_two.png" />
        <div class="wtb-action">
            EXPLORE
        </div>
        <div class="wtb-descr">
            Explore member inspired designs and vote for 5 items you want
        </div>
        <div id="the-bar">
        	<div class="next-butt" style="display: none;">
                <a href="/spine" class="Button12 Button OrangeButton">
                    <strong>NEXT</strong><span></span>
                </a>
            </div>
            <div class="the-dot">
        	    <div id="counter">1</div>
        	</div>
        </div>
     </div>
    <?php $Spine->output_explore($_data['posts']); ?>
</div><!-- end main col -->

<script>
$('.image a').bind('click', function(){
	$('#counter').html( parseInt($('#counter').html())+1 );
	if(parseInt($('#counter').html()) == 5){
		$('.next-butt').show();
		$('.the-dot').hide();
	}
});

$(window).scroll(function(e){ 
	el = $('#the-bar');
	if($(window).scrollTop() > 153){
		el.css('position', 'fixed').css('top', 84);
	}else if(el.css('position') == 'fixed'){
		el.css('top', 'auto').css('position', 'static');
	}
});


</script>

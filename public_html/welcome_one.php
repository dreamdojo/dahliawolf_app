<?php
$pageTitle = "Welcome to Dahliawolf";
include "head.php";
include "post_slideout.php";
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
	margin:0px auto
}
.the-dot div{
	color:#fff;
	font-size: 42px;
	padding-top: 10px;
}
.spine{
	padding-left:100px !important;
}
.image{
	background-color:#d7d7d7;
}
.image img{
	height:100%;
	margin-top:0px !important;
}
.button{
	padding: 0.5em 2.825em .58em !important;
}
.next-butt{
	display:none;
}
.helper{
	background-color: #F00;
	position: fixed;
	color: #fff;
	top: 206px;
	left: -359px;
	height: 121px;
}
#tooltip-overlay{
	display:none !important;
}
.never-f-up{
	display:none !important;
}
#close-box{
	display:none !important;
}
</style>
<div id="fb-root" class=" fb_reset"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div>
<div class="header">
 <div class="HeaderContents">
    <img src="/public_html/images/logo.png">
 </div>
</div>

<img class="helper" src="/public_html/images/post_help_pop.jpg" />

<div class="main-col">
     <div class="wtb-title-box">
        <img src="images/wel_stat_one.png" />
        <div class="wtb-action">
            POST
        </div>
        <div class="wtb-descr">
            Post 5 fashion images that you would like trasformed into clothing
        </div>
        <div class="the-dot">
            <div id="the-count">0</div>
        </div>
        <div class="next-butt">
        	<a href="welcome_two.php" class="Button12 Button OrangeButton">
                <strong>NEXT</strong><span></span>
            </a>
        </div>
        
        <div class="spine" data-url="/spine-chunk.php">
				<ul class="images mod-0">
                	<li class="posting-227 image-0" data-posting_id="227">
                        <div class="image">
                                <img id="w-img-1" class="lazy" src="/public_html/images/fake-img.png" height="100%" alt="Rep Yo Steez" style="margin-top: -12px; margin-left: -0px;">
                        </div>                      
                        <p class="username"><a href="#"></a></p>                         
                        <p class="like">
                            <span class="like-count-227"></span>
                            <a href="#" id="link-227" rel="like" data-undo_href=""></a>
                        </p>
					</li>
                    <li class="posting-226 image-1" data-posting_id="226">
                        <div class="image">
                             <img id="w-img-2" class="lazy" src="/public_html/images/fake-img.png" height="100%" alt="Rep Yo Steez" style="margin-top: -0px; margin-left: -0px;">
                        </div>					
						<p class="username"><a href="#"></a></p>										
						<p class="like">
							<span class="like-count-226"></span>
							<a href="#" id="link-226" rel="like" data-undo_href="#"></a>
						</p>
					</li>
                    <li class="posting-225 image-2" data-posting_id="225">
						<div class="image">
								<img id="w-img-3" class="lazy" src="/public_html/images/fake-img.png" height="100%" alt="Rep Yo Steez" style="margin-top: -0px; margin-left: -3px;">
						</div>
						<p class="username">
                        	<a href="#"></a></p>
						<p class="like">
							<span class="like-count-225"></span>
							<a href="#" id="link-225" rel="like" data-undo_href="#"></a>
						</p>
					</li>
                    <li class="posting-224 image-3" data-posting_id="224">
						<div class="image">						
								<img id="w-img-4" class="lazy" src="/public_html/images/fake-img.png" height="100%" alt="Rep Yo Steez" style="margin-top: -0px; margin-left: -0px;">
						</div>
						<p class="username"><a href="#"></a></p>
						<p class="like">
							<span class="like-count-224"></span>
							<a href="#" id="link-224" rel="like" data-undo_href="#"></a>
						</p>
					</li>
                    <li class="posting-223 image-4" data-posting_id="223">
						<div class="image">
								<img id="w-img-5" class="lazy" src="/public_html/images/fake-img.png" height="100%" alt="Rep Yo Steez" style="margin-top: -0px; margin-left: -0px;">
						</div>
						<p class="username"><a href="#"></a></p>
						<p class="like">
							<span class="like-count-223"></span>
							<a href="#" id="link-223" rel="like" data-undo_href="#"></a>
						</p>
					</li>
				</ul>
			</div>
     </div>
</div><!-- end main col -->

<script>
var post_mode = "welcome";
$('#tabber').bind('click', function(){
	$('.helper').hide();
	setTimeout(function(){
		refillImages('pinterest');
	}, 1000);
});
function increaseCount(image){
	$('#the-count').html((parseInt($('#the-count').html())+1));
	$('#w-img-'+parseInt($('#the-count').html())).attr('src', image.attr('src'));
	if(parseInt($('#the-count').html()) == 5){
		$('#postitdiv').remove();
		$('#tabber').remove();
		$('.next-butt').show();
		$('.the-dot').remove();
	}
}
$(window).load(function(){
	setTimeout(function(){
		$('.helper').animate({left:59}, 1000);
	}, 300);
});
</script>

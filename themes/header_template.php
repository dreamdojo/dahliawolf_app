<body>
<div id="loadme"></div>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '552515884776900',                        // App ID from the app dashboard
      channelUrl : '//www.dahliawolf.com/channel.html', // Channel file for x-domain comms
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all/debug.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


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
});
//Google Aanalytics
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34564940-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<div id="modal" class="modal">
    <div id="modal-content">
        <img id="modal-image" />
    </div>
</div>

<a name="top"></a>
<div class="header">
    <div class="HeaderContainer">
        <div class="HeaderContents">
            <div class="header_logo"><a href="/spine"><img src="/images/logo.png"></a>
            </div>
        <div id="middlebutton">
          	<div class="marginmiddlebutton1 marginmiddlebutton">
            	<a id="section-inspire" href="#" onClick="thePost.buttonPushed();" >INSPIRE+</a>
            </div>
            <div class="slasher">
            	<img src="/images/slash.png" width="23" height="19">
            </div>
                        <div class="marginmiddlebutton1 marginmiddlebutton">
            	<a id="section-vote" href="/spine" class="<?= ($self == '/spine.php' || $self == '/grid.php' ? 'color-me-red' : '') ?>">VOTE</a>
            </div>

             <div class="slasher">
            	<img src="/images/slash.png" width="23" height="19">
            </div>
            <div class="marginmiddlebutton4 marginmiddlebutton">
            	<a id="section-shop" href="/shop" class="<?= ($self == '/explore.php' ? 'color-me-red' : '') ?>">SHOP</a>
            </div>


            <div style="clear:both"></div>
        </div>
        <div id="user-nav">
          <ul class="Navigation">
				<?php if(IS_LOGGED_IN): ?>
                 <li class="parent username">
                    <a href="<? echo '/' . $_SESSION['user']['username'] ?>">
                    	<?php echo $_SESSION['user']['username'] ?>
                    	<span class="arrow"></span>
                    </a>
                    <ul>
                		<li>
                			<form style="min-width:135px;padding-top:15px; padding-bottom:10px; padding-left:5px; color:#fff !important; background-color:#000;" class="sysFullTSForm text" method="get" action="/spine">
	        					<input style="width: 65%; background-color: rgb(0, 0, 0); border: 2px solid rgb(170, 170, 170); margin-left: 2px; padding-left: 2px; padding-top: 2px; color: rgb(135, 135, 135) !important; text-transform: uppercase !important;" type="text" value="" size="10" name="q" id="query" is_empty="yes" class="ui-autocomplete-input" inited="inited">
	        					<button class="lg" style="width:20%; padding: 4px;" id="query_button" type="submit"><img alt="Search" src="<?= CR ?>/images/search.gif"></button>
	        				</form>

	        				<script type="text/javascript">
	        					//$('.sysFullTSForm INPUT[name="q"]').emptyVal({text: "Search"})
	        				</script>
        				</li>
                    	<?
                    	$account_navs = array(
                    		array(
	                    		'Profile' 		=> '/' . $_SESSION['user']['username']
	                    		, 'Activity' 	=> '/activity'
								, 'Invite' 	=> '/invite'
	                    		, 'Showroom' 		=> '/my-runway?username='.$_SESSION['user']['username']
                                , 'Cart'.' $'.money_format('%i', isset($_data['cart']) && isset($_data['cart']['cart']) ? $_data['cart']['cart']['totals']['grand_total'] : 0) => '/shop/checkout'
	                    		, 'Wishlist' 	=> '/shop/my-wishlist'
	                    	)
							, array(
								'Inspire Tool' => '/pinit'
                    		)
							, array(
								'Settings' => '/account/settings'
								, 'Orders' => '/shop/my-orders'
								, 'Logout' => '/action/logout'
                    		)

							, array(
								'Pack Leaders' => '/wolf-pack'

                    		)
						);
						foreach ($account_navs as $i => $group) {
							$j = 0;
							foreach ($group as $name => $url) {
								?>
								<li<?= $i != 0 && $j == 0 ? ' class="divider"' : '' ?>><a href="<?= $url ?>"><?= $name ?></a><? if($name == 'Activity' && $new_activity > 0){echo '<div class="new-bubs"><p>'.$new_activity.'</p></div>';} ?></li>
								<?
								$j++;
							}
						}
                    	?>
                    </ul>
                </li>

                <?php else: ?>
                <li class="Navigation2">
                    <a href="javascript:;" onClick="loginscreen('signup')">Signup</a>
                </li>
                <li>
                    <a href="javascript:;" onClick="loginscreen('login')">Login</a>
                </li>
                <?php endif ?>
         </ul>
         <?
         if (IS_LOGGED_IN) {
         	?>
			<div id="point-board">
				<a href="/wolf-pack">
					You have <span class="points user-points">1</span> points
				</a>
				<span class="message">You have earned <span class="earned-points"></span> points</span>
			</div>
			<?
		 }
		 ?>
       </div>
       <div id="tour-button">SHOW HELPER</div>
   </div>
</div>
</div>

<div id="dahliaHead">
    <div id="dahliaHeadAvatar"><img id="dahliaHeadAvatarSrc" src="" /></div>
    <div id="dahliaHeadFollowToggle"></div>
</div>

<div id="theLesson" class="lessonBox">
	<div id="lessonCloser"><a href="#">HIDE HELPER</a></div>
    <div id="lesson-title" class="lesson-section"></div>
    <div class="lesson-line"></div>
    <div id="lesson-content" class="lesson-content"></div>
    <div class="lesson-steps"><!--<div style="color: rgb(107, 107, 107);font-size: 11px; padding-top:14px; padding-bottom:5px;">THE PROCESS</div><div style="font-size: 18px; padding-bottom: 11px;"><a href="#" onClick="thePost.buttonPushed();" >INSPIRE</a> >> <a href="/spine">VOTE</a> >> <a href="/explore">SHOP</a></div>
        <!--<a href="/spine"><img id="step1" <?= ($self != '/spine.php' ? 'class="faded"' : '') ?>src="/images/lesson1.png"></a>
        <img onClick="thePost.buttonPushed();" id="step2" <?= ($self != '/post.php' ? 'class="faded"' : '') ?> src="/images/lesson3.png">
        <a href="/explore"><img id="step3" <?= ($self != '/explore.php' ? 'class="faded"' : '') ?> src="/images/lesson2.png"></a>-->
        <div style="padding-top: 29px;color: rgb(104, 104, 104);">Still have questions? Visit the <a href="/faqs">FAQs</a> or <a href="/help">How it Works</a></div>
    </div>
</div>
<style>
#bankOptions{height:60px; width:100%; display:none; overflow:hidden;position: relative;z-index: 100;margin-top: -6px;border-bottom: #b6b6b6 1px solid;}
#bankCenter{height:60px; width:1100px; margin:0px auto;}
#bankCenter .bankSection{ width:24%; height:81%; float:left; border-right:#b6b6b6 1px solid;padding-top: 1.2%; color:rgb(104, 104, 104);}
#bankCenter .bankSection:hover{background-color:#ebebeb;}
.no-right-border{border-right:none !important;}
.bankSection p{font-size: 13px;margin-top: 9px;margin-left: 10px;}
.bankSection img{float: left;margin-left: 10px;margin-right: 10px;}
#dndeezy{border: #777777 2px dotted;width: 80%;margin-left: 10%;border-radius: 8px;text-align: center;margin-top: -4px;}
#loadingView{display:none;width:100%; position:fixed; bottom:-100px;text-align: center;z-index: 10000000000;height: 60px;}
#loadingView img{height:100%;}
#getPinterestName{ position:absolute; left:-100%; height:100%; width:100%;background-color: #fff;top: 0px;}
#importFromPinterest{ position:relative; overflow:hidden;}
#thePinterestName{height: 75%;margin-top: 2%;margin-left: 2%;width: 75%;font-size: 14px;text-indent: 3px; float:left;}
#goPinterestButton{ height:100%; width:20%; float:left; background-image:url(/images/pinterestGo.png); background-size: 86% 80%;background-repeat: no-repeat;background-position: 7%;}
</style>



<div id="bankOptions" class="drop-shadow">
	<div id="bankCenter">
    	<div class="bankSection">
        	<img class="fork-img" id="uploadButton" src="/images/select-files.png" style="float: right;" />
   			<input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="imgUpload.submitImage(this.files[0]);">
        </div>
        <div class="bankSection">
        	<div id="dndeezy">
            	<p>Drag n Drop File Here</p>
            </div>
        </div>
        <div id="importFromPinterest" class="bankSection cursor">
        	<div id="getPinterestName">
            	<input type="text" placeholder="Enter Pinterest Name Here" id="thePinterestName" /><div id="goPinterestButton"></div>
            </div>
            <img src="/images/bank-pinterest.png">
            <p>Select Images From Your Pinterest</p>
        </div>
        <div id="importFromInstagram" class="bankSection no-right-border cursor">
        	<img src="/images/bank-instagram.png">
            <p>Select Images From Your Instagram</p>
        </div>
    </div>
</div>

<div id="loadingView">
	<img src="/images/loading-feed.gif">
</div>

<script>
$(function(){
	theLesson.init('<?= $self ?>');
});
</script>

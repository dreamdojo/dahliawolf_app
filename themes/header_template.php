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
<style>
    #dahliaHeader{position: fixed; height: 50px; width: 100%; background-color: #000; left: 0px; top: 0px;z-index: 11111; min-width: 500px; font-family: futura;
        background: #3f3f3f; /* Old browsers */
        background: -moz-linear-gradient(top,  #3f3f3f 0%, #131313 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#3f3f3f), color-stop(100%,#131313)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  #3f3f3f 0%,#131313 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  #3f3f3f 0%,#131313 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  #3f3f3f 0%,#131313 100%); /* IE10+ */
        background: linear-gradient(to bottom,  #3f3f3f 0%,#131313 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3f3f3f', endColorstr='#131313',GradientType=0 ); /* IE6-9 */
    }
    #dahliaHeader a{color: #fff !important;}
    /*#dahliaHeader a:hover{color: #eb1d5d !important;}*/
    #dahliaHeader #dahliaLogo{width: 160px;height: 80%;background-image: url("/images/logo_no_beta.png");background-size: 100%;background-repeat: no-repeat;background-position: 46% 50%;margin-top: 7px;margin-left: 20px;overflow: hidden; float: left; cursor: pointer;}
    #dahliaHeader #userMenu{float: right; padding-right: 20px; position: relative; height: 40px; margin-top: 10px; margin-right: 8px;}
    #dahliaHeader .avatarFrame{width: 30px;height: 30px;overflow: hidden; margin-top: -1px; border-radius: 30px;float: right;}
    #dahliaHeader .avatarFrame img{width: 100%;}
    #dahliaHeader .userName{float: right;color: #fff;font-size: 12px;line-height: 32px; margin-right: 9px;}
    #dahliaHeader #mainMenu{position: absolute;width: 260px; left: 50%;margin-left: -130px; color: #fff;height: 60px;line-height: 50px;font-size: 18px;text-align: center;}
    #dahliaHeader #mainMenu li{float: left; margin: 0px 10px; position: relative;}
    #dahliaHeader #shoppingCart{ float: right; background-image: url("/images/shoppingCart.png");width: 40px;height: 40px;background-size: 81%; background-repeat: no-repeat; background-position: -7px -2px; margin-top: 10px;}
    #dahliaHeader #searchButton{ float:right; background-image: url("/images/s_mag.png"); width: 40px; height: 40px; background-size: 75%; background-repeat: no-repeat;margin-top: 10px; margin-right: 0px;}
    #dahliaHeader #rightHandMenu { cursor:pointer; float: right; height: 100%;margin-right: 10px;}
    #dahliaMainMenuButton{float: left; height: 48px; width: 50px;  display: none; margin-left: 10px;background-image: url("/images/barMenu.png");background-size: 86%; background-repeat: no-repeat;margin-top: 2px;}
    #dahliaMainMenuButton:hover .theMainMenu{display: block;}
    .theMainMenu {position: absolute;margin-top: 48px;left: 0;background-color: #000;color: #fff;font-size: 18px; display: none;}
    .theMainMenu li{padding: 7px;width: 100px;text-align: center; position: relative;}
    #dahliaHeader #userMenu:hover ul{display: block;}
    #userMenu ul{position: absolute;width: 100%; margin-top: 40px; text-align: left; background-color: #000;color: #fff;min-width: 100px; display: none;opacity: .88;}
    #userMenu li{font-size: 13px;padding: 5px 14px; font-family: arial;border-top: #292929 1px solid;}
    #userMenu li:hover{background-color: #1a1a1a;}
    #userMenu li:last-child{padding-bottom: 10px;}
    .loginDept{color: #fff;font-size: 13px;width: 125px;line-height: 50px;}
    .loginDept li{float: left;margin-right: 10px; position: relative;margin-left: 8px;}
    .sector{border-top: #fff thin solid; border-bottom: #fff thin solid;}
    .rtBorder{border-right: #666666 thin solid; position: absolute; height: 30px; right: 0px;}
    .mmBorder{border-right: #666666 thin solid;position: absolute; height: 30px;right: -10px; top: 10px;
        -webkit-transform: rotate(-22deg);
        -moz-transform: rotate(-22deg);
        -o-transform: rotate(-22deg);
        -ms-transform: rotate(-22deg);
        transform: rotate(-22deg);}

    #searchBar{width: 100%;position: fixed;height: 60px;left: 0px;background-color: #000;top: 49px; z-index: 123;border-top: #fff thin solid;display: none;}
    #searchBar input{height: 59px;width: 100%;background-color: #FFF;border: none;color: #C7C7C7;font-size: 40px;text-indent: 15px;text-align: center;}
    .pinkMe{color: #F03E63;}

    @media screen and (max-width: 1000px) {
        #dahliaHeader .userName{display: none;}
    }

    @media screen and (max-width: 700px) {
        #dahliaHeader #mainMenu{display: none;}
        #dahliaMainMenuButton{display: block;}
        #dahliaHeader #dahliaLogo{float: none;position: absolute;left: 50%;margin-left: -120px;}
        #userMenu ul{position: fixed;right: 0px;width: 130px;}
    }
</style>

<div id="dahliaHeader" class="avatarShadow">
    <div id="dahliaMainMenuButton">
        <ul class="theMainMenu">
            <li><a href="#" onclick="thePost.buttonPushed();return false;">INSPIRE</a></li>
            <li><a href="/spine">VOTE</a></li>
            <li><a href="/shop">SHOP</a></li>
        </ul>
    </div>
    <a href="/spine"><div id="dahliaLogo"></div></a>
    <ul id="mainMenu">
        <li><a href="#" onclick="thePost.buttonPushed();return false;"><span class="<?= $self == '' ? 'pinkMe' : '' ?>">INSPIRE+</a><div class="mmBorder"></div></li>
        <li><a href="/spine"><span class="<?= $self == '/grid.php' || $self == '/spine.php' ? 'pinkMe' : '' ?>">VOTE</a><div class="mmBorder"></div></li>
        <li><a href="/shop"><span class="<?= $self == '/shop/index.php' ? 'pinkMe' : '' ?>">SHOP</a></li>
    </ul>
    <div id="rightHandMenu">
        <? if(IS_LOGGED_IN): ?>
        <a href="/shop/checkout.php"><div id="shoppingCart"></div></a>
        <div id="searchButton"></div>
        <div id="userMenu">
            <div class="rtBorder"></div>
            <div class="avatarFrame"><img src="<?= $userConfig['avatar'] ?>"></div>
            <div class="userName"><a href="/<?= $_SESSION['user']['username'] ?>" style="color: #B1B1B1 !important;"><?= $_SESSION['user']['username'] ?></a></div>
            <ul>
                <li><a href="/<?= $_SESSION['user']['username'] ?>">Profile</a></li>
                <li><a href="/activity">Activity</a></li>
                <li><a href="/invite">Invite</a></li>
                <li><a href="/shop/my-wishlist">Wishlist</a></li>
                <li><a href="/pinit">Inspire Tool</a></li>
                <li><a href="/account/settings">Settings</a></li>
                <li><a href="/shop/my-orders">Orders</a></li>
                <li><a href="/action/logout">Logout</a></li>
                <li><a href="/wolf-pack">Pack Leaders</a></li>
            </ul>
        </div>
        <? else: ?>
            <ul class="loginDept">
                <li onclick="loginscreen('login')">Login<div class="mmBorder"></div></li>
                <li onclick="loginscreen('signup')" style="margin-right: 20px; color: #F03E63;">Signup</li>
            </ul>
        <? endif ?>
    </div>
</div>
<div id="searchBar">
    <input type="text" placeholder="Start typing to search...">
</div>

<script>
    $(function() {
       $('#searchButton').bind('click', function() {
           $('#searchBar').slideToggle(200);
           $('#searchBar input').focus();
           $('#searchBar input').unbind('keydown').bind('keydown', function(e){
               if(e.keyCode == 13) {
                   var s_key = $(this).val();
                   document.location = '/grid?q='+s_key;
                   $('#searchBar').slideUp(200);
               }
           });
       });
    });
</script>
<? //var_dump($userConfig) ?>

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

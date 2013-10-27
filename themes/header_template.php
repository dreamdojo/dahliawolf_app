<body style="overflow-x: hidden;">

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

<div id="dahliaHeader" class="avatarShadow">
    <div id="dahliaMainMenuButton">
        <ul class="theMainMenu">
            <li><a href="/inspire">INSPIRE</a></li>
            <li><a href="/spine">VOTE</a></li>
            <li><a href="/shop">SHOP</a></li>
        </ul>
    </div>
    <a href="/home"><div id="dahliaLogo"></div></a>
    <ul id="mainMenu">
        <li><a href="/inspire"><span class="<?= $self == '/inspire.php' ? 'pinkMe' : '' ?>">INSPIRE+</a><div class="mmBorder"></div></li>
        <li><a href="/vote"><span class="<?= $self == '/grid.php' || $self == '/spine.php' || $self == '/vote.php'  || $self == '/index.php' ? 'pinkMe' : '' ?>">VOTE</a><div class="mmBorder"></div></li>
        <li><a href="/shop"><span class="<?= $self == '/shop/index.php' ? 'pinkMe' : '' ?>">SHOP</a></li>
    </ul>
    <div id="rightHandMenu">
        <div id="tourButton"></div>
        <? if(IS_LOGGED_IN): ?>
            <a href="/shop/checkout.php"><div id="shoppingCart"></div></a>
        <? endif ?>
            <div id="searchButton"></div>
        <? if(IS_LOGGED_IN): ?>
        <div id="userMenu">
            <div class="rtBorder"></div>
            <div class="menuBars"><img src="/images/menu-bars.png"></div>
            <div class="avatarFrame theUsersAvatar"><a href="/<?= $_SESSION['user']['username'] ?>"><img src="<?= $userConfig['avatar'] ?>&width=100"></a></div>
            <div class="userName"><a href="/<?= $_SESSION['user']['username'] ?>" style="color: #B1B1B1 !important;"><?= $_SESSION['user']['username'] ?></a></div>
            <ul>
                <div class="header-bezier"></div>
                <a href="/<?= $_SESSION['user']['username'] ?>"><li style="border-top: none;">Profile</li></a>
                <a href="/<?= $_SESSION['user']['username'] ?>?dashboard=true"><li>Dashboard</li></a>
                <a href="/activity"><li>Activity</li></a>
                <a href="/invite"><li>Grow My Clique</li></a>
                <a href="/goodies"><li>Goodies</li></a>
                <!--<a href="/shop/my-wishlist"><li>Wishlist</li></a>-->
                <a href="/pinit"><li>Inspire Tool</li></a>
                <a href="/account/settings"><li>Settings</li></a>
                <a href="/shop/my-orders"><li>Orders</li></a>
                <a href="/wolf-pack"><li style="border-bottom: none;">Pack Leaders</li></a>
                <a href="/faqs"><li>FAQ</li></a>
                <a href="/action/logout"><li>Logout</li></a>
                <li class="top-menu-footer"><a href="/help">How it Works</a> - <a href="/tos">Legal</a> - <a href="/contact">Contact</a> - <bold>© Dahlia Wolf 2013</bold></li>
            </ul>
        </div>
        <? else: ?>
            <ul class="loginDept">
                <li onclick="loginscreen('login')">Login<div class="mmBorder"></div></li>
                <li onclick="loginscreen('signup')" style="margin-right: 20px; color: #F03E63;">Signup</li>
            </ul>
        <? endif ?>
    </div>
    <div id="searchBar">
        <input type="text" placeholder="Start typing to search...">
    </div>
</div>

<script>

</script>
<? //var_dump($userConfig) ?>

<div id="dahliaHead">
    <div id="dahliaHeadAvatar"><img id="dahliaHeadAvatarSrc" src="" /></div>
    <div id="dahliaHeadFollowToggle"></div>
</div>

<div id="theLesson" class="lessonBox">
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

<div id="loadingView">
	<img src="/images/dw-logo.png">
</div>

<script>

$(function(){
	theLesson.init('<?= $self ?>');
    dahliaLoader = new loadingBar();
    $('#searchButton').bind('click', function() {
        $('#searchBar').slideToggle(200);
        $('#searchBar input').focus();
        $('#searchBar input').unbind('keydown').bind('keydown', function(e){
            if(e.keyCode == 13) {
                var s_key = $(this).val();
                document.location = '/vote?q='+s_key;
                $('#searchBar').slideUp(200, function() {
                    if(!$(this).is(':visible')) {
                        $('#searchBar input').blur();
                    }
                });
            }
        });
    });
});
</script>

<?php if(!IS_LOGGED_IN): ?>
    <?php include "login_pop.php"; ?>
<?php endif ?>
<?php require_once 'blocks/analytics.php'; ?>

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

    //Google Aanalytics
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-34564940-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        //ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<a name="top"></a>
<style>
    #headerHeader{height: 28px;  color: #fff; background-color: #a5a5a5;font-size: 14px;}
    #headerBody{height: 73px; position: relative; color: #666;}
    #headerBody .hBG{position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;opacity: .85;}
    #headerFooter{height: 30px; background-color: #fff;}
    #headerHeader .native{width: 25px;height: 29px;background-repeat: no-repeat;background-position: 50%; padding: 0px !important;}
    #headerHeader .right{float: right; margin-right: 10px;}
    #headerHeader .right li{float: left; line-height: 28px;padding: 0px 10px;}
    #headerHeader .left{float: left; width: 300px;}
    #headerHeader .left li{float: left; line-height: 28px; padding: 0px 10px;}
    #headerHeader .nativeWrap{margin-left: 20px;margin-right: 10px;}
    #headerHeader .hhDropdown{height: 30px;float: left;line-height: 30px;text-indent: 10px; cursor: pointer;}
    #headerHeader .hhDropdown:hover{color: #fff;}
    #headerHeader .hhDropdown ul{display: none; position: absolute; background-color: #ccc;}
    #headerHeader .hhDropdown ul li{float: none; color: #666; text-align: left;}
    #headerHeader .hhDropdown ul li:hover{color: #fff;}
    #headerHeader .hhDropdown:hover ul{display: block;}
    #headerBody #inspireButt{cursor: pointer;float: right;height: 100px;margin-right: 10px;position: relative;line-height: 68px;font-size: 47px;color: #fff;font-family: ariel; width: 65px; text-align: right;}
    #headerBody #inspireButt:hover #inspireMenu{display: block;}
    #headerBody #inspireMenu{position: absolute; width: 300px; right: -17px; margin-top: 30px;display: none;}
    #headerBody #inspireMenu li{font-size: 18px;text-indent: 45px; line-height: 35px; position: relative;text-align: right;direction: rtl;}
    #headerBody #inspireMenu .subMenuBG{position: absolute;right: 0px;width: 30px;height: 30px;background-size: 464px;top: 0px;}
    #headerBody #inspireMenu .gtiTool{font-size: 14px; text-align: center;text-indent: 0px;}
    .arrow-up {width: 0;height: 0;border-left: 18px solid transparent; border-right: 18px solid transparent; border-bottom: 25px solid #008caf; position: absolute;bottom: 100%;right: 15px;}
    #theDropPad{position: fixed; background-color: #000; width: 100%; height: 100%; top: 0px; left: 0px;z-index: 1000000; opacity: .8; display: none;}
</style>
<div id="dahliaHeader">
    <div id="headerHeader">
        <ul class="left">
            <li>SIGN UP TODAY AND GET $10</li>
        </ul>
        <ul class="right">
            <li><a href="/contests">CONTESTS</a></li>
            <li><a href="/goodies">GOODIES</a></li>
            <li><a href="/hiw">HOW IT WORKS</a></li>
            <li><a href="/wolf-pack">PACK LEADERS</a></li>
            <li id="tourButton">HELP</li>
        </ul>
    </div>
    <div id="headerBody">
        <div class="hBG dahliaBGColor"></div>
        <div id="dahliaMainMenuButton"></div>
        <a href="/"><div id="dahliaLogo"></div></a>
        <ul id="mainMenu">
            <li><a href="/inspire"><span class="<?= $self == '/inspire.php' ? 'pinkMe' : '' ?>">INSPIRE</a></li>
            <li><a href="/sponsor"><span class="<?= $self == '/sponsor.php' ? 'pinkMe' : '' ?>">SPONSOR</a></li>
            <li><a href="/shop"><span class="<?= $self == '/shop/index.php' ? 'pinkMe' : '' ?>">SHOP</a></li>
        </ul>

        <div id="rightHandMenu">
            <div id="shoppingCart" <?= count($_data['cart']['products']) ? 'style="background-image: url(\'/images/shoppingCart_on.png\');"' : '' ?>>
                <?php if(count($_data['cart']['products'])): ?>
                    <a href="/shop/cart"><div class="cartCount"><?= getTotalProductsInCart($_data['cart']['products']) ?></div></a>
                    <ul id="dahliaCart">
                        <div class="cart_bezier"></div>
                        <?php foreach( $_data['cart']['products'] as $product ): ?>
                            <ul>
                                <li><img src="http://content.dahliawolf.com/shop/product/image.php?file_id=<?= $product['product_info']['product_file_id'] ?>&width=80"></li>
                                <li style="line-height: 20px;"><?= $product['product_info']['product_name'] ?></li>
                                <li>$<?= money_format('%i', ($product['product_info']['sale_price'] ? $product['product_info']['sale_price'] : $product['product_info']['price'])) ?></li>
                                <li><?= $product['attributes'] ?></li>
                                <li>Quantity <?= $product['quantity'] ?> </li>
                            </ul>
                        <?php endforeach ?>
                        <a href="/shop/cart"><li class="cta">Edit bag/ Check out</li></a>
                    </ul>
                <? else: ?>
                    <a href="/shop/cart"><div class="cartCount"></div></a>
                <? endif ?>
            </div>
            <div id="searchButton"></div>
            <? if(IS_LOGGED_IN): ?>
                <div id="userMenu">
                    <div class="avatarFrame theUsersAvatar"><a href="/<?= $_SESSION['user']['username'] ?>"><img src="<?= $userConfig['avatar'] ?>&width=100"></a></div>
                    <div class="userName"><a href="/<?= $_SESSION['user']['username'] ?>" style="color: #fff !important;"><?= $_SESSION['user']['username'] ?></a></div>
                    <ul id="theDropdown" class="dahliaBGColor">
                        <div class="arrow-up"></div>
                        <a href="/<?= $_SESSION['user']['username'] ?>"><li style="border-top: none;">Profile</li></a>
                        <a href="/<?= $_SESSION['user']['username'] ?>?dashboard=true"><li>Dashboard</li></a>
                        <a href="/activity"><li id="menuActivity">Activity</li></a>
                        <a href="/invite"><li id="menuClique">Grow My Clique</li></a>
                        <a href="/account/settings"><li>Settings</li></a>
                        <a href="/shop/my-orders"><li>Orders</li></a>
                        <a href="/action/logout"><li>Logout</li></a>
                    </ul>
                </div>
            <? else: ?>
                <ul class="loginDept">
                    <li onclick="loginscreen('login')">Login</li>
                    <li onclick="loginscreen('signup')">Signup</li>
                </ul>
            <? endif ?>
        </div>
        <div id="inspireButt">+
            <ul id="inspireMenu" class="dahliaBGColor">
                <div class="arrow-up"></div>
                <li><a href="/bank?feed=upload">UPLOAD A PICTURE<div class="spriteBG subMenuBG" style="background-position: -43px 305px;"></div></a></li>
                <li><a href="/bank?feed=tumblr">TUMBLR<div class="spriteBG subMenuBG" style="background-position: -108px 305px;"></div></a></li>
                <li><a href="/bank?feed=pinterest">PINTEREST<div class="spriteBG subMenuBG" style="background-position: -237px 305px;"></div></a></li>
                <li><a href="/bank?feed=instagram">INSTAGRAM<div class="spriteBG subMenuBG" style="background-position: -173px 305px;"></div></a></li>
                <li><a href="/bank?feed=dwolf">D/W IMAGE BANK<div class="spriteBG subMenuBG" style="background-position: -304px 304px;"></div></a></li>
                <li><a href="/bank?feed=web">ADD FROM WEBSITE<div class="spriteBG subMenuBG" style="background-position: -369px 305px;"></div></a></li>
                <li class="gtiTool"><a href="/pinit">GET THE INSPIRE TOOL</a></li>
            </ul>
        </div>
        <div id="searchBar">
            <input type="text" placeholder="Start typing to search...">
        </div>
    </div>
    <div id="headerFooter">
        <ul>
            <li><a href="/inspire">INSPIRE</a></li>
            <li><a href="/shop">SPONSOR</a></li>
            <li>SHOP</li>
        </ul>
    </div>
</div>

<div id="theDropPad"></div>

<script>
    $(function() {
        $(window).scroll(function() {
            var $headerHeader = $('#headerHeader');
            var $header = $('#dahliaHeader');
            var $dahliaLogo = $('#dahliaLogo');

            if( $(window).scrollTop() > 20 && $headerHeader.is(':visible') && !$headerHeader.is(':animated') ) {
                $headerHeader.slideUp(200);
                $dahliaLogo.addClass('logoTransformed');
            }
            if($(window).scrollTop() < 20 && !$headerHeader.is(':visible') && !$headerHeader.is(':animated')) {
                $headerHeader.slideDown(200);
                $dahliaLogo.removeClass('logoTransformed');
            }

            if($(window).scrollTop() < 0) {
                $header.css('top' , Math.abs($(window).scrollTop())+'px');
            } else {
                $header.css('top' , 0+'px');
            }
        });/*
        var position = $(window).scrollTop();
        var $footer = $('#footer');
        var rate = 35;
        var footerHeight = $footer.height() + 650;
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var $footerPos = parseFloat($footer.css('bottom'));
            if(position - rate < 35) {
                rate = position - rate;
            } else {
                rate = 35;
            }

            if(scroll > position && $footerPos > -footerHeight && scroll > 0) { //SCROLL DOWN
                if($footerPos > -footerHeight) {
                    if($footerPos - rate > -footerHeight)
                        $footer.css('bottom', $footerPos - rate);
                    else
                        $footer.css('bottom', -footerHeight);
                }
            } else if(scroll < position && $footerPos <= 0 && scroll > 0 && !($(window).scrollTop() + $(window).height() > $(document).height())) { //SCROLL UP
                if($footerPos + rate < 0)
                    $footer.css('bottom', ($footerPos + rate));
                else
                    $footer.css('bottom', 0);
            } else if(scroll < 0) {
                $footer.css('bottom', 0);
            }
            position = scroll;
        });*/
    });
</script>

<style>
    #mobile_Menu{position: fixed; height: 100%; width: 80%;top: 0px; left: -80%; z-index: 100000000; display: none;}
    #mobile_Menu li{height: 50px;line-height: 50px;font-size: 13px;color: #fff;text-indent: 5%; border-bottom: #fff thin solid;}
    #mobile_Menu ul ul{min-height: 50px;line-height: 50px;font-size: 13px;color: #fff;text-indent: 5%; border-bottom: #fff thin solid;}
    #mobile_Menu .hasSubs{background-color: #c2c2c2; background-image: url("/images/mobileNavChev.jpg");background-repeat: no-repeat;background-size: auto 50px;background-position: 115% 0px;}
    #mobile_Menu .hasSubs li{display: none;}
    #mobile_Menu .showSubs li{display: block !important; border-bottom: none !important; border-top: #fff thin solid;}
</style>
<div id="mobile_Menu" class="dahliaBGColor">
    <ul>
        <li>SEARCH ITEMS & PEOPLE</li>
        <li>LOGIN | SIGNUP</li>
        <li>CONTESTS</li>
        <li>GOODIES</li>
        <li>HOW IT WORKS</li>
        <li>CONNECT</li>
        <ul class="hasSubs">FAQ
                <li>BLOAH</li>
                <li>POOTY</li>
        </ul>
        <li>INFO</li>
        <li>LEGAL</li>
        <li>ABOUT</li>
        <li>PRESS</li>
    </ul>
</div>
<script>
    $(function() {
        $('#dahliaMainMenuButton').on('click', function() {
            if( !$('#mobile_Menu').is(':visible') ) {
                $('#mobile_Menu').show().animate({left:0});
                $('#dahliaHeader').animate({left:80+'%'});
            } else {
                $('#mobile_Menu').animate({left:'-'+80+'%'}, function() {
                    $(this).hide();
                });
                $('#dahliaHeader').animate({left:0});
            }
        });
        $('.hasSubs').on('click', function() {
            $(this).toggleClass('showSubs');
        });

        $('body').on('dragover', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#theDropPad').fadeIn(100);
        });

        $('body').on('dragleave', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('#theDropPad').fadeOut(100);
        });

        /*$('body').on('dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });*/

        $('body').on('drop', function(e){
            if(e.originalEvent.dataTransfer.files){
                if(e.originalEvent.dataTransfer.files.length) {
                    e.preventDefault();
                    e.stopPropagation();
                    new postUpload(e.originalEvent.dataTransfer.files[0]);
                }
            } else {
                alert('Drag and Drop not supported in your browser');
            }
        });
    });
</script>

<div id="theLesson" class="lessonBox">
    <div id="lesson-title" class="lesson-section"></div>
    <div class="lesson-line"></div>
    <div id="lesson-content" class="lesson-content"></div>
    <div class="lesson-steps">
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
    });
</script>


<form action="action/post_image.php" id="thePinForm" method="POST" class="Form PinForm" enctype="multipart/form-data">


<div id="post-me">
	<div id="u-clsr" onclick="imgUpload.closeMe()">X</div>
    <div class="uploader-frame">
    	<img id="user-uploaded-img" />
    </div>

        <input type="hidden" name="subpin" value="1">
        <div style="text-align: center;"><textarea name="description" id="comment">#dahliawolf</textarea></div>
        <div style="text-align: center;padding-bottom: 25px; margin-top: 10px;"><input name="submit" type="image" src="/images/postitbtn2.png" onclick="$(this).hide()" id="image-sub"></div>
</div>
</form>

<?php require_once 'blocks/system_messages.php'; ?>

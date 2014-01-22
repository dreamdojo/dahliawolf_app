<?php
?>

<style>
    #headerHeader{height: 28px;  color: #fff; background-color: #cccccc;font-size: 14px;}
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
    #theDropPad #dropUpdate{font-size: 80px;width: 100%;margin-top: -50px;text-align: center;height: 100px;top: 50%;position: absolute;}
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
                    <li><a href="/login" rel="pop">Login</a></li>
                    <li><a href="/signup" rel="pop">Signup</a></li>
                </ul>
            <? endif ?>
        </div>
        <div id="inspireButt">+
            <ul id="inspireMenu" class="dahliaBGColor">
                <div class="arrow-up"></div>
                <li style="padding-right: 42px;">
                    <form id="postUploadForm" action="/public_html/action/post_image.php" method="post" enctype="multipart/form-data">
                        <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="new postUpload(this.files[0]);">
                        <input type="hidden" name="takeMeBack" value="takemehome">
                    </form>
                    UPLOAD A PICTURE<div class="spriteBG subMenuBG" style="background-position: -43px 305px;"></div></li>
                <li><a href="/bank/tumblr">TUMBLR<div class="spriteBG subMenuBG" style="background-position: -108px 305px;"></div></a></li>
                <li><a href="/bank/pinterest">PINTEREST<div class="spriteBG subMenuBG" style="background-position: -237px 305px;"></div></a></li>
                <li><a href="/bank/instagram">INSTAGRAM<div class="spriteBG subMenuBG" style="background-position: -173px 305px;"></div></a></li>
                <li><a href="/bank/dahliawolf">D/W IMAGE BANK<div class="spriteBG subMenuBG" style="background-position: -304px 304px;"></div></a></li>
                <!--<li><a href="/bank/web">ADD FROM WEBSITE<div class="spriteBG subMenuBG" style="background-position: -369px 305px;"></div></a></li>-->
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

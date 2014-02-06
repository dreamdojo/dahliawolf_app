<?php
?>

<style>
    #headerHeader{height: 28px;  color: #666; background-color: #ebebeb;font-size: 12px;}
    #headerHeader a{color: #666;}
    #headerHeader a:hover{color: #666;}
    #headerBody{height: 65px; position: relative; color: #666;}
    #headerBody .hBG{position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;opacity: .95;}
    #headerFooter{height: 30px; background-color: #fff;}
    #headerFooter a{color: #74bf00;}
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
    #headerBody #inspireButt{cursor: pointer;float: right;height: 68px;margin-right: 10px;position: relative;line-height: 65px;font-size: 47px;color: #666; width: 65px; text-align: right;}
    #headerBody #inspireButt:hover #inspireMenu{display: block;}
    #headerBody #inspireButt .inspGraph{border: #CFCFCF thin solid; color:#ebebeb; height: 30px;width: 30px;line-height: 28px;margin-top: 18px;font-size: 32px;border-radius: 4px;text-align: center;float: right;}
    #headerBody #inspireMenu{position: absolute; width: 225px; right: -1px; margin-top: 65px;display: none; background-color: #ebebeb; box-shadow: #000 0px 1px 4px 0px;}
    #headerBody #inspireMenu li{font-size: 14px;text-indent: 45px; line-height: 35px; position: relative;text-align: right;direction: rtl; border-bottom: #666 thin solid;}
    #headerBody #inspireMenu li:hover{background-color:#909090; color: #fff;}
    #headerBody #inspireMenu li:hover a{color: #fff;}
    #headerBody #inspireMenu li a{color: #666;}
    #headerBody #inspireMenu .subMenuBG{position: absolute;right: 0px;width: 30px;height: 30px;background-size: 464px;top: 0px;}
    #headerBody #inspireMenu .dda{font-size: 15px;text-align: center;height: 60px;background-color: #ebebeb; padding-top: 5px; border-bottom: #666 thin solid;}
    #headerBody #inspireMenu .dda p{margin-top: 9px;width: 84%; border: #666 2px dotted;margin-left: 8%;height: 30px;line-height: 30px;font-size: 12px;}
    #headerBody #inspireMenu .gtiTool{font-size: 14px; text-align: center;text-indent: 0px;}
    #headerBody .logged-in .loginDept{width: 265px;}
    .arrow-up {width: 0;height: 0;border-left: 18px solid transparent; border-right: 18px solid transparent; border-bottom: 25px solid #008caf; position: absolute;bottom: 100%;right: 15px;}
</style>
<div id="dahliaHeader">
    <div id="headerHeader">
        <ul class="right">
            <!--<li><a href="/contests">CONTESTS</a></li>-->
            <li><a href="/goodies">GOODIES</a></li>
            <!--<li><a href="/hiw">HOW IT WORKS</a></li>-->
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
            <!--<li><a href="/sponsor"><span class="<?= $self == '/sponsor/index.php' ? 'pinkMe' : '' ?>">SPONSOR</a></li>-->
            <li><a href="/shop"><span class="<?= $self == '/shop/index.php' ? 'pinkMe' : '' ?>">SHOP</a></li>
        </ul>

        <div id="rightHandMenu" class="<?= IS_LOGGED_IN ? 'logged-in' : 'not-logged-in' ?>">
            <div id="userMenuFrame">
                <?php if(IS_LOGGED_IN) require_once $_SERVER['DOCUMENT_ROOT'] . '/blocks/userMenu.php'; ?>
            </div>
            <ul class="loginDept">
                <?php if(!IS_LOGGED_IN): ?>
                    <li><a href="/signup" rel="pop">Join</a></li>
                    <li style="color: #fff;">$10 SIGN UP BONUS!</li>
                    <li style="border-left: #80c6d7 thin solid;
border-right: #80c6d7 thin solid;
padding-right: 10px;
padding-left: 10px;"><a href="/login" rel="pop">Login</a></li>
                <? endif ?>
            </ul>
            <div id="shoppingCart">
                <?php if(count($_data['cart']['products'])): ?>
                    <a href="/shop/cart">
                        <div class="cartCount spriteBG <?= count($_data['cart']['products']) ? 'fullCart' : 'emptyCart' ?>"><?= getTotalProductsInCart($_data['cart']['products']) ?></div>
                    </a>
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
                    <div class="cartCount spriteBG <?= count($_data['cart']['products']) ? 'fullCart' : 'emptyCart' ?>"><?= count($_data['cart']['products']) ? getTotalProductsInCart($_data['cart']['products']) : '' ?></div>
                <? endif ?>
            </div>
            <div id="searchButton" class="spriteBG"></div>
        </div>
        <?php if(IS_LOGGED_IN): ?>
            <div id="inspireButt">
                <div class="inspGraph">+</div>
                <ul id="inspireMenu">
                    <li style="padding-right: 42px;">
                        <form id="postUploadForm" action="/action/post_image.php" method="post" enctype="multipart/form-data">
                            <input type="file" src="/images/btn/my-images-butt.jpg" name="iurl" id="file" onChange="new postUpload(this.files[0]);">
                            <input type="hidden" name="takeMeBack" value="takemehome">
                        </form>
                        UPLOAD A PICTURE<div class="spriteBG subMenuBG" style="background-position: -46px 419px;"></div></li>
                    <li><a href="/bank/tumblr">TUMBLR<div class="spriteBG subMenuBG" style="background-position: -110px 419px;"></div></a></li>
                    <li><a href="/bank/pinterest">PINTEREST<div class="spriteBG subMenuBG" style="background-position: -240px 419px;"></div></a></li>
                    <li><a href="/bank/instagram">INSTAGRAM<div class="spriteBG subMenuBG" style="background-position: -176px 419px;"></div></a></li>
                    <li><a href="/bank/dahliawolf">D/W IMAGE BANK<div class="spriteBG subMenuBG" style="background-position: -359px 689px;"></div></a></li>
                    <!--<li><a href="/bank/web">ADD FROM WEBSITE<div class="spriteBG subMenuBG" style="background-position: -369px 305px;"></div></a></li>-->
                    <div class="dda">
                        <p>DRAG AND DROP ANYWHERE</p>
                    </div>
                    <li class="gtiTool"><a href="/pinit">GET THE INSPIRE TOOL</a></li>
                </ul>
            </div>
        <? endif ?>
        <div id="searchBar">
            <input type="text" placeholder="Start typing to search...">
        </div>
    </div>
    <div id="headerFooter">
        <ul>
            <li><a href="/inspire">INSPIRE</a></li>
            <!--<li><a href="/sponsor">SPONSOR</a></li>-->
            <li><a href="/shop">SHOP</a></li>
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

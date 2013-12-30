<?php
    $pageTitle = "Homepage";
    if(isset($_COOKIE["dahliaUser"]) && isset($_COOKIE["token"])){
        $_SESSION['user'] = unserialize($_COOKIE["dahliaUser"]);
        $_SESSION['token'] = $_COOKIE["token"];
    }
    include "head.php";
    include "header.php";
?>
<style>
    #hpWrapper .paraBG{}
    #hpWrapper #movieFrame video{width: 100%;}
    #hpWrapper .top{background-color: #fff; position: relative; z-index: 10;}
    #hpWrapper .top img{width: 100%;}
    #hpWrapper .infoCol{width: 1000px; margin: 0px auto; padding-top: 50px; padding-bottom: 100px;}
    #hpWrapper .infoCol ul{width: 50%; float: left;}
    #hpWrapper .infoCol .leftCol{padding-top: 50px; border-top: #666 5px solid;}
    #hpWrapper .infoCol .rightCol{text-align: center;}
    #hpWrapper .infoCol .rightCol li{margin-left: 25px; text-align: left;}
    #hpWrapper .infoCol .rightCol .subHead{padding-top: 15px;}
    #hpWrapper .infoCol .leftCol li{font-size: 50px;border-bottom: #c2c2c2 thin solid;}
    #pressBanner{border-bottom: #c2c2c2 thin solid; text-align: center;}
    #pressBanner ul{width: 1000px;margin: 0px auto;height: 50px;line-height: 50px;}
    #pressBanner ul li{float: left; width: 20%;}
    section{min-height: 500px; background-color: #fff;}
    .expSect{position: relative; z-index: 10;}

    .bgWrap{position: fixed;overflow: hidden;height: 100%;width: 100%;z-index: -1;top: 0px;left: 0px;}
    .paraBG{background-size: cover; position: absolute; top:0px; left: 0px; z-index: -1; background-repeat: no-repeat; height: 100%;width: 100%;}

    .noBG{background-color: transparent !important;}
    .dahliaColor{color: #009bba !important;}
    .dahliaBGColor{background-color: #009bba !important;}
    #hpWrapper .smallIcon{width: 25px; float: left;}
    #hpWrapper h1{margin: 0px;line-height: 30px;text-indent: 10px; font-size: 23px;}
    .explanation{font-size: 16px; color: #a5a5a5; margin-top: 10px;}
    .hp_cta{background-image: url("/public_html/images/hp_cta_bg.jpg"); text-align: center; width: 100%; height: 250px;}
    .hp_cta li:first-child{font-size: 30px;padding-top: 20px;padding-bottom: 20px;}
    .hp_cta .gs_button{background-color: #666;color: #fff;width: 200px;height: 50px;line-height: 50px;border-radius: 12px;margin: 35px auto; font-size: 16px;}
    #footer{height: 500px;}
</style>

<div id="hpWrapper">
    <section class="top">
            <img src="/public_html/images/hpVideoBanner.jpg">
        <div id="pressBanner">
            <img style="width: 1000px;" src="/public_html/images/asaBar.jpg">
        </div>
    </section>
    <section class="expSect">
        <div class="infoCol" >
            <ul class="leftCol">
                <li class="dahliaColor">WHAT IS IT?</li>
                <li>INSPIRE</li>
                <li>SPONSOR</li>
                <li>SHOP</li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/public_html/images/hp_hiw_poster.jpg"></li>
                <li><img class="smallIcon" src="/public_html/images/hp_cam.jpg"><h1>Watch the How It Works video</h1></li>
                <li class="explanation">Dahlia Wolf a platform that allows user to create their own fashion brand without the difficulty of having to learn how to sketch or navigating the complexities of working with manufacturers. By allowing users to upload images of items they love or by hand selecting images of items in our truly innovative image bank they can inspire a new design. If selected to be manufactured by our community of fashionista’s we create an entirely new product to be sold on our site and the profits are then shared with the members who inspired the products.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <div id="bgWrap1" class="bgWrap" style="z-index: 4;"><div class="paraBG" style="background-image: url('/public_html/images/hpBG-1.jpg')"></div></div>
    <div id="bgWrap2" class="bgWrap" style="z-index: 3;"><div class="paraBG" style="background-image: url('/public_html/images/hpBG-2.jpg')"></div></div>
    <div id="bgWrap3" class="bgWrap" style="z-index: 2;"><div class="paraBG" style="background-image: url('/public_html/images/hpBG-3.jpg')"></div></div>
    <section class="noBG">
    </section>
    <section class="expSect">
        <div class="infoCol" >
            <ul class="leftCol">
                <li>WHAT IS IT?</li>
                <li class="dahliaColor">INSPIRE</li>
                <li>SPONSOR</li>
                <li>SHOP</li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/public_html/images/hp_post_vote.jpg"></li>
                <li class="subHead"><img class="smallIcon" src="/public_html/images/hp_inspire_img.jpg"><h1>Inspire new fashion by posting images</h1></li>
                <li class="explanation">Inspire new fashion by posting images of clothes you want to bring to life. It’s simple post an image and let other members vote on it. If it gets enough votes we will turn it into a one of a kind original piece of clothing & send it to you for FREE! </li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="noBG">

    </section>
    <section class="expSect">
        <div class="infoCol" >
            <ul class="leftCol">
                <li>WHAT IS IT?</li>
                <li>INSPIRE</li>
                <li class="dahliaColor">SPONSOR</li>
                <li>SHOP</li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/public_html/images/hp_sponsor_img.jpg"></li>
                <li class="subHead"><img class="smallIcon" src="/public_html/images/hp_inspire_img.jpg"><h1>What does it mean to sponsor an item?</h1></li>
                <li class="explanation">Sponser members designs to have them sold in the shop. Earn commission when they sell Once an image has inspired new clothing members will have the oppurtunity to sponser the item. Sponsers will then make commision everytime that item sells in the shop.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="noBG">

    </section>
    <section class="expSect">
        <div class="infoCol" >
            <ul class="leftCol">
                <li>WHAT IS IT?</li>
                <li>INSPIRE</li>
                <li>SPONSOR</li>
                <li class="dahliaColor">SHOP</li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/public_html/images/hp_shop_img.jpg"></li>
                <li class="subHead"><img class="smallIcon" src="/public_html/images/hp_inspire_img.jpg"><h1>Not just another online shop</h1></li>
                <li class="explanation">All the designs in our shop are made by the people for the people Experience a truly unique shop, browse designs made by our community and manufactured with with the highest quality in the industry.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="expSect">
        <ul class="hp_cta">
            <li>This is your chance to design your own fashion</li>
            <li><h2>it all starts with simply posting an image, so what are you are waiting for?</h2></li>
            <li class="gs_button">GET STARTED</li>
        </ul>
        <div id="footer" class="dahliaBGColor"></div>
    </section>
</div>

<?php include "footer.php"; ?>

<script>
    $(function() {
        $('.paraBG').height(window.innerHeight);
        $(window).scroll(function() {
           $('.paraBg').height(window.innerHeight);
           $('#bgWrap1').height( $('.expSect').eq(1).offset().top - $(window).scrollTop() );
           $('#bgWrap2').height( $('.expSect').eq(2).offset().top - $(window).scrollTop() );
        }).resize(function() {
            $('.paraBg').height(window.innerHeight);
        });


    })
</script>
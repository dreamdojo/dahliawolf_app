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
    #hpWrapper .top{background-color: #fff; position: relative; z-index: 10; background-position: 50%;}
    #hpWrapper .top img{width: 100%;}
    #hpWrapper .infoCol{width: 1000px; margin: 0px auto; padding-top: 50px; padding-bottom: 50px;}
    #hpWrapper .infoCol ul{width: 48%; margin-right: 2%; float: left;}
    #hpWrapper .infoCol .leftCol{padding-top: 50px; border-top: #666 5px solid; font-weight: 900;}
    #hpWrapper .infoCol .rightCol #hiw-video{width: 450px;}
    #hpWrapper .infoCol .rightCol .sectionIcon{width: 35px; height: 35px;float: left;background-size: 395px;}
    #hpWrapper .infoCol .rightCol .sponsorIcon{background-position: -187px -281px;}
    #hpWrapper .infoCol .rightCol .inspireIcon{background-position: -145px -281px;}
    #hpWrapper .infoCol .rightCol .shopIcon{background-position: -229px -281px;}
    #hpWrapper .infoCol .rightCol .hiwIcon{background-position: -272px -281px;}
    #hpWrapper .infoCol .rightCol{text-align: center;}
    #hpWrapper .infoCol .rightCol li{margin-left: 25px; text-align: left;}
    #hpWrapper .infoCol .rightCol .subHead{padding-top: 15px;}
    #hpWrapper .infoCol .leftCol li{font-size: 50px;border-bottom: #c2c2c2 thin solid;}
    #pressBanner{border-bottom: #c2c2c2 thin solid; text-align: center;position: relative;z-index: 108;background-color: #fff;}
    #pressBanner ul{width: 1000px;margin: 0px auto;height: 50px;line-height: 50px;}
    #pressBanner ul li{float: left; width: 20%;}
    section{min-height: 500px; background-color: #fff; color: #666;}
    .expSect{position: relative; z-index: 10;}

    .bgWrap{position: fixed;overflow: hidden;height: 100%;width: 100%;z-index: -1;top: 0px;left: 0px;}
    .paraBG{background-size: cover; position: absolute; top:0px; left: 0px; z-index: -1; background-repeat: no-repeat; height: 100%;width: 100%; background-position: 50% 0px;}

    .noBG{background-color: transparent !important;}
    #hpWrapper .smallIcon{width: 25px; float: left;}
    #hpWrapper h1{margin: 0px;line-height: 30px;text-indent: 10px; font-size: 23px;}
    .explanation{font-size: 16px; color: #a5a5a5; margin-top: 10px;}
    .hp_cta{background-image: url("/images/hp_cta_bg.jpg"); text-align: center; width: 100%; height: 250px;}
    .hp_cta li:first-child{font-size: 30px;padding-top: 20px;padding-bottom: 7px;font-weight: bold;}
    .hp_cta .gs_button{background-color: #74bf00;color: #fff;width: 200px;height: 50px;line-height: 50px;border-radius: 12px;margin: 35px auto; font-size: 16px;font-size: 16px !important;padding-bottom: 0px !important; padding-top: 0px !important;}
</style>

<div id="hpWrapper">
    <section class="top" style="background-image: url('/images/hpVideoBanner.jpg');">
    </section>
    <div id="pressBanner">
        <img style="width: 1000px;" src="/images/asaBar.jpg">
    </div>
    <section id="whatisit" class="expSect">
        <div class="infoCol">
            <ul class="leftCol">
                <li class="dahliaColor">WHAT IS IT?</li>
                <li><a href="#inspire">INSPIRE</a></li>
                <li><a href="#sponsor">SPONSOR</a></li>
                <li><a href="#shop">SHOP</a></li>
            </ul>
            <ul class="rightCol">
                <li>
                    <video id="hiw-video" poster="/images/poster.png">
                        <source src="/images/video/HIW.mp4">
                        <source src="/images/video/HIW.ogv">
                    </video>
                </li>
                <li style="margin-top: 15px;"><div class="sectionIcon spriteBG hiwIcon"></div><h1>Watch the How It Works video</h1></li>
                <li class="explanation">Dahlia Wolf a platform that allows user to create their own fashion brand without the difficulty of having to learn how to sketch or navigating the complexities of working with manufacturers.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <div id="bgWrap1" class="bgWrap" style="z-index: 4;"><div id="BG1" class="paraBG" style="background-image: url('/images/hpBG-1.jpg')"></div></div>
    <div id="bgWrap2" class="bgWrap" style="z-index: 3;"><div id="BG2" class="paraBG" style="background-image: url('/images/hpBG-2.jpg')"></div></div>
    <div id="bgWrap3" class="bgWrap" style="z-index: 2;"><div id="BG3" class="paraBG" style="background-image: url('/images/hpBG-3.jpg')"></div></div>
    <section class="noBG">
    </section>
    <section class="expSect" id="inspire">
        <div class="infoCol" >
            <ul class="leftCol">
                <li><a href="#whatisit">WHAT IS IT?</a></li>
                <li class="dahliaColor">INSPIRE</li>
                <li><a href="#sponsor">SPONSOR</a></li>
                <li><a href="#shop">SHOP</a></li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_inspire_img.jpg"></li>
                <li class="subHead"><div class="sectionIcon spriteBG inspireIcon"></div><h1>Inspire new fashion by posting images</h1></li>
                <li class="explanation">Inspire new fashion by posting images of clothes you want to bring to life. It’s simple post an image and let other members vote on it. If it gets enough votes we will turn it into a one of a kind original piece of clothing & send it to you for FREE!</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="noBG">

    </section>
    <section class="expSect" id="sponsor">
        <div class="infoCol" >
            <ul class="leftCol">
                <li><a href="#whatisit">WHAT IS IT?</a></li>
                <li><a href="#inspire">INSPIRE</a></li>
                <li class="dahliaColor">SPONSOR</li>
                <li><a href="#shop">SHOP</a></li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_sponsor_img.jpg"></li>
                <li class="subHead"><div class="sectionIcon spriteBG sponsorIcon"></div><h1>What does it mean to sponsor an item?</h1></li>
                <li class="explanation">Sponser members designs to have them sold in the shop. Earn commission when they sell Once an image has inspired new clothing members will have the oppurtunity to sponser the item. Sponsers will then make commision everytime that item sells in the shop.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="noBG">

    </section>
    <section class="expSect" id="shop">
        <div class="infoCol" >
            <ul class="leftCol">
                <li><a href="#whatisit">WHAT IS IT?</a></li>
                <li><a href="#inspire">INSPIRE</a></li>
                <li><a href="#sponsor">SPONSOR</a></li>
                <li class="dahliaColor">SHOP</li>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_shop_img.jpg"></li>
                <li class="subHead"><div class="sectionIcon spriteBG shopIcon"></div><h1>Not just another online shop</h1></li>
                <li class="explanation">All the designs in our shop are made by the people for the people. Experience a truly unique shop, browse designs made by our community and manufactured with with the highest quality in the industry.</li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="expSect" style="min-height: 250px;">
        <ul class="hp_cta">
            <li>This is your chance to design your own fashion</li>
            <li><h2 style="font-size: 17px;">It all starts with simply posting an image, so what are you are waiting for?</h2></li>
            <a href="/signup" style="color: #fff;"><li class="gs_button">GET STARTED</li></a>
        </ul>
    </section>
</div>

<?php include "footer.php"; ?>

<script>
    $(function() {
        $('#hiw-video').hover(function() {
            console.log('hoverd');
            $('#hiw-video').attr('controls', true);
        }, function() {
            $('#hiw-video').attr('controls', false);
        });
        hpresize();
        $(window).scroll(hpresize).resize(hpresize);
        $('a[href^="#"]').on('click',function (e) {
            e.preventDefault();

            var target = this.hash,
                $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': ($target.offset().top-60)
            }, 900, 'swing', function () {
                window.location.hash = target;
            });
        });
    })

function hpresize() {
    var scrollPos = $(window).scrollTop();
    console.log(scrollPos);
    $('.paraBg').height(window.innerHeight);
    $('#bgWrap1').height( $('.expSect').eq(1).offset().top - $(window).scrollTop() );
    $('#bgWrap2').height( $('.expSect').eq(2).offset().top - $(window).scrollTop() );
    $('#bgWrap3').height( $('.expSect').eq(3).offset().top - $(window).scrollTop() );
    /*if(scrollPos > 300 && scrollPos < 2000) {
     $('#BG1').css('background-position', 50+'%'+' '+-scrollPos *.1+'px');
     } else if(scrollPos > 2000 && scrollPos < 4000) {
     $('#BG2').css('background-position', 50+'%'+' '+-scrollPos *.01+'px');
     }*/
}
</script>
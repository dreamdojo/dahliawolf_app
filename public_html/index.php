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
    #hpWrapper .top{background-color: #fff; position: relative; z-index: 10; background-position: 50%; height: 430px; min-height: 0px !important;}
    #hpWrapper .top img{width: 100%;}
    #hpWrapper .infoCol{width: 1000px; margin: 0px auto; padding-top: 65px; padding-bottom: 65px;}
    #hpWrapper .infoCol ul{width: 48%; margin-right: 2%; float: left;}
    #hpWrapper .infoCol .leftCol{padding-top: 119px; font-weight: 900;}
    #hpWrapper .infoCol .rightCol #hiw-video{width: 450px;}
    #hpWrapper .infoCol .rightCol .sectionIcon{width: 35px; height: 35px;float: left;background-size: 395px;}
    #hpWrapper .infoCol .rightCol .sponsorIcon{background-position: -187px -281px;}
    #hpWrapper .infoCol .rightCol .inspireIcon{background-position: -145px -281px;}
    #hpWrapper .infoCol .rightCol .shopIcon{background-position: -229px -281px;}
    #hpWrapper .infoCol .rightCol .hiwIcon{background-position: -272px -281px;}
    #hpWrapper .infoCol .rightCol{text-align: center; padding-top: 0px;}
    #hpWrapper .infoCol .rightCol li{margin-left: 25px; text-align: left;}
    #hpWrapper .infoCol .rightCol .subHead{padding-top: 15px;}
    #hpWrapper .infoCol .leftCol h1{font-size: 53px;font-weight: 800; line-height: 53px; text-indent: 0px;}
    #hpWrapper .infoCol .leftCol h3{font-size: 20px;font-weight: 300;line-height: 30px;margin-top: 10px;}

    #pressBanner{border-bottom: #c2c2c2 thin solid; text-align: center;position: relative;z-index: 108;background-color: #fff;}
    #pressBanner ul{width: 1000px;margin: 0px auto;height: 50px;line-height: 50px;}
    #pressBanner ul li{float: left; width: 20%;}
    section{min-height: 485px; background-color: #fff; color: #666;}
    section .nextSect{position: absolute;left: 50%;margin-left: -16.5px;bottom: 0px;}
    .expSect{position: relative; z-index: 10;}

    .bgWrap{position: fixed;overflow: hidden;height: 100%;width: 100%;z-index: -1;top: 0px;left: 0px;}
    .paraBG{background-size: cover; position: absolute; top:0px; left: 0px; z-index: -1; background-repeat: no-repeat; height: 100%;width: 100%; background-position: 50% 0px;}

    .noBG{height: 1000px; background-size: cover; background-repeat: no-repeat; background-attachment: fixed;}
    #hpWrapper .smallIcon{width: 25px; float: left;}
    #hpWrapper h1{margin: 0px;line-height: 30px;text-indent: 10px; font-size: 23px;}
    .explanation{font-size: 16px; color: #a5a5a5; margin-top: 10px;}
    .hp_cta{background-image: url("/images/hp_cta_bg.jpg"); text-align: center; width: 100%; height: 215px;}
    .hp_cta li:first-child{font-size: 30px;padding-top: 20px;padding-bottom: 7px;font-weight: bold;}
    .hp_cta .gs_button{background-color: #74bf00;color: #fff;width: 200px;height: 50px;line-height: 50px;border-radius: 12px;margin: 35px auto; font-size: 16px;font-size: 16px !important;padding-bottom: 0px !important; padding-top: 0px !important;}
    .dahliaCarasoul{position: absolute;width: 100%;height: 100%;overflow: hidden;}
    .dahliaCarasoul li{position: absolute; width: 100%; height: 100%; background-position: 50%; background-size: cover; background-repeat: no-repeat; display: none; z-index: 1;}
    .dahliaCarasoul .activeFrame{z-index: 2; display: block !important;}
</style>

<div id="hpWrapper">
    <section class="top">
        <ul class="dahliaCarasoul">
            <li style="background-image: url('/images/heroBanner1.jpg');" class="activeFrame firstFrame"></li>
            <li style="background-image: url('/images/heroBanner2.jpg')"></li>
            <li style="background-image: url('/images/heroBanner3.jpg')"></li>
        </ul>
    </section>
    <div id="pressBanner">
        <img style="width: 1000px;" src="/images/asaBar.jpg">
    </div>
    <section id="whatisit" class="expSect">
        <div class="infoCol">
            <ul class="leftCol">
                <h1>WHAT IS IT?</h1>
                <h3>Dahlia Wolf is a platform that allows isers to create their own fashion brand.</h3>
            </ul>
            <ul class="rightCol">
                <li>
                    <video id="hiw-video" poster="/images/poster.png">
                        <source src="/images/video/HIW.mp4">
                        <source src="/images/video/HIW.ogv">
                    </video>
                </li>
            </ul>
            <div style="clear: left;"></div>
        </div>
        <a href="#inspire"><img class="nextSect" src="/images/arrowDown.png"></a>
    </section>
    <section class="noBG" style="background-image: url('/images/hpBG-1.jpg')" data-stellar-background-ratio="0.2">
    </section>
    <section class="expSect" id="inspire">
        <div class="infoCol" >
            <ul class="leftCol">
                <h1>INSPIRE</h1>
                <h3>Inspire new fashion by posting images of clothes you want to bring to life.</h3>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_inspire_img.jpg"></li>
            </ul>
            <div style="clear: left;"></div>
        </div>
        <a href="#sponsor"><img class="nextSect" src="/images/arrowDown.png"></a>
    </section>
    <section class="noBG" style="background-image: url('/images/hpBG-2.jpg')" data-stellar-background-ratio="0.2">

    </section>
    <section class="expSect" id="sponsor">
        <div class="infoCol" >
            <ul class="leftCol">
                <h1>SPONSOR</h1>
                <h3>Sponsor members designs to have them sold in the shop. Earn commission when they sell.</h3>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_sponsor_img.jpg"></li>
            </ul>
            <div style="clear: left;"></div>
        </div>
        <a href="#shop"><img class="nextSect" src="/images/arrowDown.png"></a>
    </section>
    <section class="noBG" style="background-image: url('/images/hpBG-3.jpg')" data-stellar-background-ratio="0.2">

    </section>
    <section class="expSect" id="shop">
        <div class="infoCol" >
            <ul class="leftCol">
                <h1>SHOP</h1>
                <h3>All the designs in out shop are made by the poeple for the people</h3>
            </ul>
            <ul class="rightCol">
                <li><img style="width: 100%;" src="/images/hp_shop_img.jpg"></li>
            </ul>
            <div style="clear: left;"></div>
        </div>
    </section>
    <section class="expSect" style="min-height: 215px;">
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
        $.stellar({
            horizontalScrolling: false
        });
        $('#hiw-video').hover(function() {
            $('#hiw-video').attr('controls', true);
        }, function() {
            $('#hiw-video').attr('controls', false);
        }).on('click', function() {
               this.play();
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

        setInterval(function() {
            var $next;

            if($('.activeFrame').next().length) {
                $next = $('.activeFrame').next();
            } else {
                $next = $('.firstFrame');
            }

            $next.fadeIn(1000);
            $('.activeFrame').fadeOut(1000, function() {
                $(this).removeClass('activeFrame');
                $next.addClass('activeFrame');
            });
        }, 5000);

    })

function hpresize() {
    var scrollPos = $(window).scrollTop();
    //console.log(scrollPos);
    //$('.paraBG').height(window.innerHeight);
    //$('.noBG').eq(0).css('background-position', 0+'px -'+($(window).scrollTop() - window.innerHeight)+'px');
    //$('#bgWrap2').height( $('.expSect').eq(2).offset().top - $(window).scrollTop() );
    //$('#bgWrap3').height( $('.expSect').eq(3).offset().top - $(window).scrollTop() );
    /*if(scrollPos > 300 && scrollPos < 2000) {
     $('#BG1').css('background-position', 50+'%'+' '+-scrollPos *.1+'px');
     } else if(scrollPos > 2000 && scrollPos < 4000) {
     $('#BG2').css('background-position', 50+'%'+' '+-scrollPos *.01+'px');
     }*/
}
</script>
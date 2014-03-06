<?
$pageTitle = "Help";
include "head.php";
include "header.php";
//include "post_slideout.php";
?>
    <style>
        .contentWrap{max-width: 100%;}
        #howItWorks video{width: 100%;}
        #howItWorks .noBG{height: 727px;}
        #howItWorks .infoBanner{height: 350px; text-align: center;}
        #howItWorks .infoBanner h1{font-size: 45px;padding-top: 90px;font-weight: 700;color: #3A3A3A;}
        #howItWorks .infoBanner h2{font-size: 23px;margin-top: 15px;}
        #howItWorks .infoBanner button{margin-top: 29px;padding: 12px 25px;}
        #howItWorks #hiwFooter{height: 250px;padding-top: 100px;max-width: 980px;margin: 0px auto;width: 100%;;}
        #howItWorks #hiwFooter>li{width: 33%;float: left;min-width: 250px;margin-bottom: 10px;}
        #howItWorks #hiwFooter>li .aliModule{margin: 0px auto;}
        #howItWorks .videoHome{width: 100%; position: relative; height: 400px;}
        #howItWorks .videoHome .poster{position: absolute;width: 100%;height: 100%;background-size: cover;background-position: 50%; z-index: 5;}
        #howItWorks video{height: 100%;margin: 0px auto;}

        @media screen and (max-width : 500px) {
            #howItWorks #hiwFooter>li{width: 100%;}
        }
    </style>
    <div id="howItWorks">
        <div class="videoHome">
            <div class="poster" style="background-image: url(/images/hiw/hpVideoBanner.jpg);"></div>
            <video id="howItWorksVideo" controls>
                <source src="/images/video/HIW.ogv">
                <source src="/images/video/HIW.mp4">
            </video>
        </div>
        <ul class="infoBanner">
            <li><h1>Inspire fashion</h1></li>
            <li><h2>Post and HYPE your favorite fashion images</h2></li>
            <li>
                <a href="/shop">
                    <button class="btn btn-lg btn-success">DISCOVER NOW</button>
                </a>
            </li>
        </ul>
        <section class="noBG" style="background-image: url(/images/hiw/hiw_01.jpg);" data-stellar-background-ratio="0.2"></section>
        <ul class="infoBanner">
            <li><h1>Sponsor Collections</h1></li>
            <li><h2>Sponsor new styles by ordering them & receive discounts for early support</h2></li>
            <li>
                <a href="/sponsor">
                    <button class="btn btn-lg btn-success">DISCOVER NOW</button>
                </a>
            </li>
        </ul>
        <section class="noBG" style="background-image: url(/images/hiw/hiw_02.jpg);" data-stellar-background-ratio="0.2"></section>
        <ul class="infoBanner">
            <li><h1>The Shop</h1></li>
            <li><h2>All the designs in our shop are member inspired and shipped for free!</h2></li>
            <li>
                <a href="/shop">
                    <button class="btn btn-lg btn-success">DISCOVER NOW</button>
                </a>
            </li>
        </ul>
        <section class="noBG" style="background-image: url(/images/hiw/hiw_03.jpg);" data-stellar-background-ratio="0.2"></section>
        <ul id="hiwFooter">
            <li>
                <ul class="aliModule">
                    <li class="title">SPONSOR</li>
                    <li class="explanation">Find out more about sponsoring items and making commission.</li>
                    <a ng-href="/shop">
                        <li class="grnButton dahliaGreenBG">LEARN MORE</li>
                    </a>
                </ul>
            </li>
            <li>
                <ul class="aliModule">
                    <li class="title">MY ACCOUNT</li>
                    <li class="explanation">Payment options. Shipping and delivery returns</li>
                    <a ng-href="/shipping">
                        <li class="grnButton dahliaGreenBG">MY ACCOUNT</li>
                    </a>
                </ul>
            </li>
            <li>
                <ul class="aliModule">
                    <li class="title">FAQ</li>
                    <li class="explanation">Have a question? Check the FAQ section its full of great info.</li>
                    <a ng-href="/faqs">
                        <li class="grnButton dahliaGreenBG">LEARN MORE</li>
                    </a>
                </ul>
            </li>
        </ul>
    </div>

    <script>
        $(function() {
            $.stellar({
                horizontalScrolling: false
            });
            $('.poster').on('click', function() {
                $(this).fadeOut(400, function() {
                    document.getElementById('howItWorksVideo').play();
                });
            });
        });
    </script>

<?
include "footer.php";
?>
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
    #hpWrapper .top{background-color: #fff;}
    #hpWrapper .infoCol{width: 1000px; margin: 0px auto; padding-top: 50px;}
    #hpWrapper .infoCol ul{width: 50%; float: left;}
    #hpWrapper .infoCol .leftCol{padding-top: 50px; border-top: #666 5px solid;}
    #hpWrapper .infoCol .rightCol{text-align: center;}
    #hpWrapper .infoCol .leftCol li{font-size: 50px;border-bottom: #c2c2c2 thin solid;}
    #pressBanner{border-bottom: #c2c2c2 thin solid;}
    #pressBanner ul{width: 1000px;margin: 0px auto;height: 50px;line-height: 50px;}
    #pressBanner ul li{float: left; width: 20%;}
    section{min-height: 1000px; background-color: #fff;}
    .paraBG{-o-background-size: 100% auto; position: fixed; top:0px; left: 0px; z-index: -1; background-repeat: no-repeat; height: 100%;width: 100%;}
    .noBG{background-color: transparent !important;}
</style>

<div id="hpWrapper">
    <section class="top">
        <div id="movieFrame">
            <video src="/images/video/hiw_mobile.mp4" poster="/images/hpVideoBanner.jpg">

            </video>
        </div>
        <div id="pressBanner">
            <ul>
                <li>AS SEEN IN:</li>
                <li>EXTRA</li>
                <li>YAHOO</li>
                <li>YAHOO</li>
                <li>YAHOO</li>
            </ul>
        </div>
    </section>
    <section>
        <div class="infoCol" >
            <ul class="leftCol">
                <li>WHAT IS IT?</li>
                <li>INSPIRE</li>
                <li>SPONSOR</li>
                <li>SHOP</li>
            </ul>
            <ul class="rightCol">
                <li></li>
                <li><h3>Watch the How It Works video</h3></li>
                <li></li>
            </ul>
        </div>
    </section>
    <section class="paraBG" style="background-image: url('/images/hpBG-1.jpg')">
    </section>
    <section class="noBG">
    </section>
    <section>
        <div class="infoCol" >
            <ul class="leftCol">
                <li>WHAT IS IT?</li>
                <li>INSPIRE</li>
                <li>SPONSOR</li>
                <li>SHOP</li>
            </ul>
            <ul class="rightCol">
                <li></li>
                <li><h3>Watch the How It Works video</h3></li>
                <li></li>
            </ul>
        </div>
    </section>
</div>

<?php include "footer.php"; ?>
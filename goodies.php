<?php
    $pageTitle = "Goodies";
    include "head.php";
    include "header.php";
?>

<style>
    .goodiesCol{width: 900px; margin: 0px auto; text-align: center; color: #464646; position: relative; z-index: 1;}
    .goodiesCol .goodHead{ width: 100%; margin-top: 100px; font-size: 24px; margin-bottom: 55px;}
    .buttRow{width: auto; display: inline-block; margin: 0px auto;}
    .buttRow li{float: left;}
    .pic1{width: 100%;margin-top: 60px;}
    .picDescript{float: left; padding-bottom: 60px; margin-left: 20px;}
    .goodiesCol h1{font-size: 22px;-webkit-margin-after: 5px;}
    .goodiesCol h3{text-align: left;}
    .lbeezy{width: 100%; border-bottom: #464646 thin solid;}
    .toolCTA{color: #fff; padding: 10px 40px; margin-top: 36px; margin-left: 50px; text-align: center; background-color: #ed577e;float: left;}
    .goodieGrad{position: absolute;background-image: url("/images/goodieGrad.png");z-index: -1;height: 400px;width: 100%;top: -52px;background-repeat: no-repeat;}
</style>
<div class="goodiesCol">
    <div class="goodieGrad"></div>
    <div class="goodHead">Go next level with Apps, Widgets and More!</div>
    <ul class="buttRow">
        <a href="https://itunes.apple.com/us/app/dahlia-wolf-fashion/id718253685?ls=1&mt=8" target="_blank">
            <li style="margin-right: 20px;"><img src="/images/iosButt.png"></li>
        </a>
        <a href="https://play.google.com/store/apps/details?id=com.zyonnetworks.dahliawolf2&hl=en" target="_blank">
            <li><img src="/images/playButt.png"></li>
        </a>
        <div style="clear: left;"></div>
    </ul>
    <img class="pic1" src="/images/goodie_pic_1.png">
    <div class="picDescript">
        <h1>THE DAHLIA WOLF APP</h1>
        <h3>Get DAHLIA WOLF on your phone</h3>
    </div>
    <div style="clear: left;"></div>

    <div class="lbeezy"></div>

    <img class="pic1" src="/images/goodie_pic_2.png">

    <div class="picDescript">
        <h1>THE INSPIRE TOOL</h1>
        <h3>With the INSPIRE TOOL you can </br>effortlessly post images from any website</h3>
    </div>
    <a href="/pinit">
        <div class="toolCTA">GET IT NOW</div>
    </a>
    <div style="clear: left;"></div>
</div>

<?php include "footer.php" ?>
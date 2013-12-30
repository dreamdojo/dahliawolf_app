<?php
    $pageTitle = "Help - VIP";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>

<div class="transCol">
    <div class="goodieGrad"></div>
    <h1>VIP MEMBERSHIP</h1>
    <h3>VIP Membership allows you to earn more and gives you exclusive access to our lates designs<br> find out more about how to get the VIP badge and take advantage of exclusive offers today!</h3>
    <h2>How to become a VIP</h2>

    <ul class="steppingStone">
        <li>
            <p class="stepTitle">STEP 1</p>
            <p class="wyg">VERIFY YOUR ACCOUNT</p>
            <p class="learns">Simply click below <br> to verify you account</p>
            <a href="/help/verified.php"><div class="dahliaButton">VERIFY NOW</div></a>
        </li>
        <li>
            <p class="stepTitle">STEP 1</p>
            <p class="wyg">EARN 1,000,000 POINTS</p>
            <p class="learns">Learn more about all the <br> exciting ways to earn points</p>
            <a href="/faqs"><div  class="dahliaButton">LEARN MORE</div></a>
        </li>
    </ul>
    <div class="justTheFacts">
        <div class="vipEx"><img src="/public_html/images/vip_ex.png"></div>
        <ul class="listOfFacts">
            <li><h3>VIP BENIFITS</h3></li>
            <li>Need 100 loves (vs 1000 loves) to win. (limit 1 item per month)</li>
            <li>Get paid 10% commission on sales vs 5% for regular members.</li>
            <li>Get early access to exclusive designs.</li>
            <li><h3>BECOME A CELEBRITY VIP</h3></li>
            <li>Are you already a person of influence in the fashion world?</li>
            <li>VIP status can be granted and is determined on a case-by-case basis.</li>

        </ul>
    </div>
</div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
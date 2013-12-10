<?
$pageTitle = "Help";
include "head.php";
include "header.php";
//include "post_slideout.php";
?>
<style>
.row1{width: 100%;margin-top: 50px;}
.row1 ul{ width: 33.3%; float: left; text-align: center;}
.row1 ul li:last-child{margin: 10px 0px;}
.row2{width: 100%;margin-top: 50px;}
.row2 h1{width: 100%;font-size: 19px; margin-bottom: 15px;margin-top: 15px;}
.row2 ul{ width: 27%; float: left; text-align: center; background-color: #FAFAFA; border: #B8B8B8 thin solid; padding-bottom: 30px;}
.row2 ul p{font-size: 12px;width: 65%;margin: 0px auto;padding-bottom: 20px;}
.row2 ul li:last-child{background-color: #ff1176; padding: 10px 10px; font-size: 12px; color: #fff; width: 65%; margin: 0px auto;}
.transCol h3{width: 80%;margin: 0px auto;margin-top: 15px;font-size: 14px;margin-bottom: 10px;line-height: 25px;}
.transCol h1{margin-bottom: 35px;}
.row2 h1{margin-top: 30px; margin-bottom: 25px;}
</style>

<div class="transCol">
    <div class="goodieGrad"></div>
    <h1>CUSTOMER CARE</h1>
    <h3 style="color: #666;">If you are unable to find the info you need after visiting the FAQ section, please use one of the options<br>
        below to contact us. Your inquiry is important to us; we typically respond with 24 business hours. Thank you.
    </h3>
    <h1 style="margin-top: 45px;">
        DON'T QUITE UNDERSTAND<BR> HOW DAHLIA\WOLF WORKS?
    </h1>
    <a href="/faqs">
        <img src="/images/hiwClickme.png">
    </a>
    <div class="row1">
        <ul>
            <li>image</li>
            <li><h3>EMAIL US A QUESTION</h3></li>
            <li>Expect to hear back from us in 24 hours</li>
            <li><a href="mailto:cs@dahliawolf.com">EMAIL NOW</a></li>
        </ul>
        <ul>
            <li>image</li>
            <li><h3>CALL US TOLL FREE</h3></li>
            <li>1-800-9302 8am -6pm PT</li>
            <li>5 days a week</li>
        </ul>
        <ul>
            <li>image</li>
            <li><h3>CHAT LIVE WITH AN EXPERT</h3></li>
            <li>6am - 6pm PT Mon-Fri</li>
            <li>COMING SOON</li>
        </ul>
    </div>
    <div style="clear: left;"></div>
    <div class="row2">
        <ul style="margin-right: 9%;">
            <li><h1>POINTS</h1></li>
            <li><p>Points explaination and tips on how to earn points</p></li>
            <a href="/faqs"><li>LEARN ABOUT POINTS</li></a>
        </ul>
        <ul>
            <li><h1>SHIPPING & RETURNS</h1></li>
            <li><p>Payment options Shipping and delivery Returns</p></li>
            <a href="/faqs"><li>SHIPPING AND RETURNS</li></a>
        </ul>
        <ul style="margin-left: 9%;">
            <li><h1>FAQ</h1></li>
            <li><p>Points explaination and tips on how to earn points</p></li>
            <a href="/faqs"><li>READ FAQS</li></a>
        </ul>
    </div>
</div>
<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
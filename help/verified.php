<?php
    $pageTitle = "Help - Verfied";
    include $_SERVER['DOCUMENT_ROOT'] . "/head.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/header.php";
?>
<style>
    .transCol ul{font-size: 14px;margin-bottom: 50px;}
    .transCol ul li:first-child{font-size: 15px;}
    .transCol ul li:last-child{color: #777777;margin-top: 12px;}
    .transCol p{font-size: 14px;padding: 10px;}
</style>

<div class="transCol">
    <div class="goodieGrad"></div>
    <h1>VERIFIED ACCOUNTS</h1>

    <ul>
        <li>What is a verified account?</li>
        <li style="margin-top: 0px;">Verified accounts are accounts that have the verified badge <img src="/images/verified.png"></li>
    </ul>

    <ul>
        <li>Why does Dahlia\Wolf verify accounts?</li>
        <li>Verification is used to establish the authenticity of individual or brands that are at risk of impersonation</li>
    </ul>

    <ul>
        <li>How to verify your account.</li>
        <li>If you want verify your account and receive a verified badge on your profile, please complete the steps below...</li>
    </ul>
    <a href="/account/settings.php"><img src="/images/Verified-Explaination.png" style="margin-bottom: 10px;"></a>
    <p>1. Upload a profile pic and post at least one inspiration image to your account</p>
    <p>2. Connect your Dahlia Wolf account with your official Twitter, Facebook and/or Tumblr from your account settings page or by clicking <a href="/account/settings.php?social=true">here</a></p>
    <p>3. Email us at <a href="mailto:verify@dahliawolf.com">verify@dahliawolf.com</a> and included your Dahlia Wolf username along with links to the verification messages posted on each of your official accounts</p>
</div>

<?
    include $_SERVER['DOCUMENT_ROOT'] . "/footer.php";
?>
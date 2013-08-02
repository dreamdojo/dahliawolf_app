<?
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pageTitle = "Reset Password";
include "head.php";
include "header.php"; 
?>
<style>
    img.bg {
        /* Set rules to fill background */
        min-height: 100%;
        min-width: 1072px;

        /* Set up proportionate scaling */
        width: 100%;
        height: auto;

        /* Set up positioning */
        position: fixed;
        top: 0;
        left: 0;
    }

    @media screen and (max-width: 1072px) { /* Specific to this particular image */
        img.bg {
            left: 50%;
            margin-left: -536px;   /* 50% */
        }
    }
    #passwordResetBox{position: fixed;width: 700px;height: 200px;left: 50%;top: 50%;margin-left: -350px;margin-top: -100px; overflow: hidden; color: #fff; text-align: center;}
    .coolBG{background-color: #111; position: absolute;left: 0px; height: 100%; width: 100%; top: 0px; opacity: .7;}
    .dahliaForgetButton{ background-color: #000;padding: 5px 35px;font-size: 20px;border: none;}
    .peggedpelvispete{font-size: 14px;position: relative;color: #c2c2c2;width: 365px;margin: 10px auto;}
    .passBackButt{color: #fff; position: absolute; right: 5px; top: 10px; cursor: pointer; font-size: 18px; z-index: 12;}
    .user-message{position: relative;z-index: 111;}
</style>

<img src="/images/passwordBG.jpg" class="bg">

<div id="passwordResetBox">
    <div class="coolBG"></div>
    <div onclick="document.location = '/';" class="passBackButt">BACK</div>
    <p class="auth_text" style="font-size:23px">FORGOT YOUR PASSWORD?</p>
    <p class="peggedpelvispete" style="font-size:14px">Enter your email address below and we'll send you instructions on how to reset your password.</p>

    <div class="error_block login_error"></div>

    <form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/reset-password-link">
        <ul>
            <li>
                <input class="input_text" type="text" name="email" id="sysForm_identity" value="" />
                <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
            </li>
        </ul>
        <div class="non_inputs">
            <input type="submit" style="color: #fff;" value="Submit" class="dahliaForgetButton" id="sysForm_submit" />
        </div>
    </form>
</div>


<?php include "footer.php" ?>

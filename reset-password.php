<?
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pageTitle = "Reset Password";
include "head.php";
include "header.php"; 
?>

<p class="auth_text" style="font-size:24px">Enter your e-mail address to reset your password.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/reset-password">
    <ul>
        <li>
        	<input class="input_text" type="text" name="email" id="sysForm_identity" value="<?= !empty($_GET['email']) ? base64_decode($_GET['email']) : '' ?>" />
            <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
        </li> 
        <li>
        	<input class="input_text" type="password" name="password" id="sysForm_password" value="" />
            <label for="sysForm_password">Password</label><span class="fff"></span>
        </li> 
        <li>
        	<input class="input_text" type="password" name="password_confirm" id="sysForm_password_confirm" value="" />
            <label for="sysForm_password_confirm">Confirm Password</label><span class="fff"></span>
        </li> 
    </ul>
    <div class="non_inputs">
    	<input type="hidden" name="key" value="<?= !empty($_GET['key']) ? $_GET['key'] : '' ?>" />
    	<input type="submit" value="Submit" class="Button_input" id="sysForm_submit" />
    </div>
</form>

<?php include "footer.php" ?>

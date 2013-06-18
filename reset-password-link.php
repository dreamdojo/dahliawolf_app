<?
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pageTitle = "Reset Password";
include "head.php";
include "header.php"; 
?>

<p class="auth_text" style="font-size:24px">Enter your e-mail address to reset your password.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/reset-password-link">
    <ul>
        <li>
        	<input class="input_text" type="text" name="email" id="sysForm_identity" value="" />
            <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
        </li> 
    </ul>
    <div class="non_inputs">
    	<input type="submit" value="Submit" class="Button_input" id="sysForm_submit" />
    </div>
</form>

<?php include "footer.php" ?>

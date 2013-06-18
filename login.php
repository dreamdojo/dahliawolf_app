<?
$pageTitle = "Login";
include "head.php";
include "header.php"; 
?>

<p class="auth_text" style="font-size:24px">Login using your e-mail address.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/login.php">
    <ul>
        <li>
        	<input class="input_text" type="text" name="identity" id="sysForm_identity" value="" />
            <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
        </li>
        <li>
        	<input class="input_text" type="password" name="credential" id="sysForm_credential" value="" />
        	<label for="sysForm_credential">Password</label>
        	<span class="fff"></span>
        </li>  
        <li>
        	<input class="checkbox" id="l_remember_me" name="l_remember_me" type="checkbox" value="1" />
        	<span style="font-size:16px; color:#666"> Remember me</span>
        </li>   
    </ul>
    <div class="non_inputs">
    	<input type="submit" value="Log in" class="Button_input" id="sysForm_submit" />
                <a href="javascript:loginscreen('signup')" id="urlGetInvite" class="colorless">Sign up now!</a>
            	<a href="/reset-password-link" id="resetPassword" class="colorless">Forgot your password?</a>
    </div>
     <input type="hidden" name="r" value="" />
     <input type="hidden" name="sublog" value="1" />
</form>

<?php include "footer.php" ?>

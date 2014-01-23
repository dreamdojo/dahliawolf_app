<?
$pageTitle = "Login";
if( !isset($_GET['ajax']) ) {
    include "head.php";
    include "header.php";
}
?>
<style>
    .auth_text{margin-top: 100px;}
    #sysForm{margin-top: 35px;}
</style>

<div style="width: 500px; text-align: center; margin: 0px auto;">
    <p class="auth_text" style="font-size:24px">Login using your e-mail address.</p>

    <div class="error_block login_error"></div>
    <a href="/social-login.php?social_network=facebook"><img style="padding: 10px;" src="/skin/img/signinfacebook2.png" width="244" height="49"></a>

    <form id="loginForm" method="POST" class="Form FancyForm AuthForm" action="/action/login.php">
        <input type="hidden" name="ajax" value="true">
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
            <input type="submit" value="Log in" class="Button_input" id="sysForm_submit" style="float: left;" />
            <a href="/signup" rel="pop" class="colorless">Sign up now!</a>
            <a href="/reset-password-link" id="resetPassword" class="colorless">Forgot your password?</a>
        </div>
         <input type="hidden" name="r" value="" />
         <input type="hidden" name="sublog" value="1" />
    </form>
</div>
<?php// include "footer.php" ?>
<script>
    $(function() {
        $('#loginForm').on('submit', {$errorBox : $('#errorBox')}, dahliawolf.login);
    });
</script>
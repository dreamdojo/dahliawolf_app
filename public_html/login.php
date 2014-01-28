<?
$pageTitle = "Login";
if( !isset($_GET['ajax']) ) {
    include "head.php";
    include "header.php";
}
?>
<style>
    .auth_text{margin-top: 100px;}
    .loginCol{width: 300px;margin: 0px auto;text-align: center;padding-top: 30px;}
    .loginCol h3{font-size: 13px;margin-top: -13px;}
    .loginCol #theLoginForm{width: 300px; margin-top: 40px;}
    .loginCol #theLoginForm input{box-shadow: none;-moz-box-shadow: none;-webkit-box-shadow: none;}
    .facebookConnect{width: 300px; height: 40px;background-color: #52688f; text-align: center; line-height: 40px; color: #fff; font-size: 13px; margin-top: 40px;}
    .facebookConnect li{float: left;}
    .facebookConnect li:first-child{width: 40px; border-right: #fff thin solid; font-size: 18px;}
    .facebookConnect li:last-child{width: 248px;}

    .loginCol .teal{width: 300px; height: 40px; line-height: 40px; text-align: center; color: #fff; margin-bottom: 15px; background-color: #74bf00;border: 0px;border: 0px;font-size: 15px;text-indent: 0px; margin-top: 30px; letter-spacing: 4px; cursor: pointer;}
    .loginCol .non_inputs{width: 300px;}
    .loginCol .non_inputs p{text-align: left; color: #c2c2c2;margin-top: 5px;margin-top: 13px;}
    .loginCol .non_inputs p a{color: #c2c2c2;}
    .loginCol #resetPassword{line-height: 24px; position: static;}
    .loginCol #loginErrors{font-size: 13px;color: red;line-height: 25px;}

    .loginCol #theLoginForm .checkbox{float: left; margin-top: 0px;width: 20px; height: 21px;}
</style>


<div class="loginCol" <?= isset($_GET['ajax']) ? 'style="margin-top: 100px;"' : '' ?>>
    <h1>LOGIN</h1>
    <h3>Login using your email or username</h3>

    <a href="/social-login.php?social_network=facebook">
        <ul class="facebookConnect">
            <li>f</li>
            <li>CONNECT USING FACEBOOK</li>
        </ul>
    </a>

    <form id="theLoginForm" method="POST" class="Form FancyForm AuthForm" action="/action/login.php">
        <input type="hidden" name="ajax" value="true">
        <div id="loginErrors"></div>
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
                <span style="font-size:16px; color:#666; float: left;"> Remember me</span>
                <a href="/reset-password-link" id="resetPassword" class="colorless">Forgot your password?</a>
            </li>
        </ul>
        <div class="non_inputs">
            <input type="submit" value="LOGIN" class="teal" id="sysForm_submit">
            <a href="/signup" rel="pop" class="colorless">Or sign up now!</a>
        </div>
         <input type="hidden" name="r" value="" />
         <input type="hidden" name="sublog" value="1" />
    </form>
</div>
<?php// include "footer.php" ?>
<script>
    $(function() {
        console.log('runnning');
        $('#theLoginForm').on('submit', {$errorBox : $('#loginErrors')}, dahliawolf.login);
    });
</script>

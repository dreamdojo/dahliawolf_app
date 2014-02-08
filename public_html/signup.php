<?

$pageTitle = "Sign Up";
if( !isset($_GET['ajax']) ) {
    include "head.php";
    include "header.php";
}
?>
<style>
    .auth_text{margin-top: 100px;}
    .loginCol{width: 300px;margin: 0px auto;text-align: center;padding-top: 30px;}
    .loginCol h3{font-size: 13px;margin-top: -13px;}
    .loginCol #sysForm{width: 300px; margin-top: 40px;}
    .loginCol #sysForm input{box-shadow: none;-moz-box-shadow: none;-webkit-box-shadow: none;}
    .facebookConnect{width: 300px; height: 40px;background-color: #52688f; text-align: center; line-height: 40px; color: #fff; font-size: 13px; margin-top: 40px;}
    .facebookConnect li{float: left;}
    .facebookConnect li:first-child{width: 40px; border-right: #fff thin solid; font-size: 18px;}
    .facebookConnect li:last-child{width: 248px;}

    .loginCol .teal{width: 300px; height: 40px; line-height: 40px; text-align: center; color: #fff; background-color: #74bf00;border: 0px;border: 0px;font-size: 15px;text-indent: 0px; margin-top: 30px; letter-spacing: 4px; cursor: pointer;}
    .loginCol .non_inputs p{text-align: left; color: #c2c2c2;margin-top: 5px;margin-top: 13px;}
    .loginCol .non_inputs p a{color: #c2c2c2;}
</style>

<div class="loginCol" <?= isset($_GET['ajax']) ? 'style="margin-top: 100px;"' : '' ?>>
    <h1>SIGN UP</h1>
    <h3>Create an account or sign in to continue</h3>

    <a href="/social-login.php?social_network=facebook">
        <ul class="facebookConnect">
            <li>f</li>
            <li>CONNECT USING FACEBOOK</li>
        </ul>
    </a>

    <div class="error_block login_error"></div>

    <form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/signup.php">
        <ul>
            <li>
                <input class="input_text" type="text" name="user_username" id="sysForm_user_username" value="" max="30" />
                <label for="sysForm_user_username">USERNAME</label><span class="fff"></span>
            </li>
            <?
            /*
            <li>
                <input class="input_text" type="text" name="user_fname" id="sysForm_user_fname" value="" max="30" />
                <label for="sysForm_user_fname">First Name</label><span class="fff"></span>
            </li>
            <li>
                <input class="input_text" type="text" name="user_lname" id="sysForm_user_lname" value="" max="50" />
                <label for="sysForm_user_lname">Last Name</label><span class="fff"></span>
            </li>
            */
            ?>
            <li>
                <input class="input_text" type="text" name="user_email" id="sysForm_user_email" value="" />
                <label for="sysForm_user_email">EMAIL</label><span class="fff"></span>
            </li>
            <li>
                <input class="input_text" type="password" name="user_password" id="sysForm_user_password" value="" />
                <label for="sysForm_user_password">PASSWORD</label>
                <span class="fff"></span>
            </li>
        <?
        /*
        <li>
        	<input class="input_text" type="password" name="user_password2" id="sysForm_user_password2" value="" />
        	<label for="sysForm_user_password2">Confirm Password</label>
        	<span class="fff"></span>
        </li> 
		*/
		?>

        </ul>
        <div class="non_inputs">
            <input type="submit" value="REGISTER" class="teal" id="sysForm_submit" />
            <p>By creating an account, I accept Dahlia Wolf's <a href="/tos">Terms of Service</a> and <a href="/tos">Privacy Policy</a></p>
        </div>
         <input type="hidden" name="r" value="" />
         <input type="hidden" name="jsub" value="1" />
    </form>
</div>

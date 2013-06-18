<?
$pageTitle = "Login";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php";
?>


<p class="auth_text" style="font-size:37px; margin-top: 100px; margin-bottom: 50px; margin-left: 20px;">Signup using your e-mail address.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/signup.php">
    <ul>
        <li>
        	<label for="sysForm_user_username" style="font-size: 40px;">Username</label><span class="fff"></span>
        	<input class="input_text" type="text" name="user_username" id="sysForm_user_username" value="" max="30" style="width: 550px; height: 60px;"/>
        </li>
        <?
        /*
        <li>
        	<label for="sysForm_user_fname" style="font-size: 40px;">First Name</label><span class="fff"></span>
        	<input class="input_text" type="text" name="user_fname" id="sysForm_user_fname" value="" max="30" style="width: 550px; height: 60px;" />
        </li>
        <li>
        	<label for="sysForm_user_lname" style="font-size: 40px;">Last Name</label><span class="fff"></span>
        	<input class="input_text" type="text" name="user_lname" id="sysForm_user_lname" value="" max="50" style="width: 550px; height: 60px;" />
        </li>
		*/
		?>
        <li>
        	<label for="sysForm_user_email" style="font-size: 40px;">E-Mail</label><span class="fff"></span>
        	<input class="input_text" type="text" name="user_email" id="sysForm_user_email" value="" style="width: 550px; height: 60px;" />
        </li>
        <li>
        	<label for="sysForm_user_password" style="font-size: 40px;">Password</label>
        	<input class="input_text" type="password" name="user_password" id="sysForm_user_password" value="" style="width: 550px; height: 60px;" />
        	<span class="fff"></span>
        </li>
        <?
        /* 
        <li>
        	<label for="sysForm_user_password2" style="font-size: 40px;">Confirm Password</label>
        	<input class="input_text" type="password" name="user_password2" id="sysForm_user_password2" value="" style="width: 550px; height: 60px;" />
        	<span class="fff"></span>
        </li> 
        */
        ?><!--<li>
            <input class="input_text" type="text" name="user_captcha_solution" id="sysForm_user_captcha_solution" value="" />
        	<label for="sysForm_user_captcha_solution">Image Code</label>
        	<span class="fff"></span>
        </li>  
        <li>
            <img src="/include/captcha.php" style="border: 0px; margin:0px; padding:0px" />
        </li> -->
    </ul>
    <div class="non_inputs">
    	<input type="submit" value="Submit" class="Button_input" id="sysForm_submit" style="font-size: 40px;" />
    </div>
     <input type="hidden" name="r" value="" />
     <input type="hidden" name="jsub" value="1" />
     
     <?
	if (!empty($_GET['session_type'])) {
		?>
		<input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
		<?
	}
	?>
</form>

<div style="margin-bottom: 100px">&nbsp;</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>
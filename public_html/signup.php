<?
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pageTitle = "Login";
if( !isset($_GET['ajax']) ) {
    include "head.php";
    include "header.php";
}
?>
<style>
    .auth_text{margin-top: 100px;}
</style>

<p class="auth_text" style="font-size:24px">Signup using your e-mail address.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="/action/signup.php">
    <ul>
        <li>
        	<input class="input_text" type="text" name="user_username" id="sysForm_user_username" value="" max="30" />
            <label for="sysForm_user_username">Username</label><span class="fff"></span>
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
            <label for="sysForm_user_email">E-Mail</label><span class="fff"></span>
        </li>
        <li>
        	<input class="input_text" type="password" name="user_password" id="sysForm_user_password" value="" />
        	<label for="sysForm_user_password">Password</label>
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
    	<input type="submit" value="Submit" class="Button_input" id="sysForm_submit" />
    </div>
     <input type="hidden" name="r" value="" />
     <input type="hidden" name="jsub" value="1" />
</form>

<?
$pageTitle = "Login";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
?>

<p class="auth_text" style="font-size:24px">Enter your e-mail address to reset your password.</p>

<div class="error_block login_error"></div>

<form id="sysForm" method="POST" class="Form FancyForm AuthForm" action="">
    <ul>
        <li>
        	<input class="input_text" type="text" name="identity" id="sysForm_identity" value="" />
            <label for="sysForm_identity">E-Mail</label><span class="fff"></span>
        </li> 
    </ul>
    <div class="non_inputs">
    	<input type="submit" value="Submit" class="Button_input" id="sysForm_submit" />
    </div>
    <?
	if (!empty($_GET['session_type'])) {
		?>
		<input type="hidden" name="session_type" value="<?= $_GET['session_type'] ?>" />
		<?
	}
	?>
	
</form>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php" ?>
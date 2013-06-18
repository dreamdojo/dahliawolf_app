<?
$pageTitle = "Contact";
include "head.php";
include "header.php"; 
?>

<div class="AboutContent">
	<div class="title-section">
	<div class="section-title">FEEDBACK</div>
</div>

<div style="padding-top:20px; margin-left:-80px">
	<?
	if (isset($_GET['sent'])) {
		?>
		<img src="skin/img/feedback-dahlia-thanks.jpg">
		<?
	}
	else {
		?>
		<img src="skin/img/feedback-dahlia.jpg">
	 	<div>
	 		<div style="margin-top:100px" class="AboutRight">
			<form id="inviteforms" method="post" action="/action/feedback.php">
	        <div id="EmailAddresses" class="Form FancyForm floatLeft" style="width: 62%; margin-left:-42px;">
	            <ul style="margin-top:-140px; margin-left:210px; width: 825px;">
	                <li style="display:none">
	                    <input type="text" class="email" tabindex="1" name="email1" value="solomon@offlinela.com"/>
	                    <label>dahlia@dahliawolf.com</label>
	                    <span class="fff"></span>
	                    <span class="helper"></span>
	                </li>
	                <li>
	                    <textarea name="message" style="min-height: 6.85em; background-color:#FFFFFF" tabindex="5"></textarea>
	                    <label>What are your thoughts?</label>
	                    <span class="efefef"></span>
	                    <span class="helper"></span>
	                </li>
	            </ul>
	        </div>
	        
	        <div class="clear message"></div>
	        
	        <div style="margin-top:-210px; margin-left:875px;" class="clear">
	            <a href="#" id="SendInvites" class="Button OrangeButton Button18" tabindex="6" onclick="$(this).closest('form').submit()"><strong>SEND</strong><span></span></a>
	        </div>
	        <input type="hidden" name="fpsub" value="1" />
			</form>
	
	        <div class="clear message"></div>
	
		</div>
		<?
	}
	?>
</div>
       
<script>

<?php include "footer.php" ?>

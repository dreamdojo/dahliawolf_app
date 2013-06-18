<?
if($_GET['session_type'] == "web") {
	$pageTitle = "Invite Your Friends - Dahlia\Wolf";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/header.php"; 
} else {
	include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/head.php";
}
?>

<div class="activity-bar">FEED</div>
		
    <div class="FixedContainer" style="padding-bottom: 50px;">            
        <form id="inviteforms" method="post" action="/action/invite.php">
        <div id="EmailAddresses" class="Form FancyForm floatLeft">
            <ul>
                <li>
                    <input type="text" class="email" tabindex="1" name="emails[]" placeholder="Email Address 1" />
  
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="2" name="emails[]" placeholder="Email Address 2" />
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="3" name="emails[]" placeholder="Email Address 3" />
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <input type="text" class="email" tabindex="4" name="emails[]" placeholder="Email Address 4" />
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
                <li>
                    <textarea name="message" style="min-height: 6.85em;" tabindex="5" placeholder="Add a personal note (optional):"></textarea>
                    <span class="fff"></span>
                    <span class="helper"></span>
                </li>
            </ul>
        </div>
        
        <div class="clear message"></div>
       
        <div class="clear">
            <a id="SendInvites" tabindex="6" onclick="$(this).closest('form').submit()"><strong class="cp-butt" style="font-size: 12px;">Send Invites</strong><span></span></a>
        </div>
        <input type="hidden" name="fpsub" value="1" />
		</form>
        
        </div>


<? 
include $_SERVER['DOCUMENT_ROOT'] . "/mobile/common/footer.php"; 
?>